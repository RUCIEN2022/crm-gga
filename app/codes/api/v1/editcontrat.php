<?php
include_once("../app/codes/models/ClasseContrat.php");

// Vérifier si c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'opération à effectuer
    $operation = $_POST['operation'] ?? '';
    $idcontrat = $_POST['idcontrat'] ?? '';
    $montantPrime = $_POST['montantPrime'] ?? 0;
    $effectifs = $_POST['effectifs'] ?? 0;

    // Instancier l'objet Contrat
    $contrat = new Contrat();
    
    // Déclencher l'action appropriée en fonction de l'opération
    switch ($operation) {
        case 'ajout':
            // Appeler la méthode pour l'ajout des bénéficiaires et mettre à jour la prime
            $resultat = $contrat->CreerMouvementContrat($idcontrat, $effectifs, 'ajout');
            $contrat->majPrimeAssurance($idcontrat, $montantPrime, 'ajout');
            break;

        case 'retrait':
            // Appeler la méthode pour le retrait des bénéficiaires et mettre à jour la prime
            $resultat = $contrat->CreerMouvementContrat($idcontrat, $effectifs, 'retrait');
            $contrat->majPrimeAssurance($idcontrat, $montantPrime, 'retrait');
            break;

        case 'suspension':
            // Appeler la méthode pour la suspension du contrat
            $resultat = $contrat->CreerSuspensionContrat($idcontrat);
            break;

        case 'resiliation':
            // Appeler la méthode pour la résiliation du contrat
            $resultat = $contrat->CreerResilisation($idcontrat);
            break;

        default:
            $resultat = false;
            break;
    }

    // Retourner le résultat en JSON
    if ($resultat) {
        echo json_encode(['success' => true, 'message' => 'Opération effectuée avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors du traitement de la demande']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>
