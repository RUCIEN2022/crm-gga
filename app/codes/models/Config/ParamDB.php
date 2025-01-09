
<?php
class connect {

    private $username = "root";
    private $mdp = "";
    private $dsn = 'mysql:host=localhost;dbname=db_gga;port=3306;charset=utf8';
    private $ckx; // Instance PDO

    // Méthode connexion
    function fx_connexion() {
        try {
            $this->ckx = new PDO($this->dsn, $this->username, $this->mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->ckx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gérer les erreurs
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode pour obtenir l'instance PDO
    public function getConnection() {
        if ($this->ckx === null) {
            $this->fx_connexion();
        }
        return $this->ckx;
    }

    // Démarrer une transaction
    public function beginTransaction() {
        $this->fx_connexion();
        $this->ckx->beginTransaction();
    }

    // Valider la transaction
    public function commit() {
        $this->fx_connexion();
        $this->ckx->commit();
    }

    //Annuler la transaction
    public function rollback() {
        $this->fx_connexion();
        $this->ckx->rollBack();
    }

    function fx_ecriture($sql, $params = []) {
        $this->fx_connexion();
        $stmt = $this->ckx->prepare($sql);
        return $stmt->execute($params);
    }

    function fx_lecture($sql, $params = []) {
        $this->fx_connexion();
        $stmt = $this->ckx->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

/*
class connect{
 
//online access

 //private $username="usermutuel";
 //Private $mdp="wLY-H2.4uWypFnfy";
 //private $dsn='mysql:host=localhost;dbname=mutuelpro_db;port=3306;charset=utf8';// creation des attributs
 //private $ckx; // Instance PDO
 //local access
 
 private $username = "root";
 private $mdp = "devpro";
 private $dsn = 'mysql:host=localhost;dbname=db_gga;port=3306;charset=utf8';
 private $ckx; // Instance PDO

 // Méthode pour établir la connexion
 function fx_connexion() {
     try {
         $this->ckx = new PDO($this->dsn, $this->username, $this->mdp, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
         $this->ckx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Pour gérer les erreurs
     } catch (PDOException $e) {
         die("Erreur de connexion : " . $e->getMessage());
     }
 }

 // Méthode pour obtenir l'instance PDO
 public function getConnection() {
     if ($this->ckx === null) {
         $this->fx_connexion();
     }
     return $this->ckx;
 }

 function fx_ecriture($sql) {
     $this->fx_connexion();
     return $this->ckx->exec($sql);
 }

 function fx_lecture($sql) {
     $this->fx_connexion();
     return $this->ckx->query($sql);
 }

 function fx_modifier($sql) {
     $this->fx_connexion();
     return $this->ckx->exec($sql);
 }
}//creation de class
*/

?>