<?php
    include_once(__DIR__ . '/Config/ParamDB.php');
    class Intermediaire{
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
            public function fx_CreerIntermediaire($data) {//data sera notre tableau qui va recevoir les données de paramètre
                $query = "INSERT INTO partenaire(denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre, telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire) 
                VALUES (:denom_social, :pays_assu, :ville_assu, :adresse_assu, :code_interne, :numeroAgree, :Rccm, :numero_impot, :emailEntre, :telephone_Entr, :nomRespo, :emailRespo, :TelephoneRespo, :etatpartenaire)";
               // echo $query;
                return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut
            }
            public function DeleteIntermediaire($idpartenaire){
                $query = "DELETE FROM partenaire where idpartenaire = :idpartenaire";
                $paramDelete=[':idutile'=>$idpartenaire];
                return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut
    
            }
            public function fx_UpdateIntermediaire($data){
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
            public function ListeIntermediaire(){
                $query = "SELECT intermediaire.idinte,intermediaire.numeroarca,intermediaire.nomcomplet,intermediaire.telephone,intermediaire.email,intermediaire.adresse 
                FROM intermediaire WHERE intermediaire.etat=1";
                return $this->executeQuery($query);
            }
            public function RechercheIntermediaire($idint){
                $query = "SELECT idpartenaire, denom_social, pays_assu, ville_assu, adresse_assu, code_interne, numeroAgree, Rccm, numero_impot, emailEntre,
                 telephone_Entr, nomRespo, emailRespo, TelephoneRespo, etatpartenaire, adresseip FROM partenaire where idpartenaire = :idpartenaire";
                return $this->executeQuery($query, [':idpartenaire' => $idint]);
            }
            public function fx_ActiverIntermediaire($idpartenaire){
                $query = "UPDATE partenaire set etatpartenaire=1 where idpartenaire = :idpartenaire LIMIT 1";
                return $this->executeQuery($query, [':idpartenaire' => $idpartenaire]);
            }
            public function fx_desactiverIntermediaire($idpartenaire){
                $query = "UPDATE partenaire set etatpartenaire=0 where idpartenaire = :idpartenaire LIMIT 1";
                return $this->executeQuery($query, [':idpartenaire' => $idpartenaire]);
            }

    }
   
?>