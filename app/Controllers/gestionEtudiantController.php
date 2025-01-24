<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\CompteModel;
use App\Models\StudentClassModel;
use App\Models\ClassesModel;
use App\Models\UniversityYearModel;
use CodeIgniter\Controller;

class gestionEtudiantController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
{
    // Initialiser les modèles
    $roleModel = new RoleModel();
    $compteModel = new CompteModel();
    $userModel = new UserModel();
    $yearModel = new UniversityYearModel();
    $classesModel = new ClassesModel();
    $etud_classModel = new StudentClassModel();

    // Étape 1 : Récupérer toutes les relations étudiant-classe-année
    $etud_class = $etud_classModel->findAll();

    
    // print_r( $etud_class ); 


    // Étape 2 : Récupérer les IDs uniques pour chaque entité
    $studentsIds = array_column($etud_class, 'student_id');
    $classesIds = array_column($etud_class, 'class_id');
    $yearsIds = array_column($etud_class, 'year_id');

    // Étape 3 : Récupérer les données des étudiants, classes et années
    $students = !empty($studentsIds) ? $userModel->whereIn('id', $studentsIds)->findAll() : [];
    $classes = !empty($classesIds) ? $classesModel->whereIn('id', $classesIds)->findAll() : [];
    $years = !empty($yearsIds) ? $yearModel->whereIn('id', $yearsIds)->findAll() : [];

    // Étape 4 : Indexer les classes et années par leurs IDs pour un accès rapide
    $classesById = [];
    foreach ($classes as $class) {
        $classesById[$class['id']] = $class;
    }

    $yearsById = [];
    foreach ($years as $year) {
        $yearsById[$year['id']] = $year;
    }

    // Étape 5 : Construire le tableau final des étudiants
    $finalStudents = [];
    foreach ($etud_class as $relation) {
        $studentId = $relation['student_id'];
        $classId = $relation['class_id'];
        $yearId = $relation['year_id'];

        // Trouver les infos de l'étudiant
        $student = array_filter($students, fn($s) => $s['id'] == $studentId);
        $student = reset($student); // Prendre le premier résultat

        if ($student) {
            // Ajouter les infos de classe et d'année à l'étudiant
            $student['class'] = $classesById[$classId] ?? null;
            $student['year'] = $yearsById[$yearId] ?? null;

            $finalStudents[] = $student; // Ajouter au tableau final
        }
    }

    // Étape 6 : Envoyer les données à la vue
    return view('Admin/StudentView', ['students' => $finalStudents]);
}


    public function add()
    {
        // Charger les modèles nécessaires
        $userModel = new UserModel();
        $roleModel = new RoleModel();
        $studentClassModel = new StudentClassModel();
        $classesModel = new ClassesModel();

        // Récupérer le rôle étudiant
        $roleStudent = $roleModel->where('role_name', 'etudiant')->first();
        if (!$roleStudent) {
            return redirect()->to('/admin')->with('error', 'Role "étudiant" non trouvé.');
        }

        if ($this->request->getMethod() === 'post') {
            // Valider les données envoyées
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'city' => 'required',
                'tel' => 'required|numeric',
                'grade' => 'required|numeric', // Le grade doit être une ID de classe, pas du texte
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Préparer les données de l'étudiant
            $studentData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash('defaultpassword', PASSWORD_BCRYPT), // Mot de passe par défaut
                'city' => $this->request->getPost('city'),
                'tel' => $this->request->getPost('tel'),
            ];

            // Sauvegarder l'étudiant
            if ($userModel->save($studentData)) {
                $studentId = $userModel->getInsertID();

                // Associer l'étudiant à la classe
                $studentClassData = [
                    'user_id' => $studentId,
                    'role_id' => $roleStudent['id'],
                    'class_id' => $this->request->getPost('grade'), // ID de la classe
                    'year_id' => 1, // Année par défaut, ajustez selon votre logique
                ];

                if ($studentClassModel->save($studentClassData)) {
                    return redirect()->to('/admin/student_view')->with('message', 'Étudiant ajouté avec succès !');
                }
            }

            return redirect()->back()->with('error', 'Échec de l\'ajout de l\'étudiant.');
        }

        // Charger la liste des classes disponibles pour le formulaire
        $classes = $classesModel->findAll();

        return view('Admin/AddStudentView', ['classes' => $classes]);
    }


    // Edit Student Method
    public function edit($id)
    {
        $userModel = new UserModel();
        $studentClassModel = new StudentClassModel();
        $classesModel = new ClassesModel();

        // Récupérer les données de l'étudiant
        $student = $userModel->find($id);
        if (!$student) {
            return redirect()->to('/admin/student_view')->with('error', 'Étudiant non trouvé.');
        }

        if ($this->request->getMethod() === 'post') {
            // Valider les données envoyées
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
                'city' => 'required',
                'tel' => 'required|numeric',
                'grade' => 'required|numeric', // Le grade doit être une ID de classe
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Préparer les données mises à jour de l'étudiant
            $studentData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'city' => $this->request->getPost('city'),
                'tel' => $this->request->getPost('tel'),
            ];

            // Mettre à jour les données de l'étudiant
            if ($userModel->update($id, $studentData)) {
                // Mettre à jour les données de la classe
                $studentClassData = [
                    'class_id' => $this->request->getPost('grade'),
                    'year_id' => 1, // Année par défaut
                ];

                $studentClassModel->where('user_id', $id)->set($studentClassData)->update();

                return redirect()->to('/admin/student_view')->with('message', 'Étudiant mis à jour avec succès !');
            }

            return redirect()->back()->with('error', 'Échec de la mise à jour de l\'étudiant.');
        }

        // Charger la liste des classes disponibles pour le formulaire
        $classes = $classesModel->findAll();

        return view('Admin/EditStudentView', ['student' => $student, 'classes' => $classes]);
    }

    

    public function delete($id)
    {
        // Charger les modèles nécessaires
        $studentClassModel = new StudentClassModel();
        $userModel = new UserModel();

        // Vérifier si l'étudiant existe
        $student = $userModel->find($id);
        if (!$student) {
            return redirect()->to('/admin/student_view')->with('error', 'Étudiant introuvable.');
        }

        // Supprimer les relations de l'étudiant dans la table class_student

        // Supprimer l'étudiant dans la table principale (users)
        if ($studentClassModel->where('student_id', $id)->delete()) {
            return redirect()->to('/admin/student_view')->with('message', 'Étudiant supprimé avec succès.');
        }

        return redirect()->to('/admin/student_view')->with('error', 'Échec de la suppression de l\'étudiant.');
    }

}

