<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Assurance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        table{
            font-size: 12px;
        }
        .actions-menu .nav-pills .nav-link {
    color: #333;
    background-color: #f4f4f9;
    border: 1px solid #dee2e6;
    margin-right: 5px;
    border-radius: 5px;
    transition: 0.3s ease;
}

.actions-menu .nav-pills .nav-link.active {
    color: #fff;
    background-color:rgb(183, 8, 16);
}

.actions-menu .nav-pills .nav-link:hover {
    background-color: #e9ecef;
    color: #007bff;
}
/* Kanban Board */
.kanban-board {
    display: flex;
    gap: 1rem;
}

.kanban-column {
    width: 18%;
    border: 2px dotted #ccc;
    border-radius: 8px;
    background-color: #fff;
    overflow: hidden;
}

.kanban-header {
    padding: 10px;
    color: #fff;
    text-align: center;
    font-weight: 700;
    position: relative;
    clip-path: polygon(0 0, 100% 0, 90% 100%, 10% 100%);
}

.kanban-content {
    padding: 15px;
    background-color: #f9f9f9;
    min-height: 150px;
}

/* Kanban Card */
.kanban-card {
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
}

.kanban-card img {
    width: 24px;
    height: 24px;
}

/* Gradient Colors */
.gradient-red {
    background: linear-gradient(135deg, #e63946, #ff6f61);
}

.gradient-green {
    background: linear-gradient(135deg, #2a9d8f, #26d07c);
}

.gradient-blue {
    background: linear-gradient(135deg, #457b9d, #1d3557);
}

.gradient-purple {
    background: linear-gradient(135deg, #6a4c93, #b47eff);
}

.gradient-gray {
    background: linear-gradient(135deg, #adb5bd, #6c757d);
}
form {
    max-width: auto;
    margin: auto;
}

label i {
    color: #0d6efd;
}

input, textarea, select {
    border-radius: 0.5rem;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

button {
    font-weight: bold;
    font-size: 1rem;
}

button:hover {
    background-color: #0056b3;
    color: #fff;
}
.mention-input {
    position: relative;
}

.mention-suggestions {
    z-index: 1050;
    max-height: 200px;
    overflow-y: auto;
    width: 100%;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
}

.mention-suggestions li {
    padding: 0.5rem;
    cursor: pointer;
}

.mention-suggestions li:hover {
    background-color: #f8f9fa;
}
.contractsTable {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }
#theadlist {
            background-color:rgb(172, 50, 50);
            color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
.table-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .tabsuivi {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        .theadsuivi {
            background-color:rgb(172, 50, 50);
            color: #fff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tbodysuivi tr:hover {
            background-color: #f1f1f1;
        }

        .action-icons {
            display: flex;
            gap: 10px;
        }

        .action-icons i {
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }

        .action-icons i:hover {
            color: #4CAF50;
        }

/* Popup Styling */
.popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: flex-end;
            align-items: center;
            z-index: 1000;
        }

        .popup-overlay.active {
            display: flex;
        }

        .popup {
            width: 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transform: translateX(100%);
            animation: slideIn 0.4s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .popup-header {
            background-color:rgb(209, 152, 189);
            color: #fff;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .popup-header h2 {
            margin: 0;
            font-size: 18px;
        }

        .popup-header .close {
            font-size: 20px;
            cursor: pointer;
            color: #fff;
        }

        .popup-header .close:hover {
            color: #f44336;
        }

        .popup-content {
            padding: 20px;
            font-size: 16px;
            color: #333;
        }

        .popup-content table {
            width: 100%;
            border-collapse: collapse;
        }

        .popup-content th,
        .popup-content td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .popup-content th {
            background-color: #f4f4f4;
            color: #333;
        }

        .popup-content td {
            color: #555;
        }

        .popup-content tr:last-child td {
            border-bottom: none;
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
                        <h2>Tâches</h2>
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

<!-- Menu des actions des tâches -->
<div class="actions-menu mb-3">
    <ul class="nav nav-tabs" id="taskTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="deadlines-tab" data-bs-toggle="tab" data-bs-target="#deadlines" type="button" role="tab" aria-controls="deadlines" aria-selected="true">
                <i class="bi bi-calendar-event"></i> Deadlines
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="list-tasks-tab" data-bs-toggle="tab" data-bs-target="#list-tasks" type="button" role="tab" aria-controls="list-tasks" aria-selected="false">
                <i class="bi bi-card-list"></i> Liste des tâches
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="create-task-tab" data-bs-toggle="tab" data-bs-target="#create-task" type="button" role="tab" aria-controls="create-task" aria-selected="false">
                <i class="bi bi-plus-circle"></i> Créer une tâche
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="follow-up-tab" data-bs-toggle="tab" data-bs-target="#follow-up" type="button" role="tab" aria-controls="follow-up" aria-selected="false">
                <i class="bi bi-arrow-repeat"></i> Suivi
            </button>
        </li>
    </ul>
</div>

<!-- Contenu des onglets -->
<div class="tab-content" id="taskTabsContent">
    <!-- Tab: Deadlines -->
    <div class="tab-pane fade show active" id="deadlines" role="tabpanel" aria-labelledby="deadlines-tab">
        <div class="card shadow">
            <div class="card-body">
                <h5>Deadlines des Tâches</h5>
                <hr>
                <div class="kanban-board d-flex p-4 gap-3">
                    <!-- Column: Retard -->
                    <div class="kanban-column">
                        <div class="kanban-header gradient-red">
                            <h6>Retard (2)</h6>
                        </div>
                        <div class="kanban-content">
                            <div class="kanban-card">
                                <h6 class="mb-1">Implémentation DB</h6>
                                <small class="text-danger">-3 semaines</small>
                                <div class="d-flex align-items-center mt-2">
                                    <span><i class="bi bi-person-circle"></i> <small>Rucien Kindukulu</small></span>
                                </div>
                            </div>
                            <div class="kanban-card">
                                <h6 class="mb-1">Développement frontend</h6>
                                <small class="text-danger">-2 semaines</small>
                                <div class="d-flex align-items-center mt-2">
                                    <span><i class="bi bi-person-circle"></i> <small>Adonai Mbula</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column: À terminer aujourd'hui -->
                <div class="kanban-column">
                    <div class="kanban-header gradient-green">
                        <h6>À terminer aujourd'hui (0)</h6>
                    </div>
                    <div class="kanban-content">
                        <div class="text-center mt-4">+</div>
                    </div>
                </div>
            
                <!-- Column: À terminer cette semaine -->
                <div class="kanban-column">
                    <div class="kanban-header gradient-blue">
                        <h6>À terminer cette semaine (0)</h6>
                    </div>
                    <div class="kanban-content">
                        <div class="text-center mt-4">+</div>
                    </div>
                </div>
            
                <!-- Column: À terminer la semaine prochaine -->
                <div class="kanban-column">
                    <div class="kanban-header gradient-purple">
                        <h6>À terminer la semaine prochaine (0)</h6>
                    </div>
                    <div class="kanban-content">
                        <div class="text-center mt-4">+</div>
                    </div>
                </div>
            
                <!-- Column: Pas de date limite -->
                <div class="kanban-column">
                    <div class="kanban-header gradient-gray">
                        <h6>Pas de date limite (0)</h6>
                    </div>
                    <div class="kanban-content">
                        <div class="text-center mt-4">+</div>
                    </div>
                </div>
                    <!-- Ajoutez les autres colonnes ici -->
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Liste des tâches -->
    <div class="tab-pane fade" id="list-tasks" role="tabpanel" aria-labelledby="list-tasks-tab">
        <div class="card shadow">
            <div class="card-body">
                <h5>Liste des tâches</h5>
                <hr>
                <div class="row g-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Rechercher une tâche (mot clé, date limit...)"
                    />
                </div>
               
                <!-- Tableau liste classeurs contrats -->
                <div class="table-responsive">
                    <div class="table-container">
                    <table id="contractsTable" class="contractsTable table-striped table-hover align-middle">
                        <thead class="theadlist" id="theadlist">
                            <tr>
                                <th>#</th>
                                <th>Numéro du contrat</th>
                                <th>Nom du classeur</th>
                                <th>Type de contrat</th>
                                <th>Date de création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lignes du tableau -->
                            <tr>
                                <td>1</td>
                                <td>PA15555</td>
                                <td>Classeur A</td>
                                <td>Assurance vie</td>
                                <td>2024-01-10</td>
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
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>PA15555</td>
                                <td>Classeur A</td>
                                <td>Assurance vie</td>
                                <td>2024-01-10</td>
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
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>PA742522</td>
                                <td>Classeur B</td>
                                <td>Assurance santé</td>
                                <td>2024-02-15</td>
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
                            </tr>
                        </tbody>
                    </table>
                    </div>
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

    <!-- Tab: Créer une tâche -->
    <div class="tab-pane fade" id="create-task" role="tabpanel" aria-labelledby="create-task-tab">
        <div class="card shadow">
        <div class="container py-4">
    <form class="shadow p-4 rounded bg-light">
        <h5 class="mb-4">Créer une nouvelle tâche</h5>
        <div class="row g-4">
            <!-- Colonne 1 -->
            <div class="col-md-6">
                <!-- Nom de la tâche -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="taskName" placeholder="Nom de la tâche">
                    <label for="taskName"><i class="bi bi-card-checklist me-2"></i>Nom de la tâche</label>
                </div>

                <!-- Description -->
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="taskDescription" placeholder="Description" style="height: 100px"></textarea>
                    <label for="taskDescription"><i class="bi bi-file-text me-2"></i>Description</label>
                </div>

                <!-- Responsable -->
                <div class="form-floating mb-3">
                    <select class="form-select" id="taskAssignee" aria-label="Responsable">
                        <option selected>Choisir un responsable</option>
                        <option value="1">Rucien Kindukulu</option>
                        <option value="2">Adonai Mbula</option>
                        <option value="3">John Masini</option>
                    </select>
                    <label for="taskAssignee"><i class="bi bi-person-check me-2"></i>Responsable</label>
                </div>

                <!-- Priorité -->
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-exclamation-triangle me-2"></i>Priorité</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="highPriority" value="high">
                        <label class="form-check-label" for="highPriority">Haute</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="mediumPriority" value="medium">
                        <label class="form-check-label" for="mediumPriority">Moyenne</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="lowPriority" value="low">
                        <label class="form-check-label" for="lowPriority">Basse</label>
                    </div>
                </div>
            </div>

            <!-- Colonne 2 -->
            <div class="col-md-6">
                <!-- Date limite -->
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" id="taskDeadline" placeholder="Date limite">
                    <label for="taskDeadline"><i class="bi bi-calendar-event me-2"></i>Date limite</label>
                </div>

                <!-- Observateur (avec mentions @) -->
                <div class="form-floating position-relative mb-3">
                    <input type="text" class="form-control mention-input" id="taskObserver" placeholder="Observateur">
                    <label for="taskObserver"><i class="bi bi-eyeglasses me-2"></i>Mentionner observateur</label>
                    <ul class="mention-suggestions list-group position-absolute mt-1 d-none">
                        <!-- Suggestions dynamiques apparaîtront ici -->
                    </ul>
                </div>

                <!-- Fichier/Document -->
                <div class="mb-4">
                    <label for="taskFile" class="form-label"><i class="bi bi-file-earmark-arrow-up me-2"></i>Ajouter un fichier/document</label>
                    <input class="form-control" type="file" id="taskFile">
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-save me-2"></i>Créer la tâche
                </button>
            </div>
        </div>
    </form>
</div>

        </div>
    </div>

    <!-- Tab: Suivi -->
    <div class="tab-pane fade" id="follow-up" role="tabpanel" aria-labelledby="follow-up-tab">
        <div class="card shadow">
            <div class="card-body">
                <h5>Suivi des tâches</h5>
                <hr>
                <p>Tableau de suivi des tâches avec les détails d'avancement.</p>
                <div class="table-container">
                <table class="tabsuivi">
            <thead class="theadsuivi">
                <tr>
                    <th>Tâche</th>
                    <th>Créée par</th>
                    <th>Responsable</th>
                    <th>Statut</th>
                    <th>Progrès</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="tbodysuivi">
                <tr>
                    <td>Migration de la base de données</td>
                    <td>Jean Dupont</td>
                    <td>Marie Curie</td>
                    <td>En cours</td>
                    <td>60%</td>
                    <td class="action-icons">
                        <i class="fas fa-eye" onclick="showDetails('Migration de la base de données', 'Jean Dupont', 'Marie Curie', 'En cours', '60%')"></i>
                        <i class="fas fa-edit" onclick="editTask('Migration de la base de données')"></i>
                    </td>
                </tr>
                <tr>
                    <td>Design UI</td>
                    <td>Sophie Martin</td>
                    <td>Alexandre Dumas</td>
                    <td>Terminé</td>
                    <td>100%</td>
                    <td class="action-icons">
                        <i class="fas fa-eye" onclick="showDetails('Design UI', 'Sophie Martin', 'Alexandre Dumas', 'Terminé', '100%')"></i>
                        <i class="fas fa-edit" onclick="editTask('Design UI')"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  <!-- Popup Details -->
  <div class="popup-overlay" id="popupOverlay">
        <div class="popup">
            <div class="popup-header">
                <h2>Détails du suivi</h2>
                <span class="close" onclick="closePopup()">&times;</span>
            </div>
            <div class="popup-content">
                <table>
                <div class="alert alert-info text-center" role="alert">
                Tâche en en cours!
                </div>
                    <tr>
                        <th>Tâche</th>
                        <td id="taskName"></td>
                    </tr>
                    <tr>
                        <th>Créée par</th>
                        <td id="createdBy"></td>
                    </tr>
                    <tr>
                        <th>Responsable</th>
                        <td id="responsible"></td>
                    </tr>
                    <tr>
                        <th>Observateur</th>
                        <td id="responsible"></td>
                    </tr>
                    <tr>
                        <th>Statut</th>
                        <td id="status"></td>
                    </tr>
                    <tr>
                        <th>Progrès</th>
                        <td id="progress"></td>
                    </tr>
                    <tr>
                        <th>Date Creation</th>
                        <td id="progress"></td>
                    </tr>
                    
                    <tr>
                        <th>Damarrage</th>
                        <td id="progress"></td>
                    </tr>
                    <tr>
                        <th>Date limite</th>
                        <td id="progress"></td>
                    </tr>
                    <tr>
                        <th>Rappel</th>
                        <td id="progress"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
                
            </div>
        </div>
    </div>
</div>

</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
    <script>
    // Recherche dynamique
    document.getElementById("searchInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#contractsTable tbody tr");
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // Pagination
    const table = document.getElementById("contractsTable");
    const rowsPerPage = 5;
    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const pagination = document.getElementById("pagination");

    function renderTable(page) {
        rows.forEach((row, index) => {
            row.style.display =
                index >= (page - 1) * rowsPerPage && index < page * rowsPerPage
                    ? ""
                    : "none";
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
        pagination.firstChild.classList.add("active");
    }

    renderTable(1);
    renderPagination();

    document.addEventListener("DOMContentLoaded", () => {
    const mentionInput = document.querySelector(".mention-input");
    const suggestionList = document.querySelector(".mention-suggestions");

    const agents = ["Rucien Kindukulu", "Adonai Mbula", "John Masini", "Maelle Rhode", "Mike Bakala"]; // Liste d'agents à recuperer dans l'api agents

    mentionInput.addEventListener("input", (e) => {
        const value = e.target.value.trim();
        if (value.startsWith("@")) {
            const searchTerm = value.substring(1).toLowerCase();
            const filteredAgents = agents.filter((agent) =>
                agent.toLowerCase().includes(searchTerm)
            );

            suggestionList.innerHTML = filteredAgents
                .map((agent) => `<li class="list-group-item">${agent}</li>`)
                .join("");

            suggestionList.classList.remove("d-none");
        } else {
            suggestionList.classList.add("d-none");
        }
    });

    suggestionList.addEventListener("click", (e) => {
        if (e.target.tagName === "LI") {
            mentionInput.value = `@${e.target.textContent}`;
            suggestionList.classList.add("d-none");
        }
    });

    document.addEventListener("click", (e) => {
        if (!mentionInput.contains(e.target) && !suggestionList.contains(e.target)) {
            suggestionList.classList.add("d-none");
        }
    });
});


function showDetails(task, createdBy, responsible, status, progress) {
            document.getElementById('taskName').textContent = task;
            document.getElementById('createdBy').textContent = createdBy;
            document.getElementById('responsible').textContent = responsible;
            document.getElementById('status').textContent = status;
            document.getElementById('progress').textContent = progress;

            document.getElementById('popupOverlay').classList.add('active');
        }

        function closePopup() {
            document.getElementById('popupOverlay').classList.remove('active');
        }

        function editTask(task) {
            alert('Editer la tâche : ' + task);
            // Implémentez la logique d'édition ici
        }
</script>

</body>
</html>