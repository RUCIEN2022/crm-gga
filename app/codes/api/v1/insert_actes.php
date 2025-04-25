<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseMedical.php');
$chemin = __DIR__ . "/../../../../../ressources/";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = ['zactes', 'nom_assure', 'contrat', 'montant', 'date_soin', 'prestataire', 'iduser'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
            exit;
        }
    }

    $data = [
        'num_contrat' => $_POST['contrat'],
        'nom_acte' => $_POST['zactes'],
        'beneficiaire_acte' => $_POST['nom_assure'],
        'id_prestataire' => $_POST['prestataire'],
        'montant_acte' => str_replace(',', '.', $_POST['montant']),
        'date_soin' => $_POST['date_soin'],
        'iduser' => $_POST['iduser'],
        'datesave' => date('Y-m-d H:i:s')
    ];

    $ajoutacte = new Medical();
    $result = $ajoutacte->fx_EnregistrerActe($data);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Acte enregistré avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement.']);
    }
}
