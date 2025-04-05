<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClasseContrat.php');

$contrat = new Contrat(); // Instancier la classe

// Vérifier l'action envoyée en AJAX
$action = $_GET['action'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = $_POST;

    switch ($action) { 
        case "police_contrat":
            $idContrat = $contrat->creerPoliceContrat($data);
            if ($idContrat) {
                echo json_encode(["status" => "success", "idcontrat" => $idContrat]);
            } else {
                echo json_encode(["status" => "error"]);
            }
            break;

        case "police_assurance":
            $res = $contrat->creerPoliceAssurance($data);
            echo json_encode($res);
            break;

        case "contrat_autofinance":
            $res = $contrat->creerContratAutoFinance($data);
            echo json_encode($res);
            break;

        case "facture":
            $res = $contrat->creerFacture_FraisGGA($data);
            echo json_encode($res);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Action inconnue"]);
            break;
    }
}
?>
