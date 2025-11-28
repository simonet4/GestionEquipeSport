<?php
// Modifie "monSuperMotDePasse" par le vrai mot de passe que tu veux utiliser
$mot_de_passe = "monSuperMotDePasse";

echo "Voici le hash à copier dans ton code : <br>";
echo password_hash($mot_de_passe, PASSWORD_DEFAULT);
?>