<?php 
include_once(__DIR__ . '/Config/ParamDB.php');
 class Finance{
    private $conn;

    public function __construct() {
        $this->conn = new connect(); // Connexion via la classe connect de ClasseParamDB
    }
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

    public function CreerDecompte($data){

        $query ="INSERT INTO decomptes_valides(annee, id_prestataire, id_assureur, id_contrat, date_soin,
         montant_paye, date_reception, observation, date_paiement, user) VALUES (:annee, :id_prestataire, :id_assureur, :id_contrat, :date_soin,
         :montant_paye, :date_reception, :observation, :date_paiement, :user)";

        return $this->executeQuery($query, $data);
    } 
    public function getListeDecompte(){
        $query = "SELECT 
                        dv.id_decompte,
                        dv.annee,
                        dv.date_soin,
                        dv.montant_paye,
                        dv.date_reception,
                        dv.date_paiement,
                        dv.observation,

                        p.nom_prestataire,
                        p.adresse AS adresse_prestataire,
                        p.contact AS contact_prestataire,
                        p.email AS email_prestataire,
                        p.rib AS rib_prestataire,
                        c.numero_police,
                        a.denom_social

                    FROM decomptes_valides dv
                    JOIN prestataires p ON dv.id_prestataire = p.id_prestataire
                    JOIN police_contrat c ON dv.id_contrat = c.idpolice
                    JOIN partenaire a ON dv.id_assureur = a.idpartenaire
                    ";
        return $this->executeQuery($query);

    }
    public function CreerFond_deroulement($data){

        $query ="INSERT INTO fonds_deroulement(id_assureur, id_contrat, fonds_recus, sinistre_paye, 
        sinistre_encours)VALUES (:id_assureur, :id_contrat, :fonds_recus, :sinistre_paye, 
        :sinistre_encours)";

        return $this->executeQuery($query, $data);
    } 
    public function getListeFondDerou(){
        $query = "SELECT F.id_fond,denom_social,numero_police, fonds_recus,sinistre_paye,sinistre_encours,fonds_disponibles FROM
         fonds_deroulement F INNER JOIN partenaire P on P.idpartenaire=F.id_assureur
             INNER join police_contrat pc on pc.idpolice=f.id_contrat ";
        return $this->executeQuery($query);

    }
    public function InsertJournalOp($data){
        
           //recuperation solde
           $req="SELECT solde FROM journal_operation ORDER BY id_operation DESC LIMIT 1";
           $result= $this->executeQuery($req);
           if($result){
               $jb=$result[0];
               $data['solde'] = $jb['solde'] + $data['montantcredit'] - $data['montantdebit'];
           }else{
               $data['solde'] = $data['montantcredit'] - $data['montantdebit'];
           }
   

        $query ="INSERT INTO journal_operation(idcompte, datejour, typeOperation, montant, motif, beneficiaire, 
        montantcredit, montantdebit, solde,ref_oper) VALUES (:idcompte, :datejour, :typeOperation, :montant, :motif, :beneficiaire, 
        :montantcredit, :montantdebit, :solde, :ref_oper)";
        return $this->executeQuery($query, $data);
    } 
    public function InsertJournalCaisse($data){
         //recuperation solde
         $req="SELECT solde FROM journal_caisse ORDER BY id_operation DESC LIMIT 1";
         $result= $this->executeQuery($req);
         if($result){
             $jb=$result[0];
             $data['solde'] = $jb['solde'] + $data['entree_fond'] - $data['sortie_fond'];
         }else{
             $data['solde'] = $data['entree_fond'] - $data['sortie_fond'];
         }
 
        $query ="INSERT INTO journal_caisse(date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer)
         VALUES (:date_operation, :beneficiaire, :entree_fond, :sortie_fond, :solde, :refer)";
        return $this->executeQuery($query, $data);
    } 
    public function InsertJournalBanque($data){
        //recuperation solde
        $req="SELECT solde FROM journal_banque ORDER BY id_operation DESC LIMIT 1";
        $result= $this->executeQuery($req);
        if($result){
            $jb=$result[0];
            $data['solde'] = $jb['solde'] + $data['entree_fond'] - $data['sortie_fond'];
        }else{
            $data['solde'] = $data['entree_fond'] - $data['sortie_fond'];
        }

        $query ="INSERT INTO journal_banque(date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer, idcompte, idbanque)
         VALUES (:date_operation, :beneficiaire, :entree_fond, :sortie_fond, :solde, :refer, :idcompte, :idbanque)";
        return $this->executeQuery($query, $data);
    } 
    public function getUpdateSolde($idcompte, $solde){

        $query="update compte set solde = :solde where idcompte = :idcompte";
       
        return $this->executeQuery($query, [':idcompte' => $idcompte, ':solde' => $solde]);
    }
    public function insertBanque($data){
        $query ="INSERT INTO banque(idcompte, libbanque, comptebanque, soldebanque) VALUES (:idcompte, :libbanque, :comptebanque, :soldebanque)";
        return $this->executeQuery($query, $data);
    }
    public function updateSoldeBanque($idbanque,$soldebanque){
        
        $req="SELECT soldebanque FROM banque where idbanque=:idbanque ORDER BY idbanque DESC LIMIT 1";
        $result= $this->executeQuery($req, [':idbanque' => $idbanque]);
        $anciensolde=0;
        if($result){
            $jb=$result[0];
            $anciensolde=$jb['soldebanque'];
        }else{
            $anciensolde=0;
        }
        $soldesave=$anciensolde + $soldebanque;
        $query="update banque set soldebanque = :soldebanque where idbanque = :idbanque";
        return $this->executeQuery($query, [':idbanque' => $idbanque, ':soldebanque' => $soldesave]);
    }
    public function reduireSoldeBanque($idbanque,$soldebanque){
        
        $req="SELECT soldebanque FROM banque where idbanque=:$idbanque ORDER BY id_banque DESC LIMIT 1";
        $result= $this->executeQuery($req, [':idbanque' => $idbanque]);
        $anciensolde=0;
        if($result){
            $jb=$result[0];
            $anciensolde=$jb['soldebanque'];
        }else{
            $anciensolde=0;
        }
        $soldesave=$anciensolde - $soldebanque;
        $query="update banque set soldebanque = :soldebanque where idbanque = :idbanque";
        return $this->executeQuery($query, [':idbanque' => $idbanque, ':soldebanque' => $soldesave]);
    }
    public function getSoldecompte($idcompte){
        $query="SELECT solde FROM compte where idcompte= :idcompte";
        //return $this->executeQuery($query);
        return $this->executeQuery($query, [':idcompte' => $idcompte]);
    }
    public function getSoldeBanque($idbanque){
        $query="SELECT soldebanque FROM banque where idbanque= :idbanque";
        //return $this->executeQuery($query);
        return $this->executeQuery($query, [':idbanque' => $idbanque]);
    }

    public function EnregistrerJournal($dataJO, $dataJB, $dataJC, $datasolde){
        try{
           // $this->conn->beginTransaction();
            // Étape 1 : Enregistrer le client
            $resultOp = $this->InsertJournalOp($dataJO);
            if (!$resultOp) {
                throw new Exception("Erreur lors de l'enregistrement de l/'Operation.");
            }
            if($dataJO['idcompte'] == 1 ){
                $this->InsertJournalBanque($dataJB);
                $this->getUpdateSolde($dataJB['idcompte'],$dataJB['solde']);
                if($dataJO['typeOperation']==="Recette"){
                    $this->updateSoldeBanque($datasolde['idbanque'],$datasolde['soldebanque']);
                }else{
                    $this->reduireSoldeBanque($datasolde['idbanque'],$datasolde['soldebanque']);
                }
                
            }elseif($dataJO['idcompte'] == 2){
                $this->InsertJournalCaisse($dataJC);
                $this->getUpdateSolde($dataJO['idcompte'],$dataJO['solde']);
            }

         return true;
    
        }catch(Exception $e){
           return false;
        }
    }
    public function getListeJC(){
        $query = "SELECT id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer FROM journal_caisse";
        return $this->executeQuery($query);

    }
    public function getJC($data){
        $date1= $data['date1'];
        $date2=$data['date2'];
        $query = "SELECT id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer FROM journal_caisse
                  WHERE date_operation BETWEEN :date1 AND :date2
                  ORDER BY id_operation ASC";
    
        return $this->executeQuery($query, [
            ':date1' => $date1,
            ':date2' => $date2
        ]);
    }
    public function getListeJB(){
        $query = "SELECT id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, 
        solde, refer, idcompte, idbanque FROM journal_banque ";
        return $this->executeQuery($query);

    }
    public function getJB($data){
        $date1= $data['date1'];
        $date2=$data['date2'];
        $query = "SELECT J.id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, 
        solde, refer, libbanque FROM journal_banque J INNER JOIN banque B on B.idbanque=J.idbanque
                  WHERE J.date_operation BETWEEN :date1 AND :date2
                  ORDER BY J.date_operation ASC";
    
        return $this->executeQuery($query, [
            ':date1' => $date1,
            ':date2' => $date2
        ]);
    }
    public function getListeJO(){
        $query = "SELECT J.idjo, libcompte, datejour, typeOperation, montant, motif, beneficiaire, montantcredit,
        montantdebit,J.solde FROM journal_operation J INNER join compte c on c.idcompte=J.idcompte WHERE DATE(J.datejour) = CURDATE()";
        return $this->executeQuery($query);

    }
    /*public function getJournalParDate($date1, $date2){
        $query = "SELECT J.idjo, libcompte, datejour, typeOperation, montant, motif, beneficiaire, montantcredit,
        montantdebit,J.solde FROM journal_operation J INNER join compte c on c.idcompte=J.idcompte WHERE DATE(J.datejour) BETWEEN :date1 AND :date2  ORDER BY DATE(datejour) ASC";
        return $this->executeQuery($query, [':date1' => $date1, ':date2' => $date2]);

    }*/
    public function getJournalParDate($data){
        $date1= $data['date1'];
        $date2=$data['date2'];
        $query = "SELECT J.idjo, libcompte, datejour, typeOperation, montant, motif, beneficiaire, montantcredit,
                  montantdebit, J.solde
                  FROM journal_operation J
                  INNER JOIN compte c ON c.idcompte = J.idcompte
                  WHERE J.datejour BETWEEN :date1 AND :date2
                  ORDER BY J.datejour ASC";
    
        return $this->executeQuery($query, [
            ':date1' => $date1,
            ':date2' => $date2
        ]);
    }
    
    //mes fonctions supplementaire
    public function listeContrat(){
        $query = "SELECT numero_police FROM police_contrat where etat_contrat=1 ";
        return $this->executeQuery($query);
    }

    public function ComboContrats(){
        $query = "SELECT pc.idcontrat, pc.type_contrat, pc.etat_contrat, c.idclient, c.den_social, pc.effectif_Benef, pc.val_frais_gest,pc.tva,pc.numero_police,
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
    public function getTotalDecompte() {
        $query = "SELECT COUNT(*) AS total_dv FROM decomptes_valides";
        return $this->executeQuery($query);
    }
    public function getTotalJC() {
        $query = "SELECT solde AS total_jc FROM journal_caisse order by id_operation desc limit 1";
        return $this->executeQuery($query);
    }
    public function getTotalJB() {
        $query = "SELECT solde AS total_jb FROM journal_banque order by id_operation desc limit 1";
        return $this->executeQuery($query);
    }
    public function getCompte(){
        $query = "SELECT idcompte, libcompte, codecompte FROM compte";
        return $this->executeQuery($query);

    }
    public function getBanque(){
        $query = "SELECT idbanque, idcompte, libbanque, comptebanque, soldebanque FROM banque order by libbanque asc";
        return $this->executeQuery($query);

    }


 }

?>