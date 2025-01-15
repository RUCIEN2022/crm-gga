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
       
        public function UpdateUser($data){
            //$query = "UPDATE utilisateur SET 
              //  idposte =  :idposte, idsite = :idsite, nomutile = :nomutile, prenomutile = :prenomutile, email = :email,
                //photo = :photo, motpasse = :motpasse, etatutile = :etatutile where idutile = :idutile ";
            //return $this->executeQuery($query, $data);//cfr les explication de la methode executeQuery ci-haut

            $Rqte = "UPDATE utilisateur SET ";
            $dataset = [];
            $params = [];
        
            foreach ($data as $key => $value) {
                if ($key !== 'idutile') {
                    $dataset[] = "$key = :$key";
                }
                $params[$key] = $value;
            }
        
            $Rqte .= implode(', ', $dataset) . " WHERE idutile = :idutile";
        
            return $this->executeQuery($Rqte, $params);

        }
        public function DeleteUser($idutile){
            $query = "DELETE FROM utilisateur where idutile = :idutile";
            $paramDelete=[':idutile'=>$idutile];
            return $this->executeQuery($query, $paramDelete);//cfr les explication de la methode executeQuery ci-haut

        }
        public function ChangerEtat($idutile){
            $query = "UPDATE utilisateur SET 
                etatutile = 0 where idutile = :idutile ";
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
        public function RechercheUser($idutile){
            $query = "SELECT U.idutile, P.idposte, S.idsite,libsite, libposte, nomutile, prenomutile, email, 
            photo, motpasse, etatutile FROM utilisateur U INNER JOIN poste P ON P.idposte=U.idposte 
           INNER JOIN site S ON s.idsite=U.idsite where idutile = :idutile";
            return $this->executeQuery($query, [':idutile' => $idutile]);//cfr les explication de la methode executeQuery ci-haut

        }
        public function ChangerMotdepasser($idutile, $motpasse){
            $query = "UPDATE utilisateur SET 
                motpasse = :motpasse where idutile = :idutile";
            $ParamCM=[':motpasse' => $motpasse, ':idutile' => $idutile];
            return $this->executeQuery($query, $ParamCM);//cfr les explication de la methode executeQuery ci-haut

        }
        public function TrouverMP($email){
            $query = "SELECT idutile, idposte, idsite, nomutile, prenomutile, email, photo, motpasse, etatutile 
                FROM utilisateur WHERE email = :email";
            return $this->executeQuery($query, [':email' => $email]);//cfr les explication de la methode executeQuery ci-haut


        }
        public function AuthentifierUser1($email,$motpasse){
            //$query = "SELECT * FROM utilisateur WHERE email = :email and motpasse = :motpasse";
            $query = "SELECT idutile, idposte, idsite, nomutile, prenomutile, email, photo, motpasse, etatutile 
                FROM utilisateur WHERE email = :email and motpasse = :motpasse";
            $ParamAut=[':email' => $this->TrouverMP($email), ':motpasse' => $motpasse];
            return $this->executeQuery($query, $ParamAut);//cfr les explication de la methode executeQuery ci-haut

        }
        public function AuthentifierUser($email,$motpasse){
                
        //-----------from jmas---------
            $zmotpass=$this->TrouverMP($email);
            $zmot=$zmotpass[0];
            $query = "SELECT idutile, idposte, idsite, nomutile, prenomutile, email, photo, motpasse, etatutile 
            FROM utilisateur WHERE email = :email and motpasse = :motpasse";
            $result = $this->executeQuery($query, ['email' => $email, 'motpasse' => $motpasse]);
            if (!$result || count($result) === 0) {
                throw new Exception("Aucun utilisateur trouvé avec cet email et cet mot de passe.");
            }

            $user = $result[0]; // Récupérer l'utilisateur
            
            // check le mot de passe haché ici avec password_verify
            
            // if (password_verify($motpasse, $user['motpasse'])) { 
                // throw new Exception("Mot de passe incorrect.");
                    // Supprimer le mot de passe avant de retourner les données
                    unset($user['motpasse']);
                    return $result;
                    //return ['status' => 200, 'message' => 'Authentification réussie', 'data' => $user];
            //}else{
                //   throw new Exception("Mot de passe incorrect.");
            //}
                              
        }
        public function EmailCheck($email) {
            $query = "SELECT COUNT(*) AS count FROM utilisateur WHERE email = :email";
            $result = $this->executeQuery($query, ['email' => $email]);
            // Retourne vrai si aucun utilisateur n'a cet email
            return isset($result[0]['count']) && $result[0]['count'] == 0;
        }
                                
        public function CreerUser($data) {
            // Vérifier si l'email est fourni et valide
            if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("L'email fourni est invalide ou manquant.");
            }

            // Vérifier si l'email est unique
            if (!$this->EmailCheck($data['email'])) {
                throw new Exception("Cet email est déjà utilisé.");
            }

            // Valider et hacher le mot de passe
            if (!isset($data['motpasse']) || empty($data['motpasse'])) {
                throw new Exception("Le mot de passe est obligatoire.");
            }
            //hachage
            $data['motpasse'] = password_hash($data['motpasse'], PASSWORD_DEFAULT);

            // reqte d'insertion
            $query = "INSERT INTO utilisateur (
                idposte, idsite, nomutile, prenomutile, email, photo, motpasse, etatutile
            ) VALUES (
                :idposte, :idsite, :nomutile, :prenomutile, :email, :photo, :motpasse, :etatutile
            )";

            return $this->executeQuery($query, $data);
        }
                      
    }
?>