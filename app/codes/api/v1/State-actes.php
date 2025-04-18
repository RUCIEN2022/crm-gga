<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once(__DIR__ . '/../../models/ClasseMedical.php');

$actes = new Medical();

try {
    // Récupération des données
    $totalActes = $actes->getTotalActesDuMois();
    $totalBeneficiaires = $actes->getTotalBeneficiairesDuMois();
    $actesPlusFrequents = $actes->getNbActeLePlusFrequentDuMois(); // renvoie un tableau d'actes
    $montantTotal = $actes->getMontantTotalActesDuMois();

    // Préparation des actes fréquents (nom + fréquence)
    $listeActes = [];
    $frequence = 0;

    if (!empty($actesPlusFrequents)) {
        $frequence = $actesPlusFrequents[0]['total']; // même pour tous
        foreach ($actesPlusFrequents as $item) {
            $listeActes[] = $item['nom_acte'];
        }
    }

    $data = [
        'status' => 'success',
        'total_actes' => $totalActes[0]['total_actes'] ?? 0,
        'total_beneficiaires' => $totalBeneficiaires[0]['total_beneficiaires'] ?? 0,
        'actes_plus_frequents' => $listeActes,
        'nb_acte_plus_frequent' => $frequence,
        'montant_total' => $montantTotal[0]['montant_total'] ?? 0
    ];

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Erreur lors de la récupération des statistiques.',
        'error' => $e->getMessage()
    ]);
}
