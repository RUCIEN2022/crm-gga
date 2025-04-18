<?php
//require 'vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';

//require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Titres correspondant aux champs de la table
$titres = [
    'denom_social', 'pays_assu', 'ville_assu', 'adresse_assu', 'code_interne',
    'numeroAgree', 'Rccm', 'numero_impot', 'emailEntre', 'telephone_Entr',
    'nomRespo', 'emailRespo', 'TelephoneRespo'
];

// Remplir les titres dans le fichier Excel
$colonne = 'A';
foreach ($titres as $titre) {
    $sheet->setCellValue($colonne.'1', $titre);
    $colonne++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'modele_partenaires.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
