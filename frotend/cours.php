<?php 
include '../db.php';

$stmt = $pdo->query("SELECT * FROM cours ORDER BY id DESC");
$cours = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Cours - Code de la Route</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('faby.jpg');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      min-height: 100vh;
      position: relative;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Overlay mba hanatsarana famakiana */
    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(255,255,255,0.9);
      z-index: 0;
    }

    .content-wrapper {
      position: relative;
      z-index: 1;
      padding: 30px;
      max-width: 900px;
      margin: auto;
      border-radius: 12px;
    }

    h2 {
      font-weight: 700;
      color: #0d6efd;
      margin-bottom: 30px;
      text-align: center;
      text-transform: uppercase;
    }

    .list-group-item {
      border: 1px solid #ddd;
      border-radius: 10px;
      margin-bottom: 15px;
      transition: all 0.3s ease-in-out;
    }

    .list-group-item:hover {
      background-color: #f0f8ff;
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .list-group-item h5 {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .list-group-item p {
      font-size: 1rem;
      color: #444;
    }

    .navbar-brand, .nav-link {
      font-weight: 600;
    }

    .nav-link.active {
      font-weight: 700;
      color: #fff !important;
    }

    @media (max-width: 768px) {
      .content-wrapper {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
        <li class="nav-item"><a href="cours.php" class="nav-link active">Cours</a></li>
        <li class="nav-item"><a href="media.php" class="nav-link">Médias</a></li>
        <li class="nav-item"><a href="qcm.php" class="nav-link">QCM</a></li>
     
        <li class="nav-item"><a href="../login.php" class="nav-link">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenu -->
<div class="container content-wrapper mt-5 mb-5">
  <h2>Nos cours</h2>

  <?php if (!$cours): ?>
      <p class="text-center text-muted">Aucun cours disponible pour le moment.</p>
  <?php else: ?>
      <div class="list-group">
          <?php foreach ($cours as $c): ?>
              <a href="#" class="list-group-item list-group-item-action">
                  <h5><?= htmlspecialchars($c['titre']) ?></h5>
                  <p><?= nl2br(htmlspecialchars($c['contenu'])) ?></p>
              </a>
          <?php endforeach; ?>
      </div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
