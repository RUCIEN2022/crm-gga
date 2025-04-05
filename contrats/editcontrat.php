<?php 
include_once("../app/codes/api/v1/GetInfoContrat.php");
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
    <title>Edit contrat</title>
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
.table tbody tr td {
    background-color: #923a4d !important;
    
}
fieldset {
        
        padding: 25px;
        position: relative;
        margin-top: 10px;
    }

    legend {
        font-size: 1.1rem;
        font-weight: bold;
        color:rgb(37, 38, 39);
        padding: 0 20px;
       
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
    }

    .form-check {
        display: inline-block;
        margin: 0 15px;
    }

    .form-check-input {
        accent-color: #007bff;
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
        button:hover {
    background-color: #7a2e3e !important; /* Légèrement plus foncé */
    transform: scale(1.05); /* Effet zoom léger */
}
.custom-radio {
    display: none;
}

.custom-radio:checked + .btn {
    color: white !important;
}

#ajoutBenef:checked + .btn {
    background-color: #923a4d;
    border-color: #923a4d;
}

#retraitBenef:checked + .btn {
    background-color: #923a4d;
    border-color: #923a4d;
}

#suspensionCheck:checked + .btn {
    background-color: #923a4d;
    border-color: #923a4d;
    color: black !important;
}

#resiliationCheck:checked + .btn {
    background-color: #923a4d;
    border-color: #923a4d;
}
.custom-radio-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border: 2px solid #dc3545;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #dc3545;
        background-color: transparent;
        font-weight: bold;
        min-width: 140px;
        text-align: center;
    }

    .custom-radio-label:hover, 
    .custom-radio-input:checked + .custom-radio-label {
        background-color: #dc3545;
        color: white;
    }

    .custom-radio-input {
        display: none;
    }

    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <div id="content">
            <?php include_once('topbar.php'); ?>
            <!-- Cards -->
           
        <div class="mt-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Production</a></li>
                    <li class="breadcrumb-item" aria-current="page">Gestion des contrats</li>
                    <li class="breadcrumb-item active">Incorporation / Radiation</li>
                </ol>
            </nav>
            <div class="card shadow" style="background-color: #f4f4f9;">
            <div class="card-body">
                <h5 class="card-title">Gestion du contrat</h5>
                <form id="form-action">
                <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="./" class="btn text-light fw-bold" style="background-color:#3498db">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
                <div class="d-flex align-items-center" style="width: 35%;">
                   
                </div>
            </div>
    <!-- Numéro Police -->
    <div class="col-md-4 mb-2">
        <label for="numeroPolice" class="form-label fw-bold">Numéro Police</label>
        <input type="text" id="numeroPolice" class="form-control" value="<?= htmlspecialchars($numero_police ?? '') ?>" disabled>
        <input type="text" name="idcontrat" id="idcontrat" value="<?= htmlspecialchars($idcontrat) ?>" hidden>
    </div>

    <!-- Fieldset pour l'opération -->
    <div class="col-md-8">
    <fieldset class="p-2 border rounded">
    <legend class="text-center px-3 fw-bold" style="width: auto; background: white; margin: 0 auto; transform: translateY(-50%);">
        Opérations
    </legend>
    <div class="d-flex justify-content-center gap-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input custom-radio" type="radio" name="actionType" id="ajoutBenef" value="ajout">
            <label class="form-check-label btn btn-outline-danger" for="ajoutBenef">
                <i class="bi bi-person-plus-fill me-1"></i> Incorporation
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input custom-radio" type="radio" name="actionType" id="retraitBenef" value="retrait">
            <label class="form-check-label btn btn-outline-danger" for="retraitBenef">
                <i class="bi bi-person-dash-fill me-1"></i> Radiation
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input custom-radio" type="radio" name="actionType" id="suspensionCheck" value="suspension">
            <label class="form-check-label btn btn-outline-danger" for="suspensionCheck">
                <i class="bi bi-pause-circle-fill me-1"></i> Suspension
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input custom-radio" type="radio" name="actionType" id="resiliationCheck" value="resiliation">
            <label class="form-check-label btn btn-outline-danger" for="resiliationCheck">
                <i class="bi bi-x-circle-fill me-1"></i> Résiliation
            </label>
        </div>
       
    </div>
</fieldset>

</div>

</div>

