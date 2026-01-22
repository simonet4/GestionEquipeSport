<?php
class MatchController {
    
    public function liste() { 
        $model = new MatchModel();
        $matchs = $model->getAllMatchs();
        $titre = "Calendrier des Rencontres";
        $vue = "../views/matchs/liste.php";
        $currentPage = 'matchs';
        require_once "../views/layout.php";
    }

    public function ajouter() {
        $joueurModel = new JoueurModel();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $adversaire = htmlspecialchars($_POST['adversaire']);
            $lieu = $_POST['lieu'];

            $model = new MatchModel();
            
            $id_match = $model->addMatch($date, $heure, $adversaire, $lieu);
            
            if ($id_match && isset($_POST['joueurs']) && is_array($_POST['joueurs'])) {
                $selection = [];
                foreach ($_POST['joueurs'] as $id_joueur) {
                    $infos = $_POST['data'][$id_joueur] ?? [];
                    $selection[] = [
                        'id' => $id_joueur,
                        'titulaire' => isset($infos['titulaire']) ? 1 : 0,
                        'poste' => htmlspecialchars($infos['poste'] ?? '')
                    ];
                }
                $model->saveFeuilleMatch($id_match, $selection);
            }
            
            header('Location: index.php?page=matchs'); 
            exit;
        }
        
        $joueursActifs = $joueurModel->getJoueursActifs();

        $titre = "Planifier un match";
        $vue = "../views/matchs/ajout.php";
        $currentPage = 'matchs';
        require_once "../views/layout.php";
    }

    public function feuille() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=matchs');
            exit;
        }

        $id_match = $_GET['id'];
        $matchModel = new MatchModel();
        $joueurModel = new JoueurModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selection = [];
            if (isset($_POST['joueurs']) && is_array($_POST['joueurs'])) {
                foreach ($_POST['joueurs'] as $id_joueur) {
                    $infos = $_POST['data'][$id_joueur] ?? [];
                    $selection[] = [
                        'id' => $id_joueur,
                        'titulaire' => isset($infos['titulaire']) ? 1 : 0,
                        'poste' => htmlspecialchars($infos['poste'] ?? '')
                    ];
                }
            }
            
            $matchModel->saveFeuilleMatch($id_match, $selection);
            
            header("Location: index.php?page=matchs");
            exit;
        }

        $match = $matchModel->getMatchById($id_match);
        $joueursActifs = $joueurModel->getJoueursActifs();
        $selectionActuelle = $matchModel->getFeuilleDeMatch($id_match);

        $titre = "Feuille de match : vs " . htmlspecialchars($match['nom_equipe_adverse']);
        $vue = "../views/matchs/feuille.php";
        $currentPage = 'matchs';
        require_once "../views/layout.php";
    }

    public function noter() { 
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=matchs');
            exit;
        }

        $id_match = $_GET['id'];
        $matchModel = new MatchModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $score_equipe = $_POST['score_equipe'];
            $score_adverse = $_POST['score_adverse'];
            $matchModel->updateScore($id_match, $score_equipe, $score_adverse);

            if (isset($_POST['notes']) && is_array($_POST['notes'])) {
                foreach ($_POST['notes'] as $id_joueur => $note) {
                    if ($note !== "") {
                        $matchModel->updateNoteJoueur($id_match, $id_joueur, $note);
                    }
                }
            }

            header("Location: index.php?page=matchs");
            exit;
        }

        $match = $matchModel->getMatchById($id_match);
        $participants = $matchModel->getFeuilleDeMatch($id_match);
        $joueurModel = new JoueurModel();
        
        $tousLesJoueurs = [];
        foreach($joueurModel->getAllJoueurs() as $j) {
            $tousLesJoueurs[$j['id_joueur']] = $j;
        }

        $titre = "Résultat & Évaluations";
        $vue = "../views/matchs/noter.php";
        $currentPage = 'matchs';
        require_once "../views/layout.php";
    }

    public function modifier() { 
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=matchs');
            exit;
        }

        $id_match = $_GET['id'];
        $matchModel = new MatchModel();
        $match = $matchModel->getMatchById($id_match);

        if (!$match) {
            header('Location: index.php?page=matchs');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'];
            $heure = $_POST['heure'];
            $adversaire = htmlspecialchars($_POST['adversaire']);
            $lieu = $_POST['lieu'];

            $matchModel->updateMatch($id_match, $date, $heure, $adversaire, $lieu);
            
            header('Location: index.php?page=matchs');
            exit;
        }

        $titre = "Modifier le match";
        $vue = "../views/matchs/modifier.php";
        $currentPage = 'matchs';
        require_once "../views/layout.php";
    }

    public function supprimer() {
        if (isset($_GET['id'])) {
            $matchModel = new MatchModel();
            $matchModel->deleteMatch($_GET['id']);
        }
        header('Location: index.php?page=matchs');
        exit;
    }
}
?>