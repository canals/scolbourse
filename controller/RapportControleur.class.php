<?php
session_start();
/**
* controller.RapportControleur.class.php : classe qui represente le controleur des Rapports de l'application
*
* @author JARNAUX Noemie
* @author COURTOIS Gillaume
* @author RIVAS Ronel
* @author SUSTAITA Luis
* @author Gérôme CANALS
*
* @package controller
**/

class RapportControleur extends AbstractControleur {

	public static $MNU_ID = "mnuRapport";
	
	public function __construct(){
		// Pour gérer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {			
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;				
		$view = new RapportView($rapport,"detail");
		$view->display ();				
	}
	
	public function listeAction() {	
		$view = new RapportView($rapports,"liste");
		$view->display ();	
	}
	
	public function defaultAction() {			
		switch ($this->action) {		
			// Operations
			case "cheque"                      : { $this->generer_cheque() ; break; }		
			case "dossier_non_soldes"          : { $this->generer_dossier_non_soldes() ; break; }
			case "enveloppe_paiement"          : { $this->generer_enveloppe_paiement() ; break; }			
			case "facture_achat"               : { $this->generer_facture_achat() ; break; }	
			case "facture_achat_particulier"   : { $this->generer_facture_achat_particulier() ; break; }	
			case "invendus"                    : { $this->generer_invendus() ; break; }				
			case "liste_manuel"                : { $this->generer_liste_manuel() ; break; }			
			case "recepisse_depot"             : { $this->generer_recepisse_depot() ; break; }	
			case "recepisse_depot_particulier" : { $this->generer_recepisse_depot_particulier() ; break; }		
			case "retour_invendus"             : { $this->generer_retour_invendus() ; break; }
			case "retour_invendus_particulier" : { $this->generer_retour_invendus_particulier() ; break; }	
			case "voirPDF"                     : { $this->voirPDF() ; break; }		
			
			default         : { $this->mnuAction() ; }			
		} 
	}	
		
