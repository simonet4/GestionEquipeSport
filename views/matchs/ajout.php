<form action="" method="post" class="row g-3">
    <div class="col-md-6">
        <label for="date" class="form-label">Date du match</label>
        <input type="date" class="form-control" name="date" required>
    </div>
    <div class="col-md-6">
        <label for="heure" class="form-label">Heure</label>
        <input type="time" class="form-control" name="heure" required>
    </div>
    <div class="col-md-8">
        <label for="adversaire" class="form-label">Équipe adverse</label>
        <input type="text" class="form-control" name="adversaire" required>
    </div>
    <div class="col-md-4">
        <label for="lieu" class="form-label">Lieu</label>
        <select class="form-select" name="lieu">
            <option value="Domicile">Domicile</option>
            <option value="Exterieur">Extérieur</option>
        </select>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Planifier le match</button>
        <a href="index.php?page=matchs&action=liste" class="btn btn-secondary">Annuler</a>
    </div>
</form>