<?php
header("Content-Type: application/json");
require_once "../app/codes/models/ClasseContrat.php"; // Ajuste le chemin selon ton projet

// Vérifier si la requête est bien une requête POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Lire les données JSON envoyées par AJAX
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);

    // Vérifier si les données sont bien reçues
    if ($data === null) {
        echo json_encode(["success" => false, "message" => "Données JSON invalides"]);
        exit;
    }

    try {
        // Instancier la classe Contrat (Assure-toi que la connexion à la BD est bien définie)
        $contrat = new Contrat();
        
        // Appeler la méthode pour enregistrer le contrat
        $response = $contrat->enregistrerContrat($data);

        // Retourner la réponse en JSON
        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>
