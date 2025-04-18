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
        button:hover {
    background-color: #7a2e3e !important; /* Légèrement plus foncé */
    transform: scale(1.05); /* Effet zoom léger */
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
                    <li class="breadcrumb-item active" aria-current="page">Gestion des contrats</li>
                </ol>
            </nav>
            <div class="card shadow" style="background-color: #f4f4f9;">
    <div class="card-body">
        <h5 class="card-title">Incorporation / Radiation</h5>
        <form id="gestionContratForm">
        <div class="row">
            <!-- Numéro Police -->
            <div class="col-md-2 mb-2">
                <label for="numeroPolice" class="form-label fw-bold">Numéro Police</label>
                <input type="text" id="numeroPolice" class="form-control" disabled>
            </div>
            
            <div class="col-md-4 mb-2">
                <label for="numeroPolice" class="form-label fw-bold">Client</label>
                <input type="text" id="numeroPolice" class="form-control" disabled>
            </div>

            <!-- Choix Incorporation / Radiation -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Action</label>
                <div class="d-flex">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="radio" name="actionType" id="ajoutBenef" value="ajout">
                        <label class="form-check-label" for="ajoutBenef">Ajout Bénéficiaires</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="actionType" id="retraitBenef" value="retrait">
                        <label class="form-check-label" for="retraitBenef">Retrait Bénéficiaires</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- infos contrat -->
            <div class="mb-3">
            <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered table-striped table-hover">
                <thead style="background-color: #ccc;">
                    <tr>
                       
                        <th>Création</th>
                        <th>Numéro de Police</th>
                        <th>Type de Contrat</th>
                        
                        <th>Couverture</th>
                        <th>Bénéficiaires</th>
                        <th>Prime/Budget</th>
                        <th>Gestionnaire</th>
                        <th>Statut</th>
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            
        </div>
            </div>
        </div>

            <!-- Section Ajout Bénéficiaires -->
            <div id="ajoutSection" class="d-none">
                <h6>Ajout de Bénéficiaires</h6>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nombre Agents</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Conjoints</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Enfants</label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Date Incorporation</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Prime Nette</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Accessoires</label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <div class="mt-2">
                    <label class="form-label">Prime TTC</label>
                    <input type="number" class="form-control">
                </div>
            </div>

            <!-- Section Retrait Bénéficiaires -->
            <div id="retraitSection" class="d-none">
                <h6>Retrait de Bénéficiaires</h6>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Nombre Agents</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Conjoints</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Enfants</label>
                        <input type="number" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
    <!-- Date de Radiation -->
    <div class="col-md-4">
        <label class="form-label fw-bold">Date Radiation</label>
        <input type="date" class="form-control">
    </div>

    <!-- Ristourne Prime -->
    <div class="col-md-4 d-flex align-items-center">
        <input class="form-check-input me-2" type="checkbox" id="ristournePrime">
        <label class="form-check-label" for="ristournePrime">Ristourne Prime</label>
    </div>

    <!-- Montant Prime -->
    <div class="col-md-4">
        <label class="form-label fw-bold">Montant Prime</label>
        <input type="number" id="montantPrime" class="form-control" disabled>
    </div>
</div>

            </div>

            <!-- Suspension / Résiliation -->
            <hr>
            <h5>Suspension / Résiliation</h5>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="suspensionCheck">
                    <label class="form-check-label" for="suspensionCheck">Suspension</label>
                </div>
                <div id="suspensionSection" class="d-none row mt-2">
    <!-- Date Suspension -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Date Suspension</label>
        <input type="date" class="form-control mb-2">
    </div>

    <!-- Date Reprise -->
    <div class="col-md-6">
        <label class="form-label fw-bold">Date Reprise</label>
        <input type="date" class="form-control">
    </div>
</div>

            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="resiliationCheck">
                    <label class="form-check-label" for="resiliationCheck">Résiliation</label>
                </div>
                <div id="resiliationSection" class="d-none mt-2">
                    <div class="col-md-4">
                    <label class="form-label">Date Résiliation</label>
                    <input type="date" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
    <button type="submit" class="btn text-light mt-3 px-4 py-2 shadow" style="background-color: #923a4d; font-size: 1.1rem; transition: 0.3s;">
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

    ajoutRadio.addEventListener('change', () => {
        ajoutSection.classList.remove('d-none');
        retraitSection.classList.add('d-none');
    });

    retraitRadio.addEventListener('change', () => {
        retraitSection.classList.remove('d-none');
        ajoutSection.classList.add('d-none');
    });

    ristournePrime.addEventListener('change', () => {
        montantPrime.disabled = !ristournePrime.checked;
    });

    suspensionCheck.addEventListener('change', () => {
        suspensionSection.classList.toggle('d-none', !suspensionCheck.checked);
    });

    resiliationCheck.addEventListener('change', () => {
        resiliationSection.classList.toggle('d-none', !resiliationCheck.checked);
    });
});
</script>
</body>
</html>