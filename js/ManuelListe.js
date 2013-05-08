// JavaScript Document

messageObj = new DHTML_modalMessage();	 
messageObj.setShadowOffset(10);	 
		
function displayMessageListe(url){
    
    messageObj = new DHTML_modalMessage();	 
messageObj.setShadowOffset(10);	
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(300,150);
	messageObj.setShadowDivVisible(true); 
	messageObj.display();
}

function closeMessage()	{
	messageObj.close();	
}
	
function soulignerRow(elem, laClass){
	elem.className=laClass; 
}


function AfficherFormulaireListe()	{	
	
		var resp = "";
		resp += "<div class='liste' style='padding:10px; text-align:left;'>";
		resp += "<div align='left'>";
		resp += "	<h3>Cr&eacute;ation d'une nouvelle liste</h3>";		
		resp += "</div>";	
		resp += "<div align='left' style='margin:0px 5px 0px 5px; padding:10px; background:#F9F9F9;'>";		
		resp += '<form id="frmListe" name="frmListe" method="POST" action="/ScolBoursePHP/index.php/Manuel/creerliste">';
resp += '<table width="100%" border="0" cellspacing="1px" style="padding:5px">';
	resp += '<tr>';
		resp += '<td>';
			resp += '<table border="0" cellspacing="0" cellpadding="0">';
				resp += '<tr>';
					resp += '<td width="45%">Nom de la liste:</td>';
					resp += '<td width="55%" align="left">';
						resp += '<input name="libelle_liste" type="text" id="libelle_liste" size="20"/>';
					resp += '</td>';
				resp += '</tr>';
			resp += '</table>';
		resp += '</td>';
	resp += '</tr>';
	resp += '<tr>';
		resp += '<td>';
			resp += '<table border="0" cellspacing="0" cellpadding="0">';
				resp += '<tr>';
					resp += '<td width="45%">Classe concern&eacute;e:</td>';
					resp += '<td width="55%" align="left">';
						resp += '<input name="classe_liste" type="text" id="classe_liste" size="20" />';
					resp += '</td>';
				resp += '</tr>';
			resp += '</table>';
		resp += '</td>';
	resp += '</tr>';
resp += '</table>';
resp += '<table width="100%" border="0" cellspacing="3px" style="padding:10px">';
	resp += '<tr>';
		resp += '<td width="50%" align="center">';
			resp += '<input name="btnValider"  type="submit" id="btnValider"  value="Valider"/>';
		resp += '</td>';
		resp += '<td width="50%" align="center">';
			resp += '<input name="btnAnnuler"  type="button" id="btnAnnuler"  value="Annuler" onclick="closeMessage(); return false;"/>';
		resp += '</td>';
	resp += '</tr>';
resp += '</table>';
resp += '</form>';
		displayMessage(resp,500,250);						
	   
}
