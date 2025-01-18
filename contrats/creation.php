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
                    <input type="text" class="form-control" id="rccm">
                </div>
                <div class="col-md-3">
                    <label for="denomination" class="form-label">Dénomination sociale</label>
                    <input type="text" class="form-control" id="denomination">
                </div>
                <div class="col-md-3">
                    <label for="idNat" class="form-label">Id. Nat</label>
                    <input type="text" class="form-control" id="idNat">
                </div>
                <div class="col-md-3">
                    <label for="numeroImpot" class="form-label">Numéro Impôt</label>
                    <input type="text" class="form-control" id="numeroImpot">
                </div>
                <div class="col-md-3">
                    <label for="codeInterne" class="form-label">Code interne</label>
                    <input type="text" class="form-control" id="codeInterne">
                </div>
                <div class="col-md-3">
                    <label for="pays" class="form-label">Pays</label>
                    <select name="pays" id="pays" class="form-select">
                            <option value="">--choisir--</option>
                        </select>
                </div>
                <div class="col-md-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" name="ville" id="ville" class="form-control" id="denomination">
                </div>
                <div class="col-md-3">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse">
                </div>
                
                
                <div class="col-md-3">
                    <label for="emailEntreprise" class="form-label">Email entreprise</label>
                    <input type="email" class="form-control" id="emailEntreprise">
                </div>
                <div class="col-md-3">
                    <label for="telephoneEntreprise" class="form-label">Téléphone</label>
                    <input type="text" class="form-control" id="telephoneEntreprise">
                </div>
                <div class="col-md-3">
                    <label for="telephoneEntreprise" class="form-label">Nom du responsable</label>
                    <input type="text" class="form-control" id="responsable">
                </div>
                <div class="col-md-3">
                    <label for="telephoneresponsable" class="form-label">Téléphone responsable</label>
                    <input type="text" class="form-control" id="telephonerespons" placeholder="">
                </div>
                <div class="col-md-3">
                    <label for="emailresponsable" class="form-label">Email responsable</label>
                    <input type="email" class="form-control" id="email responsable">
                </div>
                <div class="col-md-3">
                    <label for="site" class="form-label">Site</label>
                    <select name="site" id="site" class="form-select">
                        <option value="0">--Choisir site--</option>
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
                    <select name="" id="" class="form-select">
                        <option value="0">--Choisir--</option>
                    </select>
                    </div>
                    <div class="col-md-4">
                        <label for="assureur" class="form-label">Assureur</label>
                        <select name="assureur" id="assureur" class="form-select">
                            <option value="">--choisir--</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="reassureur" class="form-label">Réassureur</label>
                        <select name="assureur" id="assureur" class="form-select">
                            <option value="">--choisir--</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="dateEffet" class="form-label">Date d'effet</label>
                        <input type="date" class="form-control" id="dateEffet">
                    </div>
                    <div class="col-md-4">
                        <label for="dateEcheance" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" id="dateEcheance">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="primeNette" class="form-label">Prime Nette</label>
                        <input type="text" class="form-control" id="primeNette">
                    </div>
                    <div class="col-md-4">
                        <label for="accessoires" class="form-label">Accessoires</label>
                        <input type="text" class="form-control" id="accessoires">
                    </div>
                    <div class="col-md-4">
                        <label for="primeTtc" class="form-label">Prime TTC</label>
                        <input type="text" class="form-control" id="primeTtc">
                    </div>
                    <div class="col-md-4">
                        <label for="intermediaire" class="form-label">Intermédiaire</label>
                        <input type="text" class="form-control" id="intermediaire">
                    </div>
                    
                    
                </div>
            </div>

            <!-- Section 3 -->
            <div class="form-section">
                <div class="row g-3">
                    
                    <div class="col-md-4">
                        <label for="quoteReassureur" class="form-label">Quote-part réassureur</label>
                        <input type="text" class="form-control" id="quoteReassureur">
                    </div>
                    <div class="col-md-4">
                        <label for="quoteAssureur" class="form-label">Quote-part assureur</label>
                        <input type="text" class="form-control" id="quoteAssureur">
                    </div>
                    <div class="col-md-4">
                        <label for="modaliteFacturation" class="form-label">Modalité Facturation</label>
                        <input type="text" class="form-control" id="modaliteFacturation">
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


    </script>
</body>
</html>