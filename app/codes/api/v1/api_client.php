<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassClient.php');

$cli = new Client();

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
            if ($action === 'rccm') {
                if ($id) {
                    // Décoder l'ID (RCCM) dans l'URL pour gérer les caractères spéciaux
                    $rccm = urldecode($id);
        
                    //expression régulière pour valider le format du RCCM
                    if (preg_match('/^[A-Z]{2}\/[A-Z]{3}\/RCCM\/[0-9]{2}-[A-Z]{1}-[0-9]{5}$/', $rccm)) {
                        // Si le RCCM est valide, procéder à la recherche
                        $response = $cli->fx_RechercheClientRccm($rccm);
                        
                        // Si aucune donnée n'est trouvée
                        if (empty($response)) {
                            $response = ['error' => 'Aucun client trouvé pour ce RCCM'];
                        }
                    } else {
                        // Si le RCCM n'est pas valide, retourner une erreur
                        $response = ['error' => 'RCCM invalide'];
                    }
                } else {
                    $response = $cli->ListeGlobalClient();
                }
            } elseif ($action === 'clients') {
                if ($id) {
                    // Récupérer les détails d'un contrat spécifique
                    $response = $cli->fx_RechercheClientID($id);
                }
            }elseif ($action === 'site') {
                $response = $cli->listeSite();
            }
            break;
        

        case 'POST':
            if ($action === 'create') {
                // Créer un partenaire
                $data = json_decode(file_get_contents("php://input"), true);

                // Vérifier si JSON est bien reçu
                //if (!$data) {
                   // die(json_encode(["status" => 400, "message" => "Aucune donnée reçue par le serveur!"]));
                //}
                
                // Enregistrer les données reçues pour debug
              //  file_put_contents("log_api.txt", print_r($data, true), FILE_APPEND);
                $response = $cli->fx_CreerClient($data);
                if($response){
                    $response=['Statut' =>200, 'message' => 'Client enregistré'];
                }else{
                    $response = ['status' => 500, 'message' => 'Echec d\'enregistrement'];
                }
 
            }else{
                $response = ['status' => 400, 'message' => 'Action  manquant pour effectuer cette opération'];
            }
            break;
            //Mise à jour contrat
            case 'PUT':
                if ($action === 'updtcontrat' && $id) { //j'appel l'action + id 
                    // Récup data envoyées
                    $data = json_decode(file_get_contents("php://input"), true);
                    if ($data) {
                        $response = $cli->fx_UpdateClient($id, $data);
                    } else {
                        $response = ['status' => 400, 'message' => 'Données manquantes pour la mise à jour'];
                    }
                } else {
                    $response = ['status' => 400, 'message' => 'Action ou ID manquant pour la mise à jour'];
                }
            break;
                //Suppression
            case 'DELETE':
                    if ($action === 'suppcontrat' && $id) {//j'appel l'action + id 
                        $response = $cli->DeleteClient($id);
                        if ($response) {
                            $response = ['status' => 200, 'message' => 'Le Contrat est supprimé avec succès!'];
                        } else {
                            $response = ['status' => 500, 'message' => 'Echec de suppression du contrat'];
                        }
                    } else {
                        $response = ['status' => 400, 'message' => 'Action ou ID manquant pour effectuer cette opération'];
                    }
            break;
                
        default:
            $response = ['status' => 400, 'message' => 'Méthode HTTP non supportée'];
    }
} catch (Exception $e) {
    $response = ['status' => 500, 'message' => $e->getMessage()];
}
echo json_encode($response);
