<hr class="my-4">
<h4>Sélection des joueurs</h4>
<div class="table-responsive">
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th style="width: 50px;">Sel.</th>
                <th>Joueur</th>
                <th>Rôle</th>
                <th>Poste</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($joueursActifs as $j): ?>
            <tr>
                <td class="text-center align-middle">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="joueurs[]" 
                               value="<?= $j['id_joueur'] ?>" 
                               id="j_<?= $j['id_joueur'] ?>">
                    </div>
                </td>
                <td class="align-middle">
                    <label class="form-check-label w-100" for="j_<?= $j['id_joueur'] ?>">
                        <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
                        <br>
                        <small class="text-muted"><?= htmlspecialchars($j['numero_licence']) ?></small>
                    </label>
                </td>
                <td class="align-middle">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" 
                               name="data[<?= $j['id_joueur'] ?>][titulaire]" 
                               value="1" checked>
                        <label class="form-check-label">Titulaire</label>
                    </div>
                </td>
                <td class="align-middle">
                    <input type="text" class="form-control form-control-sm" 
                           name="data[<?= $j['id_joueur'] ?>][poste]" 
                           placeholder="Poste (ex: Ailier)">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>