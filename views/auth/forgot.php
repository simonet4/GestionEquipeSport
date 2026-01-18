<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Mot de passe oublié</h2>
            <?php if (isset($message)): ?>
                <div class="alert alert-<?= strpos($message, 'réinitialisé') !== false ? 'success' : 'danger' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            <form action="index.php?page=auth&action=reset" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Entrez votre email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="submit" class="btn btn-primary">Réinitialiser</button>
                <a href="index.php?page=auth&action=login" class="btn btn-link">Retour à la connexion</a>
            </form>
        </div>
    </div>
</div>