<?php
   include_once(__DIR__ . '/Config/ParamDB.php');
   class Tache{
    private $conn;
    public function __construct()
    {
    
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
    public function creerTache($data) {//data sera notre tableau qui va recevoir les données de paramètre
        $query = "INSERT INTO taches (nomtach, description, idresponsable, datelimite, observateur, prioritehaute, prioritemoyenne, prioritebasse, 
        fichier, createby, datecreate, statut
        ) VALUES (
            :nomtach, :description, :idresponsable, :datelimite, :observateur, :prioritehaute, :prioritemoyenne, :prioritebasse, 
        :fichier, :createby, :datecreate, :statut
        )";
        return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut
    }
    public function UpdateTache($data) {
        $Rqte = "UPDATE taches SET ";
        $dataset = [];
        $params = [];
        foreach ($data as $key => $value) {
            if ($key !== 'idtache') {
                $dataset[] = "$key = :$key";
            }
            $params[$key] = $value;
        }
        $Rqte .= implode(', ', $dataset) . " WHERE idtache = :idtache";
        return $this->executeQuery($Rqte, $params);
    }
    public function DeleteTaches($idtache){
        $query = "DELETE FROM taches where idtache = :idtache";
        $paramDelete=[':idutile'=>$idtache];
        return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut

    }
    public function listeGlobaleTache($offset = 0, $limit = 50) {
        $query = "SELECT nomtache, description, idresponsable, datelimite, observateur, prioritehaute, prioritemoyenne, prioritebasse, 
            fichier, createby, datecreate, statut  FROM taches 
            LIMIT :offset, :limit
        ";
        return $this->executeQuery($query, ['offset' => $offset, 'limit' => $limit]);
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
    public function DeleteTache($idtache){
        $query = "DELETE FROM taches where idtache = :idtache";
        $paramDelete=[':idtache'=>$idtache];
        return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut

    }
    
    public function getAgent() {
        $query = "SELECT  matagent, nomagent, postnomagent, prenomagent, sexeagent FROM agent order by nomagent asc";
        return $this->executeQuery($query);
    }



   }
?>