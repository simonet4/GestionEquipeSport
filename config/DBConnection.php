<?php
class DBConnection {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('DB_HOST');
        if (empty($host) || $host === 'localhost') {
            $host = 'db_sport';
        }
        
        $dbname = getenv('DB_NAME') ?: 'sport_db';
        $user = getenv('DB_USER') ?: 'sport_user';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur connexion DB: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getPDO() {
        return $this->pdo;
    }
}
