<?php
class MatchModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO(); // Connexion DB
    }

    public function getAllMatchs() { // Liste tous les matchs, récents d'abord
        $sql = "SELECT * FROM match_rencontre ORDER BY date_heure DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addMatch($date, $heure, $adversaire, $lieu) { // Ajoute un nouveau match
        try {
            $date_heure = $date . ' ' . $heure . ':00';
            
            $sql = "INSERT INTO match_rencontre (date_heure, nom_equipe_adverse, lieu_rencontre) 
                    VALUES (:dh, :adversaire, :lieu)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':dh' => $date_heure,
                ':adversaire' => $adversaire,
                ':lieu' => $lieu
            ]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout du match : " . $e->getMessage());
            return false;
        }
    }

    public function getMatchById($id) { // Détails d'un match spécifique
        $sql = "SELECT * FROM match_rencontre WHERE id_match = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getFeuilleDeMatch($id_match) { // Joueurs inscrits sur la feuille
        $sql = "SELECT * FROM participer WHERE id_match = :id_match";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_match' => $id_match]);
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[$row['id_joueur']] = $row;
        }
        return $result;
    }

    public function saveFeuilleMatch($id_match, $selection) { // Sauvegarde la composition équipe
        try {
            $this->pdo->beginTransaction();

            $sqlDelete = "DELETE FROM participer WHERE id_match = :id_match";
            $stmtDel = $this->pdo->prepare($sqlDelete);
            $stmtDel->execute([':id_match' => $id_match]);

            $sqlInsert = "INSERT INTO participer (id_match, id_joueur, est_titulaire, poste) 
                          VALUES (:id_match, :id_joueur, :est_titulaire, :poste)";
            $stmtIns = $this->pdo->prepare($sqlInsert);

            foreach ($selection as $joueur_data) {
                $stmtIns->execute([
                    ':id_match' => $id_match,
                    ':id_joueur' => $joueur_data['id'],
                    ':est_titulaire' => $joueur_data['titulaire'],
                    ':poste' => $joueur_data['poste']
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateScore($id_match, $score_equipe, $score_adverse) { // Met à jour le score final
        $sql = "UPDATE match_rencontre SET resultat_equipe = :re, resultat_adverse = :ra WHERE id_match = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':re' => $score_equipe,
            ':ra' => $score_adverse,
            ':id' => $id_match
        ]);
    }

    public function updateNoteJoueur($id_match, $id_joueur, $note) { // Note un joueur pour ce match
        $sql = "UPDATE participer SET evaluation = :note WHERE id_match = :im AND id_joueur = :ij";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':note' => $note,
            ':im' => $id_match,
            ':ij' => $id_joueur
        ]);
    }

    public function updateMatch($id, $date, $heure, $adversaire, $lieu) { // Met à jour un match
        $date_heure = $date . ' ' . $heure . ':00';
        $sql = "UPDATE match_rencontre SET date_heure = :dh, nom_equipe_adverse = :adversaire, lieu_rencontre = :lieu WHERE id_match = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':dh' => $date_heure,
            ':adversaire' => $adversaire,
            ':lieu' => $lieu,
            ':id' => $id
        ]);
    }

    public function deleteMatch($id) { // Supprime un match
        $sql = "DELETE FROM match_rencontre WHERE id_match = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>