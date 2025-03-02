<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassFinance.php');

$fina = new Finance();
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
            if ($action === 'decompte') {
                    $response = $fina->getListeDecompte();   
            } elseif($action === 'JO'){
                $response = $fina->getListeJO(); 
            }elseif($action === 'JC'){
                $response = $fina->getListeJC(); 
            }elseif($action === 'JB'){
                $response = $fina->getListeJB(); 
            }elseif($action === 'FD'){
                $response = $fina->getListeFondDerou(); 
            }
            break;
        
        case 'POST':
                
             if ($action === 'create_decompte') { // Début action login
               // session_start(); // Démarrage de la session
                try {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $fina->CreerDecompte($data);
                    if($result){
                        $response = ['status' => 200, 'message' => 'Facture receptionnee'];
                    }
                    
                } catch (Exception $e) {
                    http_response_code(400); // Code 400 pour mauvaise requête
                    $response = ['status' => 400, 'message' => $e->getMessage()];
                }
            }//fin login
             elseif($action === 'create_fond') {
                $data = json_decode(file_get_contents("php://input"), true);

                $result = $fina->CreerFond_deroulement($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Fond enregistre'];
                }
            }elseif($action === 'create_JO') {
                $data = json_decode(file_get_contents("php://input"), true);
                $dataJO=json_decode(file_get_contents("php://input"), true);
                $result = $fina->EnregistrerJournal($dataJO,$data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Operation enregistree'];
                }
                /*
                if($data['compte'] == 'Caisse'){
                    $result = $fina->InsertJournalOp($data);
                    if($result){
                        $fina->InsertJournalCaisse($data);
                        $response = ['status' => 200, 'message' => 'Courrier entrant enregistre'];
                    }
                }elseif($data['compte'] == 'Banque') {
                    $result = $fina->InsertJournalOp($data);
                    if($result){
                        $fina->InsertJournalBanque($data);
                        $response = ['status' => 200, 'message' => 'Courrier entrant enregistre'];
                    }
                }
                */
            
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