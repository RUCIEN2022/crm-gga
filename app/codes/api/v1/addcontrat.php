<?php

require_once 'database.php'; // Assurez-vous que ce fichier contient la connexion PDO et executeQuery

header('Content-Type: application/json');

// Vérifier si la requête est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
    exit;
}

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['type'])) {
    echo json_encode(["status" => "error", "message" => "Données invalides"]);
    exit;
}

$type = $data['type']; // Le type d'insertion (police_contrat, contrat_autofinance, police_assurance, facture)

switch ($type) {
    case 'police_contrat':
        $requiredFields = ['idclient', 'type_contrat', 'etat_contrat', 'cocher_couvr_nat', 'cocher_couvr_inter',
            'effectif_Benef', 'numero_police', 'effectif_agent', 'effectif_conjoint', 'effectif_enfant',
            'pource_frais_gest', 'val_frais_gest', 'tva', 'gestionnaire_id', 'idutile'];
        $table = 'police_contrat';
        break;
    
    case 'contrat_autofinance':
        $requiredFields = ['idcontrat', 'budget_total', 'pource_app_fond', 'val_app_fond', 'seuil_app_fond',
            'fg_index_sin', 'modalite_compl'];
        $table = 'contrat_autofinance';
        break;
    
    case 'police_assurance':
        $requiredFields = ['idcontrat', 'idpartenaire', 'prime_nette', 'accessoire', 'prime_ttc', 'intermediaire_id',
            'cocher_reassur', 'reassureur', 'quote_part_assureur', 'quote_part_reassur', 'paie_sin_assur',
            'paie_sin_gga', 'pource_app_fond', 'val_app_fond', 'seuil_sinistre', 'dateEffet', 'dateEcheance'];
        $table = 'police_assurance';
        break;
    
    case 'facture':
        $requiredFields = ['numfact', 'idcontrat', 'amount_contrat', 'frais_gga', 'tva', 'modalite', 'etatfact', 'code', 'idutile'];
        $table = 'facture';
        $data['datefact'] = date('Y-m-d H:i:s'); // Ajouter la date actuelle
        break;
    
    default:
        echo json_encode(["status" => "error", "message" => "Type d'opération invalide"]);
        exit;
}

// Vérification des champs obligatoires
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        echo json_encode(["status" => "error", "message" => "Champ manquant : $field"]);
        exit;
    }
}

// Construction de la requête SQL dynamiquement
$columns = implode(", ", array_keys($data));
$placeholders = ":" . implode(", :", array_keys($data));
$sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

// Exécution de la requête
$result = executeQuery($sql, $data, true);
if ($result) {
    echo json_encode(["status" => "success", "message" => "Insertion réussie", "id" => $result]);
} else {
    echo json_encode(["status" => "error", "message" => "Échec de l'insertion"]);
}

/*
header("Content-Type: application/json");
include_once(__DIR__ . '/../../models/ClasseContrat.php');

// Vérifier si les données sont reçues
$data = json_decode(file_get_contents("php://input"), true);
//var_dump($data);
if (!$data) {
    echo json_encode(["status" => "error", "message" => "Données invalides"]);
    exit;
}

try {
    // Instanciation de la classe Contrat
    $contrat = new Contrat();
    // Étape 1 : Insérer police_contrat
    $resultPolice = $contrat->creerPoliceContrat($data);

    // Vérification du résultat de l'insertion
    if (!is_array($resultPolice) || !isset($resultPolice["status"])) {
        echo json_encode(["status" => "error", "message" => "Erreur de la requête : résultat inattendu pour police_contrat"]);
        exit;
    }

    if ($resultPolice["status"] !== "success") {
        echo json_encode(["status" => "error", "message" => "Échec de l'enregistrement de police_contrat"]);
        exit;
    }

    $idcontrat = $resultPolice["idcontrat"];

    // Étape 2 : Vérifier le type de contrat et insérer dans la table correspondante
    if ($data["type_contrat"] == 1) {
        // Contrat de type assurance
        $data["idcontrat"] = $idcontrat; // Ajouter idcontrat aux données
        $resultAssurance = $contrat->creerPoliceAssurance($data);

        // Vérification du résultat d'insertion dans police_assurance
        if (!is_array($resultAssurance) || !isset($resultAssurance["status"]) || $resultAssurance["status"] !== "success") {
            echo json_encode(["status" => "error", "message" => "Échec de l'enregistrement de police_assurance"]);
            exit;
        }
    } elseif ($data["type_contrat"] == 2) {
        // Contrat de type autofinance
        $data["idcontrat"] = $idcontrat;
        $resultAutoFinance = $contrat->creerContratAutoFinance($data);

        // Vérification du résultat d'insertion dans contrat_autofinance
        if (!is_array($resultAutoFinance) || !isset($resultAutoFinance["status"]) || $resultAutoFinance["status"] !== "success") {
            echo json_encode(["status" => "error", "message" => "Échec de l'enregistrement de contrat_autofinance"]);
            exit;
        }
    }

    // Étape 3 : Enregistrer la facture associée
    $data["idcontrat"] = $idcontrat;
    $resultFacture = $contrat->creerFacture_FraisGGA($data);

    // Vérification du résultat d'insertion de la facture
    if (!is_array($resultFacture) || !isset($resultFacture["status"]) || $resultFacture["status"] !== "success") {
        echo json_encode(["status" => "error", "message" => "Échec de l'enregistrement de la facture"]);
        exit;
    }

    // Réponse finale
    echo json_encode([
        "status" => "success",
        "message" => "Contrat enregistré avec succès",
        "idcontrat" => $idcontrat
    ]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Erreur serveur : " . $e->getMessage()]);
}
    */

?>
