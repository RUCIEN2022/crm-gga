<?php
//session_start();
//if((!isset($_SESSION['idagent']))or($_SESSION['adresseIP']!=$_SERVER['REMOTE_ADDR'])or(!isset($_SESSION['IdAgence']))){
if(($_SESSION['niveau']!='Admin')){
	unset($_SESSION['idagent']);
	unset($_SESSION['niveau']);
	unset($_SESSION['adresseIP']);
	
	unset($_SESSION['Nom']);
	unset($_SESSION['postnom']);
	unset($_SESSION['prenom']);
	
	unset($_SESSION['IdAgence']);
	unset($_SESSION['NomAgence']);
 header("location:Authentification.php");
 exit();

}

?>