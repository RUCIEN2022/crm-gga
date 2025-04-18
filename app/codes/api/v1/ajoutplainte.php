<?php
session_start(); // Important pour accéder à $_SESSION

// Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once(__DIR__ . '/../../models/ClasseMedical.php'); // assurez-vous du chemin du fichier

$medical = new Medical(); // Nom de la classe

// Recevoir les données du formulaire via POST
$data = [
    'date_reception' => $_POST['dateReception'],
    'datesaisie' => date('Y-m-d H:i:s'),
    'type_plaignant' => $_POST['typePlaignant'],
    'nom_plaignant' => $_POST['nomPlaignant'],
    'cat_plainte' => $_POST['categoriePlainte'],
    'idmedecin' => $_SESSION['user_id'], 
    'descript' => $_POST['descriptionPlainte'],
    'moyen' => $_POST['moyendecontact'],
    'statut' => 1,
    'date_update' => date('Y-m-d H:i:s'),
];

$insertResult = $medical->fx_EnregistrerPlainte($data);

if ($insertResult) {
    echo json_encode([
        "status" => "success",
        "message" => "Plaint enregistrée avec succès"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Une erreur est survenue, réessayez plus tard."
    ]);
}
?>
