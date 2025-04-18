<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseSinistre.php');
$fact = new Sinistre();

$factures = $fact->getListe_facture_niv_med();

echo json_encode(['data' => $factures]);
