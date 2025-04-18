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
    <title>Contrat-Gestion</title>
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
            <div class="card shadow">
            <div class="card-body">
            <h3>Gestion des contrats</h3>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="./" class="btn btn-danger">
                    <i class="bi bi-arrow-left-circle"></i> Retour
                </a>
                <div class="d-flex align-items-center" style="width: 25%;">
                    <label for="searchInput" class="me-2">Recherche contrat :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Tapez ici..."/>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered table-striped table-hover">
                <thead style="background-color: #923a4d;">
                    <tr>
                        <th>#</th>
                        <th>Création</th>
                        <th>Numéro de Police</th>
                        <th>Type de Contrat</th>
                        <th>Client/Assuré</th>
                        <th>Couverture</th>
                        <th>Bénéficiaires</th>
                        <th>Prime/Budget</th>
                        <th>Gestionnaire</th>
                        <th>Statut</th>
                        <th>Ops</th>
                        
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            
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
    <script>
document.addEventListener("DOMContentLoaded", function() {
    fetchContrats();
});

function fetchContrats() {
    fetch('http://localhost/crm-gga/app/codes/api/v1/getcontrats.php')
        .then(response => response.json())
        .then(response => {
            if (response.status === "success") {
                let tbody = document.querySelector("#contratsTable tbody");
                tbody.innerHTML = "";

                response.data.forEach((contrat, index) => {
                    let row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${contrat.datecreate}</td>
                            <td>${contrat.numero_police}</td>
                            <td>${contrat.libtype}</td>
                            <td>${contrat.den_social} (${contrat.ville_entr}, ${contrat.pays_entr})</td>
                            <td>${contrat.couverture}</td>
                            <td>${contrat.effectif_Benef}</td>
                            <td>${contrat.val_frais_gest}</td>
                            <td>${contrat.nomagent} ${contrat.postnomagent}</td>
                            <td>${getStatutLibelle(contrat.etat_contrat)}</td>
                            <td>
                              <a href="./edit_contrat?np=${contrat.numero_police}" class="btn btn-primary btn-sm" title="Gérer">
        <i class="bi bi-gear"></i>
    </a>
    <a href="" class="btn btn-info btn-sm view-btn" data-id="${contrat.numero_police}" title="Visualiser">
        <i class="bi bi-eye"></i>
    </a>

                            </td>
                        </tr>
                    `;
                    
                    tbody.innerHTML += row;
                });
                updatePagination();
            } else {
                const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucun partenaire trouvé</td>';
                        tableBody.appendChild(row);
            }
        })
        .catch(error => console.error('Erreur lors du chargement des contrats:', error));
}
// Fonction pour afficher le statut sous forme de badge coloré
function getStatutLibelle(etat) {
        switch (etat) {
        case 1:
            return '<span class="text-warning">En attente</span>';
        case 2:
            return '<span class="text-success">En Cours</span>';
        case 3:
            return '<span class="text-secondary text-dark">En suspension</span>';
        case 4:
                return '<span class="text-danger text-dark">En résiliation</span>';
        default:
            return '<span class="badge bg-secondary">Statut inconnu</span>';
    }
}
// Recherche dynamique
document.getElementById("searchInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#contratsTable tbody tr");
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // pagination GPT
 // Fonction de mise à jour de la pagination
function updatePagination() {
    const table = document.getElementById("contratsTable");
    const rowsPerPage = 5;
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const pagination = document.getElementById("pagination");
    function renderTable(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) ? "" : "none";
        });
    }
    function renderPagination() {
        const pageCount = Math.ceil(rows.length / rowsPerPage);
        pagination.innerHTML = "";
        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement("li");
            li.className = "page-item";
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener("click", (e) => {
                e.preventDefault();
                renderTable(i);
                document.querySelectorAll(".page-item").forEach((item) => item.classList.remove("active"));
                li.classList.add("active");
            });
            pagination.appendChild(li);
        }
        if (pagination.firstChild) {
            pagination.firstChild.classList.add("active");
        }
        renderTable(1); // Afficher la première page par défaut
    }
    renderPagination();
}
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', function () {
        let contratId = this.getAttribute('data-id');
        window.location.href = `./edit/?id=${contratId}`;
    });
});


</script>

</body>
</html>