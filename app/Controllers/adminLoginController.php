<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\CompteModel;
use CodeIgniter\Controller;

class AdminLoginController extends Controller
{
    protected $session;

    public function __construct()
    {
        // Load the session service
        $this->session = \Config\Services::session();
    }

    // Load the login page
    public function index()
    {
        if ($this->session->get('admin_logged_in')) { // Correct way to retrieve session data in CI4
            return redirect()->to('admin/dashboard');
        }
        return view('Admin/login');
    }

    // Handle login form submission
    public function login()
    {
        $validation = \Config\Services::validation();

        // Validate input fields
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed
            return view('admin/login', ['errors' => $validation->getErrors()]);
        }

        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Verify credentials using a UserModel
        $userModel = new UserModel();
        $compteModel = new CompteModel();
        $roleModel = new RoleModel();
        $user = $userModel->where('email', $email)->first();
        $compte = $compteModel->where('id', $user['id'])->first();
        $role_admin = $roleModel->where('id', $compte['role_id'])->first();
        

        if ($user && password_verify($password, $user['password'])) {
            // Check if the user is an admin
            if ($role_admin['role_name'] === 'admin') {
                // Set session data
                $this->session->set([
                    'admin_logged_in' => true,
                    'user_id'         => $user['id'],
                    'name'        => $user['name'],
                    'role_name'       => $role_admin['role_name'],
                ]);
                return redirect()->to('/admin/Dashbord');
            } else {
                // Unauthorized user
                $this->session->setFlashdata('error', 'Only administrators can log in.');
                return redirect()->to('/admin');
            }
        } else {
            // Invalid credentials
            $this->session->setFlashdata('error', 'Invalid email or password.');
            return redirect()->to('/');
        }
    }

    // Logout
    public function logout()
    {
        $this->session->remove(['admin_logged_in', 'user_id', 'name', 'role_name']);
        $this->session->destroy(); // Destroy the session
        return redirect()->to('/');
    }
}
