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

        $query ="INSERT INTO journal_operation(idcompte, datejour, typeOperation, montant, motif, beneficiaire, 
        montantcredit, montantdebit) VALUES (:idcompte, :datejour, :typeOperation, :montant, :motif, :beneficiaire, 
        :montantcredit, :montantdebit)";
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


        $query ="INSERT INTO journal_banque(date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer, compte, banque)
         VALUES (:date_operation, :beneficiaire, :entree_fond, :sortie_fond, :solde, :refer, :compte, :banque)";
        return $this->executeQuery($query, $data);
    } 
    public function getLibcompte($idcompte){
        $query="SELECT libcompte FROM compte where idcompte= :idcompte";
        //return $this->executeQuery($query);
        return $this->executeQuery($query, [':idcompte' => $idcompte]);
    }
    public function EnregistrerJournal($dataJO, $data){
        try{
            $this->conn->beginTransaction();
            // Étape 1 : Enregistrer le client
            $resultOp = $this->InsertJournalOp($data);
            if (!$resultOp) {
                throw new Exception("Erreur lors de l'enregistrement de l/'Operation.");
            }
            if($data['idcompte'] == 1 ){
                $this->InsertJournalBanque($dataJO);
            }elseif($data['idcompte'] == 2){
                $this->InsertJournalCaisse($dataJO);
            }

             // Si tout est OK, valider la transaction
           $this->conn->commit();
    
        }catch(Exception $e){

        }
    }
    public function getListeJC(){
        $query = "SELECT id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, solde, refer FROM journal_caisse";
        return $this->executeQuery($query);

    }
    public function getListeJB(){
        $query = "SELECT id_operation, date_operation, beneficiaire, entree_fond, sortie_fond, 
        solde, refer, compte, banque FROM journal_banque ";
        return $this->executeQuery($query);

    }
    public function getListeJO(){
        $query = "SELECT J.idjo, libcompte, datejour, typeOperation, montant, motif, beneficiaire, montantcredit,
        montantdebit FROM journal_operation J INNER join compte c on c.idcompte=J.idcompte ";
        return $this->executeQuery($query);

    }


 }

?>