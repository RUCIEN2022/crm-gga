<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClasseParametre.php');

$parametre = new Parametre();

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
           if ($action === 'total') {
                // Statistiques ou indicateurs pour le tableau de bord
                $response = [
                    'status' => 200,
                    'data' => [
                        'totalUtile' => $parametre->getTotalUser() ?? 0,
                        'totalClient' => $parametre->getTotalClient() ?? 0,
                        'totalInt' => $parametre->getTotalInterm() ?? 0,
                        'totalPart' => $parametre->getTotalPartenaire() ?? 0,
                        'totalSite' => $parametre->getTotalSite() ?? 0,
                        'totalPoste' => $parametre->getTotalPoste() ?? 0,
                        'totalProfil' => $parametre->getTotalProfil() ?? 0,
                    ]
                ];
               
            }elseif ($action === 'poste') {
                // Statistiques ou indicateurs pour le tableau de bord
                $response = $parametre->listePoste();
            }
         
        break;
        case 'POST':
            if($action === 'create1') {
                $data = json_decode(file_get_contents("php://input"), true);

                $result = $parametre->CreerIntermediaire($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Intermediaire enregistre'];
                }
            }else {
                http_response_code(405); // methode non autorisée
                $response = ['status' => 405, 'message' => 'Méthode incorecte'];
            }
        break;   
        
        default:
            $response = ['status' => 400, 'message' => 'Méthode HTTP non supportée'];
    }
} catch (Exception $e) {
    $response = ['status' => 500, 'message' => $e->getMessage()];
}
echo json_encode($response);
