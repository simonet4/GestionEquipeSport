<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">La feuille de match a été sauvegardée !</div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body bg-light">
        <h5 class="card-title">Détails de la rencontre</h5>
        <p class="mb-0">
            <strong>Date :</strong> <?= date('d/m/Y à H:i', strtotime($match['date_heure'])) ?> <br>
            <strong>Adversaire :</strong> <?= htmlspecialchars($match['nom_equipe_adverse']) ?> <br>
            <strong>Lieu :</strong> <?= $match['lieu_rencontre'] ?>
        </p>
    </div>
</div>

<form action="" method="post">
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="text-center" style="width: 50px;">Sel.</th>
                    <th>Joueur (Actifs uniquement)</th>
                    <th>Infos (Aide à la décision)</th>
                    <th>Rôle</th>
                    <th>Poste pour ce match</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueursActifs as $j): 
                    $id = $j['id_joueur'];
                    $selected = isset($selectionActuelle[$id]);
                    $data = $selected ? $selectionActuelle[$id] : [];
                ?>
                <tr class="<?= $selected ? 'table-primary' : '' ?>">
                    <td class="text-center">
                        <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input" type="checkbox" 
                                   name="joueurs[]" value="<?= $id ?>" 
                                   <?= $selected ? 'checked' : '' ?>
                                   style="transform: scale(1.3);">
                        </div>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?></strong><br>
                        <small class="text-muted">Licence : <?= htmlspecialchars($j['numero_licence']) ?></small>
                    </td>
                    <td>
                        <small>
                            Taille: <?= $j['taille'] ? $j['taille'].'cm' : '-' ?> | 
                            Poids: <?= $j['poids'] ? $j['poids'].'kg' : '-' ?>
                        </small>
                        <?php if(!empty($j['commentaire'])): ?>
                            <br><small class="text-info fst-italic">Note: <?= htmlspecialchars($j['commentaire']) ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   name="data[<?= $id ?>][titulaire]" 
                                   <?= (isset($data['est_titulaire']) && $data['est_titulaire'] == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label">Titulaire</label>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" 
                               name="data[<?= $id ?>][poste]" 
                               placeholder="Ex: Ailier gauche"
                               value="<?= isset($data['poste']) ? htmlspecialchars($data['poste']) : '' ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($joueursActifs)): ?>
                    <tr><td colspan="5" class="text-center text-danger">Aucun joueur actif disponible.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3 mb-5">
        <a href="index.php?page=matchs&action=liste" class="btn btn-secondary me-2">Annuler</a>
        <button type="submit" class="btn btn-success btn-lg">Valider la feuille de match</button>
    </div>
</form>