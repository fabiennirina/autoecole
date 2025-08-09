<?php
session_start();
include '../db.php'; // Atsofohy eto ny connexion PDO anao

$errorLogin = '';
$errorRegister = '';

// Raha efa tafiditra, alefa any index.php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Gestion inscription
if (isset($_POST['register'])) {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($prenom == '' || $nom == '' || $email == '' || $password == '') {
        $errorRegister = "Veuillez remplir tous les champs pour l'inscription.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Vérifier si email existe déjà
        $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $errorRegister = "Cet email est déjà utilisé.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$prenom, $nom, $email, $hashedPassword])) {
                $_SESSION['user_id'] = $pdo->lastInsertId();
                header("Location: index.php");
                exit;
            } else {
                $errorRegister = "Erreur lors de l'inscription.";
            }
        }
    }
}

// Gestion login
if (isset($_POST['login'])) {
    $email = trim($_POST['email_login']);
    $password = $_POST['password_login'];

    if ($email == '' || $password == '') {
        $errorLogin = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $errorLogin = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Connexion / Inscription</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 450px;">
    <div class="card shadow-sm">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="authTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= ($errorLogin || (!$errorRegister && !isset($_POST['register']))) ? 'active' : '' ?>" 
                            id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $errorRegister ? 'active' : '' ?>" 
                            id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Inscription</button>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content" id="authTabsContent">
            <!-- Login Tab -->
            <div class="tab-pane fade <?= ($errorLogin || (!$errorRegister && !isset($_POST['register']))) ? 'show active' : '' ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                <?php if ($errorLogin): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorLogin) ?></div>
                <?php endif; ?>
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="email_login" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_login" name="email_login" required autofocus
                               value="<?= isset($_POST['email_login']) ? htmlspecialchars($_POST['email_login']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password_login" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password_login" name="password_login" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>

            <!-- Register Tab -->
            <div class="tab-pane fade <?= $errorRegister ? 'show active' : '' ?>" id="register" role="tabpanel" aria-labelledby="register-tab">
                <?php if ($errorRegister): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorRegister) ?></div>
                <?php endif; ?>
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required
                               value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required
                               value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  <?php if ($errorLogin || (!$errorRegister && !isset($_POST['register']))): ?>
    var triggerEl = document.querySelector('#login-tab');
    var tab = new bootstrap.Tab(triggerEl);
    tab.show();
  <?php elseif ($errorRegister): ?>
    var triggerEl = document.querySelector('#register-tab');
    var tab = new bootstrap.Tab(triggerEl);
    tab.show();
  <?php endif; ?>
});
</script>

</body>
</html>
