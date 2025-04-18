<?php 
//session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/");
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
          
            <div class="container mt-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Production</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rapports</li>
            </ol>
        </nav>

        <div class="card shadow">
        <div class="card-body">
    <h5 class="card-title"><i class="bi bi-list"></i> Rapports de Production</h5>

    <!-- Sélection du type de rapport -->
    <div class="row" id="blockfixe">
        <div class="col-md-4 mb-3">
            <label for="rapportSelect" class="form-label">Sélectionner un rapport :</label>
            <select id="rapportSelect" class="form-select" style="font-size: 13px;">
                <option value="">-- Choisir un rapport --</option>
                <option value="global"> Rapport Global de Production</option>
                <option value="site_agent"> Rapport par Site & Agent</option>
                <option value="assureur"> Production par Assureur</option>
                <option value="comparatif"> Analyse Comparative</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="periode" class="form-label">Période :</label>
            <input type="month" id="periode" class="form-control">
        </div>
       
    <!-- Bouton Générer le Rapport à gauche -->
    <div class="col-md-2 mt-4">
        <button class="btn btn-danger" id="generateReport"><i class="bi bi-search"></i></button>
    </div>

    <!-- Boutons d'exportation à droite -->
    <div class="col-md-3 text-center p-2 mt-4" style="background-color:rgb(241, 242, 243);border-radius:10px">
        Exporter les données vers <i class="bi bi-arrow-right"></i>
        <button class="btn btn-success me-2" id="exportExcel" title="Exporter en Excel">
            <i class="bi bi-file-earmark-excel"></i>
        </button>
        <button class="btn btn-danger me-2" id="exportPDF" title="Exporter en PDF">
        <i class="bi bi-file-earmark-pdf"></i>
        </button>
        <button class="btn btn-primary" id="exportWord" title="Exporter en Word">
        <i class="bi bi-printer"></i>
            
        </button>
    </div>

    </div>

    <!-- Boutons d'exportation -->
    <div class="row mt-3" id="exportButtons">
        <div class="col-md-12 text-end">
            
        </div>
    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <!-- filtres site-agent -->
                            <div class="row d-none" id="filter-site-agent">
                              <!-- Site -->
                            <div class="col-md-6">
                                <label for="site" class="form-label">Site :</label>
                                <select id="site" class="form-select" style="font-size: 12px;">
                                    <option value="">Tous</option>
                                    <option value="kinshasa">Kinshasa</option>
                                    <option value="lubumbashi">Lubumbashi</option>
                                </select>
                            </div>
                            <!-- Agent -->
                            <div class="col-md-6">
                                <label for="agent" class="form-label">Agent :</label>
                                <select id="agent" class="form-select" style="font-size: 12px;">
                                    <option value="">Tous</option>
                                    <option value="agent1">Agent 1</option>
                                    <option value="agent2">Agent 2</option>
                                </select>
                            </div>
                            </div>
                        <!-- filtres assureur -->
                    <div class="row d-none" id="filter-assureur">
                        <div class="col-md-12">
                        <label for="assureur" class="form-label">Assureur :</label>
                        <select id="assureur" class="form-select" style="font-size: 12px;">
                        <option value="">Tous</option>
                        <option value="assureur1">Assureur A</option>
                        <option value="assureur2">Assureur B</option>
                        </select>
                        </div>
                    </div>
                    </div>

                    </div>
                    <div class="col-md-6">
                    <div class="row">
                    <div class="col-md-6">
                    <label for="debut">Période du :</label>
                    <input type="date" name="datedebut" id="datedebut" class="form-control" style="font-size: 12px;">
                    </div>
                    <div class="col-md-6">
                    <label for="debut">Au :</label>
                    <input type="date" name="datedebut" id="datedebut" class="form-control" style="font-size: 12px;">
                    </div>
                    </div>
                    </div>
                </div>
                <!-- Contenu dynamique des rapports -->
                <!-- Contenu dynamique des rapports -->
<div id="ContentreportGlobal" class="mt-4 d-none">
    <h4> Rapport Global de Production</h4>
    <table class="table table-bordered" id="tblrptglobal">
        <thead>
            <tr>
                <th>Période</th>
                <th>Production Totale</th>
                <th>Nombre de Transactions</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<div id="ContentreportSiteAgent" class="mt-4 d-none">
    <h4>Rapport par Site & Agent</h4>
    <table class="table table-bordered" id="tblrpt_site_agent">
        <thead>
            <tr>
                <th>Site</th>
                <th>Agent</th>
                <th>Production</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<div id="ContentreportAssureur" class="mt-4 d-none">
    <h4>Production par Assureur</h4>
    <table class="table table-bordered" id="tblrptassureur">
        <thead>
            <tr>
                <th>Assureur</th>
                <th>Nombre de Contrats</th>
                <th>Montant Total</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div id="Contentreportcomparatif" class="mt-4 d-none">
    <h4>Analyse Comparative</h4>
    <table class="table table-bordered" id="tblrptcomparatif">
        <thead>
            <tr>
                <th>Période</th>
                <th>Production (2024)</th>
                <th>Production (2025)</th>
                <th>Évolution</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

            </div>
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="script.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const rapportSelect = document.getElementById("rapportSelect");
    const filterSiteAgent = document.getElementById("filter-site-agent");
    const filterAssureur = document.getElementById("filter-assureur");
    const periodeBlock = document.getElementById("periode");

    const reports = {
        global: document.getElementById("ContentreportGlobal"),
        site_agent: document.getElementById("ContentreportSiteAgent"),
        assureur: document.getElementById("ContentreportAssureur"),
        comparatif: document.getElementById("Contentreportcomparatif"),
    };

    function resetVisibility() {
        filterSiteAgent.classList.add("d-none");
        filterAssureur.classList.add("d-none");
        periodeBlock.classList.remove("d-none");

        // Cacher tous les rapports
        Object.values(reports).forEach(report => report.classList.add("d-none"));
    }

    rapportSelect.addEventListener("change", function () {
        resetVisibility();
        const selectedValue = rapportSelect.value;

        switch (selectedValue) {
            case "global":
                reports.global.classList.remove("d-none");
                break;
            case "site_agent":
                filterSiteAgent.classList.remove("d-none");
                reports.site_agent.classList.remove("d-none");
                break;
            case "assureur":
                filterAssureur.classList.remove("d-none");
                reports.assureur.classList.remove("d-none");
                break;
            case "comparatif":
                periodeBlock.classList.add("d-none");
                reports.comparatif.classList.remove("d-none");
                break;
        }
    });

    // Initialisation pour cacher les filtres et rapports au chargement
    resetVisibility();
});


</script>



</body>
</html>