<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin'] = $admin['username'];
        header("Location: admin.php");
        exit;
    } else {
        $error = "Identifiants invalides";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('admin.jpg') no-repeat center center fixed;
            background-size: 890px auto;
            background-color: #f8f9fa;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
        /* Ampiakarina ambony ny login box */
        .login-container {
            margin-top: 95px; /* ahena na ampitombo arakaraka */
        }
    </style>
</head>
<body>
    
<div class="container vh-100 d-flex justify-content-center align-items-start login-container">
    <div class="card shadow-sm p-4" style="width: 350px;">
        <h3 class="mb-4 text-center">Connexion Admin</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" class="form-control" required autofocus />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required />
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
