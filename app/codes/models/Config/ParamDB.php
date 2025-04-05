<?php
class connect {
    private $username = "root";
    private $mdp = "devpro";
    private $dsn = 'mysql:host=localhost;dbname=db_gga;port=3306;charset=utf8';
    private $ckx = null; // Instance PDO

    private function fx_connexion() {
        if ($this->ckx === null) {
            try {
                $this->ckx = new PDO($this->dsn, $this->username, $this->mdp, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ]);
                $this->ckx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                error_log("Erreur de connexion : " . $e->getMessage());
                die("Erreur de connexion : Vérifiez les logs.");
            }
        }
    }

    public function getConnection() {
        $this->fx_connexion();
        return $this->ckx;
    }

    public function beginTransaction() {
        $this->fx_connexion();
        $this->ckx->beginTransaction();
    }

    public function commit() {
        if ($this->ckx !== null) {
            $this->ckx->commit();
        }
    }

    public function rollback() {
        if ($this->ckx !== null) {
            $this->ckx->rollBack();
        }
    }

    function fx_ecriture($sql, $params = []) {
        $this->fx_connexion();
        try {
            $stmt = $this->ckx->prepare($sql);
            if (!$stmt->execute($params)) {
                $errorInfo = $stmt->errorInfo();
                error_log("Erreur SQL (fx_ecriture) : " . implode(" | ", $errorInfo));
                return false;
            }
            if (strpos(trim(strtoupper($sql)), 'INSERT') === 0) {
                return $this->ckx->lastInsertId();
            }
            return true;
        } catch (PDOException $e) {
            error_log("Exception SQL (fx_ecriture) : " . $e->getMessage());
            return false;
        }
    }

    function fx_lecture($sql, $params = []) {
        $this->fx_connexion();
        try {
            $stmt = $this->ckx->prepare($sql);
            if (!$stmt->execute($params)) {
                $errorInfo = $stmt->errorInfo();
                error_log("Erreur SQL (fx_lecture) : " . implode(" | ", $errorInfo));
                return false;
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Exception SQL (fx_lecture) : " . $e->getMessage());
            return false;
        }
    }

    public function lastInsertId() {
        return $this->ckx->lastInsertId();
    }
}

?>
