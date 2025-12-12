<?php
session_start();

// Vérification de la session
if (!isset($_SESSION['est_connecte']) || $_SESSION['est_connecte'] !== true) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="GlobalCSS.css">
    <meta charset="UTF-8">
    <title>Statistiques de l'équipe</title>
</head>
<body>

    <nav class="navbar">
        <div class="nav-links">
            <a href="liste_joueurs.php" class="nav-item">Joueurs</a>
            <a href="ajout_match.php" class="nav-item">Feuille de Match</a>
            <a href="PageStatistique.php" class="nav-item">Statistiques</a>
        </div>
        <div class="nav-logout">
            <a href="logout.php" class="nav-item logout">Déconnexion (<?= htmlspecialchars($_SESSION['utilisateur']) ?>)</a>
        </div>
    </nav>

    <div class="container">
        <h1>Statistiques de l'équipe</h1>

        <section>
            <h2>Résultats globaux</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Type de résultat</th>
                        <th>Nombre total</th>
                        <th>Pourcentage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Matchs gagnés</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Matchs perdus</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Matchs nuls</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Statistiques par joueur</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Titularisations</th>
                        <th>Moyenne notes</th>
                        <th>% Victoires</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>