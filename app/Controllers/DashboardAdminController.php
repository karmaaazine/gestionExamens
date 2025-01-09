<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CompteModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class DashboardAdminController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        if ($this->session->get('role_name') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Accès refusé. Rôle non autorisé.');
        }

        return view('Admin/teacherview'); 
    }
    public function logout()
    {
        $this->session->remove(['admin_logged_in', 'user_id', 'name', 'role_name']);
        $this->session->destroy();
        return redirect()->to('admin/login');
    }
}       