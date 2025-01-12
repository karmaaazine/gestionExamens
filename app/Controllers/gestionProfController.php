<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\CompteModel;
use CodeIgniter\Controller;

class gestionProfController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
{
    $logger = \Config\Services::logger();
    $logger->debug('Delete method called for ID: ');
    // if ($this->session->get('admin_logged_in')) {
        $roleModel = new RoleModel();
        $compteModel = new CompteModel();
        $userModel = new UserModel();

       
        $role_prof = $roleModel->where('role_name', 'professeur')->first();

        if (!$role_prof) {
            return redirect()->to('/admin/gestion_prof')->with('error', 'Role "professeur" not found.');
        }

        $teachers = null;

        $roleId = $role_prof['id'];
        // Step 2: Get all user_ids from compte table with role_id equal to professeur's ID
        $compteEntries = $compteModel->where('role_id', $roleId)->findAll();

        if($compteEntries){
            $userIds = array_column($compteEntries, 'user_id');
            $teachers = $userModel->whereIn('id', $userIds)->findAll();
        }

        // Pass data to the view
        return view('Admin/teacherview', ['teachers' => $teachers]);
    // }

    return view('Admin/login');
}

    public function add()
    {
        log_message('debug', 'Delete method called for ID: ' . $id);
        $validation = \Config\Services::validation();
        
        // Validate the form input
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'city' => 'required|min_length[3]|max_length[100]',
            'tel' => 'required|numeric|min_length[10]|max_length[15]',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get the input data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $city = $this->request->getPost('city');
        $tel = $this->request->getPost('tel');
        $password = $this->request->getPost('password');

        // Initialize models
        $profModel = new UserModel();
        $compteModel = new CompteModel();
        $roleModel = new RoleModel();

        // Find the "professeur" role
        $role_prof = $roleModel->where('role_name', 'professeur')->first();
        if (!$role_prof) {
            return redirect()->to('/admin/teachers/add')->with('error', 'Role "professeur" not found.');
        }

        // Save the professor data
        $profModel->save([
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'tel' => $tel,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password
        ]);

        // Get the newly created professor's ID
        $newProfId = $profModel->insertID();

        // Save the professor's role to the "compte" table
        $compteModel->save([
            'user_id' => $newProfId,
            'role_id' => $role_prof['id'],
        ]);

        // Redirect back to the professor list with a success message
        return redirect()->to('/admin/gestion_prof')->with('success', 'Professor added successfully!');
    }


    public function edit($prof)
    {
        $profModel = new UserModel();

        // Validate the input data (optional)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'city' => 'required',
            'tel' => 'required|numeric',
            'password' => 'required'
            
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Get user input
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'city' => $this->request->getPost('city'),
            'tel' => $this->request->getPost('tel'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        // Update the database
        if ($profModel->update($prof, $data)) {
            return redirect()->to('/admin/gestion_prof')->with('message', 'professor updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update professor.');
        }
    }

    public function delete($id)
    {
        $logger = \Config\Services::logger();
        $logger->debug('Delete method called for ID: ' . $id);

        $profModel = new UserModel();
        $compteModel = new CompteModel();

        // Fetch and validate professor
        $professor = $profModel->find($id);
        if (!$professor) {
            return redirect()->to('/admin/prof_view')->with('error', 'Professor not found.');
        }

        // Delete associated compte
        $compte = $compteModel->where('user_id', $id)->first();
        if ($compte) {
            $compteModel->delete($compte['id']);
        }

        // Delete professor record
        if ($profModel->delete($id)) {
            return redirect()->to('/admin/prof_view')->with('message', 'Professor deleted successfully.');
        }

        return redirect()->to('/admin/prof_view')->with('error', 'Failed to delete professor.');
    }



}

