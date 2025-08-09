
 <!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Plateforme Code de la Route</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-brand {
      font-size: 1.8rem;
      font-weight: bold;
    }

    .nav-link {
      font-size: 1.2rem;
    }

    .hero-section {
      min-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .hero-container {
      border: 3px solid #0d6efd;
      border-radius: 10px;
      padding: 30px;
      background-color: white;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    .hero-img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .hero-text {
      padding: 20px;
    }

    h1 {
      font-size: 2rem;
      color: #0d6efd;
    }

    p {
      font-size: 1.2rem;
      color: #333;
    }

    /* Footer styles */
    footer {
      background-color: #222;
      color: #eee;
      padding: 40px 0;
      margin-top: 60px;
    }

    footer h5 {
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      font-weight: 600;
      color: #f0f0f0;
      border-bottom: 2px solid #555;
      padding-bottom: 0.3rem;
    }

    footer p {
      font-size: 1rem;
      margin-bottom: 1rem;
      line-height: 1.6;
    }

    footer p strong {
      color: #bbb;
      width: 100px;
      display: inline-block;
    }

    footer p i {
      font-size: 1.2rem;
      vertical-align: middle;
      color: #0d6efd;
      margin-left: 8px;
    }

    footer p a {
      color: #eee;
      transition: color 0.3s ease;
      text-decoration: underline;
      margin-left: 5px;
    }

    footer p a:hover {
      color: #0d6efd;
      text-decoration: none;
    }

    form label {
      font-weight: 600;
      color: #333;
    }

    form input.form-control,
    form textarea.form-control {
      border-radius: 5px;
      border: 1px solid #ccc;
      transition: border-color 0.3s ease;
    }

    form input.form-control:focus,
    form textarea.form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
      outline: none;
    }

    .btn-light {
      background-color: #0d6efd;
      color: white !important;
      font-weight: 600;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn-light:hover {
      background-color: #084cdf;
      color: white !important;
      text-decoration: none;
    }

    hr {
      border-color: rgba(255, 255, 255, 0.15);
    }

    .text-primary {
      color: #0d6efd !important;
    }
    @media (max-width: 768px) {
  .hero-container {
    flex-direction: column;
    text-align: center;
    padding: 20px;
  }

  .hero-text {
    padding: 15px 0;
  }

  h1 {
    font-size: 1.5rem;
  }

  p {
    font-size: 1rem;
  }

  footer h5 {
    font-size: 1.2rem;
  }

  footer p {
    font-size: 0.95rem;
  }

  iframe {
    height: 200px;
  }
}

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Code Route</a>
    <ul class="navbar-nav ms-auto">
    <li class="nav-item"><a href="index.php" class="nav-link">Acceuil</a></li>
      <li class="nav-item"><a href="cours.php" class="nav-link">Cours</a></li>
      <li class="nav-item"><a href="media.php" class="nav-link">Médias</a></li>
      <li class="nav-item"><a href="qcm.php" class="nav-link">QCM</a></li>
   
      <li class="nav-item"><a href="../login.php" class="nav-link">Admin</a></li>
    </ul>
  </div>
</nav>

<!-- Contenu principal -->
<div class="container hero-section">
  <div class="row justify-content-center align-items-center hero-container">
    <!-- Image -->
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="cours-conduitefr.jpg" alt="Image Code de la Route" class="img-fluid hero-img" />
    </div>

    <!-- Texte -->
    <div class="col-md-6 hero-text">
      <h1 class="text-primary mb-4">TONGASOA ETO AMIN'NY PLATEFORME FIANARANA CODE DE LA ROUTE</h1>
      <p>Ilaina ny mahay sy mahalala ny lalàna mifehy ny fifamoivoizana mba hisorohana loza sy hananana fihetsika mendrika eny an-dalana.</p>
      <p>Mampirisika anao izahay hianatra sy handalina izany amin'ny alalan'ity sehatra ity.</p>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row gy-4">
      <!-- Contact Info -->
      <div class="col-md-5">
        <h5>Contactez-nous</h5>
        <p>
          <strong>Email :</strong>
          <i class="bi bi-envelope-fill"></i>
          <a href="mailto:fabiennirina33@gmail.com">fabiennirina33@gmail.com</a>
        </p>
        <p>
          <strong>Téléphone :</strong>
          <i class="bi bi-telephone-fill"></i>
          <a href="tel:+0346536897">0346536897</a>
        </p>
        <p>
          <strong>Facebook :</strong>
          <a href="https://facebook.com/fabien.andriamanampisoa" target="_blank">
            <i class="bi bi-facebook"></i> Fabien Andriamanampisoa
          </a>
        </p>
        <p>
          <strong>Instagram :</strong>
          <a href="https://instagram.com/nirinafabien" target="_blank">
            <i class="bi bi-instagram"></i> Nirina Fabien
          </a>
        </p>
      </div>

      <!-- Contact Form -->
      <div class="col-md-7">
        <h5>Envoyez-nous un message</h5>
        <form action="send_mail.php" method="post" class="text-dark">
          <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" id="name" name="name" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" id="email" name="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-light text-primary">Envoyer</button>
        </form>
      </div>
    </div>

    <hr />

    <!-- Google Map Embed -->
    <div class="row mt-4">
      <div class="col-12">
        <h5>Notre localisation</h5>
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7876.122367104234!2d47.0875045!3d-21.4546147!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21e7bec0717f0aab%3A0xbab89234313f05ed!2sFianarantsoa!5e0!3m2!1sfr!2smg!4v1691514000000!5m2!1sfr!2smg" 
          width="100%" 
          height="300" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

    <p class="text-center small mt-3">&copy; 2025 Plateforme Code de la Route. Tous droits réservés.</p>
  </div>
</footer>