<?php
include_once(__DIR__ . '/Config/ParamDB.php');

class Commercial{
    
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

    public function CreerProspect($data){
        $query ="INSERT INTO prospect(nom, adresse, telephone, email, date_prospection, moyen_contact_id, type_prospect_id) 
        VALUES (:nom, :adresse, :telephone, :email, :date_prospection, :moyen_contact_id, :type_prospect_id)";
        return $this->executeQuery($query, $data);
    } 
    public function CreerProduit($data){
        $query ="INSERT INTO produit(nom, formule, type_gestion, montant_annuel) 
        VALUES (:nom, :formule, :type_gestion, :montant_annuel)";
        return $this->executeQuery($query, $data);
    } 
    public function insertVente($data){
        $query ="INSERT INTO vente(produit_id, client_id, date_vente) 
        VALUES (:produit_id, :client_id, :date_vente)";
        return $this->executeQuery($query, $data);
    } 
    


    public function listeProspect(){
        $query = "SELECT
                p.id,
                p.nom,
                p.adresse,
                p.telephone,
                p.email,
                p.date_naissance,
                p.date_prospection,
                mc.libelle AS moyen_contact,
                tp.libelle AS type_prospect
            FROM prospect p
            LEFT JOIN moyen_contact mc ON p.moyen_contact_id = mc.id
            LEFT JOIN type_prospect tp ON p.type_prospect_id = tp.id
            ORDER BY p.date_prospection DESC";
        return $this->executeQuery($query);

    }
    public function getTotalProspect() {
        $query = "SELECT COUNT(*) AS total_prospect FROM prospect";
        return $this->executeQuery($query);
    }
    public function getClient() {
        $query = "SELECT COUNT(*) AS total_client FROM client_pro";
        return $this->executeQuery($query);
    }
    public function getProduit() {
        $query = "SELECT COUNT(*) AS total_produit FROM produit";
        return $this->executeQuery($query);
    }
    public function getProduitVendu() {
        $query = "SELECT SUM(p.montant_annuel) AS total_general_ventes
        FROM vente v JOIN produit p ON v.produit_id = p.id";
        return $this->executeQuery($query);
    }
    public function getTypeProspect(){
        $query = "SELECT id, libelle FROM type_prospect";
        return $this->executeQuery($query);

    }
    public function getMoyen(){
        $query = "SELECT id, libelle FROM moyen_contact";
        return $this->executeQuery($query);

    }
    public function getListeClient(){
        $query = "SELECT id, nom, adresse, telephone, email, formule_souscrite, date_effet, date_echeance, nb_beneficiaires, agent, conjoint, enfant, type_id FROM client_pro";
        return $this->executeQuery($query);

    }
    public function getListeProduit(){
        $query = "SELECT id, nom, formule,  type_gestion, montant_annuel FROM produit";
        return $this->executeQuery($query);
    }

}

?>