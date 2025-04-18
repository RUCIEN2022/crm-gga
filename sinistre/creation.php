<?php 
include_once("../app/codes/api/v1/processContrat.php");
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- CSS de Select2 -->

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
       
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
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
.flag-icon {
            width: 20px;
            height: 15px;
            margin-right: 8px;
            vertical-align: middle;
        }
        /* Loader container */
        .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7); /* Fond transparent pour l'effet */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Image du loader */
    .loader img {
        width: 500px; /* Ajustez la taille du loader selon vos préférences */
        height: 300px;
    }
    legend {
    margin-top: 0;
    text-align: center;
}
/* Style de l'icône d'interrogation en cercle */
.icon-circle {
            width: 80px;
            height: 80px;
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: auto;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        }

        /* Style du modal */
        .modal-content {
            border-radius: 15px;
            border: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal-header {
            border-bottom: none;
            background: #f8f9fa;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .modal-footer {
            border-top: none;
            justify-content: center;
            gap: 10px;
        }

        /* Animation fluide */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        
        }
    </style>
</head>
<body>
<div id="loader" class="loader" style="display: none;">
    <img src="loader.gif" alt="Chargement..." />
</div>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <div id="content">
            <?php include_once('topbar.php'); ?>
            <!-- Cards -->
            <div class="container mt-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Production</a></li>
                <li class="breadcrumb-item active" aria-current="page">Création police</li>
            </ol>
            </nav>
        <div class="card shadow">
            <div class="card-body">
            <form id="clientForm" method="POST" onsubmit="return confirmerEnregistrement(this);">
                <div class="form-section">
                <div class="row g-3">
                <span class="fw-bold text-danger" style="font-size: 16px;">Mise en place contrat / <span class="fw-bold text-dark" id="typecont" style="font-size: 16px;"></span></span> 
                <hr>
                <div class="col-md-3">
                        <label for="typecontrat" class="form-label">Type contrat</label>
                    <select name="typecontrat" id="typecontrat" class="form-select fw-bold" style="font-size: 12px;" required>
                        <option value="0">...</option>
                    </select>
                    </div>
                    <div class="col-md-3">
                    <label for="client" class="form-label">Client</label>
                    <select name="client" id="client" class="form-select" style="border: solid 1px #ccc;" required>
                        <option value="0">--Choisir--</option>
                    </select>
                </div>    
                <div class="col-md-3">
                    <label for="gestionnaire" class="form-label">Gestionnaire</label>
                    <select name="gestionnaire" id="gestionnaire" class="form-select" style="border: solid 1px #ccc;" required>
                        <option value="0">--Choisir--</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="numpolice" class="form-label">Num. police</label>
                    <input type="text" class="form-control" id="numpolice" name="numpolice" placeholder="" require style="height: 30px;">
                    <div id="alertNumPolice" style="color: red; display: none;">Ce numéro de police existe déjà.</div>
                </div>
                <fieldset class="border p-3 mt-3 d-none position-relative" id="diveffectif" style="border-radius: 5px; border: 2px solidrgb(11, 11, 11);background-color:#f4f4f9">
                        <legend class="w-auto px-3" style="font-size: 13px; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #f4f4f9; color:rgb(35, 36, 37);border: 0.5px solid; border-radius: 5px; padding: 0 10px;">Effectif bénéficiares</legend>
                        <div class="row">
                        <div class="col-md-3">
                        <label for="effectAgent">Effectif Agent</label>
                        <input type="number" class="form-control" name="effectAgent" id="effectAgent" min="0" oninput="calculateEffectifs()" required>
                    </div>
                    <div class="col-md-3">
                        <label for="effectConj">Effectif Conjoint</label>
                        <input type="number" class="form-control" name="effectConj" id="effectConj" min="0" oninput="calculateEffectifs()" required>
                    </div>
                    <div class="col-md-3">
                        <label for="effectEnf">Effectif Enfant</label>
                        <input type="number" class="form-control" name="effectEnf" id="effectEnf" min="0" oninput="calculateEffectifs()" required>
                    </div>
                    <div class="col-md-3">
                        <label for="effectTot">Effectif Total</label>
                        <input type="number" class="form-control" name="effectTot" id="effectTot" readonly style="background-color:#f9f9f9;" required>
                    </div>
                    </div>
                    </fieldset>
                    <div id="typecontrat-1-fields" class="d-none">
                        <div class="row g-3">
                        <div class="col-md-4">
                        <label for="assureur" class="form-label">Assureur</label>
                        <select name="assureur" id="assureur" class="form-select fw-bold" style="font-size: 12px;">
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="dateEffet" class="form-label">Date d'effet</label>
                        <input type="date" class="form-control" name="dateEffet" id="dateEffet" style="font-size: 12px;border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="dateEcheance" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" name="dateEcheance" id="dateEcheance" style="font-size: 12px;border: solid 1px #ccc;">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="primeNette" class="form-label">Prime Nette</label>
                        <input type="text" class="form-control" name="primeNette" id="primeNette" style="border: solid 1px #ccc;" placeholder="0.00$" oninput="calculatePrimeTtc()">
                    </div>

                    <div class="col-md-4">
                        <label for="accessoires" class="form-label">Accessoires <span class="text-danger">(Montant accessoires)</span></label>
                        <input type="text" class="form-control" name="accessoires" id="accessoires" style="border: solid 1px #ccc;" placeholder="0.00$" oninput="calculatePrimeTtc()">
                    </div>

                    <div class="col-md-4">
                        <label for="primeTtc" class="form-label">Prime TTC</label>
                        <input type="text" class="form-control" name="primeTtc" id="primeTtc" style="border: solid 1px #ccc;background-color:rgb(244, 235, 186);" readonly>
                    </div>
                    <div class="col-md-4">
                    <label for="intermediaire" class="form-label">Intermediaire</label><br>
                    <select name="intermediaire" id="intermediaire" class="form-select" style="border: solid 1px #ccc;font-size:12px;width:405px">
                    </select>
                </div>
                <div class="col-md-4 d-flex justify-content-center align-items-center pt-4">
                    <div class="form-check me-3 d-flex align-items-center" style="font-size: 13px;">
                        <input class="form-check-input" type="checkbox" name="PaieSinAssureur" id="PaieSinAssureur" style="border: solid 1px #ccc;">
                        <label class="form-check-label ms-2" for="PaieSinAssureur">Paiment sinistre par l'assureur</label>
                </div>
                <div class="form-check d-flex align-items-center" style="font-size: 13px;">
                    <input class="form-check-input" type="checkbox" name="PaieSinGGA" id="PaieSinGGA" style="border: solid 1px #ccc;">
                    <label class="form-check-label ms-2" for="PaieSinGGA">Paiement sinistre par GGA</label>
                </div>
            </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4" style="font-size: 13px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="reassurance" id="reassurance" style="border: solid 1px #ccc;">
                        <label class="form-check-label" for="reassurance"> Cocher si Contrat en réassurance</label>
                    </div>
                    </div>
                    <div class="container-fluid px-3">
                    <div class="row d-none p-3 mt-2" id="reassurance-fields" 
                        style="border: 1px solid #ccc; border-radius: 5px;">
                        <div class="col-md-4">
                            <label for="reassureur" class="form-label">Réassureur</label>
                            <select name="reassureur" id="reassureur" class="form-select" 
                                    style="font-size: 12px; border: 1px solid #ccc; padding: 8px;">
                                <option value="0">--choisir--</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="QpReassureur" class="form-label">Quote-part réassureur</label>
                            <input type="text" class="form-control" name="QpReassureur" id="QpReassureur" 
                                style="border: 1px solid #ccc; padding: 8px;">
                        </div>
                        <div class="col-md-4">
                            <label for="QpAssureur" class="form-label">Quote-part assureur</label>
                            <input type="text" class="form-control" name="QpAssureur" id="QpAssureur" 
                                style="border: 1px solid #ccc; padding: 8px;">
                        </div>
                        </div>
                    </div>
                </div>
                </div>        
                </div>
                </div>
                    <div class="row">
                    <div id="typecontrat-2-fields" class="d-none">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="budgetTotal" class="form-label">Budget total</label>
                            <input type="text" class="form-control" placeholder="0.00" name="budgetTotal" id="budgetTotal" style="border: solid 1px #ccc;">
                        </div>
                        <div class="col-md-4 d-flex justify-content-center align-items-center pt-4" style="font-size: 13px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="FGIS" id="FGIS" style="border: solid 1px #ccc;">
                                <label class="form-check-label ms-2" for="FGIS"> Cocher si Frais de gestion indexé à la sinistralité.</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="modCompl" class="form-label">Modalité complémentaire</label>
                            <input type="text" class="form-control" name="modCompl" id="modCompl" style="border: solid 1px #ccc;">
                        </div> 
                    </div>
                </div>
            </div> 
           <div class="row d-none mt-4 d-flex align-items-center justify-content-center" id="appel-fonds">
            <hr>
           <div class="col-md-4"  >
            <label class="form-label">Appel de fonds</label>
            <div class="input-group mb-3">
                        <label class="input-group-text" for="PourceAFInitial" style="font-size: 12px;">%</label>
                        <input type="text" class="form-control" placeholder="0" aria-label="Username" name="PourcmodAppelFonds" id="PourcmodAppelFonds" oninput="calculateModaliteAppelFonds()">
                        <label class="input-group-text" style="font-size: 12px;">Valeur</label>
                        <input type="text" class="form-control" placeholder="0.00" aria-label="Server"  name="ValmodAppelFonds" id="ValmodAppelFonds" readonly style="background-color:rgb(244, 235, 186);">
                        </div>
            </div>
            <div class="col-md-4">
            <label class="form-label">Montant du Seuil</label>
                <div class="input-group mb-3">
                <input type="text" class="form-control" name="seuilAppelFonds" id="seuilAppelFonds" style="border: solid 1px #ccc;">
                </div>
            </div>
           </div>
            <div class="row d-none mt-2" id="option-frais-gest" style="border: 1px solid #ccc; border-radius: 5px; background-color: #f4f4f9;">
                <!-- Frais gestion GGA -->
                <div class="col-md-4">
                <label class="form-label">Frais gestion GGA</label>
                <div class="input-group mb-3">
                <label class="input-group-text" for="fraisGestionGGA" style="font-size: 12px;">%</label>
                <input type="text" class="form-control" placeholder="0" aria-label="Username" name="fraisGestionGGA" id="fraisGestionGGA" oninput="calculateTotalFraisGestion()">
                <label class="input-group-text" for="ValfraisGestionGGAHT" style="font-size: 12px;">Valeur</label>
                <input type="text" class="form-control" placeholder="0.00" aria-label="Server" name="ValfraisGestionGGAHT" id="ValfraisGestionGGAHT" readonly style="background-color:rgb(244, 235, 186);">
                </div>
            </div>
            <!-- Case à cocher centré -->
            <div class="col-md-2 d-flex align-items-center justify-content-center pt-4" style="font-size: 13px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="TVA" id="TVA" style="border: solid 1px #ccc;" onchange="calculateTotalFraisGestion()">
                    <label class="form-check-label text-danger" for="TVA"> TVA applicable ?</label>
                </div>
            </div>
            <!-- Total frais gestion -->
            <div class="col-md-2">
                <label for="totalFraisGestion" class="form-label">Total frais gestion</label>
                <input type="text" class="form-control" name="totalFraisGestion" id="totalFraisGestion" style="border: solid 1px #ccc;background-color:rgb(244, 235, 186);" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Mod. facturation</label>
                <div class="input-group mb-3">
                <label class="input-group-text" style="font-size: 12px;">%</label>
                <input type="text" class="form-control" placeholder="0%" name="modfact" id="modfact" oninput="calculateValModFact()">
                <label class="input-group-text" style="font-size: 12px;">Montant</label>
                <input type="text" class="form-control" placeholder="0.00" aria-label="Server" name="ValModFact" id="ValModFact" readonly style="background-color:rgb(244, 235, 186);">
                </div>
            </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4"></div>
                <div class="col-md-4 d-flex justify-content-center align-items-center pt-2 d-none border border-danger" id="options-couverture">
                    <div class="form-check me-3 d-flex align-items-center" style="font-size: 13px;">
                        <input class="form-check-input" type="checkbox" name="couverture" id="CN" value="Nationale" style="border: solid 1px #ccc;">
                        <label class="form-check-label ms-2" for="CN">Couverture nationale</label>
                </div>
                <div class="form-check d-flex align-items-center" style="font-size: 13px;">
                    <input class="form-check-input" type="checkbox" name="couverture" id="CI" value="Internationale" style="border: solid 1px #ccc;">
                    <label class="form-check-label ms-2" for="CI">Couverture internationale</label>
                </div>
            </div>
            </div>
            <hr>
           
            <div class="mt-4 d-flex justify-content-center gap-3">
           
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fas fa-save"></i> Enregistrer
            </button>

            
            <button type="reset" class="btn btn-danger">
                <i class="fas fa-times-circle"></i> Annuler
            </button>
        </div>


