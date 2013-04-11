// JavaScript Document

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

/** Message dialog **/
function displayMessage(html, width, heigth){			
	 
	var content = "";	
	content += "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";	
	content += "<html xmlns='http://www.w3.org/1999/xhtml'>";
	content += "<head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' /></head>";	
	content += "<body>";
	content += html;
	content += "<body></html>";	
	
	messageObj.setSource(false);
	messageObj.setHtmlContent(content);	
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

function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 


function ouvrircredit(){
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();		
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 						
	var url = "/ScolBoursePHP/credits.php";  		 		
	xmlHttp.onreadystatechange=credits;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function credits() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var msg = "";
		msg += "<div class='liste' style='padding:10px; text-align:left;'>";
		msg += "<div align='left'>";
		msg += "	<h3>ScolBourse: credits</h3>";		
		msg += "</div>";	
		msg += "<div align='left'>";
		msg += xmlHttp.responseText;
		msg += "</div><br/>";	
		msg += "<div align='center'>";				
		msg += " <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
		msg += "</div>";	
		msg += "</div>";	
		displayMessage(msg,570,448);							
	} 
}

function ouvrirpdf(file){
	window.open(file,"aide");
}