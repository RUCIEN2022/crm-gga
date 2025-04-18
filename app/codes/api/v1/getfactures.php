<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseMedical.php');
$fact = new Medical();

$factures = $fact->getListe_facture();

echo json_encode(['data' => $factures]);
