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
      <h3 class="text-center mb-4" style="color: #923a4d;">CRM-Login</h3>
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
          <button type="submit" id="loginButton" class="btn btn-danger w-100">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="button-text">Connexion</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const loginForm = document.getElementById("loginForm");
    const loginButton = document.getElementById("loginButton");
    const spinner = loginButton.querySelector(".spinner-border");
    const buttonText = loginButton.querySelector(".button-text");
    const passwordInput = document.getElementById("motpasse");
    const emailInput = document.getElementById("email");
    const togglePassword = document.getElementById("togglePassword");
    const toggleIcon = document.getElementById("toggleIcon");


    togglePassword.addEventListener("click", function () {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
      }
    });
/*
    loginForm.addEventListener("submit", async function (event) {
      event.preventDefault();

      let isValid = true;
      if (emailInput.value.trim() === "") {
        emailInput.classList.add("is-invalid");
        isValid = false;
      } else {
        emailInput.classList.remove("is-invalid");
      }
      if (passwordInput.value.trim() === "") {
        passwordInput.classList.add("is-invalid");
        isValid = false;
      } else {
        passwordInput.classList.remove("is-invalid");
      }
      if (!isValid) return;

      loginButton.disabled = true;
      spinner.style.display = "inline-block";
      buttonText.textContent = "Connexion...";

      //appels des variables du formulaires
      const requestData = {
        email: emailInput.value.trim(),
        motpasse: passwordInput.value.trim(),
      };
      //fixation du delai d'attente en milliseconde (ms)
      const simulateDelay = (ms) => new Promise(resolve => setTimeout(resolve, ms));
      await simulateDelay(3000);

      try {
        //Appel API
       // const response = await fetch("https://www.gga-crm.com/app/codes/api/users.php/auth", {
        const response = await fetch("http://localhost/app-gga/app/codes/api/v1/users.php/auth", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(requestData),
        });
        const data = await response.json();

        if (response.ok) {
          Swal.fire({
            icon: "success",
            title: "Connexion réussie",
            text: "Chargement tableau de bord...",
          }).then(() => {
            window.location.href = "../dashboard";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Erreur",
            text: data.message || "Une erreur est survenue.",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Problème de connexion au serveur. Veuillez réessayer.",
        });
        console.error("Erreur API :", error);
      } finally {
        loginButton.disabled = false;
        spinner.style.display = "none";
        buttonText.textContent = "Connexion";
      }
    });
    */
  loginForm.addEventListener("submit", async function (event) {
      event.preventDefault();

      let isValid = true;
      if (emailInput.value.trim() === "") {
        emailInput.classList.add("is-invalid");
        isValid = false;
      } else {
        emailInput.classList.remove("is-invalid");
      }
      if (passwordInput.value.trim() === "") {
        passwordInput.classList.add("is-invalid");
        isValid = false;
      } else {
        passwordInput.classList.remove("is-invalid");
      }
      if (!isValid) return;

      loginButton.disabled = true;
      spinner.style.display = "inline-block";
      buttonText.textContent = "Connexion...";

      const requestData = {
        email: emailInput.value.trim(),
        motpasse: passwordInput.value.trim(),
      };
      const simulateDelay = (ms) => new Promise(resolve => setTimeout(resolve, ms));
      await simulateDelay(3000);
      try {
        const response = await fetch("http://localhost:8080/crm-gga/app/codes/api/v1/api_user.php/login", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(requestData),
        });
        const data = await response.json();

        if (response.ok) {
          // traitement ici
          Swal.fire({
            icon: "success",
            title: "Vous êtes connecté!",
          //  text: "Chargement tableau de bord...",
          }).then(() => {
            // Redirection
            window.location.href = "../dashboard";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Erreur",
            text: data.message || "Une erreur est survenue.",
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Problème de connexion au serveur. Veuillez réessayer.",
        });
        console.error("Erreur API :", error);
      } finally {
        loginButton.disabled = false;
        spinner.style.display = "none";
        buttonText.textContent = "Connexion";
      }
});
  </script>
</body>
</html>
