<?php
include_once ("../models/Config/ClasseParamDB.php");

// Création d'une instance de la classe connect
$db = new connect();

// Si on est après le 15 du mois, vérifier les paiements des souscripteurs
if (date('d') > 15) {
    // Sélectionner les souscripteurs actifs qui n'ont pas payé ce mois-ci
    $sql = "SELECT a.IdSouscrip 
            FROM adhesion a 
            JOIN souscripteur s ON a.IdSouscrip = s.IdSouscrip 
            WHERE a.Statut_adhes = '1' 
            AND a.IdSouscrip NOT IN (
                SELECT p.id_affilie 
                FROM perception p 
                WHERE MONTH(p.date_p) = MONTH(CURDATE()) 
                AND YEAR(p.date_p) = YEAR(CURDATE())
            )";

    // Exécution de la requête
    $result = $db->fx_lecture($sql);

    if ($result && $result->rowCount() > 0) {
        // Parcours des résultats pour désactiver les souscripteurs concernés
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $IdSouscrip = $row['IdSouscrip'];
            // Mise à jour du statut à 'inactive'
            $sql_update = "UPDATE adhesion SET Statut_adhes = '2' WHERE IdSouscrip = :IdSouscrip";
            $update_stmt = "UPDATE adhesion SET Statut_adhes = '2' WHERE IdSouscrip = " . $IdSouscrip;
            $db->fx_modifier($update_stmt);
        }
    }
}
?>
