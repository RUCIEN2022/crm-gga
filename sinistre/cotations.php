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
    <title>Cotation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
            font-size: 12px;
        }



.text-orange {
    color:rgb(240, 235, 235); 
}

.bg-orange {
    background-color: #d71828; 
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
    flex-direction: column; 
    align-items: center; 
}
        .user-name {
    font-weight: bold;
    margin-bottom: 5px; 
}
        .time {
    font-size: 1.5em;
    color: gray; 
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
<div id="loader" class="loader" style="display: none;">
    <img src="loader.gif" alt="Chargement..." />
</div>
    <div class="wrapper">
       
        <?php include_once('navbar.php'); ?>
        <div id="content">
            <?php include_once('topbar.php'); ?>
            <div class="container mt-2">

            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">Production</a></li>
    <li class="breadcrumb-item active" aria-current="page">Cotations contrat</li>
  </ol>
</nav>
        <div class="card shadow">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
               
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cotationModal">
    <i class="bi bi-plus-circle"></i> Demande de Cotation
</button>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Recherche"
                    />
                </div>
            <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered table-striped table-hover">
                <thead style="background-color: #923a4d;">
                    <tr>
                        <th>#</th>
                        <th>Date cotation</th>
                        <th>Type contrat</th>
                        <th>Client / Demandeur</th>
                        <th>Total_bénéficiaires</th>
                        <th>Budget</th>
                        <th>Couverture</th>
                        <th>Actions</th>
                       
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            
        </div>
            </div>
        </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="cotationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cotationModalLabel">Demande de Cotation - Contrat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="cotationForm" class="">
                
                <h6 class="fw-bold text-dark">Informations du Client</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomClient" class="form-label">Nom du demandeur</label>
                        <input type="text" class="form-control" id="nomClient" name="nomClient" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="societeClient" class="form-label">Société</label>
                        <input type="text" class="form-control" id="societeClient" name="societeClient">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="emailClient" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailClient" name="emailClient" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telClient" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telClient" name="telClient" required>
                    </div>
                </div>

                
                <h6 class="fw-bold text-dark mt-3">Détails du Contrat</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="typeContrat" class="form-label">Type de Contrat</label>
                        <select class="form-select" id="typeContrat" name="typeContrat" required>
                            <option value="">Sélectionnez...</option>
                           
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="dateDebut" class="form-label">Date de Début</label>
                        <input type="date" class="form-control" id="dateDebut" name="dateDebut" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="dateFin" class="form-label">Date de Fin</label>
                        <input type="date" class="form-control" id="dateFin" name="dateFin" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nbBeneficiaires" class="form-label">Nombre de Bénéficiaires</label>
                        <input type="number" class="form-control" id="nbBeneficiaires" name="nbBeneficiaires" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="budgetEstime" class="form-label">Budget Estimé (USD)</label>
                        <input type="number" class="form-control" id="budgetEstime" name="budgetEstime" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="couverture" class="form-label">Couverture</label>
                        <select class="form-select" id="frequencePaiement" name="frequencePaiement" required>
                            <option value="Mensuel">--choisir--</option>
                            
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="frequencePaiement" class="form-label">Fréquence de Paiement</label>
                        <select class="form-select" id="frequencePaiement" name="frequencePaiement" required>
                            <option value="">---</option>
                           
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="modePaiement" class="form-label">Mode de Paiement</label>
                        <select class="form-select" id="modePaiement" name="modePaiement" required>
                        <option value="">---</option>
                        </select>
                    </div>
                </div>

             
                <h6 class="fw-bold text-dark mt-3">Informations Supplémentaires</h6>
                <div class="mb-3">
                    <label for="conditionsSpecifiques" class="form-label">Conditions Spécifiques</label>
                    <textarea class="form-control" id="conditionsSpecifiques" name="conditionsSpecifiques" rows="3"></textarea>
                </div>
               
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">Annuler</button>
                    <button type="submit" class="btn btn-danger">Sauvegarder</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="script.js"></script>
    <script>
document.getElementById("cotationForm").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("Votre demande de cotation a été envoyée avec succès !");
});
</script>



</body>
</html>