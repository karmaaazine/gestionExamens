<?php
namespace App\Controllers;

use App\Models\ClassesModel;

class gestionClassesController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * Display the list of classes.
     */
    public function index()
    {
        $classesModel = new ClassesModel();

        // Fetch all classes with only the 'id' and 'name' fields
        $classes = $classesModel->select('id, name')->findAll();

        // Pass the classes data to the view
        return view('Admin/ClassView', ['classes' => $classes]);
    }

    /**
     * Handle the edit functionality for a class.
     * This method handles both displaying the edit form and processing the form submission.
     */
    public function edit($id)
{
    $classesModel = new ClassesModel();

    // Fetch all classes for the table
    $allClasses = $classesModel->select('id, name')->findAll();

    // Fetch the class being edited
    $classToEdit = $classesModel->find($id);

    if (!$classToEdit) {
        return redirect()->to('/admin/classes_view')->with('error', 'Classe introuvable.');
    }

    // Handle POST request
    if ($this->request->getMethod() === 'post') {
        $newName = $this->request->getPost('name');

        if (empty($newName)) {
            return redirect()->back()->with('error', 'Le nom de la classe est requis.');
        }

        $classesModel->update($id, ['name' => $newName]);
        return redirect()->to('/admin/classes_view')->with('success', 'Classe mise à jour avec succès.');
    }

    // Pass BOTH variables to the view
    return view('Admin/ClassView', [
        'classes' => $allClasses,        // For the table
        'classToEdit' => $classToEdit    // For the edit form
    ]);
}

public function add()
{
    log_message('info', 'Add Class: Request method is ' . $this->request->getMethod()); // Debug log

    if ($this->request->getMethod() === 'post') {
        $className = $this->request->getPost('name');

        // Validate the input
        if (empty($className)) {
            log_message('error', 'Add Class: Empty name provided.'); // Debug log
            return $this->response->setJSON(['success' => false, 'message' => 'Le nom de la classe est requis.']);
        }

        $classesModel = new ClassesModel();

        // Insert the new class
        $insertResult = $classesModel->insert(['name' => $className]);

        if (!$insertResult) {
            log_message('error', 'Add Class: Failed to insert into database.'); // Debug log
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'ajout de la classe.']);
        }

        log_message('info', 'Add Class: Class added successfully.'); // Debug log
        return $this->response->setJSON(['success' => true, 'message' => 'Classe ajoutée avec succès.']);
    }

    log_message('error', 'Add Class: Invalid request method.'); // Debug log
    return $this->response->setJSON(['success' => false, 'message' => 'Méthode non autorisée.']);
}

    /**
     * Handle the deletion of a class.
     */
    public function delete($id)
    {
        $classesModel = new ClassesModel();

        // Fetch the class to be deleted
        $class = $classesModel->find($id);

        // If the class doesn't exist, redirect with an error message
        if (!$class) {
            return redirect()->to('/admin/classes_view')->with('error', 'Classe introuvable.');
        }

        // Delete the class
        $classesModel->delete($id);

        // Redirect with a success message
        return redirect()->to('/admin/classes_view')->with('success', 'Classe supprimée avec succès.');
    }
}