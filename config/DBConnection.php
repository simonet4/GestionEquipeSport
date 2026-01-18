<?php
// Singleton pour une seule connexion DB, évite les multiples connexions
class DBConnection {
    private static $instance = null; // Stocke l'unique instance
    private $pdo; // Objet de connexion

    private function __construct() { // Privé pour empêcher new()
        // Connexion locale par défaut
        $host = 'localhost';
        $dbname = 'gestion_sport';
        $user = 'root';
        $pass = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            // Erreurs en exceptions pour debug
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Résultats en tableaux associatifs
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur connexion DB: " . $e->getMessage());
        }
    }

    public static function getInstance() { // Accès à l'instance unique
        if (self::$instance === null) {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getPDO() { // Retourne l'objet PDO pour requêtes
        return $this->pdo;
    }
}
?>