<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
include_once(__DIR__ . '/../../models/ClassFinance.php');

if(isset($_GET['idbanque'])){
    $idbanque = intval($_GET['idbanque']);
    
    $fina = new Finance();

    $result = $fina->getSoldeBanque($idbanque); 

    if($result && isset($result[0]['soldebanque'])){
        echo json_encode(['soldebanque' => $result[0]['soldebanque']]);
    } else {
        echo json_encode(['soldebanque' => 0]);
    }
} else {
    echo json_encode(['soldebanque' => 0]);
}
