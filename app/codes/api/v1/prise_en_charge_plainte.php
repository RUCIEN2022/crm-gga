<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseMedical.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $idplainte = $data['idplainte'] ?? null;

    if ($idplainte) {
        $plainte = new Medical(); // Remplacez par le nom réel de votre classe

        $success = $plainte->Prise_en_charge_plainte($idplainte);

        if ($success) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Plainte prise en charge avec succès.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur lors de la validation de la plainte.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de traitement manquant.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Méthode non autorisée.'
    ]);
}
