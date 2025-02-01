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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
<div id="loader" class="loader" style="display: none;">
    <img src="loader.gif" alt="Chargement..." />
</div>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
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
            <form id="clientForm" onsubmit="handleSubmit(event)">
          
                <!-- Section 2 -->
                <div class="form-section">
                <div class="row g-3">
                <span class="fw-bold text-danger" style="font-size: 16px;">Mise en place contrat / <span class="fw-bold text-dark" id="typecont" style="font-size: 16px;"></span></span> 
                <hr>
                <div class="col-md-4">
                        <label for="typecontrat" class="form-label">Type contrat</label>
                    <select name="typecontrat" id="typecontrat" class="form-select fw-bold" style="font-size: 12px;">
                        <option value="0">...</option>
                    </select>
                   
                    </div>
                    <div class="col-md-4">
                    <label for="client" class="form-label">Client</label>
                    <select name="client" id="client" class="form-select" style="border: solid 1px #ccc;" >
                        <option value="0">--Choisir--</option>
                    </select>
                </div>    
               
                <div class="col-md-4">
                    <label for="site" class="form-label">Gestionnaire</label>
                    <select name="gestionnaire" id="gestionnaire" class="form-select" style="border: solid 1px #ccc;">
                        <option value="0">--Choisir--</option>
                    </select>
                </div>
                <fieldset class="border p-3 mt-3 d-none position-relative" id="diveffectif" style="border-radius: 5px; border: 2px solidrgb(11, 11, 11);background-color:#f4f4f9">
                        <legend class="w-auto px-3" style="font-size: 13px; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #f4f4f9; color:rgb(35, 36, 37);border: 0.5px solid; border-radius: 5px; padding: 0 10px;">Effectif bénéficiares</legend>
                        <div class="row">
                        <div class="col-md-3">
                        <label for="effectAgent">Effectif Agent</label>
                        <input type="number" class="form-control" name="effectAgent" id="effectAgent" min="0" oninput="calculateEffectifs()">
                    </div>
                    <div class="col-md-3">
                        <label for="effectConj">Effectif Conjoint</label>
                        <input type="number" class="form-control" name="effectConj" id="effectConj" min="0" oninput="calculateEffectifs()">
                    </div>
                    <div class="col-md-3">
                        <label for="effectEnf">Effectif Enfant</label>
                        <input type="number" class="form-control" name="effectEnf" id="effectEnf" min="0" oninput="calculateEffectifs()">
                    </div>
                    <div class="col-md-3">
                        <label for="effectTot">Effectif Total</label>
                        <input type="number" class="form-control" name="effectTot" id="effectTot" readonly style="background-color:#f9f9f9;">
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
                        <input type="date" class="form-control" id="dateEffet" style="font-size: 12px;border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="dateEcheance" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" id="dateEcheance" style="font-size: 12px;border: solid 1px #ccc;">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="primeNette" class="form-label">Prime Nette</label>
                        <input type="text" class="form-control" id="primeNette" style="border: solid 1px #ccc;" placeholder="0.00$" oninput="calculatePrimeTtc()">
                    </div>

                    <div class="col-md-4">
                        <label for="accessoires" class="form-label">Accessoires <span class="text-danger">(Montant accessoires)</span></label>
                        <input type="text" class="form-control" id="accessoires" style="border: solid 1px #ccc;" placeholder="0.00$" oninput="calculatePrimeTtc()">
                    </div>

                    <div class="col-md-4">
                        <label for="primeTtc" class="form-label">Prime TTC</label>
                        <input type="text" class="form-control" id="primeTtc" style="border: solid 1px #ccc;background-color:rgb(244, 235, 186);" readonly>
                    </div>
                    <div class="col-md-4">
                    <label for="intermediaire" class="form-label">Intermediaire</label><br>
                    <select name="intermediaire" id="intermediaire" class="form-select" style="border: solid 1px #ccc;font-size:12px;width:405px">
                    </select>
                </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4" style="font-size: 13px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="reassurance" style="border: solid 1px #ccc;">
                        <label class="form-check-label" for="reassurance"> Cocher si Contrat en réassurance</label>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <label for="modaliteFacturation" class="form-label">Frais de gestion GGA</label>
                        
                        <div class="input-group mb-3">
                            <label class="input-group-text" style="font-size: 12px;">%</label>
                            <input type="text" class="form-control" placeholder="0" aria-label="Username" id="mod_Facturation" oninput="calculateModaliteFacturation()">
                            <label class="input-group-text" style="font-size: 12px;">Valeur</label>
                            <input type="text" class="form-control" placeholder="0.00" aria-label="Server" id="Valmod_Facturation" style="background-color:rgb(244, 235, 186);" readonly>
                            </div>
                    </div>
                    <div class="container-fluid px-3">
                    <div class="row d-none p-3 mt-2" id="reassurance-fields" 
                        style="border: 1px solid #ccc; border-radius: 5px; background-color: #f4f4f9;">
                        <div class="col-md-4">
                            <label for="reassureur" class="form-label">Réassureur</label>
                            <select name="reassureur" id="reassureur" class="form-select" 
                                    style="font-size: 12px; border: 1px solid #ccc; padding: 8px;">
                                <option value="">--choisir--</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="quoteReassureur" class="form-label">Quote-part réassureur</label>
                            <input type="text" class="form-control" id="QpReassureur" 
                                style="border: 1px solid #ccc; padding: 8px;">
                        </div>
                        <div class="col-md-4">
                            <label for="quoteAssureur" class="form-label">Quote-part assureur</label>
                            <input type="text" class="form-control" id="QpAssureur" 
                                style="border: 1px solid #ccc; padding: 8px;">
                        </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex justify-content-center align-items-center pt-4">
                    <div class="form-check me-3 d-flex align-items-center" style="font-size: 13px;">
                        <input class="form-check-input" type="checkbox" value="" id="PaieSinAssureur" style="border: solid 1px #ccc;">
                        <label class="form-check-label ms-2" for="PaieSinAssureur" style="">Paiment sinistre par l'assureur</label>
                </div>
                <div class="form-check d-flex align-items-center" style="font-size: 13px;">
                    <input class="form-check-input" type="checkbox" value="" id="PaieSinGGA" style="border: solid 1px #ccc;">
                    <label class="form-check-label ms-2" for="PaieSinGGA" style="">Paiement sinistre par GGA</label>
                </div>
            </div>
                   
               
                <div class="col-md-4">
                    <label for="appelFondsInitial" class="form-label">Appel de fonds initial</label>
                    
                    <div class="input-group mb-3">
                            <label class="input-group-text" style="font-size: 12px;">%</label>
                            <input type="text" class="form-control" placeholder="0" aria-label="Username" id="PourceAFInitial" oninput="calculateModaliteAFInit()">
                            <label class="input-group-text" style="font-size: 12px;">Valeur</label>
                            <input type="text" class="form-control" placeholder="0.00" aria-label="Server" id="ValAFInitial" style="background-color:rgb(244, 235, 186);" readonly>
                            </div>
                </div>
                <div class="col-md-4">
                    <label for="seuilSinistre" class="form-label">Seuil sinistre</label>
                    <input type="text" class="form-control" id="seuilSinistre" style="border: solid 1px #ccc;">
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
                            <input type="text" class="form-control" placeholder="0.00" id="budgetTotal" style="border: solid 1px #ccc;">
                        </div>
                        <div class="col-md-4">
                            <label for="modAppelFonds" class="form-label">Modalité d'appel de fonds</label>
                            <div class="input-group mb-3">
                            <label class="input-group-text" style="font-size: 12px;">%</label>
                            <input type="text" class="form-control" placeholder="0" aria-label="Username" id="PourcmodAppelFonds" oninput="calculateModaliteAppelFonds()">
                            <label class="input-group-text" style="font-size: 12px;">Valeur</label>
                            <input type="text" class="form-control" placeholder="0.00" aria-label="Server" id="ValmodAppelFonds" readonly style="background-color:rgb(244, 235, 186);">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="seuilAppelFonds" class="form-label">Seuil d'appel de fonds</label>
                            <input type="text" class="form-control" placeholder="0.00" id="seuilAppelFonds">
                        </div>
                        <div class="row">
                            <!-- Frais gestion GGA -->
                            <div class="col-md-4">
                            <label for="fraisGestionGGA" class="form-label">Frais gestion GGA</label>
                           <div class="input-group mb-3">
                            <label class="input-group-text" style="font-size: 12px;">%</label>
                            <input type="text" class="form-control" placeholder="0" aria-label="Username" id="fraisGestionGGA" oninput="calculateTotalFraisGestion()">
                            <label class="input-group-text" style="font-size: 12px;">Valeur</label>
                            <input type="text" class="form-control" placeholder="0.00" aria-label="Server" id="ValfraisGestionGGAHT" readonly style="background-color:rgb(244, 235, 186);">
                            </div>
                        </div>
                        <!-- Case à cocher centré -->
                        <div class="col-md-4 d-flex align-items-center justify-content-center pt-4" style="font-size: 13px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="TVA" style="border: solid 1px #ccc;" onchange="calculateTotalFraisGestion()">
                                <label class="form-check-label text-danger" for="TVA"> Cocher si TVA applicable</label>
                            </div>
                        </div>
                        <!-- Total frais gestion -->
                        <div class="col-md-4">
                            <label for="totalFraisGestion" class="form-label">Total frais gestion</label>
                            <input type="text" class="form-control" id="totalFraisGestion" style="border: solid 1px #ccc;background-color:rgb(244, 235, 186);" readonly>
                        </div>
                        </div>

                        <div class="row mt-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-center pt-4" style="font-size: 13px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="FGIS" style="border: solid 1px #ccc;">
                                <label class="form-check-label ms-2" for="FGIS"> Cocher si Frais de gestion indexé à la sinistralité.</label>
                            </div>
                            
                        </div>
                        <div class="col-md-4">
                            <label for="modCompl" class="form-label">Modalité complémentaire</label>
                            <input type="text" class="form-control" id="modCompl"style="border: solid 1px #ccc;">
                        </div> 
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row mt-4">
                <div class="col-md-4"></div>
                <div class="col-md-4 d-flex justify-content-center align-items-center pt-2 d-none border border-danger" id="options-couverture">
                    <div class="form-check me-3 d-flex align-items-center" style="font-size: 13px;">
                        <input class="form-check-input" type="checkbox" value="" id="CN" style="border: solid 1px #ccc;">
                        <label class="form-check-label ms-2" for="CN" style="">Couverture nationale</label>
                </div>
                <div class="form-check d-flex align-items-center" style="font-size: 13px;">
                    <input class="form-check-input" type="checkbox" value="" id="CI" style="border: solid 1px #ccc;">
                    <label class="form-check-label ms-2" for="CI" style="">Couverture internationale</label>
                </div>
            </div>
            </div>
            <hr>
            <!-- Buttons -->
            <div class="mt-4 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary me-3">
                <i class="fas fa-save"></i> Enregistrer
            </button>
            <button type="reset" class="btn btn-danger">
                <i class="fas fa-times"></i> Annuler
            </button>
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
    <script src="script.js"></script>
    <script>
