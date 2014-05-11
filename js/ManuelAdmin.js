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
		
function ManuelChercher() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	
	var nomMan = document.getElementById("nomCh");    nomMan = nomMan.value;
	var matCh  = document.getElementById("matCh");    matCh = matCh.value;
	var codCh  = document.getElementById("codCh");    codCh = codCh.value;
	var editCh = document.getElementById("editCh");   editCh = editCh.value;
	 
	if((editCh=="")&&(codCh=="")&&(matCh=="")&&(nomMan=="")) {
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
		if(editCh!="")
			url += "Manuel/listeParEdit/" + editCh;
		else if(codCh!="")
			url += "Manuel/listeParCode/" + codCh;
		else if(matCh!="")
			url += "Manuel/listeParMatiere/" + matCh;
		else if(nomMan!="")
			url += "Manuel/listeParNom/" + nomMan;				
	}
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function nouvelleRecherche() {
	window.location.replace("/ScolBoursePHP/index.php/Manuel/");		
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
					case'csv' : url = "/ScolBoursePHP/index.php/Manuel/export/csv";break;
					case'sql' : url = "/ScolBoursePHP/index.php/Manuel/export/sql";break;
				}
				
			}
		}
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function displayMessage(html, width, heigth){
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

function soulignerRow(elem, laClass){
	elem.className=laClass; 
}

function selectManuel(id) {
	window.location.replace("/ScolBoursePHP/index.php/Manuel/voir/" + id);
}

/*** Fonction pour travailler sur les familles ***/
function activerFormulaire() {
	// Formulaire superieure
	document.getElementById("nomCh").disabled="disabled";  document.getElementById("editCh").disabled="disabled";
	document.getElementById("matCh").disabled="disabled";  document.getElementById("codCh").disabled="disabled";
	
	// Formulaire Central
	document.getElementById("code_manuel").disabled="";  
	document.getElementById("titre_manuel").disabled="";  
	document.getElementById("classe_manuel").disabled="";
	document.getElementById("matiere_manuel").disabled="";  
	document.getElementById("editeur_manuel").disabled="";
	document.getElementById("date_edition_manuel").disabled="";  
	document.getElementById("tarif_neuf_manuel").disabled="";
	document.getElementById("liste_manuel").disabled="";
	
	// Boutons
	document.getElementById("btnCh").disabled="disabled";        document.getElementById("btnNCh").disabled="disabled";
	document.getElementById("btnNouvelle").disabled="disabled";  document.getElementById("btnValider").disabled="";
	document.getElementById("btnModifier").disabled="disabled";  document.getElementById("btnAnnuler").disabled="";	
} 

function annulerFormulaire() {
	window.location.reload();
}