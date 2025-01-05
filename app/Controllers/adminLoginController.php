<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminLoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('UserModel'); // Modèle pour gérer les interactions avec les utilisateurs
    }

    // Charger la page de connexion
    public function index() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }
        $this->load->view('admin/login');
    }

    // Traitement de la soumission du formulaire de connexion
    public function login() {
        // Validation des champs
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation échouée
            $this->load->view('admin/login');
        } else {
            // Récupérer les informations du formulaire
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Vérifier les informations d'identification
            $user = $this->UserModel->verify_admin($email, $password);

            if ($user) {
                // Vérifier si l'utilisateur est un admin
                if ($user->role_name === 'admin') {
                    // Définir les données de session
                    $this->session->set_userdata([
                        'admin_logged_in' => TRUE,
                        'user_id' => $user->user_id,
                        'username' => $user->username,
                        'role_name' => $user->role_name,
                    ]);
                    redirect('admin/dashboard');
                } else {
                    // Utilisateur non autorisé
                    $this->session->set_flashdata('error', 'Seuls les administrateurs peuvent se connecter.');
                    redirect('admin/login');
                }
            } else {
                // Connexion échouée
                $this->session->set_flashdata('error', 'Email ou mot de passe invalide.');
                redirect('admin/login');
            }
        }
    }

    // Déconnexion
    public function logout() {
        $this->session->unset_userdata(['admin_logged_in', 'user_id', 'username', 'role_name']);
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
