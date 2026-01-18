<div class="row mb-5">
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Victoires</div>
            <div class="card-body">
                <h1 class="card-title"><?= $pctGagne ?>%</h1>
                <p class="card-text"><?= $globalStats['gagnes'] ?> matchs gagnés</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Nuls</div>
            <div class="card-body">
                <h1 class="card-title"><?= $pctNul ?>%</h1>
                <p class="card-text"><?= $globalStats['nuls'] ?> matchs nuls</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Défaites</div>
            <div class="card-body">
                <h1 class="card-title"><?= $pctPerdu ?>%</h1>
                <p class="card-text"><?= $globalStats['perdus'] ?> matchs perdus</p>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-3">Performances par Joueur</h4>
<div class="table-responsive">
    <table class="table table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th class="text-start">Joueur</th>
                <th>Statut</th>
                <th>Matchs joués</th>
                <th>Titulaire / Remplaçant</th>
                <th>Note Moyenne</th>
                <th>% Victoire (avec lui)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($joueurStats as $stat): ?>
            <tr>
                <td class="text-start fw-bold">
                    <?= htmlspecialchars($stat['nom'] . ' ' . $stat['prenom']) ?>
                </td>
                <td>
                    <span class="badge bg-secondary"><?= $stat['statut'] ?></span>
                </td>
                <td><?= $stat['nb_matchs'] ?></td>
                <td>
                    <span class="text-success"><?= $stat['nb_titularisations'] ?></span> / 
                    <span class="text-muted"><?= $stat['nb_remplacements'] ?></span>
                </td>
                <td>
                    <?php if ($stat['moyenne_note']): ?>
                        <strong><?= number_format($stat['moyenne_note'], 1) ?></strong> / 5
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($stat['nb_matchs'] > 0): ?>
                        <?= number_format($stat['pct_victoire'], 0) ?> %
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>