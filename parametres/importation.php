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
include('./app/codes/controls/importer_excel.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parametres Partenaire</title>
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
th {
    text-align: center;
    vertical-align: middle;
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
    <li class="breadcrumb-item"><a href="./partenaires">Partenaires</a></li>
    <li class="breadcrumb-item active" aria-current="page">importation fichier excel</li>
  </ol>
</nav>
        <div class="card shadow">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-left mb-3">
                  <!-- Boutons collés -->
           

                </div>
                 
               
                <!-- Corps -->
                <h3>Importation ou Exportation de fichier Excel</h3>
                    <hr>
                    <div class="col-md-6">
                        <a href="exporter_modele.php" class="btn btn-success">Télécharger Modèle Excel</a>

                        <form action="" method="post" enctype="multipart/form-data" class="mt-4">
                            <label for="fichier">Importer Excel :</label>
                            <input type="file" name="fichier" id="fichier" class="form-control" accept=".xlsx" required>
                            <button type="submit" class="btn btn-primary mt-2" name="Envoyer">Importer les données</button>
                        </form>
                         <!-- Message d'erreur ou succès ici -->
                            <!-- Affichage clair des messages -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-<?= $type_message ?> alert-dismissible fade show mt-3" role="alert">
                                <?= htmlspecialchars($message); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                            </div>
                        <?php endif; ?>
                    </div>
                   

               <!-- Fin Corps -->

            </div>
        </div>
            </div>
        </div>
    </div>

    
    <!-- Modal Static Content -->



<!-- Fin Modal -->

<!-- Fin Modal de consultation -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="script.js"></script>

    <!-- Ajoute les bibliothèques nécessaires-->
    <!-- XLSX pour Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- jsPDF + autoTable pour PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <!-- fin -->
   
    <script>
        // clique de l'action
        
    </script>







</body>
</html>