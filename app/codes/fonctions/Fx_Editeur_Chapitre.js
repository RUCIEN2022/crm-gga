// JavaScript Document

	var Nbre=0;
	var NbreO=0;
	var NbreR=0;
	var NbreA=0;
	var NbreQ=0;
	var NbreSl=0; 
	
	function traitement_Charge_Etape(reponses){
				//alert(reponses);
				reponses=reponses.trim();
				objetJSON3=JSON.parse(reponses);
				IdEtapeEnC=0;
				$("#TabTaches").empty();
				InitFormTache();
				NbTache=0;
				TCout=0;
				TDuree=0;
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Reponse.length;i++){
						var Etat=objetJSON3.Reponse[i].Etat;
						var Message=objetJSON3.Reponse[i].Message;
						if(Etat=="500")
						{
							for(i=0;i<objetJSON3.Donnees.length;i++){
								var IdTache=objetJSON3.Donnees[i].IdTache;
								var NomTache=objetJSON3.Donnees[i].NomTache;
								var NbJours=objetJSON3.Donnees[i].NbJours;
								var IdTachePreced=objetJSON3.Donnees[i].IdTachePreced;
								var IdEtape=objetJSON3.Donnees[i].IdEtape;
								var EtatTache=objetJSON3.Donnees[i].EtatTache;
								var coutTache=objetJSON3.Donnees[i].coutTache;
								nouvelleLigneTache(IdTache,NomTache,NbJours,IdTachePreced,IdEtape,EtatTache);
								NbTache++;
								TCout=TCout+parseInt(coutTache);
								TDuree=TDuree+parseInt(NbJours);
							}
							$("#NbreTache").html(NbTache);
							
							$("#CoutEtape").html(TCout);
							$("#DminA").html(TDuree);
							$("#DmaxA").html(TDuree);
							//alert(TDuree);
							//alert(Message);
							for(i=0;i<objetJSON3.Donnees2.length;i++){
								var IdEtapeCult=objetJSON3.Donnees2[i].IdEtapeCult;
								var NomEtapeCulte=objetJSON3.Donnees2[i].NomEtapeCulte;
								var DurreEtapeMin=objetJSON3.Donnees2[i].DurreEtapeMin;
								var DurreEtapeMax=objetJSON3.Donnees2[i].DurreEtapeMax;
								var IdEtapePreced=objetJSON3.Donnees2[i].IdEtapePreced;
								var EtatEtape=objetJSON3.Donnees2[i].EtatEtape;
								AfficheEtape(IdEtapeCult,NomEtapeCulte,DurreEtapeMin,DurreEtapeMax,IdEtapePreced,EtatEtape);
								IdEtapeEnC=IdEtapeCult;
							}
							for(i=0;i<objetJSON3.Donnees3.length;i++){
								var IdEtapeCult=objetJSON3.Donnees3[i].IdEtapeCult;
								var NomEtapeCulte=objetJSON3.Donnees3[i].NomEtapeCulte;
								var DurreEtapeMin=objetJSON3.Donnees3[i].DurreEtapeMin;
								var DurreEtapeMax=objetJSON3.Donnees3[i].DurreEtapeMax;
								var IdEtapePreced=objetJSON3.Donnees3[i].IdEtapePreced;
								var EtatEtape=objetJSON3.Donnees3[i].EtatEtape;
								RemplirCombo(IdEtapeCult,NomEtapeCulte,IdEtapeEnC);
								
							}
							//alert(Message);
							//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
						}
						else
						{
							alert(Message);
							//Toast("Compte ou PIN incorrects");
						}
					}

			//AfficheContenu(IdContenu,Typecontenu,Fichier,TexteContenu,Heure,Minute);
					
	}
	function AfficheEtape(IdEtapeCult,NomEtapeCult,DurreEtapeMin,DurreEtapeMax,IdEtapePreced,EtatEtape){
		$("#Dmin").html(DurreEtapeMin);
		$("#Dmax").html(DurreEtapeMax);
		//$("#NbreTache").html(DurreEtapeMax);

	}
	function RemplirCombo(IdEtapeCult,NomEtapeCulte,IdEtapeEnC){
		if(IdEtapeEnC==IdEtapeCult){
			$('#EtapePreced').append('<option value="'+IdEtapeCult+'" selected>'+NomEtapeCulte+'</option>');
		}else{
			$('#EtapePreced').append('<option value="'+IdEtapeCult+'">'+NomEtapeCulte+'</option>');
		}
	}
	function nouvelleLigneTache(IdTache,NomTache,NbJours,IdTachePreced,IdEtape,EtatTache) {
			NbreR++;
			//alert(Lien);
		$("#TabTaches").append('<tr id="'+NbreR+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><a href="javascript:select_Tache('+IdTache+',\''+NomTache+'\','+NbJours+','+IdTachePreced+')"><p>'+NomTache+'</p></a></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+NbreR+'" id="D'+NbreR+'" value="'+IdTache+'"/></div></div></div></div></td><td>'+NbJours+' Jours</td><td>Cout<div class="col-md-2"><a href="javascript:supprimerTache('+NbreR+','+IdTache+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></td></tr>');
		$('#TachePreced').append('<option value="'+IdTache+'">'+NomTache+'</option>');
		/*$('#NomRess').val('');$('#TypeRess').val('');$('#LienRess').val('');
		$('#BoiteLien').css("visibility", "hidden");
		$('#BoiteUploald').css("visibility", "hidden");*/
	}
	function select_Tache(IdTache,NomTache,NbJours,IdTachePreced){
		if (IdTache > 0) {
			Liste_Intra(IdTache);
			$('#IdTacher').val(IdTache);
			$('#NomTache').val(NomTache);
			$('#NbJours').val(NbJours);
			$('#TachePreced').val(IdTachePreced);
			$('#ModifTache').css("visibility", "visible");
			$('#AjoutTache').css("visibility", "hidden");
			$("#Titre_Action").html("Modifier Tâche : "+NomTache);
		}
	}
	
	function Ajout_Intra(IdIntra,QteIntra,CoutIntra,textIntra,TypeAjt,IdUtilise){
		//alert('Poc');
		NbreO++;
		$('#NbreRess').val(NbreO);
		$('#TabIntra').append('<tr id="'+NbreO+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p>'+textIntra+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="DT'+NbreO+'" id="DT'+NbreO+'" value="'+IdIntra+'"/><input type="hidden" name="DQ'+NbreO+'" id="DQ'+NbreO+'" value="'+QteIntra+'"/><input type="hidden" name="UT'+NbreO+'" id="UT'+NbreO+'" value="'+IdUtilise+'"/><input type="hidden" name="DTy'+NbreO+'" id="DTy'+NbreO+'" value="'+TypeAjt+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimerIntra('+NbreO+','+IdUtilise+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$("#Intras").val('');
		$("#QtePB").val('');
	}
	function supprimerTache(id,IdTache){
		//Modif_Etat_Outils(IdOutil,0);
		//alert('Duly');
		Modif_Etat_Tache(IdTache,0);
        if (id > 0) {
           
					$('#TabTache tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                        $(this).hide();
						$(this).remove();
                    });
           
            //} 
        }
    }
    function supprimerIntra(id,IdUtilise){
		//Modif_Etat_Outils(IdOutil,0);
		//alert('Duly');
		//Modif_Etat_Tache(IdTache,0);
		Modif_Etat_Utilise(IdUtilise,0);
        if (id > 0) {
           
				$('#TabIntra tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                    $(this).hide();
					$(this).remove();
                });
           
        }
    }
	
	function traitement_Liste_Etape(reponses){
				$("#TabDate").empty();
				
				reponses=reponses.trim();
				objetJSON3=JSON.parse(reponses);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Reponse.length;i++){
						var Etat=objetJSON3.Reponse[i].Etat;
						var Message=objetJSON3.Reponse[i].Message;
						if(Etat=="500")
						{
						
							for(i=0;i<objetJSON3.Donnees.length;i++){
								var IdEtapeCult=objetJSON3.Donnees[i].IdEtapeCult;
								var NomEtapeCulte=objetJSON3.Donnees[i].NomEtapeCulte;
								var DurreEtapeMin=objetJSON3.Donnees[i].DurreEtapeMin;
								var DurreEtapeMax=objetJSON3.Donnees[i].DurreEtapeMax;
								var IdEtapePreced=objetJSON3.Donnees[i].IdEtapePreced;

								var EtatEtape=objetJSON3.Donnees[i].EtatEtape;
								var IdCulture=objetJSON3.Donnees[i].IdCulture;
								nouvelleLigneE(NomEtapeCulte,IdEtapeCult,IdEtapePreced);
								
							}
							//alert(Message);
							
							//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
						}
						else
						{
							alert(Message);
							//Toast("Compte ou PIN incorrects");
						}
					}
	}
	function nouvelleLigneE(NomEtapeCulte,IdEtapeCult,IdEtapePreced) {
		
			Nbre++;
			IdCulture=$('#IdCulture').val();
		$("#TabDate").append('<tr id="'+Nbre+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><a href="javascript:select_Etape('+IdEtapeCult+',\''+NomEtapeCulte+'\')"><p>'+NomEtapeCulte+'</p></a></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+Nbre+'" id="D'+Nbre+'" value="'+IdEtapeCult+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+Nbre+','+IdEtapeCult+','+IdCulture+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$("#DIdEtape").val(IdEtapeCult);
	}
	
	function Ajout_Etp(IdEtape,NbEtap){
		
		Nbre++;
		IdCulture=$('#IdCulture').val();
		$('#NbreJour').val(Nbre);
		$('#TabDate').append('<tr id="'+Nbre+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><a href="javascript:select_Etape('+IdEtape+',\''+$('#NEtape').val()+'\')"><p>'+$('#NEtape').val()+'</p></a></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+Nbre+'" id="D'+Nbre+'" value="'+$('#NEtape').val()+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+Nbre+','+IdEtape+','+IdCulture+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#NEtape').val('');

		$('#NbrEtapes').html(NbEtap);
	}
	
	/////////////////////////////
	function supprimer(id,IdEtapeCult,IdCulture){
        if (id > 0) {
				Modif_Etat_Etape(IdEtapeCult,0,IdCulture);
				$('#TabDate tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                    $(this).hide();
					$(this).remove();
                });
        }
    }
	
	function select_Etape(IdEtape,NEtape){
		//alert(idCont); 
        if (IdEtape > 0) {
            $('#IdEtaper').val(IdEtape);
			$('#NomEtape').html(NEtape);
			//$('#IdExamen').val(IdExamen);
			//$('#TitreChap').html(Titre);
			IdCulture=$('#IdCulture').val();
			Charge_Etape(IdEtape,IdCulture);

			/*Liste_Ressource(idChap);
			Liste_Question(IdExamen);
			Liste_Slide(idChap);*/
			
			
        }
    }
	function Rep_Etape(reponses){
		//alert(reponses);
		reponses=reponses.trim();
		objetJSON3=JSON.parse(reponses);
			//rich=objetJSON3.membre.length;
			for(i=0;i<objetJSON3.Reponse.length;i++){
				var Etat=objetJSON3.Reponse[i].Etat;
				var Message=objetJSON3.Reponse[i].Message;
				if(Etat=="500")
				{
					
					for(i=0;i<objetJSON3.Donnees.length;i++){
						var IdEtape=objetJSON3.Donnees[i].IdEtape;
						var NbEtape=objetJSON3.Donnees[i].NbEtape;
						Ajout_Etp(IdEtape,NbEtape);
						
					}
					//alert(Message);
					
					//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
				}
				else
				{
					alert(Message);
					//Toast("Compte ou PIN incorrects");
				}
			
		}
		
						
					
		
	}
	function Traitement_Liste_Intra(reponses){
		//alert(reponses);
		reponses=reponses.trim();
		objetJSON3=JSON.parse(reponses);
			//rich=objetJSON3.membre.length;
			$('#TabIntra').empty();
			NbreO=0;
			for(i=0;i<objetJSON3.Reponse.length;i++){
				var Etat=objetJSON3.Reponse[i].Etat;
				var Message=objetJSON3.Reponse[i].Message;
				if(Etat=="500")
				{
					
					for(i=0;i<objetJSON3.Donnees.length;i++){
						var IdIntra=objetJSON3.Donnees[i].IdIntra;
						var TypeIntra=objetJSON3.Donnees[i].TypeIntra;
						var NomIntra=objetJSON3.Donnees[i].NomIntra;
						var Unite=objetJSON3.Donnees[i].Unite;
						var CoutUnitaire=objetJSON3.Donnees[i].CoutUnitaire;
						var CodeMonnaie=objetJSON3.Donnees[i].CodeMonnaie;
						var EtatIntra=objetJSON3.Donnees[i].EtatIntra;

						var QtePBJRS=objetJSON3.Donnees[i].QtePBJRS;
						var NbJours=objetJSON3.Donnees[i].NbJours;
						var IdUtilise=objetJSON3.Donnees[i].IdUtilise;
						CoutI=(QtePBJRS*CoutUnitaire)*NbJours;
						textIntra=IdIntra+","+NomIntra+" : ("+QtePBJRS+" ("+Unite+") X "+CoutUnitaire+CodeMonnaie+") X "+NbJours+"Jours = "+CoutI;
						Ajout_Intra(IdIntra,QtePBJRS,CoutUnitaire,textIntra,"Anc",IdUtilise);
						
					}
					//alert(Message);
					
					//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
				}
				else
				{
					alert(Message);
					//Toast("Compte ou PIN incorrects");
				}
			
		}
		
						
					
		
	}
	function Rep_Modif_Tache(Reponse){
		//alert(Reponse);
		/*$('#ModifTache').css("visibility", "hidden");
		
		$('#AjoutTache').css("visibility", "visible");*/
		//Ajout_Chap();
		InitFormTache();
	}
	function Rep_Outils(Reponse){
		//alert(Reponse);
		Ajout_Out(Reponse);
	}
	function Rep_Ressource(Reponse){
		//alert(Reponse);
		Ajout_Ress(Reponse,$('#LienRess').val());

		//Ajout_Ress(IdRess,LienRess)
	}
	function Rep_Question(Reponse){
		tinyMCE.get('Question').setContent('');
		$('#TabAssertion').empty();
		alert(Reponse);
	}
	
	function Rep_Slide(Reponse){
		//alert(Reponse);
		Liste_Slide($("#IdChapitre").val());
		//Ajout_Ress(Reponse,$('#LienRess').val());
		//Ajout_Ress(IdRess,LienRess)
	}
	function Rep_Supp_Etape(reponses){
		//alert(Reponse);
		alert(reponses);
		reponses=reponses.trim();
		objetJSON3=JSON.parse(reponses);
			//rich=objetJSON3.membre.length;
			for(i=0;i<objetJSON3.Reponse.length;i++){
				var Etat=objetJSON3.Reponse[i].Etat;
				var Message=objetJSON3.Reponse[i].Message;
				if(Etat=="500")
				{
					
					for(i=0;i<objetJSON3.Donnees.length;i++){
						var IdEtapeCult=objetJSON3.Donnees[i].IdEtapeCult;
						var NbEtape=objetJSON3.Donnees[i].NbEtape;
						$('#NbrEtapes').html(NbEtape);
						
					}
					//alert(Message);
					
					//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
				}
				else
				{
					alert(Message);
					//Toast("Compte ou PIN incorrects");
				}
			
		}
	}
	function Rep_Supp_Utilise(Reponse){
		alert(Reponse);
	}
	function Rep_Supp_Tache(Reponse){
		//alert(Reponse);
		IdEtape=$('#IdEtaper').val();
		IdCulture=$('#IdCulture').val();
		Charge_Etape(IdEtape,IdCulture);
	}
	function Rep_Supp_Question(Reponse){
		alert(Reponse);
	}
	function Rep_Supp_Examen(Reponse){
		//alert(Reponse);
	}
	function Rep_Supp_Slide(Reponse){
		alert(Reponse);
	}
	function Ajout_Etatpe(IdCulture,NomEtapeCulte,IdEtapePreced) {
	Position=1;
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Etape.php',
		   data:{IdCulture:IdCulture, NomEtapeCulte:NomEtapeCulte, IdEtapePreced:IdEtapePreced},
		   dataType: 'text',
		   success: Rep_Etape,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	function traitement_Ajout_Tache(reponses){
				listeJSON = reponses;
				//alert(listeJSON);
				reponses=reponses.trim();
				objetJSON3=JSON.parse(reponses);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Reponse.length;i++){
						var Etat=objetJSON3.Reponse[i].Etat;
						var Message=objetJSON3.Reponse[i].Message;
						if(Etat=="500")
						{
							
							for(i=0;i<objetJSON3.Donnees.length;i++){
								var IdTache=objetJSON3.Donnees[i].IdTache;
								//Ajout_Etp(IdEtape);
								InitFormTache();
								IdEtape=$('#IdEtaper').val();
								IdCulture=$('#IdCulture').val();
								Charge_Etape(IdEtape,IdCulture);
							}
							alert(Message);
							
							//OuvreCompte(IdCompte,NumCompte,DeviceSerial,CodeMonnaie,Titulaire,"1");
						}
						else
						{
							alert(Message);
							//Toast("Compte ou PIN incorrects");
						}
					
				}
	}
	
	function nouvelleLigneOut(IdOutil,NOutils,VersionOutils,IdChapitre,LienOutils) {
			NbreO++;
		$("#TabOutils").append('<tr id="'+NbreO+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p><a href="'+LienOutils+'" target="blank">'+NOutils+' '+VersionOutils+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+NbreO+'" id="D'+NbreO+'" value="'+IdOutil+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimerOutils('+NbreO+','+IdOutil+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		
	}
	
	function Ajout_Out(IdOutil){
		//alert('Pic');
		NbreO++;
		$('#NbreOutils').val(NbreO);
		$('#TabOutils').append('<tr id="'+NbreO+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p><a href="'+$('#LienOutils').val()+'" target="blank">'+$('#NOutils').val()+' '+$('#VersionOutils').val()+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+NbreO+'" id="D'+NbreO+'" value="'+$('#NOutils').val()+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimerOutils('+NbreO+','+IdOutil+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#NOutils').val('');$('#VersionOutils').val('');$('#LienOutils').val('');
	}
	
	/////////////////////////////
	function supprimerOutils(id,IdOutil){
		Modif_Etat_Outils(IdOutil,0);
        if (id > 0) {
           
					$('#TabOutils tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                        $(this).hide();
						$(this).remove();
                    });
           
            //} 
        }
    }
	
	function traitement_Liste_Rossource(reponse){
				listeJSON = reponse;
				//alert(listeJSON);
				$("#TabRessource").empty();
				if (listeJSON!=0){
					//alert(listeJSON);
					objetJSON3=JSON.parse(listeJSON);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Tab_Ressource.length;i++){
						var IdRessource=objetJSON3.Tab_Ressource[i].IdRessource;
						
						var NomRessource=objetJSON3.Tab_Ressource[i].NomRessource;
						var TypeRessource=objetJSON3.Tab_Ressource[i].TypeRessource;
						
						var Lien=objetJSON3.Tab_Ressource[i].Lien;
						var IdChapitre=objetJSON3.Tab_Ressource[i].IdChapitre;
						
						//alert(Titre);
						nouvelleLigneRess(IdRessource,NomRessource,TypeRessource,Lien,IdChapitre);
						
					}
					
				}else{
					//ErrPlage();
					alert("Erreur");
					}
	}
	
	
	///////////&&&&&&&&&&&&&&&&&&&&&&///////////////////////////
	
	////////////////////////////////
	
	function nouvelleLigneAssertion(IdRessource,NomRessource,TypeRessource,Lien,IdChapitre) {
			NbreR++;
			//alert(Lien);
		$("#TabRessource").append('<tr id="'+NbreR+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p><a href="'+Lien+'" target="blank">'+NomRessource+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+NbreR+'" id="D'+NbreR+'" value="'+IdRessource+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimerRessource('+NbreR+','+IdRessource+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#NomRess').val('');$('#TypeRess').val('');$('#LienRess').val('');
		$('#BoiteLien').css("visibility", "hidden");
		$('#BoiteUploald').css("visibility", "hidden");
	}
	
	function Ajout_Assertion(Assertion,IdAss){
		//alert('Poc');
		NbreA++;
		$('#NbreAss').val(NbreA);
		$('#TabAssertion').append('<tr id="'+NbreA+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-8"><p>'+Assertion+'</p></div><div class="col-md-2"><label>Bonne Reponse</label><input type="radio" name="CAss" id="CAss" value="'+Assertion+'" onclick="CocheReponse(\''+Assertion+'\','+NbreA+');"/><input type="hidden" name="Ass'+NbreA+'" id="Ass'+NbreA+'" value="'+Assertion+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimerAssertion('+NbreA+','+IdAss+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#Assertion').val('');
	}
	
	function CocheReponse(Assertion,Num){
		//alert(Assertion+"-"+Num);
		$('#BonneReponse').val(Assertion);
		$('#IdBonneReponse').val(Num);
	}
	function supprimerAssertion(id,IdAss){
		//Modif_Etat_Outils(IdOutil,0);
		//alert('Duly');
		if(IdAss!=0){
			//Modif_Etat_Ressource(IdRess,0);
		}
		
        if (id > 0) {
           
					$('#TabAssertion tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                        $(this).hide();
						$(this).remove();
                    });
           
            //} 
        }
    }
	/////////////////////////////&&&&&&&&&&&&&&&&&&&&&&////////////////
	
	
	function Ajout_Ressource(NomRessource,TypeRessource, IdFichier, LienRessource, IdChapitre) {
	//alert("Boua"+NomRessource);
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Ressource.php',
		   data: "NomRessource="+ NomRessource+"&TypeRessource="+ TypeRessource+"&IdFichier="+IdFichier+"&LienRessource="+LienRessource+"&IdChapitre="+IdChapitre,
		   dataType: 'text',
		   success: Rep_Ressource,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Ajout_Taches(NomTache, NbJours, IdTachePreced, IdEtape, ChaineIntra) {
	//alert("Boua"+NomRessource);
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Tache.php',
		   data: {NomTache: NomTache,NbJours: NbJours,IdTachePreced:IdTachePreced,IdEtape:IdEtape,ChaineIntra:ChaineIntra},
		   dataType: 'text',
		   success: traitement_Ajout_Tache,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Ajout_Slide(Texte, Image, IdChapitre, Ordre) {
	//alert("Boua"+NomRessource);
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Slide.php',
		   data: {Texte:Texte,Image:Image,IdChapitre:IdChapitre,Ordre:Ordre},
		   //data: "Texte="+ Texte+"&Image="+ Image+"&IdChapitre="+IdChapitre+"&Ordre="+Ordre,
		   dataType: 'text',
		   success: Rep_Slide,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Liste_Intra(IdTache) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Intra.php',
		   data: {IdTache:IdTache},
		   dataType: 'text',
		   success: Traitement_Liste_Intra,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Liste_Ressource(IdChapitre) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Ressource.php',
		   data: "IdChapitre="+ IdChapitre,
		   dataType: 'text',
		   success: traitement_Liste_Rossource,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	function Liste_EtapesCulture(IdCulture) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Update_Etapes.php',
		   data: {IdCulture:IdCulture},
		   dataType: 'text',
		   success: traitement_Liste_Etape,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Liste_Question(IdExamen) {
		//alert('Pili');
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Question.php',
		   data: "IdExamen="+ IdExamen,
		   dataType: 'text',
		   success: traitement_Liste_Question,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Liste_Slide(IdChapitre) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Slide.php',
		   data: "IdChapitre="+ IdChapitre,
		   dataType: 'text',
		   success: traitement_Liste_Slide,
		   error: function() {alert('Erreur serveur');}
		   
		   });
	}
	////////////A utiliser pour lister les assertion//////////////////////
	function Liste_Assertion(IdQuestion) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Assertion.php',
		   data: "IdQuestion="+ IdQuestion,
		   dataType: 'text',
		   success: traitement_Liste_Assertion,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Charge_Etape(IdEtapeCult, IdCulture) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Charge_Etape.php',
		   data: {IdEtapeCult:IdEtapeCult, IdCulture:IdCulture},
		   dataType: 'text',
		   success: traitement_Charge_Etape,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Tache(IdTache, NomTache, NbJours, IdTachePreced,ChaineIntra) {
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Tache.php',
		   data: {IdTache:IdTache, NomTache:NomTache, NbJours:NbJours, IdTachePreced:IdTachePreced, ChaineIntra:ChaineIntra},
		   dataType: 'text',
		   success: Rep_Modif_Tache,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	function Modif_Etat_Etape(IdEtapeCult,EtatEtape,IdCulture){
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Etape.php',
		   data: {IdEtapeCult:IdEtapeCult, EtatEtape:EtatEtape, IdCulture:IdCulture},
		   dataType: 'text',
		   success: Rep_Supp_Etape,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Etat_Utilise(IdUtilise,EtatUtil){
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Utilise.php',
		   data: {IdUtilise:IdUtilise, EtatUtil:EtatUtil},
		   dataType: 'text',
		   success: Rep_Supp_Utilise,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Etat_Tache(IdTache,EtatTache){
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Tache.php',
		   data: {IdTache:IdTache, EtatTache:EtatTache},
		   dataType: 'text',
		   success: Rep_Supp_Tache,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Etat_Question(IdQuestion,EtatQuestion){
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Question.php',
		   data: "IdQuestion="+ IdQuestion+"&EtatQuestion="+EtatQuestion,
		   dataType: 'text',
		   success: Rep_Supp_Question,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Etat_Exam(IdExamen,EtatExam){
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Examen.php',
		   data: "IdExamen="+ IdExamen+"&EtatExam="+EtatExam,
		   dataType: 'text',
		   success: Rep_Supp_Examen,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Etat_Slide(IdSlide,EtatSlide){
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Etat_Slide.php',
		   data: "IdSlide="+ IdSlide+"&EtatSlide="+EtatSlide,
		   dataType: 'text',
		   success: Rep_Supp_Slide,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	$(document).ready(function() {
		//alert('Bana');
		$('#AjouteEtape').click(function () {PrepareAjoutEtape();});
		//
		$('#AjtIntra').click(function () {PrepareAjoutIntra();});
		Liste_EtapesCulture($("#IdCulture").val());
		//
		$('#AjoutTache').click(function(){PrepareAjoutTache();});
		$('#ModifTache').click(function(){PrepareModifTache();});
		$('#ModifTache').css("visibility", "hidden");

		$('#NouvTache').click(function () {InitFormTache();});

		$('#Visualiser').click(function () {visualise();});
		$('#EnregLive').click(function () {PrepareModifContenu("Live");});
		
		$('#AjouteLien').click(function () {BtnLien();});
		$('#EnregLien').click(function () {NouvRess();});
		
		$('#UploadRess').click(function () {BtnUp();});
		$('#ComfirmeUp').click(function () {NouvRess_Upload();});
		///gestion de l’animation
		/*$('#loading').ajaxStart(function(request, settings) { $(this).css("visibility", "visible") });
		$('#loading').ajaxStop(function(request, settings){ $(this).css("visibility", "hidden") });*/
		
		//$('#loading').css("visibility", "hidden");
		/*$(document).ajaxStart(function() {
		  $('#loading').css("visibility", "visible");
		}).ajaxStop(function() {
		  $('#loading').css("visibility", "hidden");
		});*/
			$(document).ajaxStart(function () {
                //alert("ajaxStart");
                $('#loading').css("visibility", "visible");
            });

            $(document).ajaxComplete(function () {
                //alert("ajaxComplete");
                $('#loading').css("visibility", "hidden");
            });
			
		$('#BoiteLien').css("visibility", "hidden");
		$('#BoiteUploald').css("visibility", "hidden");
		//Liste_Ressource(IdChapitre)
		$('#AjouterSlide').click(function () {PrepareAjoutSlide();});
		
		$('#EnregQuetion').click(function () {PrepareAjoutQuestion();});
		
		$('#Avec').change(function () {PrepareEtatExam(1);});
		$('#Sans').change(function () {PrepareEtatExam(0);});
	});
	function PrepareEtatExam(Etat){
		IdExamen=$('#IdExamen').val();
		Modif_Etat_Exam(IdExamen,Etat);
	}
	function PrepareAjoutSlide(){
		Texte=tinyMCE.get('TexteSlide').getContent();
		Image="";
		IdChapitre=$("#IdChapitre").val();
		Ordre=1;
		var Texte = Texte.replace(/&/g, '%26');
		Texte = Texte.replace(/'/g, "\\'");
		//Texte = Texte.replace("/", "//");
		//alert("Le texte = "+Texte);
		//alert($('#TexteSlide').html());
		Ajout_Slide(Texte, Image, IdChapitre, Ordre);
	}
	function PrepareAjoutEtape(){
		IdCulture=$("#IdCulture").val();
		NEtape=$("#NEtape").val();
		Ajout_Etatpe(IdCulture,NEtape,"0");
	}
	function PrepareAjoutIntra(){
		NomIntras=$("#Intras").val();
		QtePB=$("#QtePB").val();
		Donnees=NomIntras.split("*");
		//$data['IdIntra']."/".$data['CoutUnitaire']."/".$data['CodeMonnaie']."/".$data['NomIntra']
		IdIntra=Donnees[0];
		CoutUnitaire=Donnees[1];
		CodeMonnaie=Donnees[2];
		NomI=Donnees[3];
		Unite=Donnees[4];
		CoutI=CoutUnitaire*QtePB;
		TextIntra=IdIntra+","+NomI+" : "+QtePB+" ("+Unite+") X "+CoutUnitaire+CodeMonnaie+" = "+CoutI;
		//alert(TextIntra);
		Ajout_Intra(IdIntra,QtePB,CoutI,TextIntra,"Nouv",0)
		/*LienH=$("#LienOutils").val();
		IdChapitre=$("#IdChapitre").val();
		Ajout_Outils(NomOutils,Version,IdChapitre,LienH);*/
	}
	function PrepareAjoutTache(){
		NomTache=$("#NomTache").val();
		NbJours=$("#NbJours").val();
		TachePreced=$("#TachePreced").val();
		IdEtape=$("#IdEtaper").val();
		CNb=NbreO+1;
		Position=1;
		
		if(NbreO>0){
			ChaineP="[";
			while(Position<CNb){
				//if(Position!=1)ListeAssertion=ListeAssertion+',';
				DType=$('#DTy'+Position+'').val();
				if(DType="Nouv"){
					IdIntra=$('#DT'+Position+'').val();
					QteIntra=$('#DQ'+Position+'').val();
					ChaineP=ChaineP+"{\"IdIntra\":\""+IdIntra+"\",\"Qte\":\""+QteIntra+"\"}";
					//if(Position=1)
					Position++;
					if(Position<CNb){
						ChaineP=ChaineP+",";
					}
				}
				
				
			}
			ChaineP=ChaineP+"]";
			//alert(ChaineP);
			Chaine=JSON.parse(ChaineP);
			ChaineIntra = JSON.stringify(Chaine);
			//alert(ChaineIntra);
		}else{
			ChaineIntra="[]";
		}
		Ajout_Taches(NomTache, NbJours, TachePreced, IdEtape, ChaineIntra);
	}
	function PrepareModifTache(TypeContenu){
		IdTache=$("#IdTacher").val();
		if(IdTache!=0){
			NomTache=$("#NomTache").val();
			NbJours=$("#NbJours").val();
			TachePreced=$("#TachePreced").val();
			IdEtape=$("#IdEtaper").val();
			CNb=NbreO+1;
			Position=1;
			
			if(NbreO>0){
				ChaineP="[";
				while(Position<CNb){
					//if(Position!=1)ListeAssertion=ListeAssertion+',';
					DType=$('#DTy'+Position+'').val();
					if(DType="Nouv"){
						IdIntra=$('#DT'+Position+'').val();
						QteIntra=$('#DQ'+Position+'').val();
						ChaineP=ChaineP+"{\"IdIntra\":\""+IdIntra+"\",\"Qte\":\""+QteIntra+"\"}";
						//if(Position=1)
						Position++;
						if(Position<CNb){
							ChaineP=ChaineP+",";
						}
					}
					
					
				}
				ChaineP=ChaineP+"]";
				//alert(ChaineP);
				Chaine=JSON.parse(ChaineP);
				ChaineIntra = JSON.stringify(Chaine);
				//alert(ChaineIntra);
			}else{
				ChaineIntra="[]";
			}
			Modif_Tache(IdTache, NomTache, NbJours, TachePreced, ChaineIntra);
		}
	}
	function InitFormTache(){
		$("#IdTacher").val(0);
		$("#NomTache").val('');
		$("#NbJours").val('');
		$("#TachePreced").val('');
		//IdEtape=$("#IdEtaper").val();
		NbreO=0;
		$("#TabIntra").empty();
		$("#AjoutTache").css("visibility", "visible");
		$("#ModifTache").css("visibility", "hidden");
		$("#Titre_Action").html("Nouvel Tâche");
	}
	function visualise(){
		Fichier=$('#LienYutub').val();
		if(Fichier!=""){
			$('#Ecran').attr('src',Fichier);
		}
	}

/////////////////////
$(function() {
  var $tabButtonItem = $('#tab-button li'),
	  $tabButtonItem2 = $('#tab-button2 li'),
      $tabSelect = $('#tab-select'),
	  $tabSelect2 = $('#tab-select2'),
      $tabContents = $('.tab-contents'),
	  $tabContents2 = $('.tab-contents2'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabButtonItem2.first().addClass(activeClass);
  $tabContents.not(':first').hide();
  $tabContents2.not(':first').hide();
//alert('bombe');
  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });
  $tabButtonItem2.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem2.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents2.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });
  $tabSelect2.on('change', function() {
    var target = $(this).val(),
        targetSelectNum = $(this).prop('selectedIndex');

    $tabButtonItem2.removeClass(activeClass);
    $tabButtonItem2.eq(targetSelectNum).addClass(activeClass);
    $tabContents2.hide();
    $(target).show();
  });
});
/////////////////////////////////////////////////////

/*function Rep_Test(Reponse){
		alert(Reponse);
	}*/
Dropzone.options.myDropzone = {
                dictResponseError:true,
                maxFilesize: 2,  //(2 mb is here the max file upload size constraint)
				acceptedFiles: ".jpeg, .jpg, .png, .JPEG, .JPG, .PNG, .pdf, .PDF",
				url:'codes/serveur/Upload_Fichier.php',
				addRemoveLinks: true,
				maxFiles:1,
				//success: Rep_Test,
				//dictDefaultMessage:"Cliquez ici pour changer l'image",
            removedfile: function(file) {
                    var name = file.name;        
                    $.ajax({
                    type: 'POST',
                    url: 'delete_dropzone.php',
                    data: "id="+name,
                    dataType: 'html'
                        });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
            },

			init: function(file) {
				this.on("maxfilesexceeded", function(file) { this.removeFile(file); });
				this.on("success", function(file, responseText) {
				  // Handle the responseText here. For example, add the text to the preview element:
				  //file.previewTemplate.appendChild(document.createTextNode(responseText));
				  //var mot=;
					alert(responseText);
					$('#IdFichier').val(responseText);
			})
			this.on("addedfile", function(file) { $('#loading').show(); $('#Publier').attr("disabled", true); });
			this.on("complete", function(file) { $('#loading').hide(); $('#Publier').attr("disabled", false);});
			
			
        }
		}