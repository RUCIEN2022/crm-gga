<?php
include_once(__DIR__ . '/Config/ParamDB.php');

class Client{
    private $conn;
    public function __construct()
    {
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
    public function fx_CreerClient($data) {//data sera notre tableau qui va recevoir les données de paramètre
        $query = "INSERT INTO client (
            idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, 
            telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat
        ) VALUES (
            :idsite, :den_social, :pays_entr, :ville_entr, :adresse_entr, :code_interne, :id_nat, 
            :telephone_client, :nom_respon, :email_respon, :telephone_respo, :numclasseur, :datecrea, :etat
        )";
        return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut
    }
    public function fx_UpdateClient($data) {//data sera notre tableau qui va recevoir les données de paramètre
       
        $Rqte = "UPDATE client SET ";
        $dataset = [];
        $params = [];
    
        foreach ($data as $key => $value) {
            if ($key !== 'idclient') {
                $dataset[] = "$key = :$key";
            }
            $params[$key] = $value;
        }
    
        $Rqte .= implode(', ', $dataset) . " WHERE idclient = :idclient";
    
        return $this->executeQuery($Rqte, $params);
    }
    public function DeleteClientssss($idclient){
        $query = "DELETE FROM client where idclient = :idclient";
        $paramDelete=[':idutile'=>$idclient];
        return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut

    }
    public function ListeGlobalClient() {
        $query = "SELECT c.idclient, s.idsite,libsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat FROM client c inner join site s on s.idsite=c.idsite LIMIT 50";
        return $this->executeQuery($query);
    }
    public function listeSite() {
        $query = "SELECT idsite,libsite FROM site order by libsite";
        return $this->executeQuery($query);
    }
    public function fx_RechercheClientID($idclient){
        $query = "SELECT c.idclient, s.idsite,libsite, den_social, rccm, numeroimpot, emailclient, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat FROM client c inner join site s on s.idsite=c.idsite where idclient = :idclient";
        return $this->executeQuery($query, [':idclient' => $idclient]);
    }
    public function fx_RechercheClientRccm($rccm){
        $query = "SELECT c.idclient, s.idsite,libsite, den_social, rccm, numeroimpot, emailclient, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat FROM client c inner join site s on s.idsite=c.idsite where idclient = :idclient";
        return $this->executeQuery($query, [':rccm' => $rccm]);
    }
    public function fx_ActiverClient($idclient){
        $query = "Update client set etat=1 where idclient = :idclient LIMIT 1";
        return $this->executeQuery($query, [':idclient' => $idclient]);
    }
    public function fx_DesactiverClient($idclient){
        $query = "Update client set etat=0 where idclient = :idclient LIMIT 1";
        return $this->executeQuery($query, [':idclient' => $idclient]);
    }
}

