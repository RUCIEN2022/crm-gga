
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
})
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
    const response = await fetch("http://localhost/crm-gga/app/codes/api/v1/api_user.php/login", {
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