<?php
//session_start();
//if((!isset($_SESSION['idagent']))or($_SESSION['adresseIP']!=$_SERVER['REMOTE_ADDR'])or(!isset($_SESSION['IdAgence']))){
if(($_SESSION['Role']!='Trainer')&&($_SESSION['Role']!='Master')){
	unset($_SESSION['IdCompte']);
	unset($_SESSION['Role']);
	unset($_SESSION['adresseIP']);
	
	unset($_SESSION['Nom']);
	unset($_SESSION['Postnom']);
	unset($_SESSION['Prenom']);

 header("location:authentification_L.php");
 exit();

}


?>