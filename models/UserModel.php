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
}
?>