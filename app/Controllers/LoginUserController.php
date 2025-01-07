<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('login'); 
    }

    public function login()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel
            ->select('users.*, comptes.role_id') // Récupère les colonnes nécessaires
            ->join('comptes', 'comptes.user_id = users.id') // Jointure entre `users` et `comptes`
            ->where('users.email', $this->request->getPost('email'))
            ->first();

        // Vérifie les informations d'identification
        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

        // Stocke les données utilisateur dans la session
        session()->set('isLoggedIn', true);
        session()->set('user', $user);

        // Redirection selon le rôle (2 = Professeur, 3 = Étudiant)
        if ($user['role_id'] == 2) {
            return redirect()->to('http://localhost:8080/professeur/dashboard');
        } elseif ($user['role_id'] == 3) {
            return redirect()->to('http://localhost:8080/etudiant/dashboard');
        } else {
            return redirect()->to('http://localhost:8080/dashboard'); // Redirection par défaut
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
