

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
include_once(__DIR__ . '/../../models/ClassFinance.php');

if(isset($_GET['idcompte'])){
    $idcompte = intval($_GET['idcompte']);
    
    $fina = new Finance();

    $result = $fina->getSoldecompte($idcompte); 

    if($result && isset($result[0]['solde'])){
        echo json_encode(['solde' => $result[0]['solde']]);
    } else {
        echo json_encode(['solde' => 0]);
    }
} else {
    echo json_encode(['solde' => 0]);
}
