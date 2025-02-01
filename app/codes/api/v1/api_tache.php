<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);






header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClassTache.php');

$tache = new Tache();

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
            if ($action === 'rtache') {
                $taches = [
                    'total' => $tache->getTotalTaches() ?? 0,
                    'en_cours' => $tache->getTachesEnCours() ?? 0,
                    'terminees' => $tache->getTachesTerminees() ?? 0,
                    'retard' => $tache->getTachesRetard() ?? 0,
                ];
                $response =[
                    'success' => true,
                    'data' => $taches

                ];
            }elseif($action === 'agent'){
                $response = $tache->getAgent();
            } 
            break;
    
        case 'POST':
            if ($action === 'create') {
                // Créer un partenaire
               // $data = json_decode(file_get_contents("php://input"), true);

                // Vérifier si JSON est bien reçu
                //if (!$data) {
                   // die(json_encode(["status" => 400, "message" => "Aucune donnée reçue par le serveur!"]));
                //}
                
                // Enregistrer les données reçues pour debug
               // file_put_contents("log_api.txt", print_r($data, true), FILE_APPEND);

                //$uploadDir = "/../../../taches/doc/"; // Dossier de destination
                $uploadDir = __DIR__ . "doc/"; // Assurez-vous que ce chemin est correct
                // Récupérer les données JSON
                $data = json_decode($_POST['json'], true);
               // if (!is_dir($uploadDir)) {
                 //   mkdir($uploadDir, 0777, true); // Création du dossier si inexistant
                //}
                $file = $_FILES['file'];
                $fileName = basename($file["name"]);
                $targetFilePath = $uploadDir . $fileName;

                // Vérifier l'extension du fichier
                $allowedExtensions = ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx"];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExtension, $allowedExtensions)) {
                    //echo "Format de fichier non supporté !";
                    $response = ['status' => 500, 'message' => 'Format de fichier non supporté'];
                    exit;
                }
                 // Vérifier la taille du fichier (5MB max)
                if ($file["size"] > 5 * 1024 * 1024) {
                   //echo "Le fichier est trop volumineux (max 5MB) !";
                    $response = ['status' => 500, 'message' => 'Le fichier est trop volumineux (max 5MB) !'];
                    exit;
                }
                // Déplacer le fichier dans le dossier de destination
                if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                   // echo "Fichier uploadé avec succès : " . $fileName;
                   //$data['fichier'] = $targetFilePath;
                  // $data = ['fichier' => $targetFilePath];
                   $data['fichier'] = $targetFilePath; // Ajouter le fichier au JSON

                } else {
                   // echo "Erreur lors de l'upload du fichier.";
                    $response = ['status' => 500, 'message' => 'Erreur lors de l\'upload du fichier!'];
                    exit;
                }
               // $data = ['fichier' => $targetFilePath];
                $response = $tache->creerTache($data);
               // echo $data;
                if($response){
                    $response=['Statut' =>200, 'message' => 'tache enregistré'];
                }else{
                    $response = ['status' => 500, 'message' => 'Echec dd\'enregistrement'];
                }
 
            }else{
                $response = ['status' => 400, 'message' => 'Action  manquant pour effectuer cette opération'];
            }
            break;
            //Mise à jour contrat
            case 'PUT':
                if ($action === 'updtache' && $id) { //j'appel l'action + id 
                    // Récup data envoyées
                    $data = json_decode(file_get_contents("php://input"), true);
                    if ($data) {
                        $response = $tache->UpdateTache($id, $data);
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
                        $response = $tache->DeleteTache($id);
                        if ($response) {
                            $response = ['status' => 200, 'message' => 'Le tache est supprimée avec succès!'];
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