<!-- Modal de Confirmation -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <!-- En-tête du modal avec icône -->
                <div class="modal-header">
                    <div class="icon-circle">
                        <i class="fas fa-question"></i>
                    </div>
                    <h5 class="modal-title mt-3" id="exampleModalLabel">Confirmation</h5>
                </div>

                <!-- Corps du modal -->
                <div class="modal-body text-center">
                    <p class="text-muted">Voulez-vous vraiment enregistrer ce contrat ?</p>
                </div>

                <!-- Pied du modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary" name="BtnSaveContrat" id="BtnSaveContrat">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>

            </div>
        </div>
    </div>
            </form>
            </div>
        </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="../app/codes/machine/traitement_frontend.js"></script>
    
<script>
    document.getElementById('typecontrat').addEventListener('change', function () {
    const selectedValue = this.value;
    const type1Fields = document.getElementById('typecontrat-1-fields');
    const type2Fields = document.getElementById('typecontrat-2-fields');
    const couvertures = document.getElementById('options-couverture');
    const effectifs = document.getElementById('diveffectif');
    const appfonds = document.getElementById('appel-fonds');
    const fraisgest = document.getElementById('option-frais-gest');
    // Réinitialiser la visibilité
    type1Fields.classList.add('d-none');
    type2Fields.classList.add('d-none');
    couvertures.classList.add('d-none');
    effectifs.classList.add('d-none');
    appfonds.classList.add('d-none');
    fraisgest.classList.add('d-none');
    if (selectedValue === '1') {
        // Afficher les champs pour typecontrat=1
        type1Fields.classList.remove('d-none');
        couvertures.classList.remove('d-none');
        effectifs.classList.remove('d-none');
        fraisgest.classList.remove('d-none');
        appfonds.classList.remove('d-none');
    } else if (selectedValue === '2') {
        // Afficher les champs pour typecontrat=2
        type2Fields.classList.remove('d-none');
        couvertures.classList.remove('d-none');
        effectifs.classList.remove('d-none');
        appfonds.classList.remove('d-none');
        fraisgest.classList.remove('d-none');
    }
});
function calculateModaliteAppelFonds() {
    const pourcentageAF = document.getElementById("PourcmodAppelFonds");
    const valeurMod = document.getElementById("ValmodAppelFonds");
    const typecontrat = document.getElementById("typecontrat"); 
    const budgetTotal = document.getElementById("budgetTotal");
    const primeNette = document.getElementById("primeNette");

    const pourcAF = parseFloat(pourcentageAF.value) || 0; 
    let baseCalcul = 0;

    console.log("Type Contrat:", typecontrat.value); // Vérification
    console.log("Prime Nette avant traitement:", primeNette ? primeNette.value : "Non trouvé");

    // Vérifie que l'élément primeNette existe bien avant de l'utiliser
    if (typecontrat.value === "1" && primeNette) { 
        baseCalcul = parseFloat(primeNette.value.replace(",", ".").replace(/[^0-9.]/g, "")) || 0; 
        console.log("Base calcul avec Prime Nette:", baseCalcul);
    } else if (typecontrat.value === "2") { 
        baseCalcul = parseFloat(budgetTotal.value.replace(",", ".").replace(/[^0-9.]/g, "")) || 0; 
        console.log("Base calcul avec Budget Total:", baseCalcul);
    }

    // Calcul de la valeur d'appel de fonds
    const valeurAP2 = (baseCalcul * pourcAF) / 100;

    // Affichage du résultat
    valeurMod.removeAttribute("readonly"); // Active la modification
valeurMod.value = valeurAP2.toFixed(2);
valeurMod.setAttribute("readonly", true); // Remet en readonly après
 

    console.log("Valeur d'appel de fonds calculée:", valeurMod.value);
}
function calculateValModFact() {
    const pourcentageFact = document.getElementById("modfact");
    const valeurFact = document.getElementById("ValModFact");
    const totalFraisGestion = document.getElementById("totalFraisGestion");

    // Vérifier si totalFraisGestion est bien défini et contient une valeur
    if (!totalFraisGestion || totalFraisGestion.value.trim() === "") {
        console.warn("totalFraisGestion est vide ou non défini.");
        valeurFact.value = "0.00";
        return;
    }

    const pourcFact = parseFloat(pourcentageFact.value.replace("%", "")) || 0; // Nettoyage et conversion en nombre
    const baseCalcul = parseFloat(totalFraisGestion.value.replace(",", ".").replace(/[^0-9.]/g, "")) || 0; // Nettoyage et conversion

    console.log("Base calcul = Total Frais de Gestion :", baseCalcul);
    console.log("Pourcentage Facturation :", pourcFact);

    // Calcul de la valeur de facturation
    const valeurFacturation = (baseCalcul * pourcFact) / 100;

    // Affichage du résultat
    valeurFact.removeAttribute("readonly");
    valeurFact.value = valeurFacturation.toFixed(2);
    valeurFact.setAttribute("readonly", true);

    console.log("Valeur de modalité de facturation :", valeurFact.value);
}

</script>
</body>
</html>