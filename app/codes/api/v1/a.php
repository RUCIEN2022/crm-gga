<?php
include_once __DIR__ . '/Config/ClasseParamDB.php';

class Contrat {
    private $conn;

    public function __construct() {
        $this->conn = new connect(); // Connexion via la classe connect de ClasseParamDB
    }

    private function executeQuery($query, $params = [], $isWrite = false) {
        try {
            if (strpos(trim(strtoupper($query)), 'SELECT') === 0) {
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
    public function creerContratAutoFinance($data) {
        $query = "INSERT INTO contrat_autofinance (
            budget_total, modalite_AF, appel_fond_init, seuil_Sinis_declenAF, frais_gest_gga, 
            modalite_facture, cocher_si_fg_index_sin, modalite_fc, datecreate, idutile
        ) VALUES (
            :budget_total, :modalite_AF, :appel_fond_init, :seuil_Sinis_declenAF,
            :modalite_facture, :cocher_si_fg_index_sin, :modalite_fc, CURRENT_TIMESTAMP, :idutile
        )";
        return $this->executeQuery($query, $data);
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

    // liste contrats autofin par agent
    public function listeGlobalContratsAutofin($idutile) {
        $query = "SELECT 
            c.idpolice, c.budget_total, c.modalite_AF, c.appel_fond_init, c.seuil_Sinis_declenAF, 
            c.frais_gest_gga, c.modalite_facture, c.cocher_si_fg_index_sin, c.modalite_fc, 
            c.cocher_couv_nat, c.cocher_couv_int, u.nomutile, u.prenomutile, u.email
        FROM contrat_autofinance AS c
        INNER JOIN utilisateur AS u ON c.idpolice = u.idutile
        WHERE u.idutile = :idutile";
        return $this->executeQuery($query, [':idutile' => $idutile]);
    }

    // Liste contrats par assureur
    public function listeContratsParAssureur($idAssureur) {
        $query = "SELECT * FROM contrat_autofinance WHERE idAssureur = :idAssureur";
        return $this->executeQuery($query, [':idAssureur' => $idAssureur]);
    }

    // total des contrats
    public function totalGlobalContrats() {
        $query = "SELECT COUNT(*) AS total_contrats FROM police_contrat";
        return $this->executeQuery($query);
    }
    // total des contrats assurance
    public function totalGlobalContratsAssurance() {
        $query = "SELECT COUNT(*) AS total_contratsAss FROM police_contrat WHERE type_contrat=1 AND etat_contrat=1";
        return $this->executeQuery($query);
    }
    // total des contrats autofin
    public function totalGlobalContratsAutoFin() {
    $query = "SELECT COUNT(*) AS total_contratsAutoFin FROM police_contrat WHERE type_contrat=2 AND etat_contrat=1";
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
        $query = "SELECT SUM(effectif_Benef) AS total_beneficiaires FROM police_contrat WHERE idpolice = :idContrat AND etat_contrat=1";
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

    //historique mouvements des effectifs
    public function historiqueMouvEffectif($idContrat) {
        $sql = "
            SELECT * 
            FROM mouvementeffect 
            WHERE idpolice = :idContrat 
            ORDER BY date_ops DESC
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
    public function etatProductionParAssureur($idAssureur) {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(budget_total) AS total_budget FROM contrat_autofinance WHERE idAssureur = :idAssureur";
        return $this->executeQuery($query, [':idAssureur' => $idAssureur]);
    }
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
    // Total couv nationale
    public function Total_Couverture_Nationale() {
        $query = "SELECT COUNT(cocher_couv_nat) AS total_couvNat FROM police_contrat ";
        return $this->executeQuery($query);
    }
    // Total couv internationale
    public function Total_Couverture_Internationale() {
        $query = "SELECT COUNT(cocher_couvr_inter) AS total_couvInterNat FROM police_contrat";
        return $this->executeQuery($query);
    }
}
?>
