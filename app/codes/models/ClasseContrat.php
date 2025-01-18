<?php

include_once(__DIR__ . '/Config/ParamDB.php');

class Contrat {
    private $conn;

    public function __construct() {
        $this->conn = new connect(); // Connexion via la classe connect de ClasseParamDB
    }

    // cette methode va nous aider à gerer les operations de lecture et ecriture sur la bdd
    //$query =chaine qui va contenir la requete et $params=2e parametre de la methode qui va contenir les parametres de ma requete
    private function executeQuery($query, $params = [], $isWrite = false) {
        try {
            if (strpos(trim(strtoupper($query)), 'SELECT') === 0) {// ici on se rassure que la chaine commence par le mot SELECT et est convertie en majuscule en trimant la chaine
                return $this->conn->fx_lecture($query, $params); // Lecture
            } else {
                return $this->conn->fx_ecriture($query, $params); // Écriture
            }
        } catch (Exception $e) {
            // En cas d'erreur, retourne false
            return false;
        }
    }

    // Création contrat autofin
    public function creerContratAutoFinance($data) {//data sera notre tableau qui va recevoir les données de paramètre
        $query = "INSERT INTO contrat_autofinance (
            budget_total, modalite_AF, appel_fond_init, seuil_Sinis_declenAF, frais_gest_gga, 
            modalite_facture, cocher_si_fg_index_sin, modalite_fc, datecreate, idutile
        ) VALUES (
            :budget_total, :modalite_AF, :appel_fond_init, :seuil_Sinis_declenAF,
            :modalite_facture, :cocher_si_fg_index_sin, :modalite_fc, CURRENT_TIMESTAMP, :idutile
        )";
        return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut
    }

    // Création police d'assurance
    public function creerPoliceAssurance($data) {
        $query = "INSERT INTO police_assurance (
            effectif_agent, effectif_conjoint, effectif_enfant, effectif_Benef, date_effet, 
            date_echeance, numero_police, prime_nette, accessoire, prime_ttc, 
            intermediaire, cocher_reassur, reassureur, quote_part_assureur, frais_gest_gga, 
            appel_fond_initial, seuil_sinistre_declen_AF, datecreatenuserid
        ) VALUES (
            :effectif_agent, :effectif_conjoint, :effectif_enfant, :effectif_Benef, :date_effet, 
            :date_echeance, :numero_police, :prime_nette, :accessoire, :prime_ttc, 
            :intermediaire, :cocher_reassur, :reassureur, :quote_part_assureur, 
            :appel_fond_initial, :seuil_sinistre_declen_AF,CURRENT_TIMESTAMP, :idutile
        )";
        return $this->executeQuery($query, $data);
    }

    // Création contrat de police
    public function creerPoliceContrat($data) {
        $query = "INSERT INTO police_contrat (
            idclient, code_partenaire, type_contrat, etat_contrat,frais_gest_gga,cocher_couv_nat,cocher_couvr_inter
        ) VALUES (
            :idclient, :code_partenaire, :type_contrat, :etat_contrat, :frais_gest_gga, :cocher_couv_nat, :cocher_couvr_inter
        )";
        return $this->executeQuery($query, $data);
    }
    // mise à jour police contrat
    public function fx_UpdateContrat($data) {
        $Rqte = "UPDATE police_contrat SET ";
        $dataset = [];
        $params = [];
        foreach ($data as $key => $value) {
            if ($key !== 'idpolice') {
                $dataset[] = "$key = :$key";
            }
            $params[$key] = $value;
        }
        $Rqte .= implode(', ', $dataset) . " WHERE idpolice = :idpolice";
        return $this->executeQuery($Rqte, $params);
    }
   
    public function fx_DeleteContrat($id) {
        $Rqte = "DELETE FROM police_contrat WHERE idpolice = :idpolice";
        $params = ['idpolice' => $id];
        return $this->executeQuery($Rqte, $params);
    }    
    public function listeGlobalContrats($offset = 0, $limit = 50) {
        $query = "
            SELECT 
                pc.idpolice, 
                pc.type_contrat, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.cocher_couvr_nat, 
                pc.cocher_couvr_inter, 
                pc.effectif_Benef, 
                pc.frais_gest_gga, 
                p.denom_social
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
            INNER JOIN 
                partenaire AS p ON pc.code_partenaire = p.idpartenaire
            LIMIT :offset, :limit
        ";
        return $this->executeQuery($query, ['offset' => $offset, 'limit' => $limit]);
    }
    
    public function FindContrats($code) {
        $query = "
            SELECT 
                pc.idpolice, 
                pc.type_contrat, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.cocher_couvr_nat, 
                pc.cocher_couvr_inter, 
                pc.effectif_Benef, 
                pc.frais_gest_gga, 
                p.denom_social
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
            INNER JOIN 
                partenaire AS p ON pc.code_partenaire = p.idpartenaire
            WHERE 
                pc.idpolice = :code
        ";
        return $this->executeQuery($query, ['code' => $code]);
    }
    
   
    public function listeGlobalContratsAutofin() {
        $query = "
            SELECT 
                pc.idpolice, 
                pc.type_contrat, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.cocher_couvr_nat, 
                pc.cocher_couvr_inter, 
                pc.effectif_Benef, 
                pc.frais_gest_gga, 
                p.denom_social
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
            INNER JOIN 
                partenaire AS p ON pc.code_partenaire = p.idpartenaire
            WHERE 
                pc.type_contrat = :type_contrat
        ";
        return $this->executeQuery($query, ['type_contrat' => 2]);
    }
    
