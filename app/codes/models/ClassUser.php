<?php
    include_once(__DIR__ . '/Config/ParamDB.php');
    class Utilisateur{
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

        public function CreerUser($data){
            $query = "INSERT INTO utilisateur (
                idposte, idsite, nomutile, prenomutile, email, photo, motpasse, etatutile
            ) VALUES (
                :idposte, :idsite, :nomutile, :prenomutile, :email, :photo, :motpasse, :etatutile
            )";
            return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut

        }
        public function UpdateUser($data){
            $query = "UPDATE utilisateur SET 
                idposte =  :idposte, idsite = :idsite, nomutile = :nomutile, prenomutile = :prenomutile, email = :email,
                photo = :photo, motpasse = :motpasse, etatutile = :etatutile where idutile = :idutile ";
            return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut

        }
        public function DeleteUser($idutile){
            $query = "DELETE FROM utilisateur where idutile = :idutile ";
            $paramDelete=[':idutile'=>$idutile];
            return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut

        }
        public function ActiverUser($idutile){
            $query = "UPDATE utilisateur SET 
                etatutile = 1 where idutile = :idutile ";
            return $this->executeQuery($query, [':idutile'=>$idutile]);//cfr les explication de la methode executeQuery ci-haut

        }
        public function DesactiverUser($idutile){
            $query = "UPDATE utilisateur SET 
                etatutile = 0 where idutile = :idutile ";
            return $this->executeQuery($query, [':idutile'=>$idutile]);//cfr les explication de la methode executeQuery ci-haut

        }
        public function ListeUser(){
            $query = "SELECT U.idutile, P.idposte, S.idsite,libsite, libposte, nomutile, prenomutile, email, 
            photo, motpasse, etatutile FROM utilisateur U INNER JOIN poste P ON P.idposte=U.idposte 
           INNER JOIN site S ON s.idsite=U.idsite ";
            return $this->executeQuery($query);//cfr les explication de la methode executeQuery ci-haut

        }
        public function ChangerMotdepasser($idutile, $motpasse){
            $query = "UPDATE utilisateur SET 
                motpasse = :motpasse where idutile = :idutile";
            $ParamCM=[':motpasse' => $motpasse, ':idutile' => $idutile];
            return $this->executeQuery($query, $ParamCM);//cfr les explication de la methode executeQuery ci-haut

        }
        public function TrouverMP($email){
            $query = "SELECT * FROM utilisateur WHERE email = :email";
            return $this->executeQuery($query, [':email' => $email]);//cfr les explication de la methode executeQuery ci-haut

        }
        public function AuthentifierUser($email,$motpasse){
            $query = "SELECT * FROM utilisateur WHERE email = :email and motpasse = :motpasse";
            $ParamAut=[':email' => $email, ':motpasse' => $this->TrouverMP($motpasse)];
            return $this->executeQuery($query, $ParamAut);//cfr les explication de la methode executeQuery ci-haut

        }

        public function fx_resetpwd($email){
        // Générer un mot de passe temporaire
                $temporaryPassword = $this->RandomPassword();
                $hashedPassword = password_hash($temporaryPassword, PASSWORD_BCRYPT);

                $Rqte = "UPDATE utilisateur SET motpasse = :motpasse WHERE email = :email";
                $params = [
                    'motpasse' => $hashedPassword,
                    'email' => $email
                ];
                $success = $this->executeQuery($Rqte, $params);
                if ($success) {
                    return [
                        'status' => 'success',
                        'temporaryPassword' => $temporaryPassword,
                        'message' => 'Mot de passe réinitialisé avec succès.'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Erreur lors de la réinitialisation du mot de passe.'
                    ];
                }
            }

        
            private function RandomPassword($length = 10)
            {
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
                $password = '';
                for ($i = 0; $i < $length; $i++) {
                    $password .= $characters[random_int(0, strlen($characters) - 1)];
                }
                return $password;
            }


        
             
    }
?>