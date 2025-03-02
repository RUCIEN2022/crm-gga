<?php
include_once(__DIR__ . '/Config/ParamDB.php');
class Administraction{
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

    public function CreerReception_facture($data){
         // reqte d'insertion
   
        $query ="INSERT INTO reception_facture(id_prestataire, tp, rd, numero_facture, date_reception, 
        periode_prestation, moyen_reception, montant_facture) VALUES (:id_prestataire, :tp, :rd, :numero_facture, :date_reception, 
        :periode_prestation, :moyen_reception, :montant_facture)";

        return $this->executeQuery($query, $data);
    }
    public function getListereception_facture(){
       
        $query = "SELECT id_facture, id_prestataire, tp, rd, numero_facture, date_reception, periode_prestation, moyen_reception, montant_facture FROM reception_facture";
        return $this->executeQuery($query);

    }
    public function CreerPrestataire($data){
        // reqte d'insertion
       $query ="INSERT INTO prestataires(nom_prestataire, adresse, contact, email, rib)
       VALUES (:nom_prestataire, :adresse, :contact, :email, :rib)";
       return $this->executeQuery($query, $data);
    }
    public function getListePrestataire(){

        $query = "SELECT id_prestataire, nom_prestataire, adresse, contact, email, rib FROM prestataires";
        return $this->executeQuery($query);
    }
    public function CreerCourrierEntrant($data){
        // reqte d'insertion
       $query ="INSERT INTO courriers_entrants(date_arrivee, expediteur, objet, numref, type_courrier)
       VALUES (:date_arrivee, :expediteur, :objet, :numref, :type_courrier)";
       return $this->executeQuery($query, $data);
    }
    public function getListeCE(){
        $query = "SELECT id_courrier, date_arrivee, expediteur, objet, numref, type_courrier FROM courriers_entrants";
        return $this->executeQuery($query);
    }
    public function CreerCourrierSortant($data){
        // reqte d'insertio
       $query ="INSERT INTO courriers_sortants(num_reference, date_depart, destinateur, objet, type_courrier)
        VALUES (:num_reference, :date_depart, :destinateur, :objet, :type_courrier)";
       return $this->executeQuery($query, $data);
    }
    public function getListeCS(){
        $query = "SELECT id_courrier, num_reference, date_depart, destinateur, objet, numref, type_courrier FROM courriers_sortants";
        return $this->executeQuery($query);
    }

    public function getTotalPrestataire() {
        $query = "SELECT COUNT(*) AS total_prest FROM prestataires ";
        return $this->executeQuery($query);
    }
    public function getTotalFactureRecu() {
        $query = "SELECT COUNT(*) AS total_fact FROM reception_facture ";
        return $this->executeQuery($query);
    }
    public function getTotalCE() {
        $query = "SELECT COUNT(*) AS total_CE FROM courriers_entrants ";
        return $this->executeQuery($query);
    }
    public function getTotalCS() {
        $query = "SELECT COUNT(*) AS total_CS FROM courriers_sortants ";
        return $this->executeQuery($query);
    }

}
?>