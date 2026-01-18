<?php
class UserModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO(); // Connexion DB
    }

    public function getByLogin($login) { // Trouve un utilisateur par login
        $sql = "SELECT * FROM utilisateur WHERE login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':login' => $login]);
        return $stmt->fetch(); // Retourne l'utilisateur ou false
    }

    public function getByEmail($email) { // Trouve un utilisateur par email
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $login, $email, $password = null) { // Met à jour le profil
        try {
            if ($password) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE utilisateur SET login = :login, email = :email, mot_de_passe = :pass WHERE id_utilisateur = :id";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([':login' => $login, ':email' => $email, ':pass' => $hashed, ':id' => $id]);
            } else {
                $sql = "UPDATE utilisateur SET login = :login, email = :email WHERE id_utilisateur = :id";
                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([':login' => $login, ':email' => $email, ':id' => $id]);
            }
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour du profil : " . $e->getMessage());
            return false;
        }
    }

    public function resetPassword($email) { // Réinitialise le mot de passe
        try {
            $newPass = 'admin'; // Mot de passe par défaut
            $hashed = password_hash($newPass, PASSWORD_DEFAULT);
            $sql = "UPDATE utilisateur SET mot_de_passe = :pass WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':pass' => $hashed, ':email' => $email]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Erreur lors de la réinitialisation du mot de passe : " . $e->getMessage());
            return false;
        }
    }
}
?>