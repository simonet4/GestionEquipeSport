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
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['login'] = $user['login'];
                
                header('Location: index.php?page=joueurs&action=liste');
                exit;
            } else {
                $error = "Identifiants incorrects";
                $vue = "../views/auth/login.php";
                require_once "../views/layout.php";
            }
        }
    }

    public function logout() { // Déconnecte l'utilisateur
        session_destroy();
        header('Location: index.php?page=auth&action=login');
        exit;
    }
}
?>