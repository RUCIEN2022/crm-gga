<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseMedical.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $idtt = $data['idtt'] ?? null;
    $motif = $data['motif'] ?? null;

    if (!$idtt || !$motif) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de traitement ou motif de rejet manquant.'
        ]);
        exit;
    }

    $traitement = new Medical();
    $facture = $traitement->getFactureDetails($idtt);

    if ($facture) {
        $numFacture = $facture['numero_facture'];

        $success = $traitement->RejeterFacture($idtt, $motif);

        if ($success) {
            echo json_encode([
                'status' => 'success',
                'message' => 'La Facture ' . $numFacture . ' est rejetée.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur lors du rejet de la facture.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Facture non trouvée.'
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Méthode non autorisée.'
    ]);
}
