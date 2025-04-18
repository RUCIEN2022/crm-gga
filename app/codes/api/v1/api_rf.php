<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Inclure la classe qui contient la méthode CreerReception_facture

include_once(__DIR__ . '/../../models/ClassAdmin.php');// adapte le chemin
$admin = new Administraction();// remplace par le nom réel de ta classe

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Dossier d'upload
//$uploadDir = __DIR__ . "/../../../../../ressources/facture/";
//$uploadDir = '/../../../../../ressources/facture/';
$uploadDir = '../../../../ressources/facture/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Vérifie que le fichier est bien présent
if (!isset($_FILES['fichier_facture'])) {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier de facture reçu']);
    exit;
}

// Gestion de l'upload
$nomFichier = time() . '_' . basename($_FILES['fichier_facture']['name']);
$cheminComplet =$uploadDir . $nomFichier;

if (!move_uploaded_file($_FILES['fichier_facture']['tmp_name'], $cheminComplet)) {
    echo json_encode(['success' => false, 'message' => 'Échec de l\'upload du fichier']);
    exit;
}

// Préparation des données
$data = [
    ':id_prestataire'     => $_POST['id_prestataire'],
    ':tp'                 => $_POST['tp'],
    ':rd'                 => $_POST['rd'],
    ':numero_facture'     => $_POST['numero_facture'],
    ':date_reception'     => $_POST['date_reception'],
    ':periode_prestation' => $_POST['periode_prestation'],
    ':moyen_reception'    => $_POST['moyen_reception'],
    ':montant_facture'    => $_POST['montant_facture'],
    ':statut'             => 1,
    ':cheminfichier'      => $nomFichier
];

// Insertion via ta fonction métier
$insertion = $admin->CreerReception_facture($data);

if ($insertion) {
    echo json_encode(['success' => true, 'message' => 'Facture enregistrée avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion dans la base de données']);
}
