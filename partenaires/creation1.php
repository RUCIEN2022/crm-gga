
<?php 
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {//si on ne trouve aucun utilisateur
    header("Location: ../login/"); // on redirige vers la page de connexion si non connecté
    exit();
}

// Récupération des données utilisateur
$userId = $_SESSION['user_id'];
$userEmail = $_SESSION['email'];
$userNom = $_SESSION['nom'];
$userPrenom = $_SESSION['prenom'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partenaire Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
            font-size: 12px;
        }
        /* Effet de tremblement (shake) */
@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-2px);
    }
    50% {
        transform: translateX(2px);
    }
    75% {
        transform: translateX(-1px);
    }
}

/* Effet de pulsation (pulse) */
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Animation pour la notification */
.animate-notification {
    animation: pulse 1.5s infinite; /* Remplacez `pulse` par `shake` pour l'effet tremblement */
}

.text-orange {
    color:rgb(240, 235, 235); /* Orange */
}

.bg-orange {
    background-color: #d71828; /* Orange */
}
        .form-section {
           
            border-top: 2px solid #dee2e6;
            margin-top: 20px;
            padding-top: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
            <?php include_once('topbar.php'); ?>
            <!-- Cards -->
            <div class="container mt-2">
            <h5 class=" mb-4">Partenaire/Création</h5>
        <div class="card shadow">
            <div class="card-body">
            <form id="partenaireForm">
      
            <!-- Section 1 -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="denomination" class="form-label">Dénomination sociale</label>
                    <input type="text" class="form-control" id="denomination" name ="denomination">
                </div>
                <div class="col-md-4">
                    <label for="pays" class="form-label">Pays</label>
                    <select name="pays" id="pays" class="form-select">
                            <option value="">--choisir--</option>
                            <option value="RDC">RDC</option>
                        </select>
                </div>
                <div class="col-md-4">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control" id="ville">
                </div>
                <div class="col-md-4">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse">
                </div>
                <div class="col-md-4">
                    <label for="codeInterne" class="form-label">Code interne</label>
                    <input type="text" class="form-control" id="codeInterne">
                </div>
                <div class="col-md-4">
                    <label for="idNat" class="form-label">Id. Nat</label>
                    <input type="text" class="form-control" id="idNat">
                </div>
                <div class="col-md-4">
                    <label for="rccm" class="form-label">RCCM</label>
                    <input type="text" class="form-control" id="rccm">
                </div>
                <div class="col-md-4">
                    <label for="numeroImpot" class="form-label">Numéro Impôt</label>
                    <input type="text" class="form-control" id="numeroImpot">
                </div>
                <div class="col-md-4">
                    <label for="emailEntreprise" class="form-label">Email entreprise</label>
                    <input type="email" class="form-control" id="emailEntreprise">
                </div>
                <div class="col-md-4">
                    <label for="telephoneEntreprise" class="form-label">Téléphone entreprise</label>
                    <input type="text" class="form-control" id="telephoneEntreprise">
                </div>
                <div class="col-md-4">
                    <label for="telephoneEntreprise" class="form-label">Nom Responsable</label>
                    <input type="text" class="form-control" id="nomRespo">
                </div>
                <div class="col-md-4">
                    <label for="telephoneEntreprise" class="form-label">E-mail Responsable</label>
                    <input type="email" class="form-control" id="emailRespo">
                </div>
                <div class="col-md-4">
                    <label for="telephoneRespo" class="form-label">Telephone Responsable</label>
                    <input type="text" class="form-control" id="telephoneRespo">
                </div>
                
            </div>

           

            <!-- Buttons -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2" id="SaveButton">Enregistrer</button>
                <button type="reset" class="btn btn-secondary">Annuler</button>
            </div>
        </form>
            </div>
        </div>
              
               
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script>
        // recuperation de valeur de zone de saisie
            const partenaireForm = document.getElementById("partenaireForm");
            const SaveButton = document.getElementById("SaveButton");
            const denominationInput = document.getElementById("denomination").value;
            const pays = document.getElementById("pays").value;
            const ville = document.getElementById("ville").value;
            const adresse = document.getElementById("adresse").value;
            const codeInterne = document.getElementById("codeInterne").value;
            const idNat = document.getElementById("idNat").value;
            const rccm = document.getElementById("rccm").value;
            const numeroImpot = document.getElementById("numeroImpot").value;
            const emailEntreprise = document.getElementById("emailEntreprise").value;
            const telephoneEntreprise = document.getElementById("telephoneEntreprise").value;
            const nomRespo = document.getElementById("nomRespo").value;
            const emailRespo = document.getElementById("emailRespo").value;
            const telephoneRespo = document.getElementById("telephoneEntreprise").value;
            const etatparte = 1;

            //evenement clique du formulaire

            partenaireForm.addEventListener("submit", async function (event){
                event.preventDefault();
                let isValid = true;
                //verification de zone vide
                if (denominationInput.value.trim() === "") {
                    denominationInput.classList.add("is-invalid");
                    isValid = false;
                } else {
                    denominationInput.classList.remove("is-invalid");
                }
                if (pays.value.trim() === "") {
                    pays.classList.add("is-invalid");
                    isValid = false;
                } else {
                    pays.classList.remove("is-invalid");
                }
                if (ville.value.trim() === "") {
                    ville.classList.add("is-invalid");
                    isValid = false;
                } else {
                    ville.classList.remove("is-invalid");
                }
                if (adresse.value.trim() === "") {
                    adresse.classList.add("is-invalid");
                    isValid = false;
                } else {
                    adresse.classList.remove("is-invalid");
                }
                if (codeInterne.value.trim() === "") {
                    codeInterne.classList.add("is-invalid");
                    isValid = false;
                } else {
                    codeInterne.classList.remove("is-invalid");
                }
                if (idNat.value.trim() === "") {
                    idNat.classList.add("is-invalid");
                    isValid = false;
                } else {
                    idNat.classList.remove("is-invalid");
                }
                if (rccm.value.trim() === "") {
                    rccm.classList.add("is-invalid");
                    isValid = false;
                } else {
                    rccm.classList.remove("is-invalid");
                }
                if (numeroImpot.value.trim() === "") {
                    numeroImpot.classList.add("is-invalid");
                    isValid = false;
                } else {
                    numeroImpot.classList.remove("is-invalid");
                }
                if (emailEntreprise.value.trim() === "") {
                    emailEntreprise.classList.add("is-invalid");
                    isValid = false;
                } else {
                    emailEntreprise.classList.remove("is-invalid");
                }
                if (telephoneEntreprise.value.trim() === "") {
                    telephoneEntreprise.classList.add("is-invalid");
                    isValid = false;
                } else {
                    telephoneEntreprise.classList.remove("is-invalid");
                }
                if (nomRespo.value.trim() === "") {
                    nomRespo.classList.add("is-invalid");
                    isValid = false;
                } else {
                    nomRespo.classList.remove("is-invalid");
                }
                if (emailRespo.value.trim() === "") {
                    emailRespo.classList.add("is-invalid");
                    isValid = false;
                } else {
                    emailRespo.classList.remove("is-invalid");
                }
                if (telephoneRespo.value.trim() === "") {
                    telephoneRespo.classList.add("is-invalid");
                    isValid = false;
                } else {
                    telephoneRespo.classList.remove("is-invalid");
                }
                if (!isValid) return;
                
                const requestData = {
                    denom_social: denominationInput.value.trim(),
                    pays_assu: pays.value.trim(),
                    ville_assu: ville.value.trim(),
                    adresse_assu: adresse.value.trim(),
                    code_interne: codeInterne.value.trim(),
                    numeroAgree: idNat.value.trim(),
                    Rccm: rccm.value.trim(),
                    numero_import: numeroImpot.value.trim(),
                    emailEntre: emailEntreprise.value.trim(),
                    telephone_Entr: telephoneEntreprise.value.trim(),
                    nomRespo: nomRespo.value.trim(),
                    emailRespo: emailRespo.value.trim(),
                    telephoneRespo: telephoneRespo.value.trim(),
                    etatpartenaire: 1

                };

                const simulateDelay = (ms) => new Promise(resolve => setTimeout(resolve, ms));
                await simulateDelay(3000);

                try{
                    // integration api
                    const response = await fetch("http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/create", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(requestData), // liaison donnee formulaire a l'api
                    });

                    const data = await response.json();
                    if (response.ok) {
                        // traitement ici
                        Swal.fire({
                            icon: "success",
                            title: "Partenaire enregistré!",
                        //  text: "Chargement tableau de bord...",
                        }).then(() => {
                            // Redirection
                            window.location.href = "../partenaires";
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Erreur",
                            text: data.message || "Une erreur est survenue.",
                        });
                    }

                }catch(error){
                    Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "Problème de connexion au serveur. Veuillez réessayer.",
                    });
                    console.error("Erreur API :", error);
                }

                   

            });
     
           
    </script>

</body>
</html>