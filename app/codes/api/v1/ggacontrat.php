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
            //Mise à jour contrat
            case 'PUT':
                if ($action === 'updtcontrat' && $id) { //j'appel l'action + id 
                    // Récup data envoyées
                    $data = json_decode(file_get_contents("php://input"), true);
                    if ($data) {
                        $response = $contrat->fx_UpdateContrat($id, $data);
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
                        $response = $contrat->fx_DeleteContrat($id);
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