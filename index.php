<?php
session_start();

// Récupérer l'URL demandée
$request = trim($_SERVER['REQUEST_URI'], '/');

// Supprimer le préfixe de dossier
$baseFolder = 'crm-gga';
if (strpos($request, $baseFolder) === 0) {
    $request = substr($request, strlen($baseFolder));
}
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

// Gestion des routes
switch ($request) {
    case 'dashboard':
        include 'dashboard/index.php';
        break;

    case 'login':
        include 'login/index.php';
        break;

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

    case (preg_match('/^contrats\/view\/\d+$/', $request) ? true : false):
        $id = explode('/', $request)[2];
        include 'contrats/view.php';
        break;

    case (preg_match('/^contrats\/edit\/\d+$/', $request) ? true : false):
        $id = explode('/', $request)[2];
        include 'contrats/edit.php';
        break;
    case 'parametres':
        include 'parametres/index.php';
        break;
    case 'parametres/partenaires':
            include 'parametres/partenaires.php';
            break;
    case 'parametres/importation':
            include 'parametres/importation.php';
            break;
    case 'commercial':
        include 'commercial/index.php';
        break;
    case 'admin':
        include 'admin/index.php';
        break;
    case 'admin/prestataires':
        include 'admin/prestataires.php';
        break;
    case 'finances':
        include 'finances/index.php';
        break;
    case 'facture':
        include 'facture/index.php';
        break;
    case 'notedebit':
       include 'contrats/notedebit.php';
       break;
   
    case 'users':
        include 'users/index.php';
        break;
    
    case 'clients/creation':
            include 'clients/creation.php';
            break;
    case 'clients':
            include 'clients/index.php';
            break;
    case 'taches':
            include 'taches/index.php';
            break; 
    case 'taches/creation':
            include 'taches/creation.php';
            break;
    case 'success':
            include 'success.php';
            break;
    case 'success':
            include 'success.php';
            break;
    case 'failed':
            include '500.php';
            break; 
            
    default:
        // Vérifiez si le fichier 404.php existe avant de l'inclure
        if (file_exists('404.php')) {
            
            include '404.php';
        } else {
            echo "<h1>Erreur 404 : Page non trouvée</h1>";
        }
        break;
}
