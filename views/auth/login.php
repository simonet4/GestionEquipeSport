<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">Connexion</div>
            <div class="card-body">
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form action="index.php?page=auth&action=check" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>
        <div class="mt-3 text-center text-muted">
            <small>Login par défaut : admin / admin</small>
        </div>
    </div>
</div>