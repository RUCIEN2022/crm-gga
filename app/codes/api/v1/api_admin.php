<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassAdmin.php');

$admin = new Administraction();
// méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Récuperation de l'action depuis l'URL. je t'expliquerai chaque ligne...
$path_info = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';
$request = explode('/', $path_info);
$action = isset($request[0]) ? $request[0] : '';
$id = isset($request[1]) ? $request[1] : null;
// Réponse par défaut
$response = ['status' => 404, 'message' => 'Endpoint non trouvé'];

    
try {
    switch ($method) {
        case 'GET':
            if ($action === 'listeRF') {
                    $response = $admin->getListereception_facture();   
            } elseif($action === 'listePresta'){
                $response = $admin->getListePrestataire(); 
            }elseif($action === 'listeCE'){
                $response = $admin->getListeCE(); 
            }elseif($action === 'listeCS'){
                $response = $admin->getListeCS(); 
            }elseif($action === 'Total'){
                // Statistiques ou indicateurs pour le tableau de bord
                $response = [
                    'status' => 200,
                    'data' => [
                        'totalRF' => $admin->getTotalFactureRecu() ?? 0,
                        'totalPre' => $admin->getTotalPrestataire() ?? 0,
                        'totalCE' => $admin->getTotalCE() ?? 0,
                        'totalCS' => $admin->getTotalCS() ?? 0,
                     
                    ]
                ];
            }
            break;
        
        case 'POST':
             //------- from jmas -------   
             if ($action === 'reception') { // Début action login
               // session_start(); // Démarrage de la session
                try {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $admin->CreerReception_facture($data);
                    if($result){
                        $response = ['status' => 200, 'message' => 'Facture receptionnee'];
                    }
                    
                } catch (Exception $e) {
                    http_response_code(400); // Code 400 pour mauvaise requête
                    $response = ['status' => 400, 'message' => $e->getMessage()];
                }
            }//fin login
             elseif($action === 'create_presta') {
                $data = json_decode(file_get_contents("php://input"), true);

                $result = $admin->CreerPrestataire($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Prestataire enregistre'];
                }
            }elseif($action === 'create_CE') {
                $data = json_decode(file_get_contents("php://input"), true);
                $result = $admin->CreerCourrierEntrant($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Courrier entrant enregistre'];
                }
            }elseif($action === 'create_CS') {
                $data = json_decode(file_get_contents("php://input"), true);
                $result = $admin->CreerCourrierSortant($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Prestataire enregistre'];
                }
            }else {
                http_response_code(405); // methode non autorisée
                $response = ['status' => 405, 'message' => 'Méthode incorecte'];
            }

            break;
        // A completer avec ses methodes    
        /*
        case 'PUT':
              
             if ($action === 'UpdateUser' && $id) { //j'appel l'action + id 
                // Récup data envoyées
                $data = json_decode(file_get_contents("php://input"), true);
                if ($data) {
                    $response = $user->UpdateUser($id, $data);
                } else {
                    $response = ['status' => 400, 'message' => 'Données manquantes pour la mise à jour'];
                }
            }else {
                $response = ['status' => 400, 'message' => 'Action ou ID manquant pour la mise à jour'];
            }
           
            break;
        case 'DELETE':
            if ($action === 'SuppUser' && $id) {//j'appel l'action + id 
                $response = $user->DeleteUser($id);
                if ($response) {
                    $response = ['status' => 200, 'message' => 'User est supprimé avec succès!'];
                } else {
                    $response = ['status' => 500, 'message' => 'Echec de suppression du contrat'];
                }
            } else {
                $response = ['status' => 400, 'message' => 'Action ou ID manquant pour effectuer cette opération'];
            }
            break;
         */
        default:
            $response = ['status' => 400, 'message' => 'Méthode HTTP non supportée'];
    }
} catch (Exception $e) {
    $response = ['status' => 500, 'message' => $e->getMessage()];
}

// Retourner la réponse en JSON
echo json_encode($response);

?>