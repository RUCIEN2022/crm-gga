<?php

include_once(__DIR__ . '/Config/ParamDB.php');

class Sinistre {
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
        $query = "SELECT COUNT(*) AS count FROM police_contrat WHERE numero_police = :numPolice";
        $params = [":numPolice" => $numPolice];
        $result = $this->executeQuery($query, $params);
    
        return $result[0]['count'] > 0;
    }

    public function fx_CreerAffectationFactures($data) {
        $query = "INSERT INTO affect_facture (
            idfacture, date_affect, idgestionnaire, datedebut, datefin,total_fact, montant_apyer,observ, statut,createby,updateby,updated_at) 
            VALUES (
            :idfacture, :date_affect, :idgestionnaire, :datedebut, :datefin, :total_fact, :montant_apyer, :observ, :statut, :createby, :updateby, :updated_at
        )";
      return $this->executeQuery($query, $data);
        
    }
     //Gestion contrat insert suspension
     public function CreerSuspensionContrat($idcontrat,$datesusp,$datereprise,$motif,$dateopera,$updateby) {
        $query = "INSERT INTO suspension (
            idcontrat,datesusp,datereprise,motif,dateopera,updateby
        ) VALUES (
           '".$idcontrat."', '".$datesusp."', '".$datereprise."', '".$motif."',CURRENT_TIMESTAMP,".$updateby."'
        )";
        $conn=new connect();
        $resultat=$conn -> fx_ecriture($query);
        if ($resultat){
            return $resultat;
        }
        else{
            return false;
        } 
    }
   
    public function listeGlobalContrats() {
        $query = "
            SELECT 
                pc.idcontrat,
                pc.numero_police,
                pc.datecreate,
                pc.couverture,
                pc.val_frais_gest,
                pc.tva,
                pc.seuil,
                pc.val_app_fond,
                ag.matagent,ag.nomagent,ag.postnomagent,ag.prenomagent,
                tc.libtype, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.effectif_Benef,
                ut.nomutile,ut.prenomutile
               
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
            INNER JOIN 
                typecontrat AS tc ON pc.type_contrat = tc.idtype
            INNER JOIN
                agent AS ag ON pc.gestionnaire_id = ag.idagent
            INNER JOIN
                utilisateur AS ut ON pc.idutile = ut.idutile
            WHERE pc.etat_contrat != 0
            LIMIT 100
        ";
      // Exécution de la requête
      $results = $this->executeQuery($query);
      if ($results && count($results) > 0) {
          return $results;
      } else {
          return []; // Retourne un tableau vide si aucun contrat n'est trouvé
      }
    }
    public function listeLastContrats() {
        $query = "
            SELECT pc.idcontrat, pc.type_contrat, pc.etat_contrat, c.idclient, c.den_social, pc.effectif_Benef, pc.val_frais_gest,pc.tva,pc.numero_police,
                pc.datecreate,ag.idagent,ag.nomagent,ag.prenomagent,tc.idtype,tc.libtype
                
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
          
            INNER JOIN 
                agent AS ag ON pc.gestionnaire_id = ag.idagent
            INNER JOIN 
                typecontrat AS tc ON pc.type_contrat = tc.idtype
            LIMIT 5
        ";
        $results = $this->executeQuery($query);
        if ($results && count($results) > 0) {
            return $results;
        } else {
            return [];
        }
    }
    public function ComboContrats() {
        $query = "
            SELECT pc.idcontrat, pc.type_contrat, pc.etat_contrat, c.idclient, c.den_social, pc.effectif_Benef, pc.val_frais_gest,pc.tva,pc.numero_police,
                pc.datecreate,ag.idagent,ag.nomagent,ag.prenomagent,tc.idtype,tc.libtype
                
            FROM 
                police_contrat AS pc
            INNER JOIN 
                client AS c ON pc.idclient = c.idclient
          
            INNER JOIN 
                agent AS ag ON pc.gestionnaire_id = ag.idagent
            INNER JOIN 
                typecontrat AS tc ON pc.type_contrat = tc.idtype
            WHERE pc.etat_contrat = 2
        ";
    
        $results = $this->executeQuery($query);
        if ($results && count($results) > 0) {
            return $results;
        } else {
            return []; // Retour tab vide si aucun contrat trouvé
        }
    }
   

    // nombre global de bénéf
    public function effectifGlobalBeneficiaires() {
        $query = "SELECT SUM(effectif_Benef) AS total_beneficiaires FROM police_contrat";
        return $this->executeQuery($query);
    }
    public function effectifGlobalBeneficiairesAssur() {
        $query = "SELECT SUM(effectif_Benef) AS total_benefAssur FROM police_contrat WHERE type_contrat=1 AND etat_contrat=2";
        return $this->executeQuery($query);
    }
    public function effectifGlobalBeneficiairesAutofin() {
        $query = "SELECT SUM(effectif_Benef) AS total_benefAutofin FROM police_contrat WHERE type_contrat=2 AND etat_contrat=2";
        return $this->executeQuery($query);
    }
    // Nombre bénéf pour un contrat spécifique
    public function totalBeneficiairesParContrat($idContrat) {
        $query = "SELECT SUM(effectif_Benef) AS total_beneficiaires 
        FROM police_contrat WHERE idpolice = :idContrat AND etat_contrat=2";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    
    // Suspendre contrat etat_contrat=2
    public function suspendreContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = 3 WHERE idcontrat = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    // Résilier contrat etat_contrat=0
    public function resilierContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = 3 WHERE idcontrat = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
    }
    // Réactiver contrat etat_contrat=1
    public function reactiverContrat($idContrat) {
        $query = "UPDATE police_contrat SET etat_contrat = 2 WHERE idcontrat = :idContrat LIMIT 1";
        return $this->executeQuery($query, [':idContrat' => $idContrat]);
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
 

    public function getGestionnaire() {
        $query = "SELECT * FROM agent";
        return $this->executeQuery($query);
    }
    public function getListe_facture_niv_med(){ 
        $query = "SELECT 
        rf.id_facture, 
        rf.tp, 
        rf.rd, 
        rf.numero_facture, 
        rf.date_reception, 
        rf.periode_prestation, 
        rf.moyen_reception, 
        rf.montant_facture, 
        p.id_prestataire,
        p.nom_prestataire, 
        tf.idtraitement,
        tf.datedebut,
        tf.datefin,
        tf.statut,
        tf.updated_at,
        tf.obs, 
        a.nomagent AS Nom_medecin,
        a.prenomagent AS Prenom_medecin
        FROM reception_facture rf
        JOIN prestataires p ON rf.id_prestataire = p.id_prestataire
        JOIN traitementfacture tf ON tf.idfacture = rf.id_facture
        JOIN agent a ON tf.idmedecin = a.idagent
        WHERE tf.statut = 1";
        return $this->executeQuery($query);
    }
    public function getListe_traitement_sinistre(){ 
        $query = "SELECT 
    af.idaffect,
    af.date_affect,
    af.datedebut,
    af.datefin,
    af.total_fact,
    af.montant_apyer,
    af.observ,
    af.statut,
    af.updated_at,
    rf.id_facture,
    rf.tp,
    rf.rd,
    rf.numero_facture,
    rf.date_reception,
    rf.periode_prestation,
    rf.moyen_reception,
    p.nom_prestataire,
    ag.prenomagent AS prenom_gestionnaire,
    ag.nomagent AS nom_gestionnaire
FROM 
    affect_facture af
LEFT JOIN 
    reception_facture rf ON af.idfacture = rf.id_facture
LEFT JOIN 
    prestataires p ON rf.id_prestataire = p.id_prestataire
LEFT JOIN 
    agent ag ON af.idgestionnaire = ag.idagent
GROUP BY 
    af.idaffect
ORDER BY 
    af.date_affect DESC

    ";
        return $this->executeQuery($query);
    }
    public function updateStatutTraitementFacture() {
        $currentDate = date('Y-m-d');
        $query = "UPDATE affect_facture
                  SET statut = CASE 
                                WHEN statut = 1 AND '$currentDate' > datefin THEN 4
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
    public function getTotalFactAffect() {
        $query = "SELECT COUNT(*) AS total_fact
                  FROM affect_facture";
        return $this->executeQuery($query);
    }
   
    public function getTotalFactEncours() {
        $query = "SELECT COUNT(*) AS total_encours FROM affect_facture WHERE statut = 1";
        return $this->executeQuery($query);
    }
    
    public function getTotalFactTraitee() {
        $query = "SELECT COUNT(*) AS total_traitee FROM affect_facture WHERE statut = 2";
        return $this->executeQuery($query);
    }
    
    public function getTotalFactEnRetard() {
        $query = "SELECT COUNT(*) AS total_retard FROM affect_facture WHERE statut = 4";
        return $this->executeQuery($query);
    }
    
    public function getTotalFactRejetee() {
        $query = "SELECT COUNT(*) AS total_rejetee FROM affect_facture WHERE statut = 3";
        return $this->executeQuery($query);
    }
    public function getTotalFactRetard() {
        $query = "SELECT COUNT(*) AS total_retard FROM affect_facture WHERE statut = 4";
        return $this->executeQuery($query);
    }
    
    
    

}
?>
