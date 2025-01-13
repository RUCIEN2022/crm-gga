<?php 
	function fx_generateur_Code2(){
		 $caracteres = array( 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 0, 1, 2, 3, 4, 5, 6,7, 8,9, 0, 2, 4, 6, 8, 10, 1,3, 5,7,9,"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","y","z");
		 $caracteres_aleatoires = array_rand($caracteres, 9);
		 $Code= "";
		 //$Code .= date("d");
		 
		 
		 foreach($caracteres_aleatoires as $i)
		 {
			  $Code .= $caracteres[$i];
		 }
		//$Code .=$Annees;
		return $Code;
	}
	function fx_createur_code(){
		$caracteres = array( 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 0, 1, 2, 3, 4, 5, 6,7, 8,9, 0, 2, 4, 6, 8, 10, 1,3, 5,7,9);
		$caracteres_aleatoires = array_rand($caracteres, 5);
		$Code= "";
		//$Code .= date("d");
		
		
		foreach($caracteres_aleatoires as $i)
		{
			 $Code .= $caracteres[$i];
		}
	   //$Code .=$Annees;
	   return $Code;
   }
?>