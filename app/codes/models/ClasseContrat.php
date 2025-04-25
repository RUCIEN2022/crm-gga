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
    public function lastInsertId() {
        return $this->conn->lastInsertId();
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
    $conn=new connect();
		$resultat=$conn -> fx_ecriture($sql);
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
    $conn=new connect();
		$resultat=$conn -> fx_ecriture($query);
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
        $conn=new connect();
		$resultat=$conn -> fx_ecriture($query);
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
     
        $query = "INSERT INTO notedebit (
            idcontrat, num_nd, date_edit, amount_contrat, frais_gga, 
            tva, modalite, etatfact, idutile
        ) VALUES (
           '".$idcontrat."', '".$num_nd."',CURRENT_TIMESTAMP, '".$amount_contrat."', '".$frais_gga."', 
    '".$tva."', '".$modalite."', '".$etatfact."', '".$idutile."'
        )";
       // echo $query;
        $conn=new connect();
		$resultat=$conn -> fx_ecriture($query);
		if ($resultat){
        	return $resultat;
        }
        else{
        	return false;
        }
    }
    public function EnregistrerContrat($dataPC, $dataPAS, $dataPAT, $dataND){
        try {
            $conn = new connect();
    
            // Étape 1 : Insertion dans police_contrat
            $sqlPC = "INSERT INTO police_contrat (
                idclient, type_contrat, etat_contrat, couverture, effectif_Benef, numero_police, 
                effectif_agent, effectif_conjoint, effectif_enfant, pource_frais_gest, 
                val_frais_gest, tva, pource_app_fond, val_app_fond, seuil, 
                gestionnaire_id, idutile, datecreate
            ) VALUES (
                '".$dataPC['idclient']."', '".$dataPC['type_contrat']."', '".$dataPC['etat_contrat']."', '".$dataPC['couverture']."', '".$dataPC['effectif_Benef']."', 
                '".$dataPC['numero_police']."', '".$dataPC['effectif_agent']."', '".$dataPC['effectif_conjoint']."', '".$dataPC['effectif_enfant']."', 
                '".$dataPC['pource_frais_gest']."', '".$dataPC['val_frais_gest']."', '".$dataPC['tva']."', '".$dataPC['pource_app_fond']."', 
                '".$dataPC['val_app_fond']."', '".$dataPC['seuil']."', '".$dataPC['gestionnaire_id']."', '".$dataPC['idutile']."', CURRENT_TIMESTAMP
            )";
    
            $result = $conn->fx_ecriture($sqlPC);
    
            if (!$result) {
                throw new Exception("Erreur lors de l'enregistrement du contrat.");
            }
    
            // Récupération de l'ID du contrat inséré
            $idcontrat = $conn->lastInsertId(); // Méthode à implémenter dans ta classe connect si elle n'existe pas déjà
    
            // Préparation des données enfants avec l'ID du contrat
            $dataND['idcontrat'] = $idcontrat;
    
            if ($dataPC['type_contrat'] == 1) {
                $dataPAS['idcontrat'] = $idcontrat;
                $this->creerPoliceAssurance(
                    $dataPAS['idcontrat'], $dataPAS['idpartenaire'], $dataPAS['prime_nette'], 
                    $dataPAS['accessoire'], $dataPAS['prime_ttc'], $dataPAS['intermediaire_id'], 
                    $dataPAS['cocher_reassur'], $dataPAS['reassureur'], $dataPAS['quote_part_assureur'], 
                    $dataPAS['quote_part_reassur'], $dataPAS['paie_sin_assur'], $dataPAS['paie_sin_gga'], 
                    $dataPAS['dateEffet'], $dataPAS['dateEcheance']
                );
            } elseif ($dataPC['type_contrat'] == 2) {
                $dataPAT['idcontrat'] = $idcontrat;
                $this->creerContratAutoFinance(
                    $dataPAT['idcontrat'], $dataPAT['budget_total'], 
                    $dataPAT['fg_index_sin'], $dataPAT['modalite_compl']
                );
            }
    
            // Enregistrement de la facture dans tous les cas
            $this->creerFacture_FraisGGA(
                $dataND['idcontrat'], $dataND['num_nd'], $dataND['date_edit'], 
                $dataND['amount_contrat'], $dataND['frais_gga'], $dataND['tva'], 
                $dataND['modalite'], $dataND['etatfact'], $dataND['idutile']
            );
    
            return true;
    
        } catch (Exception $e) {
            // Tu peux aussi faire un log ici si besoin
            return false;
        }
    }
    
     //insert mouvement
     public function CreerMouvementContrat($data) {
       
        $idcontrat   = $data['idcontrat'] ?? '';
        $typeops     = $data['type_operation'] ?? '';
        $prime       = $data['prime'] ?? 0;
        $accessoire  = $data['accessoire'] ?? 0;
        $nbr_agent   = $data['nbr_agent'] ?? 0;
        $nbr_conj    = $data['nbr_conj'] ?? 0;
        $nbr_enf     = $data['nbr_enf'] ?? 0;
        $updateby    = $data['updateby'] ?? 1;
        $query = "INSERT INTO mouvementcontrat (
            idcontrat, typeops, prime, accessoire, nbr_agent, nbr_conj, nbr_enf, date_update, updateby
        ) VALUES (
            '$idcontrat', '$typeops', '$prime', '$accessoire', '$nbr_agent', '$nbr_conj', '$nbr_enf', CURRENT_TIMESTAMP, '$updateby'
        )";
        $conn = new connect();
        $resultat = $conn->fx_ecriture($query);
    
        return $resultat ? $resultat : false;
    }
    
     //insert suspension
     public function CreerSuspensionContrat($data) {
        $Rqte = "INSERT INTO suspension (
            idcontrat, datesusp, datereprise, motif, dateopera, updateby
        ) VALUES (
            :idcontrat, :datesusp, :datereprise, :motif, CURRENT_TIMESTAMP, :updateby
        )";
    
        $params = [
            'idcontrat'    => $data['idcontrat'],
            'datesusp'     => $data['datesusp'],
            'datereprise'  => $data['datereprise'],
            'motif'        => $data['motif'],
            'updateby'     => $data['updateby']
        ];
    
        return $this->executeQuery($Rqte, $params);
    }
    
    
    //insert resiliation
    public function CreerResiliation($data) {
        $Rqte = "INSERT INTO resiliation (
            idcontrat, dateresiliation, dateopera, motif, updateby
        ) VALUES (
            :idcontrat, :dateresiliation, CURRENT_TIMESTAMP, :motif, :updateby
        )";
    
        $params = [
            'idcontrat'        => $data['idcontrat'],
            'dateresiliation'  => $data['dateresiliation'],
            'motif'            => $data['motif'],
            'updateby'         => $data['updateby']
        ];
    
        return $this->executeQuery($Rqte, $params);
    }
    
    //transaction mise à jour contrat
    public function TraiterOperationContrat($data) {
        try {
            // Démarrage de la transaction
            $this->conn->beginTransaction();
        
            // Type d'opération et type de contrat
            $typeOperation = $data['type_operation'];
            $typeContrat = $data['typecontrat'];
    
            // Si l'opération est "ajout" ou "retrait", il faut traiter les champs spécifiques
            if (in_array($typeOperation, ['ajout', 'retrait'])) {
                // Gestion spécifique pour "ajout" ou "retrait"
                if ($typeOperation === 'retrait') {
                    // Filtrer les données liées à l'opération retrait
                    unset($data['nbragent']);
                    unset($data['nbrconj']);
                    unset($data['nbrenf']);
                }
    
                // Création du mouvement de contrat
                $this->CreerMouvementContrat($data);
        
                // Mise à jour du contrat selon son type
                if ($typeContrat == 2) {
                    $this->UpdateContratAutofinance($data);
                } elseif ($typeContrat == 1) {
                    $this->UpdatePoliceAssurance($data);
                }
        
                $this->UpdatePoliceContrat($data);
            }
            // Si l'opération est "suspension"
            elseif ($typeOperation === 'suspension') {
                $this->UpdateEtatContrat([
                    'idcontrat' => $data['idcontrat'],
                    'etat_contrat' => 3
                ]);
        
                $this->CreerSuspensionContrat($data);
            }
            // Si l'opération est "resiliation"
            elseif ($typeOperation === 'resiliation') {
                $this->UpdateEtatContrat([
                    'idcontrat' => $data['idcontrat'],
                    'etat_contrat' => 4
                ]);
        
                $this->CreerResiliation($data);
            } else {
                throw new Exception("Type d'opération non reconnu.");
            }
        
            // Commit de la transaction
            $this->conn->commit();
            return ["success" => true, "message" => "Opération réussie"];
        } catch (Exception $e) {
            // En cas d'erreur, rollback de la transaction
            $this->conn->rollBack();
            return ["success" => false, "message" => "Erreur : " . $e->getMessage()];
        }
    }
    
    
    //modif effectifs
    public function UpdatePoliceContrat($data) {
        $signe = ($data['type_operation'] === 'ajout') ? '+' : '-';
    
        $Rqte = "UPDATE police_contrat 
                 SET effectif_Benef = GREATEST(0, effectif_Benef $signe :total),
                     effectif_agent = GREATEST(0, effectif_agent $signe :agent),
                     effectif_conjoint = GREATEST(0, effectif_conjoint $signe :conjoint),
                     effectif_enfant = GREATEST(0, effectif_enfant $signe :enfant),
                     idutile = :idutile,
                     datecreate = CURRENT_TIMESTAMP
                 WHERE numero_police = :numero_police";
    
        $params = [
            'total'          => $data['nbr_agent'] + $data['nbr_conj'] + $data['nbr_enf'],
            'agent'          => $data['nbr_agent'],
            'conjoint'       => $data['nbr_conj'],
            'enfant'         => $data['nbr_enf'],
            'idutile'        => $data['updateby'],
            'numero_police'  => $data['numero_police']
        ];
    
        return $this->executeQuery($Rqte, $params);
    }
    
    
    //update police_assurance
    public function UpdatePoliceAssurance($data) {
        $signe = ($data['type_operation'] === 'ajout') ? '+' : '-';
    
        $Rqte = "UPDATE police_assurance 
                 SET prime_nette = prime_nette $signe :prime_nette,
                     accessoire = accessoire $signe :accessoire,
                     prime_ttc = (prime_nette + accessoire)
                 WHERE idcontrat = :idcontrat";
    
        $params = [
            'prime_nette' => $data['prime'],
            'accessoire'  => $data['accessoire'],
            'idcontrat'   => $data['idcontrat']
        ];
    
        return $this->executeQuery($Rqte, $params);
    }
    
    //update budget_total Autofinance
    public function UpdateContratAutofinance($data) {
        $signe = ($data['type_operation'] === 'ajout') ? '+' : '-';
    
        $Rqte = "UPDATE contrat_autofinance 
                 SET budget_total = budget_total $signe :budget_total
                 WHERE idcontrat = :idcontrat";
    
        $params = [
            'budget_total' => $data['budget_total'],
            'idcontrat'    => $data['idcontrat']
        ];
    
        return $this->executeQuery($Rqte, $params);
    }
    
    //update etat_contrat
    public function UpdateEtatContrat($data) {
        $Rqte = "UPDATE police_contrat 
                 SET etat_contrat = :etat_contrat,
                     date_update = CURRENT_TIMESTAMP
                 WHERE idcontrat = :idcontrat";
    
        $params = [
            'etat_contrat' => $data['etat_contrat'],
            'idcontrat'    => $data['idcontrat']
        ];
    
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
    // Récupère les initiales d'un agent par son ID
    public function getInitialesAgent($idAgent) {
        $query = "
            SELECT nomagent, postnomagent, prenomagent 
            FROM agent 
            WHERE idagent = :id
        ";
    
        $params = [':id' => $idAgent];
        $result = $this->executeQuery($query, $params);
    
        if (!$result || count($result) == 0) {
            return null; // Agent non trouvé
        }
    
        $agent = $result[0];
    
        // Vérifier si chaque champ existe et n'est pas vide
        $nom = !empty($agent['nomagent']) ? strtoupper(substr($agent['nomagent'], 0, 1)) : "";
        $postnom = !empty($agent['postnomagent']) ? strtoupper(substr($agent['postnomagent'], 0, 1)) : "";
        $prenom = !empty($agent['prenomagent']) ? strtoupper(substr($agent['prenomagent'], 0, 1)) : "";
    
        // Générer les initiales en fonction des valeurs disponibles
        $initials = $nom . $postnom . $prenom;
    
        return substr($initials, 0, 3); // Prend maximum 3 caractères
    }
    
    
   // Récupère les initiales d'un client par son ID
   public function getInitialesClient($idClient) {
    $query = "
        SELECT den_social 
        FROM client 
        WHERE idclient = :id
    ";

    $params = [':id' => $idClient];
    $result = $this->executeQuery($query, $params);

    if (!$result || count($result) == 0) {
        return null; // Client non trouvé
    }

    $den_social = trim($result[0]['den_social']);
    $words = explode(" ", $den_social);
    $initials = "";

    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 3) break; // Max 3 caractères
        }
    }

    return substr($initials, 0, 3);
}
//site user
public function getIdSiteByUser($idutile) {
    $query = "
        SELECT idsite 
        FROM utilisateur 
        WHERE idutile = :idutile
    ";
    
    $params = [':idutile' => $idutile];
    $result = $this->executeQuery($query, $params);
    if ($result && count($result) > 0) {
        return $result[0]['idsite']; // Retourne l'idsite
    } else {
        return null; // Aucun site trouvé
    }
}

    //dernier contrat
    public function getLastContratId() {
        $query = "
            SELECT MAX(idcontrat) AS last_id
            FROM police_contrat
        "; 
    
        $result = $this->executeQuery($query);
        if ($result && isset($result[0]['last_id'])) {
            return $result[0]['last_id'];
        }
        
        return 0;
    }
    //derniere ND
    public function getLastNoteDebitId() {
        $query = "
            SELECT MAX(id_nd) AS last_id
            FROM notedebit
        "; 
    
        $result = $this->executeQuery($query);
        if ($result && isset($result[0]['last_id'])) {
            return $result[0]['last_id'];
        }
        return 0;
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
                pa.dateEffet, pa.dateEcheance,nd.num_nd,nd.date_edit,nd.amount_contrat,
               nd.frais_gga,nd.tva,nd.modalite
            FROM police_contrat AS pc
            INNER JOIN police_assurance AS pa ON pc.idcontrat = pa.idcontrat
            INNER JOIN notedebit AS nd ON pc.idcontrat = nd.idcontrat
            INNER JOIN partenaire AS p ON pa.idpartenaire = p.idpartenaire
            INNER JOIN client AS c ON pc.idclient = c.idclient
            INNER JOIN typecontrat AS tc ON pc.type_contrat = tc.idtype
            WHERE pc.numero_police = :numero_police
        ";

        $result = (new connect())->fx_lecture($query, [':numero_police' => $numero_police]);
        return !empty($result) ? $result[0] : null;
    }
    public function FindContrats_auto($numero_police) {
        $query = "
           SELECT 
                pc.idcontrat, pc.etat_contrat, pc.datecreate, tc.libtype, 
                pc.numero_police, c.idclient, c.den_social AS Client_name, 
                c.pays_entr, c.ville_entr, c.adresse_entr, pc.couverture,  
                pc.effectif_Benef, COALESCE(ca.budget_total, 0) AS budget_total,
               nd.num_nd,nd.date_edit,nd.amount_contrat,
               nd.frais_gga,nd.tva,nd.modalite
            FROM police_contrat AS pc
            INNER JOIN contrat_autofinance AS ca ON pc.idcontrat = ca.idcontrat
            INNER JOIN notedebit AS nd ON pc.idcontrat = nd.idcontrat
            INNER JOIN client AS c ON pc.idclient = c.idclient
            INNER JOIN typecontrat AS tc ON pc.type_contrat = tc.idtype
            WHERE pc.numero_police = :numero_police
        ";

        $result = (new connect())->fx_lecture($query, [':numero_police' => $numero_police]);
        return !empty($result) ? $result[0] : null;
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
    public function insertCotation($dateCotation, $nomDemandeur, $societe, $email, $telephone, $idtypeContrat, $dateDebut, $dateFin, $beneficiaire, $budget, $couverture, $frequencePay, $modePay, $commentaires, $statut) {
        $query = "
        INSERT INTO cotations (
            datecotation, nomdemandeur, societe, email, telephone, 
            idtypecontrat, datedebut, datefin, beneficiaire, 
            budget, couverture, frequencepay, modepay, commentaires, statut
        ) VALUES (
            :datecotation, :nomdemandeur, :societe, :email, :telephone,
            :idtypecontrat, :datedebut, :datefin, :beneficiaire, 
            :budget, :couverture, :frequencepay, :modepay, :commentaires, :statut
        )";
    
        $params = [
            ':datecotation' => $dateCotation,
            ':nomdemandeur' => $nomDemandeur,
            ':societe' => $societe,
            ':email' => $email,
            ':telephone' => $telephone,
            ':idtypecontrat' => (int) $idtypeContrat, // Force en entier
            ':datedebut' => $dateDebut,
            ':datefin' => $dateFin,
            ':beneficiaire' => (int) $beneficiaire, // Force en entier
            ':budget' => (float) $budget, // Garde un format numérique
            ':couverture' => $couverture,
            ':frequencepay' => $frequencePay,
            ':modepay' => $modePay,
            ':commentaires' => $commentaires,
            ':statut' => (int) $statut // Force en entier
        ];
    
        $result = $this->executeQuery($query, $params);

        if ($result) {
            return true;
        } else {
            error_log("Erreur SQL lors de l'insertion.");
            return [
                "status" => "error",
                "message" => "Échec de l'enregistrement"
            ];
        }
        
    }
    
    public function listCotation() {
        $query = "
          SELECT 
                cotations.idcotation, cotations.datecotation, cotations.nomdemandeur, cotations.societe, cotations.email, cotations.telephone, 
                typecontrat.libtype, cotations.datedebut, cotations.datefin, cotations.beneficiaire, 
                cotations.budget, cotations.couverture, cotations.frequencepay, cotations.modepay, cotations.commentaires
            FROM cotations, typecontrat
            WHERE cotations.idtypecontrat=typecontrat.idtype
            ORDER BY datecotation DESC
        ";
        
        $results = $this->executeQuery($query);
        
        return $results ?: [];
    }
    public function countCotation() {
        $query = "SELECT COUNT(*) AS total_cotation FROM cotations WHERE statut = 1";
        return $this->executeQuery($query);
       
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
    //contrats en attente
    public function totalContrats_attentes() {
        $query = "SELECT COUNT(*) AS attentes FROM police_contrat WHERE etat_contrat=1";
        return $this->executeQuery($query);
    }
    //contrats resilié
    public function totalContrats_resilies() {
        $query = "SELECT COUNT(*) AS resilies FROM police_contrat WHERE etat_contrat=4";
        return $this->executeQuery($query);
    }
    // total des contrats
    public function totalNewContrats() {
        $query = "SELECT COUNT(*) AS total_newcontrats FROM police_contrat WHERE etat_contrat=1";
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
    DATE_FORMAT(pc.datecreate, '%Y-%m') AS mois, -- Format YYYY-MM
    p.denom_social AS assureur,
    COUNT(pc.idcontrat) AS total_contrats,
    SUM(COALESCE(pc.val_frais_gest, 0) + COALESCE(pc.tva, 0)) AS frais_gestion_gga,
    SUM(COALESCE(pa.prime_ttc, 0)) AS chiffre_affaire,
    SUM(COALESCE(pc.effectif_Benef, 0)) AS total_assures
FROM 
    police_contrat pc
JOIN 
    police_assurance pa ON pc.idcontrat = pa.idcontrat
LEFT JOIN 
    partenaire p ON pa.idpartenaire = p.idpartenaire
WHERE
    pc.type_contrat = 1
GROUP BY 
    mois, p.denom_social
ORDER BY 
    mois DESC, total_contrats DESC, chiffre_affaire DESC;
;

    ";
  
    $result = $this->executeQuery($sql); 
    return $result;
}
//analyse contrats autofinancement
public function analyseContratAutofinancement() {
    $sql = "
       SELECT 
    DATE_FORMAT(pc.datecreate, '%Y-%m') AS mois,
    COUNT(pc.idcontrat) AS total_contrats,  -- Nombre total de contrats
    SUM(COALESCE(pc.effectif_Benef, 0)) AS total_beneficiaires,
    SUM(COALESCE(ca.budget_total, 0)) AS budget_total_contrats,
    SUM(COALESCE(pc.val_frais_gest, 0) + COALESCE(pc.tva, 0)) AS frais_gestion
FROM 
    police_contrat pc
JOIN 
    contrat_autofinance ca ON pc.idcontrat = ca.idcontrat
WHERE 
    pc.type_contrat = 2 
GROUP BY 
    mois
ORDER BY 
    mois DESC;
";
    
    $result = $this->executeQuery($sql); 
 
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
    public function getTypeContratByNumPolice($numero_police) {
        $query = "
            SELECT tc.libtype
            FROM police_contrat pc
            INNER JOIN typecontrat tc ON pc.type_contrat = tc.idtype
            WHERE pc.numero_police = :numero_police
        ";
    
        $result = (new connect())->fx_lecture($query, [':numero_police' => $numero_police]);
        return !empty($result) ? $result[0]['libtype'] : null;
    }
    
    public function getGestionnaire() {
        $query = "SELECT * FROM agent";
        return $this->executeQuery($query);
    }
   
}
?>