/*
include_once ("models/Config/ParamDB.php");
class Client{
          private $idclient;
          private $idsite;
          private $den_social;
          private $pays_entr; 
          private $ville_entr;
          private $adresse_entr;
          private $code_interne;
          private  $id_nat;
          private $telephone_client;
          private $nom_respon;
          private $email_respon;
          private $telephone_respo; 
          private $numclasseur;
          private $datecrea;
          private $etat;
 
          
          function fx_CreerClient($idsite, $den_social, $pays_entr, $ville_entr, $adresse_entr, $code_interne, $id_nat, $telephone_client, $nom_respon, $email_respon, $telephone_respo, $numclasseur, $datecrea, $etat){
                    $this->idsite = $idsite;
                    $this->den_social = $den_social;
                    $this->pays_entr = $pays_entr; 
                    $this->ville_entr = $ville_entr;
                    $this->adresse_entr = $adresse_entr;
                    $this->code_interne = $code_interne;
                    $this->id_nat = $id_nat;
                    $this->telephone_client = $telephone_client;
                    $this->nom_respon = $nom_respon;
                    $this->email_respon = $email_respon;
                    $this->telephone_respo = $telephone_respo; 
                    $this->numclasseur = $numclasseur;
                    $this->datecrea = $datecrea;
                    $this->etat = $etat;
                    $requete='INSERT INTO client(idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat) VALUES ("'.$this->idsite.'", "'.$this->den_social.'", "'.$this->pays_entr.'", "'.$this->ville_entr.'", "'.$this->adresse_entr.'", "'.$this->code_interne.'", "'.$this->id_nat.'", "'.$this->telephone_client.'", "'.$this->nom_respon.'", "'.$this->email_respon.'", "'.$this->telephone_respo.'", "'.$this->numclasseur.'", "'.$this->datecrea.'", "'.$this->etat.'")';
                    $conn=new connect(); // preparation de la connexion
                    $resultat=$conn -> fx_ecriture($requete);
                    if ($resultat){
                        return $resultat;
                    }
                    else{
                        return false;
                    }
            }
            function fx_UpdateClient($idclient,$idsite, $den_social, $pays_entr, $ville_entr, $adresse_entr, $code_interne, $id_nat, $telephone_client, $nom_respon, $email_respon, $telephone_respo, $numclasseur, $datecrea, $etat){
                $this->idclient = $idclient;
                $this->idsite = $idsite;
                $this->den_social = $den_social;
                $this->pays_entr = $pays_entr; 
                $this->ville_entr = $ville_entr;
                $this->adresse_entr = $adresse_entr;
                $this->code_interne = $code_interne;
                $this->id_nat = $id_nat;
                $this->telephone_client = $telephone_client;
                $this->nom_respon = $nom_respon;
                $this->email_respon = $email_respon;
                $this->telephone_respo = $telephone_respo; 
                $this->numclasseur = $numclasseur;
                $this->datecrea = $datecrea;
                $this->etat = $etat;
                $requete='Update client set idsite="'.$this->idsite.'", den_social="'.$this->den_social.'", pays_entr="'.$this->pays_entr.'", ville_entr="'.$this->ville_entr.'", adresse_entr="'.$this->adresse_entr.'", code_interne="'.$this->code_interne.'", id_nat="'.$this->id_nat.'", telephone_client="'.$this->telephone_client.'", nom_respon="'.$this->nom_respon.'", email_respon="'.$this->email_respon.'", telephone_respo="'.$this->telephone_respo.'", numclasseur="'.$this->numclasseur.'", datecrea="'.$this->datecrea.'", etat="'.$this->etat.'" where idclient="'.$this->idclient.'" LIMIT 1';
                $conn=new connect(); // preparation de la connexion
                $resultat=$conn -> fx_ecriture($requete);
                if ($resultat){
                    return $resultat;
                }
                else{
                    return false;
                }
        }
                
                
        function fx_RechercheClientID($idclient){
            $this->idclient = $idclient;
            $requete=" SELECT idclient, idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat FROM client WHERE  idclient='".$this->idclient."'";
			//echo $requete; 
			  $conn=new connect();// preperation de la conexion
			  $resultat=$conn-> fx_lecture($requete);
				if ($resultat){			
					return $resultat;
				}
			   else{
					return false;
			   }
        }

        function fx_ActiverClient($idclient){
            $this->idclient = $idclient;
            $requete='Update client set etat=1 where idclient="'.$this->idclient.'" LIMIT 1';
            $conn=new connect(); // preparation de la connexion
            $resultat=$conn -> fx_ecriture($requete);
            if ($resultat){
                return $resultat;
            }
            else{
                return false;
            }
    }
    function fx_DesactiverClient($idclient){
        $this->idclient = $idclient;
        $requete='Update client set etat=0 where idclient="'.$this->idclient.'" LIMIT 1';
        $conn=new connect(); // preparation de la connexion
        $resultat=$conn -> fx_ecriture($requete);
        if ($resultat){
            return $resultat;
        }
        else{
            return false;
        }
    }
    function ListeGlobalClient(){
        $requete='select idclient, idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat from client';
        $conn=new connect(); // preparation de la connexion
        $resultat=$conn -> fx_ecriture($requete);
        if ($resultat){
            return $resultat;
        }
        else{
            return false;
        }

    }
    function ListeClientActif(){
        $requete='select idclient, idsite, den_social, pays_entr, ville_entr, adresse_entr, code_interne, id_nat, telephone_client, nom_respon, email_respon, telephone_respo, numclasseur, datecrea, etat from client where etat=1';
        $conn=new connect(); // preparation de la connexion
        $resultat=$conn -> fx_ecriture($requete);
        if ($resultat){
            return $resultat;
        }
        else{
            return false;
        }

    }

}
*/
?>