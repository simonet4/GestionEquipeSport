<div class="container mt-5">
    <h2>Gestion du Profil</h2>
    <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form action="index.php?page=profile&action=update" method="post">
        <div class="mb-3">
            <label for="current_password" class="form-label">Mot de passe administrateur (requis pour modifications) V2</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login" value="<?php echo htmlspecialchars($user['login']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>