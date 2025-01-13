<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassPartenaire.php');

$partenaire = new Partenaire();

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
            if ($action === 'partenaires') {
        
                if ($id) {
                    // Récupérer les détails d'un partenaire spécifique
                    $response = $partenaire->RecherchePartenaire($id);
                } else {
                    $response = $partenaire->ListePartenaire();
                }
            }
            break;
        
        case 'POST':
            if ($action === 'create') {
                // Créer un partenaire
                $data = json_decode(file_get_contents("php://input"), true);

             
                $response = $partenaire->fx_CreerPartenaire($data);
                if($response){
                    $response=['Statut' =>200, 'message' => 'Partenaire enregistre'];
                }else{
                    $response = ['status' => 500, 'message' => 'Echec d\'enregistrement'];
                }
            }else{
                $response = ['status' => 400, 'message' => 'Action  manquant pour effectuer cette opération'];
            }
            break;


        case 'PUT':
            if ($action === 'Update' && $id) { //j'appel l'action + id 
                // Récup data envoyées
                $data = json_decode(file_get_contents("php://input"), true);
                if ($data) {
                    $response = $partenaire->fx_UpdatePartenaire($id, $data);
                } else {
                    $response = ['status' => 400, 'message' => 'Données manquantes pour la mise à jour'];
                }
            }else {
                $response = ['status' => 400, 'message' => 'Action ou ID manquant pour la mise à jour'];
            }
            break;
        case 'DELETE':
            if ($action === 'SuppParte' && $id) {//j'appel l'action + id 
                $response = $partenaire->DeletePartenaire($id);
                if ($response) {
                    $response = ['status' => 200, 'message' => 'Partenaire est supprimé avec succès!'];
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

// Retourner la réponse en JSON
echo json_encode($response);

?>