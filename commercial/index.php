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
    <title>CRM-GGA Commercial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">

    
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
        max-width: 650px;
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
        <div class="row g-3">
            <!-- Navigation -->
            <div class="custom-navbar">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#userModal">
                            <i class="bi bi-person-plus"></i> Nouveau Prospect
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#ParModal">
                            <i class="bi bi-file-earmark-text"></i> Création des produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#PvModal" >
                            <i class="bi bi-file-earmark-text"></i> Vente des produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" >
                            <i class="bi bi-file-earmark-text"></i> REPORTING
                        </a>
                    </li>

                </ul>
            </div>
         <hr>
<div class="row text-center">
    <!-- Total Contrats -->
    <div class="col-md-3">
        <a href="total-contrats.html" class="text-decoration-none">
            <div class="card shadow hover-effect" style="border: #923a4d solid 1px;">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        <i class="bi bi-file-earmark"></i> Total prospect
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="TotalPropect">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- En cours de gestion -->
    <div class="col-md-3">
        <a href="en-cours-gestion.html" class="text-decoration-none">
            <div class="card shadow hover-effect" style="border: #923a4d solid 1px;">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        <i class="bi bi-gear"></i> Total clients enregistrés
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="Totalclient">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- En suspension -->
    <div class="col-md-3">
        <a href="en-suspension.html" class="text-decoration-none">
            <div class="card shadow hover-effect" style="border: #923a4d solid 1px;">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        <i class="bi bi-pause-circle"></i> Total produits 
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;"  id="Totalproduit">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
    <!-- En résiliation -->
    <div class="col-md-3">
        <a href="en-resiliation.html" class="text-decoration-none">
            <div class="card shadow hover-effect" style="border: #923a4d solid 1px;">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        <i class="bi bi-x-circle text-danger"></i> Total produits vendus
                    </h5>
                    <div class="circle-value border border-danger shadow text-light mx-auto" style="background-color: #923a4d;" id="Totalproduitvendu">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


    <!-- Tableau liste classeurs contrats -->
    <div class="table-responsive">
          

            <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center" >
           
            
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
                        <th>Type Operation</th>
                        <th>Compte</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      
                      <!-- Ajoutez d'autres lignes ici -->
                  </tbody>
              </table>
    </div>

          <!-- Pagination -->
          <nav>
              <ul class="pagination justify-content-center" id="pagination">
                  <!-- Pagination dynamique -->
              </ul>
          </nav>

      </div>
    </div>
</div>
    </div>
</div>



<!-- Modal Journal -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Journal des transactions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="clientForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="datejour" placeholder="" required>
                                        <label for="datejour">Date</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="typeOperation" id="typeOperation" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                            <option value="1">Recette</option>
                                            <option value="2">Depense</option>
                                        </select>
                                        <label for="typeOperation">Type Operation</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                   <div class="form-floating">
                                        <select name="idcompte" id="idcompte" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="idcompte">Compte    | Solde disponible : <input type="text" id="solde" value="0" readonly ></label>
                                       
                                    </div>
                                </div>
                                <!-- banque-->
                                <div class="col-md-6" id="bankSelectContainer" style="display:none;">
                                    <div class="form-floating">
                                        <select name="bankList" id="bankList" class="form-select" style="font-size: 12px;border: solid 1px #ccc;">
                                            <option value="0">--Choisir une banque--</option>
                                        </select>
                                        <label for="bankList">Banque</label>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="motif" placeholder="Motif" required>
                                        <label for="motif">Motif</label>
                                    </div>
                                </div>
                               
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="beneficiaire" placeholder="Source / Beneficiaire " required>
                                        <label for="beneficiaire">Source/Beneficiaire </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ref_oper" placeholder="Reference " required>
                                        <label for="ref_oper">Reference </label>
                                    </div>
                                </div>
                                
                            </div>
                               <!-- Section 3 -->
                               <div class="row g-3 mb-1">
                                   <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="montant" placeholder="Montant" required style="text-align: right;">
                                            <label for="montant">Montant </label>
                                        </div>
                                   </div>
                               </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormJournal()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal creation utilisateur -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Création prospect</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="UserForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom" placeholder="Saisir nom" required>
                                        <label for="date_soin">Nom :</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adresse" placeholder="Saisir adresse" required>
                                        <label for="adresse">Adresse :</label>
                                    </div>
                                </div>
                            
                            </div>
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="telephone" placeholder="Téléphone" required>
                                        <label for="telephone">Téléphone :</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="E-mail" required>
                                        <label for="email">E-mail :</label>
                                    </div>
                                </div>
                            
                            </div>
                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_prospection" placeholder="Date prospection" required>
                                        <label for="date_prospection">Date prospection :</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="moyen_contact_id" id="moyen_contact_id" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="moyen_contact_id">Moyen de Contact :</label>
                                    </div>
                                </div>
                       
                            </div>
                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                 <div class="col-md-12">
                                    <div class="form-floating">
                                        <select name="type_prospect_id" id="type_prospect_id" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="type_prospect_id">Type :</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormProspect()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormUser()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal creation produit -->
