<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseSinistre.php');

$fact = new Sinistre();

try {

    $totalFact = $fact->getTotalFactAffect();
    $totalEncours = $fact->getTotalFactEncours(); 
    $totalTraitee = $fact->getTotalFactTraitee();
    $totalRetard = $fact->getTotalFactEnRetard();
    $totalRejetee = $fact->getTotalFactRejetee();
    $totalRetard = $fact->getTotalFactRetard();


    $data = [
        'status' => 'success',
        'total_fact' => $totalFact[0]['total_fact'] ?? 0,
        'total_encours' => $totalEncours[0]['total_encours'] ?? 0,
        'total_traitee' => $totalTraitee[0]['total_traitee'] ?? 0,
        'total_retard' => $totalRetard[0]['total_retard'] ?? 0,
        'total_retard' => $totalRetard[0]['total_retard'] ?? 0,
    ];

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des statistiques.',
        'error' => $e->getMessage()
    ]);
}
