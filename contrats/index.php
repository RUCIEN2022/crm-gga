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
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#clientModal">
                            <i class="bi bi-person-plus"></i> Nouveau Client
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="./creation" class="nav-link">
                            <i class="bi bi-file-earmark-plus"></i> Créer contrat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#gestionContratModal">
                            <i class="bi bi-file-earmark-text"></i> Gestion contrat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#formChecklist">
                            <i class="bi bi-list-check"></i> Check List
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#">
                            <i class="bi bi-calculator"></i> Cotation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#reporting">
                            <i class="bi bi-clipboard-data"></i> Gestion des rapports
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
                        <i class="bi bi-file-earmark"></i> Total Contrats
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;">
                        300
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
                        <i class="bi bi-gear"></i> En cours de gestion
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;">
                        180
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
                        <i class="bi bi-pause-circle"></i> En suspension
                    </h5>
                    <div class="circle-value bg-light shadow text-secondary mx-auto" style="border: #923a4d solid 1px;">
                        60
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
                        <i class="bi bi-x-circle text-danger"></i> En résiliation
                    </h5>
                    <div class="circle-value border border-danger shadow text-light mx-auto" style="background-color: #923a4d;">
                        40
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


<div class="row text-center mt-2">
    <div class="col-12">
        <h5 class="text-secondary mb-3">
            <i class="bi bi-list-check"></i> Contrats Récents
        </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date mise en place</th>
                        <th>Numéro de Police</th>
                        <th>Type de Contrat</th>
                        <th>Total_Frais_gestion</th>
                        <th>Client</th>
                        <th>Gestionnaire</th>
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
        </div>
    </div>
</div>
    </div>
</div>
<!-- Modal Static Content -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Création d'un Nouveau Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="clientForm" class="p-3">
                            <!-- Section 1 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select name="site" id="site" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                                            <option value="0">--Choisir--</option>
                                        </select>
                                        <label for="site">Site</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="den_social" placeholder="Dénomination sociale" required>
                                        <label for="den_social">Dénomination sociale</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="">
                                        <label for="pays">Pays</label>
                                        <select name="pays" id="pays" class="form-select" style="border: solid 1px #ccc;">
                                                <option value="">--choisir--</option>
                                        </select>
                                           
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ville_entr" placeholder="Ville" required>
                                        <label for="ville_entr">Ville</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adresse_entr" placeholder="Adresse Client" required>
                                        <label for="adresse_entr">Adresse Client</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="code_interne" placeholder="Code Interne" required>
                                        <label for="code_interne">code_interne</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="id_nat" placeholder="Identifiant National [id nat]" required>
                                        <label for="id_nat">Identifiant National [id nat]</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="telephone_client" placeholder="Telephone Client" required>
                                        <label for="telephone_client">Telephone Client</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-floating">
                                        <input type="email" class="form-control" id="emailclient" placeholder="Email Client" required>
                                        <label for="emailclient">Email Client</label>
                                    </div>
    
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom_respon" placeholder="Nom du responsable" required>
                                        <label for="nom_respon">Nom du responsable</label>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                   
                                   <div class="form-floating">
                                        <input type="text" class="form-control" id="telephone_respo" placeholder="Telephone du responsable" required>
                                        <label for="telephone_respo">Telephone du responsable</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                      <div class="form-floating">
                                        <input type="email" class="form-control" id="email_respon" placeholder="Email du responsable" required>
                                        <label for="email_respon">Email du responsable</label>
                                    </div>    
                                
                                </div>
                            </div>

                            <!-- Section 5 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="RCCM" placeholder="RCCM" required>
                                        <label for="RCCM">RCCM</label>
                                    </div>
                                </div>
                              
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numeroimpot" placeholder="Numero Impot" required>
                                        <label for="numeroimpot">Numero Impot</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="numclasseur" placeholder="Numero Classeur" required>
                                        <label for="numclasseur">Numero Classeur</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitForm()">Enregistrer <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Gestion Contrat -->