<div class="row">
    <!-- infos contrat -->
    <div class="mb-3">
        <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type Contrat</th>
                        <th>Couverture</th>
                        <th>Bénéficiaires</th>
                        <th>Prime/Budget</th>
                        <th>Client</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-light"><?= !empty($datec) ? date('d/m/Y', strtotime($datec)) : '' ?></td>
                        <td class="text-light"><?= htmlspecialchars($data['libtype'] ?? '') ?></td>
                        <td class="text-light"><?= htmlspecialchars($data['couverture'] ?? '') ?></td>
                        <td class="text-light text-end"> <?= htmlspecialchars($data['effectif_Benef'] ?? '') ?></td>
                        <td class="text-light text-end"><?= number_format($montant, 2, ',', ' ') ?> $</td>
                        <td class="text-light"><?= htmlspecialchars($client) ?></td>
                        <td style="
                            <?php
                            switch ($data['etat_contrat'] ?? '') {
                                case 1: echo 'color: orange; font-weight: bold;'; break;
                                case 2: echo 'color: green; font-weight: bold;'; break;
                                case 3: echo 'color: red; font-weight: bold;'; break;
                                case 4: echo 'color: gray; font-weight: bold;'; break;
                                default: echo 'color: black; font-weight: bold;';
                            }
                            ?>">
                            <?php
                            switch ($data['etat_contrat'] ?? '') {
                                case 1: echo 'En attente'; break;
                                case 2: echo 'En cours'; break;
                                case 3: echo 'En suspension'; break;
                                case 4: echo 'Résilié'; break;
                                default: echo 'Non défini';
                            }
                            ?>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


            <!-- Section Ajout Bénéficiaires -->
            <div id="ajoutSection" class="d-none">
                <h6 class="fw-bold">Incorporation de Bénéficiaires</h6> <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nombre Agents</label>
                        <input type="number" name="nbagent" id="nbagent" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Conjoints</label>
                        <input type="number" name="nbconjoint" id="nbconjoint" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Enfants</label>
                        <input type="number" name="nbenf" id="nbenf" min="0" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Date Incorporation</label>
                        <input type="date" name="dateincorp" id="dateincorp" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Prime Nette</label>
                        <input type="number" name="prime" id="prime" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Accessoires</label>
                        <input type="number" name="accessoire" id="accessoire" min="0" class="form-control">
                    </div>
                </div>
                <div class="row d-flex justify-content-end">
    <div class="form-group col-md-4">
        <label for="montantPrimettc">Montant Prime</label>
        <input type="text" id="montantPrimettc" name="montantPrimetcc" class="form-control text-center text-danger fw-bold" placeholder="0.00$" disabled>
    </div>
