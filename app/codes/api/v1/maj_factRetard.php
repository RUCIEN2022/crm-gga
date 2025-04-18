<?php 

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseSinistre.php');

try {
    $factureManager = new Sinistre();
    $result = $factureManager->updateStatutTraitementFacture();

    echo json_encode([
        'success' => true,
        'message' => 'Mise à jour des statuts effectuée avec succès.',
        'result' => $result
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de la mise à jour.',
        'error' => $e->getMessage()
    ]);
}

?>