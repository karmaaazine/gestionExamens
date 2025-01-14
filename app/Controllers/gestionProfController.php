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
                'email' => 'required|valid_email',
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
                'email' => 'required|valid_email',
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

