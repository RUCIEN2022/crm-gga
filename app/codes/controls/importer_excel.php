<?php
require __DIR__ . '/../../../vendor/autoload.php';
include_once(__DIR__ . '/../models/ClassPartenaire.php');
use PhpOffice\PhpSpreadsheet\IOFactory;

$partenaire = new Partenaire();
$message = '';
$type_message = ''; // succès ou erreur

if (isset($_POST['Envoyer'])) {

    if ($_FILES['fichier']['error'] == 0) {

        $fichier = $_FILES['fichier']['tmp_name'];
        $spreadsheet = IOFactory::load($fichier);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Entêtes attendues
        $entetes_attendues = [
            'A' => 'denom_social',
            'B' => 'pays_assu',
            'C' => 'ville_assu',
            'D' => 'adresse_assu',
            'E' => 'code_interne',
            'F' => 'numeroAgree',
            'G' => 'Rccm',
            'H' => 'numero_impot',
            'I' => 'emailEntre',
            'J' => 'telephone_Entr',
            'K' => 'nomRespo',
            'L' => 'emailRespo',
            'M' => 'TelephoneRespo'
        ];

        // Validation structure Excel
        foreach ($entetes_attendues as $col => $titre) {
            if (!isset($rows[1][$col]) || strtolower(trim($rows[1][$col])) !== strtolower(trim($titre))) {
                $message = "Erreur : la colonne '$titre' attendue à la position '$col' est absente ou incorrecte.";
                $type_message = 'danger';
                break;
            }
        }

        // Importation seulement si pas d'erreur de structure
        if(empty($message)){
            unset($rows[1]); // enlève l'entête
            $success = true;

            foreach ($rows as $row) {
                $data = [
                    ':denom_social'   => $row['A'],
                    ':pays_assu'      => $row['B'],
                    ':ville_assu'     => $row['C'],
                    ':adresse_assu'   => $row['D'],
                    ':code_interne'   => $row['E'],
                    ':numeroAgree'    => $row['F'],
                    ':Rccm'           => $row['G'],
                    ':numero_impot'   => $row['H'],
                    ':emailEntre'     => $row['I'],
                    ':telephone_Entr' => $row['J'],
                    ':nomRespo'       => $row['K'],
                    ':emailRespo'     => $row['L'],
                    ':TelephoneRespo' => $row['M'],
                    ':etatpartenaire' => 1
                ];

                if (!$partenaire->fx_CreerPartenaire($data)) {
                    $success = false;
                    $message = "Erreur lors de l'insertion dans la base de données.";
                    $type_message = 'danger';
                    break;
                }
            }

            if ($success) {
                $message = "Importation réussie avec succès !";
                $type_message = 'success';
            }
        }

    } else {
        $message = "Erreur lors du chargement du fichier.";
        $type_message = 'danger';
    }
}
?>
