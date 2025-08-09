<?php
session_start();
require 'db.php';

// Vérification si admin connecté
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Upload fichier
if (isset($_POST['upload'])) {
    $titre = trim($_POST['titre'] ?? '');
    $type = $_POST['type'] ?? '';
    $nomFichier = $_FILES['fichier']['name'] ?? '';
    $tmp = $_FILES['fichier']['tmp_name'] ?? '';

    $extensionsAutorisees = [
        'image' => ['jpg', 'jpeg', 'png', 'gif'],
        'video' => ['mp4', 'webm', 'ogg'],
        'pdf'   => ['pdf']
    ];

    $ext = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));

    if ($titre && $type && isset($extensionsAutorisees[$type]) && in_array($ext, $extensionsAutorisees[$type])) {
        $nouveauNom = uniqid() . "." . $ext;
        $uploadPath = __DIR__ . "/assets/uploads/" . $nouveauNom;
        
        if (move_uploaded_file($tmp, $uploadPath)) {
            $stmt = $pdo->prepare("INSERT INTO media (titre, type, fichier) VALUES (?, ?, ?)");
            $stmt->execute([$titre, $type, $nouveauNom]);
            $message = '<div class="alert alert-success">✅ Fichier uploadé avec succès.</div>';
        } else {
            $message = '<div class="alert alert-danger">❌ Erreur lors de l\'upload.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">⚠️ Format de fichier non autorisé.</div>';
    }
}

// Suppression
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("SELECT fichier FROM media WHERE id=?");
    $stmt->execute([$id]);
    $fichier = $stmt->fetchColumn();
    $filePath = __DIR__ . "/assets/uploads/$fichier";

    if ($fichier && file_exists($filePath)) {
        unlink($filePath);
    }
    $pdo->prepare("DELETE FROM media WHERE id=?")->execute([$id]);
    $message = '<div class="alert alert-success">🗑️ Média supprimé avec succès.</div>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Gestion des Médias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><span class="nav-link"><?= htmlspecialchars($_SESSION['admin']) ?></span></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="cours.php">Gérer les cours</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="qcm.php">Gérer les QCM</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="media.php">Gérer les médias</a></li>
        <li class="nav-item"><a class="nav-link btn btn-warning text-dark ms-2" href="logout.php">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
  <?= $message ?>

  <h2 class="mb-4 text-center">📁 Upload Media</h2>

  <form method="POST" enctype="multipart/form-data" class="row g-3 mb-5">
    <div class="col-md-4 col-sm-12">
      <label class="form-label">Titre</label>
      <input type="text" name="titre" class="form-control" required>
    </div>
    <div class="col-md-4 col-sm-6">
      <label class="form-label">Type</label>
      <select name="type" class="form-select" required>
        <option value="">-- Choisir --</option>
        <option value="image">Image</option>
        <option value="video">Vidéo</option>
        <option value="pdf">PDF</option>
      </select>
    </div>
    <div class="col-md-4 col-sm-6">
      <label class="form-label">Fichier</label>
      <input type="file" name="fichier" class="form-control" required>
    </div>
    <div class="col-12 text-center">
      <button type="submit" name="upload" class="btn btn-success px-5">📤 Upload</button>
    </div>
  </form>

  <h3 class="mb-3 text-center">🗂️ Liste des Médias</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>Titre</th>
          <th>Type</th>
          <th>Aperçu</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pdo->query("SELECT * FROM media ORDER BY id DESC") as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['titre']) ?></td>
            <td><?= htmlspecialchars($m['type']) ?></td>
            <td>
              <?php if ($m['type'] === 'image'): ?>
                <img src="/auto/assets/uploads/<?= htmlspecialchars($m['fichier']) ?>" class="img-thumbnail" style="max-width: 100px;">
              <?php elseif ($m['type'] === 'video'): ?>
                <video controls style="max-width: 180px;">
                  <source src="/auto/assets/uploads/<?= htmlspecialchars($m['fichier']) ?>" type="video/mp4">
                </video>
              <?php elseif ($m['type'] === 'pdf'): ?>
                <a href="/auto/assets/uploads/<?= htmlspecialchars($m['fichier']) ?>" target="_blank" class="btn btn-outline-secondary btn-sm">📄 Voir PDF</a>
              <?php endif; ?>
            </td>
            <td>
              <a href="?delete=<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce média ?')">🗑️ Supprimer</a>
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