function handleSubmit(event) {
    event.preventDefault();  // Empêche la soumission du formulaire par défaut
    // Afficher le loader
    document.getElementById('loader').style.display = 'flex';

    // Récupérer les valeurs des champs du formulaire
    const typecontrat = document.getElementById('typecontrat').value;
    const client = document.getElementById('client').value;
    const gestionnaire = document.getElementById('gestionnaire').value;
    const assureur = document.getElementById('assureur').value;
    const dateEffet = document.getElementById('dateEffet').value;
    const dateEcheance = document.getElementById('dateEcheance').value;
    const primeNette = document.getElementById('primeNette').value;
    const accessoires = document.getElementById('accessoires').value;
    const primeTtc = document.getElementById('primeTtc').value;
    const intermediaire = document.getElementById('intermediaire').value;
    const reassurance = document.getElementById('reassurance').checked ? 1 : 0;
    const modaliteFacturation = document.getElementById('mod_Facturation').value;
    const ValmodFacturation = document.getElementById('Valmod_Facturation').value;
    const PaieSinAssureur = document.getElementById('PaieSinAssureur').checked ? 1 : 0;
    const PaieSinGGA = document.getElementById('PaieSinGGA').checked ? 1 : 0;
    const appelFondsInitial = document.getElementById('appelFondsInitial').value;
    const seuilSinistre = document.getElementById('seuilSinistre').value;
    
    // Vérification pour le type de contrat et ajustements supplémentaires si nécessaire
    let reassureur = null, quoteReassureur = null, quoteAssureur = null;
    if (reassurance) {
        reassureur = document.getElementById('reassureur').value;
        quoteReassureur = document.getElementById('QpReassureur').value;
        quoteAssureur = document.getElementById('QpAssureur').value;
    }

    // Création de l'objet à envoyer à l'API
    const data = {
        typecontrat,
        client,
        gestionnaire,
        assureur,
        dateEffet,
        dateEcheance,
        primeNette,
        accessoires,
        primeTtc,
        intermediaire,
        reassurance,
        modaliteFacturation,
        ValmodFacturation,
        PaieSinAssureur,
        PaieSinGGA,
        appelFondsInitial,
        seuilSinistre,
        reassureur,
        quoteReassureur,
        quoteAssureur
    };

    // Exemple de soumission d'API
    fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        // Masquer le loader après 4 secondes, même si la réponse est reçue plus tôt
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';
            
            // Afficher un SweetAlert en fonction du résultat
            if (result.success) {
                Swal.fire({
                    title: 'Succès!',
                    text: 'Le contrat a été enregistré avec succès.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Erreur!',
                    text: 'Une erreur est survenue lors de l\'enregistrement du contrat.',
                    icon: 'error',
                    confirmButtonText: 'Réessayer'
                });
            }
        }, 4000);  // Délai de 4 secondes avant de masquer le loader et afficher la réponse
    })
    .catch(error => {
        // Masquer le loader après 4 secondes, même en cas d'erreur
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';

            // Afficher une alerte en cas d'erreur de connexion
            Swal.fire({
                title: 'Erreur!',
                text: 'Impossible de communiquer avec le serveur.',
                icon: 'error',
                confirmButtonText: 'Réessayer'
            });
        }, 4000);  // Délai de 4 secondes avant de masquer le loader et afficher l'alerte
    });
}


