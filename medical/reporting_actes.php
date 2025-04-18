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

     
        <!-- Fin Pagination -->
            </div>
        </div>

    </div>
    <!-- Section : Traitement factures -->
   
    <!-- Section : Actes médicaux -->
<div class="section-content mt-4" id="actes">
  <div class="row">
    <!-- Bloc gauche -->
    <div class="col-md-12">
      <div class="card shadow-sm">
      <div class="card-header bg-light d-flex justify-content-between align-items-center">
  <h6 class="mb-0">
    <i class="bi bi-list-check"></i> Liste des actes plafonnés
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








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="script.js"></script>

</body>
</html>