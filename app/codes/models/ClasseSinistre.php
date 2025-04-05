<?php

include_once(__DIR__ . '/Config/ParamDB.php');

class Contrat {
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
    
  
    public function fx_CreerClient($data) {
        $query = "INSERT INTO client (
            idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, 
            telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat, RCCM, numeroimpot, emailclient) 
            VALUES (
            :idsite, :den_social, :pays_entr, :ville_entr, :adresse_entr, :code_interne, :id_nat, 
            :telephone_client, :nom_respon, :email_respon, :telephone_respo, :numclasseur, :datecrea, :etat, :RCCM, :numeroimpot, :emailclient
        )";
      return $this->executeQuery($query, $data);
        
    }
    
public function creerPoliceContrat($idclient, $type_contrat, $etat_contrat, $couverture, $effectif_Benef, $numero_police, 
$effectif_agent, $effectif_conjoint, $effectif_enfant, $pource_frais_gest, 
$val_frais_gest, $tva, $pource_app_fond, $val_app_fond, $seuil, $gestionnaire_id, $idutile, $datecreate) {
    $sql = "INSERT INTO police_contrat 
        (idclient, type_contrat, etat_contrat, couverture, effectif_Benef, numero_police, 
         effectif_agent, effectif_conjoint, effectif_enfant, pource_frais_gest, 
         val_frais_gest, tva, pource_app_fond, val_app_fond, seuil, gestionnaire_id, idutile, datecreate) 
    VALUES 
        ('".$idclient."', '".$type_contrat."', '".$etat_contrat."', '".$couverture."', '".$effectif_Benef."', 
         '".$numero_police."', '".$effectif_agent."', '".$effectif_conjoint."', '".$effectif_enfant."', 
         '".$pource_frais_gest."', '".$val_frais_gest."', '".$tva."', '".$pource_app_fond."', '".$val_app_fond."', '".$seuil."', '".$gestionnaire_id."', '".$idutile."', CURRENT_TIMESTAMP)";
    //echo $sql;
    $conn=new connect();// preperation de la conexion
		$resultat=$conn -> fx_ecriture($sql);// execution de la requete
		if ($resultat){
        	return $resultat;
        }
        else{
        	return false;
        }
}

    // insert contrat autofinancement
    public function creerContratAutoFinance($idcontrat, $budget_total, $fg_index_sin, $modalite_compl) {
        $query = "INSERT INTO contrat_autofinance (
            idcontrat, budget_total, fg_index_sin, modalite_compl
        ) VALUES (
            '".$idcontrat."', '".$budget_total."', '".$fg_index_sin."', '".$modalite_compl."'
        )";
    //echo $query;
    $conn=new connect();// preperation de la conexion
		$resultat=$conn -> fx_ecriture($query);// execution de la requete
		if ($resultat){
        	return $resultat;
        }
        else{
        	return false;
        }
    }
    
    // insert police assurance
    public function creerPoliceAssurance($idcontrat, $idpartenaire, $prime_nette, $accessoire, $prime_ttc, $intermediaire_id, $cocher_reassur, 
    $reassureur, $quote_part_assureur, $quote_part_reassur, $paie_sin_assur, $paie_sin_gga, $dateEffet, $dateEcheance) {
        $query = "INSERT INTO police_assurance (
            idcontrat, idpartenaire, prime_nette, accessoire, prime_ttc, intermediaire_id, cocher_reassur, 
            reassureur, quote_part_assureur, quote_part_reassur, paie_sin_assur, paie_sin_gga, dateEffet, dateEcheance
        ) VALUES (
            '".$idcontrat."', '".$idpartenaire."', '".$prime_nette."', '".$accessoire."', '".$prime_ttc."', '".$intermediaire_id."', '".$cocher_reassur."', 
    '".$reassureur."', '".$quote_part_assureur."', '".$quote_part_reassur."', '".$paie_sin_assur."', '".$paie_sin_gga."', '".$dateEffet."', '".$dateEcheance."'
        )";
        //echo $query;
        $conn=new connect();// preperation de la conexion
		$resultat=$conn -> fx_ecriture($query);// execution de la requete
		if ($resultat){
        	return $resultat;
        }
        else{
        	return false;
        }
    }
    
    //insert facture
    public function creerFacture_FraisGGA($idcontrat, $num_nd, $date_edit, $amount_contrat, $frais_gga, 
    $tva, $modalite, $etatfact, $idutile) {
        // Préparer la requête SQL
        $query = "INSERT INTO notedebit (
            idcontrat, num_nd, date_edit, amount_contrat, frais_gga, 
            tva, modalite, etatfact, idutile
        ) VALUES (
           '".$idcontrat."', '".$num_nd."',CURRENT_TIMESTAMP, '".$amount_contrat."', '".$frais_gga."', 
    '".$tva."', '".$modalite."', '".$etatfact."', '".$idutile."'
        )";
       // echo $query;
        $conn=new connect();// preperation de la conexion
		$resultat=$conn -> fx_ecriture($query);// execution de la requete
		if ($resultat){
        	return $resultat;
        }
        else{
        	return false;
        }
        // Début du bloc try-catch pour la gestion des erreurs
    /*    try {
            // Exécution de la requête avec les données
            $idFacture = $this->executeQuery($query, true);
            
            // Vérifier si l'ID de la facture est retourné
            if (!$idFacture) {
                throw new Exception("L'insertion de la facture a échoué.");
            }
    
            // Retourner un tableau avec le statut et l'ID de la facture
            return ["status" => "success", "idFacture" => $idFacture];
        } catch (Exception $e) {
            // Capturer l'erreur et retourner un message détaillé
            return ["status" => "error", "message" => "Erreur lors de l'insertion : " . $e->getMessage()];
        }
            */
    }
     //Gestion contrat insert mouvement
     public function CreerMouvementContrat($idcontrat,$typeops,$prime,$accessoire,$nbr_agent,$nbr_conj,$nbr_enf,$date_update,$updateby) {
         $query = "INSERT INTO mouvementcontrat (
             idcontrat,typeops,prime,accessoire,nbr_agent,nbr_conj,nbr_enf,date_update,updateby
         ) VALUES (
            '".$idcontrat."', '".$typeops."', '".$prime."', '".$accessoire."','".$nbr_agent."', '".$nbr_conj."', '".$nbr_enf."',CURRENT_TIMESTAMP, '".$updateby."'
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
    //Gestion contrat insert resiliation
    public function CreerResilisation($idcontrat,$dateresiliation,$dateopera,$motif,$updateby) {
        $query = "INSERT INTO resiliation (
            idcontrat,dateresiliation,dateopera,motif,updateby
        ) VALUES (
           '".$idcontrat."', '".$dateresiliation."', CURRENT_TIMESTAMP, '".$motif."',".$updateby."'
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
    //modif effectifs
    public function mettreAJourEffectifs($numero_police, $effectif_agent, $effectif_conjoint, $effectif_enfant, $operation, $idutile) {
        // Déterminer le signe de l'opération (+ pour ajout, - pour réduction)
        $signe = ($operation === 'ajout') ? '+' : '-';
        $sql = "UPDATE police_contrat 
                SET effectif_Benef = GREATEST(0, effectif_Benef $signe $effectif_agent + $effectif_conjoint + $effectif_enfant), 
                    effectif_agent = GREATEST(0, effectif_agent $signe $effectif_agent), 
                    effectif_conjoint = GREATEST(0, effectif_conjoint $signe $effectif_conjoint), 
                    effectif_enfant = GREATEST(0, effectif_enfant $signe $effectif_enfant), 
                    idutile = '$idutile', 
                    datecreate = CURRENT_TIMESTAMP 
                WHERE numero_police = '$numero_police'";
    
        $conn = new connect(); // Connexion à la base
        $resultat = $conn->fx_ecriture($sql); // Exécution de la requête
    
        return $resultat ? true : false;
    }
    
    public function majPrimeAssurance($idcontrat, $prime_nette, $accessoire, $operation) {
        
        $signe = ($operation === 'ajout') ? '+' : '-';
        $query = "UPDATE police_assurance 
                  SET prime_nette = prime_nette $signe '".$prime_nette."', 
                      accessoire = accessoire $signe '".$accessoire."',
                      prime_ttc = (prime_nette + accessoire) 
                  WHERE idcontrat = '".$idcontrat."'";
        // Connexion et exécution
        $conn = new connect();
        $resultat = $conn->fx_ecriture($query);
    
        return $resultat ? $resultat : false;
    }
    public function majBudgetAutofinancement($idcontrat, $budget_total,$operation) {
        
        $signe = ($operation === 'ajout') ? '+' : '-';
        $query = "UPDATE contrat_autofinance 
                  SET budget_total = budget_total $signe '".$budget_total."'
                  WHERE idcontrat = '".$idcontrat."'";
    
        // Connexion et exécution
        $conn = new connect();
        $resultat = $conn->fx_ecriture($query);
    
        return $resultat ? $resultat : false;
    }
    
    
    
    public function UpdateEffectif($idcontrat,$dateresiliation,$dateopera,$motif,$updateby) {
        $query = "INSERT INTO resiliation (
            idcontrat,dateresiliation,dateopera,motif,updateby
        ) VALUES (
           '".$idcontrat."', '".$dateresiliation."', CURRENT_TIMESTAMP, '".$motif."',".$updateby."'
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
    // fx modif police contrat
    public function fx_UpdateContrat($data) {
        $Rqte = "UPDATE police_contrat SET ";
        $dataset = [];
        $params = [];
        foreach ($data as $key => $value) {
            if ($key !== 'idcontrat') {
                $dataset[] = "$key = :$key";
            }
            $params[$key] = $value;
        }
        $Rqte .= implode(', ', $dataset) . " WHERE idcontrat = :idcontrat";
        return $this->executeQuery($Rqte, $params);
    }
   
    public function fx_DeleteContrat($id) {
        $Rqte = "DELETE FROM police_contrat WHERE idcontrat = :idcontrat";
        $params = ['idcontrat' => $id];
        return $this->executeQuery($Rqte, $params);
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
    
    
    public function FindContrats_assur($numero_police) {
        $query = "
            SELECT 
                pc.idcontrat, tc.libtype, pc.etat_contrat, pc.numero_police,
                c.idclient, c.den_social AS Client_name, c.pays_entr, 
                c.ville_entr, c.adresse_entr, pc.datecreate, pc.couverture,  
                pc.effectif_Benef, p.denom_social AS assureur, pa.prime_ttc,
                pa.dateEffet, pa.dateEcheance
            FROM police_contrat AS pc
            INNER JOIN police_assurance AS pa ON pc.idcontrat = pa.idcontrat
            INNER JOIN partenaire AS p ON pa.idpartenaire = p.idpartenaire
            INNER JOIN client AS c ON pc.idclient = c.idclient
            INNER JOIN typecontrat AS tc ON pc.type_contrat = tc.idtype
            WHERE pc.numero_police = :numero_police
        ";

        $result = (new connect())->fx_lecture($query, [':numero_police' => $numero_police]);

        return !empty($result) ? $result[0] : null; // Retourne un seul résultat (ou null si vide)
    }

    /**
     * Récupérer les détails d'un contrat auto par son numéro de police.
     */
    public function FindContrats_auto($numero_police) {
        $query = "
            SELECT 
                pc.idcontrat, pc.etat_contrat, pc.datecreate, tc.libtype, 
                pc.numero_police, c.idclient, c.den_social AS Client_name, 
                c.pays_entr, c.ville_entr, c.adresse_entr, pc.couverture,  
                pc.effectif_Benef, COALESCE(ca.budget_total, 0) AS budget_total
            FROM police_contrat AS pc
            INNER JOIN contrat_autofinance AS ca ON pc.idcontrat = ca.idcontrat
            INNER JOIN client AS c ON pc.idclient = c.idclient
            INNER JOIN typecontrat AS tc ON pc.type_contrat = tc.idtype
            WHERE pc.numero_police = :numero_police
        ";

        $result = (new connect())->fx_lecture($query, [':numero_police' => $numero_police]);

        return !empty($result) ? $result[0] : null; // Retourne un seul résultat (ou null si vide)
    }
    
    public function ContratEnCours() {
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
                ag.matagent, ag.nomagent, ag.postnomagent, ag.prenomagent,
                tc.libtype, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.effectif_Benef,
                ut.nomutile, ut.prenomutile
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
            WHERE pc.etat_contrat = 2
            LIMIT 100
        ";
        $results = $this->executeQuery($query);
        return $results ?: [];
    }
    public function ContratAttente() {
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
                ag.matagent, ag.nomagent, ag.postnomagent, ag.prenomagent,
                tc.libtype, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.effectif_Benef,
                ut.nomutile, ut.prenomutile
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
            WHERE pc.etat_contrat = 1
            LIMIT 100
        ";
        $results = $this->executeQuery($query);
        return $results ?: [];
    }
    public function ContratSuspendus() {
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
                ag.matagent, ag.nomagent, ag.postnomagent, ag.prenomagent,
                tc.libtype, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.effectif_Benef,
                ut.nomutile, ut.prenomutile
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
            WHERE pc.etat_contrat = 3
            LIMIT 100
        ";
        $results = $this->executeQuery($query);
        return $results ?: [];
    }
    public function ContratResilies() {
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
                ag.matagent, ag.nomagent, ag.postnomagent, ag.prenomagent,
                tc.libtype, 
                pc.etat_contrat, 
                c.idclient, 
                c.den_social, 
                c.pays_entr, 
                c.ville_entr, 
                pc.effectif_Benef,
                ut.nomutile, ut.prenomutile
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
            WHERE pc.etat_contrat = 4
            LIMIT 100
        ";
        $results = $this->executeQuery($query);
        return $results ?: [];
    }
    public function insertCotation($dateCotation, $nomDemandeur, $societe, $email, $telephone, $typeContrat, $dateDebut, $dateFin, $beneficiaire, $budget, $couverture, $frequencePay, $modePay, $commentaires) {
        $query = "
            INSERT INTO cotations (
                datecotation, nomdemandeur, societe, email, telephone, 
                typecontrat, datedebut, datefin, beneficiaire, 
                budget, couverture, frequencepay, modepay, commentaires
            ) VALUES (
                :datecotation, :nomdemandeur, :societe, :email, :telephone,
                :typecontrat, :datedebut, :datefin, :beneficiaire, 
                :budget, :couverture, :frequencepay, :modepay, :commentaires
            )
        ";
        
        $params = [
            ':datecotation' => $dateCotation,
            ':nomdemandeur' => $nomDemandeur,
            ':societe' => $societe,
            ':email' => $email,
            ':telephone' => $telephone,
            ':typecontrat' => $typeContrat,
            ':datedebut' => $dateDebut,
            ':datefin' => $dateFin,
            ':beneficiaire' => $beneficiaire,
            ':budget' => $budget,
            ':couverture' => $couverture,
            ':frequencepay' => $frequencePay,
            ':modepay' => $modePay,
            ':commentaires' => $commentaires
        ];
        
        // Exécution de la requête
        $result = $this->executeQuery($query, $params);
        
        return $result ? true : false;
    }
    public function listCotation() {
        $query = "
            SELECT 
                idcotation, datecotation, nomdemandeur, societe, email, telephone, 
                typecontrat, datedebut, datefin, beneficiaire, 
                budget, couverture, frequencepay, modepay, commentaires
            FROM cotations
            ORDER BY datecotation DESC
        ";
        
        // Exécution de la requête
        $results = $this->executeQuery($query);
        
        return $results ?: [];
    }
    public function countCotation() {
        $query = "SELECT COUNT(*) AS total FROM cotations";
        
        // Exécution de la requête
        $result = $this->executeQuery($query);
        
        // Récupérer le total des cotations
        return $result ? $result[0]['total'] : 0;
    }
                           
    
// liste contrats assurance
public function listeGlobalContratsAssur() {
    $query = "
        SELECT 
            pc.idcontrat, 
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
            pc.idcontrat, 
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
    //contrats en cours
    public function totalContrats_encours() {
        $query = "SELECT COUNT(*) AS encours FROM police_contrat WHERE etat_contrat=2";
        return $this->executeQuery($query);
    }
    //contrats en suspension
    public function totalContrats_suspension() {
        $query = "SELECT COUNT(*) AS suspendus FROM police_contrat WHERE etat_contrat=3";
        return $this->executeQuery($query);
    }
    //contrats resilié
    public function totalContrats_attentes() {
        $query = "SELECT COUNT(*) AS attentes FROM police_contrat WHERE etat_contrat=1";
        return $this->executeQuery($query);
    }
    // total des contrats
    public function totalNewContrats() {
        $query = "SELECT COUNT(*) AS total_newcontrats FROM police_contrat WHERE etat_contrat=0";
        return $this->executeQuery($query);
    }
    // total des contrats assurance
    public function totalGlobalContratsAssurance() {
        $query = "SELECT COUNT(*) AS total_contratsAss FROM police_contrat WHERE type_contrat=1 AND etat_contrat=2";
        return $this->executeQuery($query);
    }
    
    // Total des contrats d'assurance pour le mois en cours
public function totalGlobalContratsAssuranceMoisEncours() {
    $query = "
        SELECT COUNT(*) AS total_contratsAss_mois
        FROM police_contrat
        WHERE type_contrat = 1
          AND etat_contrat = 2
          AND MONTH(datecreate) = MONTH(CURRENT_DATE())
          AND YEAR(datecreate) = YEAR(CURRENT_DATE())
    ";
    return $this->executeQuery($query);
}

    // total des contrats autofin
    public function totalGlobalContratsAutoFin() {
    $query = "SELECT COUNT(*) AS total_contratsAutoFin FROM police_contrat WHERE type_contrat=2 AND etat_contrat=2";
    return $this->executeQuery($query);
    }
    public function totalGlobalContratsAutoFinMoisEncours() {
        $query = "
            SELECT COUNT(*) AS total_contratsAss_mois
            FROM police_contrat
            WHERE type_contrat = 2
              AND etat_contrat = 2
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

    // Ajouter bénéf d'un contrat
    public function ajouterBeneficiaire($idContrat, $nombre) {
        try {
            $this->conn->beginTransaction();
            // Mise à jour de l'effectif
            $rqtUpdate = "UPDATE police_contrat SET effectif_Benef = effectif_Benef + :nombre WHERE idcontrat = :idContrat";
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
            $rqtstory = "INSERT INTO mouvementeffect (idcontrat, type_ops, nombre, date_ops) VALUES (:idContrat, 'Retrait', :nombre, CURRENT_TIMESTAMP)";
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
                me.idcontrat = :idContrat
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
    COUNT(pc.idcontrat) AS total_contrats,
    SUM(COALESCE(pc.val_frais_gest, pc.tva, 0)) AS frais_gestion_gga,
    SUM(COALESCE(pa.prime_ttc, ca.budget_total)) AS chiffre_affaire,
    SUM(
        COALESCE(pc.effectif_Benef, 0)
    ) AS total_assures
FROM 
    police_contrat pc
JOIN 
police_assurance pa ON pc.idcontrat = pa.idcontrat
    
LEFT JOIN 
    partenaire p ON pa.idpartenaire = p.idpartenaire
LEFT JOIN 
contrat_autofinance ca ON pc.idcontrat=ca.idcontrat
GROUP BY 
    p.denom_social
ORDER BY 
    total_contrats DESC, chiffre_affaire DESC;
";

        return $this->executeQuery($sql);
    }
//analyse comparative de chaque etat de production
public function analyseComparativeParAssureur() {
    $sql = "
       SELECT 
    p.denom_social AS assureur,
    COUNT(pc.idcontrat) AS total_contrats,
    SUM(COALESCE(pc.val_frais_gest, pc.tva, 0)) AS frais_gestion_gga,
    SUM(COALESCE(pa.prime_ttc, ca.budget_total)) AS chiffre_affaire,
    SUM(
        COALESCE(pc.effectif_Benef, 0)
    ) AS total_assures
FROM 
    police_contrat pc
JOIN 
police_assurance pa ON pc.idcontrat = pa.idcontrat
    
LEFT JOIN 
    partenaire p ON pa.idpartenaire = p.idpartenaire
LEFT JOIN 
contrat_autofinance ca ON pc.idcontrat=ca.idcontrat
GROUP BY 
    p.denom_social
ORDER BY 
    total_contrats DESC, chiffre_affaire DESC;

    ";
    
    // Exécution de la requête
    $result = $this->executeQuery($sql); 
    // Retour des données sous forme de tableau
    return $result;
}


    // Total FG previsionnel
    public function TotalFrais_de_Gestion_prevision() {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(val_frais_gest + tva) AS frais_gest FROM police_contrat WHERE etat_contrat = 2";
        return $this->executeQuery($query);
    }
    // Total FG perçu *** J'y reviendrai lors de la mise en place du module finance ***
    public function TotalFrais_de_Gestion_perçu() {
        $query = "SELECT COUNT(*) AS total_contrats, SUM(val_frais_gest + tva) AS frais_gest FROM police_contrat WHERE etat_contrat = 2";
        return $this->executeQuery($query);
    }
    public function Total_Couverture_Nationale() {
        $query = "SELECT COUNT(couverture) AS total_couvNat FROM police_contrat WHERE couverture ='Nationale' AND etat_contrat = 2";
        return $this->executeQuery($query);
    }
    public function Total_Couverture_Internationale() {
        $query = "SELECT COUNT(couverture) AS total_couvInterNat FROM police_contrat WHERE couverture ='Internationale' AND etat_contrat = 2";
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
