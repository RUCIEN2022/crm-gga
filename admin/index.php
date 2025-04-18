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
    <title>CRM-GGA Admin</title>
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
        max-width: 600px;
        margin: 20px auto;
    }

    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline;
        flex-direction: row;
        gap: 7px;
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
                            <i class="bi bi-person-plus"></i> Prestataires
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#clientModal">
                            <i class="bi bi-person-plus"></i> Reception Facture
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#InterModal">
                            <i class="bi bi-file-earmark-plus"></i> Courrier Entrant
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#ParModal">
                            <i class="bi bi-file-earmark-text"></i> Courrier Sortant
                        </a>
                    </li>
                   
                </ul>
            </div>
         <hr>
<div class="row text-center">
    <!-- Total Contrats -->
    <div class="col-md-3">
        <a href="./prestataires" class="text-decoration-none">
            <div class="card shadow hover-effect" style="border: #923a4d solid 1px;">
                <div class="card-body">
                    <h5 class="card-title text-secondary">
                        
                        <i class="bi bi-file-earmark"></i> Prestataires
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="totalUtil">
                        
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
                        <i class="bi bi-gear"></i> Total facture reçue
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;" id="totalClient">
                        
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
                        <i class="bi bi-pause-circle"></i> Total Courrier Entrant 
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;"  id="totalInt">
                        
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
                        <i class="bi bi-x-circle text-danger"></i> Total Courrier Sortant 
                    </h5>
                    <div class="circle-value border border-danger shadow text-light mx-auto" style="background-color: #923a4d;" id="totalPart">
                        
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


      </div>
    </div>
</div>
    </div>
</div>
<!-- Modal Static Content -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Enregistrement de facture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="clientForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="site" id="site" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="site">Prestataire</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="tp" placeholder="TP" required>
                                        <label for="tp">TP </label>
                                    </div>
                                </div>
                            
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                 <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rd" placeholder="RD" required>
                                        <label for="rd">RD </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numero_facture" placeholder="Numero facture" required>
                                        <label for="numero_facture">Numero facture</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_reception" placeholder="Date Reception" required>
                                        <label for="date_reception">Date Reception</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <div class="row align-items-center mb-3">
                                           <label for="date_reception">Periode de prestation</label>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-auto">
                                                <label for="periode_debut">Du</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="date" class="form-control" id="periode_debut" required>
                                            </div>
                                            <div class="col-auto">
                                                <label for="periode_fin">au</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="date" class="form-control" id="periode_fin" required>
                                            </div>
                                        </div>
                                       
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="moyen_reception" placeholder="Moyen de reception" required>
                                        <label for="moyen_reception">Moyen de Reception</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="montant_facture" placeholder="Montant Facture" required>
                                        <label for="montant_facture">Montant Facture</label>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between">
                               <div class="form-group">
                                   <label for="">Attachez Facture</label>
                                  
                                   <input type="file" name="fichier_facture" accept=".pdf" class="form-control" required>
                               </div>
                               <div class="action d-flex gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormReception()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal creation Prestataire -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Création  d'un Prestataire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="UserForm" class="p-3">
                            
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom_prestataire" placeholder="Nom Prestataire" required>
                                        <label for="nom_prestataire">Nom Complet</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adresse" placeholder="Adresse Prestataire" required>
                                        <label for="adresse">Adresse</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                               
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contact" placeholder="contact Prestataire" required>
                                        <label for="contact">Contact</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rib" placeholder="Releve Identite Bancaire" required>
                                        <label for="rib">RIB</label>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Adresse mail" required>
                                        <label for="email">E-mail</label>
                                    </div>
                                </div>
                              
                            
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormPresta()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormUser()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Courrier entrant -->
<div class="modal fade" id="InterModal" tabindex="-1" aria-labelledby="InterModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Enregistrement Courrier  Entrant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="InterForm" class="p-3">
                            
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_arrivee" placeholder="Date Arrivee" required>
                                        <label for="date_arrivee">Date Arrivee </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="expediteur" placeholder="Expediteur" required>
                                        <label for="expediteur">Expediteur</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            
                            <div class="row g-3 mb-1">
                                    <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="objet" placeholder="Objet " required>
                                                <label for="objet">Objet </label>
                                            </div>
                                    </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numref" placeholder="Numero Reference" required>
                                        <label for="numref">Numero Reference</label>
                                    </div>
                                </div>
                            
                            </div>
                             <!-- Section 3 -->
                            
                             <div class="row g-3 mb-1">
                                    <div class="col-md-12">
                                        
                                            <div class="form-floating">
                                                <select name="type_courrier" id="type_courrier" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                                    <option value="0">--Choisir--</option>
                                                    <option value="Mail"> Mail </option>
                                                    <option value="Physique"> Physique </option>
                                                </select>
                                                <label for="site">Type Courrier</label>
                                            </div>
                                    </div>
                            
                            
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormCE()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
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


