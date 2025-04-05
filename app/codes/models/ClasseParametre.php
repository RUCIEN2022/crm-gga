<?php
include_once(__DIR__ . '/Config/ParamDB.php');
class Parametre{
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
    public function getTotalClient() {
        $query = "SELECT COUNT(*) AS total_client FROM client";
        return $this->executeQuery($query);
    }

    public function getTotalUser() {
        $query = "SELECT COUNT(*) AS total_user FROM utilisateur WHERE etatutile = '1'";
        return $this->executeQuery($query);
    }

    public function getTotalInterm() {
        $query = "SELECT COUNT(*) AS total_inter FROM intermediaire WHERE etat = '1'";
        return $this->executeQuery($query);
    }
    public function getTotalPartenaire() {
        $query = "SELECT COUNT(*) AS total_part FROM partenaire ";
        return $this->executeQuery($query);
    }
    public function getTotalSite() {
        $query = "SELECT COUNT(*) AS total_site FROM site ";
        return $this->executeQuery($query);
    }
    public function getTotalPoste() {
        $query = "SELECT COUNT(*) AS total_poste FROM poste";
        return $this->executeQuery($query);
    }
    public function getTotalProfil() {
        $query = "SELECT COUNT(*) AS total_profil FROM Profil";
        return $this->executeQuery($query);
    }
    public function listePoste() {
        $query = "SELECT idposte, idprofil, libposte FROM poste order by libposte asc";
        return $this->executeQuery($query);
    }
    public function EmailCheck($email) {
        $query = "SELECT COUNT(*) AS count FROM intermediaire WHERE email = :email";
        $result = $this->executeQuery($query, ['email' => $email]);
        // Retourne vrai si aucun utilisateur n'a cet email
        return isset($result[0]['count']) && $result[0]['count'] == 0;
}
            
public function CreerIntermediaire($data) {
        // Vérifier si l'email est fourni et valide
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email fourni est invalide ou manquant.");
        }

        // Vérifier si l'email est unique
        if (!$this->EmailCheck($data['email'])) {
            throw new Exception("Cet email est déjà utilisé.");
        }

        // reqte d'insertion
        $query = "INSERT INTO intermediaire (
            numeroarca, nomcomplet, telephone, email, adresse, etat
        ) VALUES (
            :numeroarca, :nomcomplet, :telephone, :email, :adresse, :etat
        )";

        return $this->executeQuery($query, $data);
}

}
?>