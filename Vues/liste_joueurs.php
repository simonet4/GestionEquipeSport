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
    <title>Fiche Joueur</title>
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
        <h1>Fiche Joueur</h1>

        <section>
            <h2>Informations du joueur</h2>
            <form>
                <label>Numéro de licence :</label>
                <input type="text" name="numero_licence">

                <label>Nom :</label>
                <input type="text" name="nom">

                <label>Prénom :</label>
                <input type="text" name="prenom">

                <label>Date de naissance :</label>
                <input type="date" name="date_naissance">

                <label>Taille (cm) :</label>
                <input type="number" name="taille">

                <label>Poids (kg) :</label>
                <input type="number" step="0.01" name="poids">

                <label>Commentaire général :</label>
                <textarea name="commentaire_general_joueur" rows="3"></textarea>

                <label>Statut :</label>
                <select name="Id_statut">
                    <option value="">-- Sélectionner --</option>
                    <option value="1">Actif</option>
                    <option value="2">Suspendu</option>
                    <option value="3">Absent</option>
                    <option value="4">Blessé</option>
                </select>
            </form>
        </section>

        <section>
            <h2>Matchs joués</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID Match</th>
                        <th>Titulaire</th>
                        <th>Poste occupé</th>
                        <th>Notes</th>
                        <th>Commentaire match</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td><input type="checkbox" disabled></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div> </body>
</html>