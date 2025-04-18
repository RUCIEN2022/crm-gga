<?php 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseMedical.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $fact = new Medical();

    try {
        $fact->updateStatutTraitementFacture();
        $data = $fact->getListe_traitement_facture();
        if ($data) {
            echo json_encode(["success" => true, "data" => $data]);
        } else {
            echo json_encode(["success" => false, "message" => "Aucune donnée trouvée."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour des statuts: " . $e->getMessage()]);
        exit;
    }

    
}

?>