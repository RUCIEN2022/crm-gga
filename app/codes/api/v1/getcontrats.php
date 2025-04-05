<?php
require_once '../../models/ClasseContrat.php'; // Classe Contrat

header('Content-Type: application/json');

try {
    // Instancier la classe Contrat
    $contrat = new Contrat();

    // Récupérer les paramètres d'offset et de limite
   // $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
   // $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;

    // Appeler la méthode existante
    $contrats = $contrat->listeGlobalContrats();

    // Envoyer les données JSON
    echo json_encode(['status' => 'success', 'data' => $contrats]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
