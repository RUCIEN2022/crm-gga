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
    <title>CRM-GGA Parametre</title>
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
        max-width: 900px;
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
                            <i class="bi bi-person-plus"></i> Décomptes validés
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#ParModal">
                            <i class="bi bi-file-earmark-text"></i> Fonds de déroulement 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" >
                            <i class="bi bi-file-earmark-text"></i> Journal de Caisse
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#" class="nav-link" >
                            <i class="bi bi-file-earmark-text"></i> Journal de Banque
                        </a>
                    </li>
                   
                 
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#ParModal">
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
                        <i class="bi bi-file-earmark"></i> Total Décomptes validés
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="Totaldv">
                        
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
                        <i class="bi bi-gear"></i> Solde Caisse
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="Totaljc">
                        
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
                        <i class="bi bi-pause-circle"></i> Solde Banque 
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;"  id="Totaljb">
                        
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
                        <i class="bi bi-x-circle text-danger"></i> Total Solde
                    </h5>
                    <div class="circle-value border border-danger shadow text-light mx-auto" style="background-color: #923a4d;" id="Totalsolde">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


<!-- Tableau Journal de transaction du jour -->

<div class="row text-center mt-2">
    <div class="col-12">
        <h5 class="text-secondary mb-3" id="titreTransaction">
            <i class="bi bi-list-check"></i> Journal de transaction du ...
        </h5>
       

        <div class="table-responsive">
        <h5 class="text-secondary mb-3 d-flex justify-content-between align-items-center" >
           
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#clientModal" >
                <i class="bi bi-plus-circle"></i> Nouvelle Transaction
            </button>
        </h5>
        
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date du jour </th>
                        <th>Type Operation</th>
                        <th>Compte</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Solde</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-start"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a href=""><span class="badge bg-info">Ouvrir Classeur</span></a></td>
                    </tr>
                    
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Fin Tableau -->
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
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Décompte  Valide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="UserForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                               <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="annee" id="annee" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="annee">Annee</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="id_prestataire" id="id_prestataire" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="site1">Prestataire</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="id_assureur" id="id_assureur" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="id_assureur">Assureur</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="id_contrat" id="id_contrat" class="form-select" style="font-size: 12px;border: solid 1px #ccc;">
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="id_contrat">Contrat</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_soin" placeholder="Date Soin" required>
                                        <label for="date_soin">Date Soin</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="montant_paye" placeholder="Montant Payé" required>
                                        <label for="montant_paye">Montant Payé</label>
                                    </div>
                                </div>
                            
                            </div>
                            <!-- Section 4 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_paiement" placeholder="Date Paiement" required>
                                        <label for="date_paiement">Date Paiement</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_reception" placeholder="Date Réception" required>
                                        <label for="date_reception">Date Réception</label>
                                    </div>
                                </div>
                            
                            </div>
                            <!-- Section 4 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="observation" placeholder="Observation" required>
                                        <label for="observation">Observation</label>
                                    </div>
                                </div>
                       
                            </div>
                            <input type="text" id="user" value="<?php if(isset($userId)) echo $userId; ?>" hidden>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormDecompte()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormUser()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal creation site -->
<div class="modal fade" id="SiteModal" tabindex="-1" aria-labelledby="SiteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="SiteModalLabel">Création  Site</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="UserForm" class="p-3">
                            <!-- Section 1 -->
                            

                           
                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="libsite" placeholder="Saisissez le nom du site" required>
                                        <label for="libsite">Designation </label>
                                    </div>
                                </div>
                            
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormSite()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormUser()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal creation intermediaire -->
<div class="modal fade" id="InterModal" tabindex="-1" aria-labelledby="InterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Création  Intermediaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="InterForm" class="p-3">
                            <!-- Section 1 -->
                           

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numeroarca" placeholder="Numero ORCA" required>
                                        <label for="numeroarca">Numero ORCA</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nomcomplet" placeholder="Nom complet" required>
                                        <label for="nomcomplet">Nom Complet</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            
                            <div class="row g-3 mb-1">
                                    <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="telephone" placeholder="Téléphone " required>
                                                <label for="telephone">Téléphone </label>
                                            </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email1" placeholder="Votre adresse mail" required>
                                        <label for="email1">E-mail</label>
                                    </div>
                                </div>
                            
                            </div>
                             <!-- Section 3 -->
                            
                             <div class="row g-3 mb-1">
                                    <div class="col-md-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="adresse" placeholder="Adresse " required>
                                                <label for="adresse">Adresse </label>
                                            </div>
                                    </div>
                            
                            
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormInter()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormInter()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Modal Partenaire -->


