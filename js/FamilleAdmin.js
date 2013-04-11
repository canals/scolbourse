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
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var resp = xmlHttp.responseText;				
		displayMessage(resp,800,350);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}
		
function rechercher() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	
	var nomFam = document.getElementById("nomCh"); nomFam = nomFam.value;
	var telFam = document.getElementById("telCh"); telFam = telFam.value;
	var numFam = document.getElementById("numCh"); numFam = numFam.value;
	var numExe = document.getElementById("exeCh"); numExe = numExe.value;
	 
	if((numExe=="")&&(nomFam=="")&&(telFam=="")&&(numFam=="")) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Crit&eagrave;re de recherche</h3><br/>";
		messageContent += "	<div>Vous devez introduire un crit&eagrave;re de recherche...</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;					
	} else {		
		var url = "/ScolBoursePHP/index.php/";  	
		if(numExe!="")
			url += "Exemplaire/listeParNum/" + numExe;
		else if(nomFam!="")
			url += "Famille/listeParNom/" + nomFam;
		else if(telFam!="")
			url += "Famille/listeParTel/" + telFam;
		else if(numFam!="")
			url += "Famille/listeParDossier/" + numFam;				
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function nouvelleRecherche() {
	window.location.replace("/ScolBoursePHP/index.php/Famille/");		
}

function displayMessage(html, width, heigth){			
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

function soulignerRow(elem, laClass){
	elem.className=laClass; 
}

function selectFamille(id) {
	window.location.replace("/ScolBoursePHP/index.php/Famille/voir/" + id);
}

/*** Fonction pour travailler sur les familles ***/
function activerFormulaireFamille() {
	// Formulaire superieure
	document.getElementById("nomCh").disabled="disabled";  document.getElementById("telCh").disabled="disabled";
	document.getElementById("numCh").disabled="disabled";  document.getElementById("exeCh").disabled="disabled";
	
	// Formulaire Central
	document.getElementById("nom_famille").disabled="";  
	document.getElementById("prenom_famille").disabled="";
	document.getElementById("num_tel_famille").disabled="";  
	document.getElementById("ville_famille").disabled="";
	document.getElementById("code_postal_famille").disabled="";  
	document.getElementById("adresse1_famille").disabled="";
	document.getElementById("adresse2_famille").disabled="";  
	document.getElementById("adherent_association").disabled="";
	document.getElementById("enlevettfrais").disabled="";  
	document.getElementById("indication_famille").disabled="";
	
	// Boutons
	document.getElementById("btnCh").disabled="disabled";        document.getElementById("btnNCh").disabled="disabled";
	document.getElementById("btnNouvelle").disabled="disabled";  document.getElementById("btnValider").disabled="";
	document.getElementById("btnModifier").disabled="disabled";  document.getElementById("btnAnnuler").disabled="";
	//window.location.replace("/ScolBoursePHP/index.php/Famille/" + id);
} 

function exporter(radio) {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
		for(var i = 0;i<radio.length;i++){
			if(radio[i].checked){
				id=radio[i].value;
				var url;
				//alert(id);
				switch(id){
					case'csv' : url = "/ScolBoursePHP/index.php/Famille/export/csv";break;
					case'sql' : url = "/ScolBoursePHP/index.php/Famille/export/sql";break;
				}
				
			}
		}
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}


function annulerFormulaire() {
	window.location.reload();
}