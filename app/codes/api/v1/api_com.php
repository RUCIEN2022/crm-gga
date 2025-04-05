<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassCom.php');

$com = new Commercial();
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
            if ($action === 'Prospect') {
                    $response = $com->listeProspect();   
            }elseif ($action === 'total') {
               
                // Statistiques ou indicateurs pour le tableau de bord
                $response = [
                    'status' => 200,
                    'data' => [
                        'totalprospect' => $com->getTotalProspect() ?? 0,
                        'totalclient' => $com->getClient() ?? 0,
                        'totalproduit' => $com->getProduit() ?? 0,
                        'totalprovendu' => $com->getProduitVendu() ?? 0,
                    ]
                ];
            }elseif ($action === 'tp'){
                $response = $com->getTypeProspect();   
            }elseif ($action === 'moyens'){
                $response = $com->getMoyen();   
            }elseif ($action === 'clientpro'){
                $response = $com->getListeClient();   
            }elseif ($action === 'produit'){
                $response = $com->getListeProduit();   
            }

            break;
        
        case 'POST':
                
             if ($action === 'createprospect') { // Début action login
               // session_start(); // Démarrage de la session
                try {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $com->CreerProspect($data);
                    if($result){
                        $response = ['status' => 200, 'message' => 'Prospect enregistré'];
                    }
                    
                }catch (Exception $e) {
                    http_response_code(400); // Code 400 pour mauvaise requête
                    $response = ['status' => 400, 'message' => $e->getMessage()];
                }
            }elseif($action === 'createproduit'){
                try {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $com->CreerProduit($data);
                    if($result){
                        $response = ['status' => 200, 'message' => 'Produit créé'];
                    }
                    
                } catch (Exception $e) {
                    http_response_code(400); // Code 400 pour mauvaise requête
                    $response = ['status' => 400, 'message' => $e->getMessage()];
                }
            }elseif($action === 'vente'){
                try {
                   /* $data = json_decode(file_get_contents("php://input"), true);
                  
                    $produits = $data['produit_id'];
                   
                    foreach ($produits as $produit_id) {
                        //$com->CreerProduit($data);
                        $result = $com->insertVente($data);
                    }
                
                    if($result){
                        $response = ['status' => 200, 'message' => 'Vente enregistrée'];
                    } */
                   
                    $data = json_decode(file_get_contents("php://input"), true);
                    $produits = $data['produit_id'];
                    $result = true;

                    foreach ($produits as $produit_id) {
                        $data['produit_id'] = $produit_id;
                        $inserted = $com->insertvente($data);
                        if (!$inserted) {
                            $result = false;
                            break;
                        }
                    }

                    if($result){
                        $response = ['status' => 200, 'message' => 'Vente enregistrée'];
                    } else {
                        $response = ['status' => 500, 'message' => 'Une erreur est survenue lors de l\'insertion.'];
                    }

                    
                } catch (Exception $e) {
                    http_response_code(400); // Code 400 pour mauvaise requête
                    $response = ['status' => 400, 'message' => $e->getMessage()];
                }
            }
            else {
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