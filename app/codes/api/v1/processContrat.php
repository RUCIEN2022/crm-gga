<?php

include_once("../app/codes/models/ClasseContrat.php");

if (isset($_POST["BtnSaveContrat"])) {
    $response = ["status" => "error", "message" => "Erreur inconnue."];
    // Vérif champs requis
    if (empty($_POST["typecontrat"]) || empty($_POST["client"]) || empty($_POST["gestionnaire"])) {
        $response["message"] = "Tous les champs sont obligatoires.";
        echo json_encode($response);
        exit;
    }
    $typeContrat = filter_input(INPUT_POST, "typecontrat", FILTER_SANITIZE_SPECIAL_CHARS);
    $client = filter_input(INPUT_POST, "client", FILTER_SANITIZE_NUMBER_INT);
    $gestionnaire = filter_input(INPUT_POST, "gestionnaire", FILTER_SANITIZE_NUMBER_INT);
    $numPolice = filter_input(INPUT_POST, "numpolice", FILTER_SANITIZE_SPECIAL_CHARS);
    $effectifAgent = filter_input(INPUT_POST, "effectAgent", FILTER_SANITIZE_NUMBER_INT) ?? 0;
    $effectifConj = filter_input(INPUT_POST, "effectConj", FILTER_SANITIZE_NUMBER_INT) ?? 0;
    $effectifEnf = filter_input(INPUT_POST, "effectEnf", FILTER_SANITIZE_NUMBER_INT) ?? 0;
    $effectTot = filter_input(INPUT_POST, "effectTot", FILTER_SANITIZE_NUMBER_INT) ?? 0;
    $CN = isset($_POST["CN"]) ? 1 : 0;
    $CI = isset($_POST["CI"]) ? 1 : 0;
    $couverture = $_POST["couverture"] ?? "";
    $fraisGestionGGA = filter_input(INPUT_POST, "fraisGestionGGA", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
    $tva = isset($_POST['TVA']) ? 1 : 0;
    $totalFraisGestion = filter_input(INPUT_POST, "totalFraisGestion", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
    $pource_app_fond = filter_input(INPUT_POST, "PourcmodAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
    $val_app_fond = filter_input(INPUT_POST, "ValmodAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
    $seuil = filter_input(INPUT_POST, "seuilAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
    $modfact = filter_input(INPUT_POST, "modfact", FILTER_SANITIZE_SPECIAL_CHARS);
    $idutile = $_POST["idutile"] ?? 1;

    $taux = ($tva != 1) ? 0 : 0.16;
    $taxe = $totalFraisGestion * $taux;

    $contrat = new Contrat();
    
    //format = ND/lastInsert+1 formatage à 5 chiffres/les initial du nom du client/année/les initial du nom du gestionnaire
    $ann = date('y');
    $prefix="ND";
    $lastnd=$contrat->getLastNoteDebitId();
    $idnd=str_pad($lastnd + 1, 3, '0', STR_PAD_LEFT); //formatage à 3 chiffres
    $initialesagent=$contrat->getInitialesAgent($gestionnaire);
    $initialesclient=$contrat->getInitialesClient($client);

    $numfac = $prefix."/" .$idnd. "/" .$initialesclient."/".$ann."/".$initialesagent;

    if ($typeContrat == 2) {
        do {
           
            $annee = date('y');
            $moisJour = date('md');
            $idClient = str_pad($client, 3, '0', STR_PAD_LEFT); // on formate à 3 chiffres
            $idSite =  $contrat->getIdSiteByUser($idutile);
            $site = str_pad($idSite, 3, '0', STR_PAD_LEFT);
            $lastContratId = $contrat->getLastContratId();
            $idLastContrat = str_pad($lastContratId + 1, 8, '0', STR_PAD_LEFT);
            $numPolice = $annee . $gestionnaire. '-' . $moisJour . '-' . $idClient . '-' . $site. '-'. $idLastContrat;
            // verif si existe déjà
            $existe = $contrat->verifierExistenceNumPolice($numPolice);
        } while ($existe);
    
        echo "Numéro de police généré : " . $numPolice;
    }
    
    $datacontrat = $contrat->creerPoliceContrat($client, $typeContrat, 1, $couverture, $effectTot, $numPolice, $effectifAgent, $effectifConj, $effectifEnf, $fraisGestionGGA, $totalFraisGestion, $taxe, $pource_app_fond, $val_app_fond, $seuil, $gestionnaire, $idutile, "");
    
    if (!$datacontrat) {
        $response["message"] = "Échec de la création du contrat.";
        echo json_encode($response);
        exit;
    }
    
    if ($typeContrat == 1) {
        $assureur = filter_input(INPUT_POST, "assureur", FILTER_SANITIZE_SPECIAL_CHARS);
        $reassureur = filter_input(INPUT_POST, "reassureur", FILTER_SANITIZE_SPECIAL_CHARS);
        
        $dateEffet = filter_input(INPUT_POST, "dateEffet", FILTER_SANITIZE_SPECIAL_CHARS);
        $dateEcheance = filter_input(INPUT_POST, "dateEcheance", FILTER_SANITIZE_SPECIAL_CHARS);
        $primeNette = filter_input(INPUT_POST, "primeNette", FILTER_SANITIZE_SPECIAL_CHARS);
        $accessoires = filter_input(INPUT_POST, "accessoires", FILTER_SANITIZE_SPECIAL_CHARS);
        $primeTtc = filter_input(INPUT_POST, "primeTtc", FILTER_SANITIZE_SPECIAL_CHARS);
        $intermediaire = filter_input(INPUT_POST, "intermediaire", FILTER_SANITIZE_SPECIAL_CHARS);
        $PaieSinAssureur = filter_input(INPUT_POST, "PaieSinAssureur", FILTER_SANITIZE_SPECIAL_CHARS);
        $PaieSinGGA = filter_input(INPUT_POST, "PaieSinGGA", FILTER_SANITIZE_SPECIAL_CHARS);
        $reassurance = filter_input(INPUT_POST, "reassurance", FILTER_SANITIZE_SPECIAL_CHARS);
        $QpReassureur = filter_input(INPUT_POST, "QpReassureur", FILTER_SANITIZE_SPECIAL_CHARS);
        $QpAssureur = filter_input(INPUT_POST, "QpAssureur", FILTER_SANITIZE_SPECIAL_CHARS);
                                        
        $contrat->creerPoliceAssurance($datacontrat, $assureur, $primeNette, $accessoires, $primeTtc, $intermediaire, $reassurance, $reassureur,$QpAssureur, $QpReassureur, $PaieSinAssureur, $PaieSinGGA, $dateEffet, $dateEcheance);
    } elseif ($typeContrat == 2) {
        $budgetTotal = filter_input(INPUT_POST, "budgetTotal", FILTER_SANITIZE_SPECIAL_CHARS);
        $FGIS = isset($_POST['FGIS']) ? 1 : 0;
        $modCompl = filter_input(INPUT_POST, "modCompl", FILTER_SANITIZE_SPECIAL_CHARS);
        $contrat->creerContratAutoFinance($datacontrat, $budgetTotal, $FGIS, $modCompl);
    }
    
    $fg = ($typeContrat == 1) ? ($primeNette * $fraisGestionGGA) / 100 : ($budgetTotal * $fraisGestionGGA) / 100;
    $valtaxe = $fg * $taux;
    if ($typeContrat == 1) {
        $contrat->creerFacture_FraisGGA($datacontrat, $numfac, "", $primeNette, $fg, $valtaxe, $modfact, 0, $idutile);
    } elseif ($typeContrat == 2) {
        $contrat->creerFacture_FraisGGA($datacontrat, $numfac, "", $budgetTotal, $fg, $valtaxe, $modfact, 0, $idutile);
    }
    $response = ["status" => "success", "message" => "Votre contrat est créée avec succès.", "numPolice" => $numPolice];

header("Location: success.php?message=" . urlencode($response["message"]) . "&numPolice=" . urlencode($response["numPolice"]));
exit;


    
}
?>
