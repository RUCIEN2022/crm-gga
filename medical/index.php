<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">


    
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
            font-size: 12px;
        }
        .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1rem;
    }

    .dashboard-card {
        background: #fff;
        border: 1px solid #923a4d;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        min-width: 200px;
        flex: 1 1 23%; /* Flexible width, 4 cards per row */
        margin-bottom: 1rem;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 10px rgba(146, 58, 77, 0.2);
    }

    .dashboard-card .icon {
        font-size: 2rem;
        color: #923a4d;
        background-color: rgba(146, 58, 77, 0.1);
        padding: 0.5rem;
        border-radius: 50%;
        margin-bottom: 1rem;
    }

    .dashboard-card h5 {
        font-size: 1.1rem;
        color: #333;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .dashboard-card .count {
        font-size: 1.3rem;
        font-weight: bold;
        color: #923a4d;
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
        table{
            font-size: 12px;
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
.custom-navbar {
        background-color: #f8f9fa; /* Light background */
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 820px;
        margin: 20px auto;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline;
        flex-direction: row;
        gap: 10px;
    }

    .nav-item {
        display: inline;
    }

    .nav-link {
        display: inline-block;
        align-items: center;
        text-decoration: none;
        background-color: #923a4d; /* Bootstrap danger color */
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-link i {
        margin-right: 8px;
        font-size: 1.2em;
    }

    .nav-link:hover {
        background-color: #bb2d3b; /* Darker danger color */
        text-decoration: none;
    }
    .card {
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        
    }
    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }
    .circle-value, .circle-value-small {
        width: 80px;
        height: 80px;
        line-height: 80px;
        border-radius: 50%;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-top: 10px;
    }
    .circle-value-small {
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 24px;
    }
    h5 {
        font-size: 16px;
        font-weight: bold;
    }
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85rem;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
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
            background-color:rgb(59, 226, 165);
        }
        .toast.show {
            display: block;
            animation: fadeIn 0.5s, fadeOut 0.5s 4s;
        }
        .simple-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-bottom: 1px solid #ccc;
    }

    .simple-menu a {
        text-decoration: none;
        color: #333;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .simple-menu a:hover {
        color: #923a4d;
    }

    .simple-menu a.active {
        color: #923a4d;
        font-weight: bold;
        border-bottom: 2px solid #923a4d;
        padding-bottom: 0.2rem;
    }

    .section-content {
        display: none;
    }

    .section-content.active {
        display: block;
    }
    @keyframes blink {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
    100% {
        opacity: 1;
    }
}

.blinking-text {
    animation: blink 1s infinite;
}
/* Modal Principal - Taille et ergonomie */
#modalTraitementPrincipal.modal-lg {
    max-width: 90% !important; /* Augmenter la taille du modal principal */
}

#modalTraitementPrincipal .modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#modalTraitementPrincipal .modal-header {
    background-color: #f1f1f1;
    border-bottom: 1px solid #ddd;
}

#modalTraitementPrincipal .modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}

#modalTraitementPrincipal .modal-footer {
    background-color: #f9f9f9;
    border-top: 1px solid #ddd;
}

#modalTraitementPrincipal .modal-body {
    padding: 20px;
}

/* Modal Rejet - Plus petit et plus simple */
#modalTraitementRejet.modal-sm {
    max-width: 800px !important; /* Taille plus petite pour le modal de rejet */
}

#modalTraitementRejet .modal-content {
    border-radius: 8px;
}

#modalTraitementRejet textarea {
    resize: none;
}

/* Boutons */
#modalTraitementPrincipal .btn, #modalTraitementRejet .btn {
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 5px;
}

/* Différencier les boutons */
#modalTraitementPrincipal .btn-success {
    background-color: #28a745;
    color: white;
}

#modalTraitementPrincipal .btn-warning {
    background-color: #ffc107;
    color: white;
}

#modalTraitementRejet .btn-danger {
    background-color: #dc3545;
    color: white;
}

#modalTraitementRejet .btn-secondary {
    background-color: #6c757d;
    color: white;
}

#modalTraitementPrincipal .btn-secondary {
    background-color: #6c757d;
    color: white;
}
#tableModalTraitement {
    border-radius: 10px;
    background-color: #f8f9fa;
    overflow: hidden;
}

#tableModalTraitement th, #tableModalTraitement td {
    padding: 12px 15px;
    vertical-align: middle;
    font-size: 12px;
    border-color: #dee2e6;
}

#tableModalTraitement th {
    background-color: #fff;
    color: #000;
    font-weight: 600;
}

#tableModalTraitement td {
    background-color: #f9f9f9;
    font-weight: 500;
    color: #333;
}

#tableModalTraitement .table-striped tbody tr:nth-of-type(odd) {
    background-color: #f1f1f1;
}

#tableModalTraitement .table-striped tbody tr:nth-of-type(even) {
    background-color: #fff;
}

#tableModalTraitement.table-bordered {
    border: 1px solid #dee2e6;
}

