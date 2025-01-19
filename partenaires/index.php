
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
        table{
            font-size: 12px;
        }
        .user-info {
    display: flex;
    flex-direction: column; /* Organise les éléments en colonne */
    align-items: center; /* Aligne le texte à gauche */
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
          
    <div class="card shadow">
        <div class="card-body">
        
            <div class="row g-3">
                <!-- Bouton d'ajout -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="./creation" class="btn btn-danger">
                        <i class="bi bi-plus-circle"></i> Créer
                    </a>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Rechercher un partenaire (Numéro, Nom, Type, Date)"
                    />
                </div>
                <h5 class="mb-4">Partenaires</h5>
                <!-- Tableau liste classeurs contrats -->
                <div class="table-responsive">
              


                    <table id="partnersTable" class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>DENOMINATION SOCIALE </th>
                                <th>E-mail</th>
                                <th>TELEPHONE</th>
                                <th>RESPONSABLE</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- Ajoutez d'autres lignes ici -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center" id="pagination">
                        <!-- Pagination dynamique -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    
<script>
        document.addEventListener('DOMContentLoaded', fetchPartners);

        function fetchPartners() {
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#partnersTable tbody');
                    tableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(partner => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${partner.idpartenaire}</td>
                                <td>${partner.denom_social}</td>
                                <td>${partner.emailEntre}</td>
                                <td>${partner.telephone_Entr}</td>
                                <td>${partner.nomRespo}</td>
                              
                                <td>
                                    <button class="btn btn-sm btn-success me-2">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary me-2">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });

                        updatePagination();
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucun partenaire trouvé</td>';
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des partenaires :', error));
        }


    // Recherche dynamique
    document.getElementById("searchInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#partnersTable tbody tr");
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
           
        });
      
    });

 
  



    // pagination GPT
 // Fonction de mise à jour de la pagination
function updatePagination() {
    const table = document.getElementById("partnersTable");
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
    
    </script>
    <script>
    
</script>
</body>
</html>