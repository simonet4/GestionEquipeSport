<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Planifier un match</h2>
        <a href="index.php?page=matchs" class="btn btn-outline-secondary">
            Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="index.php?page=matchs&action=add" method="post">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="heure" class="form-label">Heure</label>
                        <input type="time" class="form-control" id="heure" name="heure" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="adversaire" class="form-label">Adversaire</label>
                    <input type="text" class="form-control" id="adversaire" name="adversaire" placeholder="Ex: FC Nantes" required>
                </div>

                <div class="mb-3">
                    <label for="lieu" class="form-label">Lieu</label>
                    <select class="form-select" id="lieu" name="lieu">
                        <option value="Domicile">Domicile</option>
                        <option value="Exterieur">Extérieur</option>
                    </select>
                </div>

                <hr class="my-4">
                <h4 class="mb-3">Sélection de l'équipe</h4>
                
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm table-hover border">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 50px;" class="text-center">Sel.</th>
                                <th>Joueur</th>
                                <th>Rôle</th>
                                <th>Poste</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($joueursActifs) && !empty($joueursActifs)): ?>
                                <?php foreach ($joueursActifs as $j): ?>
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="joueurs[]" 
                                                   value="<?= $j['id_joueur'] ?>" 
                                                   id="j_<?= $j['id_joueur'] ?>">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <label class="form-check-label w-100" style="cursor: pointer;" for="j_<?= $j['id_joueur'] ?>">
                                            <strong><?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?></strong>
                                            <div class="text-muted small"><?= htmlspecialchars($j['numero_licence']) ?></div>
                                        </label>
                                    </td>
                                    <td class="align-middle">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="data[<?= $j['id_joueur'] ?>][titulaire]" 
                                                   value="1" checked>
                                            <label class="form-check-label small">Titulaire</label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control form-control-sm" 
                                               name="data[<?= $j['id_joueur'] ?>][poste]" 
                                               placeholder="Poste">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun joueur actif disponible.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Valider et Créer le match
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>