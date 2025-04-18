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
    <li class="breadcrumb-item"><a href="./">Parametre</a></li>
    <li class="breadcrumb-item active" aria-current="page">Partenaire</li>
  </ol>
</nav>
        <div class="card shadow">
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-left mb-3">
                  <!-- Boutons collés -->
            <div class="btn-group" role="group" aria-label="Exportation">
                <button class="btn btn-outline-success me-2" id="exportExcel">
                    <i class="bi bi-file-earmark-excel"></i> Exporter Excel
                </button>
                <button class="btn btn-outline-danger me-2" id="exportPDF">
                    <i class="bi bi-file-earmark-pdf"></i> Exporter PDF
                </button>
             
                <a href="./importation" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-excel"></i> Importer Excel
                </a>
            </div>

                    <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Rechercher un partenaire"
                    />
                </div>
            <div class="table-responsive">
            <table id="contratsTable" class="table table-bordered table-striped table-hover">
                <thead style="background-color: #923a4d;">
                   
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Denomination</th>
                        <th colspan="3">Pour l’entreprise</th>
                        <th rowspan="2">RCCM</th>
                        <th colspan="3">Responsable</th>
                        <th rowspan="2">Actions</th>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody></tbody>
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

    
    <!-- Modal Static Content -->

<!-- Modal creation Prestataire -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Modification  d'un Prestataire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="UserForm" class="p-3">
                            
                            <!-- Section 2 -->
                            <div class="row g-3 mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nom_prestataire" placeholder="Nom Prestataire" required>
                                        <label for="nom_prestataire">Nom Complet</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="adresse" placeholder="Adresse Prestataire" required>
                                        <label for="adresse">Adresse</label>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Section 3 -->
                            <div class="row g-3 mb-1">
                               
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contact" placeholder="contact Prestataire" required>
                                        <label for="contact">Contact</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="rib" placeholder="Releve Identite Bancaire" required>
                                        <label for="rib">RIB</label>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="row g-3 mb-1">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Adresse mail" required>
                                        <label for="email">E-mail</label>
                                        <input type="text" id="id_prestataire" hidden>
                                    </div>
                                </div>
                              
                            
                            </div>

                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="button" class="btn btn-success" id="" onclick="submitFormPresta()">Modifier <i class="fas fa-spinner spinner"></i></button>
                                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" onclick="clearFormUser()">
                                    <i class="bi bi-plus-circle"></i> Nouveau
                                </button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>


<!-- Fin Modal -->

