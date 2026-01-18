<?php
class JoueurController {
    
    public function liste() { // Affiche la liste des joueurs
        $model = new JoueurModel();
        $joueurs = $model->getAllJoueurs();
        $titre = "Effectif de l'équipe";
        $vue = "../views/joueurs/liste.php";
        $currentPage = 'joueurs';
        require_once "../views/layout.php";
    }

    public function ajouter() { // Formulaire pour ajouter un joueur
        $titre = "Ajouter un joueur";
        $vue = "../views/joueurs/form.php";
        $currentPage = 'joueurs';
        require_once "../views/layout.php";
    }

    public function modifier() { // Formulaire pré-rempli pour modifier
        if (isset($_GET['id'])) {
            $model = new JoueurModel();
            $joueur = $model->getJoueurById($_GET['id']);
            
            if ($joueur) {
                $titre = "Modifier le joueur";
                $vue = "../views/joueurs/form.php";
                $currentPage = 'joueurs';
                require_once "../views/layout.php";
            } else {
                header('Location: index.php?page=joueurs&action=liste');
            }
        }
    }

    public function sauvegarder() { // Traite l'ajout ou modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new JoueurModel();
            
            $id = $_POST['id'] ?? null;
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $licence = htmlspecialchars($_POST['licence']);
            $date_naissance = $_POST['date_naissance'];
            $taille = $_POST['taille'];
            $poids = $_POST['poids'];
            $statut = $_POST['statut'];
            $commentaire = htmlspecialchars($_POST['commentaire']);

            if ($id) {
                $model->updateJoueur($id, $nom, $prenom, $licence, $date_naissance, $taille, $poids, $statut, $commentaire);
            } else {
                $model->addJoueur($nom, $prenom, $licence, $date_naissance, $taille, $poids, $statut, $commentaire);
            }

            header('Location: index.php?page=joueurs&action=liste');
            exit;
        }
    }

    public function supprimer() { // Supprime un joueur
        if (isset($_GET['id'])) {
            $model = new JoueurModel();
            $model->deleteJoueur($_GET['id']);
        }
        header('Location: index.php?page=joueurs&action=liste');
        exit;
    }
}
?>