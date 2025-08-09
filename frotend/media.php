<?php
include '../db.php';

$stmt = $pdo->query("SELECT * FROM media ORDER BY date_upload DESC");
$medias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Médias - Code de la Route</title>
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
      color: #222;
    }
    .content-wrapper {
      background-color: rgba(255,255,255,0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      margin-bottom: 50px;
    }
    .navbar-brand, .nav-link {
      font-weight: 600;
      font-size: 1.1rem;
    }
    .nav-link.active {
      font-weight: 700;
      color: #0d6efd !important;
    }
    .media-card img,
    .media-card video,
    .media-card iframe {
      object-fit: cover;
      height: 250px;
      width: 100%;
      border-top-left-radius: 0.375rem;
      border-top-right-radius: 0.375rem;
    }

    @media (max-width: 767.98px) {
      .media-card img,
      .media-card video,
      .media-card iframe {
        height: 180px;
      }
    }

    @media (max-width: 575.98px) {
      .media-card img,
      .media-card video,
      .media-card iframe {
        height: 150px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto fs-5">
        <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
        <li class="nav-item"><a href="cours.php" class="nav-link">Cours</a></li>
        <li class="nav-item"><a href="media.php" class="nav-link active">Médias</a></li>
        <li class="nav-item"><a href="qcm.php" class="nav-link">QCM</a></li>
      
        <li class="nav-item"><a href="../login.php" class="nav-link">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container content-wrapper">
  <h2 class="mb-4">Nos Médias</h2>

  <div class="row">
    <?php foreach ($medias as $m): ?>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="card media-card shadow-sm h-100">
          <?php 
          $path = "../assets/uploads/" . $m['fichier'];

          if ($m['type'] === 'image'): ?>
            <img src="<?= htmlspecialchars($path) ?>" alt="<?= htmlspecialchars($m['titre']) ?>" class="card-img-top" />
          
          <?php elseif ($m['type'] === 'video'): ?>
            <video controls>
              <source src="<?= htmlspecialchars($path) ?>" type="video/mp4" />
              Votre navigateur ne supporte pas la vidéo.
            </video>

          <?php elseif ($m['type'] === 'pdf'): ?>
            <iframe src="<?= htmlspecialchars($path) ?>" style="height: 250px;" frameborder="0"></iframe>

          <?php else: ?>
            <div class="text-center p-3">Type inconnu</div>
          <?php endif; ?>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($m['titre']) ?></h5>
            <p class="text-muted small mb-1"><strong>Date :</strong> <?= htmlspecialchars($m['date_upload']) ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
