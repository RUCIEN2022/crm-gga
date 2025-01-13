// JavaScript Document

	var Nbre=0;
	var NbreO=0;
	function traitement_Recherche_Contenu(reponse){
				listeJSON = reponse;
				alert(listeJSON);
				//$("#TabDate > tbody").empty();
				if (listeJSON!=0){
					//alert(listeJSON);
					objetJSON3=JSON.parse(listeJSON);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Tab_Contenu.length;i++){
						var IdContenu=objetJSON3.Tab_Contenu[i].IdContenu;
						var Typecontenu=objetJSON3.Tab_Contenu[i].Typecontenu;
						
						var Fichier=objetJSON3.Tab_Contenu[i].Fichier;
						var TexteContenu=objetJSON3.Tab_Contenu[i].TexteContenu;
						
						var Heure=objetJSON3.Tab_Contenu[i].Heure;
						var Minute=objetJSON3.Tab_Contenu[i].Minute;
						
						AfficheContenu(IdContenu,Typecontenu,Fichier,TexteContenu,Heure,Minute);
					}
					
				}else{
					//ErrPlage();
					alert("Erreur");
					}
	}
	function AfficheContenu(IdContenu,Typecontenu,Fichier,TexteContenu,Heure,Minute){
		if(Typecontenu=="Texte"){
			//alert(TexteContenu);
			//$('textarea#Texte').html(TexteContenu);
			//$('textarea#Texte').val(TexteContenu);
			//$('textarea#Description').val(TexteContenu);
			
			tinyMCE.get('Texte').setContent(TexteContenu);
			//$("textarea#Texte").append(result.TexteContenu);
			$('#tab_texte').get(0).click();
		}
		if(Typecontenu=="Video"){
			$('#Ecran').attr('src',Fichier);
			$('#tab_video').get(0).click();
			
		}
		if(Typecontenu=="Live"){
			//
			$('#Synthese').val(TexteContenu);
			$('#Lheure').val(Heure);
			//alert('Mim'+$('#Lheure').val());
			$('#LMinute').val(Minute);
			Liste_Outils($('#IdChapitre').val());
			$('#tab_live').get(0).click();
		}
	}
	function traitement_Liste_Chapitres(reponse){
				listeJSON = reponse;
				//alert(listeJSON);
				//$("#TabDate > tbody").empty();
				if (listeJSON!=0){
					//alert(listeJSON);
					objetJSON3=JSON.parse(listeJSON);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Tab_Chapitres.length;i++){
						var IdChapitre=objetJSON3.Tab_Chapitres[i].IdChapitre;
						var Titre=objetJSON3.Tab_Chapitres[i].Titre;
						
						var Synthese=objetJSON3.Tab_Chapitres[i].Synthese;
						var IdContenu=objetJSON3.Tab_Chapitres[i].IdContenu;
						var IdCours=objetJSON3.Tab_Chapitres[i].IdCours;
						var Position=objetJSON3.Tab_Chapitres[i].Position;
						
						var EtatChapitre=objetJSON3.Tab_Chapitres[i].EtatChapitre;
						//alert(Titre);
						nouvelleLigneC(Titre,IdChapitre,IdContenu);
					}
					
				}else{
					//ErrPlage();
					alert("Erreur");
					}
	}
	function nouvelleLigneC(Titre,IdChapitre,IdContenu) {
		//alert(nomagence);
		/*if(etatagence==0){
				etatagence="Désactivé";
		}else if(etatagence==1){
				etatagence="Actif";
		}else if(etatagence==2){
				etatagence="Veroullé";
		}else{
				etatagence="Non reconnu";
			}*/
			Nbre++;
		$("#TabDate").append('<tr id="'+Nbre+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><a href="javascript:select_Chapitre('+IdChapitre+','+IdContenu+',\''+Titre+'\')"><p>'+Titre+'</p></a></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+Nbre+'" id="D'+Nbre+'" value="'+IdChapitre+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+Nbre+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		
	}
	
	function Ajout_Chap(){
		//$('#testi').val($('#datetimepicker').val());
		//alert('Boni');
		Nbre++;
		//Lieu1=
		/*if(Nbre>1){
			Lieu1=$('#L1').val();
		}else{
			Lieu1='';
		}*/
		$('#NbreJour').val(Nbre);
		$('#TabDate').append('<tr id="'+Nbre+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p>'+$('#ETitre').val()+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+Nbre+'" id="D'+Nbre+'" value="'+$('#ETitre').val()+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+Nbre+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#ETitre').val('');
	}
	/*$("#datetimepicker").datetimepicker().on('hide',function(ev){
		$("#datetimepicker").val('Ajouter une date');
		//e.preventDefault();
	});*/
	/////////////////////////////
	function supprimer(id){
        if (id > 0) {
            //Exécution du script PHP avec Ajax
			/*if (confirm("Etes-vous sûr de vouloir supprimer cet élément ?"))
            {
            $('#TabDate tr[id="' + id + '"] td').css({
                        'backgroundImage': 'none',
                        'backgroundColor': 'white',
                    });
                    $('#TabDate tr[id="' + id + '"] td').animate({
                        'backgroundColor': '#ff8888',
                        'color': '#941010'
                    }, 1000);*/
					$('#TabDate tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                        $(this).hide();
						$(this).remove();
                    });
           
            //} 
        }
    }
	
	function select_Chapitre(idChap,idCont,Titre){
		//alert(idCont); 
        if (idChap > 0) {
            $('#IdChapitre').val(idChap);
			$('#IdContenu').val(idCont);
			$('#TitreChap').html(Titre);
			Reche_Contenu(idCont);
			
			/*$('#TabDate tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
				$(this).hide();
				$(this).remove();
			
			});*/
        }
    }
	function Rep_Cours(Reponse){
		alert(Reponse);
		Ajout_Chap();
	}
	function Rep_Contenu(Reponse){
		alert(Reponse);
		//Ajout_Chap();
	}
	function Rep_Outils(Reponse){
		alert(Reponse);
		Ajout_Out(Reponse);
	}
	function Ajout_Chapitre(IdCours,Titre) {
	//alert(CodeTypeCompte);
	Position=1;
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Chapitre.php',
		   data: "IdCours="+ IdCours+"&Titre="+ Titre+"&Position=1",
		   dataType: 'text',
		   success: Rep_Cours,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	function traitement_Liste_Outils(reponse){
				listeJSON = reponse;
				//alert(listeJSON);
				//$("#TabDate > tbody").empty();
				if (listeJSON!=0){
					//alert(listeJSON);
					objetJSON3=JSON.parse(listeJSON);
					//rich=objetJSON3.membre.length;
					for(i=0;i<objetJSON3.Tab_Outils.length;i++){
						var IdOutils=objetJSON3.Tab_Outils[i].IdOutils;
						
						var NomOutils=objetJSON3.Tab_Outils[i].NomOutils;
						var Version=objetJSON3.Tab_Outils[i].Version;
						
						var IdChapitre=objetJSON3.Tab_Outils[i].IdChapitre;
						var EtatOutils=objetJSON3.Tab_Outils[i].EtatOutils;
						var Lien=objetJSON3.Tab_Outils[i].Lien;
						
						//alert(Titre);
						nouvelleLigneOut(IdOutils,NomOutils,Version,IdChapitre,Lien);
						
					}
					
				}else{
					//ErrPlage();
					alert("Erreur");
					}
	}
	
	function nouvelleLigneOut(IdOutil,NOutils,VersionOutils,IdChapitre,LienOutils) {
			NbreO++;
		$("#TabOutils").append('<tr id="'+NbreO+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p><a href="'+LienOutils+'">'+NOutils+' '+VersionOutils+'<br/>'+LienOutils+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+Nbre+'" id="D'+Nbre+'" value="'+IdOutil+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+NbreO+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		
	}
	
	function Ajout_Out(IdOutil){
		alert('Pic');
		NbreO++;
		$('#NbreOutils').val(NbreO);
		$('#TabOutils').append('<tr id="'+NbreO+'"><td><div class="row"><div class="col-md-10"><div class="row"><div class="col-md-12"><p><a href="'+$('#LienOutils').val()+'">'+$('#NOutils').val()+' '+$('#VersionOutils').val()+'</p></div></div><div class="row"><div class="col-md-12"><input type="hidden" name="D'+NbreO+'" id="D'+NbreO+'" value="'+$('#NOutils').val()+'"/></div></div></div><div class="col-md-2"><a href="javascript:supprimer('+NbreO+')" class="supprimer" alt="Supprimer"><span class="glyphicon glyphicon-remove">X</span></a></div></div></td></tr>');
		$('#NOutils').val('');$('#VersionOutils').val('');$('#LienOutils').val('');
	}
	
	/////////////////////////////
	function supprimerOutils(id){
        if (id > 0) {
           
					$('#TabDate tr[id="' + id + '"] td').fadeTo("slow", 0, function(){
                        $(this).hide();
						$(this).remove();
                    });
           
            //} 
        }
    }
	function Ajout_Outils(NomOutils,Version,IdChapitre,Lien) {
	//alert("To go");
	$.ajax({
		   
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Ajout_Materiel.php',
		   data: "NomOutils="+ NomOutils+"&Version="+ Version+"&IdChapitre="+IdChapitre+"&Lien="+Lien,
		   dataType: 'text',
		   success: Rep_Outils,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Liste_Outils(IdChapitre) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Liste_Outils.php',
		   data: "IdChapitre="+ IdChapitre,
		   dataType: 'text',
		   success: traitement_Liste_Outils,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	function Liste_Chapitres(IdCours) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Update_Chapitres.php',
		   data: "IdCours="+ IdCours,
		   dataType: 'text',
		   success: traitement_Liste_Chapitres,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Reche_Contenu(IdContenu) {
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Recherche_Contenu.php',
		   data: "IdContenu="+ IdContenu,
		   dataType: 'text',
		   success: traitement_Recherche_Contenu,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	function Modif_Contenu(IdContenu,Typecontenu,Fichier,TexteContenu,NbreHeure) {
		//alert("tel "+IdContenu);
		$.ajax({
		   type: 'GET',
		   url: 'codes/serveur/Serveur_Modif_Contenu.php',
		   data: "IdContenu="+ IdContenu+"&Typecontenu="+Typecontenu+"&Fichier="+Fichier+"&TexteContenu="+TexteContenu+"&NbreHeure="+NbreHeure,
		   //data: { IdContenu: poststr, Typecontenu:Typecontenu, Fichier:Fichier,TexteContenu:TexteContenu},
		   dataType: 'text',
		   success: Rep_Contenu,
		   error: function() {alert('Erreur serveur ID');}
		   
		   });
	}
	
	$(document).ready(function() {
		//alert('Bana');
		$('#AjouteChap').click(function () {PrepareAjoutChap();});
		$('#AjouteOutil').click(function () {PrepareAjoutOutil();});
		Liste_Chapitres($("#IdCours").val());
		$('#Enreg').click(function () {PrepareModifContenu("Texte");});
		$('#EnregVideo').click(function () {PrepareModifContenu("Video");});
		$('#Visualiser').click(function () {visualise();});
		$('#EnregLive').click(function () {PrepareModifContenu("Live");});
	});
	
	function PrepareAjoutChap(){
		IdCours=$("#IdCours").val();
		ETitre=$("#ETitre").val();
		Ajout_Chapitre(IdCours,ETitre);
	}
	function PrepareAjoutOutil(){
		NomOutils=$("#NOutils").val();
		Version=$("#VersionOutils").val();
		LienH=$("#LienOutils").val();
		IdChapitre=$("#IdChapitre").val();
		Ajout_Outils(NomOutils,Version,IdChapitre,LienH);
	}
	function PrepareModifContenu(TypeContenu){
		NbreHeure='00:00';
		if(TypeContenu=="Texte"){
			//Texte=$("#Texte").val();
			Texte=tinyMCE.get('Texte').getContent();
			Fichier="x";
			IdContenu=$('#IdContenu').val();
			
			var Texte = Texte.replace('&', '%26');
			Texte = Texte.replace("'", "\'");
		}
		if(TypeContenu=="Video"){
			
			Fichier=$('#LienYutub').val();
			IdContenu=$('#IdContenu').val();
			Texte="_";
			var Fichier = Fichier.replace('&', '%26');
			Fichier = Fichier.replace("'", "\'");
			//alert("Balo "+Fichier);
		}
		if(TypeContenu=="Live"){
			
			Fichier="x";
			IdContenu=$('#IdContenu').val();
			//Texte=tinyMCE.get('Texte').getContent();
			Texte=$('#Synthese').val();
			Texte = Texte.replace('&', '%26');
			Texte = Texte.replace("'", "\'");
			NbreHeure=$('#Lheure').val()+":"+$('#LMinute').val();
			//alert("Balo "+Fichier);
		}
		Modif_Contenu(IdContenu,TypeContenu,Fichier,Texte,NbreHeure);
	}
	function visualise(){
		Fichier=$('#LienYutub').val()
		if(Fichier!=""){
			$('#Ecran').attr('src',Fichier);
		}
	}
/////////////////////
$(function() {
  var $tabButtonItem = $('#tab-button li'),
      $tabSelect = $('#tab-select'),
      $tabContents = $('.tab-contents'),
      activeClass = 'is-active';

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(':first').hide();

  $tabButtonItem.find('a').on('click', function(e) {
    var target = $(this).attr('href');

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
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
});