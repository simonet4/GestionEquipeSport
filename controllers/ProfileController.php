<?php
require_once '../models/UserModel.php';
require_once '../config/secrets.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->currentPage = 'profile';
    }

    public function index() {
        $user = $_SESSION['user'];
        $vue = "../views/profile/index.php";
        $titre = "Gestion du Profil";
        require_once "../views/layout.php";
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            $user = $_SESSION['user'];

            // Vérifier le mot de passe administrateur
            if ($currentPassword !== ADMIN_PASSWORD) {
                $message = "Mot de passe administrateur incorrect.";
            } else {
                if ($this->userModel->updateProfile($user['id_utilisateur'], $login, $email, $password)) {
                    // Update session
                    $_SESSION['user']['login'] = $login;
                    $_SESSION['user']['email'] = $email;
                    $message = "Profil mis à jour avec succès.";
                } else {
                    $message = "Erreur lors de la mise à jour.";
                }
            }
        }

        $user = $_SESSION['user'];
        $vue = "../views/profile/index.php";
        $titre = "Gestion du Profil";
        require_once "../views/layout.php";
    }
}
?>