	public function generer_cheque(){
		$pdf=new FPDF('L','mm','A5');
		$tableaulisteDepot= DossierDeDepot::findAllTrie();
		$date = date("d-m-Y");
		for($i=0;$i< sizeof($tableaulisteDepot);$i++){ //boucle sur les personnes
			$pdf->SetTopMargin(2);
			$pdf->AddPage();	
			$famille=Famille::findById($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$dossier=DossiersMontant::findById($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$pdf->SetFont('Arial','B',5);
			$pdf->Cell(200,2,$dossier->getAttr('montant').'€',0,1,'C');
			$pdf->SetFont('Arial','',5);
			$pdf->Cell(225,5,'Bourse aux livres - dossier :'.$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,1,'C');
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(240,5);
			$pdf->Cell(30,10,$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,0,'C');
			$pdf->SetXY(100,25);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(30,10,'*** '.$dossier->getAttr('montant').'€ ***',0,0,'C');
			$pdf->SetXY(20,30);
			$pdf->Cell(30,10,$famille->getAttr('nom_famille'),0,0,'C');
			$pdf->SetXY(150,30);
			$pdf->Cell(30,10,$dossier->getAttr('montant').'€',0,0,'C');
			$pdf->SetXY(150,33);
			$pdf->Cell(30,10,'Vandoeuvre',0,0,'C');
			$pdf->SetXY(150,36);
			$pdf->Cell(30,10,$date,0,0,'C');
		}
		$pdf->Output('./rapports/general/cheques.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";
		$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des ch&egrave;ques &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;.</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'.</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";
		
		$html .= "<br/><div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/cheques.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
		
	public function generer_enveloppe_paiement(){
		$pdf=new FPDF('L','mm','A5');
		$pdf->SetDisplayMode('real');
		$tableaulisteDepot= DossierDeDepot::findAllTrie();
		for($i=0;$i< sizeof($tableaulisteDepot);$i++){ //boucle sur les personnes
			$pdf->AddPage();	
			$pdf->SetFont('Arial','B',14);
			$pdf->SetXY(45,10);
			$pdf->Cell(60,10,'Conseil Local FCPE - Lycée J. Callot Vandoeuvre',0,1,'C');
			$pdf->SetFont('Arial','',12);
			$pdf->SetXY(45,15);
			$pdf->Cell(30,10,'Bourse aux livres '.date("Y"),0,0,'C');
			$pdf->SetXY(45,19);
			$pdf->Cell(30,10,'N° de dossier : ',0,0,'C');
			$pdf->SetXY(67,19);
			$pdf->Cell(30,10,$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,0,'C');
			$famille=Famille::findById($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$pdf->SetXY(100,60);
			$pdf->Cell(30,10,'Famille '.$famille->getAttr('nom_famille'),0,0,'C');
			$pdf->SetXY(100,67);
			$pdf->Cell(30,10,$famille->getAttr('adresse1_famille'),0,0,'C');
			$pdf->SetXY(100,74);
			$pdf->Cell(30,10,$famille->getAttr('code_postal_famille')."       ".$famille->getAttr('ville_famille'),0,0,'C');
		}
		$pdf->Output('./rapports/general/enveloppes_paiement.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des enveloppes &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/enveloppes_paiement.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	
	public function generer_dossier_non_soldes(){
		$tableaulisteAchat= DossierDAchat::findAllTrie();
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetCreator('ScolBourse');
		$pdf->SetDisplayMode('real');
		$pdf->AddPage();		
		$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
		$pdf->SetFont('Arial','B',18);
		$pdf->Cell(140,10,'Bourse aux Livres FCPE '.date("Y"),0,1,'C');
		$pdf->SetFont('Arial','',14);
		$pdf->SetXY(85,20);
		$pdf->Cell(30,10,'Dossiers non régularisés au :',0,0,'C');
		$date = date("d-m-Y");
		$pdf->SetXY(140,20);
		$pdf->Cell(30,10,$date,0,0,'C');
		$pdf->SetXY(10,35);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,10,'N° Dossier',0,0,'C');
		$pdf->SetXY(60,35);
		$pdf->Cell(25,10,'Nom -Prénom',0,0,'C');
		$pdf->SetXY(120,35);
		$pdf->Cell(30,10,'Téléphone',0,0,'C');
		$pdf->SetXY(170,35);
		$pdf->Cell(30,10,'Montant',0,0,'C');
		$positionverticale=42;
		$pdf->SetFont('Arial','',9);
		for($i=0;$i< sizeof($tableaulisteAchat);$i++){ //boucle sur les personnes (dossier dachat)
			if ($tableaulisteAchat[$i]->getAttr('etat_dossier_achat')==2){ // si le dossier n'est pas clos
				$famille=Famille::findById($tableaulisteAchat[$i]->getAttr('num_dossier_achat'));// on recupère la famille correspondante au dossier
				$pdf->Line(10,$positionverticale,200,$positionverticale);
				$positionverticale=$positionverticale+5;
				$pdf->SetXY(20,$positionverticale);
				$pdf->Cell(1,1,$tableaulisteAchat[$i]->getAttr('num_dossier_achat'),0,0,'C');
				$pdf->SetXY(70,$positionverticale);
				$pdf->Cell(1,1,$famille->getAttr('nom_famille')."   ".$famille->getAttr('prenom_famille'),0,0,'C');
				$pdf->SetXY(126,$positionverticale);
				$pdf->Cell(20,1,$famille->getAttr('num_tel_famille'),0,0,'C');
				$prix=DossiersMontant::findById($tableaulisteAchat[$i]->getAttr('num_dossier_achat'));
				$pdf->SetXY(182,$positionverticale);
				if ($prix!=null){
					$pdf->Cell(1,1,$prix->getAttr('montant'),0,0,'C');
				}
				$positionverticale=$positionverticale+7;
				$pdf->SetXY(40,$positionverticale);
				$pdf->Cell(1,1,$famille->getAttr('adresse1_famille'),0,0,'C');
				$pdf->SetXY(90,$positionverticale);
				$pdf->Cell(1,1,$famille->getAttr('code_postal_famille'),0,0,'C');
				$pdf->SetXY(130,$positionverticale);
				$pdf->Cell(1,1,$famille->getAttr('ville_famille'),0,0,'C');
				 	
				$positionverticale=$positionverticale+5;
				if($positionverticale>265){
					$pdf->AddPage();	
					$positionverticale=22;
				}
			}
		}
		$pdf->Output('./rapports/general/dossiers_non_soldes.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des dossiers non sold&eacute;s &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/dossiers_non_soldes.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
        
        private function creer_facture_particulier($famille, $dossier) {
            include 'config/config.edit.php';
            $exemplaires = $dossier->getAttr("exemplaires");					
            $pdf=new FPDF('P','mm','A4');
            $pdf->SetCreator('ScolBourse');
            $pdf->SetDisplayMode('real');
            $pdf->AddPage();
				$pdf->SetFont('Arial','B',17);
				$pdf->Cell(200,5,'BOURSE AUX LIVRES '. $annee_bourse ,0,1,'C');
				$pdf->SetFont('Arial','',12);
				//$pdf->Cell(230,11,'Lycée Jacques Callot - Vandoeuvre',0,1,'C');
				$pdf->Cell(230,11,$titre_bourse,0,1,'C');
				$pdf->SetFont('Arial','B',18);
				$pdf->Cell(210,8,'- Facture d\'achat -',0,1,'C');
				$pdf->SetXY(500,50);
				//$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
				$pdf->Image($logo ,10,8,25,25);
				$pdf->SetXY(10,40);
				$pdf->SetFont('Arial','',11);
				$pdf->Rect(10,38,185,40);
				$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
				$date = date("d-m-Y");
				$pdf->SetXY(40,40);
				$pdf->Cell(25,0,$dossier->getAttr('num_dossier_achat'),0,1,'C');
				$pdf->SetXY(150,40);
				$pdf->Cell(40,0,$date,0,0,'C',0);
				$pdf->SetXY(40,40);
				$pdf->Cell(13,25,$famille->getAttr('nom_famille'),0,0,'C',0);
				$pdf->SetXY(72,40);
				$pdf->Cell(20,25,$famille->getAttr('prenom_famille'),0,0,'C',0);
				$pdf->SetXY(40,47);
				$pdf->Cell(20,25,$famille->getAttr('adresse1_famille'),0,0,'C',0);
				$pdf->SetXY(85,47);
				$pdf->Cell(20,25,$famille->getAttr('code_postal_famille'),0,0,'C',0);
				$pdf->SetXY(110,47);
				$pdf->Cell(20,25,$famille->getAttr('ville_famille'),0,0,'C',0);
				$pdf->SetXY(35,55);
				$pdf->Cell(35,25,$famille->getAttr('num_tel_famille'),0,0,'C',0);
				$placementvertical=85;
				$pdf->SetXY(40,$placementvertical);
				$pdf->SetFont('Arial','U',12);
				$pdf->Cell(10,0,'Récapitulatif des livres achetés :',0,0,'C',0);
				$pdf->SetFont('Arial','',8);
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,'Référence',0,0,'C',0);
				$pdf->SetXY(40,$placementvertical);
				$pdf->Cell(10,0,'Matière',0,0,'C',0);
				$pdf->SetXY(100,$placementvertical);
				$pdf->Cell(10,0,'Titre',0,0,'C',0);
				$pdf->SetXY(163,$placementvertical);
				$pdf->Cell(10,0,'Etat',0,0,'C',0);
				$pdf->SetXY(180,$placementvertical);
				$pdf->Cell(10,0,'Tarif',0,0,'C',0);
				$pdf->SetFont('Arial','',6);
				$nblivresachete=0;
				$couttotal=0;
		for($j=0;$j<sizeof($exemplaires);$j++){
					$nblivresachete=$nblivresachete+1;
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
					$pdf->SetXY(25,$placementvertical);
					$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
					$manuel= Manuel::findById($code_manuel);
					$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
					$pdf->SetXY(75,$placementvertical);	
					$titre=$manuel->getAttr('titre_manuel');
					if (strlen($titre)>40){
						$titre=substr($titre,0,40);
					}
					$pdf->Cell(80,0,$titre,0,0,'C',0);
					$pdf->SetXY(156,$placementvertical);
					$etat=$exemplaires[$j]->getAttr('code_etat');
					switch ($etat) {		
						case 1 : { 
						$pdf->Cell(25,0,'1',0,0,'C',0);
						break; 
						}
						case 2 : { 
						$pdf->Cell(25,0,'2',0,0,'C',0);
						break; 
						}		
						case 3 : { 
						$pdf->Cell(25,0,'3',0,0,'C',0); 
						break; 
						}		
						case 4 : { 
						$pdf->Cell(25,0,'4',0,0,'C',0);
						break; 
						}		
						default :{
						$pdf->Cell(25,0,'?',0,0,'C',0);
						break; 
						}	
                                        }
					$pdf->SetFont('Arial','',8);
					$pdf->SetXY(182,$placementvertical);
					$codemanuel=$exemplaires[$j]->getAttr('code_manuel');
					$etat=$exemplaires[$j]->getAttr('code_etat');
					$determine=Determine::findById($etat,$codemanuel);
					$pdf->Cell(10,0,$determine->getAttr('tarif')." €",0,0,'C',0);
					$pdf->SetFont('Arial','',6);
					$couttotal=$couttotal+$determine->getAttr('tarif');
				if ($placementvertical>230){
						$pdf->AddPage();
						$placementvertical=10;
					}
				}
				$pdf->SetFont('Arial','',9);
				$placementvertical=$placementvertical+7;
				$pdf->SetXY(170,$placementvertical);
				$pdf->Cell(10,0,'Total :'.$couttotal." €",0,0,'C',0);
				$placementvertical=$placementvertical+7;
				$pdf->SetXY(170,$placementvertical);
				$fraisdossier=$dossier->getAttr('frais_dossier_achat');
				$pdf->Cell(10,0,'Frais de dossier :'.$fraisdossier." €",0,0,'C',0);
				$placementvertical=$placementvertical+7;
				$pdf->SetXY(170,$placementvertical);
				$montantapayer=$couttotal+$fraisdossier;
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(10,0,'Total à payer :'.$montantapayer." €",0,0,'C',0);
				$placementvertical=$placementvertical+10;
				$pdf->SetXY(40,$placementvertical);
				$pdf->SetFont('Arial','U',12);
				$pdf->Cell(10,0,'Règlement :',0,0,'C',0);
				$regle=Regle::findByNumDossierAchat($dossier->getAttr('num_dossier_achat'));
				if ($regle!=null){
					$pdf->SetFont('Arial','',8);
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,'Mode',0,0,'C',0);
					$pdf->SetXY(40,$placementvertical);
					$pdf->Cell(10,0,'Date',0,0,'C',0);
					$pdf->SetXY(80,$placementvertical);
					$pdf->Cell(10,0,'Montant',0,0,'C',0);
					$pdf->SetFont('Arial','',8);
					$montantdejapaye=0;
					for($k=0;$k<sizeof($regle);$k++){
						$typereg=Reglement::findAll();
						$b=$regle[$k]->getAttr('code_reglement');
						for($l=0;$l<sizeof($typereg);$l++){
							$a=$typereg[$l]->getAttr('code_reglement');
							if ($a==$b){
								$mode=$typereg[$l]->getAttr('mode_reglement');
							}
							if ($placementvertical>230){
							$pdf->AddPage();
							$placementvertical=10;
							}
						}	
						$placementvertical=$placementvertical+8;
						$pdf->SetXY(10,$placementvertical);
						$pdf->Cell(10,0,$mode,0,0,'C',0);
						$pdf->SetXY(25,$placementvertical);
						$pdf->Cell(50,0,$regle[$k]->getAttr('datereg'),0,0,'C',0); 
						$pdf->SetXY(80,$placementvertical);
						$pdf->Cell(10,0,$regle[$k]->getAttr('montant'),0,0,'C',0); 
						$montantdejapaye=$montantdejapaye+$regle[$k]->getAttr('montant');
					}
					$pdf->SetXY(163,$placementvertical);
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(10,0,'Montant déja payé : '.$montantdejapaye.' €',0,0,'C',0);
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(163,$placementvertical);
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(10,0,'Restant à payer : '. round(($montantapayer-$montantdejapaye),2) .' €',0,0,'C',0);
				}else{
					$pdf->SetFont('Arial','',8);
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,'Aucun Reglement ',0,0,'C',0);
				
				}
		$pdf->SetFont('Arial','',6);
		$pdf->SetXY(10,265);
				//$pdf->Cell(0,0,'La bourse aux livres FCPE est organisée par des Parents d\'Elèves Bénévoles.Si vous constatez une erreur, merci de vous adresser aux organisateurs.',0,0,'C',0);
		$pdf->Cell(0,0,$pied,0,0,'C',0);
                $filename = 'facture_achat_particulier_famille_'.$dossier->getAttr('num_dossier_achat').'.pdf';
		$pdf->Output('./rapports/particuliers/'.$filename,'F');
                return $filename;
                
                }
        
        
	
	public function generer_facture_achat_particulier(){
		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;
		
                if ($oid ==0) {
                    $json= array("code"=>10);
                    echo json_encode($json);
                    return ;
                }
		
		$famille = Famille::findById($oid);		
		$dossier = $famille->getAttr("dossierDAchat");
                if (is_null($dossier)){
                    $json= array("code"=>11);
                    echo json_encode($json);
                    return ;
                }
                 /*
                 * Génération du document pdf
                 */
                $filename = $this->creer_facture_particulier($famille, $dossier);
                /*
                 * retour des données vers le serveur
                 */
                $href='/ScolBoursePHP/rapports/particuliers/'.$filename;
                 $json= array( "ref"=> $href, "code"=>0);
                 echo json_encode($json);
                 return ;
		 /*
				$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		if ($dossier!=null){
			$html .= "<tr>";
			$html .= "	<td  align='left'>Le rapport de la facture &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
			$html .= "</tr>";
		}else{
			$html .= "<tr>";
			$html .= "	<td  align='left'>Erreur lors de la création du rapport, la famille n'a pas de dossier !!</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		if ($dossier!=null){
			$html .= "<a href='/ScolBoursePHP/rapports/particuliers/facture_achat_particulier_famille_".$dossier->getAttr('num_dossier_achat').".pdf' target='_blank' onclick='window.location.reload(); return true;'>";
			$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		}
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
                  * 
                  */
	}
	
	public function generer_facture_achat(){
		$tableaulisteAchat= DossierDAchat::findAllTrie();
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetCreator('ScolBourse');
		$pdf->SetDisplayMode('real');
		for($i=0;$i< sizeof($tableaulisteAchat);$i++){ //boucle sur les personnes (dossier dachat)
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',17);
			$pdf->Cell(200,5,'BOURSE AUX LIVRES '.date("Y"),0,1,'C');
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(230,11,'Lycée Jacques Callot - Vandoeuvre',0,1,'C');
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(210,8,'- Facture d\'achat -',0,1,'C');
			$pdf->SetXY(500,50);
			$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
			$pdf->SetXY(10,40);
			$pdf->SetFont('Arial','',11);
			$pdf->Rect(10,38,185,40);
			$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
			$date = date("d-m-Y");
			$pdf->SetXY(40,40);
			$pdf->Cell(25,0,$tableaulisteAchat[$i]->getAttr('num_dossier_achat'),0,1,'C');
			$pdf->SetXY(150,40);
			$pdf->Cell(40,0,$date,0,0,'C',0);
			$pdf->SetXY(40,40);
			$famille= Famille::findByNumDossier($tableaulisteAchat[$i]->getAttr('num_dossier_achat'));
			$exemplaires= Exemplaire::findByNumDossierAchat($tableaulisteAchat[$i]->getAttr('num_dossier_achat'));
			$pdf->Cell(13,25,$famille[0]->getAttr('nom_famille'),0,0,'C',0);
			$pdf->SetXY(72,40);
			$pdf->Cell(20,25,$famille[0]->getAttr('prenom_famille'),0,0,'C',0);
			$pdf->SetXY(40,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('adresse1_famille'),0,0,'C',0);
			$pdf->SetXY(85,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('code_postal_famille'),0,0,'C',0);
			$pdf->SetXY(110,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('ville_famille'),0,0,'C',0);
			$pdf->SetXY(35,55);
			$pdf->Cell(35,25,$famille[0]->getAttr('num_tel_famille'),0,0,'C',0);
			$placementvertical=85;
			$pdf->SetXY(40,$placementvertical);
			$pdf->SetFont('Arial','U',12);
			$pdf->Cell(10,0,'Récapitulatif des livres achetés :',0,0,'C',0);
			$pdf->SetFont('Arial','',8);
			$placementvertical=$placementvertical+8;
			$pdf->SetXY(10,$placementvertical);
			$pdf->Cell(10,0,'Référence',0,0,'C',0);
			$pdf->SetXY(40,$placementvertical);
			$pdf->Cell(10,0,'Matière',0,0,'C',0);
			$pdf->SetXY(100,$placementvertical);
			$pdf->Cell(10,0,'Titre',0,0,'C',0);
			$pdf->SetXY(163,$placementvertical);
			$pdf->Cell(10,0,'Etat',0,0,'C',0);
			$pdf->SetXY(180,$placementvertical);
			$pdf->Cell(10,0,'Tarif',0,0,'C',0);
			$pdf->SetFont('Arial','',6);
			$nblivresachete=0;
			$couttotal=0;
			for($j=0;$j<sizeof($exemplaires);$j++){
				$nblivresachete=$nblivresachete+1;
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
				$pdf->SetXY(25,$placementvertical);
				$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
				$manuel= Manuel::findById($code_manuel);
				$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
				$pdf->SetXY(75,$placementvertical);	
				$titre=$manuel->getAttr('titre_manuel');
				if (strlen($titre)>40){
					$titre=substr($titre,0,40);
				}
				$pdf->Cell(80,0,$titre,0,0,'C',0);
				$pdf->SetXY(156,$placementvertical);
				$etat=$exemplaires[$j]->getAttr('code_etat');
				switch ($etat) {		
					case 1 : { 
					$pdf->Cell(25,0,'Excellent',0,0,'C',0);
					break; 
					}
					case 2 : { 
					$pdf->Cell(25,0,'Bon',0,0,'C',0);
					break; 
					}		
					case 3 : { 
					$pdf->Cell(25,0,'Moyen',0,0,'C',0); 
					break; 
					}		
					case 4 : { 
					$pdf->Cell(25,0,'Mauvais',0,0,'C',0);
					break; 
					}		
					default :{
					$pdf->Cell(25,0,'non défini',0,0,'C',0);
					break; 
					}	
				}
				$pdf->SetFont('Arial','',8);
				$pdf->SetXY(182,$placementvertical);
				$codemanuel=$exemplaires[$j]->getAttr('code_manuel');
				$etat=$exemplaires[$j]->getAttr('code_etat');
				$determine=Determine::findById($etat,$codemanuel);
				$pdf->Cell(10,0,$determine->getAttr('tarif')." €",0,0,'C',0);
				$pdf->SetFont('Arial','',6);
				$couttotal=$couttotal+$determine->getAttr('tarif');
				if ($placementvertical>230){
						$pdf->AddPage();
						$placementvertical=10;
					}
			}
			$pdf->SetFont('Arial','',9);
			$placementvertical=$placementvertical+7;
			$pdf->SetXY(170,$placementvertical);
			$pdf->Cell(10,0,'Total :'.$couttotal." €",0,0,'C',0);
			$placementvertical=$placementvertical+7;
			$pdf->SetXY(170,$placementvertical);
			$fraisdossier=$tableaulisteAchat[$i]->getAttr('frais_dossier_achat');
			$pdf->Cell(10,0,'Frais de dossier :'.$fraisdossier." €",0,0,'C',0);
			$placementvertical=$placementvertical+7;
			$pdf->SetXY(170,$placementvertical);
			$montantapayer=$couttotal+$fraisdossier;
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(10,0,'Total à payer :'.$montantapayer." €",0,0,'C',0);
			$placementvertical=$placementvertical+10;
			$pdf->SetXY(40,$placementvertical);
			$pdf->SetFont('Arial','U',12);
			$pdf->Cell(10,0,'Règlement :',0,0,'C',0);
			$regle=Regle::findByNumDossierAchat($tableaulisteAchat[$i]->getAttr('num_dossier_achat'));
			if ($regle!=null){
				$pdf->SetFont('Arial','',8);
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,'Mode',0,0,'C',0);
				$pdf->SetXY(40,$placementvertical);
				$pdf->Cell(10,0,'Date',0,0,'C',0);
				$pdf->SetXY(80,$placementvertical);
				$pdf->Cell(10,0,'Montant',0,0,'C',0);
				$pdf->SetFont('Arial','',8);
				$montantdejapaye=0;
				for($k=0;$k<sizeof($regle);$k++){
					$typereg=Reglement::findAll();
					$b=$regle[$k]->getAttr('code_reglement');
					for($l=0;$l<sizeof($typereg);$l++){
						$a=$typereg[$l]->getAttr('code_reglement');
						if ($a==$b){
							$mode=$typereg[$l]->getAttr('mode_reglement');
						}
						if ($placementvertical>230){
						$pdf->AddPage();
						$placementvertical=10;
						}
					}	
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,$mode,0,0,'C',0);
					$pdf->SetXY(25,$placementvertical);
					$pdf->Cell(50,0,$regle[$k]->getAttr('datereg'),0,0,'C',0); 
					$pdf->SetXY(80,$placementvertical);
					$pdf->Cell(10,0,$regle[$k]->getAttr('montant'),0,0,'C',0); 
					$montantdejapaye=$montantdejapaye+$regle[$k]->getAttr('montant');
				}
				$pdf->SetXY(163,$placementvertical);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(10,0,'Montant déja payé : '.$montantdejapaye.' €',0,0,'C',0);
			}
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,265);
			$pdf->Cell(0,0,'La bourse aux livres FCPE est organisée par des Parents d\'Elèves Bénévoles.Si vous constatez une erreur, merci de vous adresser aux organisateurs.',0,0,'C',0);
		}
		$pdf->Output('./rapports/general/facture_achat.pdf','F');
		
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des factures &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/facture_achat.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	
	public function generer_invendus(){
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetDisplayMode('real');
		$pdf->SetCreator('ScolBourse');
		$pdf->AddPage();
		$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
		$pdf->SetFont('Arial','B',18);
		$pdf->Cell(140,10,'Bourse aux Livres FCPE '.date("Y"),0,0,'C');
		$pdf->SetFont('Arial','',13);
		$pdf->SetXY(60,16);
		$pdf->Cell(40,10,'Liste des livres invendus au',0,0,'C');
		$date = date("d-m-Y");
		$pdf->SetXY(130,16);
		$pdf->Cell(25,10,$date,0,1,'C');
		$pdf->Line(10,35,200,35);
		$placementvertical=40;
		$tableaulisteDepot= DossierDeDepot::findAllTrie();
		$nbparpages=0;//pour savoir kan on saute une page
		for($i=0;$i< sizeof($tableaulisteDepot);$i++){ //boucle sur les personnes (dossier de dépot)
			$famille= Famille::findByNumDossier($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$exemplaires= Exemplaire::findByNumDossierDepot($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			for($j=0;$j<sizeof($exemplaires);$j++){
				if ($exemplaires[$j]->getAttr('vendu')!=1){
					$nblivresinvendus=$nblivresinvendus+1;
				}
			}
			if ($nblivresinvendus!=0){
				$pdf->SetFont('Arial','',13);
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(65,0,$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,0,'C',0);
				$pdf->SetXY(10,$placementvertical);
				$pdf->SetFont('Arial','U',14);
				$pdf->Cell(130,0,$famille[0]->getAttr('nom_famille'),0,0,'C',0);
				$pdf->SetFont('Arial','',13);
				for($j=0;$j<sizeof($exemplaires);$j++){
					if ($exemplaires[$j]->getAttr('vendu')!=1){
						$placementvertical=$placementvertical+8;
						$pdf->SetXY(7,$placementvertical);
						$pdf->Cell(27,1,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
						$manuel=Manuel::findById($exemplaires[$j]->getAttr('code_manuel'));
						$pdf->SetXY(50,$placementvertical);
						$pdf->SetFont('Arial','',9);
						$matiere=$manuel->getAttr('matiere_manuel');
						if (strlen($matiere)>25){
							$matiere=substr($matiere,0,25);
						}
						$pdf->Cell(35,1,$matiere,0,0,'C',0);
						$titre=$manuel->getAttr('titre_manuel');
						if (strlen($titre)>55){
							$titre=substr($titre,0,55);
						}
						$pdf->SetXY(100,$placementvertical);
						$pdf->Cell(100,0,$titre,0,0,'C',0);
						$pdf->SetFont('Arial','',13);
					}
					if ($placementvertical>=248){
					$pdf->AddPage();
					$placementvertical=25;
					}
				}
				$placementvertical=$placementvertical+7;
				$pdf->SetXY(5,$placementvertical);
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(70,0,'Nombre de livres invendus : '.$nblivresinvendus,0,0,'C',0);
				$placementvertical=$placementvertical+4;
				$pdf->Line(10,$placementvertical,200,$placementvertical);
				$placementvertical=$placementvertical+10;
				
			}
			
			$nblivresinvendus=0;
		}
		$pdf->Output('./rapports/general/invendus.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des invendus &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/invendus.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	
	public function generer_liste_manuel(){
		
		$tableauliste= Liste::findAll();
		$pdf=new FPDF('L','mm','A4');
		$pdf->SetCreator('ScolBourse');
		$pdf->AddPage();
		$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
		$pdf->SetFont('Arial','B',18);
		$pdf->Cell(140,10,'Bourse aux Livres FCPE '.date("Y"),0,1,'C');
		$pdf->Cell(192,10,'Liste des Manuels disponibles en occasion',0,0,'C');
		for($i=0;$i< sizeof($tableauliste);$i++){
			if($i==0){ // si on est a la premiere page, on cré l'entete
				$pdf->Cell(30);
				$pdf->Rect(10,38,275,15);
				$pdf->SetFont('Arial','B',10);
				$pdf->Ln();
				$pdf->Cell(10,40,'Num Liste :',0,0,'L',0);
				$pdf->Cell(25,40,$tableauliste[$i]->getAttr('code_liste'),0,0,'C',0);
				$pdf->Cell(50,40,$tableauliste[$i]->getAttr('libelle_liste'),0,0,'C');
				$pdf->Cell(180,40,'Classes :',0,0,'L');
				$pdf->Cell(-300,40,$tableauliste[$i]->getAttr('classe_liste'),0,0,'C');
				$pdf->Ln(30);
				$pdf->SetXY(10,50);
				$x=17;
				$y=50;
			}else{
				$pdf->AddPage();
				$pdf->Rect(10,10,275,15);
				$pdf->SetFont('Arial','B',10);
				$pdf->Ln();
				$pdf->Cell(10,10,'Num Liste :',0,0,'L',0);
				$pdf->Cell(25,10,$tableauliste[$i]->getAttr('code_liste'),0,0,'C',0);
				$pdf->Cell(50,10,$tableauliste[$i]->getAttr('libelle_liste'),0,0,'C');
				$pdf->Cell(180,10,'Classes :',0,0,'L');
				$pdf->Cell(-300,10,$tableauliste[$i]->getAttr('classe_liste'),0,0,'C');
				$pdf->Ln(30);
				$pdf->SetXY(10,22);
				$x=17;
				$y=22;
			}
			$pdf->Cell(0,0,'N°',0,0,'L');
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'référence ISBN',0,0,'L',0);
			$x=$x+35;
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'Titre-Auteurs',0,0,'L',0); 
			$x=$x+120;
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'matière',0,0,'L',0);
			$x=200; 
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'classe',0,0,'L',0); 
			$x=240; 
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'Editeur ',0,0,'L',0);
			$x=270;  
			$pdf->SetXY($x,$y);
			$pdf->Cell(0,0,'Edition',0,0,'L',0);
			$tableaudesListesManuels=ListeManuel::findBycodeListe($i+1);
			if($i==0){
				$pdf->SetXY(10,50);
				$placementligneVerticale=50;
			}else{
				$pdf->SetXY(10,22);
				$placementligneVerticale=22;
			}
			for($j=0;$j< sizeof($tableaudesListesManuels);$j++){
				if ($tableaudesListesManuels[$j]->getAttr('num_manuel_liste')!=null){
					$pdf->SetFont('Arial','B',10);
					$placementLigneHorizontal=8;
					$placementligneVerticale=$placementligneVerticale+6;
					$pdf->SetXY(8,$placementligneVerticale);
					$pdf->Cell($placementLigneHorizontal,0,$tableaudesListesManuels[$j]->getAttr('num_manuel_liste'),0,0,'C',0);
					$placementLigneHorizontal=$placementLigneHorizontal+10;
					$pdf->SetXY(24,$placementligneVerticale);
					$pdf->Cell($placementLigneHorizontal,0,$tableaudesListesManuels[$j]->getAttr('code_manuel'),0,0,'C',0);
					$manuel=Manuel::findById($tableaudesListesManuels[$j]->getAttr('code_manuel'));
					$placementLigneHorizontal=$placementLigneHorizontal+40;
					$pdf->SetFont('Arial','',6);
					$placementLigneHorizontal=$placementLigneHorizontal+50;
					$titre=$manuel->getAttr('titre_manuel');
					if (strlen($titre)>60){
						$titre=substr($titre,0,60);
					}
					$pdf->Cell($placementLigneHorizontal,0,$titre,'L',0,'C',0);
					$pdf->SetXY($placementLigneHorizontal,$placementligneVerticale);
					$placementLigneHorizontal=$placementLigneHorizontal+30;
					$pdf->Cell($placementLigneHorizontal,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0);
					$placementLigneHorizontal=$placementLigneHorizontal-215;
					$pdf->Cell($placementLigneHorizontal,0,$manuel->getAttr('classe_manuel'),0,0,'C',0);
					$placementLigneHorizontal=$placementLigneHorizontal+230;
					$pdf->Cell($placementLigneHorizontal,0,$manuel->getAttr('editeur_manuel'),0,0,'C',0);
					$placementLigneHorizontal=$placementLigneHorizontal-250;
					$pdf->Cell($placementLigneHorizontal,0,$manuel->getAttr('date_edition_manuel'),0,0,'C',0);
					if ($placementligneVerticale>183){
						if ($tableaudesListesManuels[$j+1]!=null){
							$pdf->AddPage();
							$placementligneVerticale=10;
						}
					}
				}
			}
		}
		$pdf->Output('./rapports/general/liste_manuel.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport de la liste des manuels &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/liste_manuel.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	public function generer_retour_invendus_particulier(){
		include 'config/config.edit.php';
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;
		
		if($oid!=0) {
			$famille = Famille::findById($oid);		
			$dossier = $famille->getAttr("dossierDeDepot"); 	
			
			$pdf=new FPDF('P','mm','A4');
			
			if ($dossier!=null){
				$pdf->SetCreator('ScolBourse');
				$pdf->SetDisplayMode('real');
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',17);
				$pdf->Cell(200,5,'BOURSE AUX LIVRES '. $annee_bourse,0,1,'C');
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(230,11,$titre_bourse,0,1,'C');
				$pdf->SetFont('Arial','B',18);
				$pdf->Cell(210,8,'- Récapitulatif des ventes -',0,1,'C');
				$pdf->SetXY(500,50);
				$pdf->Image($logo,10,8,25,25);
				$pdf->SetXY(10,40);
				$pdf->SetFont('Arial','',11);
				$pdf->Rect(10,38,185,40);
				$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
				$date = date("d-m-Y");
				$pdf->SetXY(40,40);
				$pdf->Cell(1,0,$dossier->getAttr('num_dossier_depot'),0,0,'C',0);
				$pdf->SetXY(150,40);
				$pdf->Cell(25,0,$date,0,1,'C');
				$pdf->SetXY(40,40);
				$exemplaires= Exemplaire::findByNumDossierDepot($dossier->getAttr('num_dossier_depot'));
				$pdf->Cell(13,25,$famille->getAttr('nom_famille'),0,0,'C',0);
				$pdf->SetXY(72,40);
				$pdf->Cell(20,25,$famille->getAttr('prenom_famille'),0,0,'C',0);
				$pdf->SetXY(40,47);
				$pdf->Cell(20,25,$famille->getAttr('adresse1_famille'),0,0,'C',0);
				$pdf->SetXY(85,47);
				$pdf->Cell(20,25,$famille->getAttr('code_postal_famille'),0,0,'C',0);
				$pdf->SetXY(110,47);
				$pdf->Cell(20,25,$famille->getAttr('ville_famille'),0,0,'C',0);
				$pdf->SetXY(35,55);
				$pdf->Cell(35,25,$famille->getAttr('num_tel_famille'),0,0,'C',0);
				$placementvertical=85;
				$pdf->SetXY(40,$placementvertical);
				$pdf->SetFont('Arial','U',12);
				$pdf->Cell(10,0,'Récapitulatif des livres vendus :',0,0,'C',0);
				$pdf->SetFont('Arial','',8);
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,'Référence',0,0,'C',0);
				$pdf->SetXY(40,$placementvertical);
				$pdf->Cell(10,0,'Matière',0,0,'C',0);
				$pdf->SetXY(100,$placementvertical);
				$pdf->Cell(10,0,'Titre',0,0,'C',0);
				$pdf->SetXY(163,$placementvertical);
				$pdf->Cell(10,0,'Etat',0,0,'C',0);
				$pdf->SetXY(180,$placementvertical);
				$pdf->Cell(10,0,'Tarif',0,0,'C',0);
				$pdf->SetFont('Arial','',6);
				$nblivresvendu=0;
				$couttotal=0;
				for($j=0;$j<sizeof($exemplaires);$j++){
					if ($exemplaires[$j]->getAttr('vendu')==1){
						$nblivresvendu=$nblivresvendu+1;
						$placementvertical=$placementvertical+8;
						$pdf->SetXY(10,$placementvertical);
						$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
						$pdf->SetXY(25,$placementvertical);
						$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
						$manuel= Manuel::findById($code_manuel);
						$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
						$pdf->SetXY(75,$placementvertical);	
						$titre=$manuel->getAttr('titre_manuel');
						if (strlen($titre)>40){
							$titre=substr($titre,0,40);
						}
						$pdf->Cell(80,0,$titre,0,0,'C',0);
						$pdf->SetXY(156,$placementvertical);
						$etat=$exemplaires[$j]->getAttr('code_etat');
						switch ($etat) {		
							case 1 : { 
							$pdf->Cell(25,0,'1',0,0,'C',0);
							break; 
							}
							case 2 : { 
							$pdf->Cell(25,0,'2',0,0,'C',0);
							break; 
							}		
							case 3 : { 
							$pdf->Cell(25,0,'3',0,0,'C',0); 
							break; 
							}		
							case 4 : { 
							$pdf->Cell(25,0,'4',0,0,'C',0);
							break; 
							}		
							default :{
							$pdf->Cell(25,0,'non défini',0,0,'C',0);
							break; 
							}	
						}
						if ($placementvertical>230){
							$pdf->AddPage();
							$placementvertical=10;
						}
						$pdf->SetFont('Arial','',8);
						$pdf->SetXY(182,$placementvertical);
						$codemanuel=$exemplaires[$j]->getAttr('code_manuel');
						$etat=$exemplaires[$j]->getAttr('code_etat');
						$determine=Determine::findById($etat,$codemanuel);
						$pdf->Cell(10,0,$determine->getAttr('tarif')." €",0,0,'C',0);
						$pdf->SetFont('Arial','',6);
						$couttotal=$couttotal+$determine->getAttr('tarif');
					}
				}
				$pdf->SetFont('Arial','B',10);
				$placementvertical=$placementvertical+10;
				$pdf->SetXY(170,$placementvertical);
				$fraisdossier=$dossier->getAttr('frais_dossier_depot');
				$fraisenvoi=$dossier->getAttr('frais_envoi_depot');
				$pdf->Cell(10,0,'Frais de dossier :'.$fraisdossier." €",0,0,'C',0);
				$placementvertical=$placementvertical+10;
				$pdf->SetXY(170,$placementvertical);
				$pdf->Cell(10,0,'Frais d\'envoi :'.$fraisenvoi." €",0,0,'C',0);
				$placementvertical=$placementvertical+10;
				$pdf->SetXY(170,$placementvertical);
				$montantapercevoir= round(($couttotal-$fraisdossier)-$fraisenvoi,2);
				$pdf->Cell(10,0,'A percevoir :'.$montantapercevoir." €",0,0,'C',0);
				//invendus
				$placementvertical=$placementvertical+15;
				$pdf->SetXY(40,$placementvertical);
				$pdf->SetFont('Arial','U',12);
				$pdf->Cell(10,0,'Récapitulatif des livres invendus :',0,0,'C',0);
				$pdf->SetFont('Arial','',8);
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,'Référence',0,0,'C',0);
				$pdf->SetXY(40,$placementvertical);
				$pdf->Cell(10,0,'Matière',0,0,'C',0);
				$pdf->SetXY(100,$placementvertical);
				$pdf->Cell(10,0,'Titre',0,0,'C',0);
				$pdf->SetXY(163,$placementvertical);
				$pdf->Cell(10,0,'Etat',0,0,'C',0);
				$pdf->SetFont('Arial','',6);
				for($j=0;$j<sizeof($exemplaires);$j++){
					if ($exemplaires[$j]->getAttr('vendu')!=1){
						$placementvertical=$placementvertical+8;
						$pdf->SetXY(10,$placementvertical);
						$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
						$pdf->SetXY(25,$placementvertical);
						$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
						$manuel= Manuel::findById($code_manuel);
						$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
						$pdf->SetXY(75,$placementvertical);	
						$titre=$manuel->getAttr('titre_manuel');
						if (strlen($titre)>40){
							$titre=substr($titre,0,40);
						}
						$pdf->Cell(80,0,$titre,0,0,'C',0);
						$pdf->SetXY(156,$placementvertical);
						$etat=$exemplaires[$j]->getAttr('code_etat');
						switch ($etat) {		
							case 1 : { 
							$pdf->Cell(25,0,'Excellent',0,0,'C',0);
							break; 
							}
							case 2 : { 
							$pdf->Cell(25,0,'Bon',0,0,'C',0);
							break; 
							}		
							case 3 : { 
							$pdf->Cell(25,0,'Moyen',0,0,'C',0); 
							break; 
							}		
							case 4 : { 
							$pdf->Cell(25,0,'Mauvais',0,0,'C',0);
							break; 
							}		
							default :{
							$pdf->Cell(25,0,'non défini',0,0,'C',0);
							break; 
							}
						}	
						if ($placementvertical>240){
							$pdf->AddPage();
							$placementvertical=10;
						}
					}
					$pdf->SetFont('Arial','',6);
					$pdf->SetXY(10,265);
					$pdf->Cell(0,0,$pied,0,0,'C',0);
				}
			}
			$pdf->Output('./rapports/particuliers/retour_invendus_famille_'.$dossier->getAttr('num_dossier_depot').'.pdf','F');
		}
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		
		if ($dossier!=null){
			$html .= "<tr>";
			$html .= "	<td  align='left'>Le rapport des invendus de la famille &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
			$html .= "</tr>";
			}else{
			$html .= "<tr>";
			$html .= "	<td  align='left'>Une erreur est survenue lors de la génération du rapport, la famille n'a pas de dossier !!</td>";
			$html .= "</tr>";
			}
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		if ($dossier!=null){
			$html .= "<a href='/ScolBoursePHP/rapports/particuliers/retour_invendus_famille_".$dossier->getAttr('num_dossier_depot').".pdf' target='_blank' onclick='window.location.reload(); return true;'>";
			$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		}
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	public function generer_recepisse_depot_particulier(){
		
		include 'config/config.edit.php';
	
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetCreator('ScolBourse');
		
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;
		
		if($oid!=0) {
			$famille = Famille::findById($oid);		
			$dossier = $famille->getAttr("dossierDeDepot"); 
			$exemplaires = Exemplaire::findByNumDossierDepot($oid);
			if ($dossier!=null){
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',17);
				$pdf->Cell(200,5,'BOURSE AUX LIVRES '. $annee_bourse,0,1,'C');
				$pdf->SetFont('Arial','',12);
				$pdf->Cell(230,11,$titre_bourse,0,1,'C');
				$pdf->SetFont('Arial','B',18);
				$pdf->Cell(210,8,'- Récépissé de dépôt -',0,1,'C');
				$pdf->SetXY(500,50);
				$pdf->Image($logo,10,8,25,25);
				$pdf->SetXY(10,40);
				$pdf->SetFont('Arial','',11);
				$pdf->Rect(10,38,185,40);
				$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
				$pdf->SetXY(50,40);
				$pdf->Cell(1,0,$dossier->getAttr('num_dossier_depot'),0,0,'C',0);
				$pdf->SetXY(40,40);
				$pdf->Cell(13,25,$famille->getAttr('nom_famille'),0,0,'C',0);
				$pdf->SetXY(72,40);
				$pdf->Cell(20,25,$famille->getAttr('prenom_famille'),0,0,'C',0);
				$pdf->SetXY(40,47);
				$pdf->Cell(20,25,$famille->getAttr('adresse1_famille'),0,0,'C',0);
				$pdf->SetXY(85,47);
				$pdf->Cell(20,25,$famille->getAttr('code_postal_famille'),0,0,'C',0);
				$pdf->SetXY(110,47);
				$pdf->Cell(20,25,$famille->getAttr('ville_famille'),0,0,'C',0);
				$pdf->SetXY(35,55);
				$pdf->Cell(35,25,$famille->getAttr('num_tel_famille'),0,0,'C',0);
				$placementvertical=85;
                                /*
				$pdf->SetXY(20,$placementvertical);
                               	$pdf->SetFont('Arial','U',11);
				$pdf->Cell(10,0,'Numéro d\'exemplaire',0,0,'C',0);
				$pdf->SetXY(80,$placementvertical);
				$pdf->Cell(10,0,'Matière',0,0,'C',0);
				$pdf->SetXY(130,$placementvertical);
				$pdf->Cell(10,0,'Classe',0,0,'C',0);
				$pdf->SetXY(180,$placementvertical);
				$pdf->Cell(10,0,'Etat Du Manuel',0,0,'C',0);
				$pdf->SetFont('Arial','',9);
                                */
				$pdf->SetFont('Arial','',8);
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(10,$placementvertical);
				$pdf->Cell(10,0,'Référence',0,0,'C',0);
				$pdf->SetXY(40,$placementvertical);
				$pdf->Cell(10,0,'Matière',0,0,'C',0);
				$pdf->SetXY(100,$placementvertical);
				$pdf->Cell(40,0,'Titre - classe',0,0,'C',0);
				$pdf->SetXY(170,$placementvertical);
				$pdf->Cell(10,0,'Etat',0,0,'L',0);
				$pdf->SetXY(180,$placementvertical);
				$pdf->Cell(10,0,'Tarif',0,0,'R',0);
				$pdf->SetFont('Arial','',7);
                                $nbdeposes = 0;
				for($j=0;$j<sizeof($exemplaires);$j++){
				  //$pdf->SetFont('Arial','',7);
				  $nbdeposes+=1;
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
					$pdf->SetXY(25,$placementvertical);
					$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
					$manuel= Manuel::findById($code_manuel);
					//$pdf->SetXY(50,$placementvertical);
					$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'L',0); 
					$pdf->SetXY(75,$placementvertical);	
						$titre=$manuel->getAttr('titre_manuel');
						if (strlen($titre)>40){
							$titre=substr($titre,0,40);
						}
					$pdf->Cell(60,0,$titre,0,0,'L',0);
					$pdf->SetXY(136,$placementvertical);	
					$pdf->Cell(40,0,$manuel->getAttr('classe_manuel'),0,0,'L',0);
					$pdf->SetXY(177,$placementvertical);
					$etat=$exemplaires[$j]->getAttr('code_etat');
					switch ($etat) {		
						case 1 : { 
						$pdf->Cell(10,0,'1',0,0,'L',0);
						break; 
						}
						case 2 : { 
						$pdf->Cell(10,0,'2',0,0,'L',0);
						break; 
						}		
						case 3 : { 
						$pdf->Cell(10,0,'3',0,0,'L',0); 
						break; 
						}		
						case 4 : { 
						$pdf->Cell(10,0,'4',0,0,'L',0);
						break; 
						}		
						default :{
						$pdf->Cell(10,0,'?',0,0,'C',0);
						break; 
						}	
					}
					$pdf->SetXY(185,$placementvertical);
					$codemanuel=$exemplaires[$j]->getAttr('code_manuel');
					$etat=$exemplaires[$j]->getAttr('code_etat');
					$determine=Determine::findById($etat,$codemanuel);
					$pdf->Cell(10,0,$determine->getAttr('tarif')." €",0,0,'C',0);
					if ($placementvertical>240){
						$pdf->AddPage();
						$placementvertical=10;
					}
				}
				$pdf->SetFont('Arial','',9);
				$placementvertical+=8;
				$pdf->SetXY(100,$placementvertical);
                                $pdf->Cell(80,0,"Livres en Dépôt : $nbdeposes",0,0,'C',0);
				$pdf->SetFont('Arial','',7);
				$pdf->SetXY(10,265);
				$pdf->Cell(0,0,$pied,0,0,'C',0);
			}
			$pdf->Output('./rapports/particuliers/recepisse_depot_famille_'.$dossier->getAttr('num_dossier_depot').'.pdf','F');
		}
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";		
		$html .= "<table align='left'>";
		$html .= "<tr>";
		if ($dossier!=null){
		$html .= "	<td  align='left'>Le rapport du d&eacute;p&ocirc;t de la famille &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		}else{
		$html .= "	<td  align='left'>Une Erreur est survenue lors de la création du rapport, la famille n'a pas encore de dossier !!</td>";
		$html .= "</tr>";
		}
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		
		if ($dossier!=null){
			$html .= "<a href='/ScolBoursePHP/rapports/particuliers/recepisse_depot_famille_".$dossier->getAttr('num_dossier_depot').".pdf' target='_blank' onclick='window.location.reload(); return true;'>";
			$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		}
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	
	public function generer_recepisse_depot(){
		$tableaulisteDepot= DossierDeDepot::findAllTrie();
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetCreator('ScolBourse');
		for($i=0;$i< sizeof($tableaulisteDepot);$i++){
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',17);
			$pdf->Cell(200,5,'BOURSE AUX LIVRES '.date("Y"),0,1,'C');
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(230,11,'Lycée Jacques Callot - Vandoeuvre',0,1,'C');
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(210,8,'- Récépissé de dépôt -',0,1,'C');
			$pdf->SetXY(500,50);
			$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
			$pdf->SetXY(10,40);
			$pdf->SetFont('Arial','',11);
			$pdf->Rect(10,38,185,40);
			$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
			$pdf->SetXY(40,40);
			$pdf->Cell(1,0,$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,0,'C',0);
			$famille= Famille::findByNumDossier($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$exemplaires= Exemplaire::findByNumDossierDepot($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$pdf->Cell(13,25,$famille[0]->getAttr('nom_famille'),0,0,'C',0);
			$pdf->SetXY(72,40);
			$pdf->Cell(20,25,$famille[0]->getAttr('prenom_famille'),0,0,'C',0);
			$pdf->SetXY(40,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('adresse1_famille'),0,0,'C',0);
			$pdf->SetXY(85,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('code_postal_famille'),0,0,'C',0);
			$pdf->SetXY(110,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('ville_famille'),0,0,'C',0);
			$pdf->SetXY(35,55);
			$pdf->Cell(35,25,$famille[0]->getAttr('num_tel_famille'),0,0,'C',0);
			$placementvertical=85;
			$pdf->SetXY(20,$placementvertical);
			$pdf->SetFont('Arial','U',11);
			$pdf->Cell(10,0,'Numéro d\'exemplaire',0,0,'C',0);
			$pdf->SetXY(80,$placementvertical);
			$pdf->Cell(10,0,'Matière',0,0,'C',0);
			$pdf->SetXY(130,$placementvertical);
			$pdf->Cell(10,0,'Classe',0,0,'C',0);
			$pdf->SetXY(180,$placementvertical);
			$pdf->Cell(10,0,'Etat Du Manuel',0,0,'C',0);
			$pdf->SetFont('Arial','',9);
			for($j=0;$j<sizeof($exemplaires);$j++){
				$placementvertical=$placementvertical+8;
				$pdf->SetXY(13,$placementvertical);
				$pdf->Cell(13,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
				$pdf->SetXY(25,$placementvertical);
				$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
				$manuel= Manuel::findById($code_manuel);
				$pdf->SetXY(60,$placementvertical);
				$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
				$pdf->SetXY(120,$placementvertical);	
				$pdf->Cell(50,0,$manuel->getAttr('classe_manuel'),0,0,'C',0);
				$pdf->SetXY(175,$placementvertical);
				$etat=$exemplaires[$j]->getAttr('code_etat');
				switch ($etat) {		
					case 1 : { 
					$pdf->Cell(35,0,'Excellent',0,0,'C',0);
					break; 
					}
					case 2 : { 
					$pdf->Cell(35,0,'Bon',0,0,'C',0);
					break; 
					}		
					case 3 : { 
					$pdf->Cell(35,0,'Moyen',0,0,'C',0); 
					break; 
					}		
					case 4 : { 
					$pdf->Cell(35,0,'Mauvais',0,0,'C',0);
					break; 
					}		
					default :{
					$pdf->Cell(35,0,'non défini',0,0,'C',0);
					break; 
					}	
				}
				
				if ($placementvertical>240){
						$pdf->AddPage();
						$placementvertical=10;
					}
			}
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY(10,265);
			$pdf->Cell(0,0,'La bourse aux livres FCPE est organisée par des Parents d\'Elèves Bénévoles.Si vous constatez une erreur, merci de vous adresser aux organisateurs.',0,0,'C',0);
			
		}
		
		$pdf->Output('./rapports/general/recepisse_depot.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des d&eacute;p&ocirc;ts &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/recepisse_depot.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	public function generer_retour_invendus(){
		$tableaulisteDepot= DossierDeDepot::findAllTrie();
		$pdf=new FPDF('P','mm','A4');
		$pdf->SetCreator('ScolBourse');
		$pdf->SetDisplayMode('real');
		for($i=0;$i< sizeof($tableaulisteDepot);$i++){ //boucle sur les personnes (dossier de dépot)
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',17);
			$pdf->Cell(200,5,'BOURSE AUX LIVRES '.date("Y"),0,1,'C');
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(230,11,'Lycée Jacques Callot - Vandoeuvre',0,1,'C');
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(210,8,'- Récapitulatif des ventes -',0,1,'C');
			$pdf->SetXY(500,50);
			$pdf->Image('./images/fcpe2.jpg',10,8,25,25);
			$pdf->SetXY(10,40);
			$pdf->SetFont('Arial','',11);
			$pdf->Rect(10,38,185,40);
			$pdf->Cell(25,0,'N° de dossier :',0,1,'C');
			$date = date("d-m-Y");
			$pdf->SetXY(40,40);
			$pdf->Cell(1,0,$tableaulisteDepot[$i]->getAttr('num_dossier_depot'),0,0,'C',0);
			$pdf->SetXY(150,40);
			$pdf->Cell(25,0,$date,0,1,'C');
			$pdf->SetXY(40,40);
			$famille= Famille::findByNumDossier($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$exemplaires= Exemplaire::findByNumDossierDepot($tableaulisteDepot[$i]->getAttr('num_dossier_depot'));
			$pdf->Cell(13,25,$famille[0]->getAttr('nom_famille'),0,0,'C',0);
			$pdf->SetXY(72,40);
			$pdf->Cell(20,25,$famille[0]->getAttr('prenom_famille'),0,0,'C',0);
			$pdf->SetXY(40,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('adresse1_famille'),0,0,'C',0);
			$pdf->SetXY(85,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('code_postal_famille'),0,0,'C',0);
			$pdf->SetXY(110,47);
			$pdf->Cell(20,25,$famille[0]->getAttr('ville_famille'),0,0,'C',0);
			$pdf->SetXY(35,55);
			$pdf->Cell(35,25,$famille[0]->getAttr('num_tel_famille'),0,0,'C',0);
			$placementvertical=85;
			$pdf->SetXY(40,$placementvertical);
			$pdf->SetFont('Arial','U',12);
			$pdf->Cell(10,0,'Récapitulatif des livres vendus :',0,0,'C',0);
			$pdf->SetFont('Arial','',8);
			$placementvertical=$placementvertical+8;
			$pdf->SetXY(10,$placementvertical);
			$pdf->Cell(10,0,'Référence',0,0,'C',0);
			$pdf->SetXY(40,$placementvertical);
			$pdf->Cell(10,0,'Matière',0,0,'C',0);
			$pdf->SetXY(100,$placementvertical);
			$pdf->Cell(10,0,'Titre',0,0,'C',0);
			$pdf->SetXY(163,$placementvertical);
			$pdf->Cell(10,0,'Etat',0,0,'C',0);
			$pdf->SetXY(180,$placementvertical);
			$pdf->Cell(10,0,'Tarif',0,0,'C',0);
			$pdf->SetFont('Arial','',6);
			$nblivresvendu=0;
			$couttotal=0;
			for($j=0;$j<sizeof($exemplaires);$j++){
				if ($exemplaires[$j]->getAttr('vendu')==1){
					$nblivresvendu=$nblivresvendu+1;
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
					$pdf->SetXY(25,$placementvertical);
					$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
					$manuel= Manuel::findById($code_manuel);
					$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
					$pdf->SetXY(75,$placementvertical);	
					$titre=$manuel->getAttr('titre_manuel');
					if (strlen($titre)>40){
						$titre=substr($titre,0,40);
					}
					$pdf->Cell(80,0,$titre,0,0,'C',0);
					$pdf->SetXY(156,$placementvertical);
					$etat=$exemplaires[$j]->getAttr('code_etat');
					switch ($etat) {		
						case 1 : { 
						$pdf->Cell(25,0,'Excellent',0,0,'C',0);
						break; 
						}
						case 2 : { 
						$pdf->Cell(25,0,'Bon',0,0,'C',0);
						break; 
						}		
						case 3 : { 
						$pdf->Cell(25,0,'Moyen',0,0,'C',0); 
						break; 
						}		
						case 4 : { 
						$pdf->Cell(25,0,'Mauvais',0,0,'C',0);
						break; 
						}		
						default :{
						$pdf->Cell(25,0,'non défini',0,0,'C',0);
						break; 
						}	
					}
					$pdf->SetFont('Arial','',8);
					$pdf->SetXY(182,$placementvertical);
					$codemanuel=$exemplaires[$j]->getAttr('code_manuel');
					$etat=$exemplaires[$j]->getAttr('code_etat');
					$determine=Determine::findById($etat,$codemanuel);
					$pdf->Cell(10,0,$determine->getAttr('tarif')." €",0,0,'C',0);
					$pdf->SetFont('Arial','',6);
					$couttotal=$couttotal+$determine->getAttr('tarif');
				}
				if ($placementvertical>240){
							$pdf->AddPage();
							$placementvertical=10;
					}
			}
			$pdf->SetFont('Arial','B',10);
			$placementvertical=$placementvertical+10;
			$pdf->SetXY(170,$placementvertical);
			$fraisdossier=$tableaulisteDepot[$i]->getAttr('frais_dossier_depot');
			$fraisenvoi=$tableaulisteDepot[$i]->getAttr('frais_envoi_depot');
			$pdf->Cell(10,0,'Frais de dossier :'.$fraisdossier." €",0,0,'C',0);
			$placementvertical=$placementvertical+10;
			$pdf->SetXY(170,$placementvertical);
			$pdf->Cell(10,0,'Frais d\'envoi :'.$fraisenvoi." €",0,0,'C',0);
			$placementvertical=$placementvertical+10;
			$pdf->SetXY(170,$placementvertical);
			$montantapercevoir=($couttotal-$fraisdossier)-$fraisenvoi;
			$pdf->Cell(10,0,'A percevoir :'.$montantapercevoir." €",0,0,'C',0);
			//invendus
			$placementvertical=$placementvertical+15;
			$pdf->SetXY(40,$placementvertical);
			$pdf->SetFont('Arial','U',12);
			$pdf->Cell(10,0,'Récapitulatif des livres invendus :',0,0,'C',0);
			$pdf->SetFont('Arial','',8);
			$placementvertical=$placementvertical+8;
			$pdf->SetXY(10,$placementvertical);
			$pdf->Cell(10,0,'Référence',0,0,'C',0);
			$pdf->SetXY(40,$placementvertical);
			$pdf->Cell(10,0,'Matière',0,0,'C',0);
			$pdf->SetXY(100,$placementvertical);
			$pdf->Cell(10,0,'Titre',0,0,'C',0);
			$pdf->SetXY(163,$placementvertical);
			$pdf->Cell(10,0,'Etat',0,0,'C',0);
			$pdf->SetFont('Arial','',6);
			for($j=0;$j<sizeof($exemplaires);$j++){
				if ($exemplaires[$j]->getAttr('vendu')!=1){
					$placementvertical=$placementvertical+8;
					$pdf->SetXY(10,$placementvertical);
					$pdf->Cell(10,0,$exemplaires[$j]->getAttr('code_exemplaire'),0,0,'C',0);
					$pdf->SetXY(25,$placementvertical);
					$code_manuel=$exemplaires[$j]->getAttr('code_manuel');
					$manuel= Manuel::findById($code_manuel);
					$pdf->Cell(50,0,$manuel->getAttr('matiere_manuel'),0,0,'C',0); 
					$pdf->SetXY(75,$placementvertical);	
					$titre=$manuel->getAttr('titre_manuel');
					if (strlen($titre)>40){
						$titre=substr($titre,0,40);
					}
					$pdf->Cell(80,0,$titre,0,0,'C',0);
					$pdf->SetXY(156,$placementvertical);
					$etat=$exemplaires[$j]->getAttr('code_etat');
					switch ($etat) {		
						case 1 : { 
						$pdf->Cell(25,0,'Excellent',0,0,'C',0);
						break; 
						}
						case 2 : { 
						$pdf->Cell(25,0,'Bon',0,0,'C',0);
						break; 
						}		
						case 3 : { 
						$pdf->Cell(25,0,'Moyen',0,0,'C',0); 
						break; 
						}		
						case 4 : { 
						$pdf->Cell(25,0,'Mauvais',0,0,'C',0);
						break; 
						}		
						default :{
						$pdf->Cell(25,0,'non défini',0,0,'C',0);
						break; 
						}
					}	
					if ($placementvertical>240){
							$pdf->AddPage();
							$placementvertical=10;
					}
				}
			}
			$pdf->SetFont('Arial','',6);
			$pdf->SetXY(10,265);
			$pdf->Cell(0,0,'La bourse aux livres FCPE est organisée par des Parents d\'Elèves Bénévoles.Si vous constatez une erreur, merci de vous adresser aux organisateurs.',0,0,'C',0);
			
		}
		
		$pdf->Output('./rapports/general/retour_invendus.pdf','F');
		$html = "";	
		$html .= "<div style='width:200; overflow:auto;'>";
		$html .= "<h3>Resultat</h3><br/>";
		$html .= "<table align='left'>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Le rapport des retours des invendus &agrave; bien &eacute;t&eacute; g&eacute;n&eacute;r&eacute;</td>";
		$html .= "</tr>";
		$html .= "<tr>";
		$html .= "	<td  align='left'>Il est stock&eacute; dans le r&eacute;pertoire 'Rapports'</td>";
		$html .= "</tr>";
		$html .= "</table>";
		$html .= "</div>";

		$html .= "<div align='center'>";
		$html .= "<a href='/ScolBoursePHP/rapports/general/retour_invendus.pdf' target='_blank' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#E35F06'>Ouvrir</font></a>&nbsp;&nbsp;";
		$html .= "<a href='' onclick='window.location.reload(); return true;'>";
		$html .= "<font color='#131313'>Fermer</font>";
		$html .= "</a></div>";
		
		echo $html;
	}
	
	public function mnuAction() {
		$view = new RapportView(null,"mnuAction");
		$view->display ();		 
	}	
	
	
}

?>
