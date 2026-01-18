<?php
$isEdit = isset($joueur); // Mode édition si joueur existe
?>

<form action="index.php?page=joueurs&action=save" method="post" class="row g-3">
    <?php if ($isEdit): ?>
        <input type="hidden" name="id" value="<?= $joueur['id_joueur'] ?>">
    <?php endif; ?>

    <div class="col-md-6">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required 
               value="<?= $isEdit ? $joueur['nom'] : '' ?>">
    </div>
    <div class="col-md-6">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" required 
               value="<?= $isEdit ? $joueur['prenom'] : '' ?>">
    </div>

    <div class="col-md-4">
        <label for="licence" class="form-label">Numéro de Licence</label>
        <input type="text" class="form-control" name="licence" required 
               value="<?= $isEdit ? $joueur['numero_licence'] : '' ?>">
    </div>
    <div class="col-md-4">
        <label for="date_naissance" class="form-label">Date de Naissance</label>
        <input type="date" class="form-control" name="date_naissance" required 
               value="<?= $isEdit ? $joueur['date_naissance'] : '' ?>">
    </div>
    <div class="col-md-4">
        <label for="statut" class="form-label">Statut Actuel</label>
        <select class="form-select" name="statut">
            <?php 
            $statuts = ['Actif', 'Blessé', 'Suspendu', 'Absent'];
            foreach ($statuts as $s): 
                $selected = ($isEdit && $joueur['statut'] == $s) ? 'selected' : '';
            ?>
                <option value="<?= $s ?>" <?= $selected ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="taille" class="form-label">Taille (cm)</label>
        <input type="number" class="form-control" name="taille" 
               value="<?= $isEdit ? $joueur['taille'] : '' ?>">
    </div>
    <div class="col-md-3">
        <label for="poids" class="form-label">Poids (kg)</label>
        <input type="number" step="0.1" class="form-control" name="poids" 
               value="<?= $isEdit ? $joueur['poids'] : '' ?>">
    </div>
    
    <div class="col-12">
        <label for="commentaire" class="form-label">Commentaire / Note Coach</label>
        <textarea class="form-control" name="commentaire" rows="3"><?= $isEdit ? $joueur['commentaire'] : '' ?></textarea>
    </div>

    <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary">
            <?= $isEdit ? 'Mettre à jour' : 'Enregistrer le joueur' ?>
        </button>
        <a href="index.php?page=joueurs&action=liste" class="btn btn-secondary">Annuler</a>
    </div>
</form>