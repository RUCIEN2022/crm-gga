<?php 
//session_start();
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
    <title>FINANCE REPORTING</title>
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
        <a href="../finance/" class="btn text-light fw-bold" style="background-color:#3498db">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
        </div>
    <div class="row g-3">
        <!-- Menu -->
    <div class="row text-center p-3">
        <div class="head d-flex justify-content-start align-items-center">
            <div class="simple-menu">
                <a class="active" onclick="showSection('factures')">Journal des transactions</a>
                <a onclick="showSection('traitement')">Journal de banque</a>
                <a onclick="showSection('plaintes')">Journal de caisse</a>
                
            </div>
        </div>
    </div>
        <!-- Section : Journal des transactions -->
        <div id="factures" class="section-content active">
        <div class="row text-center">
        <div class="col-12">
        <div class="head d-flex justify-content-between align-items-center mb-2">
           
        </div>
            <!-- Dashboard de traitement des factures -->
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="date_debut" class="form-label">Du :</label>
                <input type="date" id="date_debut" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label">Au :</label>
                <input type="date" id="date_fin" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-sm btn-primary me-2" onclick="rechercherJO()">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <button class="btn btn-sm btn-danger" onclick="imprimerJournal()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
            </div>
        </div>

        <div class="table-responsive">
                <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center" >
                
                    
                <div class="btn-group" role="group" aria-label="Exportation">
                    <button class="btn btn-outline-success me-2" id="exportExcel">
                        <i class="bi bi-file-earmark-excel"></i>
                    </button>
                </div>

                <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Rechercher une transaction"
                    />
            </h5>

                <table id="journalTable" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                        <th>#</th>
                        <th>Date du jour </th>
                        <th>Opération</th>
                        <th>Compte</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- Ajoutez d'autres lignes ici -->
                    </tbody>
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


        <div class="row mb-3">
            <div class="col-md-3">
                <label for="date_debut" class="form-label">Du :</label>
                <input type="date" id="date_debut1" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label">Au :</label>
                <input type="date" id="date_fin1" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-sm btn-primary me-2" onclick="rechercherJB()">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <button class="btn btn-sm btn-danger" onclick="imprimerJB()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
            </div>
        </div>

        <div class="text-start">
            <div class="table-responsive">
                <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center" >
                    
                        
                    <div class="btn-group" role="group" aria-label="Exportation">
                        <button class="btn btn-outline-success me-2" id="exportExcel">
                            <i class="bi bi-file-earmark-excel"></i>
                        </button>
                    </div>

                    <input
                            type="text"
                            id="searchInput1"
                            class="form-control w-50"
                            placeholder="Rechercher une transaction"
                        />
                </h5>
                    <table id="tableJB" class="table table-bordered table-striped table-hover table-sm">
                        <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                            <tr>
                                <th>#</th>
                                <th>Date du jour </th>
                                <th>Bénéficiaire</th>
                                <th>Crédit</th>
                                <th>Débit</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- Section : Gestion des Plaintes -->
    <div id="plaintes" class="section-content">
      
    <div class="row mb-3">
            <div class="col-md-3">
                <label for="date_debut" class="form-label">Du :</label>
                <input type="date" id="date_debut2" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label">Au :</label>
                <input type="date" id="date_fin2" class="form-control form-control-sm">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-sm btn-primary me-2" onclick="rechercherJC()">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <button class="btn btn-sm btn-danger" onclick="imprimerJC()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
            </div>
        </div>

        <div class="text-start">
            <div class="table-responsive">
                <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center" >
                    
                        
                    <div class="btn-group" role="group" aria-label="Exportation">
                        <button class="btn btn-outline-success me-2" id="exportExcel2">
                            <i class="bi bi-file-earmark-excel"></i>
                        </button>
                    </div>

                    <input
                            type="text"
                            id="searchInput2"
                            class="form-control w-50"
                            placeholder="Rechercher une transaction"
                        />
                </h5>
                    <table id="tableJC" class="table table-bordered table-striped table-hover table-sm">
                        <thead class="text-lower" style="background-color: #923a4d;font-size:10px;">
                            <tr>
                                <th>#</th>
                                <th>Date du jour </th>
                                <th>Bénéficiaire</th>
                               
                                <th>Crédit</th>
                                <th>Débit</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
    


<!-- Ajoute les bibliothèques nécessaires-->
    <!-- XLSX pour Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- jsPDF + autoTable pour PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <!-- fin -->
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


