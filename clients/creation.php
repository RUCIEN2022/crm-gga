<?php 
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) { // si on ne trouve aucun utilisateur
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f4f4f9;
            font-size: 12px;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .spinner {
            display: none;
            margin-left: 10px;
        }
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 250px;
            padding: 15px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            display: none;
        }
        .toast.success {
            background-color: #4CAF50;
        }
        .toast.error {
            background-color: #d9534f;
        }
        .toast.show {
            display: block;
            animation: fadeIn 0.5s, fadeOut 0.5s 4s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-20px); }
        }
        .text-orange {
            color: #f0ebeb;
        }
        .bg-orange {
            background-color: #d71828;
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
                <h5 class="mb-4">Client/Création</h5>
                <div class="card shadow">
                    <div class="card-body">
                        <form id="clientForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="site" id="site" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="site">Site</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="den_social" placeholder="Dénomination sociale" required>
                                        <label for="den_social">Dénomination sociale</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <label for="pays">Pays</label>
                                        <select name="pays" id="pays" class="form-select" style="border: solid 1px #ccc;">
                                                <option value="">--choisir--</option>
                                        </select>
                                           
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ville_entr" placeholder="Ville" required>
                                        <label for="ville_entr">Ville</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adresse_entr" placeholder="Adresse Client" required>
                                        <label for="adresse_entr">Adresse Client</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="code_interne" placeholder="Code Interne" required>
                                        <label for="code_interne">code_interne</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="id_nat" placeholder="Identifiant National [id nat]" required>
                                        <label for="id_nat">Identifiant National [id nat]</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="telephone_client" placeholder="Telephone Client" required>
                                        <label for="telephone_client">Telephone Client</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-floating">
                                        <input type="email" class="form-control" id="emailclient" placeholder="Email Client" required>
                                        <label for="emailclient">Email Client</label>
                                    </div>
    
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom_respon" placeholder="Nom du responsable" required>
                                        <label for="nom_respon">Nom du responsable</label>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                   
                                   <div class="form-floating">
                                        <input type="text" class="form-control" id="telephone_respo" placeholder="Telephone du responsable" required>
                                        <label for="telephone_respo">Telephone du responsable</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                      <div class="form-floating">
                                        <input type="email" class="form-control" id="email_respon" placeholder="Email du responsable" required>
                                        <label for="email_respon">Email du responsable</label>
                                    </div>    
                                
                                </div>
                            </div>

                            <!-- Section 5 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="RCCM" placeholder="RCCM" required>
                                        <label for="RCCM">RCCM</label>
                                    </div>
                                </div>
                              
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numeroimpot" placeholder="Numero Impot" required>
                                        <label for="numeroimpot">Numero Impot</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numclasseur" placeholder="Numero Classeur" required>
                                        <label for="numclasseur">Numero Classeur</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="submitForm()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="script.js"></script>
    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.className = `toast ${type} show`;
            toast.innerText = message;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
                window.location.href = './'
            }, 4500); // Durée d'affichage de 4,5 secondes
        }

        function clearForm() {
            document.getElementById("clientForm").reset();
        }
/*
        function submitForm() {
            const spinner = document.querySelector(".spinner");
            spinner.style.display = "inline-block";

            // Simulation de l'envoi du formulaire
            setTimeout(() => {
                spinner.style.display = "none";
                showToast("Enregistrement réussi !", "success");
            }, 2000);
        }
            */
    function submitForm() {
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        // la date
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];

        const formData = {
            //site: 1,
            idsite: document.getElementById("site").value,
            den_social: document.getElementById("den_social").value,
            pays_entr: document.getElementById("pays").value,
            ville_entr: document.getElementById("ville_entr").value,
            adresse_entr: document.getElementById("adresse_entr").value,
            code_interne: document.getElementById("code_interne").value,
            id_nat: document.getElementById("id_nat").value,
            telephone_client: document.getElementById("telephone_client").value,
            nom_respon: document.getElementById("nom_respon").value,
            email_respon: document.getElementById("email_respon").value,
            telephone_respo: document.getElementById("telephone_respo").value,
            numclasseur: document.getElementById("numclasseur").value,
            datecrea: formattedDate,
            etat: 1,
            RCCM: document.getElementById("RCCM").value,
            numeroimpot: document.getElementById("numeroimpot").value,
            emailclient: document.getElementById("emailclient").value
        };

        button.disabled = true;
        spinner.style.display = "inline-block";
        console.log("Données envoyées :", formData);

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_client.php/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            //console.log("Réponse API :", data);
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                if (data.status === 200) {
                    showToast('Client enregistré avec succès!', 'success');
                    clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 3000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.' + error, 'error');
              //  console.error('Error:', error);
            }, 3000);
        });
    }
    </script>

    <script>
        // Les traitement de la page

       

        document.addEventListener('DOMContentLoaded', function(){
            // chargeSite
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_client.php/site')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectSite = document.getElementById('site');
                        selectSite.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectSite.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(site => {
                            const option = document.createElement('option');
                            option.value = site.idsite;
                            option.textContent = site.libsite;
                            selectSite.appendChild(option);
                        });
                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));
            

        });
       // integration pays
        $(document).ready(function () {
            const selectPays = $('#pays');
            // Charger les pays
            fetch('https://flagcdn.com/fr/codes.json')
                .then(response => response.json())
                .then(countries => {
                    selectPays.empty();
                    for (const [code, name] of Object.entries(countries)) {
                        const option = new Option(name, code);
                        selectPays.append(option);
                    }
                    selectPays.select2({
                        placeholder: '--choisir un pays--',
                        allowClear: true
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des pays :', error));
        });
    </script>
</body>
</html>
