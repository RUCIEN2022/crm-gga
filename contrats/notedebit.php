<?php 
//include_once("../app/codes/api/v1/processContrat.php");
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
    <title>Facture</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- CSS de Select2 -->

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


        .user-info {
    display: flex;
    flex-direction: column; /* Organise les éléments en colonne */
    align-items: center; /* Aligne le texte à gauche */
}
        .user-name {
    font-weight: bold;
    margin-bottom: 5px; /* Ajoute un espace entre le nom et l'heure */
}
        .time {
    font-size: 1.5em;
    color: gray; /* Ajoute une couleur plus discrète pour l'heure */
}
.invoice-card {
           
           
            border-radius: 10px;
        }
        .header-logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            
        }
        .header-logo img{
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 50%;
        }
        .facture-label {
            background-color: #ddd;
            padding: 5px 15px;
            font-weight: bold;
            border-radius: 5px;
        }
        .bank-details {
    border-left: 3px solid #923a4d;  /* Bordure à gauche */
    border-right: 3px solid #923a4d; /* Bordure à droite */
    border-radius: 15px 15px 15px 15px;    /* Arrondis en haut */
    padding: 15px;
    }
        /* Animation fluide */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        
        }
    </style>
</head>
<body>
<div id="loader" class="loader" style="display: none;">
    <img src="loader.gif" alt="Chargement..." />
</div>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <div id="content">
            <?php include_once('topbar.php'); ?>
            <div id="facturePDF" class="container">
    <div class="card invoice-card shadow">
        <div class="card-body m-5">
      
            <!-- Infos Client -->
                <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center">
                <span style="display: inline-block; height: 45px; width: 10px; border-right: 3px solid #923a4d; margin-right: 10px;"></span>
                <span class="fw-bold text-center rounded-3" style="background-color: #ccc; padding: 10px 100px;font-size:14px">
                    Facture
                </span>
                
                </div>
                <div class="row">
                    <h5 id="codeND"></h5>
                </div>
                
            </div>
            <div class="text-end pt-4 pe-2 p-3">
            <h5 class="fw-bold mb-1 text-uppercase" id="nomclient" style="color: #0d6efd;"></h5>
            
            <p class="mb-1" style="font-size: 13px;">
                <i class="bi bi-geo-alt-fill text-secondary"></i>
                <span id="adresseclient"></span>
            </p>

            <p class="mb-2" style="font-size: 13px;">
                <strong>Ville : </strong><span id="communevilleclient" class="text-decoration-underline"></span>
            </p>

            <p class="text-muted fst-italic" style="font-size: 12px;">
                <i class="bi bi-calendar-event me-1"></i>Édité le : <span id="dateedition"></span>
            </p>
        </div>

            <!-- Message -->
            

            <div class="card shadow-sm p-4 mb-4 rounded-4 border-0" style="background-color: #ffffff;">
                <p class="" style="font-size: 14px;">Cher client,</p>
            <p style="font-size: 12px;">Veuillez trouver la Facture N° <strong><span id="codeND"></span></strong>, correspondant aux 50% des honoraires de GGA pour <br> la gestion de la couverture médicale de vos agents et ayants droit en province.</p>
            <h5 class="mb-3 fw-semibold text-secondary">
                <i class="bi bi-file-text me-2"></i>Détails de la Facture
            </h5>

            <table class="table table-bordered table-sm align-middle small">
                <tbody>
                <tr>
                    <th style="width: 35%"><i class="bi bi-shield-lock-fill me-1 text-secondary"></i>Numéro de police</th>
                    <td id="numeropolice" class="fw-bold text-dark"></td>
                </tr>
                <tr>
                    <th><i class="bi bi-calendar-event me-1 text-secondary"></i>Période</th>
                    <td>Du <span id="dateeffet"></span> au <span id="dateecheance"></span></td>
                </tr>
                <tr>
                    <th><i class="bi bi-people-fill me-1 text-secondary"></i>Nombre de bénéficiaires</th>
                    <td id="nombrebenef"></td>
                </tr>
                <tr>
                    <th><i class="bi bi-cash me-1 text-secondary"></i>Cotisation totale</th>
                    <td id="montantbudget" class="fw-medium text-success"></td>
                </tr>
                <tr>
                    <th><i class="bi bi-gear-fill me-1 text-secondary"></i>Frais de gestion GGA</th>
                    <td id="fraisgestion"></td>
                </tr>
                <tr>
                    <th><i class="bi bi-percent me-1 text-secondary"></i>TVA sur frais de gestion</th>
                    <td id="tva"></td>
                </tr>
                <tr class="table-light">
                    <th class="fw-bold"><i class="bi bi-calculator me-1 text-primary"></i>Total frais de gestion</th>
                    <td id="totalfraisgestion" class="fw-bold text-secondary"></td>
                </tr>
                <tr class="table-light">
                    <th class="fw-bold"><i class="bi bi-calculator me-1 text-primary"></i><span id="pourcentagefraisgestion"></span> à reverser à la mise en place</th>
                    <td id="montantfrais" class="fw-bold text-danger"></td>
                </tr>
                </tbody>
            </table>
            </div>
           
            <hr>
            <div class="row text-center mt-4">
    <div class="col">
        <button class="btn text-light me-2" style="background-color: #923a4d;">
            <i class="fas fa-file-pdf"></i> Générer facture PDF
        </button>
        <button class="btn btn-primary me-2" style="background-color:rgb(58, 77, 146);">
            <i class="fas fa-envelope"></i> Envoyer par mail
        </button>
        <button class="btn btn-secondary">
            <i class="fas fa-times"></i> Fermer
        </button>
    </div>
