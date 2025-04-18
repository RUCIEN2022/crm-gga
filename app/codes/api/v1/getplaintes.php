<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once(__DIR__ . '/../../models/ClasseMedical.php'); // ajuste le chemin si nécessaire

$medical = new Medical(); // Nom de ta classe

$data = $medical->getListe_plainte();

if ($data !== false && count($data) > 0) {
    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => "empty",
        "message" => "Aucune plainte trouvée."
    ]);
}