// liste contrats assurance
public function listeGlobalContratsAssur() {
    $query = "
        SELECT 
            pc.idpolice, 
            pc.type_contrat, 
            pc.etat_contrat, 
            c.idclient, 
            c.den_social, 
            c.pays_entr, 
            c.ville_entr, 
            pc.cocher_couvr_nat, 
            pc.cocher_couvr_inter, 
            pc.effectif_Benef, 
            pc.frais_gest_gga, 
            p.denom_social
        FROM 
            police_contrat AS pc
        INNER JOIN 
            client AS c ON pc.idclient = c.idclient
        INNER JOIN 
            partenaire AS p ON pc.code_partenaire = p.idpartenaire
        WHERE 
            pc.type_contrat = :type_contrat
    ";
    return $this->executeQuery($query, ['type_contrat' => 1]);
}



public function listeContratsParAssureur($idAssureur) {
    $query = "
        SELECT 
            pc.idpolice, 
            pc.type_contrat, 
            pc.etat_contrat, 
            pc.cocher_couvr_nat, 
            pc.cocher_couvr_inter, 
            pc.effectif_Benef, 
            pc.frais_gest_gga, 
            c.idclient, 
            c.den_social, 
            c.pays_entr, 
            c.ville_entr, 
            p.denom_social
        FROM 
            police_contrat AS pc
        INNER JOIN 
            client AS c ON pc.idclient = c.idclient
        INNER JOIN 
            partenaire AS p ON pc.code_partenaire = p.idpartenaire
        WHERE 
            pc.code_partenaire = :idAssureur
    ";
    return $this->executeQuery($query, ['idAssureur' => $idAssureur]);
}


    // total des contrats
    public function totalGlobalContrats() {
        $query = "SELECT COUNT(*) AS total_contrats FROM police_contrat";
        return $this->executeQuery($query);
    }
    // total des contrats
    public function totalNewContrats() {
        $query = "SELECT COUNT(*) AS total_newcontrats FROM police_contrat WHERE etat_contrat=0";
        return $this->executeQuery($query);
    }
    // total des contrats assurance
    public function totalGlobalContratsAssurance() {
        $query = "SELECT COUNT(*) AS total_contratsAss FROM police_contrat WHERE type_contrat=1 AND etat_contrat=1";
        return $this->executeQuery($query);
    }
    // Total des contrats d'assurance pour le mois en cours