<!-- Modal creation Partenaire -->
<div class="modal fade" id="ParModal" tabindex="-1" aria-labelledby="ParModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="InterModalLabel">Enregistrement Courrier Sortant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ParForm" class="p-3">
                           <!-- Section 1 -->
                           <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="num_reference" placeholder="Numero Reference" required autofocus>
                                        <label for="num_reference">Numero Reference</label>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="date_depart" placeholder="Date depart" required>
                                        <label for="date_depart">Date depart</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="destinateur" placeholder="Destinateur" required>
                                        <label for="Destinateur">Destinateur</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="objet" placeholder="Objet" required>
                                        <label for="objet">Objet</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                               
                                <div class="col-md-12">
                                            <div class="form-floating">
                                                <select name="type_courrier" id="type_courrier" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                                    <option value="0">--Choisir--</option>
                                                    <option value="Mail"> Mail </option>
                                                    <option value="Physique"> Physique </option>
                                                </select>
                                                <label for="site">Type Courrier</label>
                                            </div>
                                </div>
                              
                            </div>
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" onclick="submitFormCS()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
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
<div class="modal fade" id="formChecklist" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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


         
            function submitFormReception() {
                
                //alert('ok');
                const form = document.getElementById("clientForm");
                const formData = new FormData();

                // Récupération des données
                const id_prestataire = document.getElementById('site').value;
                const tp = document.getElementById('tp').value;
                const rd = document.getElementById('rd').value;
                const numero_facture = document.getElementById('numero_facture').value;
                const date_reception = document.getElementById('date_reception').value;
                const periode_debut = document.getElementById('periode_debut').value;
                const periode_fin = document.getElementById('periode_fin').value;
                const moyen_reception = document.getElementById('moyen_reception').value;
                const montant_facture = document.getElementById('montant_facture').value;
                const fichier = form.querySelector('input[name="fichier_facture"]').files[0];

                // Validation minimale
                if (!fichier) {
                    alert("Veuillez joindre un fichier de facture.");
                    return;
                }

                // Formater la période comme tu veux : ici exemple : "2025-04-01 au 2025-04-30"
                const periode_prestation = `${periode_debut} au ${periode_fin}`;

                // Remplir le FormData
                formData.append('id_prestataire', id_prestataire);
                formData.append('tp', tp);
                formData.append('rd', rd);
                formData.append('numero_facture', numero_facture);
                formData.append('date_reception', date_reception);
                formData.append('periode_prestation', periode_prestation);
                formData.append('moyen_reception', moyen_reception);
                formData.append('montant_facture', montant_facture);
                formData.append('statut', 1); // par défaut ou tu peux ajouter un champ
                formData.append('fichier_facture', fichier);

                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_rf.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Réponse API :", data);
                    setTimeout(() => {
                      //  button.disabled = false;
                        //spinner.style.display = "none";

                        if (data.success === true) {
                            showToast('Facture enregistrée avec succès!', 'success');
                            clearForm();
                            form.reset();
                        } else {
                            showToast('Une erreur est survenue.', 'error');
                        }
                    }, 1000);
                  
                })
                .catch(err => {
                    setTimeout(() => {
                        button.disabled = false;
                        spinner.style.display = "none";

                        showToast('Erreur lors de l\'enregistrement.' + error, 'error');
                    //  console.error('Error:', error);
                    }, 1000);
                });
            }


   /*
    function submitFormReception() {
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        // la date
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        const periode_prestation = "Du " + document.getElementById("periode_debut").value + " au " + document.getElementById("periode_fin").value
        const formData = {
            //site: 1,
            id_prestataire: document.getElementById("site").value,
            tp: document.getElementById("tp").value,
            rd: document.getElementById("rd").value,
            numero_facture: document.getElementById("numero_facture").value,
            date_reception: document.getElementById("date_reception").value,
            periode_prestation: periode_prestation,
            moyen_reception: document.getElementById("moyen_reception").value,
            montant_facture: document.getElementById("montant_facture").value,
            statut: 1
        };

        button.disabled = true;
        spinner.style.display = "inline-block";
        //console.log("Données envoyées :", formData);

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/reception', {
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
                    showToast('Facture enregistrée avec succès!', 'success');
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

                showToast('Erreur lors de l\'enregistrement.' + error, 'error');
              //  console.error('Error:', error);
            }, 1000);
        });
    }*/

    // clique bouton user
    function submitFormPresta(){
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        const formData = {
            nom_prestataire: document.getElementById("nom_prestataire").value,
            adresse: document.getElementById("adresse").value,
            contact: document.getElementById("contact").value,
            email: document.getElementById("email").value,
            rib: document.getElementById("rib").value,
            statut:1
        };
        //alert('Bonjour' + formData['rib'] );
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);
  
        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/create_presta', {
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
                    showToast('Prestataire enregistré avec succès!', 'success');
                   // clearForm();
                } else {
                    showToast(data.message || 'Une erreur est survenue.', 'error');
                }
            }, 500);
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

    //Enregistrement courrier entrant 
    function submitFormCE(){
        alert('clique ok');
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
        
        const formData = {
            date_arrivee: document.getElementById("date_arrivee").value,
            expediteur: document.getElementById("expediteur").value,
            objet: document.getElementById("objet").value,
            numref: document.getElementById("numref").value,
            type_courrier: document.getElementById("type_courrier").value
        };
       // alert('Bonjour');
        button.disabled = true;
        spinner.style.display = "inline-block";
       // console.log("Données envoyées :", formData);

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/create_CE', {
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
                    showToast('Courrier entrant enregistré avec succès!', 'success');
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

    function submitFormCS(){
        const button = document.querySelector("button");
        const spinner = document.querySelector(".spinner");
    

        const formData = {
            num_reference: document.getElementById("num_reference").value,
            date_depart: document.getElementById("date_depart").value,
            destinateur: document.getElementById("destinateur").value,
            objet: document.getElementById("objet").value,
            type_courrier: document.getElementById("type_courrier").value
        };

        button.disabled = true;
        spinner.style.display = "inline-block";

        fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/create_CS', {
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
                    showToast('Courrier Sortant enregistré avec succès!', 'success');
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
        //chargement prestataire
        document.addEventListener('DOMContentLoaded', function(){
            // chargeSite
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/listePresta')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectSite = document.getElementById('site');
                        selectSite.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectSite.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(prestataire => {
                            const option = document.createElement('option');
                            option.value = prestataire.id_prestataire;
                            option.textContent = prestataire.nom_prestataire;
                            selectSite.appendChild(option);
                        });

                  
                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));



                //J'arrive 
                // charger poste
                fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_parametres.php/poste')
                .then(response => response.json())
                .then(data => {
                    // Vérifier si la réponse est un tableau
                    if (Array.isArray(data)) {
                        const selectPoste = document.getElementById('poste');
                        selectPoste.innerHTML = ''; // Nettoyer les options précédentes

                        // Ajouter une option par défaut
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '';
                        defaultOption.textContent = '--choisir--';
                        selectPoste.appendChild(defaultOption);

                        // Ajouter les options récupérées depuis l'API
                        data.forEach(poste => {
                            const option = document.createElement('option');
                            option.value = poste.idposte;
                            option.textContent = poste.libposte;
                            selectPoste.appendChild(option);
                        });

                        


                    } else {
                        console.error('Structure inattendue de la réponse:', data);
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des sites:', error));

            

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
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/Total')
                .then(response => response.json())
                .then(data => {
                    // recuperation de statistiques
                    document.getElementById('totalUtil').textContent = data.data.totalPre[0].total_prest;
                    document.getElementById('totalClient').textContent = data.data.totalRF[0].total_fact;
                    document.getElementById('totalInt').textContent = data.data.totalCE[0].total_CE;
                    document.getElementById('totalPart').textContent = data.data.totalCS[0].total_CS;
                    
                })
                .catch(error => console.error('Erreur lors du chargement des parametre:', error));
            

        });
    </script>
    
</body>
</html>