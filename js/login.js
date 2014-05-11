// Ajax Suggest .. www.w3schools.com
//

var xmlHttp;

function logIn() {
	// Instanciation du Objet XMLHttpRequest 
	xmlHttp = getXMLHttpRequestObject();
	
	if (xmlHttp==null) {
		alert ("Votre navigateur n’est pas compatible avec AJAX!");
		return;
	} 
	
	document.getElementById("msgErreur").innerHTML="";
		
	var url = "/ScolBoursePHP/login.php?login=" + document.getElementById("login").value;
	url += "&passw=" + document.getElementById("passw").value;
	
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() { 	
	if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
		var resp = xmlHttp.responseText;		
		if(resp != 1) {	
			document.getElementById("msgErreur").innerHTML=resp;
		} else {
			window.location.replace("/ScolBoursePHP/index.php");
		}
	}
}

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


