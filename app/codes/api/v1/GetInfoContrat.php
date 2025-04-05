<?php
include_once("../app/codes/models/ClasseContrat.php");

if (!isset($_GET['np'])) {
    die("Erreur : Numéro de police non spécifié.");
}

$numero_police = $_GET['np'];
$contrat = new Contrat();
$conn = new connect();

// Récupérer le type de contrat
$query = "SELECT type_contrat FROM police_contrat WHERE numero_police = :numero_police";
$resultattype = $conn->fx_lecture($query, [':numero_police' => $numero_police]);

if (!$resultattype || empty($resultattype[0]['type_contrat'])) {
    die("Erreur : Type de contrat non trouvé.");
}

$type_contrat = $resultattype[0]['type_contrat'];
$data = null;

if ($type_contrat == 1) {
    $data = $contrat->FindContrats_assur($numero_police);
} elseif ($type_contrat == 2) {
    $data = $contrat->FindContrats_auto($numero_police);
}

if (!$data) {
    die("Erreur : Aucune donnée trouvée pour ce contrat.");
}

// Extraction des valeurs pour affichage
$idcontrat = $data['idcontrat'] ?? '';
$numero_police = $data['numero_police'] ?? '';
$client = $data['Client_name'] ?? 'Non défini';
$datec = $data['datecreate'] ?? 'Non défini';
$libtype=$data['libtype']?? 'Non défini';
$montant = $data['prime_ttc'] ?? ($data['budget_total'] ?? 0);
?>
