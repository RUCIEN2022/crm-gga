<?php 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/");
    exit();
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="style.css">
    <style>
        body{
            background-color: #f4f4f9;
            font-size: 12px;
        }
 
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

.animate-notification {
    animation: pulse 1.5s infinite;
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
                <a href="./" class="btn text-light fw-bold" style="background-color:#3498db">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
                <div class="d-flex align-items-center" style="width: 35%;">
                    <label for="searchInput" class="me-2">Recherche contrat :</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Tapez ici..."/>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered table-striped table-hover" style="font-size: 11px;">
                <thead style="background-color: #923a4d;">
                    <tr>
                        <th>#</th>
                        <th>Date création</th>
                        <th>Numéro de Police</th>
                        <th>Type de Police</th>
                        <th>Client/Assuré</th>
                        <th>Bénéficiaires</th>
                        
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
                            <td>${formatDate(contrat.datecreate)}</td>
                            <td>${contrat.numero_police}</td>
                            <td>${contrat.libtype}</td>
                            <td>${contrat.den_social} (${contrat.ville_entr}, ${contrat.pays_entr})</td>
                            
                            <td class="text-end">${contrat.effectif_Benef}</td>
                           
                            <td>${contrat.nomagent} ${contrat.postnomagent}</td>
                            <td>${getStatutLibelle(contrat.etat_contrat)}</td>
                            <td>
                                <button style="background-color:#3498db" class="btn text-light btn-sm manage-btn" 
                                        data-id="${contrat.numero_police}" 
                                        title="Gérer">
                                    Gérer <i class="bi bi-gear"></i>
                                </button>
                               <button style="background-color:#3498db" class="btn text-light btn-sm view-btn" 
                                        data-id="${contrat.numero_police}" 
                                        title="Ouvrir classeur">
                                    <i class="fas fa-folder-open"></i>
                                </button>

                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                attachEventListeners(); // Attacher les événements après le rendu
                updatePagination();
            } else {
                let tbody = document.querySelector("#contratsTable tbody");
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center;">Aucun contrat trouvé</td></tr>';
            }
        })
        .catch(error => console.error('Erreur lors du chargement des contrats:', error));
}

function attachEventListeners() {
    document.querySelectorAll(".manage-btn").forEach(button => {
        button.addEventListener("click", function () {
            let numeroPolice = this.getAttribute("data-id");
            console.log("Numéro police sélectionné :", numeroPolice);
            window.location.href = `./editcontrat?np=${encodeURIComponent(numeroPolice)}`;
        });
    });
}

function getStatutLibelle(etat) {
        switch (etat) {
        case 1:
            return '<span class="text-danger fw-bold">En attente...</span>';
        case 2:
            return '<span class="text-success">En Cours</span>';
        case 3:
            return '<span class="text-secondary text-dark">En suspension</span>';
        case 4:
                return '<span class="text-danger text-dark">En résiliation</span>';
        default:
            return '<span class="badge bg-secondary">Création...</span>';
    }
}
// script_Recherche_dynamique
document.getElementById("searchInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#contratsTable tbody tr");
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

   
 //fx_pagination
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
        renderTable(1); // Affiche la première page par défaut
    }
    renderPagination();
}
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', function () {
        let contratId = this.getAttribute('data-id');
        window.location.href = `./edit/?id=${contratId}`;
    });
});

// Fonction pour formater une date en "jj/mm/aaaa à hh:mm"
function formatDate(dateString) {
    if (!dateString) return ''; // Gérer les valeurs nulles ou vides

    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    })
}

</script>

</body>
</html>