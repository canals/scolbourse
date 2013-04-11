// Ajax Suggest .. www.w3schools.com

var idExem;

function SupprimerAchat(idExemplaire) {
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert ("Navigateur non compatible avec AJAX!");
        return;
    } 						
    idExem = idExemplaire;
    var url = "/ScolBoursePHP/index.php/Exemplaire/voirDetail/" + idExem;  		 
		
    xmlHttp.onreadystatechange=consulterExemplaireAchat;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
    
    //$.getJSON(url, function(data) {
    //    consulterExemplaireAchat(data);
    //});
    //$.getJSON(url, consulterExemplaireAchat );
    
    
}
	
function consulterExemplaireAchat()	{	
    if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){
	var data = $.parseJSON(xmlHttp.responseText);
        var resp = "";
        resp += "<div class='liste' style='padding:10px; text-align:left;'>";
        resp += "<div align='left'>";
        resp += "	<h3>ACHAT: Rendre exemplaire</h3>";		
        resp += "</div>";	
        resp += "	<br/><div>Attention, supprimer l'exemplaire du dossier achat ?</div><br/>";
        resp += "<div align='left' style='margin:0px 5px 0px 5px; padding:10px; background:#F9F9F9;'>";		
        //resp += tata ;		
        resp += "Code exemplaire: <i>"+ data.code+"</i><BR/>" ;
	resp += "Titre: <i><strong>"+data.titre+"</strong></i><BR/>" ;
	resp += "Mati&egrave;re: <i>"+data.matiere+"</i><BR/>" ;
	resp += "tarif: <i>"+data.tarif+"</i><BR/>" ;
      
        resp += "</div>";	
        resp += "<div align='center'>";
        resp += " <h3>&nbsp;</h3>";		
        resp += "	  <a href='' onclick='closeMessage(); return false;'><font color='#131313'>Annuler</font></a>&nbsp;&nbsp;";
        resp += "	  <a href='' onclick='confirmSupprimerAchat(" + idExem + "); return false;'><font color='#E35F06'>supprimer</font></a>";
        resp += "</div>";	
        resp += "</div>";				
        displayMessage(resp,500,250);	
} else {
    var messageContent = ""; 
        messageContent += "<div>"; 
        messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
        messageContent += "	  <div align='center'>patienter, chargement des donn&eacute;es !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
}
}   

function confirmSupprimerAchat(idExemplaire)	{
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert ("navigateur non compatible avec AJAX!");
        return;
    } 						
    var url = "/ScolBoursePHP/index.php/Achat/supprimerExemplaire/" + idExemplaire;  		 
		
    xmlHttp.onreadystatechange=supprimerExemplaireAchat;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);	
}

function supprimerExemplaireAchat() { 	
    if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
        var msg = "";
        msg += "<div class='liste' style='padding:10px; text-align:left;'>";
        msg += "<div align='left'>";
        msg += "	<h3>ACHAT: Rendre exemplaire</h3>";		
        msg += "</div>";	
        msg += "<div align='left'>";
        msg += xmlHttp.responseText;
        msg += "</div>";	
        msg += "<div align='center'>";
        msg += " <h3>&nbsp;</h3>";		
			
        msg += " <a href='' onclick='window.location.reload(true); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
        msg += "</div>";	
        msg += "</div>";	
        displayMessage(msg,290,123);							
    } else {
        var messageContent = ""; 
        messageContent += "<div>"; 
        messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
        messageContent += "	  <div align='center'>patienter :  action en cours !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
    }
}

function acheterExemplaire(){
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert ("navigateur non compatible avec AJAX!");
        return;
    } 	
	
    var numDossi = document.getElementById("numDossierAchat");
    numDossi = numDossi.value;
    var codeExem = document.getElementById("codeExemplaireA");
    codeExem = codeExem.value;
		
    if((numDossi=="")||(codeExem=="")) {
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
    }	
    
    $.getJSON(url, function(data) {
        retourAjout(data,'exemplaire');
    });
    
    
    var messageContent = ""; 
        messageContent += "<div>"; 
        messageContent += "	  <h3 style='text-decoration:blink;'>ACHAT: Acheter Exemplaire...</h3><br/>";
        messageContent += "	  <div align='center'>ajout Exemplaire</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
}

/*
function ajouterAchat() { 	
    if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 										
        var resp = xmlHttp.responseText;
        if(resp!="OK") {
            var msg = "";
            msg += "<div class='liste' style='padding:10px; text-align:left;'>";
            msg += "<div align='left'>";
            msg += "	<h3>ACHAT: Acheter exemplaire</h3>";		
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
        messageContent += "	  <h3 style='text-decoration:blink;'>ACHAT: Acheter Exemplaire...</h3><br/>";
        messageContent += "	  <div align='center'>Veuillez patienter pendant la mise &agrave; jour des donn&eacute;es !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
    }
}
*/

