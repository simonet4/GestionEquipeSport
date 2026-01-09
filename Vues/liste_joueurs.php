<?php
session_start();

// SÉCURITÉ
if (!isset($_SESSION['est_connecte']) || $_SESSION['est_connecte'] !== true) {
    header("Location: index.php");
    exit();
}

// CONNEXION BASE DE DONNÉES
require 'bd.php'; 

$message_info = "";

// Récupérer les statuts disponibles depuis la base de données
try {
    $stmt_statuts = $bdd->query("SELECT Id_statut FROM statut ORDER BY Id_statut");
    $statuts_from_db = $stmt_statuts->fetchAll(PDO::FETCH_ASSOC);
    
    // Si la table est vide, insérer les statuts par défaut
    if (empty($statuts_from_db)) {
        try {
            $bdd->exec("INSERT INTO statut (Id_statut, actif, suspendu, absent, blesse) VALUES 
                       (1, 1, 0, 0, 0),
                       (2, 0, 1, 0, 0), 
                       (3, 0, 0, 1, 0),
                       (4, 0, 0, 0, 1)");
            
            // Récupérer à nouveau après insertion
            $stmt_statuts = $bdd->query("SELECT Id_statut FROM statut ORDER BY Id_statut");
            $statuts_from_db = $stmt_statuts->fetchAll(PDO::FETCH_ASSOC);
            
            $message_info = "<p style='color:green'>Statuts initialisés avec succès !</p>";
        } catch (Exception $e) {
            $message_info = "<p style='color:orange'>Impossible d'initialiser les statuts: " . $e->getMessage() . "</p>";
        }
    }
    
    // Créer les statuts avec les noms correspondants
    $statuts = [];
    $statut_names = [
        1 => 'Actif',
        2 => 'Suspendu', 
        3 => 'Absent',
        4 => 'Blessé'
    ];
    
    foreach ($statuts_from_db as $row) {
        $id = $row['Id_statut'];
        if (isset($statut_names[$id])) {
            $statuts[] = [
                'Id_statut' => $id,
                'nom_statut' => $statut_names[$id]
            ];
        }
    }
    
    // Si aucun statut trouvé ou en cas d'erreur, utiliser les statuts par défaut
    if (empty($statuts)) {
        $statuts = array_map(function($id, $name) {
            return ['Id_statut' => $id, 'nom_statut' => $name];
        }, array_keys($statut_names), $statut_names);
        
        if (empty($message_info)) {
            $message_info = "<p style='color:orange'>Utilisation des statuts par défaut.</p>";
        }
    }
} catch (Exception $e) {
    // En cas d'erreur, utiliser les statuts par défaut
    $statuts = array_map(function($id, $name) {
        return ['Id_statut' => $id, 'nom_statut' => $name];
    }, array_keys($statut_names), $statut_names);
    $message_info = "<p style='color:orange'>Erreur de chargement des statuts. Utilisation des statuts par défaut: " . $e->getMessage() . "</p>";
}

// Récupérer la liste des joueurs
try {
    $stmt_joueurs = $bdd->query("SELECT j.*, s.actif, s.suspendu, s.absent, s.blesse 
                                FROM joueur j 
                                LEFT JOIN statut s ON j.Id_statut = s.Id_statut 
                                ORDER BY j.nom, j.prenom");
    $joueurs = $stmt_joueurs->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $joueurs = [];
    if (empty($message_info)) {
        $message_info = "<p style='color:orange'>Erreur de chargement des joueurs: " . $e->getMessage() . "</p>";
    }
}

// 3. TRAITEMENT DU FORMULAIRE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // champs obligatoires
    if (!empty($_POST['numero_licence']) && !empty($_POST['nom'])) {
        
        // Vérifier que le statut est sélectionné
        if (empty($_POST['Id_statut'])) {
            $message_info = "<p style='color:orange'>Veuillez sélectionner un statut pour le joueur.</p>";
        } else {
            // Requête
            $sql = "INSERT INTO joueur (numero_licence, nom, prenom, date_naissance, taille, poids, commentaire_general_joueur, id_statut) 
                    VALUES (:licence, :nom, :prenom, :date_naiss, :taille, :poids, :comm, :statut)";
            
            $stmt = $bdd->prepare($sql);

            // données du formulaire
            try {
                $stmt->execute([
                    ':licence'   => $_POST['numero_licence'],
                    ':nom'       => $_POST['nom'],
                    ':prenom'    => $_POST['prenom'],
                    ':date_naiss'=> $_POST['date_naissance'],
                    ':taille'    => $_POST['taille'],
                    ':poids'     => $_POST['poids'],
                    ':comm'      => $_POST['commentaire_general_joueur'],
                    ':statut'    => $_POST['Id_statut']
                ]);
                $message_info = "<p style='color:green'>Joueur enregistré avec succès !</p>";
                
                // Rafraîchir la liste des joueurs après ajout
                header("Location: liste_joueurs.php");
                exit();
            } catch (PDOException $e) {
                $message_info = "<p style='color:red'>Erreur lors de l'enregistrement : " . $e->getMessage() . "</p>";
            }
        }
    } else {
        $message_info = "<p style='color:orange'>Veuillez remplir au moins le Numéro de licence et le Nom.</p>";
    }
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

        <?= $message_info ?>

        <section>
            <h2>Informations du joueur</h2>
            <form action="" method="POST">
                <label>Numéro de licence :</label>
                <input type="text" name="numero_licence" required>

                <label>Nom :</label>
                <input type="text" name="nom" required>

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
                <select name="Id_statut" required>
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($statuts as $statut): ?>
                        <option value="<?= htmlspecialchars($statut['Id_statut']) ?>">
                            <?= htmlspecialchars($statut['nom_statut']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br>
                <input type="submit" value="Enregistrer le joueur" style="background-color: #28a745; color: white; cursor: pointer;">
            </form>
        </section>

        <section>
            <h2>Liste des joueurs</h2>
            <?php if (!empty($joueurs)): ?>
                <table border="1" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>Licence</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Taille</th>
                            <th>Poids</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($joueurs as $joueur): ?>
                            <tr>
                                <td><?= htmlspecialchars($joueur['numero_licence']) ?></td>
                                <td><?= htmlspecialchars($joueur['nom']) ?></td>
                                <td><?= htmlspecialchars($joueur['prenom']) ?></td>
                                <td><?= $joueur['date_naissance'] ? date('d/m/Y', strtotime($joueur['date_naissance'])) : '-' ?></td>
                                <td><?= $joueur['taille'] ? htmlspecialchars($joueur['taille']) . ' cm' : '-' ?></td>
                                <td><?= $joueur['poids'] ? htmlspecialchars($joueur['poids']) . ' kg' : '-' ?></td>
                                <td>
                                    <?php 
                                    if ($joueur['actif']) echo 'Actif';
                                    elseif ($joueur['suspendu']) echo 'Suspendu';
                                    elseif ($joueur['absent']) echo 'Absent';
                                    elseif ($joueur['blesse']) echo 'Blessé';
                                    else echo '-';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun joueur enregistré pour le moment.</p>
            <?php endif; ?>
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
    </div>

</body>
</html>