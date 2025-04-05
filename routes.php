<?php
session_start();

// Récupérer l'URL demandée
$request = trim($_SERVER['REQUEST_URI'], '/');

// Nettoyer l'URL pour obtenir la route sans le nom du dossier du projet
$request = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
$request = trim($request, '/');

// Rediriger selon l'état de connexion
if ($request === '') {
    if (isset($_SESSION['idutile']) && $_SESSION['idutile'] === true) {
        header('Location: dashboard/');
    } else {
        header('Location: login/');
    }
    exit();
}
/*
// Vérification si c'est une requête API
if (strpos($request, 'app/codes/api/v1/') === 0) {
    // Extraire l'endpoint après 'app/codes/api/v1/'
    $endpoint = str_replace('app/codes/api/v1/', '', $request);

    // Vérifier si l'endpoint correspond à la récupération d'un contrat
    if ($endpoint === 'notedebit') {
        require_once 'app/codes/controles/ControllerGetContrat.php';
        $controller = new ContratController();
        $controller->getContratByNumeroPolice(); // Il faudra passer les paramètres nécessaires ici
        exit();
    }

    // Ajouter d'autres endpoints API ici si nécessaire...
}

// Gestion des routes pour le site
switch ($request) {
    // Route pour la page dashboard
    case 'dashboard':
        include 'dashboard/index.php';
        break;

    // Route pour la page login
    case 'login':
        include 'login/index.php';
        break;

    // Routes pour les différentes pages de gestion des contrats
    case 'contrats/creations':
        include 'contrats/creation.php';
        break;
    case 'contrats/gestion':
        include 'contrats/gestion.php';
        break;
    case 'contrats/edit_contrat':
        include 'contrats/editcontrat.php';
        break;
    case 'contrats/classeurs':
        include 'contrats/classeurs.php';
        break;
    case 'contrats/cotation':
        include 'contrats/cotations.php';
        break;
    case 'contrats/rapports':
        include 'contrats/reporting.php';
        break;

    // Routes dynamiques pour afficher ou éditer un contrat
    case (preg_match('/^contrats\/view\/\d+$/', $request) ? true : false):
        $id = explode('/', $request)[2];
        include 'contrats/view.php';
        break;

    case (preg_match('/^contrats\/edit\/\d+$/', $request) ? true : false):
        $id = explode('/', $request)[2];
        include 'contrats/edit.php';
        break;

    // Route pour afficher la facture
    case 'facture':
        include 'facture/index.php';
        break;

    // Route pour afficher la note de débit
    case 'notedebit':
        include 'contrats/notedebit.php';
        break;

    // Routes pour la gestion des utilisateurs
    case 'users':
        include 'users/index.php';
        break;

    // Routes pour la gestion des partenaires
    case 'partenaires':
        include 'partenaires/index.php';
        break;
    case 'partenaires/creation':
        include 'partenaires/creation.php';
        break;

    // Routes pour la gestion des clients
    case 'clients/creation':
        include 'clients/creation.php';
        break;
    case 'clients':
        include 'clients/index.php';
        break;

    // Routes pour la gestion des tâches
    case 'taches':
        include 'taches/index.php';
        break;
    case 'taches/creation':
        include 'taches/creation.php';
        break;

    // Routes pour les pages de succès et d'erreur
    case 'success':
        include 'success.php';
        break;
    case 'failed':
        include '500.php';
        break;

    // Gestion de la page 404 si la route n'est pas trouvée
    default:
        // Vérifiez si le fichier 404.php existe avant de l'inclure
        if (file_exists('404.php')) {
            include '404.php';
        } else {
            echo "<h1>Erreur 404 : Page non trouvée</h1>";
        }
        break;
}
