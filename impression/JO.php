<?php
//require_once __DIR__ . '/vendor/autoload.php'; // Autoload for FPDF & QR
require_once __DIR__ . '/../vendor/autoload.php';

require('../vendor/setasign/fpdf/fpdf.php'); // Assure-toi que FPDF est bien installé dans ce dossier
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
// Connexion à la base de données
session_start();
include_once(__DIR__ . '/../app/codes/models/ClassFinance.php');

$fina = new Finance();

// Récupérer les données du journal

// Récupération des dates
$data = [];
$data['date1'] = $_GET['date_debut'] ?? '';
$data['date2'] = $_GET['date_fin'] ?? '';

if (!$data['date1'] || !$data['date1']) {
    die("Plage de dates invalide.");
}
$stmt = $fina->getJournalParDate($data);

// mes dates

// Traitement des dates AVANT la création du PDF
$date1 = new DateTime($data['date1']);
$formattedDate1 = $date1->format('d/m/Y');
$date2 = new DateTime($data['date2']);
$formattedDate2 = $date2->format('d/m/Y');

class PDF extends FPDF {
    public $formattedDate1;
    public $formattedDate2;

    function setDates($d1, $d2) {
        $this->formattedDate1 = $d1;
        $this->formattedDate2 = $d2;
    }
    function Header() {
            // Affiche le grand logo centré en haut
            $logoPath = __DIR__ . '/../ressources/logogga2.png';
             if (file_exists($logoPath)) {
                $this->Image($logoPath, 10, 10, 190); // Large logo
            }

            // Saut de ligne suffisant pour passer en dessous du logo
            $this->SetY(40); // Ajuste si ton logo est plus haut

            // Titre du rapport
            $this->SetFont('Arial', 'B', 14);
            //$this->Cell(0, 10, utf8_decode("Journal de transaction du " . $this->$formattedDate1. " au ". $formattedDate2), 0, 1, 'C');
            $this->Cell(0, 10, utf8_decode("Journal de transaction du " . $this->formattedDate1 . " au " . $this->formattedDate2), 0, 1, 'C');

            // 🟥 Ligne de séparation (bordeaux)
            $this->SetDrawColor(153);
           // $this->SetDrawColor(128, 0, 32);
            //$this->SetLineWidth(0.4);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->SetDrawColor(0); // reinialiser la couleur de la line
            // 📋 En-tête du tableau
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(200, 200, 200);
            $this->Cell(10, 10, '#', 1, 0, 'C', true);
            $this->Cell(30, 10, 'Date', 1, 0, 'C', true);
            $this->Cell(30, 10, 'Opération', 1, 0, 'C', true);
            $this->Cell(30, 10, 'Compte', 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Crédit'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Débit'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Solde'), 1, 1, 'C', true);

    }

   
   function Footer() {
    // Ligne horizontale    
    // Ligne de séparation en rouge bordeaux
    $this->SetY(-30);
    $this->SetLineWidth(0.4);
    $this->SetDrawColor(128, 0, 32); // Rouge bordeaux
    $this->Line(10, $this->GetY(), 200, $this->GetY());

    // QR Code à gauche
    $qrText = "Date impression : " . date('Y-m-d H:i:s');
    $nomutile="rucien";
    // 📦 Génération QR code (nom + promo)
    $qr = QrCode::create($qrText. ' - ' .$nomutile);
    $writer = new PngWriter();
    $qrPath = 'qrcode.png';
    $result = $writer->write($qr);
    $result->saveToFile($qrPath);
    // 🖼️ QR Code
   // $pdf->Image($qrPath, 25, $pdf->GetY(), 30);
    $this->Image($qrPath, 10, $this->GetY() + 2, 20, 20); // Affiche le QR code à gauche


     // 📜 Texte centré
     $this->SetXY(35, $this->GetY() + 2); // Position à droite du QR
     $this->SetFont('Arial', '', 6.5);
     $texteInfo = 'GROUPEMENT DE GESTION ET D \’ ASSURANCE RDC – S.A. AVEC CONSEIL D\’ADMINISTRATION AU CAPITAL  DE 10 000 USD ENTIEREMENT LIBERE. GESTIONNAIRE AGREE PAR L\’ARCA SOUS N° 30001. 66 BOULEVARD DU 30 JUIN';
     $this->MultiCell(135, 3.5, utf8_decode($texteInfo), 0, 'C');
 
     // 📄 Numéro de page à droite
     $this->SetXY(170, -15);
     $this->SetFont('Arial', 'I', 8);
     $this->Cell(30, 10, utf8_decode('Page ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    // Pagination centrée
   // $this->SetY(-15);
    //$this->SetFont('Arial','I',8);
    //$this->Cell(0,10,utf8_decode('Page ').$this->PageNo().'/{nb}',0,0,'C');
}


}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->setDates($formattedDate1, $formattedDate2); // ← Injection des dates
$pdf->AddPage();
$pdf->SetFont('Arial','',10);



$index = 1;
$totalCredit = 0;
$totalDebit = 0;
$totalSolde = 0;
foreach ($stmt as $row) {
    $pdf->Cell(10, 8, $index++, 1);

    $date = new DateTime($row['datejour']);
    $formattedDate =  $date->format('Y-m-d');

    $pdf->Cell(30, 8, $formattedDate, 1);
    $pdf->Cell(30, 8, utf8_decode($row['typeOperation']), 1);
    $pdf->Cell(30, 8, utf8_decode($row['libcompte']), 1);
    $pdf->Cell(30, 8, number_format($row['montantcredit'], 2, '.', ' ') .' $', 1, 0, 'R');
    $pdf->Cell(30, 8, number_format($row['montantdebit'], 2, '.', ' ') .' $', 1, 0, 'R');
    $pdf->Cell(30, 8, number_format($row['solde'], 2, '.', ' ') .' $', 1, 1, 'R');

     //  Cumuler les totaux
     $totalCredit += $row['montantcredit'];
     $totalDebit  += $row['montantdebit'];
     //$totalSolde  += $row['solde'];
}
$totalSolde=$totalCredit - $totalDebit;
//  Ligne total
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(100, 8, utf8_decode('TOTAL GÉNÉRAL'), 1, 0, 'C');
$pdf->Cell(30, 8, number_format($totalCredit, 2, '.', ' ') .' $', 1, 0, 'R');
$pdf->Cell(30, 8, number_format($totalDebit, 2, '.', ' ').' $', 1, 0, 'R');
$pdf->Cell(30, 8, number_format($totalSolde, 2, '.', ' ').' $', 1, 1, 'R');


$pdf->Output();

// Supprimer le QR code temporaire après usage
if (file_exists('qrcode.png')) {
    unlink('qrcode.png');
}