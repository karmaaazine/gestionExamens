<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CompteModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class LoginUserController extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        return view('login'); 
    }


    // Gérer la soumission du formulaire de connexion
    public function login()
    {
        $validation = \Config\Services::validation();

        // Valider les champs du formulaire
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('login', ['errors' => $validation->getErrors()]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Vérifier les informations 
        $userModel = new UserModel();
        $compteModel = new CompteModel();
        $roleModel = new RoleModel();
        
        $user = $userModel->where('email', $email)->first();
        if ($user) {
            $compte = $compteModel->where('user_id', $user['id'])->first();
            if ($compte) {
                $role = $roleModel->where('id', $compte['role_id'])->first();
                
                //Verifier si les informations valides
                if (password_verify($password, $user['password'])) {
                    //Si user est trouve et pwd correct
                    $this->session->set([
                        'isLoggedIn' => true,
                        'user_id'    => $user['id'],
                        'name'       => $user['name'],
                        'role_name'  => $role['role_name'], 
                    ]);

                    if ($role['role_name'] === 'professeur') {
                        return redirect()->to('/professeur/dashboard');
                    } 
                    elseif ($role['role_name'] === 'etudiant') {
                        return redirect()->to('/etudiant/dashboard');
                    } 
                    else {
                        return redirect()->to('/dashboard'); 
                    }
                } else {
                    $this->session->setFlashdata('error', 'email ou mot de passe incorrect');
                    return redirect()->to('/login'); 
                }
            }
        }

        $this->session->setFlashdata('error', 'email ou mot de passe incorrect');
        return redirect()->to('/login'); 
    }

    public function logout()
    {
        $this->session->remove(['isLoggedIn', 'user_id', 'name', 'role_name']);
        $this->session->destroy(); 
        return redirect()->to('/'); 
    }
}