</div>


            <hr>
        </div>
    </div>
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    function chargerFacture(numeroPolice) {
    const url = `http://localhost/crm-gga/app/codes/api/v1//ControllerGetContrat.php?np=${encodeURIComponent(numeroPolice)}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur serveur : ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Erreur :', data.error);
                return;
            }
            function formatMontant(valeur) {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'USD' }).format(valeur);
}
            // Injection des données dans la page avec les bons ID
            document.getElementById('nomclient').textContent = data.Client_name;
            document.getElementById('adresseclient').textContent = data.adresse_entr;
            document.getElementById('communevilleclient').textContent = data.ville_entr;
            document.getElementById('montantbudget').textContent = formatMontant(data.prime_ttc);
            document.querySelectorAll('#codeND').forEach(el => el.textContent = data.num_nd);
            document.getElementById('pourcentagefraisgestion').textContent = data.modalite + ' %';
            document.getElementById('nombrebenef').textContent = data.effectif_Benef;
            document.getElementById('fraisgestion').textContent = formatMontant(data.frais_gga ?? 0);
            document.getElementById('tva').textContent = formatMontant(data.tva ?? 0);

            // Calcul du total des frais de gestion (frais + TVA)
            const total = (parseFloat(data.frais_gga || 0) + parseFloat(data.tva || 0)).toFixed(2);
            document.getElementById('totalfraisgestion').textContent = formatMontant(total);

            // Montant à reverser (50% de frais de gestion, par exemple)
            const reverser = (total * (parseFloat(data.modalite || 0) / 100)).toFixed(2);
            document.getElementById('montantfrais').textContent = formatMontant(reverser);

            // Numéro de police
            document.getElementById('numeropolice').textContent = data.numeropolice;

            // Date édition
            const now = new Date().toLocaleDateString('fr-FR');
            document.getElementById('dateedition').textContent = now;
        })
        .catch(error => {
            console.error('Erreur de chargement :', error.message);
        });
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const numeroPolice = urlParams.get('np');

    if (numeroPolice) {
        chargerFacture(numeroPolice);
    } else {
        console.warn('Numéro de police non fourni dans l\'URL.');
    }
});

</script>



</body>
</html>