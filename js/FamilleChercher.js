// Ajax Suggest .. www.w3schools.com

var idFam = "";

function retourRecherche(data_html) { 	
				
		displayMessage(data_html,800,350);						
	
}
		
function rechercher() {		
	
	var nomFam = document.getElementById("nomCh"); nomFam = nomFam.value;
	var telFam = document.getElementById("telCh"); telFam = telFam.value;
	var numFam = document.getElementById("numCh"); numFam = numFam.value;
	var numExe = document.getElementById("exeCh"); numExe = numExe.value;
	 
	if((numExe=="")&&(nomFam=="")&&(telFam=="")&&(numFam=="")) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: critere de recherche</h3><br/>";
		messageContent += "	<div>Erreur : critere de recherche manquant</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;					
	} 
	if((numExe.length<2)&&(nomFam.length<2)&&(telFam.length<2)&&(numFam.length<2)) {
		var messageContent = "<div>"; 
		messageContent += "	<h3 style='text-decoration:blink;'>ERREUR: critere de recherche</h3><br/>";
		messageContent += "	<div>La valeur du critere doit avoir plus d'un caract&eagrave;re...</div><br/>";
		messageContent += "	<div align='center'><a href='' onclick='closeMessage(); return false;'>";
		messageContent += "	<font color='#131313'>Fermer</font>";
		messageContent += "	</a></div>";
		messageContent += "</div>";					
		displayMessage(messageContent,255,110);
		return;					
	} 
	var url = "/ScolBoursePHP/index.php/";  	
	if(numFam!="")      url += "Famille/listeParDossier/" + numFam;
        else if (nomFam!="")url += "Famille/listeParNom/" + nomFam;
	else if (numExe!="")url += "Famille/listeParExemplaire/" + numExe;	
	else if(telFam!="") url += "Famille/listeParTel/" + telFam;
		
   $.get(url, retourRecherche, "html");
				

}

function nouvelleRecherche() {
	window.location.replace("/ScolBoursePHP/index.php");		
}

function selectFamille(id) {
	idFam = id;
	window.location.replace("/ScolBoursePHP/index.php/" + idFam);
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
	document.getElementById("mail_famille").disabled=""
	// Boutons
	document.getElementById("btnCh").disabled="disabled";        document.getElementById("btnNCh").disabled="disabled";
	document.getElementById("btnNouvelle").disabled="disabled";  document.getElementById("btnValider").disabled="";
	document.getElementById("btnModifier").disabled="disabled";  document.getElementById("btnAnnuler").disabled="";
} 

function annulerFormulaireFamille() {
	window.location.reload();
}
