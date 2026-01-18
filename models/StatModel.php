<?php
class StatModel {
    private $pdo;

    public function __construct() {
        $this->pdo = DBConnection::getInstance()->getPDO(); // Connexion DB
    }

    public function getGlobalStats() { // Stats générales de l'équipe
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN resultat_equipe > resultat_adverse THEN 1 ELSE 0 END) as gagnes,
                    SUM(CASE WHEN resultat_equipe < resultat_adverse THEN 1 ELSE 0 END) as perdus,
                    SUM(CASE WHEN resultat_equipe = resultat_adverse THEN 1 ELSE 0 END) as nuls
                FROM match_rencontre 
                WHERE resultat_equipe IS NOT NULL";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch();
    }

    public function getJoueurStats() { // Stats détaillées par joueur
        $sql = "SELECT 
                    j.id_joueur, j.nom, j.prenom, j.statut, j.numero_licence,
                    COUNT(p.id_match) as nb_matchs,
                    SUM(p.est_titulaire) as nb_titularisations,
                    (COUNT(p.id_match) - SUM(p.est_titulaire)) as nb_remplacements,
                    AVG(p.evaluation) as moyenne_note,
                    
                    (SUM(CASE WHEN m.resultat_equipe > m.resultat_adverse THEN 1 ELSE 0 END) / COUNT(p.id_match) * 100) as pct_victoire
                
                FROM joueur j
                LEFT JOIN participer p ON j.id_joueur = p.id_joueur
                LEFT JOIN match_rencontre m ON p.id_match = m.id_match
                
                GROUP BY j.id_joueur
                ORDER BY nb_matchs DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
}
?>