<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once(__DIR__ . '/../../models/ClasseContrat.php');

// Lire les données reçues (application/json ou formulaire classique)
$data = $_POST;
if (empty($data)) {
    $data = json_decode(file_get_contents("php://input"), true);
}

$response = ["status" => "error", "message" => "Erreur inconnue."];

// Vérification des champs requis
if (empty($data["typecontrat"]) || empty($data["client"]) || empty($data["gestionnaire"])) {
    $response["message"] = "Tous les champs sont obligatoires.";
    echo json_encode($response);
    exit;
}

// Récupération et nettoyage
$typeContrat = $data["typecontrat"];
$client = $data["client"];
$gestionnaire = $data["gestionnaire"];
$numPolice = $data["numpolice"] ?? '';
$effectifAgent = $data["effectAgent"] ?? 0;
$effectifConj = $data["effectConj"] ?? 0;
$effectifEnf = $data["effectEnf"] ?? 0;
$effectTot = $data["effectTot"] ?? 0;
$CN = !empty($data["CN"]) ? 1 : 0;
$CI = !empty($data["CI"]) ? 1 : 0;
$couverture = $data["couverture"] ?? '';
$fraisGestionGGA = $data["fraisGestionGGA"] ?? 0;
$tva = !empty($data["TVA"]) ? 1 : 0;
$totalFraisGestion = $data["totalFraisGestion"] ?? 0;
$pource_app_fond = $data["PourcmodAppelFonds"] ?? 0;
$val_app_fond = $data["ValmodAppelFonds"] ?? 0;
$seuil = $data["seuilAppelFonds"] ?? 0;
$modfact = $data["modfact"] ?? '';
$idutile = $data["idutile"] ?? 1;

// Calcul TVA
$taux = $tva ? 0.16 : 0;
$taxe = $totalFraisGestion * $taux;

$contrat = new Contrat();
$ann = date('y');
$prefix = "ND";
$lastnd = $contrat->getLastNoteDebitId();
$idnd = str_pad($lastnd + 1, 3, '0', STR_PAD_LEFT);
$initialesagent = $contrat->getInitialesAgent($gestionnaire);
$initialesclient = $contrat->getInitialesClient($client);
$numfac = $prefix."/" .$idnd. "/" .$initialesclient."/".$ann."/".$initialesagent;

// Génération auto du numéro de police
if ($typeContrat == 2) {
    do {
        $annee = date('y');
        $moisJour = date('md');
        $idClient = str_pad($client, 3, '0', STR_PAD_LEFT);
        $idSite =  $contrat->getIdSiteByUser($idutile);
        $site = str_pad($idSite, 3, '0', STR_PAD_LEFT);
        $lastContratId = $contrat->getLastContratId();
        $idLastContrat = str_pad($lastContratId + 1, 8, '0', STR_PAD_LEFT);
        $numPolice = $annee . $gestionnaire. '-' . $moisJour . '-' . $idClient . '-' . $site. '-'. $idLastContrat;
        $existe = $contrat->verifierExistenceNumPolice($numPolice);
    } while ($existe);
}

// Création du contrat
$datacontrat = $contrat->creerPoliceContrat($client, $typeContrat, 1, $couverture, $effectTot, $numPolice, $effectifAgent, $effectifConj, $effectifEnf, $fraisGestionGGA, $totalFraisGestion, $taxe, $pource_app_fond, $val_app_fond, $seuil, $gestionnaire, $idutile, "");

if (!$datacontrat) {
    $response["message"] = "Échec de la création du contrat.";
    echo json_encode($response);
    exit;
}

// Compléments par type
if ($typeContrat == 1) {
    $contrat->creerPoliceAssurance(
        $datacontrat,
        $data["assureur"] ?? "",
        $data["primeNette"] ?? 0,
        $data["accessoires"] ?? 0,
        $data["primeTtc"] ?? 0,
        $data["intermediaire"] ?? "",
        $data["reassurance"] ?? "",
        $data["reassureur"] ?? "",
        $data["QpAssureur"] ?? 0,
        $data["QpReassureur"] ?? 0,
        $data["PaieSinAssureur"] ?? 0,
        $data["PaieSinGGA"] ?? 0,
        $data["dateEffet"] ?? "",
        $data["dateEcheance"] ?? ""
    );
} elseif ($typeContrat == 2) {
    $contrat->creerContratAutoFinance(
        $datacontrat,
        $data["budgetTotal"] ?? 0,
        !empty($data["FGIS"]) ? 1 : 0,
        $data["modCompl"] ?? ""
    );
}

// Création de facture
$base = $typeContrat == 1 ? ($data["primeNette"] ?? 0) : ($data["budgetTotal"] ?? 0);
$fg = ($base * $fraisGestionGGA) / 100;
$valtaxe = $fg * $taux;

$contrat->creerFacture_FraisGGA($datacontrat, $numfac, "", $base, $fg, $valtaxe, $modfact, 0, $idutile);

$response = [
    "status" => "success",
    "message" => "Votre contrat $numPolice est créé avec succès. Une note de débit est générée.",
    "numPolice" => $numPolice
];

echo json_encode($response);
exit;
?>
