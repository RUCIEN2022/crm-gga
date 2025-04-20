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
    <title>Dashboard Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
    <style>
body{
    font-family: tahoma,sans-serif;
    font-size: 12px;
    background-color:#f4f4f9;
}
.spinner {
  border: 8px solid #f3f3f3; /* Couleur de fond */
  border-top: 8px solid #3498db; /* Couleur principale */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
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
    color:rgb(252, 246, 246); /* Orange */
}

.bg-orange {
    background-color: #923a4d; /* Orange */
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
.circle-value, .circle-value-small {
        width: 50px;
        height: 50px;
        line-height: 50px;
        border-radius: 50%;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding-top: 10px;
    }
    .bg-gradient-assurance {
    background: linear-gradient(135deg, #6f2232, #c94b4b);
}

.bg-gradient-autofinancement {
    background: linear-gradient(135deg,rgb(221, 234, 250),rgb(250, 251, 252));
}
.bg-gradient-contrats {
    background: linear-gradient(135deg,rgb(172, 115, 128),rgb(211, 100, 124));
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
            <?php include("topbar.php"); ?>

            <!-- Cards Section -->
            <div class="row mt-2">
                <div class="col-md-3">
                <div class="card card-contrats text-white">
                <div class="card-body rounded-3 bg-gradient-contrats position-relative overflow-hidden">
                    <i class="bi bi-folder position-absolute top-50 start-50 translate-middle text-white-50" 
                    style="font-size: 8rem; opacity: 0.5; z-index: 0;"></i>

                    <div class="row text-center position-relative" style="z-index: 1;">
                        <div class="col-12">
                            <h5 class="fw-bold text-light"> Contrats</h5>
                            <div class="border border-light text-light shadow rounded-circle d-inline-flex align-items-center justify-content-center px-3 py-2 mx-auto my-2">
                                <h5 id="totalContrats" class="mb-0">...</h5>
                            </div>
                            <!-- Détails en liste -->
                            <ul class="list-unstyled small mt-3 mb-0 text-start text-light">
                                <li class="d-flex justify-content-between align-items-center border-bottom border-light-subtle py-1">
                                    <span><i class="bi bi-calculator me-2"></i>Frais de Gestion</span>
                                    <span id="fraisGestion" class="fw-bold text-light">...</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center py-1">
                                    <span class="fw-bold"><i class="bi bi-people me-2"></i>Bénéficiaires</span>
                                    <span id="totalBeneficiaires" class="fw-bold text-light">...</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>

                </div>
                <!-- Carte Assurance -->
                <div class="col-md-3">
                <div class="card text-white bg-gradient-autofinancement shadow-sm">
                <div class="card-body text-center">
                
                    <h5 class="fw-bold text-danger">
                        <i class="bi bi-shield"></i> Assurance
                    </h5>

                    <div class="border border-danger text-danger bg-light shadow rounded-circle d-inline-flex align-items-center justify-content-center px-3 py-2 mx-auto my-2">
                        <h5 id="totalContratsAssur">...</h5>
                    </div>

                    <!-- Liste des détails -->
                    <ul class="list-unstyled small mb-0 text-start">
                        <li class="d-flex justify-content-between align-items-center border-bottom py-1">
                            <span class="text-danger"><i class="bi bi-calendar2-week text-danger me-2"></i>Total du Mois en cours</span>
                            <span id="contratsAssurMois" class="fw-bold text-danger">...</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-1">
                            <span class="text-danger"><i class="bi bi-wallet2 text-danger me-2"></i>Prime en gestion</span>
                            <span id="SommePrime" class="fw-bold text-danger">0</span>
                        </li>
                    </ul>
                </div>

                </div>
                </div>

                <!-- Carte Autofinancement -->
                <div class="col-md-3">
                <div class="card text-white bg-gradient-autofinancement shadow-sm">
                <div class="card-body text-center">
    <h5 class="fw-bold text-danger">
        <i class="bi bi-currency-dollar"></i> Autofinancement
    </h5>

    <div class="border border-danger text-danger bg-light shadow rounded-circle d-inline-flex align-items-center justify-content-center px-3 py-2 mx-auto my-2">
        <h5 class="" id="totalContratsAutofin">...</h5>
    </div>

    <!-- Liste des détails -->
    <ul class="list-unstyled small mb-0 text-start">
        <li class="d-flex justify-content-between align-items-center border-bottom py-1">
            <span class="text-danger"><i class="bi bi-calendar2-week text-danger me-2"></i>Mois en cours</span>
            <span id="contratsAutofinMois" class="fw-bold text-danger">...</span>
        </li>
        <li class="d-flex justify-content-between align-items-center py-1">
            <span class="text-danger"><i class="bi bi-wallet2 text-danger me-2"></i>Budget en gestion</span>
            <span id="SommeBudget" class="fw-bold text-danger">0</span>
        </li>
    </ul>
</div>

                </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-autofinancement bg-gradient-autofinancement">
                    <div class="card-body">
    <div class="row text-center mb-2">
        <div class="col-md-6 d-flex flex-column align-items-center">
            <span class="fw-bold mb-2 text-danger">Cotations</span>
            <a href="../contrats/cotations" class="text-decoration-none">
                <div class="border border-danger text-danger bg-light shadow rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <h5 id="cotation">...</h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 d-flex flex-column align-items-center">
            <span class="fw-bold mb-2 text-danger">Tâches</span>
            <a href="../taches/" class="text-decoration-none">
                <div class="border border-primary text-primary bg-light shadow rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <h5 id="totalTaches">...</h5>
                </div>
            </a>
        </div>
    </div>

    <!-- Liste des couvertures -->
    <ul class="list-unstyled small mb-0">
        <li class="d-flex justify-content-between align-items-center border-bottom py-2">
            <span><i class="bi bi-globe-americas text-success me-2"></i>Couverture Nationale</span>
            <span id="totalCouvNat" class="fw-bold text-muted">...</span>
        </li>
        <li class="d-flex justify-content-between align-items-center py-1">
            <span><i class="bi bi-globe2 text-primary me-2"></i>Couverture Internationale</span>
            <span id="totalCouvInternat" class="fw-bold text-muted">...</span>
        </li>
    </ul>
</div>

                        
                    </div>
                </div>
            </div>

            <!-- Charts and Tasks Section -->
            <div class="row">
                <div class="col-md-6">
                <div class="card">
                <div class="card-body">
                    <h5><i class="bi bi-bar-chart"></i> Indicateur assureurs</h5>
                    <div id="chartAssureur"></div>
                    <div class="pt-5" id="noDataMessage" style="display:none; text-align:center; color: #923a4d; font-size: 1.2em;">
                        <p>Pas de données disponibles pour le moment.</p>
                    </div>
                </div>
            </div>
                </div>
                <div class="col-md-6">
                <div class="card">
                <div class="card-body">
                    <h5><i class="bi bi-bar-chart"></i> Indicateur autofinancement</h5>
                    <canvas id="chartAutoFinancement"></canvas>
                    <div class="pt-5" id="noDataMessageAutoFinancement" style="display:none; text-align:center; color: #923a4d; font-size: 1.2em;">
                        <p>Pas de données disponibles pour le moment.</p>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="module">
import { BASE_API_URL } from '../app/codes/models/Config/ConfigUrl_api.js';
document.addEventListener("DOMContentLoaded", function() {
    
    // URL du endpoint backend
    //const apiUrl = 'http://localhost/crm-gga/app/codes/api/v1/dashboard.php';
    const apiUrl = BASE_API_URL + "dashboard.php";
    // Fonction pour récupérer les données du backend
    function fetchDashboardData() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                  
                    // totalContrats
                    document.getElementById('totalContrats').textContent = data.data.totalContrats[0].total_contrats;
                    // fraisGestion
                    const fraisGestion = data.data.fraisGestion[0].frais_gest;
                    document.getElementById('fraisGestion').textContent = (fraisGestion ? parseFloat(fraisGestion).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' $' : '0 us$');

                    // Vérification de la présence des données pour 'totalBeneficiaires'
                    const totalBeneficiaires = data.data.totalBeneficiaires[0].total_beneficiaires;
                    document.getElementById('totalBeneficiaires').textContent = (totalBeneficiaires ? totalBeneficiaires : '0');

                    // totalContratsAssurance
                    document.getElementById('totalContratsAssur').textContent = data.data.totalContratsAssurance[0].total_contratsAss;
                    //cotations
                    document.getElementById('cotation').textContent = data.data.totalcotation[0].total_cotation;
                   // contratsAssuranceMois
                    if (data.data.contratsAssuranceMois && data.data.contratsAssuranceMois.length > 0) {
                        document.getElementById('contratsAssurMois').textContent = 
                            data.data.contratsAssuranceMois[0].total_contratsAss_mois;
                    } else {
                        document.getElementById('contratsAssurMois').textContent = 'Pas de contrats ce mois-ci';
                    }
                    // totalContratsAutofinance
                    if (data.data.totalContratsAutofinance && data.data.totalContratsAutofinance.length > 0) {
                        document.getElementById('totalContratsAutofin').textContent = 
                            data.data.totalContratsAutofinance[0].total_contratsAutoFin;
                    } else {
                        document.getElementById('totalContratsAutofin').textContent = 'Pas de contrats autofinancés';
                    }
                    if (data.data.contratsAutofinMois && data.data.contratsAutofinMois.length > 0) {
                        document.getElementById('contratsAutofinMois').textContent = 
                            data.data.contratsAutofinMois[0].total_contratsAss_mois;
                    } else {
                        document.getElementById('contratsAutofinMois').textContent = 'Pas de contrats autofinancés ce mois-ci';
                    }
                    // Couverture nationale
                    const couvNat = data.data.couvnat?.[0]?.total_couvNat || '0';
                    document.getElementById('totalCouvNat').textContent = couvNat;
                    // Couverture internationale
                   const couvInter = data.data.couvinter?.[0]?.total_couvInterNat || '0';
                    document.getElementById('totalCouvInternat').textContent = couvInter;
                    // Tâches
                    document.getElementById('totalTaches').textContent = data.data.taches.total[0].total_taches;
                    
                    document.getElementById('totalnewcontrat').textContent = data.data.totalNewContrats[0]?.total_newcontrats || '0';
                    
                    const analyseAssureurs = data.data.analyseAssureurs; 
                    const analyseAutofin = data.data.analyseAutofin

                    // Vérif si data existent
                    if (analyseAssureurs && analyseAssureurs.length > 0) {
                        // Extraire les data nécessaires
                        const labels = analyseAssureurs.map(item => item.assureur);
                        const chiffresAffaires = analyseAssureurs.map(item => item.chiffre_affaire);
                        const fraisGestion = analyseAssureurs.map(item => item.frais_gestion_gga);

                        // Configuration du graphique ApexCharts
                        const options = {
                            chart: {
                                type: 'bar',
                                height: 350,
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800,
                                    animateGradually: {
                                        enabled: true,
                                        delay: 150
                                    }
                                }
                            },
                            series: [
                                {
                                    name: "Chiffre d'Affaires ($)",
                                    data: chiffresAffaires
                                },
                                {
                                    name: "Frais de Gestion GGA ($)",
                                    data: fraisGestion
                                }
                            ],
                            xaxis: {
                                categories: labels,
                                title: {
                                    text: 'Assureurs'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Montant ($)'
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '45%'
                                }
                            },
                            colors: ['#923a4d', '#303670'],
                            tooltip: {
                                theme: 'dark',
                                y: {
                                    formatter: function (val) {
                                        return val.toLocaleString();
                                    }
                                }
                            }
                        };

                        // Création graphique ApexCharts
                        const chart = new ApexCharts(document.querySelector("#chartAssureur"), options);
                        chart.render();
                        document.getElementById("noDataMessage").style.display = "none";
                    } else {
                        document.getElementById("chartAssureur").style.display = "none";
                        document.getElementById("noDataMessage").style.display = "block";
                    }
                    //-------------------------------- Graphique autofinancement ---------------------------------//

if (analyseAutofin && analyseAutofin.length > 0) {
    // Extraction data
    const months = analyseAutofin.map(item => item.mois);
    const totalContrats = analyseAutofin.map(item => item.total_contrats);
    const totalBeneficiaires = analyseAutofin.map(item => item.total_beneficiaires);
    const budgetTotal = analyseAutofin.map(item => item.budget_total_contrats);
    const fraisGestion = analyseAutofin.map(item => item.frais_gestion);

    // Config
    const config = {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Total Contrats',
                    data: totalContrats,
                    borderColor: '#923a4d',
                    backgroundColor: 'rgba(146, 58, 77, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Bénéficiaires',
                    data: totalBeneficiaires,
                    borderColor: '#303670',
                    backgroundColor: 'rgba(48, 54, 112, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Budget Total ($)',
                    data: budgetTotal,
                    borderColor: '#4db8ff',
                    backgroundColor: 'rgba(77, 184, 255, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Frais de Gestion ($)',
                    data: fraisGestion,
                    borderColor: '#ff6600',
                    backgroundColor: 'rgba(255, 102, 0, 0.2)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    },
                    grid: {
                        color: '#ddd'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#444'
                    }
                },
                tooltip: {
                    backgroundColor: '#fff',
                    borderColor: '#923a4d',
                    borderWidth: 1,
                    titleColor: '#000',
                    bodyColor: '#000'
                }
            }
        }
    };

    // Rendu graph Chart.js
    const ctx = document.getElementById('chartAutoFinancement').getContext('2d');
    new Chart(ctx, config);

    document.getElementById("noDataMessageAutoFinancement").style.display = "none";
    document.getElementById("chartAutoFinancement").style.display = "block";

} else {
    document.getElementById("chartAutoFinancement").style.display = "none";
    document.getElementById("noDataMessageAutoFinancement").style.display = "block";
}

//-------------------------- fin graphique autofinancement -----------------------------//
                } else {
                    alert('Une erreur est survenue lors de la récupération des données.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données:', error);
                alert('Une erreur est survenue. Veuillez réessayer plus tard.');
            });
    }
    // ici je charge les data au chargement de la page
    fetchDashboardData();
});
</script>

</body>
</html>