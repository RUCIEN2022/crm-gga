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
            <div class="row mt-2" style="">
                <div class="col-md-4">
                    <div class="card card-contrats">
                        <div class="card-body">
                            <h5><i class="bi bi-folder"></i> Contrats</h5>
                            <div class="number">140</div>
                            <div class="details">
                                <div>FG : $925,000.00</div>
                                <div>Bénéficiaires : 100 000</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-assurance">
                        <div class="card-body">
                            <h5><i class="bi bi-shield"></i> Assurance</h5>
                            <div class="number">100</div>
                            <div class="details">
                                <div>Mois en cours: 25</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-autofinancement">
                        <div class="card-body">
                            <h5><i class="bi bi-currency-dollar"></i> Autofinancement</h5>
                            <div class="number">40</div>
                            <div class="details">
                                <div>Mois en cours: 33</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Tasks -->
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <h5><i class="bi bi-bar-chart"></i> Indicateur/assureur</h5>
                            <canvas id="chartAssureur"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="couverture bg-white p-2 mb-2" style="border-radius: 15px;">
                        <div class="task-item d-flex justify-content-between">
                            <span>Couverture nationale</span>
                            <span>0</span>
                        </div>
                        <div class="task-item d-flex justify-content-between">
                            <span>Couverture internationale</span>
                            <span>0</span>
                        </div>
                        
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5><i class="bi bi-list-task"></i> Tâches</h5>
                                <div>
                                    <button class="btn btn-primary btn-sm"><i class="bi bi-plus"></i> Créer tâche</button>
                                    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-list-check"></i> Check-list</button>
                                </div>
                            </div>
                            <div class="task-list">
                                <div class="task-item d-flex justify-content-between">
                                    <span>Total</span>
                                    <span>0</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span>En cours</span>
                                    <span>0</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span>Terminées</span>
                                    <span>0</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span>En retard</span>
                                    <span>0</span>
                                </div>
                                <div class="task-item d-flex justify-content-between">
                                    <span>Assignées</span>
                                    <span>0</span>
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
</body>
</html>