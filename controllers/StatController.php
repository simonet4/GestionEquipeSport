<?php
class StatController {
    public function index() { // Affiche le tableau de bord des stats
        $model = new StatModel();
        
        $globalStats = $model->getGlobalStats();
        $joueurStats = $model->getJoueurStats();
        
        $total = $globalStats['total'] > 0 ? $globalStats['total'] : 1;
        $pctGagne = round(($globalStats['gagnes'] / $total) * 100, 1);
        $pctPerdu = round(($globalStats['perdus'] / $total) * 100, 1);
        $pctNul = round(($globalStats['nuls'] / $total) * 100, 1);

        $titre = "Statistiques de l'équipe";
        $vue = "../views/stats/index.php";
        $currentPage = 'stats';
        require_once "../views/layout.php";
    }
}
?>