</div>


            </div>

            <!-- Section Retrait Bénéficiaires -->
            <div id="retraitSection" class="d-none">
                <h6 class="fw-bold">Retrait de Bénéficiaires</h6> <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nombre Agents</label>
                        <input type="number" name="nbragent" id="nbragent" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Conjoints</label>
                        <input type="number" name="nbrconj" id="nbrconj" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Enfants</label>
                        <input type="number" name="nbrenf" id="nbrenf" min="0" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                <!-- Date de Radiation -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Date Radiation</label>
                    <input type="date" name="dateradiat" id="dateradiat" class="form-control">
                </div>

                <!-- Ristourne Prime -->
                <div class="col-md-4 d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" id="ristournePrime" name="ristournePrime" min="0">
                    <label class="form-check-label" for="ristournePrime">Ristourne Prime</label>
                </div>

                <!-- Montant Prime -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Montant Prime</label>
                    <input type="number" id="montantPrime" name="montantPrime" min="0" class="form-control" disabled>
                </div>
                </div>

                </div>
                <!-- Suspension / Résiliation -->
            <div class="mb-3">
                
            <div id="suspensionSection" class="d-none row mt-2">
            <h6 class="fw-bold">Suspension Contrat</h6> <hr>
            <!-- Date Suspension -->
            <div class="col-md-4">
                <label class="form-label fw-bold">Date Suspension</label>
                <input type="date" name="datesusp" id="datesusp" class="form-control mb-2">
            </div>

            <!-- Date Reprise -->
            <div class="col-md-4">
                <label class="form-label fw-bold">Date Reprise</label>
                <input type="date" name="datereprise" id="datereprise" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Motif</label>
                <input type="text" name="motifreprise" id="motifreprise" class="form-control">
            </div>
            </div>

            </div>
            <div class="mb-3">
                <div id="resiliationSection" class="d-none mt-2">
                <h6 class="fw-bold">Résiliation Contrat</h6> <hr>
                 <div class="row">
                 <div class="col-md-4">
                    <label class="form-label">Date Résiliation</label>
                    <input type="date" name="dateresiliation" id="dateresiliation" class="form-control">
                    </div>
                    <div class="col-md-4">
                <label class="form-label fw-bold">Motif</label>
                <input type="text" name="motifresil" id="motifresil" class="form-control">
            </div>
                 </div>
                </div>
            </div>
            <div id="spinner" style="display:none;">
        <div class="spinner-border" role="status"></div>
    </div>
    <div id="error-message" class="text-danger"></div>
            <div class="d-flex justify-content-center">
            <button type="submit" class="btn text-light px-4 py-2 shadow d-none" id="submit-btn" style="background-color:#3498db; font-size: 1.1rem; transition: 0.3s;">
                <i class="bi bi-check-circle me-2"></i> Valider
            </button>
        </div>


        </form>
    </div>
    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const ajoutRadio = document.getElementById('ajoutBenef');
    const retraitRadio = document.getElementById('retraitBenef');
    const ajoutSection = document.getElementById('ajoutSection');
    const retraitSection = document.getElementById('retraitSection');

    const ristournePrime = document.getElementById('ristournePrime');
    const montantPrime = document.getElementById('montantPrime');

    const suspensionCheck = document.getElementById('suspensionCheck');
    const resiliationCheck = document.getElementById('resiliationCheck');
    const suspensionSection = document.getElementById('suspensionSection');
    const resiliationSection = document.getElementById('resiliationSection');

    const btnvalide = document.getElementById('submit-btn');

    function resetSections() {
        ajoutSection.classList.add('d-none');
        retraitSection.classList.add('d-none');
        suspensionSection.classList.add('d-none');
        resiliationSection.classList.add('d-none');
        btnvalide.classList.add('d-none');

        ajoutRadio.checked = false;
        retraitRadio.checked = false;
        suspensionCheck.checked = false;
        resiliationCheck.checked = false;
    }

    ajoutRadio.addEventListener('change', () => {
        resetSections();
        ajoutSection.classList.remove('d-none');
        ajoutRadio.checked = true;
        btnvalide.classList.remove('d-none');
    });

    retraitRadio.addEventListener('change', () => {
        resetSections();
        retraitSection.classList.remove('d-none');
        retraitRadio.checked = true;
        btnvalide.classList.remove('d-none');
    });

    ristournePrime.addEventListener('change', () => {
        montantPrime.disabled = !ristournePrime.checked;
    });

    suspensionCheck.addEventListener('change', () => {
        resetSections();
        suspensionSection.classList.remove('d-none');
        suspensionCheck.checked = true;
        btnvalide.classList.remove('d-none');
    });

    resiliationCheck.addEventListener('change', () => {
        resetSections();
        resiliationSection.classList.remove('d-none');
        resiliationCheck.checked = true;
        btnvalide.classList.remove('d-none');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-action');
    const ajoutSection = document.getElementById('ajoutSection');
    const retraitSection = document.getElementById('retraitSection');
    const suspensionSection = document.getElementById('suspensionSection');

    // Gérer l’affichage dynamique des sections selon l’option cochée
    document.querySelectorAll('input[name="actionType"]').forEach(radio => {
        radio.addEventListener('change', function () {
            ajoutSection.classList.add('d-none');
            retraitSection.classList.add('d-none');
            suspensionSection.classList.add('d-none');

            switch (this.value) {
                case 'ajout':
                    ajoutSection.classList.remove('d-none');
                    break;
                case 'retrait':
                    retraitSection.classList.remove('d-none');
                    break;
                case 'suspension':
                    suspensionSection.classList.remove('d-none');
                    break;
            }
        });
    });

    // Envoi AJAX en JSON
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const selectedType = document.querySelector('input[name="actionType"]:checked');

        if (!selectedType) {
            alert("Veuillez sélectionner une opération.");
            return;
        }

        const data = {};

        // Ajouter les données de formulaire dans l'objet data
        formData.forEach((value, key) => {
            data[key] = value;
        });

        // Ajuster les champs en fonction de l'opération sélectionnée
        if (selectedType.value === 'ajout') {
            // Si l'opération est 'ajout', on n'a pas besoin de certains champs
            delete data['nbragent'];
            delete data['nbrconj'];
            delete data['nbrenf'];
        } else if (selectedType.value === 'retrait') {
            // Si l'opération est 'retrait', vérifier que les champs sont présents
            if (!data['nbragent']) data['nbragent'] = 0;
            if (!data['nbrconj']) data['nbrconj'] = 0;
            if (!data['nbrenf']) data['nbrenf'] = 0;
        }

        // Ajouter l'opération choisie
        data.type_operation = selectedType.value;

        fetch('http://localhost/crm-gga/app/codes/api/v1/majgestion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                alert(response.message);
                location.reload(); // ou redirection
            } else {
                alert(response.message);
            }
        })
        .catch(error => {
            console.error("Erreur AJAX :", error);
            alert("Une erreur s'est produite lors du traitement.");
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const ristourneCheckbox = document.getElementById('ristournePrime');
    const montantPrimeInput = document.getElementById('prime');
    const accessoiresInput = document.getElementById('accessoire');
    const montantTTC = document.getElementById('montantPrimettc');

    function updateMontantTTC() {
        const prime = parseFloat(montantPrimeInput.value) || 0;
        const accessoires = parseFloat(accessoiresInput.value) || 0;
        const total = prime + accessoires;

        montantTTC.value = total.toFixed(2) + ' $';
    }

    // Activer ou désactiver le champ montantPrime
    ristourneCheckbox.addEventListener('change', function () {
        montantPrimeInput.disabled = !this.checked;

        if (!this.checked) {
            montantPrimeInput.value = '';
        }

        updateMontantTTC();
    });

    // Mettre à jour le montant TTC lors de la saisie
    montantPrimeInput.addEventListener('input', updateMontantTTC);
    accessoiresInput.addEventListener('input', updateMontantTTC);
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>