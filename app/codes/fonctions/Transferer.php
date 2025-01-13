<?php
/*include_once("../codes/classes/ClasseTransaction.php");
include_once("../codes/classes/ClasseCompte.php");
include_once("../codes/classes/ClassePlage.php");*/
function Transferer($MontantTransfert, $IdCompteB, $IdCompteE, $CodeMonnaietrans, $Moyen, $idagent, $IdAgence, $CodeTypeCompte){
	if($IdCompteB!=$IdCompteE){
		$RecheCompte= new Compte();
		$MonnaieB=$RecheCompte->fx_Check_Monnaie($IdCompteB);
		if($MonnaieB==$CodeMonnaietrans){
		$Transact= new transaction();	
		$resultatB=$Transact->fx_opererTransfert($MontantTransfert,$CodeMonnaietrans,$Moyen,$IdCompteE,$IdCompteB);
		if($resultatB){
			$MontantSortie=$MontantTransfert;
			$IdTransact=$resultatB;
			
			$Result_Compte=$RecheCompte->fx_ModiferSolde_Compte($IdCompteB,$MontantTransfert,"E");
	
			$ResEffect=$Transact->fx_InsererEffectuer($idagent,$IdTransact,$IdAgence);
			$RecheFrais=$RecheCompte->fx_ListeFraisLies($CodeTypeCompte,"Transfert",$CodeMonnaietrans);
			//$RecheFrais=$Transact->fx_FraisLies("Transfert");
			$TotRfrais=0;
			if($RecheFrais){
				while ($data = $RecheFrais->fetch()) {
					$IdFrais=$data['IdFrais'];
					$MontantFrais=$data['Montant'];
					//$CodTypComptFrais=$data['CodeTypeCompte'];
					$DestinatFrais=$data['Destination'];
					$CodeTypeTransact=$data['CodeTypeTransact'];
					$Description=$data['Description'];
					if($DestinatFrais=="Agence"){
						//$IdCompteD=$_SESSION['$NumCompteAgc'];
						$IdCompteD=$IdAgence;
					}
					elseif($DestinatFrais=="Direction"){
						$IdCompteD="2";
					}
					if($Description=="Transfert"){
						$Plage=new plages();
						$ResPlage=$Plage->fx_trouve_plage($MontantTransfert,$CodeMonnaietrans,"Transfert");
						if($ResPlage){
							while ($row = $ResPlage->fetch()) {
								$IdPlage=$row['IdPlage'];
								$Montan=$row['MontantPlage'];
								$TypePlage=$row['TypePlage'];
								
								if($TypePlage=="F"){
												$MontantFrais=$Montan;
											}
								if($TypePlage=="P"){
										$MontantFrais = 0;
										$Com=0;
										$Montant = 0;
										$Montant=$MontantTransfert;
										$Com = $Montan;
										
										$MontantFrais=($Montant*$Com)/100;
										//$deviseComm=$CodedeviseCommiss;
									}
							}
						}
						//$resultat=$Transact->fx_creertransfert($IdTransact,$IdTransact+1,$IdPlage);
					}
					$resultatD=$Transact->fx_recupFrais($MontantFrais,$CodeMonnaietrans,$Moyen,$IdCompteE,$IdCompteD);
					$Result_Compte=$RecheCompte->fx_ModiferSolde_Compte($IdCompteD,$MontantFrais,"E");
					$MontantSortie=$MontantSortie+$MontantFrais;
					$TotRfrais=$TotRfrais+$MontantFrais;
					$resultatD=$Transact->fx_concerner($IdTransact, $resultatD, $resultatD+1,$IdFrais, $MontantFrais, $CodeMonnaietrans);
				}
			}
			$resultat=$Transact->fx_creertransfert($IdTransact,$IdTransact+1,$IdPlage,$TotRfrais);
			$Result_Compte=$RecheCompte->fx_ModiferSolde_Compte($IdCompteE,$MontantSortie,"S");

			//return 1;
			return $resultat;	
		}
		return 0;
	}else{
		//Monnaie Differents
		return "E1";
		}	
	}else{
		//Même compte
		return "E2";
		}
}
?>