</script>

    <script>
     
//--------------traitement formulaire---------------------------
document.getElementById('typecontrat').addEventListener('change', function () {
    const selectedValue = this.value;
    const type1Fields = document.getElementById('typecontrat-1-fields');
    const type2Fields = document.getElementById('typecontrat-2-fields');
    const couvertures = document.getElementById('options-couverture');
    const effectifs = document.getElementById('diveffectif');

    // Réinitialiser la visibilité
    type1Fields.classList.add('d-none');
    type2Fields.classList.add('d-none');
    couvertures.classList.add('d-none');
    effectifs.classList.add('d-none');

    if (selectedValue === '1') {
        // Afficher les champs pour typecontrat=1
        type1Fields.classList.remove('d-none');
        couvertures.classList.remove('d-none');
        effectifs.classList.remove('d-none');
    } else if (selectedValue === '2') {
        // Afficher les champs pour typecontrat=2
        type2Fields.classList.remove('d-none');
        couvertures.classList.remove('d-none');
        effectifs.classList.remove('d-none');
    }
});
document.getElementById('reassurance').addEventListener('change', function () {
    const reassuranceFields = document.getElementById('reassurance-fields');
    const reassureur = document.getElementById('reassureur');
    const quotePartReassureur = document.getElementById('QpReassureur');
    const quotePartAssureur = document.getElementById('QpAssureur');

    if (this.checked) {
        // Activer les champs
        reassuranceFields.classList.remove('d-none');
        reassureur.disabled = false;
        quotePartReassureur.disabled = false;
        quotePartAssureur.disabled = false;
    } else {
        // Désactiver les champs
        reassuranceFields.classList.add('d-none');
        reassureur.disabled = true;
        quotePartReassureur.disabled = true;
        quotePartAssureur.disabled = true;
    }
});
function calculateTotalFraisGestion() {
    var budget = parseFloat(document.getElementById('budgetTotal').value) || 0; // Récupère le montant du budget
    var fraisGestionPourcentage = parseFloat(document.getElementById('fraisGestionGGA').value) || 0; // Récupère le pourcentage saisi
    var tvaChecked = document.getElementById('TVA').checked; // Vérifie si la TVA est cochée

    // Calcul de la valeur HT des frais de gestion
    var fraisGestionGGAHT = (budget * fraisGestionPourcentage) / 100;

    // Mise à jour du champ de valeur HT
    document.getElementById('ValfraisGestionGGAHT').value = fraisGestionGGAHT.toFixed(2);

    // Calcul du total des frais de gestion en ajoutant la TVA si cochée
    var totalFraisGestion = fraisGestionGGAHT;
    if (tvaChecked) {
        totalFraisGestion += fraisGestionGGAHT * 0.16; // Ajoute 16% si TVA cochée
    }

    // Mise à jour du champ total frais gestion
    document.getElementById('totalFraisGestion').value = totalFraisGestion.toFixed(2);
}

