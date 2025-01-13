<?php
   header("Content-Type: application/json");
   include_once(__DIR__ . '/../../models/ClassUser.php');
  
   $user = new Utilisateur();
    // méthode HTTP
   $method = $_SERVER['REQUEST_METHOD'];
   
    // Récuperation de l'action depuis l'URL. je t'expliquerai chaque ligne...
    $path_info = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';
    $request = explode('/', $path_info);
    $action = isset($request[0]) ? $request[0] : '';
    $id = isset($request[1]) ? $request[1] : null;
    // Réponse par défaut
    $response = ['status' => 404, 'message' => 'Endpoint non trouvé'];


// redimensionnement image
function resizeImage($sourceImage, $maxWidth, $maxHeight) {
    $imageInfo = getimagesizefromstring($sourceImage);
    $width = $imageInfo[0];
    $height = $imageInfo[1];

    // Calcul nouvelles dimensions
    $ratio = $width / $height;
    if ($width > $maxWidth || $height > $maxHeight) {
        if ($ratio > 1) {
            $newWidth = $maxWidth;
            $newHeight = $maxWidth / $ratio;
        } else {
            $newHeight = $maxHeight;
            $newWidth = $maxHeight * $ratio;
        }
    } else {
        // Garde la taille d'origine si plus petite que le maximum
        return $sourceImage;
    }

    // Création d'une nouvelle image
    $image = imagecreatefromstring($sourceImage);
    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    // Redimensionnement
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Sauvegarde de l'image redimensionnée dans le buffer et retour des données
    ob_start();
    imagejpeg($newImage);
    $resizedImage = ob_get_clean();

    // je detruis l'image pour libérer la mémoire
    imagedestroy($image);
    imagedestroy($newImage);

    return $resizedImage;
}

// ici je sauvegarder l'image
function saveImage($imageBase64, $filename) {
    // je valide si c'est bien une image
    $imageData = base64_decode($imageBase64);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($imageData);

    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        throw new Exception('Format d\'image non valide. Seulement JPG et PNG sont autorisés.');
    }

    // Encore un redimenstionnement
    $imageData = resizeImage($imageData, 800, 800);

    $filePath = "../..//img/photos/" . $filename;

    if (!file_put_contents($filePath, $imageData)) {
        throw new Exception('Échec du téléchargement de l\'image.');
    }

    return $filePath;
}

    
try {
    switch ($method) {
        case 'GET':
            if ($action === 'user') {
                
                if ($id) {
                    // Récupérer les détails d'un contrat spécifique
                  
                    $response = $user->RechercheUser($id);
                } else {
                    
                    $response = $user->ListeUser();
                    
                  //  $response = $contrat->totalGlobalContrats();
                }
            } 
            break;
        
        case 'POST':
             //------- from jmas -------   
            if ($action === 'login') {
                $data = json_decode(file_get_contents("php://input"), true);

                // Vérif champs email et motdepasse
                if (!isset($data['email'], $data['motpasse'])) {
                    http_response_code(400);
                    $response = ['status' => 400, 'message' => 'Identifiants requis'];
                    echo json_encode($response);
                    exit;
                }
                $auth = $user->AuthentifierUser($data['email'], $data['motpasse']);

                //if ($auth instanceof PDOStatement && $auth->rowCount() > 0) {
                if($auth){
                    $response = ['status' => 200, 'data' => []];
                    //var_dump($auth);
                    // Vérifiez si $result est un tableau non vide
                    if (is_array($auth) && !empty($auth)) {
                        // Accédez au premier élément du tableau
                        $ligne = $auth[0];
                        $etatutile=$ligne['etatutile'];

                        if($etatutile > 0){
                            // Affichez les informations utilisateur
                            $response['data'][] = [
                                'id' => $ligne['idutile'],
                                'email' => $ligne['email'],
                                'nomutile' => $ligne['nomutile'],
                                'prenomutile' => $ligne['prenomutile'],
                                'etatutile' => $ligne['etatutile']
                            ];
                            // gestion de session
                        }else{
                            $response = ['status' => 404, 'message' => 'Votre compte Utilisateur est desactivé.'];
                        }

                    } else {
                        
                        $response = ['status' => 404, 'message' => 'Aucun utilisateur trouvé.'];
                    }

                    /*
                    while ($ligne = $auth->fetch(PDO::FETCH_ASSOC)) {
                        $etatutile=$ligne['etatutile'];
                        if($etatutile === 1){
                            $response['data'][] = [
                                'id' => $ligne['idutile'],
                                'email' => $ligne['email'],
                                'nomutile' => $ligne['nomutile'],
                                'prenomutile' => $ligne['prenomutile'],
                                'etatutile' => $ligne['etatutile']
                            ];
                        }else{
                            $response = ['status' => 404, 'message' => 'Votre compte Utilisateur est desactive.'];
                        }
                        
                    } */
                } else {
                    http_response_code(404); // renvoi le HTTP 404
                    $response = ['status' => 404, 'message' => 'Utilisateur ou mot de passe incorrect.'];
                }
            }elseif($action === 'create') {
                $data = json_decode(file_get_contents("php://input"), true);

                // Vérif champs email et motdepasse
                if (!isset($data['nomutile'], $data['prenomutile'],$data['email'])) {
                    http_response_code(400);
                    $response = ['status' => 400, 'message' => 'Identifiants requis'];
                    echo json_encode($response);
                    exit;
                }
                
                if (isset($data['photo']) && isset($data['nomutile']) && isset($data['prenomutile'])) {
                    // Je crée mainrenant le fichier ici
                    $filename = $data['nomutile'] . '-' . $data['prenomutile'] . '.jpg';
                    // Sauvegarde de l'image
                    $filePath = saveImage($data['photo'], $filename);   
                    $data['photo']=$filename;      
                } 
             
                $result = $user->CreerUser($data);
                if($result){
                    $response = ['status' => 200, 'message' => 'Utilisateur enregistre'];
                }
            }else {
                http_response_code(405); // methode non autorisée
                $response = ['status' => 405, 'message' => 'Méthode incorecte'];
            }

            break;
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

        default:
            $response = ['status' => 400, 'message' => 'Méthode HTTP non supportée'];
    }
} catch (Exception $e) {
    $response = ['status' => 500, 'message' => $e->getMessage()];
}

// Retourner la réponse en JSON
echo json_encode($response);


?>