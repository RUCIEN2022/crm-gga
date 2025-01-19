<?php 
//session_start();

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
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
            <?php include_once('topbar.php'); ?>
          
            <!-- Cards -->
            <div class="container mt-2">
            <h5 class=" mb-4">Contrats/Création police</h5>
        <div class="card shadow">
            <div class="card-body">
            <form>
            <!-- Section 1 -->
            <div class="row g-3">
                <span class="fw-bold text-danger">1. Information du client</span>
            <div class="col-md-3">
                    <label for="rccm" class="form-label">RCCM</label>
                    <input type="text" class="form-control" id="rccm" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="denomination" class="form-label">Dénomination sociale</label>
                    <input type="text" class="form-control" id="denomination" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="idNat" class="form-label">Id. Nat</label>
                    <input type="text" class="form-control" id="idNat" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="numeroImpot" class="form-label">Numéro Impôt</label>
                    <input type="text" class="form-control" id="numeroImpot" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="codeInterne" class="form-label">Code interne</label>
                    <input type="text" class="form-control" id="codeInterne" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="pays" class="form-label">Pays</label>
                    <select name="pays" id="pays" class="form-select" style="border: solid 1px #ccc;">
                            <option value="">--choisir--</option>
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" name="ville" id="ville" class="form-control" id="denomination" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" style="border: solid 1px #ccc;">
                </div>
                
                
                <div class="col-md-3">
                    <label for="emailEntreprise" class="form-label">Email entreprise</label>
                    <input type="email" class="form-control" id="emailEntreprise" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="telephoneEntreprise" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephoneEntreprise" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="telephoneEntreprise" class="form-label">Nom du responsable</label>
                    <input type="text" class="form-control" id="responsable" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="telephoneresponsable" class="form-label">Téléphone responsable</label>
                    <input type="text" class="form-control" id="telephonerespons" placeholder="" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="emailresponsable" class="form-label">Email responsable</label>
                    <input type="email" class="form-control" id="email responsable" style="border: solid 1px #ccc;">
                </div>
                <div class="col-md-3">
                    <label for="site" class="form-label">Site</label>
                    <select name="site" id="site" class="form-select" style="font-size: 12px;border: solid 1px #ccc;" >
                        <option value="0">--Choisir--</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="site" class="form-label">Gestionnaire</label>
                    <select name="gestionnaire" id="gestionnaire" class="form-select" style="border: solid 1px #ccc;">
                        <option value="0">--Choisir--</option>
                    </select>
                </div>
            </div>
<hr>
            <!-- Section 2 -->
            <div class="form-section">
                <div class="row g-3">
                <span class="fw-bold text-danger">2. Information du contrat</span>
                <div class="col-md-4">
                        <label for="typecontrat" class="form-label">Type contrat</label>
                    <select name="typecontrat" id="typecontrat" class="form-select fw-bold" style="font-size: 12px;">
                        <option value="0">--Choisir--</option>
                    </select>
                    <hr>
                    </div>
                    <div id="typecontrat-1-fields" class="d-none">
            <div class="row g-3">
            <div class="col-md-4">
                        <label for="assureur" class="form-label">Assureur</label>
                        <select name="assureur" id="assureur" class="form-select fw-bold" style="font-size: 12px;">
                            
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="dateEffet" class="form-label">Date d'effet</label>
                        <input type="date" class="form-control" id="dateEffet" style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="dateEcheance" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" id="dateEcheance" style="border: solid 1px #ccc;">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="primeNette" class="form-label">Prime Nette</label>
                        <input type="text" class="form-control" id="primeNette" style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="accessoires" class="form-label">Accessoires</label>
                        <input type="text" class="form-control" id="accessoires" style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="primeTtc" class="form-label">Prime TTC</label>
                        <input type="text" class="form-control" id="primeTtc" style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="intermediaire" class="form-label">Intermédiaire</label>
                        <input type="text" class="form-control" id="intermediaire" style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="reassurance" style="font-size: 20px;border: solid 1px #ccc;">
            <label class="form-check-label" for="reassurance"> Cocher si Contrat en réassurance</label>
        </div>
    </div>
        <div class="col-md-4">
                        <label for="reassureur" class="form-label">Réassureur</label>
                        <select name="reassureur" id="reassureur" class="form-select" style="font-size: 12px;border: solid 1px #ccc;">
                            <option value="">--choisir--</option>
                        </select>
                    </div>
        <div class="col-md-4">
                        <label for="quoteReassureur" class="form-label">Quote-part réassureur</label>
                        <input type="text" class="form-control" id="QpReassureur"style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="quoteAssureur" class="form-label">Quote-part assureur</label>
                        <input type="text" class="form-control" id="QpAssureur"style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4">
                        <label for="modaliteFacturation" class="form-label">Modalité Facturation</label>
                        <input type="text" class="form-control" id="mod_Facturation"style="border: solid 1px #ccc;">
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="PaieSinAssureur" style="font-size: 20px;border: solid 1px #ccc;">
            <label class="form-check-label" for="PaieSinAssureur"> Cocher si paiement sinistre par l'assureur</label>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="PaieSinGGA" style="font-size: 20px;border: solid 1px #ccc;">
            <label class="form-check-label" for="PaieSinGGA"> Cocher si paiement sinistre par GGA</label>
        </div>
    </div>
        <div class="col-md-4">
            <label for="appelFondsInitial" class="form-label">Appel de fonds initial</label>
            <input type="text" class="form-control" id="appelFondsInitial" style="border: solid 1px #ccc;">
        </div>
        <div class="col-md-4">
            <label for="seuilSinistre" class="form-label">Seuil sinistre</label>
            <input type="text" class="form-control" id="seuilSinistre" style="border: solid 1px #ccc;">
        </div>
        <div class="col-md-4 d-flex justify-content-center align-items-center mt-4">
    <div class="form-check me-3 d-flex align-items-center">
        <input class="form-check-input" type="checkbox" value="" id="CN" style="font-size: 20px;border: solid 1px #ccc;">
        <label class="form-check-label ms-2" for="CN" style="">Couverture nationale</label>
    </div>
    <div class="form-check d-flex align-items-center">
        <input class="form-check-input" type="checkbox" value="" id="CI" style="font-size: 20px;border: solid 1px #ccc;">
        <label class="form-check-label ms-2" for="CI" style="">Couverture internationale</label>
    </div>