<!-- Modal de consultation (lecture seule) -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="viewModalLabel">Détail du prestataire</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Nom :</strong> <span id="view_nom"></span></li>
          <li class="list-group-item"><strong>Adresse :</strong> <span id="view_adresse"></span></li>
          <li class="list-group-item"><strong>Contact :</strong> <span id="view_contact"></span></li>
          <li class="list-group-item"><strong>Email :</strong> <span id="view_email"></span></li>
          <li class="list-group-item"><strong>RIB :</strong> <span id="view_rib"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

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
        document.addEventListener('DOMContentLoaded', fetchPartners);

        function fetchPartners() {
            fetch('http://localhost:8080/crm-gga/app/codes/api/v1/api_partenaire.php/partenaires')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#contratsTable tbody');
                    tableBody.innerHTML = '';
                    let i = 1;
                    if (data.length > 0) {
                        data.forEach(parte => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${i}</td>
                                <td>${parte.denom_social}</td>
                                <td>${parte.adresse_assu}</td>
                                <td>${parte.emailEntre}</td>
                                <td>${parte.telephone_Entr}</td>
                                <td>${parte.Rccm}</td>
                                <td>${parte.nomRespo}</td>
                                <td>${parte.emailRespo}</td>
                                <td>${parte.TelephoneRespo}</td>
                               
                                <td style="display: none;">${parte.idpartenaire}</td>
                                <td>
                                  
                                    <button class="btn btn-sm btn-success me-2  btn-view">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary me-2 btn-edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                    
                                </td>
                            `;
                            tableBody.appendChild(row);
                            i++;
                        });

                        updatePagination();
                        
                        // clique de l'action
                        setTimeout(() => {
                            document.querySelectorAll('.btn-edit').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    const row = e.target.closest('tr');
                                    const cells = row.querySelectorAll('td');
                                    
                                    // Remplir le formulaire du modal
                                    document.getElementById('nom_prestataire').value = cells[1].textContent;
                                    document.getElementById('adresse').value = cells[2].textContent;
                                    document.getElementById('contact').value = cells[3].textContent;
                                    document.getElementById('email').value = cells[4].textContent;
                                    document.getElementById('rib').value = cells[5].textContent;
                                    document.getElementById('id_prestataire').value = cells[6].textContent;
                                       
                                    // Afficher le modal
                                    const modal = new bootstrap.Modal(document.getElementById('userModal'));
                                    modal.show();
                                });
                            });

                            document.querySelectorAll('.btn-view').forEach(button => {
                                button.addEventListener('click', (e) => {
                                    const row = e.target.closest('tr');
                                    const cells = row.querySelectorAll('td');

                                    document.getElementById('view_nom').textContent = cells[1].textContent;
                                    document.getElementById('view_adresse').textContent = cells[2].textContent;
                                    document.getElementById('view_contact').textContent = cells[3].textContent;
                                    document.getElementById('view_email').textContent = cells[4].textContent;
                                    document.getElementById('view_rib').textContent = cells[5].textContent;

                                    const modal = new bootstrap.Modal(document.getElementById('viewModal'));
                                    modal.show();
                                });
                            });


                        }, 100);

                        // suppression
                        document.querySelectorAll('.btn-delete').forEach(button => {
                            button.addEventListener('click', (e) => {
                                const row = e.target.closest('tr');
                                const cells = row.querySelectorAll('td');
                                const id = cells[6].textContent; // ID invisible stocké dans la 7e cellule

                                if (confirm("⚠️ Voulez-vous vraiment supprimer ce prestataire ?")) {
                                    fetch(`http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/ChangeEtat/${id}`, {
                                        method: 'PUT'
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.status === 200) {
                                            alert("Prestataire supprimé avec succès !");
                                            fetchPartners(); // recharge la table
                                        } else {
                                            alert("Erreur : " + (data.message || 'Impossible de supprimer.'));
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Erreur réseau :", error);
                                        alert("Erreur réseau ou serveur.");
                                    });
                                }
                            });
                        });






                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = '<td colspan="7" style="text-align:center;">Aucune information trouvée</td>';
                        tableBody.appendChild(row);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des prestataires :', error));
        }

      // clique bouton modifier
    function submitFormPresta(){
    
    // Récupération des champs du formulaire
    const id = document.getElementById('id_prestataire').value;
    const nom_prestataire = document.getElementById('nom_prestataire').value;
    const adresse = document.getElementById('adresse').value;
    const contact = document.getElementById('contact').value;
    const email = document.getElementById('email').value;
    const rib = document.getElementById('rib').value;

    // Construction de l'objet à envoyer
    const formData = {
        id_prestataire,
        nom_prestataire,
        adresse,
        contact,
        email,
        rib
    };

    // Envoi de la requête PUT vers l'API
    fetch(`http://localhost:8080/crm-gga/app/codes/api/v1/api_admin.php/updatePresta/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 200 || data.success) {
            alert("✅ Prestataire mis à jour avec succès !");
            // Recharger les données dans le tableau
            fetchPartners();
            // Fermer le modal
            bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
        } else {
            alert("❌ Erreur : " + (data.message || 'Mise à jour échouée.'));
           
        }
    })
    .catch(error => {
        console.error("Erreur lors de la requête :", error);
        alert("Erreur réseau ou serveur.");
    });
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
    
// Exporter vers Excel
    document.getElementById('exportExcel').addEventListener('click', () => {
        const wb = XLSX.utils.book_new();
        const table = document.getElementById('contratsTable');
        const ws = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(wb, ws, 'Prestataires');
        XLSX.writeFile(wb, 'prestataires.xlsx');
   });

   

// Exporter vers PDF
     document.getElementById('exportPDF').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
            html: '#contratsTable',
            startY: 10,
            styles: {
                fontSize: 10
            },
            headStyles: {
                fillColor: [146, 58, 77] // même couleur que ton <thead>
            }
        });

        doc.save('prestataires.pdf');
     });

    </script>
    <script>
        // clique de l'action
        
    </script>







</body>
</html>