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
            }elseif ($action === 'dashboard') {
                // Statistiques ou indicateurs pour le tableau de bord
                $response = [
                    'status' => 200,
                    'data' => [
                        'totalContrats' => ['count' => $contrat->totalGlobalContrats()['count'] ?? 0],
                        'totalContratsAssur' => ['count' => $contrat->totalGlobalContratsAssurance()['count'] ?? 0],
                        'totalContratsAutofin' => ['count' => $contrat->totalGlobalContratsAutoFin()['count'] ?? 0],
                        'totalContratsVoyage' => ['count' => $contrat->totalGlobalContratsVoyage()['count'] ?? 0],
                        'totalContratsVie' => ['count' => $contrat->totalGlobalContratsVie()['count'] ?? 0],
                        'totalEffectBenef' => $contrat->effectifGlobalBeneficiaires() ?? 0,
                        'totalFraisGestion' => ['amount' => $contrat->TotalFrais_de_Gestion_prevision()['amount'] ?? 0],
                        'totalCouvNat' => $contrat->Total_Couverture_Nationale() ?? 0,
                        'totalCouvInternat' => $contrat->Total_Couverture_Internationale() ?? 0,
                        'date' => date('Y-m-d H:i:s'),
                    ]
                ];
               
            }elseif ($action === 'getTypeContrat') {
                // Charger les types de contrats
                $typesContrats = $contrat->getTypeContrat();
                if ($typesContrats) {
                    $response = ['status' => 200, 'data' => $typesContrats];
                } else {
                    $response = ['status' => 404, 'message' => 'Aucun type de contrat trouvé'];
                }
            }
            elseif ($action === 'getGestionnaire') {
                // Charger les agents
                $agent = $contrat->getGestionnaire();
                if ($agent) {
                    $response = ['status' => 200, 'data' => $agent];
                } else {
                    $response = ['status' => 404, 'message' => 'Aucun agent trouvé'];
                }
            }
            break;
        

            case 'POST':
                if ($action === 'create') {
                    // Créer un contrat
                    $data = json_decode(file_get_contents("php://input"), true);
            
                    // Vérification des données reçues
                    if (empty($data['contrat']) || !is_array($data['contrat'])) {
                        echo json_encode([
                            "success" => false,
                            "message" => "Les données du contrat sont obligatoires."
                        ]);
                        exit;
                    }
            
                    $contratData = $data['contrat'];
            
                    try {
                        // Instance de la classe Contrat
                        $contrat = new Contrat();
            
                        // Appel de la méthode pour enregistrer le contrat
                       // $result = $contrat->enregistrerContrat($contratData);
            
                        // Retour du résultat sous format JSON
                        echo json_encode($result);
                    } catch (Exception $e) {
                        // Gestion des erreurs internes du serveur
                        echo json_encode([
                            "success" => false,
                            "message" => "Erreur interne du serveur : " . $e->getMessage()
                        ]);
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
