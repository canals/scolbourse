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
		displayMessage(resp,253,120);						
	} else {
		var messageContent = ""; 
		messageContent += "<div>"; 
		messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
		messageContent += "	  <div align='center'>Patientez pendant la g&eacute;n&eacute;ration du rapport !</div><br/>";
		messageContent += "</div><br/>";					
		displayMessage(messageContent,200,100);
	}
}
	
function Chercher(radio) {		
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	for(var i = 0;i<radio.length;i++){
			if(radio[i].checked){
				id = radio[i].value;
				var url;
				switch(id){
					case 'cheque'             : url = "/ScolBoursePHP/index.php/Rapport/cheque"; break;
					case 'dossier_non_soldes' : url = "/ScolBoursePHP/index.php/Rapport/dossier_non_soldes"; break;
					case 'enveloppe_paiement' : url = "/ScolBoursePHP/index.php/Rapport/enveloppe_paiement"; break;
					case 'facture_achat'      : url = "/ScolBoursePHP/index.php/Rapport/facture_achat"; break;
					case 'liste_manuel'       : url = "/ScolBoursePHP/index.php/Rapport/liste_manuel"; break;
					case 'recepisse_depot'    : url = "/ScolBoursePHP/index.php/Rapport/recepisse_depot"; break;
					case 'retour_invendus'    : url = "/ScolBoursePHP/index.php/Rapport/retour_invendus"; break;
					case 'invendus'           : url = "/ScolBoursePHP/index.php/Rapport/invendus"; break;
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

