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
                <a onclick="showSection('plaintes')">Transmission décomptes</a>
                
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
            <!-- Dashboard de traitement des factures -->
            <div class="row" id="statistiquesTraitement">
            <div class="col-md-3 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">Total factures affectées</h6>
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
                            <h6 class="mb-0">Total Traitées</h6>
                            <h4 id="totalTraite" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-check-circle fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">Total Rejetées</h6>
                            <h4 id="totalRejete" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-x-circle fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <div class="card bg-white border shadow-sm rounded-3">
                    <div class="card-body d-flex justify-content-between align-items-center text-danger">
                        <div>
                            <h6 class="mb-0">En cours</h6>
                            <h4 id="totalEncours" class="mb-0 fw-bold">0</h4>
                        </div>
                        <i class="bi bi-hourglass-split fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-2">
    <div class="card bg-white border shadow-sm rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center text-danger">
            <div>
                <h6 class="mb-0">En retard</h6>
                <h4 id="totalRetard" class="mb-0 fw-bold">0</h4>
            </div>
            <i class="bi bi-exclamation-circle fs-2 text-danger"></i>

        </div>
    </div>
</div>

        </div>
        <div class="table-responsive">
            <table id="FactureTable" class="table table-bordered table-striped table-hover table-condensed table-sm">
                <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                    <h5 class="text-start fw-bold">Toutes les factures disponibles</h5>
                    <tr>
                        <th>#</th>
                        <th>Num_fact</th>
                        <th>Montant</th>
                        <th>Tp</th>
                        <th>Rd</th>
                        <th>Prestataire</th>
                        <th>Période de facturation</th>
                        <th>Revue par le médécin conseil</th>
                        <th>Affectation</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px;"></tbody>
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



        <div class="text-start">
            <div class="table-responsive">
                    <table id="TraitementFactTab" class="table table-bordered table-striped table-hover table-sm">
                        <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                            <tr>
                                <th>#</th>
                                <th>Num_fact</th>
                                <th>Tp</th>
                                <th>Rd</th>
                                <th>Total_facture</th>
                                <th>Montant à payer</th>
                                <th>Prestataire</th>
                                <th>Période</th>
                                <th>Gestionnaire</th>
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
                            <i class="bi bi-table"></i> Décomptes
                        </h6>
                        <button class="btn btn-outline-danger rounded-pill px-4 shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalAddPlainte">
                            <i class="bi bi-plus-circle-fill fs-5"></i> 
                            <span class="fw-semibold">Transmission décompte</span>
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

<!-- Modal Affectation Facture -->
<div class="modal fade" id="modalAffectationFact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f1f1f1;">
        <h5 class="modal-title" id="modalLabel">Traitement Facture - [ Affectation Gestionnaire ]</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <form id="affectFactForm">
          <input type="hidden" id="id_facture" name="id_facture">
          <input type="hidden" id="montant_facture" name="montant_facture">
            <div class="row">
            <div class="col-md-6 mb-3">
            <label for="numero_facture" class="form-label">Numéro Facture</label>
            <input type="text" class="form-control" id="numero_facture" name="numero_facture" readonly style="background-color: #f1f1f1;">
          </div>
          <div class="col-md-6 mb-3">
            <label for="gestionnaire" class="form-label">Gestionnaire</label>
            <select id="gestionnaire" class="form-select" style="width: 100%;font-size:12px">
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
            <button type="submit" class="btn btn-outline-danger btn-lg"> <i class="bi bi-check-circle"></i> Affecter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Principal -->
