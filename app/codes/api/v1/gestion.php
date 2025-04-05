<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseContrat.php');
$contrat = new Contrat();

try {
    // Collecte des statistiques existantes
    $totalContrats = $contrat->totalGlobalContrats() ?? 0;
    $encours = $contrat->totalContrats_encours() ?? 0;
    $suspendus = $contrat->totalContrats_suspension() ?? 0;
    $attentes = $contrat->totalContrats_attentes() ?? 0;
    $list = [
        'listcontrat' => $contrat->listeLastContrats() ?? null,
    ];
    // Structure de la réponse avec l'analyse comparative
    $response = [
        'success' => true,
        'data' => [
            'totalContrats' => $totalContrats,
            'encours' => $encours,
            'suspendus' => $suspendus,
            'attentes' => $attentes,
            'listcontrat' => $list,
        ],
    ];

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Une erreur est survenue. Veuillez réessayer plus tard.',
        'error' => $e->getMessage() // Désactiver dans la version de production
    ]);
}
?>
