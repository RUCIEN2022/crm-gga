<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
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
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('navbar.php'); ?>
        <!-- Page Content -->
        <div id="content">
            <!-- Header -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <h2>Clients</h2>
                        <div class="user-info">
                            <span class="user-name">Bonjour, John Masini</span>
                            <span class="time" id="currentTime"></span>
                        </div>
                        <div class="position-relative animate-notification">
                            <a href="">
                           <span class="badged rounded p-2 bg-danger">
                           <i class="bi bi-folder text-orange" style="font-size: 1.5rem;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange text-white" style="font-size: 0.75rem;">
                                5
                            </span>
                           </span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
          
            <!-- Cards -->
            <div class="container mt-2">
            <h5 class=" mb-4">Clients/Création</h5>
        <div class="card shadow">
            <div class="card-body">
            <form>
            <!-- Section 1 -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="denomination" class="form-label">Dénomination sociale</label>
                    <input type="text" class="form-control" id="denomination">
                </div>
                <div class="col-md-4">
                    <label for="pays" class="form-label">Pays</label>
                    <select name="pays" id="pays" class="form-select">
                            <option value="">--choisir--</option>
                        </select>
                </div>
                <div class="col-md-4">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control" id="ville">
                </div>
                <div class="col-md-4">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse">
                </div>
                <div class="col-md-4">
                    <label for="codeInterne" class="form-label">Code interne</label>
                    <input type="text" class="form-control" id="codeInterne">
                </div>
                <div class="col-md-4">
                    <label for="idNat" class="form-label">Id. Nat</label>
                    <input type="text" class="form-control" id="idNat">
                </div>
                <div class="col-md-4">
                    <label for="rccm" class="form-label">RCCM</label>
                    <input type="text" class="form-control" id="rccm">
                </div>
                <div class="col-md-4">
                    <label for="numeroImpot" class="form-label">Numéro Impôt</label>
                    <input type="text" class="form-control" id="numeroImpot">
                </div>
                <div class="col-md-4">
                    <label for="emailEntreprise" class="form-label">Email entreprise</label>
                    <input type="email" class="form-control" id="emailEntreprise">
                </div>
                <div class="col-md-4">
                    <label for="telephoneEntreprise" class="form-label">Téléphone entreprise</label>
                    <input type="text" class="form-control" id="telephoneEntreprise">
                </div>
            </div>

            <!-- Section 2 -->
            <div class="form-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="assureur" class="form-label">Assureur</label>
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
                        <label for="numeroPolice" class="form-label">Numéro Police</label>
                        <input type="text" class="form-control" id="numeroPolice">
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
                    <div class="col-md-4">
                        <label for="reassureur" class="form-label">Réassureur</label>
                        <select name="assureur" id="assureur" class="form-select">
                            <option value="">--choisir--</option>
                        </select>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
</html>