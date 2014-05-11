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
		displayMessage(resp,230,150);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Veuillez patienter pendant la gestion de la bourse !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}
	
function Ouvrir() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/ouvrir";  	
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function Fermer() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/fermer";  	
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function Structure() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/structure";  	
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function Donnees() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/donnees";  	
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function donneesSauvegarde() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/donneesSauvegarde";  	
		 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function exportDonnees() {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	var url = "/ScolBoursePHP/index.php/Bourse/exportDonnees";  	
		 
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

