<?php

//$context  = stream_context_create($opts);
//$message='Test pour validité du systèm';
$mess=urlencode($message);
$mobile=substr($mobile,1,9);
$mobile="243".$mobile;

$result = file_get_contents('https://api.allmysms.com/http/9.0/?login=betsaleeltech&apiKey=8a53706bc4d86ed&message='.$mess.'&mobile='.$mobile.'&tpoa=Setram');
//$result = file_get_contents('test.php?login=betsaleeltech&apiKey=8a53706bc4d86ed&message='.$mess.'envoie&mobile='.$mobile.'&tpoa=Setram');

$json_data = json_decode($result,true);
$EtatEnvoie="";
/*foreach($json_data as $Donnee){
	$Recu=$Donnee['status'];
		if($Recu==100){
			echo "Envoyé";
			$EtatEnvoie=1;
			}
		else{
			echo "Non recu";
			$EtatEnvoie=0;
			}
	}
echo $mess;
echo $result;*/
?>