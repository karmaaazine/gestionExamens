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
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if ($this->session->get('admin_logged_in')) {
            return view('Admin/gestion_prof');
        }
        return view('Admin/login');
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        
        // Validation des données envoyées via le formulaire
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

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $city = $this->request->getPost('city');
        $tel = $this->request->getPost('tel');
        $password = $this->request->getPost('password');

        $profModel = new UserModel();
        $compteModel = new CompteModel();
        $roleModel = new RoleModel();
        
        $profModel->save([
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'tel' => $tel,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Hachage du mot de passe
        ]);
        $role_prof = $roleModel->where('role_name', 'prodesseur')->first();
        $compteModel->save([
            'user_id' => $profModel['id'],
            'role_id' => $role_prof['id'],
        ]);
        
        return redirect()->to('/admin/gestion_prof');
    }

    public function edit()
    {

    }

    public function delete()
    {

    }

}
