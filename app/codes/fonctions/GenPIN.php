<?php

function fx_generateur_PIN(){
	 $caracteres = array(1,2,3,4,5,6,7,8,9,0);
	 $caracteres_aleatoires = array_rand($caracteres, 5);
	 $PIN = "";
	 
	 foreach($caracteres_aleatoires as $i)
	 {
		  $PIN .= $caracteres[$i];
	 }
	return $PIN;
}

function fx_generateur_Serial(){
	 $caracteres = array(1,2,3,4,5,6,7,8,9,0,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","Y","Z");
	 $caracteres_aleatoires = array_rand($caracteres, 10);
	 $Serial = "";
	 
	 foreach($caracteres_aleatoires as $i)
	 {
		  $Serial .= $caracteres[$i];
	 }
	return $Serial;
}

?>
