<div class="d-flex justify-content-between align-items-center mb-3">
    <p>Gérez ici l'effectif de votre équipe.</p>
    <a href="index.php?page=joueurs&action=add" class="btn btn-success">
        + Nouveau Joueur
    </a>
</div>

<table class="table table-striped table-hover">
    <thead class="table-light">
        <tr>
            <th>Nom Prénom</th>
            <th>Licence</th>
            <th>Poste préféré</th> <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($joueurs as $joueur): ?>
            <tr>
                <td>
                    <strong><?= htmlspecialchars($joueur['nom']) ?></strong> 
                    <?= htmlspecialchars($joueur['prenom']) ?>
                </td>
                <td><?= htmlspecialchars($joueur['numero_licence']) ?></td>
                <td><?= htmlspecialchars($joueur['preferred_poste'] ?? 'Non défini') ?></td>
                <td>
                    <span class="badge 
                        <?= $joueur['statut'] == 'Actif' ? 'bg-success' : 
                           ($joueur['statut'] == 'Blessé' ? 'bg-danger' : 'bg-warning') ?>">
                        <?= htmlspecialchars($joueur['statut']) ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?page=joueurs&action=edit&id=<?= $joueur['id_joueur'] ?>" class="btn btn-sm btn-warning">Modif</a>
                    <a href="index.php?page=joueurs&action=delete&id=<?= $joueur['id_joueur'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce joueur ?');">
                       Suppr
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        
        <?php if (empty($joueurs)): ?>
            <tr>
                <td colspan="5" class="text-center">Aucun joueur enregistré.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>