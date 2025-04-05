<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
require_once '../../models/ClasseContrat.php';

$cotation = new Contrat();
$result = $cotation->listCotation();

if (!empty($result)) {
    echo json_encode([
        "status" => "success",
        "data" => $result
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Aucune cotation trouvée"
    ]);
}