<div class="modal fade" id="gestionContratModal" ddata-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gestionContratModalLabel">Gestion de Contrat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="gestionContratForm">
                    <!-- Section 1: Incorporation/Radiation -->
                    <div class="mb-4">
                        <h6>Incorporation/Radiation</h6>
                        <div class="col-md-6 form-floating mb-3">
                            <input type="text" class="form-control" id="numPolice" placeholder="Numéro Police">
                            <label for="numPolice">Numéro Police</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ajoutBeneficiaire" onclick="toggleSection('incorporationSection', this.checked)">
                                    <label class="form-check-label" for="ajoutBeneficiaire">Ajouter Bénéficiaire</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="retraitBeneficiaire" onclick="toggleSection('radiationSection', this.checked)">
                                    <label class="form-check-label" for="retraitBeneficiaire">Retirer Bénéficiaire</label>
                                </div>
                            </div>
                        </div>

                        <!-- Incorporation Section -->
                        <div id="incorporationSection" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="nbAgentsIncorp" placeholder="Nombre d'agents">
                                        <label for="nbAgentsIncorp">Nombre d'agents</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="nbConjointsIncorp" placeholder="Nombre de conjoints">
                                        <label for="nbConjointsIncorp">Nombre de conjoints</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="nbEnfantsIncorp" placeholder="Nombre d'enfants">
                                        <label for="nbEnfantsIncorp">Nombre d'enfants</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateIncorp" placeholder="Date Incorporation">
                                        <label for="dateIncorp">Date Incorporation</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.01" class="form-control" id="primeIncorp" placeholder="Prime Nette Incorporation">
                                        <label for="primeIncorp">Prime Nette Incorporation</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Radiation Section -->
                        <div id="radiationSection" style="display: none;" class="mt-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="nbAgentsRadiation" placeholder="Nombre d'agents">
                                        <label for="nbAgentsRadiation">Nombre d'agents</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateRadiation" placeholder="Date Radiation">
                                        <label for="dateRadiation">Date Radiation</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ristourneCheckbox" onclick="toggleField('ristourneField', this.checked)">
                                        <label class="form-check-label" for="ristourneCheckbox">Ristourne de la Prime</label>
                                    </div>
                                    <div id="ristourneField" class="form-floating mt-3" style="display: none;">
                                        <input type="number" step="0.01" class="form-control" id="ristourneAmount" placeholder="Part Prime Nette Ristourne">
                                        <label for="ristourneAmount">Part Prime Nette Ristourne</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Suspension/Résiliation -->
                    <div class="mb-4">
                        <h6>Suspension/Résiliation</h6>
                       <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="suspensionCheckbox" onclick="toggleSection('suspensionSection', this.checked)">
                                    <label class="form-check-label" for="suspensionCheckbox">Suspension</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="resiliationCheckbox" onclick="toggleSection('resiliationSection', this.checked)">
                                    <label class="form-check-label" for="resiliationCheckbox">Résiliation</label>
                                </div>
                            </div>
                        </div>

                        <!-- Suspension Section -->
                        <div id="suspensionSection" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateSuspension" placeholder="Date Suspension">
                                        <label for="dateSuspension">Date Suspension</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dateReprise" placeholder="Date Reprise">
                                        <label for="dateReprise">Date Reprise</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Résiliation Section -->
                        <div id="resiliationSection" style="display: none;" class="mt-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="dateResiliation" placeholder="Date Résiliation">
                                <label for="dateResiliation">Date Résiliation</label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Annuler</button>
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
            }, 4500); // Durée d'affichage de 4,5 secondes
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
    </script>

    <script>
        // Les traitement de la page

       

        document.addEventListener('DOMContentLoaded', function(){
            // chargeSite
            fetch('http://localhost/crm-gga/app/codes/api/v1/api_client.php/site')
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
                        data.forEach(site => {
                            const option = document.createElement('option');
                            option.value = site.idsite;
                            option.textContent = site.libsite;
                            selectSite.appendChild(option);
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
        });
    </script>
    
</body>
</html>