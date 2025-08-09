<?php 
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion des QCM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    textarea, input[type="text"] {
      font-size: 0.95rem;
    }
    @media (max-width: 576px) {
      h2 {
        font-size: 1.3rem;
      }
      .table-responsive {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
       
        <li class="nav-item"><a href="cours.php" class="nav-link">Géner les Cours</a></li>
        <li class="nav-item"><a href="qcm.php" class="nav-link">Géner les QCM</a></li>
        <li class="nav-item"><a href="media.php" class="nav-link active">Géner les média</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link btn btn-danger text-white ms-lg-2">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2 class="mb-4 text-center">📝 Gestion des QCM</h2>

  <!-- FORMULAIRE QCM -->
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="id" value="<?= $_POST['id'] ?? '' ?>">

        <div class="mb-3">
          <label class="form-label">Question</label>
          <textarea class="form-control" name="question" rows="2" required><?= $_POST['question'] ?? '' ?></textarea>
        </div>

        <div class="row g-3">
          <div class="col-md-4 col-sm-12">
            <label class="form-label">Choix 1</label>
            <input type="text" class="form-control" name="choix1" value="<?= $_POST['choix1'] ?? '' ?>" required>
          </div>
          <div class="col-md-4 col-sm-12">
            <label class="form-label">Choix 2</label>
            <input type="text" class="form-control" name="choix2" value="<?= $_POST['choix2'] ?? '' ?>" required>
          </div>
          <div class="col-md-4 col-sm-12">
            <label class="form-label">Choix 3</label>
            <input type="text" class="form-control" name="choix3" value="<?= $_POST['choix3'] ?? '' ?>" required>
          </div>
        </div>

        <div class="mb-3 mt-3">
          <label class="form-label">Bonne réponse</label>
          <input type="text" class="form-control" name="reponse" value="<?= $_POST['reponse'] ?? '' ?>" required>
        </div>

        <div class="d-flex flex-wrap gap-2">
          <button type="submit" name="save" class="btn btn-success">
            <?= isset($_POST['id']) ? '🛠 Modifier' : '💾 Enregistrer' ?>
          </button>
          <a href="?" class="btn btn-secondary">➕ Nouveau</a>
        </div>
      </form>
    </div>
  </div>

  <?php
  // Enregistrement ou mise à jour
  if (isset($_POST['save'])) {
      if (!empty($_POST['id'])) {
          $stmt = $pdo->prepare("UPDATE qcm SET question=?, choix1=?, choix2=?, choix3=?, reponse=? WHERE id=?");
          $stmt->execute([$_POST['question'], $_POST['choix1'], $_POST['choix2'], $_POST['choix3'], $_POST['reponse'], $_POST['id']]);
      } else {
          $stmt = $pdo->prepare("INSERT INTO qcm (question, choix1, choix2, choix3, reponse) VALUES (?, ?, ?, ?, ?)");
          $stmt->execute([$_POST['question'], $_POST['choix1'], $_POST['choix2'], $_POST['choix3'], $_POST['reponse']]);
      }
      header("Location: ".$_SERVER['PHP_SELF']);
      exit;
  }

  // Suppression
  if (isset($_GET['delete'])) {
      $pdo->prepare("DELETE FROM qcm WHERE id=?")->execute([$_GET['delete']]);
      header("Location: ".$_SERVER['PHP_SELF']);
      exit;
  }
  ?>

  <!-- TABLEAU LISTE QCM -->
  <div class="card">
    <div class="card-body">
      <h4 class="card-title mb-3">📋 Liste des QCM</h4>
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Question</th>
              <th>Bonne Réponse</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pdo->query("SELECT * FROM qcm ORDER BY id DESC") as $q): ?>
              <tr>
                <td><?= $q['id'] ?></td>
                <td><?= htmlspecialchars($q['question']) ?></td>
                <td><?= htmlspecialchars($q['reponse']) ?></td>
                <td class="text-nowrap">
                  <form method="POST" class="d-inline">
                    <input type="hidden" name="id" value="<?= $q['id'] ?>">
                    <input type="hidden" name="question" value="<?= htmlspecialchars($q['question']) ?>">
                    <input type="hidden" name="choix1" value="<?= htmlspecialchars($q['choix1']) ?>">
                    <input type="hidden" name="choix2" value="<?= htmlspecialchars($q['choix2']) ?>">
                    <input type="hidden" name="choix3" value="<?= htmlspecialchars($q['choix3']) ?>">
                    <input type="hidden" name="reponse" value="<?= htmlspecialchars($q['reponse']) ?>">
                    <button name="edit" class="btn btn-sm btn-warning mb-1">✏️</button>
                  </form>
                  <a href="?delete=<?= $q['id'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Supprimer ce QCM ?')">🗑</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
