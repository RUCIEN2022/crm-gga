<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 
  <style>
    body {
      background-color: #ffffff; /* Fond blanc */
    }

    .card {
      border: 1px solidrgb(172, 169, 169); /* Bordure rouge */
      border-radius: 10px;
    }

    .btn-primary {
      background-color:rgb(147, 16, 12); /* Rouge */
      border-color: #e3342f;
    }

    .btn-primary:hover {
      background-color:rgb(60, 5, 4); /* Rouge foncé */
      border-color:rgb(61, 7, 6);
    }

    .form-label {
      color:rgb(58, 4, 2); /* Rouge */
    }


    .spinner-border {
      display: none; /* Caché par défaut */
    }
  </style>
</head>
<body>
  <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
   
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 800px;">
      <h3 class="text-center mb-4" style="color:rgb(171, 16, 10)">Réinitialiser mot de passe</h3>
      <form id="loginForm" method="POST">
    
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
          <div class="invalid-feedback">Veuillez entrer votre email.</div>
        </div>
        
       
     
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" id="loginButton" class="btn btn-danger w-100">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="button-text">Envoyer</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const loginForm = document.getElementById("loginForm");
    const loginButton = document.getElementById("loginButton");
    const spinner = loginButton.querySelector(".spinner-border");
    const buttonText = loginButton.querySelector(".button-text");
    const emailInput = document.getElementById("email");

    
    loginForm.addEventListener("submit", async function (event) {
      event.preventDefault(); // Empêcher l'envoi par défaut

      // Réinitialiser les erreurs
      let isValid = true;

      if (emailInput.value.trim() === "") {
        emailInput.classList.add("is-invalid");
        isValid = false;
      } else {
        emailInput.classList.remove("is-invalid");
      }

      if (!isValid) return; // Arrêter si des champs sont vides

      // Activer le spinner et désactiver le bouton
      loginButton.disabled = true;
      spinner.style.display = "inline-block";
      buttonText.textContent = "Envoi...";

      // Simuler un délai réseau de 3 secondes
      const simulateDelay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

      // Préparer les données pour l'API
      const requestData = {
        email: emailInput.value.trim(),

      };

      try {
        await simulateDelay(3000); // Simuler un délai de réponse

        // Appeler l'API
       // const response = await fetch("https://www.gga-crm.com/app/codes/api/user_resetpwd.php", {
          const response = await fetch("http://localhost/app-gga/app/codes/api/v1/user_resetpwd.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(requestData),
        });

        const data = await response.json(); // Récupérer la réponse JSON

        if (response.ok) {
          // Connexion réussie
          alert("Connexion réussie !");
          window.location.href = "../login"; // appel login
        } else {
          // Afficher le message d'erreur de l'API
          alert(`Erreur : ${data.message}`);
        }
      } catch (error) {
        // Erreur réseau ou problème côté client
        alert("Une erreur est survenue. Veuillez réessayer.");
        console.error("Erreur API :", error);
      } finally {
        // Réinitialiser le bouton et cacher le spinner
        loginButton.disabled = false;
        spinner.style.display = "none";
        buttonText.textContent = "Envoyer";
      }
    });
  </script>
    <!-- Icones Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
