<div class="d-flex justify-content-between mb-3">
    <p>Calendrier de la saison.</p>
    <a href="index.php?page=matchs&action=add" class="btn btn-success">+ Nouveau Match</a>
</div>

<div class="row">
    <?php foreach ($matchs as $match): 
        $dateObj = new DateTime($match['date_heure']);
        $isPasse = $dateObj < new DateTime();
    ?>
    <div class="col-md-6 mb-4">
        <div class="card <?= $isPasse ? 'border-secondary' : 'border-primary' ?>">
            <div class="card-header d-flex justify-content-between align-items-center 
                        <?= $isPasse ? 'bg-secondary text-white' : 'bg-primary text-white' ?>">
                <span><?= $dateObj->format('d/m/Y à H:i') ?></span>
                <span class="badge bg-light text-dark"><?= $match['lieu_rencontre'] ?></span>
            </div>
            <div class="card-body">
                <h5 class="card-title">Contre : <?= htmlspecialchars($match['nom_equipe_adverse']) ?></h5>
                
                <?php if ($match['resultat_equipe'] !== null): ?>
                    <h4 class="text-center my-3">
                        Score : <?= $match['resultat_equipe'] ?> - <?= $match['resultat_adverse'] ?>
                    </h4>
                <?php else: ?>
                    <p class="text-muted text-center my-3">Match à venir</p>
                <?php endif; ?>

                <div class="d-grid gap-2">
                    <a href="index.php?page=matchs&action=feuille&id=<?= $match['id_match'] ?>" 
                       class="btn btn-outline-primary btn-sm">
                       <i class="bi bi-people"></i> Gérer la feuille de match
                    </a>
                    
                    <div class="btn-group" role="group">
                        <a href="index.php?page=matchs&action=edit&id=<?= $match['id_match'] ?>" class="btn btn-outline-secondary btn-sm">Modifier</a>
                        <a href="index.php?page=matchs&action=delete&id=<?= $match['id_match'] ?>" 
                           class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce match ?');">
                           Supprimer
                        </a>
                    </div>
                    
                    <?php if ($isPasse): ?>
                        <a href="index.php?page=matchs&action=noter&id=<?= $match['id_match'] ?>" class="btn btn-warning btn-sm">Saisir résultat</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>