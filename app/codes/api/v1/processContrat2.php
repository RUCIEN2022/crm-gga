<?php
include_once("../app/codes/models/ClasseContrat.php"); // Inclusion de la classe Contrat

// Vérifier si le bouton de sauvegarde a été cliqué
if (isset($_POST["BtnSaveContrat"])) {
    $formulaire_value = true;
    $msgErreur = ""; // Message d'erreur par défaut

    // Vérification des champs requis
    if (empty($_POST["typecontrat"]) || empty($_POST["client"]) || empty($_POST["gestionnaire"]) || empty($_POST["numpolice"])) {
        $msgErreur = "Tous les champs sont obligatoires.";
    } else {
        // Récupération sécurisée des données
        $typeContrat = filter_input(INPUT_POST, "typecontrat", FILTER_SANITIZE_SPECIAL_CHARS);
        $client = filter_input(INPUT_POST, "client", FILTER_SANITIZE_NUMBER_INT);
        $gestionnaire = filter_input(INPUT_POST, "gestionnaire", FILTER_SANITIZE_NUMBER_INT);
        $numPolice = filter_input(INPUT_POST, "numpolice", FILTER_SANITIZE_SPECIAL_CHARS);
        $effectifAgent = filter_input(INPUT_POST, "effectAgent", FILTER_SANITIZE_NUMBER_INT) ?? 0;
        $effectifConj = filter_input(INPUT_POST, "effectConj", FILTER_SANITIZE_NUMBER_INT) ?? 0;
        $effectifEnf = filter_input(INPUT_POST, "effectEnf", FILTER_SANITIZE_NUMBER_INT) ?? 0;
        $CN = isset($_POST["CN"]) ? 1 : 0; // Valeur 1 si sélectionné
        $CI = isset($_POST["CI"]) ? 1 : 0; // Valeur 1 si sélectionné
        $fraisGestionGGA = filter_input(INPUT_POST, "fraisGestionGGA", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
        $TVA = filter_input(INPUT_POST, "TVA", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
        $PourcmodAppelFonds = filter_input(INPUT_POST, "PourcmodAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
        $ValmodAppelFonds = filter_input(INPUT_POST, "ValmodAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
        $seuilAppelFonds = filter_input(INPUT_POST, "seuilAppelFonds", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?? 0;
        $idUtilisateur = $_POST["idutile"] ?? 1; // ID utilisateur (par défaut 1)
        $couverture = $_POST["couverture"] ?? ""; // CN ou CI

        // Création de l'objet Contrat
        $contrat = new Contrat();

        // 1. Enregistrement du contrat principal (Table police_contrat)
        $dataPoliceContrat = [
            "client" => $client,
            "typecontrat" => $typeContrat,
            "couverture" => $couverture,
            "effectTot" => $effectifAgent + $effectifConj + $effectifEnf,
            "numpolice" => $numPolice,
            "effectAgent" => $effectifAgent,
            "effectConj" => $effectifConj,
            "effectEnf" => $effectifEnf,
            "gestionnaire" => $gestionnaire,
            "fraisGestionGGA" => $fraisGestionGGA,
            "TVA" => $TVA,
            "PourcmodAppelFonds" => $PourcmodAppelFonds,
            "ValmodAppelFonds" => $ValmodAppelFonds,
            "seuilAppelFonds" => $seuilAppelFonds,
            "idutile" => $idUtilisateur
        ];

        // Enregistrement du contrat principal
        $idContrat = $contrat->creerPoliceContrat($dataPoliceContrat);

        if ($idContrat) {
            // 2. Enregistrement du contrat spécifique (Assurance ou Autofinancement)
            if ($typeContrat == 1) { // Contrat d'assurance
                $dataAssurance = [
                    "assureur" => filter_input(INPUT_POST, "assureur", FILTER_SANITIZE_SPECIAL_CHARS),
                    "primeNette" => filter_input(INPUT_POST, "primeNette", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "accessoires" => filter_input(INPUT_POST, "accessoires", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "primeTtc" => filter_input(INPUT_POST, "primeTtc", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "intermediaire" => filter_input(INPUT_POST, "intermediaire", FILTER_SANITIZE_SPECIAL_CHARS),
                    "reassurance" => isset($_POST["reassurance"]) ? 1 : 0,
                    "reassureur" => filter_input(INPUT_POST, "reassureur", FILTER_SANITIZE_SPECIAL_CHARS),
                    "QpAssureur" => filter_input(INPUT_POST, "QpAssureur", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "QpReassureur" => filter_input(INPUT_POST, "QpReassureur", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "PaieSinAssureur" => filter_input(INPUT_POST, "PaieSinAssureur", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "PaieSinGGA" => filter_input(INPUT_POST, "PaieSinGGA", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "dateEffet" => filter_input(INPUT_POST, "dateEffet", FILTER_SANITIZE_SPECIAL_CHARS),
                    "dateEcheance" => filter_input(INPUT_POST, "dateEcheance", FILTER_SANITIZE_SPECIAL_CHARS)
                ];
                $resultat = $contrat->creerPoliceAssurance($dataAssurance);
            } elseif ($typeContrat == 2) { // Contrat Autofinancement
                $dataAutoFinance = [
                    "budgetTotal" => filter_input(INPUT_POST, "budgetTotal", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "FGIS" => filter_input(INPUT_POST, "FGIS", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "modCompl" => filter_input(INPUT_POST, "modCompl", FILTER_SANITIZE_SPECIAL_CHARS)
                ];
                $resultat = $contrat->creerContratAutoFinance($dataAutoFinance);
            } else {
                $msgErreur = "Type de contrat invalide.";
            }

            if ($resultat) {
                // 3. Enregistrement de la facture associée
                $dataFacture = [
                    "numfact" => "FACT-" . time(),
                    "idcontrat" => $idContrat,
                    "amount_contrat" => filter_input(INPUT_POST, "amount_contrat", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    "frais_gga" => $fraisGestionGGA,
                    "tva" => $TVA,
                    "modalite" => filter_input(INPUT_POST, "modalite", FILTER_SANITIZE_SPECIAL_CHARS),
                    "etatfact" => "En attente",
                    "code" => md5(time()) // Génération d'un code unique
                ];

                $factureAjoutee = $contrat->creerFacture_FraisGGA($dataFacture);

                if ($factureAjoutee) {
                    // Redirection après l'ajout de la facture
                    var_dump($idContrat);
exit();
                    header("Location: confirmation.php?idcontrat=" . $idContrat);
                    exit();
                } else {
                    $msgErreur = "Erreur lors de l'enregistrement de la facture.";
                }
            } else {
                $msgErreur = "Erreur lors de l'enregistrement du contrat spécifique.";
            }
        } else {
            $msgErreur = "Erreur lors de l'enregistrement du contrat principal.";
        }
    }

    // Affichage des erreurs, s'il y en a
    if (!empty($msgErreur)) {
        echo "<p style='color:red;'>$msgErreur</p>";
    }
}
?>