public function totalGlobalContratsAssuranceMoisEncours() {
    $query = "
        SELECT COUNT(*) AS total_contratsAss_mois
        FROM police_contrat
        WHERE type_contrat = 1
          AND etat_contrat = 1
          AND MONTH(datecreate) = MONTH(CURRENT_DATE())
          AND YEAR(datecreate) = YEAR(CURRENT_DATE())
    ";
    return $this->executeQuery($query);
}

    // total des contrats autofin
    public function totalGlobalContratsAutoFin() {
    $query = "SELECT COUNT(*) AS total_contratsAutoFin FROM police_contrat WHERE type_contrat=2 AND etat_contrat=1";
    return $this->executeQuery($query);
    }
    public function totalGlobalContratsAutoFinMoisEncours() {
        $query = "
            SELECT COUNT(*) AS total_contratsAss_mois
            FROM police_contrat
            WHERE type_contrat = 2
              AND etat_contrat = 1
              AND MONTH(datecreate) = MONTH(CURRENT_DATE())
              AND YEAR(datecreate) = YEAR(CURRENT_DATE())
        ";
        return $this->executeQuery($query);
    }
    // total des contrats totalGlobalContratsVoyage
    public function totalGlobalContratsVoyage() {
        // à ajouter plus tard
        }
    // total des contrats totalGlobalContratsVie
    public function totalGlobalContratsVie() {
        // à ajouter plus tard
        }

    // nombre global de bénéf
    public function effectifGlobalBeneficiaires() {
        $query = "SELECT SUM(effectif_Benef) AS total_beneficiaires FROM police_contrat";
        return $this->executeQuery($query);
    }
    public function effectifGlobalBeneficiairesAssur() {
        $query = "SELECT SUM(effectif_Benef) AS total_benefAssur FROM police_contrat WHERE type_contrat=1 etat_contrat=1";
        return $this->executeQuery($query);
    }
    public function effectifGlobalBeneficiairesAutofin() {
        $query = "SELECT SUM(effectif_Benef) AS total_benefAutofin FROM police_contrat WHERE type_contrat=2 AND etat_contrat=1";
        return $this->executeQuery($query);
    }
    // Nombre bénéf pour un contrat spécifique
    public function totalBeneficiairesParContrat($idContrat) {
        $query = "SELECT SUM(effectif_Benef) AS total_beneficiaires 
        FROM police_contrat WHERE idpolice = :idContrat AND etat_contrat=1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    
    // Suspendre contrat etat_contrat=2
    public function suspendreContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = '2' WHERE idpolice = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    // Résilier contrat etat_contrat=0
    public function resilierContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = '0' WHERE idpolice = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    // Réactiver contrat etat_contrat=1
    public function reactiverContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = '1' WHERE idpolice = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }

    // Ajouter bénéf d'un contrat
    public function ajouterBeneficiaire($idContrat, $nombre) {
        try {
            $this->conn->beginTransaction();
            // Mise à jour de l'effectif
            $rqtUpdate = "UPDATE police_contrat SET effectif_Benef = effectif_Benef + :nombre WHERE idpolice = :idContrat";
            $paramsUpdate = [':nombre' => $nombre, ':idContrat' => $idContrat];
            $this->executeQuery($rqtUpdate, $paramsUpdate, true);

            // Insert historique mouv
            $rqtstory = "INSERT INTO mouvementeffect (idpolice, type_ops, nombre, date_ops) VALUES (:idContrat, 'Ajout', :nombre, CURRENT_TIMESTAMP)";
            $paramStory = [':idContrat' => $idContrat, ':nombre' => $nombre];
            $this->executeQuery($rqtstory, $paramStory, true);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Erreur lors de l'ajout des bénéficiaires : " . $e->getMessage());
        }
    }

    // Retrait bénéf d'un contrat
    public function retraitBeneficiaire($idContrat, $nombre) {
        try {
            $this->conn->beginTransaction();
            // Mise à jour de l'effectif
            $rqtUpdate = "UPDATE police_assurance SET effectif_Benef = effectif_Benef - :nombre WHERE idpolice = :idContrat";
            $paramsUpdate = [':nombre' => $nombre, ':idContrat' => $idContrat];
            $this->executeQuery($rqtUpdate, $paramsUpdate, true);

            // Insertion historique effectif benef
            $rqtstory = "INSERT INTO mouvementeffect (idpolice, type_ops, nombre, date_ops) VALUES (:idContrat, 'Retrait', :nombre, CURRENT_TIMESTAMP)";
            $paramStory = [':idContrat' => $idContrat, ':nombre' => $nombre];
            $this->executeQuery($rqtstory, $paramStory, true);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Erreur lors du retrait des bénéficiaires : " . $e->getMessage());
        }
    }

    //historique mouvements des effectifs d'un contrat
    public function historiqueMouvEffectif($idContrat) {
        $sql = "
            SELECT 
                me.idmou AS id_mouvement,
                me.idpolice AS id_contrat,
                me.typeops AS type_operation,
                me.nombre AS effectif_modifie,
                me.date_ops AS date_operation
            FROM 
                mouvementeffect AS me
            WHERE 
                me.idpolice = :idContrat
            ORDER BY 
                me.date_ops DESC
        ";
        $params = [':idContrat' => $idContrat];
        return $this->executeQuery($sql, $params);
    }
    