</div>
            </div>
    </div>
                    
        </div>
    </div>

         
            
<div id="typecontrat-2-fields" class="d-none">
    <div class="row mt-2">
        <div class="col-md-4">
            <label for="budgetTotal" class="form-label">Budget total</label>
            <input type="text" class="form-control" id="budgetTotal" style="border: solid 1px #ccc;">
        </div>
        <div class="col-md-4">
            <label for="modAppelFonds" class="form-label">Modalité d'appel de fonds</label>
            <input type="text" class="form-control" id="modAppelFonds"style="border: solid 1px #ccc;">
        </div>
        <div class="col-md-4">
            <label for="seuilAppelFonds" class="form-label">Seuil d'appel de fonds</label>
            <input type="text" class="form-control" id="seuilAppelFonds">
        </div>
        <div class="row mt-2">
    <!-- Frais gestion GGA -->
    <div class="col-md-4">
        <label for="fraisGestionGGA" class="form-label">Frais gestion GGA</label>
        <input type="text" class="form-control" id="fraisGestionGGA"style="border: solid 1px #ccc;">
    </div>

    <!-- Case à cocher centré -->
    <div class="col-md-4 d-flex align-items-center justify-content-center pt-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="TVA" style="font-size: 20px;border: solid 1px #ccc;">
            <label class="form-check-label" for="TVA"> Cocher si TVA applicable</label>
        </div>
    </div>

    <!-- Total frais gestion -->
    <div class="col-md-4">
        <label for="totalFraisGestion" class="form-label">Total frais gestion</label>
        <input type="text" class="form-control" id="totalFraisGestion"style="border: solid 1px #ccc;">
    </div>
</div>

    
        <div class="row mt-2">
        <div class="col-md-4 d-flex align-items-center justify-content-center pt-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="FGIS" style="font-size: 20px;border: solid 1px #ccc;">
                <label class="form-check-label" for="FGIS"> Cocher si Frais de gestion indexé à la sinistralité.</label>
            </div>
        </div>
        <div class="col-md-4">
            <label for="modCompl" class="form-label">Modalité complémentaire</label>
            <input type="text" class="form-control" id="modCompl"style="border: solid 1px #ccc;">
        </div> 
        <div class="col-md-4 d-flex justify-content-center align-items-center mt-4">
    <div class="form-check me-3 d-flex align-items-center">
        <input class="form-check-input" type="checkbox" value="" id="CN" style="font-size: 20px;border: solid 1px #ccc;">
        <label class="form-check-label ms-2" for="CN" style="">Couverture nationale</label>
    </div>
    <div class="form-check d-flex align-items-center">
        <input class="form-check-input" type="checkbox" value="" id="CI" style="font-size: 20px;border: solid 1px #ccc;">
        <label class="form-check-label ms-2" for="CI" style="">Couverture internationale</label>
    </div>
</div>

       
        </div>
    </div>
</div>
            <!-- Buttons -->
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Enregistrer</button>
                <button type="reset" class="btn btn-secondary">Annuler</button>
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

//--------------traitement formulaire---------------------------
document.getElementById('typecontrat').addEventListener('change', function () {
    const selectedValue = this.value;
    const type1Fields = document.getElementById('typecontrat-1-fields');
    const type2Fields = document.getElementById('typecontrat-2-fields');

    // Réinitialiser la visibilité
    type1Fields.classList.add('d-none');
    type2Fields.classList.add('d-none');

    if (selectedValue === '1') {
        // Afficher les champs pour typecontrat=1
        type1Fields.classList.remove('d-none');
    } else if (selectedValue === '2') {
        // Afficher les champs pour typecontrat=2
        type2Fields.classList.remove('d-none');
    }
});
//------------ fin traitement formulaire---------------

document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost:8080/crm-gga/app/codes/api/v1/ggacontrat.php/getTypeContrat')
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                const selectTypeContrat = document.getElementById('typecontrat');
                data.data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.idtype;
                    option.textContent = type.libtype;
                    selectTypeContrat.appendChild(option);
                });
            } else {
                console.error('Erreur: ', data.message);
            }
        })
        .catch(error => console.error('Erreur lors du chargement des types de contrats:', error));

const selectPartenaire = document.getElementById('assureur');
selectPartenaire.innerHTML = '<option>Chargement...</option>'; // Avant la requête

fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
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

fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
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

fetch('http://localhost:8080/crm-gga/app/codes/api/v1/ggacontrat.php/getGestionnaire')
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

    fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_client.php/site')
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




    </script>
</body>
</html>