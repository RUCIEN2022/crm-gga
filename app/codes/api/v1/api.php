<?php
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClasseContrat.php');

$contrat = new Contrat();

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
            if ($action === 'contrats') {
                
                if ($id) {
                    // Récupérer les détails d'un contrat spécifique
                    $response = $contrat->totalBeneficiairesParContrat($id);
                } else {
                    $response = $contrat->listeGlobalContrats();
                    
                  //  $response = $contrat->totalGlobalContrats();
                }
            } elseif ($action === 'dashboard') {
                // Statistiques ou indicateurs pour le tableau de bord
                $response = [
                    'status' => 200,
                    'data' => [
                        'totalContrats' => $contrat->totalGlobalContrats(),
                        'totalContratsAssur' => $contrat->totalGlobalContratsAssurance(),
                        'totalContratsAutofin' => $contrat->totalGlobalContratsAutoFin(),
                        'totalContratsVoyage' => $contrat->totalGlobalContratsVoyage(),
                        'totalContratsVie' => $contrat->totalGlobalContratsVie(),
                        'totalEffectBenef' => $contrat->effectifGlobalBeneficiaires(),
                        'totalBenefAssur' => $contrat->effectifGlobalBeneficiairesAssur(),
                        'totalBenefAutifin' => $contrat->effectifGlobalBeneficiairesAutofin(),
                        'totalprod' => $contrat->rapportGlobalProduction(),
                        'totalFraisGestion' => $contrat->TotalFrais_de_Gestion_prevision(),
                        'totalCouvNat' => $contrat->Total_Couverture_Nationale(),
                        'totalCouvInternat' => $contrat->Total_Couverture_Internationale(),
                        'date' => date('Y-m-d H:i:s'),
                    ]
                ];
            }
            break;
        

        case 'POST':
            if ($action === 'create') {
                // Créer un contrat
                $data = json_decode(file_get_contents("php://input"), true);
                if (isset($data['type'])) {
                    if ($data['type'] === 'autofin') {
                        $response = $contrat->creerContratAutoFinance($data);
                    } elseif ($data['type'] === 'assurance') {
                        $response = $contrat->creerPoliceAssurance($data);
                    } else {
                        $response = ['status' => 400, 'message' => 'Type de contrat invalide'];
                    }
                } else {
                    $response = ['status' => 400, 'message' => 'Type de contrat manquant'];
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
