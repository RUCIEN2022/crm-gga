<?php
// Autoriser l'accès depuis n'importe quel domaine (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Générer les années (par exemple de 2000 à l'année actuelle)
$annee_debut = 2010;
$annee_actuelle = (int)date("Y");

$annees = [];
for ($annee = $annee_debut; $annee <= $annee_actuelle; $annee++) {
    $annees[] = $annee;
}

// Retourner les années au format JSON
echo json_encode(["annees" => $annees]);
