<?php
session_start();
include '../db.php';






// Gestion modification profil
if (isset($_POST['modifier'])) {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    
    // Upload photo profil
    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['photo_profil']['name'];
        $fileTmp = $_FILES['photo_profil']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowed)) {
            $newFileName = 'profile_' . $id . '.' . $fileExt;
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uploadPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmp, $uploadPath)) {
                // Mise à jour chemin photo en DB
                $stmtPhoto = $pdo->prepare("UPDATE utilisateurs SET photo_profil = ? WHERE id = ?");
                $stmtPhoto->execute([$newFileName, $id]);
                $user['photo_profil'] = $newFileName;
            } else {
                $error .= "Erreur lors du téléchargement de la photo.<br>";
            }
        } else {
            $error .= "Extension de fichier non autorisée.<br>";
        }
    }

    // Mise à jour prénom, nom, email
    $stmtUpdate = $pdo->prepare("UPDATE utilisateurs SET prenom = ?, nom = ?, email = ? WHERE id = ?");
    if ($stmtUpdate->execute([$prenom, $nom, $email, $id])) {
        $success = "Profil mis à jour avec succès.";
        $user['prenom'] = $prenom;
        $user['nom'] = $nom;
        $user['email'] = $email;
    } else {
        $error .= "Erreur lors de la mise à jour des informations.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Mon profil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
  .profile-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #0d6efd;
  }
</style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
        <li class="nav-item"><a href="cours.php" class="nav-link">Cours</a></li>
        <li class="nav-item"><a href="media.php" class="nav-link">Médias</a></li>
        <li class="nav-item"><a href="qcm.php" class="nav-link">QCM</a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link active">Compte</a></li>
        <li class="nav-item"><a href="../login.php" class="nav-link">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5" style="max-width: 600px;">
    <h2>Mon Profil</h2>

    <?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="mb-4 text-center">
      <img src="uploads/<?= htmlspecialchars($user['photo_profil'] ?? 'default.jpg') ?>" alt="Photo profil" class="profile-img" />
    </div>

    <form method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required value="<?= htmlspecialchars($user['prenom']) ?>">
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required value="<?= htmlspecialchars($user['nom']) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
        </div>
        <div class="mb-3">
            <label for="photo_profil" class="form-label">Photo de profil (jpg, png, gif)</label>
            <input type="file" name="photo_profil" id="photo_profil" class="form-control" accept=".jpg,.jpeg,.png,.gif">
        </div>
        <button type="submit" name="modifier" class="btn btn-primary w-100">Modifier mon profil</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