function imprimerJournal() {
    const dateDebut = document.getElementById('date_debut').value;
    const dateFin = document.getElementById('date_fin').value;

    if (!dateDebut || !dateFin) {
        alert("Veuillez sélectionner une plage de dates.");
        return;
    }

    const url = `../impression/JO.php?date_debut=${dateDebut}&date_fin=${dateFin}`;
    window.open(url, '_blank');
}
function rechercherJC(){
    const debut = document.getElementById('date_debut2').value;
    const fin = document.getElementById('date_fin2').value;
    //alert("ok" + debut);
    if (!debut || !fin) {
        alert("Veuillez sélectionner une plage de dates.");
        return;
    }
    const formData = {
            date1: debut,
            date2: fin
        };
        console.log("Début appel API rechercheJB :", formData);
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/rechercheJC', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#tableJC tbody');
                    tableBody.innerHTML = '';
                    let i = 1;
                    if (Array.isArray(data)) {
                        //console.log("Données API :", data);
                        // alert("API répondue !");
                        data.forEach(jo => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${i}</td>
                                <td>${jo.date_operation}</td>
                                <td>${jo.beneficiaire}</td>
                                 
                                <td>${jo.entree_fond}</td>
                                <td>${jo.sortie_fond}</td>
                                <td>${jo.solde}</td>
                                
                            `;
                            tableBody.appendChild(row);
                            i++;
                        });

                        //updatePagination();
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucune transaction trouvée</td>';
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des transactions :', error));
}
function rechercherJB(){
    const debut = document.getElementById('date_debut1').value;
    const fin = document.getElementById('date_fin1').value;
    //alert("ok" + debut);
    if (!debut || !fin) {
        alert("Veuillez sélectionner une plage de dates.");
        return;
    }
    const formData = {
            date1: debut,
            date2: fin
        };
        console.log("Début appel API rechercheJB :", formData);
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/rechercheJB', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#tableJB tbody');
                    tableBody.innerHTML = '';
                    let i = 1;
                    if (Array.isArray(data)) {
                        //console.log("Données API :", data);
                        // alert("API répondue !");
                        data.forEach(jo => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${i}</td>
                                <td>${jo.date_operation}</td>
                                <td>${jo.beneficiaire}</td>
                                <td>${jo.libbanque}</td>
                                <td>${jo.entree_fond}</td>
                                <td>${jo.sortie_fond}</td>
                                <td>${jo.solde}</td>
                                
                            `;
                            tableBody.appendChild(row);
                            i++;
                        });

                        //updatePagination();
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucune transaction trouvée</td>';
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des transactions :', error));
}

function rechercherJO() {
    const debut = document.getElementById('date_debut').value;
    const fin = document.getElementById('date_fin').value;

    if (!debut || !fin) {
        alert("Veuillez sélectionner une plage de dates.");
        return;
    }
    const formData = {
            date1: debut,
            date2: fin
        };

            
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/afficherJO', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#journalTable tbody');
                    tableBody.innerHTML = '';
                    let i = 1;
                    if (Array.isArray(data)) {
                        data.forEach(jo => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${i}</td>
                                <td>${jo.datejour}</td>
                                <td>${jo.typeOperation}</td>
                                <td>${jo.libcompte}</td>
                                <td>${jo.montantcredit}</td>
                                <td>${jo.montantdebit}</td>
                                
                            `;
                            tableBody.appendChild(row);
                            i++;
                        });

                        updatePagination();
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucune transaction trouvée</td>';
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des transactions :', error));
   
    }



// Recherche dynamique
document.getElementById("searchInput").addEventListener("input", function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#journalTable tbody tr");
    rows.forEach((row) => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    
    });

 });

// pagination GPT
// Fonction de mise à jour de la pagination
function updatePagination() {
    const table = document.getElementById("journalTable");
    const rowsPerPage = 5;
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const pagination = document.getElementById("pagination");

    function renderTable(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? "" : "none";
        });
}

function renderPagination() {
        const pageCount = Math.ceil(rows.length / rowsPerPage);
        pagination.innerHTML = "";

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement("li");
            li.className = "page-item";
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            
            li.addEventListener("click", (e) => {
                e.preventDefault();
                renderTable(i);

                document.querySelectorAll(".page-item").forEach((item) => item.classList.remove("active"));
                li.classList.add("active");
            });

            pagination.appendChild(li);
        }

        if (pagination.firstChild) {
            pagination.firstChild.classList.add("active");
        }

            renderTable(1); // Afficher la première page par défaut
    }

            renderPagination();
}

     // Exporter Excel
    document.getElementById('exportExcel').addEventListener('click', () => {
        const wb = XLSX.utils.book_new();
        const table = document.getElementById('journalTable');
        const ws = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(wb, ws, 'JOURNAL_TRANSACTION');
        XLSX.writeFile(wb, 'journal.xlsx');
   });

</script>







</body>
</html>