<div class="modal fade" id="ParModal" tabindex="-1" aria-labelledby="ParModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Création Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ParForm" class="p-3">
                           <!-- Section 1 -->
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom1" placeholder="Désignation" required>
                                        <label for="nom1">Désignation</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="formule" placeholder="Formule" required>
                                        <label for="formule">Formule </label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="type_gestion" id="type_gestion" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="">--Choisir--</option>
                                            <option value="Assurance">Assurance</option>
                                            <option value="Autofinancement">Autofinancement</option>
                                        </select>
                                        <label for="type_gestion">Type gestion</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="montant_annuel" placeholder="Montant Annuel" required>
                                        <label for="montant_annuel">Montant Annuel</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <!-- Section 5 -->
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="submitFormProduit()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                             
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal vente de produits -->
<div class="modal fade" id="PvModal" tabindex="-1" aria-labelledby="PvModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Vente de Produit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ParForm" class="p-3">
                           <!-- Section 1 -->
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="client_id" id="client_id" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="">--Choisir--</option>
                                        </select>
                                        <label for="client_id">Client</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="produit_id" id="produit_id" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="">--Choisir--</option>
                                        </select>
                                        <label for="produit_id">Produit</label>
                                    </div>
                                </div>
                               
                                
                            </div>
                                <br>
                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                            
                                   <div class="form-floating">
                                       <button type="button" class="btn btn-success w-100" onclick="ajouterProduit()">Ajouter <i class="fas fa-spinner spinner"></i></button>
                                   </div>
                               
                                </div>
                                
                            </div>
                            
                            <!-- Section Tableau -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                
                                    <table id="tableVentes" class="table table-striped table-hover align-middle">
                                    <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center"> Produits ajoutés </h5>    
                                    <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Code Produit</th>
                                                <th>Désignation</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <!-- Ajoutez d'autres lignes ici -->
                                        </tbody>
                                    </table>
                                   
                                </div>
                                
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="submitFormVente()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                             
                </form>
            </div>
        </div>
    </div>
</div>






