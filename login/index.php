<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <style>
    body {
      background-color: #ffffff;
    }
    .card {
      border: 1px solid #923a4d;
      border-radius: 10px;
    }
    .btn-primary {
      background-color: rgb(146,58,77);
      border-color: #923a4d;
    }
    .btn-primary:hover {
      background-color: rgb(60, 5, 4);
      border-color: rgb(61, 7, 6);
    }
    .form-label, a {
      color: rgb(58, 4, 2);
    }
    a:hover {
      text-decoration: underline;
    }
    .spinner-border {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="mb-4 text-center">
      <img src="logo.png" alt="Logo CRM-GGA" class="img-fluid" style="max-width: 150px;">
    </div>
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
      <h3 class="text-center mb-4 fw-bold" style="color: #923a4d;">CRM-LOGIN</h3>
      <form id="loginForm" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
          <div class="invalid-feedback">Veuillez entrer votre email.</div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe</label>
          <div class="input-group">
            <input type="password" class="form-control" id="motpasse" name="motpasse" placeholder="Entrez votre mot de passe" required>
            <button class="btn btn-outline-danger" type="button" id="togglePassword">
              <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
          </div>
          <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
        </div>
        <div class="mb-3 text-end">
          <a href="../resetpwd/" id="forgotPasswordLink">Mot de passe oublié ?</a>
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" id="loginButton" class="btn w-100 text-light" style="background-color: #923a4d;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="button-text">Connexion</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../app/codes/machine/login.js"></script>
</body>
</html>