// -----------------------------Reporting-------------------------------------------------
    // Rapt global Production
    public function rapportGlobalProduction() {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(budget_total) AS total_budget FROM contrat_autofinance";
        return $this->executeQuery($query);
    }

    // Rapt production par site
    public function rapportProductionParSite($idsite) {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(budget_total) AS total_budget FROM contrat_autofinance WHERE idsite = :idsite";
        return $this->executeQuery($query, [':idsite' => $idsite]);
    }
    // Rapt production par agent
    public function rapportProductionParAgent($idsite, $idagent) {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(budget_total) AS total_budget FROM contrat_autofinance WHERE idsite = :idsite AND idutile = :idagent";
        return $this->executeQuery($query, [':idsite' => $idsite, ':idagent' => $idagent]);
    }
    // Etat prod par assureur
    public function etatEtChiffreAffaireParAssureur() {
        $sql = "
            SELECT 
                p.denom_social AS assureur,
                COUNT(pc.idpolice) AS total_contrats,
                SUM(CASE 
                    WHEN pc.etat_contrat = 'actif' THEN 1 
                    ELSE 0 
                END) AS contrats_actifs,
                SUM(CASE 
                    WHEN pc.etat_contrat = 'expiré' THEN 1 
                    ELSE 0 
                END) AS contrats_expires,
                SUM(pc.frais_gest_gga) AS chiffre_affaire
            FROM 
                police_contrat pc
            JOIN 
                partenaire p ON pc.code_partenaire = p.idpartenaire
            GROUP BY 
                p.denom_social
            ORDER BY 
                chiffre_affaire DESC
        ";
        return $this->executeQuery($sql);
    }
//analyse comparative de chaque etat de production
public function analyseComparativeParAssureur() {
    $sql = "
        SELECT 
            p.denom_social AS assureur,
            COUNT(pc.idpolice) AS total_contrats,
            SUM(pc.frais_gest_gga) AS chiffre_affaire
        FROM 
            police_contrat pc
        JOIN 
            partenaire p ON pc.code_partenaire = p.idpartenaire
        GROUP BY 
            p.denom_social
        ORDER BY 
            p.denom_social, total_contrats DESC
    ";
    
    // Exécution de la requête
    $result = $this->executeQuery($sql); // Remplacez avec la méthode adéquate pour exécuter la requête
    
    // Retour des données sous forme de tableau
    return $result;
}


/*
public function analyseComparativeParAssureur() {
    $sql = "
        SELECT 
            p.denom_social AS assureur,
            COUNT(pc.idpolice) AS total_contrats,
            SUM(pc.frais_gest_gga) AS chiffre_affaire
        FROM 
            police_contrat pc
        JOIN 
            partenaire p ON pc.code_partenaire = p.idpartenaire
        GROUP BY 
            p.denom_social
        ORDER BY 
            p.denom_social, total_contrats DESC
    ";
    return $this->executeQuery($sql);
}
    */

    // Total FG previsionnel
    public function TotalFrais_de_Gestion_prevision() {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(frais_gest_gga) AS frais_gest FROM police_contrat WHERE etat_contrat = 1";
        return $this->executeQuery($query);
    }
    // Total FG perçu *** J'y reviendrai lors de la mise en place du module finance ***
    public function TotalFrais_de_Gestion_perçu() {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(frais_gest_gga) AS frais_gest FROM police_contrat WHERE etat_contrat = 1";
        return $this->executeQuery($query);
    }
    public function Total_Couverture_Nationale() {
        $query = "SELECT SUM(cocher_couvr_nat) AS total_couvNat FROM police_contrat";
        return $this->executeQuery($query);
    }
    public function Total_Couverture_Internationale() {
        $query = "SELECT SUM(cocher_couvr_inter) AS total_couvInterNat FROM police_contrat";
        return $this->executeQuery($query);
    }
    public function getTotalTaches() {
        $query = "SELECT COUNT(*) AS total_taches FROM taches";
        return $this->executeQuery($query);
    }

    public function getTachesEnCours() {
        $query = "SELECT * FROM taches WHERE statut = '1'";
        return $this->executeQuery($query);
    }

    public function getTachesTerminees() {
        $query = "SELECT * FROM taches WHERE statut = '2'";
        return $this->executeQuery($query);
    }

    public function getTachesRetard() {
        $query = "SELECT * FROM taches WHERE statut = '1' AND datelimite < CURDATE()";
        return $this->executeQuery($query);
    }
    public function getTypeContrat() {
        $query = "SELECT * FROM typecontrat";
        return $this->executeQuery($query);
    }
    public function getGestionnaire() {
        $query = "SELECT * FROM agent";
        return $this->executeQuery($query);
    }

}
?>
