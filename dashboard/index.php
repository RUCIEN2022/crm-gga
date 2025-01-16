<?php //include_once("../app/codes/fonctions/securite.php"); ?>
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
    background-color: #d71828; /* Orange */
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


    </style>
</head>
<body>
<div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h2>Tableau de bord</h2>
                        <div class="user-info">
                            <span class="user-name">Bonjour, John Masini</span>
                            <span class="time" id="currentTime"></span>
                        </div>
                        <div class="position-relative animate-notification">
                            <a href="" class="text-white" style="text-decoration: none;">
                           <span class="badged rounded p-2 bg-danger">
                           
                           <i class="bi bi-folder text-orange" style="font-size: 1.5rem;">
                            
                           </i>
                            <span id="totalnewcontrat" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange text-white" style="font-size: 0.75rem;">
                                
                            </span>
                            Nouveau
                           </span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Cards Section -->
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="card card-contrats">
                        <div class="card-body">
                            <h5><i class="bi bi-folder"></i> Contrats</h5>
                            <h4><span class="badge bg-white text-danger" id="totalContrats" class="number">...</span></h4>
                            <div class="details">
                            <h6><i class="bi bi-calculator"></i> <span class="details" id="fraisGestion"> Frais de Gestion : ...</span></h6>
                            <h6><i class="bi bi-people"></i> <span class="details" id="totalBeneficiaires"> Total Bénéficiaires : ...</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-assurance">
                        <div class="card-body">
                            <h5><i class="bi bi-shield"></i> Assurance</h5>
                            <h4><span class="badge bg-danger" id="totalContratsAssur" class="number">...</span></h4>
                            <div class="details">
                            <span class="text-danger" id="contratsAssurMois">Mois en cours : ...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-autofinancement">
                        <div class="card-body">
                            <h5><i class="bi bi-currency-dollar"></i> Autofinancement</h5>
                          <h4><span class="badge bg-danger" id="totalContratsAutofin" class="number">...</span></h4>  
                            <div class="details">
                              <span class="text-danger" id="contratsAutofinMois">Mois en cours : ...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tasks Section -->
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h5><i class="bi bi-bar-chart"></i> Indicateur/assureur</h5>
                            <canvas id="chartAssureur" width="400" height="200"></canvas>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="couverture bg-white p-2 mb-2" style="border-radius: 15px;">
                        <div class="task-item d-flex justify-content-between">
                            <span>Couverture nationale</span>
                            <span class="badge bg-danger" id="totalCouvNat">...</span>
                        </div>
                        <div class="task-item d-flex justify-content-between">
                            <span>Couverture internationale</span>
                            <span class="badge bg-danger" id="totalCouvInternat">...</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5><i class="bi bi-list-task"></i> Tâches</h5>
                            </div>
                            <div class="task-list">
                                <div class="task-item d-flex justify-content-between">
                                    <span>Total</span>
                                    <span class="badge bg-warning" id="totalTaches">...</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span>En cours</span>
                                    <span class="badge bg-success" id="tachesEnCours">...</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span class="text-info">Terminées</span>
                                    <span class="badge bg-info text-white" id="tachesTerminees">...</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span class="text-danger">En retard</span>
                                    <span class="badge bg-danger text-white" id="tachesRetard">...</span>
                                </div>
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // URL du endpoint backend
    const apiUrl = 'http://localhost:8080/crm-gga/app/codes/api/v1/dashboard.php';

    // Fonction pour récupérer les données du backend
    function fetchDashboardData() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);  // Log de la réponse pour déboguer
                

                if (data.success) {
                    // Accéder aux données et les afficher
                    
                    // totalContrats (tableau contenant un objet)
                    document.getElementById('totalContrats').textContent = data.data.totalContrats[0].total_contrats;

                    // fraisGestion (tableau contenant un objet)
                    document.getElementById('fraisGestion').textContent = 'Frais de Gestion : ' + parseFloat(data.data.fraisGestion[0].frais_gest).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '$';

                    // totalBeneficiaires (tableau contenant un objet)
                    document.getElementById('totalBeneficiaires').textContent = 'Total des Bénéficiaires : ' + data.data.totalBeneficiaires[0].total_beneficiaires;

                    // totalContratsAssurance (tableau contenant un objet)
                    document.getElementById('totalContratsAssur').textContent = data.data.totalContratsAssurance[0].total_contratsAss;

                   // contratsAssuranceMois (tableau contenant un objet)
                    if (data.data.contratsAssuranceMois && data.data.contratsAssuranceMois.length > 0) {
                        document.getElementById('contratsAssurMois').textContent = 
                            'Total du Mois en cours : ' + data.data.contratsAssuranceMois[0].total_contratsAss_mois;
                    } else {
                        document.getElementById('contratsAssurMois').textContent = 'Pas de contrats ce mois-ci';
                    }
                    // totalContratsAutofinance (tableau contenant un objet)
                    if (data.data.totalContratsAutofinance && data.data.totalContratsAutofinance.length > 0) {
                        document.getElementById('totalContratsAutofin').textContent = 
                            data.data.totalContratsAutofinance[0].total_contratsAutoFin;
                    } else {
                        document.getElementById('totalContratsAutofin').textContent = 'Pas de contrats autofinancés';
                    }
                    if (data.data.contratsAutofinMois && data.data.contratsAutofinMois.length > 0) {
                        document.getElementById('contratsAutofinMois').textContent = 
                            'Total du Mois en cours : ' + data.data.contratsAutofinMois[0].total_contratsAss_mois;
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
                    document.getElementById('tachesEnCours').textContent = data.data.taches.en_cours.length ? data.data.taches.en_cours.length : '0';
                    document.getElementById('tachesTerminees').textContent = data.data.taches.terminees.length ? data.data.taches.terminees.length : '0';
                    document.getElementById('tachesRetard').textContent = data.data.taches.retard.length ? data.data.taches.retard.length : '0';
                    document.getElementById('totalnewcontrat').textContent = data.data.totalNewContrats[0]?.total_newcontrats || '0';

                    // Graphique des assureurs (analyser et afficher les données)
                    const analyseAssureurs = data.data.analyseAssureurs;
                    if (analyseAssureurs && analyseAssureurs.length > 0) {
                        // Extraire les labels (assureurs) et les chiffres d'affaires
                        const labels = analyseAssureurs.map(item => item.assureur);
                        const chiffresAffaires = analyseAssureurs.map(item => item.chiffre_affaire);

                        // Créer le graphique
                        const ctx = document.getElementById('chartAssureur').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels, // Labels des assureurs
                                datasets: [{
                                    label: 'Chiffres d\'Affaires ($)', // Légende du dataset
                                    data: chiffresAffaires, // Données des chiffres d'affaires
                                    backgroundColor: '#e94364',
                                    borderColor: '#e94364',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString(); // Affichage des valeurs avec séparateur de milliers
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }

                } else {
                    alert('Une erreur est survenue lors de la récupération des données.');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données:', error);
                alert('Une erreur est survenue. Veuillez réessayer plus tard.');
            });
    }

    // Appel initial pour charger les données au démarrage de la page
    fetchDashboardData();
});
</script>

</body>
</html>