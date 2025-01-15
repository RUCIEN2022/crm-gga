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
                        <h2>Contrats</h2>
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

    <div class="card shadow">
        <div class="card-body">
        
            <div class="row g-3">
                <!-- Bouton d'ajout -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="./creation" class="btn btn-danger">
                        <i class="bi bi-plus-circle"></i> Créer contrat
                    </a>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control w-50"
                        placeholder="Rechercher un contrat (Numéro, Nom, Type, Date)"
                    />
                </div>
                <h5 class="mb-4">Classeurs contrats</h5>
                <!-- Tableau liste classeurs contrats -->
                <div class="table-responsive">
                    <table id="contractsTable" class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
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
</script>
</body>
</html>