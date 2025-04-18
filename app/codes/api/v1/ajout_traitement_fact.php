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


include_once(__DIR__ . '/../../models/ClasseMedical.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['idfacture'], $data['date_debut'], $data['date_fin'], $data['idmedecin'])) {
        echo json_encode(['success' => false, 'message' => 'Données incomplètes.']);
        exit;
    }
    $fact = new Medical();

    $payload = [
        'idfacture'   => $data['idfacture'],
        'datedebut'   => $data['date_debut'],
        'datefin'     => $data['date_fin'],
        'idmedecin'   => $data['idmedecin'],
        'datecreate'  => date('Y-m-d H:i:s'),
        'createby'    => $_SESSION['user_id'], // ici tu utilises la session
        'statut'      => 1,
        'updated_at'  => date('Y-m-d H:i:s'),
        'obs'         => "RAS"
    ];   

    $result = $fact->fx_CreerTraitementFactures($payload);

    if ($result) {
        echo json_encode(["success" => true, "message" => "Traitement enregistré avec succès"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'enregistrement"]);
    }
}
