// Ajax Suggest .. www.w3schools.com

var idMan;
var idExem;

function voirManuel(idManuel) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 						
    var url = "/ScolBoursePHP/index.php/Manuel/voirDetail/" + idManuel;
	idMan = idManuel;
		
	xmlHttp.onreadystatechange=consulterManuel;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function consulterManuel() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var resp = "";
		resp += "<div class='liste' style='padding:10px; text-align:left;'>";
		resp += "<div align='left'>";
		resp += "	<h3>DEPOT: Detail du manuel</h3>";		
		resp += "</div>";	
		resp += "<div align='left'>";
		resp += xmlHttp.responseText;
		resp += "</div>";	
		resp += "<div align='center'>";
		resp += " <h3>&nbsp;</h3>";		
 
		resp += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";				
		resp += "</div>";	
		resp += "</div>";	
		displayMessage(resp,450,200);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}

function SupprimerExemplaire(idExemplaire) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 						
    idExem = idExemplaire;
	var url = "/ScolBoursePHP/index.php/Exemplaire/voirDetail/" + idExem;  		 
		
	xmlHttp.onreadystatechange=consulterExemplaire;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function consulterExemplaire()	{	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var resp = "";
		resp += "<div class='liste' style='padding:10px; text-align:left;'>";
		resp += "<div align='left'>";
		resp += "	<h3>DEPOT: Supprimer exemplaire</h3>";		
		resp += "</div>";	
		resp += "	<br/><div>Attention,&ecirc;tes vous s&ucirc;r de supprimer l'exemplaire ?</div><br/>";
		resp += "<div align='left' style='margin:0px 5px 0px 5px; padding:10px; background:#F9F9F9;'>";		
		resp += xmlHttp.responseText;
		resp += "</div>";	
		resp += "<div align='center'>";
		resp += " <h3>&nbsp;</h3>";		
		resp += "	  <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Annuler</font></a>&nbsp;&nbsp;";
		resp += "	  <a href='' onclick='confirmSupprimer(" + idExem + "); return false;'><font color='#E35F06'>Supprimer</font></a>";
		resp += "</div>";	
		resp += "</div>";				
		displayMessage(resp,500,250);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}				   
}

function confirmSupprimer(idExemplaire)	{
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 						
    var url = "/ScolBoursePHP/index.php/Depot/supprimerExemplaire/" + idExemplaire;  		 
		
	xmlHttp.onreadystatechange=supprimer;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function supprimer() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){
                var data = $.parseJSON(xmlHttp.responseText);
		var msg = "";
		msg += "<div class='liste' style='padding:10px; text-align:left;'>";
		msg += "<div align='left'>";
		msg += "	<h3>DEPOT: Supprimer exemplaire</h3>";		
		msg += "</div>";	
		msg += "<div align='left'>";
		/*msg += xmlHttp.responseText;*/
                msg += data.message ;
		msg += "</div>";	
		msg += "<div align='center'>";
		msg += " <h3>&nbsp;</h3>";			 
		msg += " <a href='' onclick='window.location.reload(true); return true;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
		msg += "</div>";	
		msg += "</div>";	
		displayMessage(msg,290,123);							
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}

function ajouterExemplaire(){
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 	
	
	var numDossi = document.getElementById("numDossierDepot");  numDossi = numDossi.value;
	var codeManu = document.getElementById("codeManuel"); 	    codeManu = codeManu.value;
	var codeExem = document.getElementById("codeExemplaire");   codeExem = codeExem.value;
	var codeEtat = document.getElementById("codeEtat"); 	    codeEtat = codeEtat.value;
	 
	if((numDossi=="")||(codeManu=="")||(codeExem=="")||(codeEtat=="")) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Champs obligatoires</h3><br/>";
		messageContent += "	<div>Vous devez remplir tous les champs demand&eacute;s...</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;					
	} else {			
		if((isNaN(numDossi))||(isNaN(codeManu))||(isNaN(codeExem))||(isNaN(codeEtat))) {
			var messageContent = "<div>"; 
			messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Valeurs des champs</h3><br/>";
			messageContent += "	<div>Les valeurs que vous avez introduites ne sont pas valides...</div><br/>";
			messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
			messageContent += "	<font color='#131313'>Fermer</font>";
			messageContent += "	</a></div>";
			messageContent += "</div>";					
			displayMessage(messageContent,255,110);
			return;		
		} else {
			var url = "/ScolBoursePHP/index.php/Depot/ajouterExemplaire/" + numDossi + "/" + codeExem + "/" + codeManu + "/" + codeEtat;  			 		
		}	
	}	

	xmlHttp.onreadystatechange=ajouterAction;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);		
}

function ajouterAction() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 										
		var resp = xmlHttp.responseText;
                var data = $.parseJSON(xmlHttp.responseText);
		if(data.message != "OK") {
			var msg = "";
			msg += "<div class='liste' style='padding:10px; text-align:left;'>";
			msg += "<div align='left'>";
			msg += "	<h3>DEPOT: Ajouter exemplaire</h3>";		
			msg += "</div>";	
			msg += "<div align='left'>";
			msg += data.message;
			msg += "</div>";	
			msg += "<div align='center'>";
			msg += " <h3>&nbsp;</h3>";			 
			msg += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
			msg += "</div>";	
			msg += "</div>";	
			displayMessage(msg,300,120);
		} else {			
			window.location.reload(true); 			
		}
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>DEPOT: Ajouter Exemplaire...</h3><br/>";
		messageContent += "	  <div align='center'>Mise &agrave; jour des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}


