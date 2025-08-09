<?php
require 'db.php';
session_start();

// Vérifier si admin connecté
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Enregistrement (insert ou update)
if (isset($_POST['save'])) {
    $titre = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $id = $_POST['id'] ?? '';

    if (!empty($titre)) {
        if (!empty($id)) {
            $sql = "UPDATE cours SET titre=?, contenu=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $contenu, $id]);
        } else {
            $sql = "INSERT INTO cours (titre, contenu) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $contenu]);
        }
    }
}

// Suppression
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM cours WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header('Location: cours.php');
    exit;
}

// Préremplissage si modification
$titre = $_POST['titre'] ?? '';
$contenu = $_POST['contenu'] ?? '';
$id = $_POST['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Cours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="nav-link text-white"><?= htmlspecialchars($_SESSION['admin']) ?></span>
                </li>
                <li class="nav-item"><a class="nav-link" href="cours.php">Gérer les cours</a></li>
                <li class="nav-item"><a class="nav-link" href="qcm.php">Gérer les QCM</a></li>
                <li class="nav-item"><a class="nav-link" href="media.php">Gérer les médias</a></li>
                <li class="nav-item"><a class="btn btn-danger btn-sm ms-2" href="logout.php">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h2 class="mb-4 text-center text-primary">Gestion des Cours</h2>

    <!-- Formulaire -->
    <div class="card shadow mb-5">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                <div class="col-md-6">
                    <label class="form-label">Titre du cours</label>
                    <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($titre) ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Contenu</label>
                    <textarea name="contenu" class="form-control" rows="4"><?= htmlspecialchars($contenu) ?></textarea>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" name="save" class="btn btn-success">
                        <i class="bi bi-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des cours -->
    <h4 class="mb-3">Liste des Cours</h4>
    <div class="table-responsive shadow">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cours = $pdo->query("SELECT * FROM cours ORDER BY id DESC");
                foreach ($cours as $c):
                ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['titre']) ?></td>
                    <td class="text-center">
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <input type="hidden" name="titre" value="<?= htmlspecialchars($c['titre']) ?>">
                            <input type="hidden" name="contenu" value="<?= htmlspecialchars($c['contenu']) ?>">
                            <button type="submit" class="btn btn-sm btn-warning">Modifier</button>
                        </form>
                        <a href="?delete=<?= $c['id'] ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer ce cours ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
