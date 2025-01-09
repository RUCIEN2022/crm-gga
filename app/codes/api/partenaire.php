<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once("../models/ClassPartenaire.php");

// je gère les réponses d'erreur ici
function handleApiErrorResponse($message) {
    $response = [
        'error' => true,
        'message' => $message
    ];
    
    echo json_encode($response);
    exit; // fin affichage de l'erreur
}
// je Valide les paramètres
function getValidatedInput($input, $requiredParams) {
    $errors = [];
    $data = [];

    foreach ($requiredParams as $param) {
        if (!isset($input[$param])) {
            $errors[] = "Le paramètre '$param' est requis.";
        } else {
            $data[$param] = $input[$param]; // je Stocke les données valides
        }
    }

    return [
        'data' => $data,
        'errors' => $errors
    ];
}
    try{
            // Récup data JSON envoyées
            $input = json_decode(file_get_contents('php://input'), true);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($input['denom_social']) && isset($input['pays_assu']) && isset($input['ville_assu']) && isset($input['adresse_assu']) && isset($input['code_interne']) && isset($input['numeroAgree']) && isset($input['Rccm']) && isset($input['numero_impot'])&& isset($input['emailEntre']) && isset($input['telephone_Entr']) && isset($input['nomRespo']) && isset($input['emailRespo']) && isset($input['TelephoneRespo']) && isset($input['etatpartenaire'])) {
                    // Validation des autres paramètres
                    $requiredParams = ["denom_social", "pays_assu", "ville_assu", "adresse_assu", "code_interne", "numeroAgree", "Rccm", "numero_impot", "emailEntre", "telephone_Entr", "nomRespo", "emailRespo", "TelephoneRespo", "etatpartenaire"];   
                    // Validation des autres paramètres requis
                    $validationResult = getValidatedInput($input, $requiredParams);
                    if (!empty($validationResult['errors'])) {
                        throw new Exception(implode(", ", $validationResult['errors']));
                    } 
                    $data = $validationResult['data'];
                    $partenaire = new Partenaire();
                    // Insertion des données
                    $resultat = $partenaire->fx_CreerPartenaire($data['denom_social'], $data['pays_assu'], $data['ville_assu'], $data['adresse_assu'], $data['code_interne'], $data['numeroAgree'], $data['Rccm'], $data['numero_impot'], $data['emailEntre'], $data['telephone_Entr'], $data['nomRespo'], $data['emailRespo'], $data['TelephoneRespo'], $data['etatpartenaire']);

                    if (!$resultat) {
                        throw new Exception('Erreur lors de l\'insertion des données.');
                    }
                    // Réponse JSON avec succès pour l'app externe
                    $response = [
                        'status' => [
                            'code' => 200,
                            'message' => 'Succès'
                        ]
                    ];

                    echo json_encode($response);
                
                    
                }
                
            }else {
                throw new Exception('Requête non valide. Seules les requêtes POST sont acceptées.', 405);
            }


    }catch(Exception $e){

        handleApiErrorResponse($e->getMessage());
    }

?>