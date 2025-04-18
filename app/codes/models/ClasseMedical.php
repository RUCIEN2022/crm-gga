<?php
date_default_timezone_set('Africa/Kinshasa'); // ou 'UTC', selon ton besoin

include_once(__DIR__ . '/Config/ParamDB.php');

class Medical {
    private $conn;

    public function __construct() {
        $this->conn = new connect();
    }

   
    private function executeQuery($query, $params = [], $isWrite = false) {
        try {
            // Vérif si $params est bien un tableau
            if (!is_array($params)) {
                error_log("Erreur : \$params n'est pas un tableau ! Valeur actuelle : " . print_r($params, true));
                $params = [];
            }
    
            if (strpos(trim(strtoupper($query)), 'SELECT') === 0) {
                return $this->conn->fx_lecture($query, $params);
            } else {
                return $this->conn->fx_ecriture($query, $params);
            }
        } catch (Exception $e) {
            error_log("Exception capturée dans executeQuery : " . $e->getMessage());
            return false;
        }
    }
    
    public function verifierExistenceNumPolice($numPolice) {
        $query = "
            SELECT COUNT(*) AS count
            FROM police_contrat
            WHERE numero_police = :numPolice
        ";
        $result = $this->executeQuery($query, ['numPolice' => $numPolice]);
        return $result && $result[0]['count'] > 0;
    }

    public function fx_CreerTraitementFactures($data) {
        $query = "INSERT INTO traitementfacture (
            idfacture, datedebut, datefin, idmedecin, datecreate,createby, statut,updated_at, obs) 
            VALUES (
            :idfacture, :datedebut, :datefin, :idmedecin, :datecreate, :createby, :statut, :updated_at, :obs
        )";
      return $this->executeQuery($query, $data);
        
    }
    public function fx_EnregistrerPlainte($data) {
        $query = "INSERT INTO plainte (
            date_reception, datesaisie, type_plaignant, nom_plaignant, cat_plainte,idmedecin, descript,moyen, statut,date_update) 
            VALUES (
            :date_reception, :datesaisie, :type_plaignant, :nom_plaignant, :cat_plainte, :idmedecin, :descript, :moyen, :statut, :date_update
        )";
      return $this->executeQuery($query, $data);
        
    }
    public function fx_EnregistrerActe($data) {
        $query = "INSERT INTO actes (
            num_contrat, nom_acte, beneficiaire_acte, id_prestataire, montant_acte, date_soin,iduser, datesave) 
            VALUES (
            :num_contrat, :nom_acte, :beneficiaire_acte, :id_prestataire, :montant_acte, :date_soin, :iduser, :datesave
        )";
      return $this->executeQuery($query, $data);
        
    }
    public function getListe_acte_du_mois(){ 
        $query = "SELECT 
        a.idacte,
        a.nom_acte,
        a.num_contrat,
        a.beneficiaire_acte,
        a.montant_acte,
        a.date_soin,
        a.datesave,
        ag.idagent,
        ag.nomagent,
        ag.postnomagent,
        ag.prenomagent,
        p.nom_prestataire
    FROM 
        actes AS a
    INNER JOIN 
        agent AS ag ON a.iduser = ag.idagent
    INNER JOIN 
        prestataires AS p ON a.id_prestataire = p.id_prestataire
    WHERE 
        MONTH(a.date_soin) = MONTH(CURDATE())
        AND YEAR(a.date_soin) = YEAR(CURDATE())

        ";
        return $this->executeQuery($query);
    }
    public function getTotalActesDuMois() {
        $query = "SELECT COUNT(*) AS total_actes
                  FROM actes
                  WHERE MONTH(date_soin) = MONTH(CURDATE())
                  AND YEAR(date_soin) = YEAR(CURDATE())";
        return $this->executeQuery($query);
    }
    public function getTotalBeneficiairesDuMois() {
        $query = "SELECT COUNT(DISTINCT beneficiaire_acte) AS total_beneficiaires
                  FROM actes
                  WHERE MONTH(date_soin) = MONTH(CURDATE())
                  AND YEAR(date_soin) = YEAR(CURDATE())";
        return $this->executeQuery($query);
    }
    public function getNbActeLePlusFrequentDuMois() {
        $query = "SELECT nom_acte, COUNT(*) AS total
                  FROM actes
                  WHERE MONTH(date_soin) = MONTH(CURDATE())
                  AND YEAR(date_soin) = YEAR(CURDATE())
                  GROUP BY nom_acte
                  ORDER BY total DESC
                  LIMIT 1";
        return $this->executeQuery($query);
    }
    public function getActeLePlusFrequentDuMois() {
        $query = "SELECT nom_acte, COUNT(*) AS total
                  FROM actes
                  WHERE MONTH(date_soin) = MONTH(CURDATE())
                  AND YEAR(date_soin) = YEAR(CURDATE())
                  GROUP BY nom_acte
                  HAVING COUNT(*) = (
                      SELECT MAX(frequence) FROM (
                          SELECT COUNT(*) AS frequence
                          FROM actes
                          WHERE MONTH(date_soin) = MONTH(CURDATE())
                          AND YEAR(date_soin) = YEAR(CURDATE())
                          GROUP BY nom_acte
                      ) AS sous_requete
                  )";
        return $this->executeQuery($query);
    }
    
    public function getMontantTotalActesDuMois() {
        $query = "SELECT SUM(montant_acte) AS montant_total
                  FROM actes
                  WHERE MONTH(date_soin) = MONTH(CURDATE())
                  AND YEAR(date_soin) = YEAR(CURDATE())";
        return $this->executeQuery($query);
    }
    
    public function getListe_plainte(){ 
        $query = "SELECT 
            p.idplainte,
            p.date_reception,
            p.datesaisie,
            p.type_plaignant,
            p.nom_plaignant,
            p.cat_plainte,
            p.descript,
            p.moyen,
            p.statut,
            p.date_update,
            a.nomagent,
            a.postnomagent,
            a.prenomagent
        FROM 
            plainte AS p
        INNER JOIN 
            agent AS a ON p.idmedecin = a.idagent
        ";
        return $this->executeQuery($query);
    }
