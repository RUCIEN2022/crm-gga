<?php 
function fx_upload($ChampF,$Dossier)
{
		$extensionsAutorisees = array(".jpeg", ".jpg", ".png",".bmp",".wbmp",".JPG",".PDF",".pdf",".doc",".docx");
        $content_dir = $Dossier; // dossier où sera déplacé le fichier
        $tmp_file = $_FILES[$ChampF]['tmp_name'];
        if( !is_uploaded_file($tmp_file) )
        {
				echo "Le fichier est introuvable";
               // exit("Le fichier est introuvable");
        }
        
        // on fait un test de sécurité
        $name_file = $_FILES[$ChampF]['name'];
        if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file) )
        {
                exit("Nom de fichier non valide");
        }
		
		// on vérifie maintenant l’extension
		$extension = strtolower(substr($name_file, strrpos($name_file, ".")));
		$Nom_fic=fx_generateur_Nom();
		$Nom_fic .=$extension;
        if (!(in_array($extension, $extensionsAutorisees))) {
            die("Le fichier n'a pas l'extension attendue ".$extension);
        }
        // on copie le fichier dans le dossier de destination
        else if( !move_uploaded_file($tmp_file, $content_dir . $Nom_fic) )
        {
               return false;
			   // exit("Impossible de copier le fichier dans $content_dir");
        }
        //echo "Le fichier a bien été uploadé";
		return $Nom_fic;
}

function fx_redimension($taillemin,$Image_url,$Dossier,$type,$nom_fichier){
$taille_min=$taillemin;
 		$content_dir = $Dossier;
        $donnees=getimagesize($Image_url);
		if (($type==".jpg")or($type==".jpeg")){
        $image = imagecreatefromjpeg($Image_url);
		}
		elseif($type==".png"){
		$image = imagecreatefrompng($Image_url);
		}else{
		$image = $Image_url;	
			}
		$dimension="";
        if ($donnees[0] > $donnees[1]) { //paysage
			$dimension="pa";
		//si la largeur est inférieure à la taille minimal ben on quitte la fonction avec un false, belle idée fab?
			if ($donnees[0]<=$taille_min){
				$largeur_finale=$donnees[0];
				$hauteur_finale=$donnees[1];
			}else{
				$largeur_finale=round(($taille_min/$donnees[1])*$donnees[0]);
				$hauteur_finale=$taille_min;
			}
        }
        elseif ($donnees[0] < $donnees[1])
        {//portrait
			$dimension="po";
			//si la hauteur est inférieure à la taille minimal ben on quitte la fonction avec un false, belle idée fab?
			if ($donnees[1]<=$taille_min){
				$largeur_finale=$donnees[0];
				$hauteur_finale=$donnees[1];
			}else{
				$hauteur_finale=round(($taille_min/$donnees[0])*$donnees[1]);
				$largeur_finale=$taille_min;
			}
        }
		elseif ($donnees[0] == $donnees[1])
        {//portrait
			$dimension="ca";
			//si la hauteur est inférieure à la taille minimal ben on quitte la fonction avec un false, belle idée fab?
			if ($donnees[1]<=$taille_min){
				$largeur_finale=$donnees[0];
				$hauteur_finale=$donnees[1];
			}else{
				$hauteur_finale=round(($taille_min/$donnees[0])*$donnees[1]);
				$largeur_finale=$taille_min;
			}
        }
        $image_mini = imagecreatetruecolor($largeur_finale, $hauteur_finale); //création image finale
        imagecopyresampled($image_mini, $image, 0, 0, 0, 0, $largeur_finale, $hauteur_finale, $donnees[0], $donnees[1]);//copie avec redimensionnement
		//imagecopyresampled(,,,,,,,,
		if (($type==".jpg")or($type==".jpeg")){
        imagejpeg ($image_mini, $content_dir.$nom_fichier);
		}
		elseif($type==".png"){
		imagepng ($image_mini, $content_dir.$nom_fichier);
		}
        return $dimension;

}

function fx_generateur_Nom(){
	 $caracteres = array( "g","h","i","j","k","o",0, 1,"e", "f", 2,"m","n","z","Z","p","q","A","B","r","s",3, 4,"a", "b", "c", "d", 5, 6,"E","G",7, 8,"l",9);
	 $caracteres_aleatoires = array_rand($caracteres, 8);
	 $Nom_Fichier = "";
	 
	 foreach($caracteres_aleatoires as $i)
	 {
		  $Nom_Fichier .= $caracteres[$i];
	 }
	 $Nom_Fichier .= date("YmdHis");
	return $Nom_Fichier;
}

function fx_upload_audio($ChampF,$Dossier)
{
		$extensionsAutorisees = array(".mp3");
        $content_dir = $Dossier; // dossier où sera déplacé le fichier
        $tmp_file = $_FILES[$ChampF]['tmp_name'];
        if( !is_uploaded_file($tmp_file) )
        {
				echo "Le fichier est introuvable ";
				echo $tmp_file;
               // exit("Le fichier est introuvable");
        }
        
        // on fait un test de sécurité
        $name_file = $_FILES[$ChampF]['name'];
        if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $name_file) )
        {
                exit("Nom de fichier non valide");
        }
		
		// on vérifie maintenant l’extension
		$extension = strtolower(substr($name_file, strrpos($name_file, ".")));
		$Nom_fic=fx_generateur_Nom();
		$Nom_fic .=$extension;
        if (!(in_array($extension, $extensionsAutorisees))) {
            die("Le fichier n'a pas l'extension attendue ".$extension);
        }
        // on copie le fichier dans le dossier de destination
        else if( !move_uploaded_file($tmp_file, $content_dir . $Nom_fic) )
        {
               return false;
			   // exit("Impossible de copier le fichier dans $content_dir");
        }
        //echo "Le fichier a bien été uploadé";
		return $Nom_fic;
}		

?>