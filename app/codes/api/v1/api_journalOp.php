<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include_once(__DIR__ . '/../../models/ClassFinance.php');


$fina = new Finance();
$result = $fina->getJournalParDate();

/*
if (isset($_GET['date1']) && isset($_GET['date2'])) {
    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];

    $fina = new Finance();
    $result = $fina->getJournalParDate($date1, $date2);

    echo json_encode($result);
} else {
    echo json_encode(['Erreur' => 'Paramètres manquants']);
}
/*
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
include_once(__DIR__ . '/../../models/ClassFinance.php');

if(isset($_GET['date1']) && isset($_GET['date2'])){
  
    $date1=$_GET['date1'];
    $date2=$_GET['date2'];
    
    $fina = new Finance();

    $result = $fina->getJournalParDate($date1, $date2); 
    
    echo json_encode($result);

    /*if($result && isset($result[0]['soldebanque'])){
        echo json_encode(['soldebanque' => $result[0]['soldebanque']]);
    } else {
        echo json_encode(['soldebanque' => 0]);
    }*/
    /*
} else {
    echo json_encode(['Erreur' => 0]);
}
*/