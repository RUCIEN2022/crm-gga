<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../models/ClasseContrat.php';

if (!isset($_GET['np'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètre manquant : np']);
    exit();
}

$numeroPolice = $_GET['np'];
$contratModel = new Contrat();

// 1. Récupérer le type de contrat via la méthode
$typeContrat = $contratModel->getTypeContratByNumPolice($numeroPolice);

if (!$typeContrat) {
    http_response_code(404);
    echo json_encode(['error' => 'Type de contrat non trouvé pour cette police']);
    exit();
}

$typeContrat = strtolower($typeContrat);
if (str_contains($typeContrat, 'autofinancement')) {
    $contrat = $contratModel->FindContrats_auto($numeroPolice);

    if (!$contrat) {
        http_response_code(404);
        echo json_encode(['error' => 'Contrat autofinancé non trouvé']);
        exit();
    }

    $data = [
        'numeropolice' => $contrat['numero_police'],
        'Client_name' => $contrat['Client_name'],
        'adresse_entr' => $contrat['adresse_entr'],
        'ville_entr' => $contrat['ville_entr'],
        'dateEffet' => $contrat['datecreate'],
       // 'dateEcheance' => null,
        'prime_ttc' => $contrat['budget_total'],
        'num_nd' => $contrat['num_nd'],
        'frais_gga' => $contrat['frais_gga'] ??0,
        'tva' => $contrat['tva'] ?? 0,
        'modalite' => $contrat['modalite'],
        'effectif_Benef' => $contrat['effectif_Benef']
    ];

} else {
    $contrat = $contratModel->FindContrats_assur($numeroPolice);

    if (!$contrat) {
        http_response_code(404);
        echo json_encode(['error' => 'Contrat assuré non trouvé']);
        exit();
    }

    $data = [
        'numeropolice' => $contrat['numero_police'],
        'Client_name' => $contrat['Client_name'],
        'adresse_entr' => $contrat['adresse_entr'],
        'ville_entr' => $contrat['ville_entr'],
       // 'dateEffet' => $contrat['dateEffet'],
       // 'dateEcheance' => $contrat['dateEcheance'],
        'prime_ttc' => $contrat['prime_ttc'],
        'num_nd' => $contrat['num_nd'],
        'frais_gga' => $contrat['frais_gga'] ?? 0,
        'tva' => $contrat['tva'] ?? 0,
        'modalite' => $contrat['modalite'],
        'effectif_Benef' => $contrat['effectif_Benef']
    ];
}

echo json_encode($data);
exit();
