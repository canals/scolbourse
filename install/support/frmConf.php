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
				ScolBourse - Outil d'installation (Recapitulatif)
			</h1>			
			<!-- Afficher le contenu //-->
			<div id="contenu" align="center">
				<form name="frmConf" id="frmConf" method="post" enctype="multipart/form-data" action="#">
					<table style="font-size:95%;">
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
                                                    <td colspan="4"> <?php echo ((isset($ERROR_MSG)) ? $ERROR_MSG : 'yo'); ?></td>				
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="background-color:#6F6F6F; color:#FFFFFF; padding:3px;">
								1) Configuration de l'application							</td>							 
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>							
						<tr>
							<td>&nbsp;</td>
							<td>Repertoire d'installation:</td>
							<td> <?php echo $repInstall; ?>	</td>
							<td style="font-size:90%; font-style:italic; color:#003333">Racine de documents du Serveur Web.<br/>ex: /opt/apache/htdocs</td>
						</tr>																						
						<tr>
						  <td>&nbsp;</td>
						  <td>Nom ou @Ip du Serveur Web:</td>
						  <td><input type="text" name="serverWeb" id="serverWeb" value="<?php echo $serverWeb;?>" size="33"/>                          </td>
						  <td style="font-size:90%; font-style:italic; color:#003333">Nom de domaine &agrave; utiliser par l'application.<br/>
						    ex: localhost, www.scolbourse.fr </td>
					  </tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>Numero de port du Serveur Web:</td>
						  <td><input type="text" name="portWeb" id="portWeb" value="<?php echo $portWeb;?>" size="33"/>
                          </td>
						  <td style="font-size:90%; font-style:italic; color:#003333">Le numero de Port du serveur web.<br/>
					      ex: 80, 8080, 8088 </td>
					  </tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>	
						<tr>
							<td>&nbsp;</td>
							<td colspan="2" style="background-color:#6F6F6F; color:#FFFFFF; padding:3px;">
								2) Configuration de la base de donn&eacute;es							</td>							 
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>							
						<tr>
							<td>&nbsp;</td>
							<td>type de SGBD:</td>
							<td>
								<input type="text" name="dbtype" id="dbtype" value="<?php echo $dbtype;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">mysql, postgres, oracle ...</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Nom ou @Ip du Serveur de BD:</td>
							<td>
								<input type="text" name="host" id="host" value="<?php echo $host;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">ex: localhost, 127.0.0.1, sql.scolbourse.fr</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Numero de port SGBD:</td>
							<td>
								<input type="text" name="port" id="port" value="<?php echo $port;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">ex: 3306</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Nom base de donn&eacute;es:</td>
							<td>
								<input type="text" name="dbname" id="dbname" value="<?php echo $dbname;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">ex: scolbourse</td>
						</tr>	
						<tr>
							<td>&nbsp;</td>
							<td>User:</td>
							<td>
								<input type="text" name="user" id="user" value="<?php echo $user;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">ex: "root"</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Mot de passe:</td>
							<td>
								<input type="password" name="pass" id="pass" value="<?php echo $pass;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>Creer les tables et initialiser les donn&eacute;es</td>
							<td><input type="checkbox" name="creatable" value="checked" <?php echo ($creatable?"checked":"");?></td>
							<td style="font-size:90%; font-style:italic; color:#003333">ne pas coccher pour installer sur <br/> une base existante</td>
						</tr>
                                                <tr>
							<td>&nbsp;</td>
							<td colspan="2" style="background-color:#6F6F6F; color:#FFFFFF; padding:3px;">
								3) Administrateur de l'application							</td>							 
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
                                                <tr>
							<td>&nbsp;</td>
							<td>administrateur:</td>
							<td>
								<input type="text" name="admin" id="admin" value="<?php echo $admin;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">ex: "root"</td>
						</tr>						
						<tr>
							<td>&nbsp;</td>
							<td>Mot de passe:</td>
							<td>
								<input type="password" name="adpass" id="adpass" value="<?php echo $adpass;?>" size="33"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
                                            
                                            
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>
					
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">
								<input type="submit" id="submit" name="frmConf_submit" value="lancer l'installation"/>							</td>
							<td style="font-size:90%; font-style:italic; color:#003333">&nbsp;</td>
						</tr>											
					</table>
 				</form>					
				<br/><br/>									
		</div>
		<!-- fin du corp //-->
		
		<!-- pie de page //-->
		<div id="footer">
			<span id="footTime" class="footTime"></span>
			<strong>&copy;2007-2008.</strong> <i>IUT Nancy2 - Charlemagne</i> &nbsp;&nbsp;	&middot;  
		</div>
		<!-- fin pie //-->
		
	</div>
	<!-- fin holder //-->
</body>
</html>
