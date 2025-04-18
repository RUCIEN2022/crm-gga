<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseMedical.php');

$medical = new Medical();

try {
    $actes = $medical->getListe_acte_du_mois();
    echo json_encode([
        'status' => 'success',
        'data' => $actes
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des actes.',
        'error' => $e->getMessage()
    ]);
}
?>