<!-- Modal creation Fond deroulement -->
<div class="modal fade" id="ParModal" tabindex="-1" aria-labelledby="ParModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Mise à jour fonds de déroulement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ParForm" class="p-3">
                           <!-- Section 1 -->
                           <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                   <div class="form-floating">
                                        <select name="id_assureur1" id="id_assureur1" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="id_assureur1">Assureur</label>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                   <div class="form-floating">
                                        <select name="id_contrat1" id="id_contrat1" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="id_contrat1">Contrat</label>
                                    </div>
                                </div>
                              
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="numeric" class="form-control" id="fonds_recus" placeholder="Fonds Reçu" required>
                                        <label for="fonds_recus">Fonds Reçus</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="sinistre_paye" placeholder="Sinistre Payé" required>
                                        <label for="sinistre_paye">Sinistre Payé</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="sinistre_encours" placeholder="Sinistre encours" required>
                                        <label for="sinistre_encours">Sinistre encours</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="fonds_disponibles" placeholder="Fonds disponibles" required>
                                        <label for="fonds_disponibles">Fonds disponibles</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 4 -->
                            <!-- Section 5 -->
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="submitFormFD()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
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

    // clique bouton user
    function submitFormDecompte(){
        alert("Bonjour :");
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        const formData = {
            annee: document.getElementById("annee").value,
            id_prestataire: document.getElementById("id_prestataire").value,
            id_assureur: document.getElementById("id_assureur").value,
            id_contrat: document.getElementById("id_contrat").value,
            date_soin: document.getElementById("date_soin").value,
            montant_paye: document.getElementById("montant_paye").value,
            date_reception: document.getElementById("date_reception").value,
            date_paiement: document.getElementById("date_paiement").value,
            observation: document.getElementById("observation").value,
            user: document.getElementById("user").value
        };
        //alert('Bonjour');
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/create_decompte', {
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
                    showToast('Décompte valide enregistré avec succès!', 'success');
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

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_parametres.php/create1', {
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

    function submitFormFD(){
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
    

        const formData = {
            id_assureur: document.getElementById("id_assureur1").value,
            id_contrat: document.getElementById("id_contrat1").value,
            fonds_recus: document.getElementById("fonds_recus").value,
            sinistre_paye: document.getElementById("sinistre_paye").value,
            sinistre_encours: document.getElementById("sinistre_encours").value
        };

        button.disabled = true;
        spinner.style.display = "inline-block";

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/create_fond', {
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
                    showToast('Fonds de déroulemennt enregistré avec succès!', 'success');
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

                showToast('Erreur lors de l\'enregistrement.', 'error');
                console.error('Error:', error);
            }, 3000);
        });
    }
    
    </script>

    <script>
        // Les traitement de la page
        document.addEventListener('DOMContentLoaded', function(){
            +
            // chargeSite
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_annee.php')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    /*
                    if (Array.isArray(data)) {
                        const selectSite = document.getElementById('annee');
                        selectSite.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectSite.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.annees.forEach(annee => {
                            const option = document.createElement('option');
                            option.value = annee;
                            option.textContent = annee;
                            selectSite.appendChild(option);
                        });

                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                        */
              
                    
                    const select = document.getElementById('annee');

                    data.annees.forEach(annee => {
                        const option = document.createElement('option');
                        option.value = annee;
                        option.textContent = annee;
                        select.appendChild(option);
                    });
                    //fin
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));



                //J'arrive 
                // charger prestataire
                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/listePresta')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('id_prestataire');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(presta => {
                            const option = document.createElement('option');
                            option.value = presta.id_prestataire;
                            option.textContent = presta.nom_prestataire;
                            selectPoste.appendChild(option);
                        });

                        


                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

             
                // charger assureur
                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('id_assureur');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(assureur => {
                            const option = document.createElement('option');
                            option.value = assureur.idpartenaire;
                            option.textContent = assureur.denom_social;
                            selectPoste.appendChild(option);
                        });

                        // pour fonds de deroulement
                        // Ajouter une option par défaut
                        const selectAssu = document.getElementById('id_assureur1');
                        selectAssu.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption1 = document.createElement('option');
                        defaultOption1.value = '';
                        defaultOption1.textContent = '--choisir--';
                        selectAssu.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(assureur => {
                            const option = document.createElement('option');
                            option.value = assureur.idpartenaire;
                            option.textContent = assureur.denom_social;
                            selectAssu.appendChild(option);
                        });


                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

               
                // charger contrat
                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_pc.php')
                .then(response => response.json())
                .then(json => {
                    const select = document.getElementById('id_contrat');
                    
                    // Effacer les options précédentes
                    select.innerHTML = '';

                    if (json.success) {
                         // Ajouter une option par défaut
                            const defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.textContent = '--choisir--';
                            select.appendChild(defaultOption);
                        json.data.forEach(contrat => {
                            const option = document.createElement("option");
                            option.value = contrat.id;
                            option.textContent = contrat.label;
                            select.appendChild(option);
                        });
                    } else {
                        const option = document.createElement("option");
                        option.textContent = json.message || "Aucun contrat disponible";
                        option.disabled = true;
                        select.appendChild(option);
                    }

                    // Fonds de deroulement
                    
                    const selectContrat = document.getElementById('id_contrat1');
                    
                    // Effacer les options précédentes
                    selectContrat.innerHTML = '';

                    if (json.success) {
                         // Ajouter une option par défaut
                            const defaultOption = document.createElement('option');
                            defaultOption.value = '';
                            defaultOption.textContent = '--choisir--';
                            selectContrat.appendChild(defaultOption);
                        json.data.forEach(contrat => {
                            const option = document.createElement("option");
                            option.value = contrat.id;
                            option.textContent = contrat.label;
                            selectContrat.appendChild(option);
                        });
                    } else {
                        const option = document.createElement("option");
                        option.textContent = json.message || "Aucun contrat disponible";
                        option.disabled = true;
                        selectContrat.appendChild(option);
                    }


                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

                // combo compte
                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/Compte')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('idcompte');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(compte => {
                            const option = document.createElement('option');
                            option.value = compte.idcompte;
                            option.textContent = compte.libcompte;
                            selectPoste.appendChild(option);
                        });

                        


                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));


                 // combo banque
                 fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/Banque')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('bankList');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--Choisir une banque--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(banque => {
                            const option = document.createElement('option');
                            option.value = banque.idbanque;
                            option.textContent = banque.libbanque;
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
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/total')
                .then(response => response.json())
                .then(data => {
                    // recuperation de statistiques
                    document.getElementById('Totaldv').textContent = data.data.totaldv[0].total_dv;
                    document.getElementById('Totaljc').textContent = data.data.totaljc[0].total_jc;
                    document.getElementById('Totaljb').textContent = data.data.totaljb[0].total_jb;

                    // Convertir les valeurs en nombres (float)
                    let totaljc = parseFloat(data.data.totaljc[0].total_jc) || 0;
                    let totaljb = parseFloat(data.data.totaljb[0].total_jb) || 0;
                    // Faire l'addition et afficher le résultat
                   document.getElementById('Totalsolde').textContent = (totaljc + totaljb).toFixed(2);
                })
                .catch(error => console.error('Erreur lors du chargement des parametre:', error));
            
        
        });


      
        // Sélectionnez d'abord l'élément
        document.getElementById('id_contrat').addEventListener('change', function(event) {
           
           
            const selectedValue = event.target.value;

            alert("combo " + selectedValue);
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

        fetch(`http://localhost:8080/crm-gga/app/codes/api/v1/api_solde.php?idcompte=${idcompte}`)
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
       if(idcompte === 1){
           banque = document.getElementById("bankList").value;
            if(banque == "0" || banque == ""){
                alert("Veuillez sélectionner une banque.");
                return;
            }
      }

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

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_finance.php/create_JO', {
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