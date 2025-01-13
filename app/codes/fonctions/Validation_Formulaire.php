<?php 
//include_once($Dossier_Fonctions.'Fx_Execution.php');


function fx_Verif_vide($Champ){
if (!isset($_POST[$Champ]) or $_POST[$Champ]==""){
	return false;
	}
else{
	return true;
	}
}

function fx_Verif_texte($Champ,$Min,$Max){
if(preg_match("/[A-Za-z0-9]{".$Min.",".$Max."}/", $_POST[$Champ]))
          {
               return true;
          }
else
		 {
				return false;
		 }

}

function fx_Verif_Email($Email){
	$mail = filter_var($Email, FILTER_VALIDATE_EMAIL) ;
	if ($mail === false){
		return false;
	}elseif($mail === NULL){
		return false;
	}else{
		return true;
	}
/*if(!preg_match("/[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,4}/", $_POST[$Email]))
          {
			return false;
          }
else
		 {
			return true;	
		 }*/
}

function fx_Verif_Nombreentier($Nombre){
	$Nombrei= filter_var($Nombre, FILTER_VALIDATE_INT) ;
	if ($Nombrei === FALSE){
		return false;
	}elseif($Nombrei === NULL){
		return false;
	}else{
		return true;
	}
}
function fx_Verif_URL($URLv){
	$URLv= filter_var($URLv, FILTER_VALIDATE_URL) ;
	if ($URLv === FALSE){
		return false;
	}elseif($URLv === NULL){
		return false;
	}else{
		return true;
	}
}
function fx_Verif_extention($extension){
	$extensionsAutorisees = array(".jpeg", ".jpg", ".png",".bmp",".wbmp");
	 if (!(in_array($extension, $extensionsAutorisees))) {
            return false;
        }
		else{
			return true;
		}
}
function fx_Verif_taille_fic($taille){
	 //if ($taille>7856198) {
	    if ($taille>2097152 or $taille==0) {
            return false;
        }
		else{
			return true;
		}
}


function fx_Verif_Mdp($Mdp){
if(preg_match("/[A-Za-z0-9]{4,15}/", $_POST[$Mdp]))
          {
               return true;
          }
else
		 {
				
				return false;
		 }

}

function fx_Verif_Date($date_x){
$date_x=strtotime($date_x);
$jour=date('d',$date_x);
$mois=date('m',$date_x);
$Annee=date('Y',$date_x);
if(checkdate($mois,$jour,$Annee))
          {
               return true;
          }
else
		 {
				
				return false;
		 }

}



?>