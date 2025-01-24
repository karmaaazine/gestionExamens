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
        $profModel = new UserModel();
        $compteModel = new CompteModel();
        $roleModel = new RoleModel();

        $roleProfId = $roleModel->where('role_name','professeur')->first();
    
        // Check if the request is a POST (form submission)
        if ($this->request->getMethod() === 'POST') {
            // Validate the input data
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
                'email' => "required|valid_email|is_unique[users.email]",
                'city' => 'required',
                'tel' => 'required|numeric',
                // Password is optional; only validate if provided
                'password' => 'required|min_length[6]'
            ]);
    
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
    
            // Get user input
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'city' => $this->request->getPost('city'),
                'tel' => $this->request->getPost('tel'),
            ];

            // Update password only if provided
            if ($password = $this->request->getPost('password')) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
    
            // Update the database
            if ($profModel->save($data)) {
                // print_r( $profModel->id);
                // print_r($roleProfId);
                $professorId = $profModel->insertID();
                 
    
                // Prepare compte data
                $compteData = [
                    'user_id' => $professorId,
                    'role_id' => $roleProfId['id']
                ];
                
                // Save compte
                if (!$compteModel->save($compteData)) {
                    throw new \Exception('Failed to save compte: ' . json_encode($compteModel->errors()));
                } 

               
                return redirect()->to('/admin/prof_view')->with('message', 'Professor added successfully!');
            } else {
                dd($profModel->errors());
                return redirect()->back()->with('error', 'Failed to update professor.');
            }
        }
    
        // Load the edit view with the teacher's data
        return view('Admin/teacherAdd');
    }


    public function edit($id)
    {
        $profModel = new UserModel();
    
        // Fetch the teacher's existing data
        $teacher = $profModel->find($id);
    
        // Check if the teacher exists
        if (!$teacher) {
            return redirect()->to('/admin/prof_view')->with('error', 'Teacher not found.');
        }
        // Check if the request is a POST (form submission)
        if ($this->request->getMethod() === 'POST') {
            // Validate the input data
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]',
                'email' => "required|valid_email|is_unique[users.email,id,$id]",
                'city' => 'required',
                'tel' => 'required|numeric',
                // Password is optional; only validate if provided
                'password' => 'permit_empty|min_length[6]'
            ]);
    
            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }
    
            // Get user input
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'city' => $this->request->getPost('city'),
                'tel' => $this->request->getPost('tel')
            ];

    
            // Update password only if provided
            if ($password = $this->request->getPost('password')) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
    
            // Update the database
            if ($profModel->update($id, $data)) {
                return redirect()->to('/admin/prof_view')->with('message', 'Professor updated successfully!');
            } else {
                dd($profModel->errors());
                return redirect()->back()->with('error', 'Failed to update professor.');
            }
        }
    
        // Load the edit view with the teacher's data
        return view('Admin/teacherEdit', ['teacher' => $teacher]);
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