function miseAJourDepot(idDossierDepot, field) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 						
		
	var enlever = (field.checked)?"o":"n";
	
    var url = "/ScolBoursePHP/index.php/Depot/fraisEnvoi/" + idDossierDepot + "/" + enlever;
				
	xmlHttp.onreadystatechange=miseAJourDepotAction;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function miseAJourDepotAction() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var data = $.parseJSON(xmlHttp.responseText);
		if(data.message != "OK") {
			var msg = "";
			msg += "<div class='liste' style='padding:10px; text-align:left;'>";
			msg += "<div align='left'>";
			msg += "	<h3>Ajouter exemplaire</h3>";		
			msg += "</div>";	
			msg += "<div align='left'>";
			msg += data.message;
			msg += "</div>";	
			msg += "<div align='center'>";
			msg += " <h3>&nbsp;</h3>";			 
			msg += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
			msg += "</div>";	
			msg += "</div>";	
			displayMessage(msg,300,120);
		} else {
			window.location.reload(true); 			
		}			
	} 
}

function impprimerRecipisee(numFamille) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 		
	
    var url = "/ScolBoursePHP/index.php/Rapport/recepisse_depot_particulier/" + numFamille;
				
	xmlHttp.onreadystatechange=impprimer;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function impprimer() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var msg = "";
		msg += "<div class='liste' style='padding:10px; text-align:left;'>";		
		msg += "<div align='left'>";
		msg += xmlHttp.responseText;
		msg += "</div>";	
		msg += "</div>";	
		displayMessage(msg,290,123);							
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}


function retourInvendus(numFamille) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 		
	
    var url = "/ScolBoursePHP/index.php/Depot/retourInvendus/" + numFamille;
				
	xmlHttp.onreadystatechange=invendus;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function invendus() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var msg = "";
		msg += "<div class='liste' style='padding:10px; text-align:left;'>";		
		msg += "<div align='left'>";
		msg += xmlHttp.responseText;
		msg += "</div>";	
		msg += "</div>";	
		displayMessage(msg,800,350);							
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}


function rapportInvendus(numFamille) {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 		
	
    var url = "/ScolBoursePHP/index.php/Rapport/retour_invendus_particulier/" + numFamille;
				
	xmlHttp.onreadystatechange=impprimer;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function venduExemplaire(numDossi,codeExem){
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 	
				
	if( (isNaN(numDossi))|| (isNaN(codeExem)) ) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Valeurs des champs</h3><br/>";
		messageContent += "	<div>Les valeurs que vous avez introduites ne sont pas valides...</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;		
	} else {
		var url = "/ScolBoursePHP/index.php/Achat/ajouterExemplaire/" + numDossi + "/" + codeExem ;  			 		
	}	
	
	xmlHttp.onreadystatechange=vendu;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);		
}

function vendu() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 										
		var resp = xmlHttp.responseText;
		if(resp!="OK") {
			var msg = "";
			msg += "<div class='liste' style='padding:10px; text-align:left;'>";
			msg += "<div align='left'>";
			msg += "	<h3>DEPOT: Passer en vendu exemplaire...</h3>";		
			msg += "</div>";	
			msg += "<div align='left'>";
			msg += resp;
			msg += "</div>";	
			msg += "<div align='center'>";
			msg += " <h3>&nbsp;</h3>";			 
			msg += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
			msg += "</div>";	
			msg += "</div>";	
			displayMessage(msg,300,120);
		} else {
			window.location.reload(true); 
		}
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>DEPOT: Passer en vendu exemplaire...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la mise &agrave; jour des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}


function rendreExemplaire(numDossi,codeExem){
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 	
				
	if( (isNaN(numDossi))|| (isNaN(codeExem)) ) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Valeurs des champs</h3><br/>";
		messageContent += "	<div>Les valeurs que vous avez introduites ne sont pas valides...</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;		
	} else {
		var url = "/ScolBoursePHP/index.php/Depot/rendreExemplaire/" + numDossi + "/" + codeExem ;  			 		
	}	
	
	xmlHttp.onreadystatechange=rendre;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);		
}

function rendre() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 										
		var data = $.parseJSON(xmlHttp.responseText);
		if(data.message != "OK") {
			var msg = "";
			msg += "<div class='liste' style='padding:10px; text-align:left;'>";
			msg += "<div align='left'>";
			msg += "	<h3>DEPOT: Rendre exemplaire</h3>";		
			msg += "</div>";	
			msg += "<div align='left'>";
			msg += resp;
			msg += "</div>";	
			msg += "<div align='center'>";
			msg += " <h3>&nbsp;</h3>";			 
			msg += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>";			
			msg += "</div>";	
			msg += "</div>";	
			displayMessage(msg,300,120);
		} else {
			window.location.reload(true); 
		}
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>DEPOT: Rendre Exemplaire...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la mise &agrave; jour des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}