<?php
    include_once(__DIR__ . '/Config/ParamDB.php');
    class Partenaire{
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
                        //echo $query;
                        return $this->conn->fx_ecriture($query, $params); // Écriture
                    }
                } catch (Exception $e) {
                    // En cas d'erreur, retourne false
                    return false;
                }
            }
             // Création Partenaire
            public function fx_CreerPartenaire($data) {//data sera notre tableau qui va recevoir les données de paramètre
                $query = "INSERT INTO partenaire(denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre, telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire) 
                VALUES (:denom_social, :pays_assu, :ville_assu, :adresse_assu, :code_interne, :numeroAgree, :Rccm, :numero_impot, :emailEntre, :telephone_Entr, :nomRespo, :emailRespo, :TelephoneRespo, :etatpartenaire)";
               // echo $query;
                return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut
            }
            public function DeletePartenaire($idpartenaire){
                $query = "DELETE FROM partenaire where idpartenaire = :idpartenaire";
                $paramDelete=[':idutile'=>$idpartenaire];
                return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut
    
            }
            public function fx_UpdatePartenaire($data){
               // $query = "UPDATE partenaire set denom_social = :denom_social, pays_assu = :pays_assu, ville_assu = :ville_assu, adresse_assu = :adresse_assu, code_interne = :code_interne,
                 //numeroAgree = :numeroAgree, Rccm = :Rccm, numero_impot = :numero_impot, emailEntre = :emailEntre, telephone_Entr = :telephone_Entr, nomRespo = :nomRespo, emailRespo = :emailRespo, TelephoneRespo = :TelephoneRespo where idpartenaire = :idpartenaire ";
                //return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut

                $Rqte = "UPDATE partenaire SET ";
                $dataset = [];
                $params = [];
            
                foreach ($data as $key => $value) {
                    if ($key !== 'idpartenaire') {
                        $dataset[] = "$key = :$key";
                    }
                    $params[$key] = $value;
                }
            
                $Rqte .= implode(', ', $dataset) . " WHERE idpartenaire = :idpartenaire";
            
                return $this->executeQuery($Rqte, $params);
    
            }
            public function ListePartenaire(){
                $query = "SELECT idpartenaire, denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre,
                 telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire, adresseip FROM partenaire where etatpartenaire = 1";
                return $this->executeQuery($query);
            }
            public function RecherchePartenaire($idpartenaire){
                $query = "SELECT idpartenaire, denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre,
                 telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire, adresseip FROM partenaire where idpartenaire = :idpartenaire";
                return $this->executeQuery($query, [':idpartenaire' => $idpartenaire]);
            }
            public function fx_ActiverPartenaire($idpartenaire){
                $query = "UPDATE partenaire set etatpartenaire=1 where idpartenaire = :idpartenaire LIMIT 1";
                return $this->executeQuery($query, [':idpartenaire' => $idpartenaire]);
            }
            public function fx_desactiverPartenaire($idpartenaire){
                $query = "UPDATE partenaire set etatpartenaire=0 where idpartenaire = :idpartenaire LIMIT 1";
                return $this->executeQuery($query, [':idpartenaire' => $idpartenaire]);
            }

    }
    /*
        include_once("../models/Config/ParamDB.php");

        class Partenaire{
            private $idpartenaire;
            private $denom_social;
            private $pays_assu; 
            private $ville_assu; 
            private $adresse_assu;
            private $code_interne;
            private $numeroAgree;
            private $Rccm;
            private $numero_impot;
            private $emailEntre;
            private $telephone_Entr;
            private $nomRespo;
            private $emailRespo; 
            private $TelephoneRespo;
            private $etatpartenaire;

            function fx_CreerPartenaire($denom_social, $pays_assu, $ville_assu, $adresse_assu, $code_interne, $numeroAgree, $Rccm, $numero_impot, $emailEntre, $telephone_Entr, $nomRespo, $emailRespo, $TelephoneRespo, $etatpartenaire){
                    $this->denom_social = $denom_social;
                    $this->pays_assu = $pays_assu; 
                    $this->ville_assu = $ville_assu; 
                    $this->adresse_assu = $adresse_assu;
                    $this->code_interne = $code_interne;
                    $this->numeroAgree = $numeroAgree;
                    $this->Rccm = $Rccm;
                    $this->numero_impot = $numero_impot;
                    $this->emailEntre = $emailEntre;
                    $this->telephone_Entr = $telephone_Entr;
                    $this->nomRespo = $nomRespo;
                    $this->emailRespo = $emailRespo; 
                    $this->TelephoneRespo = $TelephoneRespo;
                    $this->etatpartenaire = $etatpartenaire;

                    $requete='INSERT INTO partenaire(denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre, telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire) VALUES ("'.$this->denom_social.'", "'.$this->pays_assu.'", "'.$this->ville_assu.'", "'.$this->adresse_assu.'", "'.$this->code_interne.'", "'.$this->numeroAgree.'", "'.$this->Rccm.'", "'.$this->numero_impot.'", "'.$this->emailEntre.'", "'.$this->telephone_Entr.'", "'.$this->nomRespo.'", "'.$this->emailRespo.'", "'.$this->TelephoneRespo.'", "'.$this->etatpartenaire.'")';
                    
                    $conn=new connect();// preperation de la conexion
                    $resultat=$conn -> fx_ecriture($requete);// execution de la requete
                    if ($resultat){
                        return $resultat;
                    }
                    else{
                        return false;
                    }
            }
            function fx_UpdatePartenaire($idpartenaire,$denom_social, $pays_assu, $ville_assu, $adresse_assu, $code_interne, $numeroAgree, $Rccm, $numero_impot, $emailEntre, $telephone_Entr, $nomRespo, $emailRespo, $TelephoneRespo, $etatpartenaire){
                $this->idpartenaire = $idpartenaire;
                $this->denom_social = $denom_social;
                $this->pays_assu = $pays_assu; 
                $this->ville_assu = $ville_assu; 
                $this->adresse_assu = $adresse_assu;
                $this->code_interne = $code_interne;
                $this->numeroAgree = $numeroAgree;
                $this->Rccm = $Rccm;
                $this->numero_impot = $numero_impot;
                $this->emailEntre = $emailEntre;
                $this->telephone_Entr = $telephone_Entr;
                $this->nomRespo = $nomRespo;
                $this->emailRespo = $emailRespo; 
                $this->TelephoneRespo = $TelephoneRespo;
                $this->etatpartenaire = $etatpartenaire;

                $requete='Update partenaire set denom_social="'.$this->denom_social.'", pays_assu="'.$this->pays_assu.'", ville_assu="'.$this->ville_assu.'", adresse_assu="'.$this->adresse_assu.'", code_interne="'.$this->code_interne.'", numeroAgree="'.$this->numeroAgree.'", Rccm="'.$this->Rccm.'", numero_impot="'.$this->numero_impot.'", emailEntre="'.$this->emailEntre.'", telephone_Entr="'.$this->telephone_Entr.'", nomRespo="'.$this->nomRespo.'", emailRespo="'.$this->emailRespo.'", TelephoneRespo="'.$this->TelephoneRespo.'" where idpartenaire="'.$this->TelephoneRespo.'"';
                
                $conn=new connect();// preperation de la conexion
                $resultat=$conn -> fx_ecriture($requete);// execution de la requete
                if ($resultat){
                    return $resultat;
                }
                else{
                    return false;
                }
            }
            function ListePartenaire(){
                $requete='SELECT idpartenaire, denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre, telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire, adresseip, FROM partenaire';
                $conn=new connect(); // preparation de la connexion
                $resultat=$conn -> fx_ecriture($requete);
                if ($resultat){
                    return $resultat;
                }
                else{
                    return false;
                }
            }
            function fx_ActiverPartenaire($idpartenaire){
                $this->idpartenaire = $idpartenaire;
            // $this->etatpartenaire = $etatpartenaire;
                $requete='Update partenaire set etatpartenaire=1 where idpartenaire="'.$this->etatpartenaire.'"';
                $conn=new connect();// preperation de la conexion
                $resultat=$conn -> fx_ecriture($requete);// execution de la requete
                if ($resultat){
                    return $resultat;
                }
                else{
                    return false;
                }
            }
            function fx_DesactiverPartenaire($idpartenaire){
                $this->idpartenaire = $idpartenaire;
            // $this->etatpartenaire = $etatpartenaire;
                $requete='Update partenaire set etatpartenaire=0 where idpartenaire="'.$this->etatpartenaire.'"';
                $conn=new connect();// preperation de la conexion
                $resultat=$conn -> fx_ecriture($requete);// execution de la requete
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