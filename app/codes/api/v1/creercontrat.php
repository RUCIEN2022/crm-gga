<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// En-têtes pour les CORS et le type de réponse
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Inclure la classe Contrat
include_once(__DIR__ . '/../../models/ClasseContrat.php');

// Vérification de la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

$response = ['status' => 404, 'message' => 'Endpoint non trouvé']; // Réponse par défaut

// Vérification si la méthode est POST
if ($method === 'POST') {
    try {
        // Récupérer les données JSON envoyées dans la requête
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data) {
            throw new Exception("Données JSON invalides.");
        }

        // Vérifier que les données du contrat sont présentes
        if (!isset($data['contrat']) || !is_array($data['contrat'])) {
            throw new Exception("Les données du contrat sont obligatoires et doivent être sous forme de tableau.");
        }

        // Extraire les données du contrat
        $contratData = $data['contrat'];

        // Vérification des champs obligatoires
        if (empty($contratData['type_contrat'])) {
            throw new Exception("Le type du contrat est obligatoire.");
        }

        // Créer une instance de la classe Contrat
        $contrat = new Contrat();

        // Génération des données de la facture
        $factureData = [
            'numfact'      => uniqid('FACT-'),
            'amount_contrat' => $contratData['budget_total'] ?? ($contratData['prime_ttc'] ?? 0),
            'frais_gga'    => $contratData['totalFraisGestion'] ?? 0,
            'tva'          => $contratData['tva'] ?? 0,
            'modalite'     => $contratData['fraisGestionGGA'] ?? 0,
            'etatfact'     => '1',
            'code'         => uniqid('pc-'),
            'idutile'      => $contratData['idutile'] ?? 0
        ];

        // Appeler la méthode pour enregistrer le contrat et la facture
        $result = $contrat->enregistrerContrat($contratData, $factureData);

        // Vérification du résultat
        if (!isset($result['success']) || !$result['success']) {
            throw new Exception("Erreur lors de la création du contrat : " . ($result['message'] ?? 'Erreur inconnue'));
        }

        // Réponse de succès
        http_response_code(201);
        echo json_encode([
            "success"  => true,
            "message"  => "Contrat, police et facture enregistrés avec succès.",
            "idcontrat" => $result['idcontrat'],
            "numfact"  => $factureData['numfact']
        ]);

    } catch (Exception $e) {
        // Gestion des erreurs
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
} else {
    // Si la méthode n'est pas POST
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Méthode HTTP non autorisée. Utilisez POST."
    ]);
}

