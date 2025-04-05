<?php 

header('Content-Type: application/json');
require_once '../../models/ClasseContrat.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        // Pour debug local (tu peux commenter en production)
         file_put_contents("debug.log", print_r($data, true));
          // Vérification et nettoyage selon l'opération choisie
        if ($data['type_operation'] === 'ajout') {
            unset($data['nbragent']);
            unset($data['nbrconj']);
            unset($data['nbrenf']);
        } elseif ($data['type_operation'] === 'retrait') {
            // Ajouter une valeur par défaut ou effectuer des vérifications supplémentaires
            if (empty($data['nbragent'])) $data['nbragent'] = 0;
            if (empty($data['nbrconj'])) $data['nbrconj'] = 0;
            if (empty($data['nbrenf'])) $data['nbrenf'] = 0;
        }

        if (!$data || !isset($data['type_operation'])) {
            echo json_encode([
                "success" => false,
                "message" => "Données invalides ou champ 'type_operation' manquant"
            ]);
            exit;
        }

        // tu peux forcer une valeur si besoin, sinon garde celle reçue
        $data['typecontrat'] = $data['typecontrat'] ?? 1;

        $operation = new Contrat();
        $result = $operation->TraiterOperationContrat($data);

        echo json_encode($result);

    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Erreur serveur : " . $e->getMessage()
        ]);
    }
}


?>
