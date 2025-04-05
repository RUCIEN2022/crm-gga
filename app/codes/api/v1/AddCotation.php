<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once __DIR__ . '/../../models/ClasseContrat.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Données invalides"]);
    exit;
}

try {
    $contrat = new Contrat();
    
    $result = $contrat->insertCotation(
        date('Y-m-d H:i:s'),
        $data['nomClient'],
        $data['societeClient'],
        $data['emailClient'],
        $data['telClient'],
        $data['typecontrat'],
        $data['dateDebut'],
        $data['dateFin'],
        $data['nbBeneficiaires'],
        $data['budgetEstime'],
        $data['couverture'],
        $data['frequencePaiement'],
        $data['modePaiement'],
        $data['conditionsSpecifiques'],
        1
    );
    
    if ($result) {
        echo json_encode(["status" => "success", "message" => "Cotation enregistrée avec succès"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Échec de l'enregistrement"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

