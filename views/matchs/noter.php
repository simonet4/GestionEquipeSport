<div class="card mb-4 border-warning">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Match contre <?= htmlspecialchars($match['nom_equipe_adverse']) ?></h5>
        <small><?= date('d/m/Y', strtotime($match['date_heure'])) ?></small>
    </div>
    <div class="card-body">
        <form action="" method="post">
            
            <div class="row mb-4 justify-content-center text-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Notre Équipe</label>
                    <input type="number" name="score_equipe" class="form-control form-control-lg text-center" 
                           value="<?= $match['resultat_equipe'] ?>" required min="0">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <h2>-</h2>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Adversaire</label>
                    <input type="number" name="score_adverse" class="form-control form-control-lg text-center" 
                           value="<?= $match['resultat_adverse'] ?>" required min="0">
                </div>
            </div>

            <hr>

            <h5 class="mb-3">Évaluation des joueurs présents</h5>
            <?php if (empty($participants)): ?>
                <div class="alert alert-warning">Aucun joueur n'a été inscrit sur la feuille de match.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Joueur</th>
                                <th>Poste joué</th>
                                <th>Note (1 à 5)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($participants as $p): 
                                $id = $p['id_joueur'];
                                $nom = isset($tousLesJoueurs[$id]) ? $tousLesJoueurs[$id]['nom'] . ' ' . $tousLesJoueurs[$id]['prenom'] : 'Inconnu';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($nom) ?></td>
                                <td><?= htmlspecialchars($p['poste']) ?></td>
                                <td>
                                    <select name="notes[<?= $id ?>]" class="form-select" style="width: 150px;">
                                        <option value="">-- Note --</option>
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($p['evaluation'] == $i) ? 'selected' : '' ?>>
                                                <?= $i ?> / 5
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg">Enregistrer Match & Notes</button>
            </div>
        </form>
    </div>
</div>