<!-- Modal checklist amélioré -->
<div class="modal fade" id="formChecklist" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="formModalLabel">Check-list Mise en place Police / Contrat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="policeContrat" class="form-label fw-bold">📄 Police / Contrat</label>
                            <input type="text" class="form-control" id="policeContrat" placeholder="Entrez le numéro">
                        </div>
                        <div class="col-md-6">
                            <label for="dateEffet" class="form-label fw-bold">📅 Date d'effet</label>
                            <input type="date" class="form-control" id="dateEffet">
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ajoutBeneficiaire">
                                <label class="form-check-label" for="ajoutBeneficiaire">➕ Ajouter Bénéficiaire</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="retraitBeneficiaire">
                                <label class="form-check-label" for="retraitBeneficiaire">➖ Retrait Bénéficiaire</label>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="accordion" id="checklistAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#checklistTasks" aria-expanded="true">
                                    📌 Étapes de validation
                                </button>
                            </h2>
                            <div id="checklistTasks" class="accordion-collapse collapse show" data-bs-parent="#checklistAccordion">
                                <div class="accordion-body">
                                    <div class="row g-3 p-2 mt-2" style="background-color:whitesmoke">
                                        <div class="col-md-4">
                                            <label class="form-label">Validation contrat Assureur / Réassureur</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="validationContrat">
                                                <label class="form-check-label" for="validationContrat">Activé</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mt-2 p-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Création produit / Souscripteur</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">📅 Date création Amiral</label>
                                        <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2" style="background-color:whitesmoke">
                                        <div class="col-md-4">
                                            <label class="form-label">Réception liste bénéficiaire</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">📅 Date récéption</label>
                                        <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Récéption KYC, fiche d'incorp, photo</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">📅 Date récéption</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2" style="background-color:whitesmoke">
                                        <div class="col-md-4">
                                            <label class="form-label">Intégration bébéficiaire sur Amiral</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="">📅 Date intégration</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2">
                                        <div class="col-md-3">
                                            <label class="form-label">Impression cartes santé</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <label for="">📅 Date début impression</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                        <div class="col-md-3">
                                        <label for="">📅 Date fin impression</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2" style="background-color:whitesmoke">
                                        <div class="col-md-4">
                                            <label class="form-label">Controle et validation cartes santé</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="">📅 Date validation</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Transmission cartes santé</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="">📅 Date transmission</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2 p-2" style="background-color:whitesmoke">
                                        <div class="col-md-4">
                                            <label class="form-label">Formation parcours de soins</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <label for="">📅 Date formation</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label">Facture/Appel de fonds</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="creationProduit">
                                                <label class="form-check-label" for="creationProduit">Activé</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        <label for="">📅 Date facturation</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                        <div class="col-md-3">
                                        <label for="">📅 Date transmission</label>
                                            <input type="date" class="form-control" placeholder="Date création">
                                        </div>
                                    </div>
                                   
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger w-100"><i class="bi bi-pencil"></i> Compléter</button>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info w-100"><i class="bi bi-save"></i> Enregistrer</button>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', fetchPartners);

        function fetchPartners() {
            fetch('http://localhost/crm-gga/app/codes/api/v1/api_finance.php/JO')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#journalTable tbody');
                    tableBody.innerHTML = '';
                    let i = 1;
                    if (data.length > 0) {
                        data.forEach(jo => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${i}</td>
                                <td>${jo.datejour}</td>
                                <td>${jo.typeOperation}</td>
                                <td>${jo.libcompte}</td>
                                <td>${jo.montantcredit}</td>
                                <td>${jo.montantdebit}</td>
                                <td>
                                    <button class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
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
    
    </script>



    <script>
        function toggleSection(sectionId, show) {
            const section = document.getElementById(sectionId);
            section.style.display = show ? 'block' : 'none';
        }

        function toggleField(fieldId, show) {
            const field = document.getElementById(fieldId);
            field.style.display = show ? 'block' : 'none';
        }
    </script>

<script>
    
    //traitement vente
     
     let ventes = [];
     let count = 1;
     function ajouterProduit(){
       // alert('Bonjour');
        const produitSelect = document.getElementById('produit_id');
        const produitId = produitSelect.value;
        const produitNom = produitSelect.options[produitSelect.selectedIndex].text;
          // Vérifie si le produit est déjà dans le tableau
        if (ventes.includes(produitId)) {
            alert("Ce produit a déjà été ajouté !");
            return; // ne pas ajouter deux fois
        }
        // Ajout au tableau
        ventes.push(produitId);

        const table = document.getElementById('tableVentes').querySelector('tbody');
        const row = table.insertRow();
       // row.innerHTML = `<td>${count++}</td><td>${produitId}</td><td>${produitNom}</td><td> Rétirer</td>`;
        row.innerHTML = `<td>${count}</td><td>${produitId}</td><td>${produitNom}</td><td><button class="btn btn-danger" onclick="retirerProduit(this, '${produitId}')">🗑️Rétirer <i class="fas fa-spinner spinner"></i></button></td>`;
        count++;

     }
     function retirerProduit(button, produitId) {
        // Supprimer l'élément de la liste "ventes"
        ventes = ventes.filter(id => id !== produitId);

        // Supprimer la ligne du tableau HTML
        const row = button.closest("tr");
        row.remove();

        // Réindexer les lignes du tableau (optionnel mais propre)
        const rows = document.querySelectorAll('#tableVentes tbody tr');
        count = 1;
        rows.forEach(r => {
            r.cells[0].textContent = count++;
        });
    }

     function submitFormVente(){
        // alert("Bonjour :");
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        const dateVente = new Date().toISOString().split('T')[0];
        const formData = {
           // client_id: clientId,
            produit_id: ventes,
            client_id: document.getElementById('client_id').value,
            date_vente: dateVente
        };
        //alert('Bonjour');
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/vente', {
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
                    showToast('Vente enregistrée avec succès!', 'success');
                    //vider tableau
                    ventes = [];
                    document.querySelector('#tableVentes tbody').innerHTML = '';
                    count = 1;
                   // clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 1000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.' + error, 'error');
              //  console.error('Error:', error);
            }, 1000);
        });

       
     }








        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.className = `toast ${type} show`;
            toast.innerText = message;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
                window.location.href = './'
            }, 1500); // Durée d'affichage de 4,5 secondes
        }

        function clearForm() {
            document.getElementById("clientForm").reset();
        }

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

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_client.php/create', {
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

    // clique bouton user
    function submitFormProspect(){
       // alert("Bonjour :");
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        const formData = {
            nom: document.getElementById("nom").value,
            adresse: document.getElementById("adresse").value,
            telephone: document.getElementById("telephone").value,
            email: document.getElementById("email").value,
            //date_naissance: document.getElementById("date_naissance").value,
            date_prospection: document.getElementById("date_prospection").value,
            moyen_contact_id: document.getElementById("moyen_contact_id").value,
            type_prospect_id: document.getElementById("type_prospect_id").value
        };
        //alert('Bonjour');
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/createprospect', {
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
                    showToast('Prospect enregistré avec succès!', 'success');
                   // clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 1000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.' + error, 'error');
              //  console.error('Error:', error);
            }, 1000);
        });

       


    }

    //cliquer boutoun Intermediaire
    function submitFormInter(){
        alert('clique ok');
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        const formData = {
      
            numeroarca: document.getElementById("numeroarca").value,
            nomcomplet: document.getElementById("nomcomplet").value,
            
            telephone: document.getElementById("telephone").value,
            email: document.getElementById("email1").value,
            adresse: document.getElementById("adresse").value,
            etat: 1
           
        };
       // alert('Bonjour');
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_parametres.php/create1', {
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
                    showToast('Intermediaire enregistré avec succès!', 'success');
                   // clearForm();
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

    function submitFormProduit(){
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
    
       // alert("bonjour ");
        //exit();
        const formData = {
            nom: document.getElementById("nom1").value,
            formule: document.getElementById("formule").value,
            type_gestion: document.getElementById("type_gestion").value,
            montant_annuel: document.getElementById("montant_annuel").value
        };

        button.disabled = true;
        spinner.style.display = "inline-block";

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/createproduit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                if (data.status === 200) {
                    showToast('Produit créé', 'success');
                    clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 1000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.', 'error');
                console.error('Error:', error);
            }, 1000);
        });
    }
    
    </script>

    <script>
        // Les traitement de la page
        document.addEventListener('DOMContentLoaded', function(){
           
                // charger type prospect
                fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/moyens')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('moyen_contact_id');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes
                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(moyen => {
                            const option = document.createElement('option');
                            option.value = moyen.id;
                            option.textContent = moyen.libelle;
                            selectPoste.appendChild(option);
                        });

                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

              
                
                // charger client
                fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/clientpro')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('client_id');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes
                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(client => {
                            const option = document.createElement('option');
                            option.value = client.id;
                            option.textContent = client.nom + " " + client.email;
                            selectPoste.appendChild(option);
                        });

                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

           
                // charger produit
                fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/produit')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('produit_id');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes
                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(produit => {
                            const option = document.createElement('option');
                            option.value = produit.id;
                            option.textContent = produit.nom;
                            selectPoste.appendChild(option);
                        });

                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

           

                 // combo banque
                 fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/tp')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('type_prospect_id');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--Choisir une banque--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(tp => {
                            const option = document.createElement('option');
                            option.value = tp.id;
                            option.textContent = tp.libelle;
                            selectPoste.appendChild(option);
                        });

                     
                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des banque :', error));

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
            // pays partenaire
            const selectPays1 = $('#pays1');
            // Charger les pays
            fetch('https://flagcdn.com/fr/codes.json')
                .then(response => response.json())
                .then(countries => {
                    selectPays1.empty();
                    for (const [code, name] of Object.entries(countries)) {
                        const option = new Option(name, code);
                        selectPays1.append(option);
                    }
                    selectPays1.select2({
                        placeholder: '--choisir un pays--',
                        allowClear: true
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des pays :', error));

        });
    </script>
    <script>
        // chargement de la page affichage de statistiques
        document.addEventListener('DOMContentLoaded', function(){
            // chargeSite
            fetch('http://localhost/crm-gga/app/codes/api/v1/api_com.php/total')
                .then(response => response.json())
                .then(data => {
                    // recuperation de statistiques
                    document.getElementById('TotalPropect').textContent = data.data.totalprospect[0].total_prospect;
                    document.getElementById('Totalclient').textContent = data.data.totalclient[0].total_client;
                    document.getElementById('Totalproduit').textContent = data.data.totalproduit[0].total_produit;
                    document.getElementById('Totalproduitvendu').textContent = data.data.totalprovendu[0].total_general_ventes;
                   
                })
                .catch(error => console.error('Erreur lors du chargement des parametre:', error));
            
        
        });


      
        // Sélectionnez d'abord l'élément
        document.getElementById('id_contrat').addEventListener('change', function(event) {
            const selectedValue = event.target.value;
            //alert("combo " + selectedValue);
        });

    </script>
    
<script>
    document.getElementById("idcompte").addEventListener('change', function(){
        const bankContainer = document.getElementById("bankSelectContainer");
        if(this.value == "1"){
            bankContainer.style.display = "block";
        } else {
            bankContainer.style.display = "none";
            document.getElementById("bankList").value = "0"; // Réinitialise le choix
        }

        let idcompte = this.value;
        let soldeField = document.getElementById('solde');

        if(idcompte == 0){
            soldeField.value = '';
            return;
        }

        fetch(`http://localhost/crm-gga/app/codes/api/v1/api_solde.php?idcompte=${idcompte}`)
            .then(response => response.json())
            .then(data => {
                soldeField.value = data.solde;
            })
            .catch(error => {
                console.error('Erreur:', error);
                soldeField.value = 'Erreur';
        });





    });

    function clearForm(){
        document.getElementById("clientForm").reset();
        document.getElementById("bankSelectContainer").style.display = "none";
    }

    function submitFormJournal(){

       
        // enregistrement journal 
        // Exemple de récupération des valeurs
        
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");

        //$dataJO = $data['dataJO'];
        //$dataJB = $data['dataJB'];
        //$dataJC = $data['dataJC'];
       const idcompte =parseInt(document.getElementById("idcompte").value, 10);

       let banque = "";
       banque = document.getElementById("bankList").value;
      // alert("ecouteur ok" + banque);
      

        let datejour = document.getElementById("datejour").value;
        let typeOperation = parseInt(document.getElementById("typeOperation").value, 10);
        let montant =  parseFloat(document.getElementById("montant").value);
        let motif = document.getElementById("motif").value;
        let beneficiaire = document.getElementById("beneficiaire").value;
        let refer = document.getElementById("ref_oper").value;
        let montantcredit = 0.0;
        let montantdebit = 0.0;
        let liboperation="";
        let soldeData = parseFloat(document.getElementById("solde").value);
        
        // verification de champs

     if(datejour==""){
         alert("veuillez sélectionner la date  ");
         return;
     }
     if(typeOperation == "" ||  typeOperation === 0){
         alert("veuillez sélectionner le type operation ");
         return;
     }
     if(idcompte == "" ||  idcompte === 0){
         alert("veuillez sélectionner le compte ");
         return;
     }
      if(idcompte === 1){
           banque = document.getElementById("bankList").value;
            if(banque == "0" || banque == ""){
                alert("Veuillez sélectionner une banque.");
                return;
            }
      }

      if(montant == "" ||  montant === 0){
         alert("veuillez saisir le montant ");
         return;
     }



        //type =1 recette 2= depense
        if(typeOperation === 1 ) {
            montantcredit = montant;
            montantdebit = 0;
            liboperation="Recette";
            soldeData= soldeData + montant
            //alert("ok " + typeOperation + " " + montantcredit + " " + montantdebit + " " + banque );
        }else if(typeOperation === 2 ){
            if(soldeData > 0 ){
                if(soldeData > montant || soldeData === montant){
                    montantcredit = 0;
                    montantdebit = montant ;
                    liboperation = "Depense"
                    soldeData = soldeData - montant
                }else{
                    alert("Le solde est insuffisant pour la depense. ");
                    return;
                }
            }else{

                alert("Le solde est insuffisant pour la depense 0");
                return;
            }
            
            //alert("ok " + typeOperation );
        }else{
          alert("Veuillez sélectionner une opération.");
        }
       
        const dataJO = {
            idcompte: idcompte,
            datejour: datejour,
            typeOperation: liboperation,
            montant: montant,
            motif: motif,
            beneficiaire: beneficiaire,
            montantcredit: montantcredit,
            montantdebit: montantdebit,
            solde: soldeData,
            ref_oper: refer
        };
        const dataJB = {
            date_operation: datejour,
            beneficiaire: beneficiaire,
            entree_fond: montantcredit,
            sortie_fond: montantdebit,
            solde: soldeData,
            refer: refer,
            idcompte: idcompte,
            idbanque: banque
        };
        const dataJC = {
            date_operation: datejour,
            beneficiaire: beneficiaire,
            entree_fond: montantcredit,
            sortie_fond: montantdebit,
            solde: soldeData,
            refer: refer
        };
      

        button.disabled = true;
        spinner.style.display = "inline-block";

        fetch('http://localhost/crm-gga/app/codes/api/v1/api_finance.php/create_JO', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            //body: JSON.stringify(formData)
            body: JSON.stringify({
                dataJO: dataJO,
                dataJB: dataJB,
                dataJC: dataJC
            })
        })
        .then(response => response.json())
        .then(data => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                if (data.status === 200) {
                    showToast('Transaction enregistrée avec succès!', 'success');
                    clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 1000);
        })
        .catch(error => {
            setTimeout(() => {
                button.disabled = false;
                spinner.style.display = "none";

                showToast('Erreur lors de l\'enregistrement.', 'error');
                console.error('Error:', error);
            }, 1000);
        });

    
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const titreTransaction = document.getElementById('titreTransaction');

    const aujourdHui = new Date();
    const jour = String(aujourdHui.getDate()).padStart(2, '0');
    const mois = String(aujourdHui.getMonth() + 1).padStart(2, '0');
    const annee = aujourdHui.getFullYear();
    const dateActuelle = `${jour}/${mois}/${annee}`;

    titreTransaction.innerHTML = `<i class="bi bi-list-check"></i> Journal de transaction du ${dateActuelle}`;
});
</script>


</body>
</html>