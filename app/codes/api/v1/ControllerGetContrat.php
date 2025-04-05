<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/ClasseContrat.php';
    
        
        $numeroPolice = $_GET['np'];
        $contratModel = new Contrat();
        $result = $contratModel->FindContrats($numeroPolice);

        if (!$result) {
            http_response_code(404);
            echo json_encode(["error" => "Contrat non trouvé"]);
            exit();
        }

        // Si le contrat est trouvé, retournez les données sous un format structuré
        // Supposons que la méthode `FindContrats()` retourne un tableau d'objets ou un tableau associatif
        $contrat = $result[0]; // Si `FindContrats()` retourne un tableau, on prend le premier élément
        
        // Structure des données à retourner
        $data = [
            'Client_name' => $contrat['Client_name'],
            'adresse_entr' => $contrat['adresse_entr'],
            'ville_entr' => $contrat['ville_entr'],
            'dateEffet' => $contrat['dateEffet'],
            'dateEcheance' => $contrat['dateEcheance'],
            'prime_ttc' => $contrat['prime_ttc'],
           
            'num_nd' => $contrat['num_nd'],
            'frais_gga' => $contrat['frais_gga'],
            'tva' => $contrat['tva'],
            'modalite' => $contrat['modalite'],
            'effectif_Benef' => $contrat['effectif_Benef']
        ];

        echo json_encode($data);
        exit();
?>