// Attacher l'événement aux champs d'entrée
document.getElementById('fraisGestionGGA').addEventListener('input', calculateTotalFraisGestion);
document.getElementById('budgetTotal').addEventListener('input', calculateTotalFraisGestion);
document.getElementById('TVA').addEventListener('change', calculateTotalFraisGestion);

// Initialisation au chargement de la page
window.onload = function() {
    calculateTotalFraisGestion();
};

     // Fonction de calcul de Prime TTC
     function calculatePrimeTtc() {
        var primeNette = parseFloat(document.getElementById('primeNette').value) || 0; // récupère la valeur de primeNette
        var accessoires = parseFloat(document.getElementById('accessoires').value) || 0; // récupère la valeur de accessoires
        
        // Calcule la Prime TTC comme la somme de primeNette et accessoires
        var primeTtc = primeNette + accessoires;

        // Met à jour la valeur de primeTtc
        document.getElementById('primeTtc').value = primeTtc.toFixed(2);
    }
    function calculateModaliteFacturation() {
    const pourcentageField = document.getElementById("mod_Facturation");
    const valeurField = document.getElementById("Valmod_Facturation");
    const totalAmountField = document.getElementById("primeNette");

    const pourcentage = parseFloat(pourcentageField.value) || 0; // Récupère le pourcentage
    const totalAmount = parseFloat(totalAmountField.value) || 0; // Récupère le montant total

    // Calcul de la valeur
    const valeur = (totalAmount * pourcentage) / 100;

    // Affiche le résultat dans le champ "Valeur"
    valeurField.value = valeur.toFixed(2); 
    document.getElementById('Valmod_Facturation').value = valeurField.toFixed(2);// Formate à 2 décimales
}
function calculateModaliteAppelFonds() {
    const pourcentageAF = document.getElementById("PourcmodAppelFonds");
    const valeurMod = document.getElementById("ValmodAppelFonds");
    const Budget = document.getElementById("budgetTotal");

    const pourcAF = parseFloat(pourcentageAF.value) || 0; // Récupère le pourcentage
    const totalB = parseFloat(Budget.value) || 0; // Récupère le montant total

    // Calcul de la valeur
    const valeurAP2 = (totalB * pourcAF) / 100;

    // Affiche le résultat dans le champ "Valeur"
    valeurMod.value = valeurAP2.toFixed(2); 
    document.getElementById('ValmodAppelFonds').value = valeurMod.toFixed(2);// Formate à 2 décimales
}
function calculateModaliteAFInit() {
    const pourcentageAFInit = document.getElementById("PourceAFInitial");
    const valeurMod2 = document.getElementById("ValAFInitial");
    const valAFI = document.getElementById("primeNette");

    const pourcAFI = parseFloat(pourcentageAFInit.value) || 0; // Récupère le pourcentage
    const totalAFI = parseFloat(valAFI.value) || 0; // Récupère le montant total

    // Calcul de la valeur
    const TotvaleurAFI = (totalAFI * pourcAFI) / 100;

    // Affiche le résultat dans le champ "Valeur"
    valeurMod2.value = TotvaleurAFI.toFixed(2); 
    document.getElementById('ValAFInitial').value = valeurMod2.toFixed(2);// Formate à 2 décimales
}
function calculateEffectifs() {
    const agent = document.getElementById("effectAgent");
    const conjoint = document.getElementById("effectConj");
    const enfant = document.getElementById("effectEnf");
    const totalEffectif = document.getElementById("effectTot"); // Correction du nom

    // Récupération des valeurs (avec gestion des valeurs vides ou invalides)
    const effAgent = parseInt(agent.value) || 0;
    const effConjoint = parseInt(conjoint.value) || 0;
    const effEnfant = parseInt(enfant.value) || 0;

    // Calcul du total
    const total = effAgent + effConjoint + effEnfant;

    // Mise à jour du champ "Effectif Total"
    totalEffectif.value = total; 
}


    // Fonction pour valider que seules les valeurs numériques sont saisies
    function validateNumericInput(event) {
        var value = event.target.value;
        // Remplace tout ce qui n'est pas un chiffre ou un point
        event.target.value = value.replace(/[^0-9.]/g, '');
    }

    // Attacher l'événement de validation numérique aux champs
    document.getElementById('primeNette').addEventListener('input', validateNumericInput);
    document.getElementById('accessoires').addEventListener('input', validateNumericInput);
    document.getElementById('budgetTotal').addEventListener('input', validateNumericInput);
    document.getElementById('PourcmodAppelFonds').addEventListener('input', validateNumericInput);

    // Initialisation de la valeur de primeTtc au chargement de la page
    window.onload = function() {
        calculatePrimeTtc();
    };
