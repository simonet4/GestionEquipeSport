<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Équipe Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <?php if (isset($_SESSION['user'])): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Coach Assistant</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage ?? '') == 'joueurs' ? 'active' : '' ?>" href="index.php?page=joueurs&action=liste">Joueurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage ?? '') == 'matchs' ? 'active' : '' ?>" href="index.php?page=matchs&action=liste">Matchs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage ?? '') == 'stats' ? 'active' : '' ?>" href="index.php?page=stats">Statistiques</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a href="index.php?page=profile&action=index" class="btn btn-outline-primary btn-sm me-2">Profil</a>
                    <a href="index.php?page=auth&action=logout" class="btn btn-danger btn-sm">Déconnexion</a>
                </span>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <div class="container">
        <?php 
            if (isset($titre)) echo "<h2>$titre</h2><hr>";
            
            if (isset($vue)) include $vue; 
        ?>
    </div>

    <footer class="text-center mt-5 py-3 text-muted">
        <small>&copy; 2026 - Gestion d'équipe sportive - Projet R3.01</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>