<?php
class AuthController {

    public function login() { // Affiche le formulaire de connexion
        $vue = "../views/auth/login.php";
        $titre = "Authentification Coach";
        require_once "../views/layout.php";
    }

    public function checkCredentials() { // Vérifie login/mdp et connecte
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getByLogin($login);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user'] = $user;
                
                header('Location: index.php?page=joueurs&action=liste');
                exit;
            } else {
                $error = "Identifiants incorrects";
                $vue = "../views/auth/login.php";
                require_once "../views/layout.php";
            }
        }
    }

    public function forgot() { // Affiche le formulaire mot de passe oublié
        $vue = "../views/auth/forgot.php";
        $titre = "Mot de passe oublié";
        require_once "../views/layout.php";
    }

    public function reset() { // Réinitialise le mot de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $userModel = new UserModel();
            if ($userModel->resetPassword($email)) {
                $message = "Mot de passe réinitialisé à 'admin'. Connectez-vous avec ce mot de passe.";
            } else {
                $message = "Email non trouvé.";
            }
        }
        $vue = "../views/auth/forgot.php";
        $titre = "Mot de passe oublié";
        require_once "../views/layout.php";
    }

    public function logout() { // Déconnecte l'utilisateur
        session_destroy();
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}
?>