function ajouterPaiment(){
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert ("navigateur non compatible avec AJAX!");
        return;
    } 	
	
    var numDossi = document.getElementById("numDossierAchat");
    numDossi = numDossi.value;
    var modePaiment = document.getElementById("modePaiment");
    modePaiment = modePaiment.value;
    var montPai = document.getElementById("montPai");
    montPai = montPai.value;
    var cheque = document.getElementById("cheque");
    cheque = cheque.value;
		
    if((numDossi=="")||(modePaiment=="")||(montPai=="")) {
        var messageContent = "<div>"; 
        messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: Champs obligatoires</h3><br/>";
        messageContent += "	<div>Vous devez d'abord introduire toutes les donn&eacute;es demand&eacute;es...</div><br/>";
        messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
        messageContent += "	<font color='#131313'>Fermer</font>";
        messageContent += "	</a></div>";
        messageContent += "</div>";					
        displayMessage(messageContent,255,110);
        return;					
    } else {			
        if((isNaN(numDossi))||(isNaN(montPai))||(parseFloat(montPai)<=0)) {
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
            var url = "/ScolBoursePHP/index.php/Achat/ajouterRegle/" + numDossi + "/" + modePaiment + "/" + montPai + "/" + cheque ;  			 		
        }	
    }	
    
    $.getJSON(url,function(data) {
        retourAjout(data, 'paiement');
    });
    
    /*
    //xmlHttp.onreadystatechange=ajouterRegle;
    //xmlHttp.open("GET",url,true);
    //xmlHttp.send(null);	
    */
   
   
   var messageContent = ""; 
        messageContent += "<div>"; 
        messageContent += "	  <h3 style='text-decoration:blink;'>ACHAT: Ajouter Paiment...</h3><br/>";
        messageContent += "	  <div align='center'>Veuillez patienter pendant la mise &agrave; jour des donn&eacute;es !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
}

function retourAjout(data, where) {
    //alert(data.message);
    if (data.message == 'OK') {
        window.location.reload(true);
    } else {
        var msg = "";
            msg += "<div class='liste' style='padding:10px; text-align:left;'>";
            msg += "<div align='left'>";
            msg += "	<h3>ACHAT: Ajouter "+where+" </h3>";
            msg += "	<p> probleme </p>";
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
        
    }
}

/*
function ajouterRegle() { 	
    if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 										
        var resp = xmlHttp.responseText;
        if(resp!="") {
            var msg = "";
            msg += "<div class='liste' style='padding:10px; text-align:left;'>";
            msg += "<div align='left'>";
            msg += "	<h3>ACHAT: Ajouter Paiment</h3>";
            msg += "	<p> probleme </p>";
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
        messageContent += "	  <h3 style='text-decoration:blink;'>ACHAT: Ajouter Paiment...</h3><br/>";
        messageContent += "	  <div align='center'>Veuillez patienter pendant la mise &agrave; jour des donn&eacute;es !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
    }
}
*/




function SupprimerRegle(idRegle)	{
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert (" navigateur non compatible  AJAX!");
        return;
    } 						
    var url = "/ScolBoursePHP/index.php/Achat/supprimerRegle/" + idRegle;  		 
		
    //xmlHttp.onreadystatechange=confirmSupprimerRegle;
    //xmlHttp.open("GET",url,true);
    //xmlHttp.send(null);	
    $.getJSON(url,function(data) {
        retourSupp(data, 'reglement');
    });
    
    var    messageContent = "<div>"; 
        messageContent += "	  <h3 style='text-decoration:blink;'>En charge...</h3><br/>";
        messageContent += "	  <div align='center'>Veuillez patienter pendant la charge des donn&eacute;es !</div><br/>";
        messageContent += "</div><br/>";					
        displayMessage(messageContent,200,100);
}

function retourSupp(data,where) {
    if (data.message == 'OK') {
        window.location.reload(true);
    } else {
        var msg = "";
            msg += "<div class='liste' style='padding:10px; text-align:left;'>";
            msg += "<div align='left'>";
            msg += "	<h3>ACHAT: spprimer "+where+" </h3>";
            msg += "	<p> probleme </p>";
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
        
    }
    
}
/*
function confirmSupprimerRegle() { 	
    if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200)){ 		
        var msg = "";
        msg += "<div class='liste' style='padding:10px; text-align:left;'>";
        msg += "<div align='left'>";
        msg += "	<h3>ACHAT: Supprimer Regle</h3>";		
        msg += "</div>";	
        msg += "<div align='left'>";
        msg += xmlHttp.responseText;
        msg += "</div>";	
        msg += "<div align='center'>";
        msg += " <h3>&nbsp;</h3>";			 
        msg += " <a href='' onclick='window.location.reload(true); return false;'><font color='#131313'>Fermer</font></a>&nbsp;&nbsp;";					
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
*/
function impprimerFacture(numFamille) {
    // Instanciation du Objet XMLHttpRequest 
    xmlHttp = getXMLHttpRequestObject();		
    if (xmlHttp==null) {
        alert ("Votre navigateur n�est pas compatible avec AJAX!");
        return;
    } 		
	
    var url = "/ScolBoursePHP/index.php/Rapport/facture_achat_particulier/" + numFamille;
				
    xmlHttp.onreadystatechange=facture;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);	
}

function facture() { 	
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
