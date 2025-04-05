<?php
header('Access-Control-Allow-Origin: *'); // Permet à toutes les origines d'accéder à l'API
header('Access-Control-Allow-Headers: Content-Type');
require_once '../../models/ClasseContrat.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['code'])) {
        $code = $_GET['code'];
        $contrat = new Contrat();
        $result = $contrat->FindContrats($code);

        if (!empty($result)) {
            echo json_encode(['success' => true, 'data' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Aucun contrat trouvé']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Paramètre "code" manquant']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
