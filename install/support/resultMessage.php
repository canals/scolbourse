<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>ScolBourse - Outil d'installation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	<!-- Feuilles des Style CSS //-->		
		<link type="text/css" rel="stylesheet" href="./support/main.css" />
	<!-- fin des feuilles des Style CSS //-->

	<!-- Libraries JavaScript //-->
		<script type="text/javascript" language="javascript" src="./support/currentTime.js" runat="server"></script>								
	<!-- fin de libraries JavaScript //-->
	
</head>

<body onload="setInterval('getCurrentTime()', 1000);">

	<!-- Contains the site in a table like thing //-->
	<div id="holder">	
		<!-- header //-->
		<div id="header">
			<div id="logo"></div> 
		</div>
		<!-- fin header //-->
		
		<!-- Menu //-->
		<div id="menu">
			&nbsp;
		</div>
		<!-- fin menu //-->
		
		<!-- pointless bars and should not really be in 2 div"s-->
		<div style="border: 0px; border-bottom: 1px solid #ccc; height: 16px; 
		background-image: url(./support/images/shad2.png);"></div>
		<div style="border: 0px; border-bottom: 1px solid #ccc; height: 16px; 
		background-image: url(./support/images/shad3.png);"></div>
		<!-- fin pointless bar-->
		
		<!-- content -->		
		<div id="corp">				
			<h1>
				<!-- Identification de l"utilisateur //-->
				&nbsp;						
				<!-- Afficher le titre de la page //-->
				ScolBourse - Installation : Recapitulatif
			</h1>			
			<!-- Afficher le contenu //-->
			<div id="contenu" align="center">
				<form name="frmConf" id="frmConf" method="post" enctype="multipart/form-data" action="#">
					<table style="font-size:95%;">
						<tr>
							<td width="2">&nbsp;</td>
							<td width="177">&nbsp;</td>
							<td width="226">&nbsp;</td>
							<td width="14">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4"> <?php echo $ERROR_MSG; ?></td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="background-color:#6F6F6F; color:#FFFFFF; padding:3px; font-size:medium; font-weight:bold;"><i>INSTALLATION de l'application ScolBoursePHP COMPLETE</i></td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2"><strong></strong>Details de l'installation: </strong></td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>							
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>Chemin d'installation: </td>
						  <td colspan="2"><strong><?=$repDestin?></strong></td>
						  
					  </tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>Nom ou @Ip du Serveur Web: </td>
						  <td colspan="2"><strong>
							<?=$serverWeb?>
							</strong></td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>Numero de port du Serveur Web: </td>
						  <td><strong>
							<?=$portWeb?>
							</strong></td>
						  <td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
					  </tr>
						<tr>
							<td>&nbsp;</td>
							<td>SGBD:</td>
							<td><strong><?=$dbtype?></strong></td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Nom ou @Ip du Serveur de BD:</td>
							<td colspan="2"><strong><?=$host?></strong></td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Numero de port:</td>
							<td><strong><?=$port?></strong></td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Nom base de données:</td>
							<td colspan="2"><strong><?=$dbname?></strong></td>
						</tr>	
						<tr>
							<td>&nbsp;</td>
							<td>User:</td>
							<td><strong><?=$user?></strong></td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="4"><em><strong>Note</strong>:  fichier de configuration de l'application : <strong><?=( "config". DIRECTORY_SEPARATOR)?>db_config.ini</strong></td>
						</tr>
					
						<tr>
						  <td>&nbsp;</td>
						  <td colspan="2">&nbsp;</td>
						  <td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
					  </tr>
						<tr>
							<td colspan="4">Pour lancer maintenant l'application ScolBourse :<a href="<?=$adresseWebApp?>"><strong><?=$adresseWebApp?></strong></a></td>
						</tr>											
					</table>
				</form>	
				<br/><br/>									
		</div>
		<!-- fin du corp //-->
		
		<!-- pie de page //-->
		<div id="footer">
			<span id="footTime" class="footTime"></span>
			<strong>&copy;2007-2008.</strong> <i>IUT Nancy-Charlemagne</i> &nbsp;&nbsp;	&middot;  
		</div>
		<!-- fin pie //-->
		
	</div>
	<!-- fin holder //-->
</body>
</html>
