<?php
include '../db.php';

$stmt = $pdo->query("SELECT * FROM qcm ORDER BY id ASC");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QCM - Testez vos connaissances</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url('faby.jpg');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      color: #222;
    }
    .content-wrapper {
      background-color: rgba(255,255,255,0.9);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.25);
    }
    .navbar-brand, .nav-link {
      font-weight: 600;
    }
    .nav-link.active {
      font-weight: 700;
      color: #ffc107 !important;
    }
    @media (max-width: 576px) {
      h5 {
        font-size: 1rem;
      }
    }
  </style>
  <script>
    function verifierReponse(id) {
      const reponseJuste = document.getElementById('reponse-' + id).value;
      const choixs = document.getElementsByName('choix-' + id);
      let reponseUtilisateur = null;

      for (let i = 0; i < choixs.length; i++) {
        if (choixs[i].checked) {
          reponseUtilisateur = choixs[i].value;
          break;
        }
      }

      const resultat = document.getElementById('resultat-' + id);
      if (reponseUtilisateur === null) {
        resultat.innerHTML = '<span class="text-warning">Veuillez sélectionner une réponse.</span>';
      } else if (reponseUtilisateur === reponseJuste) {
        resultat.innerHTML = '<span class="text-success">Bonne réponse !</span>';
      } else {
        resultat.innerHTML = '<span class="text-danger">Mauvaise réponse. La bonne réponse est : <strong>' + reponseJuste + '</strong>.</span>';
      }
    }
  </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
        <li class="nav-item"><a href="cours.php" class="nav-link">Cours</a></li>
        <li class="nav-item"><a href="media.php" class="nav-link">Médias</a></li>
        <li class="nav-item"><a href="qcm.php" class="nav-link active">QCM</a></li>
     
        <li class="nav-item"><a href="../login.php" class="nav-link">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="content-wrapper mb-5">
    <h2 class="mb-4 text-primary text-center">QCM - Testez vos connaissances</h2>

    <?php foreach ($questions as $q): ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h5><?= htmlspecialchars($q['question']) ?></h5>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="choix-<?= $q['id'] ?>" value="<?= htmlspecialchars($q['choix1']) ?>" id="q<?= $q['id'] ?>-1">
            <label class="form-check-label" for="q<?= $q['id'] ?>-1"><?= htmlspecialchars($q['choix1']) ?></label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="choix-<?= $q['id'] ?>" value="<?= htmlspecialchars($q['choix2']) ?>" id="q<?= $q['id'] ?>-2">
            <label class="form-check-label" for="q<?= $q['id'] ?>-2"><?= htmlspecialchars($q['choix2']) ?></label>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="choix-<?= $q['id'] ?>" value="<?= htmlspecialchars($q['choix3']) ?>" id="q<?= $q['id'] ?>-3">
            <label class="form-check-label" for="q<?= $q['id'] ?>-3"><?= htmlspecialchars($q['choix3']) ?></label>
          </div>

          <input type="hidden" id="reponse-<?= $q['id'] ?>" value="<?= htmlspecialchars($q['reponse']) ?>">
          <button class="btn btn-success btn-sm" onclick="verifierReponse(<?= $q['id'] ?>)">Valider</button>
          <p id="resultat-<?= $q['id'] ?>" class="mt-2"></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
