
<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClasseIntermediaire.php');

$interm = new Intermediaire();

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
            if ($action === 'liste') {
                if ($id) {
                    // Récupérer les détails d'un partenaire spécifique
                    $response = $interm->RechercheIntermediaire($id);
                } else {
                    $response = $interm->ListeIntermediaire();
                }
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

