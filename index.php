<?php
session_start();

// Configuration Admin
$login_attendu = "admin";
$hash_attendu = password_hash("1234", PASSWORD_DEFAULT);
$message = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_saisi = $_POST['identifiant'];
    $mdp_saisi = $_POST['mot_de_passe'];

    if ($login_saisi === $login_attendu && password_verify($mdp_saisi, $hash_attendu)) {
        $_SESSION['est_connecte'] = true;
        $_SESSION['utilisateur'] = $login_saisi;
        
        // Redirection vers l'accueil
        header("Location: Vues/liste_joueurs.php"); 
        exit();
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Coach</title>
    <link rel="stylesheet" href="GlobalCSS.css">
</head>
<body>
    <div style="max-width:400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h1>Connexion</h1>
        <?php if(!empty($message)) { echo "<p style='color:red'>$message</p>"; } ?>
        <form action="" method="POST">
            <label>Identifiant :</label>
            <input type="text" name="identifiant" required>
            
            <label>Mot de passe :</label>
            <input type="password" name="mot_de_passe" required>
            
            <input type="submit" value="Se connecter" style="margin-top:10px;">
        </form>
    </div>
</body>
</html>