<?php 
	function fx_generateur_Code(){
		 $caracteres = array( 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 0, 1, 2, 3, 4, 5, 6,7, 8,9, 0, 2, 4, 6, 8, 10, 1,3, 5,7,9);
		 $caracteres_aleatoires = array_rand($caracteres, 4);
		 $Code= "";
		 //$Code .= date("d");
		 
		 
		 foreach($caracteres_aleatoires as $i)
		 {
			  $Code .= $caracteres[$i];
		 }
		//$Code .=$Annees;
		return $Code;
	}
	function fx_generateur_matricule(){
		$caracteres = array( 9, 8, 7, 6, 5, 4, 3, 2, 1, 0, 0, 1, 2, 3, 4, 5, 6,7, 8,9, 0, 2, 4, 6, 8, 10, 1,3, 5,7,9);
		$caracteres_aleatoires = array_rand($caracteres, 6);
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