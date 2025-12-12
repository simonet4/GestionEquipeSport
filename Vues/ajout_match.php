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
    <title>Feuille de match</title>
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
        <h1>Feuille de match</h1>

        <section>
            <h2>Informations sur le match</h2>
            <form>
                <label>ID du match :</label>
                <input type="text" name="id_match">

                <label>Statut de la feuille :</label>
                <input type="text" name="statut_feuille">

                <label>Équipe adverse :</label>
                <input type="text" name="equipe_adverse">

                <label>Match à domicile :</label>
                <input type="checkbox" name="rencontre_domicile">

                <label>Date du match :</label>
                <input type="date" name="date_match">

                <label>Heure du début :</label>
                <input type="time" name="heure_debut">

                <label>Heure de fin :</label>
                <input type="time" name="heure_fin">

                <label>Résultat :</label>
                <input type="text" name="resultat">
            </form>
        </section>

        <section>
            <h2>Joueurs</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Numéro licence</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Titulaire</th>
                        <th>Poste</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>