//------------ fin traitement formulaire---------------

document.addEventListener('DOMContentLoaded', function () {
    const selectTypeContrat = document.getElementById('typecontrat');
    const typepolice = document.getElementById('typecont');

    // Fonction pour charger les types de contrat
    function chargerTypesContrat() {
        fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getTypeContrat')
            .then(response => response.json())
            .then(data => {
                if (data.status === 200) {
                    data.data.forEach(type => {
                        const option = document.createElement('option');
                        option.value = type.idtype;
                        option.textContent = type.libtype;
                        selectTypeContrat.appendChild(option);
                    });

                    // Afficher la première option sélectionnée si elle existe
                    if (selectTypeContrat.options.length > 0) {
                        afficherTypeContrat();
                    }
                } else {
                    console.error('Erreur: ', data.message);
                }
            })
            .catch(error => console.error('Erreur lors du chargement des types de contrats:', error));
    }

    // Fonction pour afficher le type de contrat sélectionné
    function afficherTypeContrat() {
        const selectedOption = selectTypeContrat.options[selectTypeContrat.selectedIndex];
        typepolice.textContent = selectedOption.textContent; // Mise à jour du texte
    }

    // Charger les types de contrat au démarrage
    chargerTypesContrat();

    // Mettre à jour l'affichage lors d'un changement de sélection
    selectTypeContrat.addEventListener('change', afficherTypeContrat);

const selectPartenaire = document.getElementById('assureur');
selectPartenaire.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
    .then(response => response.json())
    .then(data => {
        selectPartenaire.innerHTML = ''; // Nettoyer les options par défaut
        
        // Ajouter l'option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '--choisir--';
        selectPartenaire.appendChild(defaultOption);

        // Ajouter les options récupérées depuis l'API
        data.forEach(parten => {
            const option = document.createElement('option');
            option.value = parten.idpartenaire;
            option.textContent = parten.denom_social;
            selectPartenaire.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectPartenaire.innerHTML = '<option>Erreur de chargement</option>';
    });

    //Les reassusseurs
const selectReassureur = document.getElementById('reassureur');
selectReassureur.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
    .then(response => response.json())
    .then(data => {
        selectReassureur.innerHTML = ''; // Nettoyer les options par défaut
        
        // Ajouter l'option par défaut
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = '--choisir--';
        selectReassureur.appendChild(defaultOption);

        // Ajouter les options récupérées depuis l'API
        data.forEach(parten2 => {
            const option = document.createElement('option');
            option.value = parten2.idpartenaire;
            option.textContent = parten2.denom_social;
            selectReassureur.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectReassureur.innerHTML = '<option>Erreur de chargement</option>';
    });

    //Les gestionnaires

const selectAgent = document.getElementById('gestionnaire');
selectAgent.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat.php/getGestionnaire')
    .then(response => response.json())
    .then(responseData => {
        // Vérifier si la réponse contient la clé "data"
        if (responseData.status === 200 && Array.isArray(responseData.data)) {
            const data = responseData.data;

            selectAgent.innerHTML = ''; // Nettoyer les options par défaut
            
            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectAgent.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            data.forEach(agent => {
                const option = document.createElement('option');
                option.value = agent.idagent;
                option.textContent = `${agent.nomagent} ${agent.prenomagent}`;
                selectAgent.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#gestionnaire').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectAgent.innerHTML = '<option>Erreur de chargement</option>';
    });

const selectIntermaire = document.getElementById('intermediaire');
selectIntermaire.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/intermediaire.php/liste')
    .then(response => response.json())
    .then(responseData => {
        // Vérifier si la réponse est un tableau d'objets
        if (Array.isArray(responseData)) {
            selectIntermaire.innerHTML = ''; // Nettoyer les options par défaut

            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectIntermaire.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            responseData.forEach(inter => {
                const option = document.createElement('option');
                option.value = inter.idinte;
                option.textContent = inter.nomcomplet; // Correction ici, vous aviez 'nocomplet' au lieu de 'nomcomplet'
                selectIntermaire.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#intermediaire').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectIntermaire.innerHTML = '<option>Erreur de chargement</option>';
    });

const selectClient = document.getElementById('client');
selectClient.innerHTML = '<option>Chargement...</option>'; // Avant la requête
fetch('http://localhost/crm-gga/app/codes/api/v1/api_client.php/rccm')
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP ! Statut : ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        // Vérifier si la réponse est un tableau
        if (Array.isArray(data)) {
            selectClient.innerHTML = ''; // Nettoyer les options par défaut
            
            // Ajouter l'option par défaut
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '--choisir--';
            selectClient.appendChild(defaultOption);

            // Ajouter les options récupérées depuis l'API
            data.forEach(client => {
                const option = document.createElement('option');
                option.value = client.idclient;
                option.textContent = client.den_social;
                selectClient.appendChild(option);
            });

            // Initialiser Select2 une fois les options ajoutées
            $('#client').select2({
                placeholder: '--choisir--',
                allowClear: true,
            });
        } else {
            throw new Error('Structure inattendue de la réponse API');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        selectClient.innerHTML = '<option>Erreur de chargement</option>';
    });


 //enregistrement contrat
    // Soumission du formulaire
    async function handleSubmit(event) {
        event.preventDefault();

        // Récupérer les valeurs du formulaire
        const formData = {
            
            client: document.getElementById('client').value,
            typecontrat: document.getElementById('typecontrat').value,
            aussureur: document.getElementById('assureur').value,
            dateEffet: document.getElementById('dateEffet').value,
            dateEcheance: document.getElementById('dateEcheance').value,
            primeNette: document.getElementById('primeNette').value,
            accessoires: document.getElementById('accessoires').value,
            primeTtc: document.getElementById('primeTtc').value,
            intermediaire: document.getElementById('intermediaire').value,
            reassurance: document.getElementById('reassurance').value,
            reassureur: document.getElementById('reassureur').value,
            QpReassureur: document.getElementById('QpReassureur').value,
            QpAssureur: document.getElementById('QpAssureur').value,
            mod_Facturation: document.getElementById('mod_Facturation').value,
            PaieSinAssureur: document.getElementById('PaieSinAssureur').value,
            PaieSinGGA: document.getElementById('PaieSinGGA').value,
            appelFondsInitial: document.getElementById('appelFondsInitial').value,
            seuilSinistre: document.getElementById('seuilSinistre').value,
            budgetTotal: document.getElementById('budgetTotal').value,
            modAppelFonds: document.getElementById('modAppelFonds').value,
            seuilAppelFonds: document.getElementById('seuilAppelFonds').value,
            fraisGestionGGA: document.getElementById('fraisGestionGGA').value,
            TVA: document.getElementById('TVA').value,
            totalFraisGestion: document.getElementById('totalFraisGestion').value,
            FGIS: document.getElementById('FGIS').value,
            modcompl: document.getElementById('modcompl').value,
            CN: document.getElementById('CN').value,
            CI: document.getElementById('CI').value,
            
        };

        try {
            const response = await fetch('http://localhost/crm-gga/app/codes/api/v1/ggacontrat/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();
            
            if (response.ok) {
                alert('Enregistrement réussi : ' + result.message);
            } else {
                alert('Erreur : ' + result.message);
            }
        } catch (error) {
            alert('Une erreur est survenue lors de l\'enregistrement : ' + error.message);
        }
    }     
});
</script>

</body>
</html>