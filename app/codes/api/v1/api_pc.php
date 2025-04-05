<?php
include_once("../../models/ClassFinance.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée. Utilisez GET."]);
    exit;
}

$contrat = new Finance();
$resultats = $contrat->ComboContrats();
$formattedData = [];

if (!empty($resultats)) {
    foreach ($resultats as $contrat) {
        $formattedData[] = [
            "id" => $contrat['idcontrat'],
            "label" => $contrat['numero_police'] . " - " . $contrat['den_social'] . " (" . $contrat['libtype'] . ")"
        ];
    }

    echo json_encode(["success" => true, "data" => $formattedData]);
} else {
    echo json_encode(["success" => false, "message" => "Aucun contrat trouvé"]);
}