#tableModalTraitement td, #tableModalTraitement th {
    text-align: left;
}
#modalPlainte .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    font-family: 'Segoe UI', Roboto, sans-serif;
    background-color: #fff;
  }

  #modalPlainte .modal-header {
    border-bottom: none;
    background-color: #fff;
    padding-top: 1.5rem;
    padding-left: 2rem;
    padding-right: 2rem;
  }

  #modalPlainte .modal-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1f2937;
  }

  #modalPlainte .modal-body {
    padding: 1rem 2rem;
  }

  .form-display {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
  }

  .form-group-display {
    display: flex;
    flex-direction: column;
  }

  .form-group-display label {
    font-size: 0.95rem;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 0.3rem;
  }

  .form-group-display span {
    background-color: #f9fafb;
    border: none;
    border-bottom: 1px solid #d1d5db;
    padding: 8px 0;
    font-size: 0.95rem;
    color: #4b5563;
  }

  #modalPlainte .modal-footer {
    border-top: none;
    padding: 1.2rem 2rem;
    background-color: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .btn {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 0.45rem 1rem;
    border-radius: 8px;
  }

  .btn-primary {
    background-color: #3b82f6;
    border: none;
    color: white;
  }

  .btn-primary:hover {
    background-color: #2563eb;
  }

  .btn-success {
    background-color: #10b981;
    border: none;
    color: white;
  }

  .btn-success:hover {
    background-color: #059669;
  }

  .btn-secondary {
    background-color: #6b7280;
    border: none;
    color: white;
  }

  .btn-secondary:hover {
    background-color: #4b5563;
  }

  .btn-close {
    filter: grayscale(100%);
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

    <div class="card shadow">
    <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="../dashboard/" class="btn text-light fw-bold" style="background-color:#3498db">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
        </div>
    <div class="row g-3">
        <!-- Menu -->
    <div class="row text-center p-3">
        <div class="head d-flex justify-content-start align-items-center">
            <div class="simple-menu">
                <a class="active" onclick="showSection('factures')">Liste des factures</a>
                <a onclick="showSection('traitement')">Traitement factures</a>
                <a onclick="showSection('plaintes')">Gestion des Plaintes</a>
                <a onclick="showSection('demandes')">Demandes de validation</a>
                <a onclick="showSection('actes')">Actes médicaux</a>
                <a onclick="showSection('activation')">Activation contrats</a>
            </div>
        </div>
    </div>
        <!-- Section : Liste des factures -->
        <div id="factures" class="section-content active">
        <div class="row text-center">
        <div class="col-12">
        <div class="head d-flex justify-content-between align-items-center mb-2">
            <h5 class="text-secondary">
                <i class="bi bi-list-check"></i> Factures Récentes
            </h5>
            <div class="col-md-3 d-flex">
                <i class="bi bi-search me-2" style="font-size: 1.2rem; color: #6c757d;"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une facture...">
            </div>
        </div>
        <div class="table-responsive">
            <table id="FactureTable" class="table table-bordered table-striped table-hover table-condensed table-sm">
                <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                    <tr>
                        <th>#</th>
                        <th>Date_reception</th>
                        <th>Num_fact</th>
                        <th>Montant</th>
                        <th>Tp</th>
                        <th>Rd</th>
                        <th>Prestataire</th>
                        <th>Période</th>
                        <th>Traitement</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Ma Pagination -->
        <div id="pagination" class="d-flex justify-content-center mt-3">
        <!-- Bouton Pagination -->
        </div>
        <!-- Fin Pagination -->
            </div>
        </div>

    </div>
    <!-- Section : Traitement factures -->
    <div id="traitement" class="section-content">
    <h5 class="text-secondary"><i class="bi bi-tools"></i> Traitement des factures</h5>
    <!-- Dashboard de traitement des factures -->
            <div class="row" id="statistiquesTraitement">
            <div class="col-md-3 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">Total Reçus</h6>
                            <h4 id="totalRecu" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-inbox fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">Total Traités</h6>
                            <h4 id="totalTraite" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-check-circle fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">Total Rejetés</h6>
                            <h4 id="totalRejete" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-x-circle fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">En Attente</h6>
                            <h4 id="totalAttente" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-hourglass-split fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-start">
            <div class="table-responsive">
                    <table id="TraitementFactTab" class="table table-bordered table-striped table-hover table-sm">
                        <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                            <tr>
                                <th>#</th>
                                <th>Num_fact</th>
                                <th>Montant</th>
                                <th>Tp</th>
                                <th>Rd</th>
                                <th>Prestataire</th>
                                <th>Période</th>
                                <th>Medecin consil</th>
                                <th>Debut_traitement</th>
                                <th>Date_fin</th>
                                <th>Statut</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- Section : Gestion des Plaintes -->
    <div id="plaintes" class="section-content">
    <div class="text-center p-3">
      
        <div class="row">
            <!-- Tableau des plaintes -->
            <div class="col-md-8 mb-3">
                <div class="card shadow-sm border rounded-3">
                <div class="card-header bg-white shadow-sm rounded-top py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h6 class="text-danger fw-bold mb-2 mb-md-0">
                            <i class="bi bi-table"></i> Liste des plaintes
                        </h6>
                        <button class="btn btn-outline-danger rounded-pill px-4 shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAddPlainte">
                            <i class="bi bi-plus-circle-fill fs-5"></i> 
                            <span class="fw-semibold">Ajouter une plainte</span>
                        </button>
                    </div>
                </div>

                    <div class="card-body table-responsive">
                       <!-- Recherche rapide -->
                        <input type="text" id="searchPlaintes" placeholder="Rechercher une plainte..." class="form-control form-control-sm my-2">

                        <!-- Pagination -->
                       

                        <!-- Table des plaintes -->
                        <table id="ListePlainteTab" class="table table-bordered table-striped table-hover table-sm">
                            <thead style="background-color: #923a4d; font-size:10px;" class="text-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date réception</th>
                                    <th>Cat. Plaignant</th>
                                    <th>Nom plaignant</th>
                                    <th>Type</th>
                                    <th>Moyen</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div id="paginationPlaintes" class="text-center my-2"></div>
                    </div>
                </div>
            </div>

            <!-- Statistiques des plaintes -->
            <div class="col-md-4 mb-3">
    <div class="card shadow-sm border rounded-3 bg-white">
        <div class="card-header bg-white">
            <h6 class="text-danger mb-0"><i class="bi bi-pie-chart-fill"></i> Statistiques des plaintes</h6>
        </div>
        <div class="card-body">
    <div class="row g-2 text-center">
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card shadow-sm border-start border-4 border-dark rounded-3">
                <div class="card-body p-2">
                    <small class="text-muted float-start">Total reçues</small>
                    <h4 class="text-dark fw-bold my-2" id="statTotal">0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card shadow-sm border-start border-4 border-primary rounded-3">
                <div class="card-body p-2">
                    <small class="text-muted float-start">Traitée</small>
                    <h4 class="text-primary fw-bold my-2" id="statTraite">0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card shadow-sm border-start border-4 border-danger rounded-3">
                <div class="card-body p-2">
                    <small class="text-muted float-start">En attente</small>
                    <h4 class="text-danger fw-bold my-2" id="statAttente">0</h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-6">
            <div class="card shadow-sm border-start border-4 border-secondary rounded-3">
                <div class="card-body p-2">
                    <small class="text-muted float-start">Prise en charge</small>
                    <h4 class="text-secondary fw-bold my-2" id="statEncharge">0</h4>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

        </div>

    </div>
</div>

    <!-- Section : Demandes de validation -->
    <div id="demandes" class="section-content">
        <div class="text-center p-3">
            <h5 class="text-secondary"><i class="bi bi-hourglass-split"></i> Demandes en attente</h5>
            
        </div>
    </div>
    <!-- Section : Actes médicaux -->
<div class="section-content mt-4" id="actes">
  <div class="row">
    <!-- Bloc gauche -->
    <div class="col-md-7">
      <div class="card shadow-sm">
      <div class="card-header bg-light d-flex justify-content-between align-items-center">
  <h6 class="mb-0">
    <i class="bi bi-list-check"></i> Liste des actes plafonnés [ Mois en cours ]
  </h6>
  
  <button type="button" class="btn btn-outline-danger btn-sm" id="btnRapportActes">
  <i class="bi bi-graph-up-arrow me-1"></i> Consultation avancée
</button>

</div>

            <!-- Mini statistiques des actes -->
            <div class="card-body pb-0">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                <div class="card bg-white text-danger border border-danger h-100 shadow-sm p-2">
                    <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard2-pulse fs-3 me-2"></i>
                    <div class="small">
                        <div class="fw-bold">Actes & Bénéficiaires</div>
                        <div><span id="nbr_acte"></span> actes | <span id="nbr_benef"></span> bénéficiaires</div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card bg-white text-danger border border-danger h-100 shadow-sm p-2">
                    <div class="d-flex align-items-center">
                    <i class="bi bi-cash-coin fs-3 me-2"></i>
                    <div class="small">
                        <div class="fw-bold">Montant total</div>
                        <div><span id="montantTotalActes"></span></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card bg-white text-danger border border-danger h-100 shadow-sm p-2">
                    <div class="d-flex align-items-center">
                    <i class="bi bi-star fs-3 me-2"></i>
                    <div class="small">
                        <div class="fw-bold">Acte le plus fréquenté</div>
                        <div><span id="nomactePlusFrequent"></span> <span id="nbrDeFrequence"></span></div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>


        <!-- Tableau des actes -->
        <div class="table-responsive">
          <table id="tableActes" class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light text-center">
              <tr>
                <th>ID</th>
                <th>Acte</th>
                <th>Assuré</th>
                <th>Contrat</th>
                <th>Montant</th>
                <th>Date soin</th>
                <th>Prestataire</th>
               
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Bloc droit : formulaire d'ajout -->
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-header bg-light">
          <h6 class="mb-0"><i class="bi bi-plus-circle"></i> Ajouter un acte plafonné</h6>
        </div>
        <div class="card-body">
          <form id="formActe">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nom de l'acte *</label>
                <select name="zactes" id="zactes" class="form-select">
                <option value="">-- Sélectionnez un acte médical --</option>

                <optgroup label="Consultations">
                    <option value="consultation_generale">Consultation générale</option>
                    <option value="consultation_specialisee">Consultation spécialisée</option>
                    <option value="visite_domicile">Visite à domicile</option>
                    <option value="teleconsultation">Téléconsultation</option>
                </optgroup>

                <optgroup label="Soins infirmiers">
                    <option value="injection">Injection intramusculaire / sous-cutanée</option>
                    <option value="pansement">Pansement simple ou complexe</option>
                    <option value="prise_tension">Prise de tension artérielle</option>
                    <option value="perfusion">Pose de perfusion</option>
                    <option value="sondage_urinaire">Sondage urinaire</option>
                </optgroup>

                <optgroup label="Examens biologiques">
                    <option value="hemogramme">Hémogramme (NFS)</option>
                    <option value="glycemie">Glycémie</option>
                    <option value="test_vih">Test VIH</option>
                    <option value="groupage">Groupage sanguin</option>
                    <option value="bilan_hepatique">Bilan hépatique / rénal</option>
                    <option value="test_grossesse">Test de grossesse</option>
                </optgroup>

                <optgroup label="Examens d’imagerie">
                    <option value="radiographie">Radiographie</option>
                    <option value="echographie">Échographie</option>
                    <option value="scanner">Scanner (CT-Scan)</option>
                    <option value="irm">IRM</option>
                    <option value="mammographie">Mammographie</option>
                </optgroup>

                <optgroup label="Actes médicotechniques">
                    <option value="ecg">Électrocardiogramme (ECG)</option>
                    <option value="audiometrie">Audiométrie</option>
                    <option value="spirometrie">Spirométrie</option>
                    <option value="endoscopie">Endoscopie</option>
                </optgroup>

                <optgroup label="Petite chirurgie">
                    <option value="suture">Suture de plaie</option>
                    <option value="incision_drainage">Incision et drainage d'abcès</option>
                    <option value="ablation_corps_etranger">Ablation de corps étranger</option>
                    <option value="exerese_tumeur">Exérèse de petite tumeur bénigne</option>
                </optgroup>

                <optgroup label="Obstétrique">
                    <option value="accouchement">Accouchement (naturel / césarienne)</option>
                    <option value="consultation_prenatale">Consultation prénatale</option>
                    <option value="suivi_postnatal">Suivi postnatal</option>
                    <option value="echo_obstetricale">Échographie obstétricale</option>
                </optgroup>

                <optgroup label="Actes dentaires">
                    <option value="detartrage">Détartrage</option>
                    <option value="extraction">Extraction dentaire</option>
                    <option value="traitement_carie">Traitement de carie</option>
                    <option value="pose_prothese">Pose de prothèse</option>
                </optgroup>

                <optgroup label="Vaccinations">
                    <option value="bcg">Vaccin BCG</option>
                    <option value="polio">Vaccin Polio</option>
                    <option value="rougeole">Vaccin Rougeole</option>
                    <option value="covid">Vaccin COVID-19</option>
                </optgroup>

                <optgroup label="Hospitalisation et chirurgie">
                    <option value="admission">Admission en hospitalisation</option>
                    <option value="reanimation">Séjour en réanimation</option>
                    <option value="chirurgie_majeure">Chirurgie majeure</option>
                    <option value="anesthesie">Anesthésie</option>
                </optgroup>
                </select>

              </div>
              <div class="col-md-6">
                <label class="form-label">Nom de l'assuré *</label>
                <input type="text" class="form-control" name="nom_assure" id="nom_assure" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Contrat *</label>
                <input type="text" class="form-control" name="contrat" id="contrat" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Montant *</label>
                <input type="number" class="form-control text-end fw-bold" name="montant" id="montant" value="0,00" required>
                </div>
              <div class="col-md-6">
                <label class="form-label">Date du soin *</label>
                <input type="date" class="form-control" name="date_soin" id="date_soin" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Prestataire *</label>
                <select name="prestataire" id="prestataire" class="form-select">
                    <option value=""></option>
                </select>
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
              <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Annuler</button>
              <button type="submit" class="btn btn-danger"><i class="bi bi-check-circle"></i> Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Section : Retour -->
    <div id="retour" class="section-content">
        <div class="text-center p-3">
            <h5 class="text-secondary"><i class="bi bi-arrow-left"></i> Retour à l’accueil</h5>
            <p>Redirection ou résumé ici...</p>
        </div>
    </div>


        </div>
     </div>
    </div>
    </div>
</div>
</div>

<!-- Modal Traitement Facture -->
<div class="modal fade" id="modalTraitement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f1f1f1;">
        <h5 class="modal-title" id="modalLabel">Traitement Facture - [ Affectation Médécin ]</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <form id="traitementForm">
          <input type="hidden" id="id_facture" name="id_facture">
            <div class="row">
            <div class="col-md-6 mb-3">
            <label for="numero_facture" class="form-label">Numéro Facture</label>
            <input type="text" class="form-control" id="numero_facture" name="numero_facture" readonly style="background-color: #f1f1f1;">
          </div>
          <div class="col-md-6 mb-3">
            <label for="medecin" class="form-label">Médecin</label>
            <select id="medecin" class="form-select" style="width: 100%;font-size:12px">
                <option value="">-- Sélectionnez --</option>
            </select>

          </div>
            </div>
          <div class="row mt-2">
          <div class="col-md-6 mb-3">
            <label for="date_debut" class="form-label">Date Début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut">
          </div>
          <div class="col-md-6 mb-3">
            <label for="date_fin" class="form-label">Date Fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin">
          </div>
          </div><hr>
          
          <div class="text-center">
            <button type="submit" class="btn btn-danger btn-lg" style="background-color: #213547;"> <i class="bi bi-check-circle"></i> Valider</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Principal -->
<div class="modal fade" id="modalTraitementPrincipal" tabindex="-1" aria-labelledby="modalTraitementPrincipalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTraitementPrincipalLabel">Opération de traitement - [ Détails de la Facture ]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <table id="tableModalTraitement" class="table table-bordered table-striped">
                <tbody>
                <tr>
                        <th scope="row">ID Opération</th>
                        <td id="id_traitement_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Numéro de Facture</th>
                        <td id="numero_facture_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Nom du Prestataire</th>
                        <td id="nom_prestataire_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Montant Facture</th>
                        <td id="montant_facture_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Période de préstation</th>
                        <td id="periode_prest_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Date de Fin de traitement</th>
                        <td id="datefin_modal" class="font-weight-bold text-muted"></td>
                    </tr>
                    <tr>
                        <th scope="row">Observations</th>
                        <td id="descript_modal" class="font-weight-bold text-danger"></td>
                    </tr>
                   
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_valider" style="background-color: #213547;">
                <i class="bi bi-check-circle"></i> Valider Facture
            </button>
            <button type="button" class="btn btn-danger" id="btn_rejeter">
                <i class="bi bi-x-circle"></i> Rejeter
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i> Fermer
            </button>
        </div>

        </div>
    </div>
</div>

<!-- Modl ajout plainte -->
<div class="modal fade" id="modalAddPlainte" tabindex="-1" aria-labelledby="modalAddPlainteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="modalAddPlainteLabel"><i class="bi bi-pencil-square"></i> Nouvelle plainte</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <form id="formPlainte">
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6 form-floating">
              <input type="date" class="form-control" id="dateReception" name="dateReception" required>
              <label for="dateReception">Date de réception</label>
            </div>

            <div class="col-md-6 form-floating">
              <select class="form-select" id="categoriePlainte" name="categoriePlainte" required>
                <option selected disabled value="0">Choisir...</option>
                <option value="Orientation médicale">Orientation médicale</option>
                <option value="Prise en charge">Prise en charge</option>
                <option value="Demande de remboursement">Demande de remboursement</option>
                <option value="Identification de l’assuré">Identification de l’assuré</option>
                <option value="Paiement de reste à charge">Paiement de reste à charge</option>
              </select>
              <label for="categoriePlainte">Catégorie de plainte</label>
            </div>

            <div class="col-md-6 form-floating">
              <select class="form-select" id="typePlaignant" name="typePlaignant" required>
                <option selected disabled value="0">Choisir...</option>
                <option value="Assuré">Assuré</option>
                <option value="Prestataire">Prestataire</option>
               
              </select>
              <label for="canalReception">Type plaignant</label>
            </div>

            <div class="col-md-6 form-floating">
              <input type="text" class="form-control" id="nomPlaignant" name="nomPlaignant" required>
              <label for="nomPlaignant">Nom du plaignant</label>
            </div>

            <div class="col-md-6 form-floating">
              <select class="form-select" id="moyendecontact" name="moyendecontact" required>
                <option selected disabled value="0">Choisir...</option>
                <option value="téléphone">Téléphone</option>
                <option value="Email">Email</option>
                <option value="Présentiel">Présentiel</option>
                <option value="Courrier physique">Courrier physique</option>
              </select>
              <label for="moyendecontact">Moyen de contact</label>
            </div>
            

            <div class="col-12 form-floating">
              <textarea class="form-control" placeholder="Décrire la plainte..." id="descriptionPlainte" name="descriptionPlainte" style="height: 100px" required></textarea>
              <label for="descriptionPlainte">Description</label>
            </div>

          </div>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="submit" id="btnajoutplainte" class="btn btn-danger px-4 rounded-pill shadow">
            <i class="bi bi-check-circle"></i> Soumettre la plainte
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal plainte -->
<div class="modal fade" id="modalPlainte" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Détails de la plainte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="form-display">
          <div class="form-group-display">
            
            <span id="modalIdPlainte" hidden></span>
          </div>
          <div class="form-group-display">
            <label>Nom du plaignant</label>
            <span id="modalNom"></span>
          </div>
          <div class="form-group-display">
            <label>Type</label>
            <span id="modalType"></span>
          </div>
          <div class="form-group-display">
            <label>Catégorie</label>
            <span id="modalCat"></span>
          </div>
          <div class="form-group-display">
            <label>Description</label>
            <span id="modalDesc"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btnPriseEnCharge" class="btn btn-primary">Prendre en charge</button>
        <button id="btnTraitement" class="btn btn-success">Plainte traitée</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="factureToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Message ici...
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999"></div>
<!-- Conteneur pour les toasts -->
<div id="toastContainer" aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    
    <script src="script.js"></script>
    <script>
    function showSection(sectionId) {
        // Retirer la classe active de tous les liens
        document.querySelectorAll('.simple-menu a').forEach(link => {
            link.classList.remove('active');
        });

        // Activer le lien cliqué
        const clickedLink = [...document.querySelectorAll('.simple-menu a')].find(a => a.getAttribute('onclick')?.includes(sectionId));
        if (clickedLink) clickedLink.classList.add('active');

        // Cacher toutes les sections
        document.querySelectorAll('.section-content').forEach(section => {
            section.classList.remove('active');
        });

        // Afficher la section correspondante
        document.getElementById(sectionId).classList.add('active');
    }
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    let allFactures = []; // Stocke toutes les factures récupérées

    // Fx affiche toutes les factures
    function displayFactures(factures) {
        const tableBody = document.querySelector('#FactureTable tbody');
        tableBody.innerHTML = '';

        factures.forEach((facture, index) => {
            const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${facture.date_reception}</td>
                    <td class="text-start">${facture.numero_facture}</td>
                    <td>$ ${facture.montant_facture}</td>
                    <td>${facture.tp}</td>
                    <td>${facture.rd}</td>
                    <td class="text-start">${facture.nom_prestataire}</td>
                    <td class="text-start">${facture.periode_prestation}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-btn" 
                            data-id="${facture.id_facture}" 
                            data-num="${facture.numero_facture}" 
                            data-date="${facture.periode_prestation}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Recherche rapide
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const filteredFactures = allFactures.filter(facture => {
            return facture.numero_facture.toLowerCase().includes(query) ||
                   facture.nom_prestataire.toLowerCase().includes(query) ||
                   facture.date_reception.toLowerCase().includes(query);
        });
        displayFactures(filteredFactures); // Afficher tout (pas de pagination)
    });

    // Chargement des données
    fetch('http://localhost/crm-gga/app/codes/api/v1/getfactures.php')
        .then(response => response.json())
        .then(data => {
            if (data.data && data.data.length > 0) {
                allFactures = data.data;
                displayFactures(allFactures);
            } else {
                const tableBody = document.querySelector('#FactureTable tbody');
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center">Pas de factures disponibles</td>
                    </tr>`;
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des factures:', error);
            const tableBody = document.querySelector('#FactureTable tbody');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center text-danger">Erreur de chargement des données</td>
                </tr>`;
        });
});




document.getElementById('btn_rejeter').addEventListener('click', function () {
    const idTraitement = document.getElementById('id_traitement_modal').textContent;
    const numeroFacture = document.getElementById('numero_facture_modal')?.textContent || 'Inconnu';

    if (!idTraitement) {
        Swal.fire({
            icon: 'error',
            title: "Aucune facture sélectionnée",
            text: "Veuillez d'abord sélectionner une facture.",
            confirmButtonText: 'Ok'
        });
        return;
    }

    // Masquer le modal principal avant d'afficher SweetAlert2
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalTraitementPrincipal'));
    if (modal) modal.hide();

    setTimeout(() => {
        Swal.fire({
            title: `Rejet de la facture`,
            html: `<strong>Facture N°:</strong> ${numeroFacture}<br><br>Veuillez spécifier le motif du rejet :`,
            input: "textarea",
            inputPlaceholder: "Motif du rejet...",
            inputAttributes: {
                'aria-label': "Motif du rejet"
            },
            inputValidator: (value) => {
                if (!value) {
                    return "Le motif est requis pour rejeter la facture.";
                }
            },
            showCancelButton: true,
            confirmButtonText: "Valider le rejet",
            cancelButtonText: "Annuler",
            icon: "warning",
            showLoaderOnConfirm: true,
            preConfirm: (motifRejet) => {
                return fetch('http://localhost/crm-gga/app/codes/api/v1/rejter_facture.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        idtt: idTraitement,
                        motif: motifRejet.trim()
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error(response.statusText);
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Erreur de traitement : ${error}`
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const res = result.value;
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Opération réussie !',
                        text: res.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Recharger les données
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: res.message,
                        confirmButtonText: 'Ok'
                    });
                }
            } else {
                // Si annulé, réafficher le modal
                if (modal) modal.show();
            }
        });
    }, 300);
});




function showToast(message, type) {
    // Crée un toast d'alerte avec le message passé
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.classList.add('toast');
    toast.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');
    toast.classList.add('text-white');
    toast.innerHTML = `
        <div class="toast-body">${message}</div>
    `;

    toastContainer.appendChild(toast);
    $(toast).toast({ delay: 3000 }).toast('show');
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalPrincipal = new bootstrap.Modal(document.getElementById('modalTraitementPrincipal'), {
        backdrop: 'static'
    });

    const modalRejet = new bootstrap.Modal(document.getElementById('modalTraitementRejet'), {
        backdrop: 'static'
    });

    // Lors du clic sur le bouton Edit, ouvrir le modal avec les informations
    document.addEventListener('click', function (e) {
        if (e.target.closest('.edit-btn2')) {
            const btn = e.target.closest('.edit-btn2');
            const id = btn.dataset.id;
            const num = btn.dataset.num;
            const prestataire = btn.dataset.prestataire;
            const montant = btn.dataset.montant;
            const periode_prestation = btn.dataset.periode_prestation;
            const obs = btn.dataset.obs;
            const datefin = btn.dataset.datefin;

            // Remplir les informations dans le modal principal
            document.getElementById('id_traitement_modal').textContent = id;
            document.getElementById('numero_facture_modal').textContent = num;
            document.getElementById('nom_prestataire_modal').textContent = prestataire;
            document.getElementById('montant_facture_modal').textContent = montant;
            document.getElementById('periode_prest_modal').textContent = periode_prestation;
            
            document.getElementById('datefin_modal').textContent = datefin;

            document.getElementById('descript_modal').textContent = obs;

            modalPrincipal.show(); // Afficher le modal principal
        }
    });


    // Lorsque l'on clique sur "Rejeter"
    document.getElementById('btn_rejeter').addEventListener('click', function () {
        modalRejet.show(); // Afficher le modal de rejet
    });

});




document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('modalTraitement'));
    
    document.addEventListener('click', function (e) {
        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.dataset.id;
            const num = btn.dataset.num;
            const periode = btn.dataset.date;

            // Traitement de la période (ex: "2024-01-01 au 2024-01-31")
            const [debut, fin] = periode.split(' au ');

            document.getElementById('id_facture').value = id;
            document.getElementById('numero_facture').value = num;
            document.getElementById('date_debut').value = debut || '';
            document.getElementById('date_fin').value = fin || '';

            modal.show();
        }
    });

    document.getElementById('traitementForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const btn = this.querySelector('button[type="submit"]');
    const spinner = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Traitement...`;
    const originalText = btn.innerHTML;

    const formData = {
        idfacture: document.getElementById('id_facture').value,
        date_debut: document.getElementById('date_debut').value,
        date_fin: document.getElementById('date_fin').value,
        idmedecin: document.getElementById('medecin').value
    };

    // Vérification des champs
    if (!formData.idfacture || !formData.date_debut || !formData.date_fin || !formData.idmedecin) {
        showToast('Erreur', 'Veuillez remplir tous les champs avant de soumettre.', 'danger');
        return;
    }

    // Boîte de dialogue de confirmation SweetAlert
    Swal.fire({
        title: "Confirmer l'opération",
        text: "Voulez-vous vraiment valider ce traitement ?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, valider'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si confirmé, lancer le traitement
            btn.disabled = true;
            btn.innerHTML = spinner;

            fetch('http://localhost/crm-gga/app/codes/api/v1/ajout_traitement_fact.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (res.success) {
                    showToast('Succès', res.message, 'success');

                    // Fermer le modal
                    const modalElement = document.getElementById('modalTraitement');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();

                    // Recharger la liste des traitements
                    fetchTraitements();
                    attachTraitementBtnEvents();

                    // Optionnel : afficher directement la section traitement
                    showSection('traitement');
                } else {
                    showToast('Erreur', res.message, 'danger');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                showToast('Erreur', "Une erreur s'est produite", 'danger');
                console.error(err);
            });
        }
    });
});
// Fonction pour attacher les événements après le rendu des lignes
function attachTraitementBtnEvents() {
    document.querySelectorAll('.edit-btn2').forEach(btn => {
        btn.addEventListener('click', () => {
            // Récupère les données de l'attribut data-*
            const id = btn.getAttribute('data-id');
            const numero = btn.getAttribute('data-num');
            const prestataire = btn.getAttribute('data-prestataire');
            const montant = btn.getAttribute('data-montant');
            const periode = btn.getAttribute('data-periode_prestation');
            const obs = btn.getAttribute('data-obs');
            const datefin = btn.getAttribute('data-datefin');

            // Remplit le contenu du modal
            document.getElementById('id_traitement_modal').textContent = id;
            document.getElementById('numero_facture_modal').textContent = numero;
            document.getElementById('nom_prestataire_modal').textContent = prestataire;
            document.getElementById('montant_facture_modal').textContent = montant;
            document.getElementById('periode_prest_modal').textContent = periode;
            document.getElementById('descript_modal').textContent = obs;
            document.getElementById('datefin_modal').textContent = datefin;

            // Ouvre le modal Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('modalTraitementPrincipal'));
            modal.show();
        });
    });
}




function showToast(titre, message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <strong>${titre}:</strong> ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    document.querySelector('.toast-container').appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('show');
        toast.remove();
    }, 4000);
}
// Fonction pour récupérer la liste des traitements et afficher dans le tableau
function fetchTraitements() {
    fetch('http://localhost/crm-gga/app/codes/api/v1/getliste_traitement.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#TraitementFactTab tbody');
        tableBody.innerHTML = ''; // Réinitialise le contenu de la table

        if (data.data && data.data.length > 0) {
            // Si des données sont présentes, on les affiche
            data.data.forEach((traitement, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-start">${traitement.numero_facture}</td>
                        <td class="text-end">$ ${traitement.montant_facture}</td>
                        <td class="text-end">${traitement.tp}</td>
                        <td class="text-end">${traitement.rd}</td>
                        <td class="text-start">${traitement.nom_prestataire}</td>
                        <td class="text-start">${traitement.periode_prestation}</td>
                        <td class="text-start">${traitement.prenom_medecin} ${traitement.nom_medecin}</td>
                        <td class="text-start">${traitement.datedebut}</td>
                        <td class="text-start">${traitement.datefin}</td>
                        <td>${getStatusText(traitement.statut)}</td>
                        <td>
                        <button class="btn btn-sm btn-outline-danger edit-btn2" 
                            data-id="${traitement.idtraitement}" 
                            data-num="${traitement.numero_facture}" 
                            data-prestataire="${traitement.nom_prestataire}" 
                            data-montant="$ ${traitement.montant_facture}"
                            data-periode_prestation="${traitement.periode_prestation}"
                            data-obs="${traitement.obs}"
                            data-datefin="${traitement.datefin}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        </td>
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
            attachTraitementBtnEvents();
            calculerStatistiques(data.data);
        } else {
            // Si aucune donnée n'est présente, on affiche "Pas de factures disponibles"
            const noDataRow = `
                <tr>
                    <td colspan="12" class="text-center text-danger">Pas de factures disponibles dans le traitement</td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', noDataRow);
        }
    })
    .catch(error => {
        showToast('Erreur', "Une erreur s'est produite lors de la récupération des données.", 'danger');
    });
}
function calculerStatistiques(data) {
    let total = data.length;
    let traite = data.filter(f => f.statut == 2).length;
    let rejete = data.filter(f => f.statut == 4).length;
    let attente = data.filter(f => f.statut == 1).length;

    document.getElementById('totalRecu').textContent = total;
    document.getElementById('totalTraite').textContent = traite;
    document.getElementById('totalRejete').textContent = rejete;
    document.getElementById('totalAttente').textContent = attente;
}


function getStatusText(statut) {
    switch (statut) {
        case 1:
            return '<span class="text-warning fw-bold">En attente</span>';
        case 2:
            return '<span class="text-success fw-bold">Terminé</span>';
        case 3:
            return '<span class="text-warning fw-bold"><i class="bi bi-info-circle-fill"></i> En retard</span>';
        case 4:
            return '<span class="text-danger blinking-text fw-bold"><i class="bi bi-exclamation-triangle"></i> Rejetée</span>';
        default:
            return '<span class="text-secondary">Statut inconnu</span>';
    }
}

fetchTraitements();

});
</script>
<script>
    // Fonction utilitaire pour afficher un toast Bootstrap
    function showToast(message, bgColor = 'bg-primary') {
        const toastElement = document.getElementById('factureToast');
        const toastBody = document.getElementById('toastMessage');

        toastBody.textContent = message;
        toastElement.className = `toast align-items-center text-white ${bgColor} border-0`;
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    document.getElementById('btn_valider').addEventListener('click', function () {
    const btn = this;
    const idTraitement = document.getElementById('id_traitement_modal').textContent.trim();
    const numeroFacture = document.getElementById('numero_facture_modal')?.textContent.trim() || 'Inconnu';
    
    console.log("ID traitement récupéré :", idTraitement);

    if (!idTraitement) {
        showToast("Aucune facture sélectionnée !", 'bg-warning');
        return;
    }

    Swal.fire({
        title: `Valider la facture N° ${numeroFacture} ?`,
        text: "Cette opération est irréversible !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Oui, valider',
        cancelButtonText: 'Annuler',
        confirmButtonColor: '#198754', // vert
        cancelButtonColor: '#dc3545'   // rouge
    }).then((result) => {
        if (result.isConfirmed) {
            btn.disabled = true;

            fetch('http://localhost/crm-gga/app/codes/api/v1/valider_facture.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ idtt: idTraitement })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Réponse API :", data);
                if (data.status === 'success') {
                    showToast(data.message, 'bg-success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showToast("Erreur : " + data.message, 'bg-danger');
                }
            })
            .catch(error => {
                console.error('Erreur réseau ou serveur :', error);
                showToast("Erreur réseau ou serveur.", 'bg-danger');
            })
            .finally(() => {
                btn.disabled = false;
                const modalEl = document.getElementById('modalTraitementPrincipal');
                if (modalEl) {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                }
            });
        }
    });
});

</script>
<script>
$(document).ready(function () {
    
    $('#modalTraitement').on('shown.bs.modal', function () {
        const selectMedecin = document.getElementById('medecin');
        selectMedecin.innerHTML = '<option>Chargement...</option>';

        fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getGestionnaire')
            .then(response => response.json())
            .then(responseData => {
                console.log("Réponse de l'API :", responseData);

                if (responseData.status === 200 && Array.isArray(responseData.data)) {
                    selectMedecin.innerHTML = '';
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = '-- Sélectionnez --';
                    selectMedecin.appendChild(defaultOption);

                    responseData.data.forEach(agent => {
                        const option = document.createElement('option');
                        option.value = agent.idagent;
                        option.textContent = `${agent.nomagent} ${agent.postnomagent} ${agent.prenomagent}`;
                        selectMedecin.appendChild(option);
                    });
                } else {
                    console.error('Structure inattendue de la réponse', responseData);
                    selectMedecin.innerHTML = '<option>Erreur de chargement</option>';
                }
            })
            .catch(error => {
                console.error('Erreur lors du fetch :', error);
                selectMedecin.innerHTML = '<option>Erreur de chargement</option>';
            });
    });
   

});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function mettreAJourStatistiques() {
    fetch('http://localhost/crm-gga/app/codes/api/v1/getplaintes.php')
        .then(response => response.json())
        .then(result => {
            if (result.status === "success") {
                let traiteCount = 0;
                let attenteCount = 0;
                let enchargeCount = 0;

                result.data.forEach(item => {
                    switch (parseInt(item.statut)) {
                        case 1:
                            attenteCount++;
                            break;
                        case 2:
                            enchargeCount++;
                            break;
                        case 3:
                            traiteCount++;
                            break;
                    }
                });

                // Mise à jour DOM
                document.getElementById('statTotal').textContent = result.data.length;
                document.getElementById('statTraite').textContent = traiteCount;
                document.getElementById('statAttente').textContent = attenteCount;
                document.getElementById('statEncharge').textContent = enchargeCount;

                // Mise à jour du graphique si existant
                if (window.pieChart) {
                    window.pieChart.data.datasets[0].data = [traiteCount, attenteCount, enchargeCount];
                    window.pieChart.update();
                }
            }
        })
        .catch(error => {
            console.error("Erreur de récupération des statistiques :", error);
        });
}
document.addEventListener("DOMContentLoaded", function () {
    mettreAJourStatistiques();
});



// Variables globales
let currentPage = 1;
const itemsPerPage = 5;
let allPlaintes = [];

document.addEventListener('DOMContentLoaded', function () {
    const statutLabels = {
        "1": `<span class="text-danger">En attente</span>`,
        "2": `<span class="text-secondary">Prise en charge...</span>`,
        "3": `<span style="color:#3498db">Traité</span>`,
    };

    function displayPlaintes(plaintes, page = 1) {
        const tbody = document.querySelector('#ListePlainteTab tbody');
        tbody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        const plaintesToDisplay = plaintes.slice(startIndex, endIndex);

        if (plaintesToDisplay.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">Aucune plainte disponible</td></tr>`;
            return;
        }

        plaintesToDisplay.forEach((item, index) => {
            const row = `
                <tr>
                    <td>${startIndex + index + 1}</td>
                    <td class="text-start">${item.date_reception}</td>
                    <td class="text-start">${item.type_plaignant}</td>
                    <td class="text-start">${item.nom_plaignant}</td>
                    <td class="text-start">${item.cat_plainte}</td>
                    <td class="text-start">${item.moyen}</td>
                    <td class="text-start">${statutLabels[item.statut] || '<span class="text-dark">Inconnu</span>'}</td>
                    <td>
                    <button class="btn btn-sm btn-outline-danger btnVoirPlainte"
                        data-id="${item.idplainte}"
                        data-nom="${item.nom_plaignant}"
                        data-type="${item.type_plaignant}"
                        data-cat="${item.cat_plainte}"
                        data-desc="${item.descript}" 
                        data-statut="${item.statut}">
                        <i class="bi bi-eye"></i>
                    </button>
                    </td>

                </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        });

        updatePaginationPlaintes(plaintes.length, page);
    }

    function updatePaginationPlaintes(totalItems, page) {
        const pagination = document.getElementById('paginationPlaintes');
        pagination.innerHTML = '';

        const totalPages = Math.ceil(totalItems / itemsPerPage);
        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = 'btn btn-sm btn-outline-secondary mx-1';
            btn.textContent = i;
            btn.disabled = (i === page);
            btn.addEventListener('click', () => {
                currentPage = i;
                displayPlaintes(allPlaintes, i);
            });
            pagination.appendChild(btn);
        }
    }

    document.getElementById('searchPlaintes').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const filtered = allPlaintes.filter(item =>
            item.nom_plaignant.toLowerCase().includes(query) ||
            item.cat_plainte.toLowerCase().includes(query) ||
            item.date_reception.toLowerCase().includes(query)
        );
        displayPlaintes(filtered, 1);
    });

    window.loadPlaintes = function () {
        fetch('http://localhost/crm-gga/app/codes/api/v1/getplaintes.php')
            .then(async response => {
                const contentType = response.headers.get("content-type");

                if (!response.ok) {
                    throw new Error(`Erreur HTTP ${response.status}`);
                }

                if (contentType && contentType.includes("application/json")) {
                    return response.json();
                } else {
                    const text = await response.text();
                    throw new Error("Réponse non-JSON : " + text);
                }
            })
            .then(result => {
                if (result.status === "success" && Array.isArray(result.data)) {
                    allPlaintes = result.data;
                    displayPlaintes(allPlaintes, currentPage);
                } else {
                    document.querySelector('#ListePlainteTab tbody').innerHTML =
                        `<tr><td colspan="8" class="text-center text-muted">Aucune plainte enregistrée.</td></tr>`;
                    document.getElementById('paginationPlaintes').innerHTML = '';
                }
            })
            .catch(error => {
                console.error("Erreur lors du chargement des plaintes :", error);
                document.querySelector('#ListePlainteTab tbody').innerHTML =
                    `<tr><td colspan="8" class="text-center text-danger">Erreur lors du chargement des plaintes. Veuillez réessayer.</td></tr>`;
                document.getElementById('paginationPlaintes').innerHTML = '';
            });
    };

    //Chargement initial
    loadPlaintes();
});

document.addEventListener('click', function (e) {
    if (e.target.closest('.btnVoirPlainte')) {
        const btn = e.target.closest('.btnVoirPlainte');

        const id = btn.dataset.id;
        const nom = btn.dataset.nom;
        const type = btn.dataset.type;
        const cat = btn.dataset.cat;
        const desc = btn.dataset.desc;
        const statut = parseInt(btn.dataset.statut);

        // Injection dans le modal
        document.getElementById('modalIdPlainte').textContent = id;
        document.getElementById('modalNom').textContent = nom;
        document.getElementById('modalType').textContent = type;
        document.getElementById('modalCat').textContent = cat;
        document.getElementById('modalDesc').textContent = desc;

        // Gestion des boutons
        const btnPrise = document.getElementById('btnPriseEnCharge');
        const btnTraitee = document.getElementById('btnTraitement');

        btnPrise.disabled = (statut === 3);
        btnTraitee.disabled = (statut === 3);
        btnPrise.style.display = (statut === 1) ? 'inline-block' : 'none';
        btnTraitee.style.display = (statut === 2) ? 'inline-block' : 'none';

        // Stocker id pour action
        btnPrise.dataset.id = id;
        btnTraitee.dataset.id = id;

        // Ouvrir le modal
        new bootstrap.Modal(document.getElementById('modalPlainte')).show();
    }
});
document.getElementById('btnPriseEnCharge').addEventListener('click', function () {
    const idplainte = this.dataset.id;

    fetch('http://localhost/crm-gga/app/codes/api/v1/prise_en_charge_plainte.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idplainte: idplainte })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
            document.querySelector('#modalPlainte .btn-close').click();
            loadPlaintes(); // Recharger la liste
            mettreAJourStatistiques();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: data.message
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Erreur lors du traitement. Veuillez réessayer.'
        });
    });
});
document.getElementById('btnTraitement').addEventListener('click', function () {
    const idplainte = this.dataset.id;

    fetch('http://localhost/crm-gga/app/codes/api/v1/traite_plainte.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ idplainte: idplainte })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
            document.querySelector('#modalPlainte .btn-close').click();
            loadPlaintes(); // Recharger la liste
            mettreAJourStatistiques();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: data.message
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Erreur lors du traitement. Veuillez réessayer.'
        });
    });
});



// Lorsque le formulaire est soumis
document.getElementById('formPlainte').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/crm-gga/app/codes/api/v1/ajoutplainte.php', {
        method: 'POST',
        body: formData
    })
    .then(async response => {
        const contentType = response.headers.get("content-type");

        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }

        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            const text = await response.text(); // utile pour déboguer
            throw new Error("Réponse non JSON : " + text);
        }
    })
    .then(result => {
        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: result.message
            });

            // Revenir à la première page
            currentPage = 1;

            // Recharger les données + statistiques
            if (typeof loadPlaintes === "function") loadPlaintes();
            if (typeof mettreAJourStatistiques === "function") mettreAJourStatistiques();

            // Fermer le modal et reset le formulaire
            $('#modalAddPlainte').modal('hide');
            document.getElementById('formPlainte').reset();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: result.message
            });
        }
    })
    .catch(error => {
        console.error('Erreur lors de l\'enregistrement de la plainte :', error);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Une erreur est survenue : ' + error.message
        });
    });
});

function fetchActes() {
    fetch('http://localhost/crm-gga/app/codes/api/v1/get_actes.php')
    .then(response => response.json())
    .then(data => {
        const tableBody = document.querySelector('#tableActes tbody');
        tableBody.innerHTML = ''; // Réinitialise le contenu de la table

        if (data.data && data.data.length > 0) {
            // Si des données sont présentes, on les affiche
            data.data.forEach((actes, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-start">${actes.nom_acte}</td>
                        <td class="text-start"> ${actes.beneficiaire_acte}</td>
                        <td class="text-start">${actes.num_contrat}</td>
                        <td class="text-end">${Number(actes.montant_acte).toLocaleString('fr-CD', { style: 'currency', currency: 'USD' })}</td>
                        <td class="text-start">${actes.date_soin}</td>
                        <td class="text-start">${actes.nom_prestataire}</td>
                        
                        
                    </tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
           // attachTraitementBtnEvents();
           // calculerStatistiques(data.data);
        } else {
            // Si aucune donnée n'est présente, on affiche "Pas de factures disponibles"
            const noDataRow = `
                <tr>
                    <td colspan="12" class="text-center text-danger">Pas d'actes' disponibles</td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', noDataRow);
        }
    })
    .catch(error => {
        showToast('Erreur', "Une erreur s'est produite lors de la récupération des données.", 'danger');
    });
}
document.addEventListener("DOMContentLoaded", function () {
    fetchActes();
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  affichestatActe()
});
function affichestatActe() {
  fetch('http://localhost/crm-gga/app/codes/api/v1/State-actes.php')
    .then(response => response.json())
    .then(data => {
      document.getElementById('nbr_acte').textContent = data.total_actes;
      document.getElementById('nbr_benef').textContent = data.total_beneficiaires;
      document.getElementById('montantTotalActes').textContent = Number(data.montant_total).toLocaleString('fr-CD', {
        style: 'currency',
        currency: 'USD'
      });

      // 🔄 Nouveau traitement pour les actes fréquents
      const actes = data.actes_plus_frequents;
      const frequence = data.nb_acte_plus_frequent;

      // Affichage dans le HTML
      const acteElement = document.getElementById('nomactePlusFrequent');
      acteElement.textContent = actes.join(', '); // ➜ affiche tous les actes séparés par des virgules

      document.getElementById('nbrDeFrequence').textContent = `(${frequence})`;
    })
    .catch(error => {
      console.error('Erreur lors du chargement des stats:', error);
    });
}


</script>
<script>
document.getElementById('formActe').addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  formData.append('iduser', 1); // remplace 1 par l'ID de l'utilisateur connecté

  fetch('http://localhost/crm-gga/app/codes/api/v1/insert_actes.php', {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        Swal.fire({
          icon: 'success',
          title: 'Succès',
          text: response.message,
          timer: 2000,
          showConfirmButton: false
        });

        document.getElementById('formActe').reset();
        affichestatActe();
        fetchActes();
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: response.message
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        icon: 'error',
        title: 'Erreur réseau',
        text: 'Une erreur est survenue.'
      });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  fetch('http://localhost/crm-gga/app/codes/api/v1/getPrestataires.php') // remplace par le bon chemin
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        const select = document.getElementById('prestataire');
        // Option par défaut
        select.innerHTML = '<option value="">-- Sélectionnez un prestataire --</option>';

        data.data.forEach(prestataire => {
          const option = document.createElement('option');
          option.value = prestataire.id_prestataire; // ou autre clé selon la BDD
          option.textContent = prestataire.nom_prestataire; // ou nom complet si dispo
          select.appendChild(option);
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: 'Impossible de charger la liste des prestataires.'
        });
      }
    })
    .catch(error => {
      console.error('Erreur lors de la récupération des prestataires:', error);
      Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: 'Une erreur s’est produite lors du chargement des prestataires.'
      });
    });
});
</script>

</body>
</html>