//combo medecin
public function getMedecins() {
    $query = "
        SELECT idagent, nomagent,postnomagent,prenomagent FROM agent";
        return $this->executeQuery($query);
}
//prestataires
public function getPrestataires() {
    $query = "
        SELECT id_prestataire, nom_prestataire, adresse, contact, email, rib FROM prestataires";
        return $this->executeQuery($query);
}

public function getListe_facture(){ 
    $query = "SELECT id_facture, tp, rd, numero_facture, date_reception, periode_prestation, moyen_reception, montant_facture, prestataires.id_prestataire,prestataires.nom_prestataire 
    FROM reception_facture, prestataires
    WHERE reception_facture.id_prestataire=prestataires.id_prestataire";
    return $this->executeQuery($query);
}
public function getListe_traitement_facture(){ 
    $query = "SELECT 
    tf.idtraitement,
    tf.datedebut,
    tf.datefin,
    tf.datecreate,
    tf.updated_at,
    tf.statut,
    tf.obs,
    rf.tp,
    rf.rd,
    rf.numero_facture,
    rf.date_reception,
    rf.periode_prestation,
    rf.montant_facture,
    p.nom_prestataire,
    ag.prenomagent AS prenom_medecin,
    ag.nomagent AS nom_medecin
FROM 
    traitementfacture tf
LEFT JOIN 
    reception_facture rf ON tf.idfacture = rf.id_facture
LEFT JOIN 
    prestataires p ON rf.id_prestataire = p.id_prestataire
LEFT JOIN 
    agent ag ON tf.idmedecin = ag.idagent
ORDER BY 
    tf.datecreate DESC
";
    return $this->executeQuery($query);
}
public function updateStatutTraitementFacture() {
    $currentDate = date('Y-m-d');
    $query = "UPDATE traitementfacture
              SET statut = CASE 
                            WHEN statut = 1 AND '$currentDate' > datefin THEN 3
                            ELSE statut
                          END,
                  updated_at = '$currentDate'
              WHERE statut = 1 AND '$currentDate' > datefin";

    return $this->executeQuery($query);
}
public function updateTraitementFacture($idtt) {
    $currentDate = date('Y-m-d H:i:s');
    $query = "UPDATE traitementfacture
              SET statut = 2, obs = :obs, updated_at = :updated_at
              WHERE idtraitement = :idtt";

    $params = [
        ':obs' => 'RAS',
        ':updated_at' => $currentDate,
        ':idtt' => $idtt
    ];

    return $this->executeQuery($query, $params);
}

public function RejeterFacture($idtt, $observation) {
    $currentDate = date('Y-m-d H:i:s');
    $query = "UPDATE traitementfacture
              SET statut = 4,
                  obs = :obs,
                  updated_at = :updated_at
              WHERE idtraitement = :idtt";

    $params = [
        ':idtt' => $idtt,
        ':obs' => $observation,
        ':updated_at' => $currentDate
    ];

    return $this->executeQuery($query, $params);
}

public function Prise_en_charge_plainte($idplainte) {
    $currentDate = date('Y-m-d H:i:s');
    $statut = 2;
    $query = "UPDATE plainte
              SET statut = :statut,
                  date_update = :date_update
              WHERE idplainte = :idplainte";

    $params = [
        ':statut' => $statut,
        ':date_update' => $currentDate,
        ':idplainte' => $idplainte,
    ];

    return $this->executeQuery($query, $params);
}
public function Traitement_plainte($idplainte) {
    $currentDate = date('Y-m-d H:i:s');
    $statut = 3;
    $query = "UPDATE plainte
              SET statut = :statut,
                  date_update = :date_update
              WHERE idplainte = :idplainte";

    $params = [
        ':statut' => $statut,
        ':date_update' => $currentDate,
        ':idplainte' => $idplainte,
    ];

    return $this->executeQuery($query, $params);
}


public function getFactureDetails($idtt) {
    $query = "SELECT 
        tf.idtraitement,
        tf.datedebut,
        tf.datefin,
        tf.datecreate,
        tf.updated_at,
        tf.statut,
        tf.obs,
        rf.tp,
        rf.rd,
        rf.numero_facture,
        rf.date_reception,
        rf.periode_prestation,
        rf.montant_facture,
        p.nom_prestataire,
        ag.prenomagent AS prenom_medecin,
        ag.nomagent AS nom_medecin
    FROM 
        traitementfacture tf
    LEFT JOIN 
        reception_facture rf ON tf.idfacture = rf.id_facture
    LEFT JOIN 
        prestataires p ON rf.id_prestataire = p.id_prestataire
    LEFT JOIN 
        agent ag ON tf.idmedecin = ag.idagent
    WHERE 
        tf.idtraitement = :idtt";  // Correction du nom de table et de l'alias

    $params = [':idtt' => $idtt];
    
    // Exécuter la requête et retourner les résultats
    $result = $this->executeQuery($query, $params);
    return $result ? $result[0] : null; // Retourne le premier résultat ou null si rien n'est trouvé
}



   
}
?>
