<?php
session_start();

// nettoyage
$_SESSION = array();

// On efface le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// On détruit la session
session_destroy();

// Redirection vers la page de connexion
header("Location: ../index.php");
exit();
?>