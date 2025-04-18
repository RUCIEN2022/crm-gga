<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

include_once(__DIR__ . '/../../models/ClasseContrat.php');

try {
    $contrat = new Contrat();

    // Collecte des statistiques existantes
    $totalContrats = $contrat->totalGlobalContrats() ?? 0;
    $totalNewContrats = $contrat->totalNewContrats() ?? 0;
    $fraisGestion = $contrat->TotalFrais_de_Gestion_prevision() ?? 0;
    $totalBeneficiaires = $contrat->effectifGlobalBeneficiaires() ?? 0;

    $totalContratsAssurance = $contrat->totalGlobalContratsAssurance() ?? 0;
    $contratsAssuranceMois = $contrat->totalGlobalContratsAssuranceMoisEncours() ?? 0;

    $totalContratsAutofinance = $contrat->totalGlobalContratsAutoFin() ?? 0;
    $contratsAutofinMois = $contrat->totalGlobalContratsAutoFinMoisEncours() ?? 0;
    $couvnat = $contrat->Total_Couverture_Nationale() ?? 0;
    $couvinter = $contrat->Total_Couverture_Internationale() ?? 0;

    $totalcotation = $contrat->countCotation() ?? 0;
    
    $taches = [
        'total' => $contrat->getTotalTaches() ?? 0,
        'en_cours' => $contrat->getTachesEnCours() ?? 0,
        'terminees' => $contrat->getTachesTerminees() ?? 0,
        'retard' => $contrat->getTachesRetard() ?? 0,
    ];
    
    $couverture = [
        'nationale' => $contrat->Total_Couverture_Nationale() ?? 0,
        'internationale' => $contrat->Total_Couverture_Internationale() ?? 0,
    ];

    // Appel de la méthode analyseComparativeParAssureur de la classe Contrat
    $assureursData = $contrat->analyseComparativeParAssureur();
    $autofinData = $contrat->analyseContratAutofinancement();

    // Structure de la réponse avec l'analyse comparative
    $response = [
        'success' => true,
        'data' => [
            'totalContrats' => $totalContrats,
            'totalNewContrats' => $totalNewContrats,
            'fraisGestion' => $fraisGestion,
            'totalBeneficiaires' => $totalBeneficiaires,
            'totalContratsAssurance' => $totalContratsAssurance,
            'contratsAssuranceMois' => $contratsAssuranceMois,
            'totalContratsAutofinance' => $totalContratsAutofinance,
            'contratsAutofinMois' => $contratsAutofinMois,
            'couvnat' => $couvnat,
            'couvinter' => $couvinter,
            'taches' => $taches,
            'couverture' => $couverture,
            'totalcotation' => $totalcotation,

            'analyseAssureurs' => $assureursData,
            'analyseAutofin' => $autofinData
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
