<?php
session_start(); // Important pour accéder à $_SESSION

// Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include_once(__DIR__ . '/../../models/ClasseSinistre.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id_facture'], $data['numero_facture'], $data['date_debut'], $data['date_fin'], $data['gestionnaire'])) {
        echo json_encode(['success' => false, 'message' => 'Données incomplètes.']);
        exit;
    }
    $fact = new Sinistre();

    $payload = [
        'idfacture'   => $data['id_facture'],
        'date_affect'  => date('Y-m-d H:i:s'),
        'idgestionnaire'   => $data['gestionnaire'],
        'datedebut'   => $data['date_debut'],
        'datefin'     => $data['date_fin'],
        'total_fact' => $data['montant_facture'],
        'montant_apyer' => 0,
        'observ' => "RAS",
        'statut'      => 1,
        'createby'    => $_SESSION['user_id'], // ici tu utilises la session
        'updateby'  => $_SESSION['user_id'],
        'updated_at' => date('Y-m-d H:i:s'),
        
    ];   

    $result = $fact->fx_CreerAffectationFactures($payload);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Traitement enregistré avec succès"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'enregistrement"]);
    }
}
