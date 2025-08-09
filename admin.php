<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><span class="nav-link"> <?= htmlspecialchars($_SESSION['admin']) ?></span></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="cours.php">Gérer les cours</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="qcm.php">Gérer les QCM</a></li>
        <li class="nav-item"><a class="nav-link btn btn-danger text-white ms-2" href="media.php">Gérer les médias</a></li>

        <li class="nav-item">
    <a class="nav-link btn btn-danger text-white ms-2" 
       href="logout.php" 
       onclick="return confirm('Voulez-vous vraiment vous déconnecter ?');">
       Déconnexion
    </a>
</li>

      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