<div class="modal fade" id="modalTraitementSinistre" tabindex="-1" aria-labelledby="modalTraitementSinistreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTraitementSinistreLabel">Opération de traitement - [ Détails de la Facture ]</h5>
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
                            <td class="font-weight-bold text-muted">
                                <span id="numero_facture_modal"></span> 
                                <span class="mx-2">|</span> 
                                <span id="statut_modal" class="badge bg-danger p-1"></span>
                            </td>
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
                            <th scope="row">Période de prestation</th>
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
                <div class="mb-3">
                    <label for="montant_a_payer" class="form-label">Montant à payer</label>
                    <input type="text" class="form-control" id="montant_a_payer" placeholder="Entrez le montant à payer">
                </div>
                <div class="mb-3">
                    <label for="observations" class="form-label">Observations</label>
                    <textarea class="form-control" id="observations" rows="3" placeholder="Entrez des observations"></textarea>
                </div>
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
<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
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
document.addEventListener('DOMContentLoaded', () => {
    let allFactures = [];
    let currentPage = 1;
    const rowsPerPage = 10;

    initApp(); // Démarre tout au chargement de la page

    // === INITIALISATION GLOBALE ===
    function initApp() {
        loadFactures();
        chargerStatistiques();
        bindFormAffectation();
    }

    // === CHARGEMENT DES FACTURES ===
    function loadFactures() {
        fetch('http://localhost/crm-gga/app/codes/api/v1/getfacture_niv2.php')
            .then(res => res.json())
            .then(data => {
                if (data?.data?.length > 0) {
                    allFactures = data.data;
                    renderTableWithPagination(allFactures);
                } else {
                    displayEmptyTable("Pas de factures disponibles");
                }
            })
            .catch(() => displayEmptyTable("Erreur de chargement des données"));
    }

    function renderTableWithPagination(data) {
        const paginated = paginate(data, currentPage);
        displayFactures(paginated);
        renderPagination(data);
    }

    function paginate(data, page) {
        const start = (page - 1) * rowsPerPage;
        return data.slice(start, start + rowsPerPage);
    }

    function displayFactures(factures) {
        const tbody = document.querySelector('#FactureTable tbody');
        tbody.innerHTML = '';

        factures.forEach((f, i) => {
            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${i + 1}</td>
                    <td class="text-start">${f.numero_facture}</td>
                    <td class="text-end">$ ${f.montant_facture}</td>
                    <td class="text-end">${f.tp}</td>
                    <td class="text-end">${f.rd}</td>
                    <td class="text-start">${f.nom_prestataire}</td>
                    <td class="text-start">${f.periode_prestation}</td>
                    <td class="text-start">${f.Prenom_medecin} ${f.Nom_medecin}</td>
                    <td>
                        <button class="btn btn-outline-danger p-1 px-2 open-modal-btn"
                            style="font-size: 0.7rem;"
                            data-id="${f.id_facture}"
                            data-num="${f.numero_facture}"
                          
                            data-mont="${f.montant_facture}">
                            <i class="bi bi-person-plus"></i>
                        </button>
                    </td>
                </tr>`);
        });

        bindModalButtons();
    }

    function renderPagination(data) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        const pages = Math.ceil(data.length / rowsPerPage);
        for (let i = 1; i <= pages; i++) {
            const btn = document.createElement('button');
            btn.className = `btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} mx-1`;
            btn.textContent = i;
            btn.onclick = () => {
                currentPage = i;
                renderTableWithPagination(data);
            };
            pagination.appendChild(btn);
        }
    }

    function displayEmptyTable(message) {
        const tbody = document.querySelector('#FactureTable tbody');
        tbody.innerHTML = `<tr><td colspan="10" class="text-center text-danger">${message}</td></tr>`;
    }

    // === RECHERCHE ===
    document.getElementById('searchInput')?.addEventListener('input', e => {
        const query = e.target.value.toLowerCase();
        const filtered = allFactures.filter(f =>
            f.numero_facture.toLowerCase().includes(query) ||
            f.nom_prestataire.toLowerCase().includes(query)
        );
        currentPage = 1;
        renderTableWithPagination(filtered);
    });

    // === MODAL BINDING ===
    function bindModalButtons() {
        document.querySelectorAll('.open-modal-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const { id, num, debut, fin, mont } = btn.dataset;
                document.getElementById('id_facture').value = id;
                document.getElementById('numero_facture').value = num;
                document.getElementById('date_debut').value = debut;
                document.getElementById('date_fin').value = fin;
                document.getElementById('montant_facture').value = mont;
                loadGestionnaires();
                new bootstrap.Modal(document.getElementById('modalAffectationFact')).show();
            });
        });
    }

    // === GESTIONNAIRES ===
    function loadGestionnaires() {
        fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getGestionnaire')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('gestionnaire');
                select.innerHTML = `<option value="">-- Sélectionnez --</option>`;

                if (data.status === 200 && Array.isArray(data.data)) {
                    data.data.forEach(g => {
                        select.insertAdjacentHTML('beforeend', `
                            <option value="${g.idagent}">
                                ${g.nomagent} ${g.postnomagent} ${g.prenomagent}
                            </option>`);
                    });
                }
            })
            .catch(err => console.error("Erreur chargement gestionnaires", err));
    }

    // === FORMULAIRE AFFECTATION ===
    function bindFormAffectation() {
        document.getElementById('affectFactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const payload = {
                id_facture: document.getElementById('id_facture').value,
                numero_facture: document.getElementById('numero_facture').value,
                date_debut: document.getElementById('date_debut').value,
                date_fin: document.getElementById('date_fin').value,
                montant_facture: document.getElementById('montant_facture').value || 0,
                gestionnaire: document.getElementById('gestionnaire').value
            };

            if (!payload.gestionnaire) {
                showToast("Veuillez sélectionner un gestionnaire", "danger");
                return;
            }

            fetch('http://localhost/crm-gga/app/codes/api/v1/affect_facture.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        showToast(resp.message, "success");
                        bootstrap.Modal.getInstance(document.getElementById('modalAffectationFact')).hide();
                        this.reset();
                        loadFactures(); // Recharger les factures
                        chargerStatistiques(); // Recharger les stats
                    } else {
                        showToast(resp.message, "danger");
                    }
                })
                .catch(() => showToast("Erreur de communication avec le serveur", "danger"));
        });
    }

    // === TOAST NOTIFICATIONS ===
    function showToast(message, type = "info") {
        const container = document.getElementById('toast-container') || createToastContainer();
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
        toast.setAttribute("role", "alert");
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        document.body.appendChild(container);
        return container;
    }

    // === STATS ===
    function chargerStatistiques() {
        fetch('http://localhost/crm-gga/app/codes/api/v1/State-factAffect.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    document.getElementById("totalRecu").textContent = data.total_fact;
                    document.getElementById("totalEncours").textContent = data.total_encours;
                    document.getElementById("totalTraite").textContent = data.total_traitee;
                    document.getElementById("totalRejete").textContent = data.total_rejetee;
                    document.getElementById("totalRetard").textContent = data.total_retard;
                }
            })
            .catch(err => console.error("Erreur stats:", err));
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    fetch("http://localhost/crm-gga/app/codes/api/v1/maj_factRetard.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Statuts mis à jour :", data.message);
            } else {
                console.error("Erreur API :", data.message);
            }
        })
        .catch(error => {
            console.error("Erreur réseau :", error);
        });
});
</script>
<script>
    //---Traitement-Facture---//
document.addEventListener('DOMContentLoaded', function () {
    function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(amount);
}
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mois commence à 0
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}


    fetch('http://localhost/crm-gga/app/codes/api/v1/get_traitement_sinistre.php')
        .then(response => response.json())
        .then(result => {
            if (result.success && Array.isArray(result.data)) {
                const tableBody = document.querySelector('#TraitementFactTab tbody');
                tableBody.innerHTML = ''; 

                result.data.forEach((item, index) => {
                    const row = document.createElement('tr');

                    const statutLabel = getStatutLabel(item.statut);
                    const statutClass = getStatutClass(item.statut);

                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${item.numero_facture}</td>
                        <td>${formatCurrency(item.tp)}</td>
                        <td>${formatCurrency(item.rd)}</td>
                        <td>${formatCurrency(item.total_fact)}</td>
                        <td>${formatCurrency(item.montant_apyer)}</td>
                        <td>${item.nom_prestataire}</td>
                        <td>${item.periode_prestation}</td>
                        <td>${item.prenom_gestionnaire} ${item.nom_gestionnaire}</td>
                        <td>${formatDate(item.datedebut)}</td>
                        <td>${formatDate(item.datefin)}</td>
                        <td><span class="badge ${statutClass}">${statutLabel}</span></td>
                        <td>
                        <button class="btn btn-outline-danger p-1 px-2 open-modal-btn"
                            style="font-size: 0.7rem;"
                            data-id="${item.id_facture}"
                            data-num="${item.numero_facture}"
                            data-mont="${formatCurrency(item.total_fact)}"
                            data-prest="${item.nom_prestataire}"
                            data-periode="${item.periode_prestation}"
                            data-fin="${formatDate(item.datefin)}"
                            data-stat="${statutLabel}"
                            data-obs="${item.observ}">
                            <i class="bi bi-person-plus"></i>
                        </button>
                    </td>

                    `;
                    tableBody.appendChild(row);
                });
            } else {
                console.warn("Aucune donnée trouvée.");
            }

            document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', function() {
            const idFacture = this.getAttribute('data-id');
            const numeroFacture = this.getAttribute('data-num');
            const montantFacture = this.getAttribute('data-mont');
            const nomPrestataire = this.getAttribute('data-prest');
            const periodePrestation = this.getAttribute('data-periode');
            const statut = this.getAttribute('data-stat');
            const dateFin = this.getAttribute('data-fin');
            const observations = this.getAttribute('data-obs');

            const modalElement = document.getElementById('modalTraitementSinistre');
            const modal = new bootstrap.Modal(modalElement);

            document.getElementById('id_traitement_modal').textContent = idFacture;
            document.getElementById('numero_facture_modal').textContent = numeroFacture;
            document.getElementById('montant_facture_modal').textContent = montantFacture;
            document.getElementById('nom_prestataire_modal').textContent = nomPrestataire;
            document.getElementById('periode_prest_modal').textContent = periodePrestation;
            document.getElementById('datefin_modal').textContent = dateFin;
            document.getElementById('statut_modal').textContent = statut;
            document.getElementById('descript_modal').textContent = observations;

            modal.show();
        });
    });





        })
        .catch(error => {
            console.error("Erreur lors du chargement des données:", error);
        });

    function getStatutLabel(code) {
        switch (parseInt(code)) {
            case 1: return 'En cours';
            case 2: return 'Traitée';
            case 3: return 'Rejetée';
            case 4: return 'En retard';
            default: return 'Inconnu';
        }
    }

    function getStatutClass(code) {
        switch (parseInt(code)) {
            case 1: return 'text-warning';
            case 2: return 'text-success';
            case 3: return 'text-danger';
            case 4: return 'text-secondary';
            default: return 'text-dark';
        }
    }

});
</script>


</body>
</html>