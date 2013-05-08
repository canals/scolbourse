// Ajax Suggest .. www.w3schools.com

var xmlHttp;
var messageObj = new DHTML_modalMessage();	
messageObj.setShadowOffset(10);	

// Creer un instance du objet XMLHttpRequest
function getXMLHttpRequestObject() {   
     var oRequest = null;
     
     try {
          oRequest = new ActiveXObject("Microsoft.XMLHTTP");
     } catch(Error) {
		 try {
			 oRequest = new ActiveXObject("MSXML2.XMLHTTP");
		 } catch(Error) {
				 oRequest = new XMLHttpRequest();
		 }			 
	 }	 
     return oRequest;  
}

function stateChanged() { 	
	if ((xmlHttp.readyState == 4) && (xmlHttp.status == 200)){ 		
		var resp = xmlHttp.responseText;
		resp += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		resp += "	<font color='#131313'>Fermer</font>";
		resp += "	</a></div>";
		showMessage(resp, 255, 200);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Patientez pendant l'enregistrement des données, s'il vous plaît!</div><br/>";
		messageContent += "</div><br/>";					
		showMessage(messageContent, 200, 100);
	}
}
		
function ModifierTaux() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();
	
	if (xmlHttp == null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	
	var fraisDossier = document.getElementById("frais_dossier"); fraisDossier = fraisDossier.value;
	var fraisEnvoi = document.getElementById("frais_envoi"); fraisEnvoi = fraisEnvoi.value;
	
	if(isNaN(fraisDossier) || isNaN(fraisEnvoi)){
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Données incorrectes!</h3><br/>";
		messageContent += "	<div>Les données ne sont pas des num&eacute;ros!</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		showMessage(messageContent, 255, 110);
		return;	
	}else{
		if((fraisDossier == "") || (fraisEnvoi == "")) {
			var messageContent = "<div>"; 
			messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Données incorrectes!</h3><br/>";
			messageContent += "	<div>Les champs ne doivent pas être vides!</div><br/>";
			messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
			messageContent += "	<font color='#131313'>Fermer</font>";
			messageContent += "	</a></div>";
			messageContent += "</div>";					
			showMessage(messageContent, 255, 110);
			return;					
		} else {
		   	if((fraisDossier < 0) || (fraisDossier > 100)) {
				var messageContent = "<div>"; 
				messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Données incorrectes!</h3><br/>";
				messageContent += "	<div>Pourcentage incorrecte!</div><br/>";
				messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
				messageContent += "	<font color='#131313'>Fermer</font>";
				messageContent += "	</a></div>";
				messageContent += "</div>";					
				showMessage(messageContent, 255, 110);
				return;					
			} else {
				//var url = "/ScolBoursePHP/index.php/Parametrage/modifier";
				var url = "/ScolBoursePHP/index.php/Parametrage/modifier/" + fraisDossier + "/" + fraisEnvoi;
			}
		}
	}
	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);	
}

function showMessage(html, width, heigth){
        messageObj = new DHTML_modalMessage();	
messageObj.setShadowOffset(10);	
	messageObj.setSource(false);
	messageObj.setHtmlContent(html);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(width,heigth);
	messageObj.setShadowDivVisible(true);	 
	messageObj.display();
} 

function closeMessage()	{
	messageObj.close();	
}
