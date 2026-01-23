<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Charge automatiquement les classes pour éviter les require
spl_autoload_register(function ($class) {
    $paths = ['../controllers/', '../models/', '../config/'];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Route vers le bon contrôleur selon l'URL
$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

// Protège les pages privées sans connexion
if (!isset($_SESSION['user']) && $page !== 'auth') {
    header('Location: index.php?page=auth&action=login');
    exit;
}

// Dirige vers le contrôleur approprié
switch ($page) {
    case 'auth':
        $controller = new AuthController();
        if ($action == 'login') $controller->login();
        elseif ($action == 'check') $controller->checkCredentials();
        elseif ($action == 'logout') $controller->logout();
        elseif ($action == 'forgot') $controller->forgot();
        elseif ($action == 'reset') $controller->reset();
        break;

    case 'joueurs':
        $controller = new JoueurController();
        if ($action == 'liste') $controller->liste();
        elseif ($action == 'add') $controller->ajouter();
        elseif ($action == 'edit') $controller->modifier();
        elseif ($action == 'save') $controller->sauvegarder();
        elseif ($action == 'delete') $controller->supprimer();
        break;

    case 'matchs':
        $controller = new MatchController();
        if ($action == 'liste') $controller->liste();
        elseif ($action == 'add') $controller->ajouter();
        elseif ($action == 'edit') $controller->modifier();
        elseif ($action == 'delete') $controller->supprimer();
        elseif ($action == 'feuille') $controller->feuille();
        elseif ($action == 'noter') $controller->noter();
        break;

    case 'stats':
        $controller = new StatController();
        $controller->index();
        break;

    case 'profile':
        $controller = new ProfileController();
        if ($action == 'index') $controller->index();
        elseif ($action == 'update') $controller->update();
        break;

    default:
        $controller = new JoueurController();
        $controller->liste();
        break;
}
?>