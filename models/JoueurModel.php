<?php
class JoueurModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO(); // Connexion DB via Singleton
    }

    public function getAllJoueurs() { // Liste tous les joueurs avec poste préféré
        try {
            $sql = "SELECT * FROM joueurs_avec_poste ORDER BY nom, prenom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des joueurs : " . $e->getMessage());
            return [];
        }
    }

    public function getJoueurById($id) { // Récupère un joueur spécifique
        $sql = "SELECT * FROM joueur WHERE id_joueur = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function addJoueur($nom, $prenom, $licence, $date_naissance, $taille, $poids, $statut, $commentaire) { // Ajoute un nouveau joueur
        try {
            $sql = "INSERT INTO joueur (nom, prenom, numero_licence, date_naissance, taille, poids, statut, commentaire) 
                    VALUES (:nom, :prenom, :licence, :date_naissance, :taille, :poids, :statut, :commentaire)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':licence' => $licence,
                ':date_naissance' => $date_naissance,
                ':taille' => $taille,
                ':poids' => $poids,
                ':statut' => $statut,
                ':commentaire' => $commentaire
            ]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout du joueur : " . $e->getMessage());
            return false;
        }
    }

    public function updateJoueur($id, $nom, $prenom, $licence, $date_naissance, $taille, $poids, $statut, $commentaire) { // Met à jour un joueur
        try {
            $sql = "UPDATE joueur SET 
                    nom = :nom, prenom = :prenom, numero_licence = :licence, 
                    date_naissance = :date_naissance, taille = :taille, poids = :poids, 
                    statut = :statut, commentaire = :commentaire 
                    WHERE id_joueur = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':licence' => $licence,
                ':date_naissance' => $date_naissance,
                ':taille' => $taille,
                ':poids' => $poids,
                ':statut' => $statut,
                ':commentaire' => $commentaire
            ]);
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour du joueur : " . $e->getMessage());
            return false;
        }
    }

    public function deleteJoueur($id) { // Supprime un joueur
        try {
            $sql = "DELETE FROM joueur WHERE id_joueur = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression du joueur : " . $e->getMessage());
            return false;
        }
    }

    public function getJoueursActifs() { // Liste seulement les joueurs actifs
        $sql = "SELECT * FROM joueur WHERE statut = 'Actif' ORDER BY nom, prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>