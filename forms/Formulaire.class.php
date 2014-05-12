<?php
/**
 * forms.Formulaire.class.php : classe qui represente les formulaires de l'application
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package forms
 */

class Formulaire {
	// D E S   A T T R I B U T S
	
	/**#@+
	 *  @access private
	 **/ 
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $nomformulaire;
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $method;
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $action;
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $titre;			
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $enctype;
	
	/**
	 *  les champs du formulaire 
	 *  @var $items
	 **/
	private $items;
	
	/**
	 *  les buttons d'action du formulaire 
	 *  @var $button
	 **/
	private $buttons;
	
	/**
	 *  represente les scripts qui sont neccesaire pour le traitement du formulaire
	 *  @var $scripts
	 **/
	private $scripts;
			 	
	/**#@-*/
	
	
	// D E S   M E T H O D E S
	
	/**#@+
	*  @access public
	*/ 

	
	/**
	*  Constructeur du Formulaire
	*
	*  fabrique un nouvel formulaire 
	*/
	public function __construct($nomformulaire,$method, $action, $titre,  $items, $buttons, $enctype="", $scripts) {
		 $this->setAttr("nomformulaire",$nomformulaire);
		 $this->setAttr("method",$method);
		 $this->setAttr("action",$action);
		 $this->setAttr("titre",$titre);
		 $this->setAttr("items",$items);
		 $this->setAttr("buttons",$buttons);
		 $this->setAttr("enctype",$enctype);
		 $this->setAttr("scripts",$scripts);
	}
	
	
	/**
	*   Getter générique
	*
	*   fonction d'accés aux attributs d'un etat.
	*   Reçoit en paramètre le nom de l'attribut accédé
	*   et retourne sa valeur.
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @return mixed
	*/
	public function getAttr($attr_name) {
		return $this->$attr_name;
	}
	
	/**
	*   Setter générique
	*
	*   fonction de modification des attributs d'un etat.
	*   Reçoit en paramétre le nom de l'attribut modifié et la nouvelle valeur
	*  
	*   @access public
	*   @param String $attr_name attribute name 
	*   @param mixed $attr_val attribute value
	*   @return mixed new attribute value
	*/
	public function setAttr($attr_name, $attr_val) {
		$this->$attr_name=$attr_val;
		return $attr_val ;
	}	
	
	
	/**
	*   Afficher le formulaire
	*
	*   fonction qui permet d'afficher le formulaire 
	*  
	*   @access public
	*   @return String avec le code HTML pour afficher le formulaire 
	*/
	public function render() {
		$index = 0;
		$html = "";
		
		$html .= "<link rel='stylesheet' type='text/css' href='/ScolBoursePHP/css/datePicker.css' />";
		$html .= "<script language='javascript' type='text/javascript' runat='server' src='/ScolBoursePHP/js/datePicker.js'></script>";
 				
		if($this->getAttr("scripts")!="")
			$html .= "<script language='javascript' src='".$this->getAttr("scripts")."'></script>";
				
		$html .= "<form id='".$this->getAttr("nomformulaire")."' name='".$this->getAttr("nomformulaire")."' ";
		$html .= "method='".$this->getAttr("method"). "' action='" . $this->getAttr("action") . "' ";
		$html .= "enctype='" . $this->getAttr("enctype") . "'>";
		
		$html .= "<table>";
		$html .= "		<tr>";
		$html .= "			<td>&nbsp;</td>";	
		$html .= "			<th colspan='2' class='frmTitre'>" . $this->getAttr("titre") . "</th>";
		$html .= "			<td>&nbsp;</td>";
		$html .= "		</tr>";		
		
		foreach($this->getAttr("items") as $item) {		
			$html .= "		<tr>";		
			if(($item->getAttr("type")!="titre")&&($item->getAttr("type")!="hidden")&&($item->getAttr("type")!="div")&&($item->getAttr("type")!="ligne")) {
				if($item->getAttr("oblig")) 
					$html .= "			<td class='frmObligatoire'>*</td>";
				else 
					$html .= "			<td>&nbsp;</td>";
								
				if($item->getAttr("erreur")!="") 
					$html .= "		<td class='frmErreur'>";
				else 
					$html .= "		<td class='frmLabel'>";							
				$html .= $item->getAttr("label") . ":</td>";
				
				$html .= "			<td valign='middle'>";
				
				switch($item->getAttr("type")) {								
					// Select
					case "select": {
						$html .= "<select id='" . $item->getAttr("nom") . "' name='" . $item->getAttr("nom") . "' ";
						$html .= $item->getAttr("disabled") . " " . $item->getAttr("events"). ">";	
						// Mettre les option au select
						$valeurs =  $item->getAttr("valeur");					
						$vals = $valeurs[0];
						$labs = $valeurs[1];
						$sels = $valeurs[2];											
						for($j=0;$j<count($vals);$j++)
							if($sels[$j])
								$html .= "<option value='" . $vals[$j] . "' selected>" . $labs[$j] . "</option>";
							else
								$html .= "<option value='" . $vals[$j]. "'>" . $labs[$j] . "</option>";										
						$html .= "</select>";
					} break;
					
					// TextArea
					case "textarea": {
						$html .= "<textarea id='" . $item->getAttr("nom") . "' name='" . $item->getAttr("nom") . "' ";
						$html .= $item->getAttr("disabled") . " " . $item->getAttr("events"). ">". $item->getAttr("valeur");
						$html .= "</textarea>";
					} break;
					
					// Radio Buttons 
					case "radio": { 
						$valeurs =  $item->getAttr("valeur");
						$vals = $valeurs[0];
						$labs = $valeurs[1];
						$sels = $valeurs[2];											
						for($j=0;$j<count($vals);$j++){
							if($sels[$j]) {
								$html .= "<input id='" . $item->getAttr("nom") . "' type='".$item->getAttr("type")."' ";
								$html .= "name='".$item->getAttr("nom")."' value='".$vals[$j]."' checked ";
								$html .= $item->getAttr("disabled") . " " . $item->getAttr("events"). "/>";									
							} else {
								$html .= "<input id='" . $item->getAttr("nom") . "' type='". $item->getAttr("type") ."' ";
								$html .= "name='" . $item->getAttr("nom") . "' value='".$vals[$j]."' " . $item->getAttr("disabled");
								$html .= " " . $item->getAttr("events"). " onkeypress='return handleEnter(this, event)'/>";
							}
							$html .= " " . $labs[$j] . "<BR/>";
						}
					} break;
					
					// CheckBox
					case "checkbox": {				
						$valeurs =  $item->getAttr("valeur");					
						$noms = $valeurs[0];
						$labs = $valeurs[1];
						$sels = $valeurs[2];											
						for($j=0;$j<count($noms);$j++){
							if($sels[$j]) {
								$html .= "<input id='" . $item->getAttr("nom") . "' type='".$item->getAttr("type")."' ";
								$html .= "name='".$noms[$j]."' checked " . $item->getAttr("disabled") . " ";
								$html .= $item->getAttr("events"). "/>";													
							} else {
								$html .= "<input id='" . $item->getAttr("nom") . "' type='".$item->getAttr("type")."' ";
								$html .= "name='".$noms[$j]."' " .$item->getAttr("disabled")." ".$item->getAttr("events")." onkeypress='return handleEnter(this, event)'/>";
							}													
							$html .= " " . $labs[$j] . "<BR/>";
						}
					} break;
					
					// file
					case "file": {					
						$html .= "<input id='" . $item->getAttr("nom") . "' type='". $item->getAttr("type") ."' ";
						$html .= "name='" . $item->getAttr("nom") . "' value='". $item->getAttr("valeur") ."' ";
						$html .= $item->getAttr("disabled") . " " . $item->getAttr("events"). " onkeypress='return handleEnter(this, event)'>";	
					} break;
					
					// dateTime
					case "dateTime": {											
						$html .= "<input id='" . $item->getAttr("nom") . "' type='text' name='" . $item->getAttr("nom") . "'";					
						$html .= "value='". $item->getAttr("valeur") ."' " . $item->getAttr("disabled") . " ";
						$html .= $item->getAttr("events"). "/>&nbsp;";															
						$html .= "<a onclick='displayDatePicker(\"" . $item->getAttr("nom") . "\", ";
						$html .= "false, \"ymd\", \"-\")'><img src='/ScolBoursePHP/images/cal.gif' width='18' height='18'";
						$html .= "border='0' alt='Faire click Here pour selectioner la date'/></a>";								
					} break;
					
					// textBox, password, email, number
					default: {					
						$html .= "<input id='" . $item->getAttr("nom") . "' type='". $item->getAttr("type") ."' ";
						$html .= "name='" . $item->getAttr("nom") . "' value='". $item->getAttr("valeur") ."' ";
						$html .= "size='40' " . $item->getAttr("disabled") . " " . $item->getAttr("events"). " onkeypress='return handleEnter(this, event); return false;'/>";	
					}
				}
				$html .= "			</td>";					
				$html .= "			<td class='frmObligatoire'>" . $item->getAttr("erreur") . "</td>";
			} else {
				if($item->getAttr("type")=="titre") {
					$html .= "			<td>&nbsp;</td>";
					$html .= "			<td colspan='2' class='frmSousTitre'>";
					$html .= $item->getAttr("label") . "</td>";
					$html .= "			<td>&nbsp;</td>";					
				} else if($item->getAttr("type")=="hidden") {
					$html .= "<input id='" . $item->getAttr("nom") . "' type='". $item->getAttr("type") ."' ";
					$html .= "name='" . $item->getAttr("nom") . "' value='". $item->getAttr("valeur") ."' ";
					$html .= "size='40' " . $item->getAttr("disabled") . " " . $item->getAttr("events"). ">";	
				} else if($item->getAttr("type")=="ligne") {
					$html .= "			<td colspan='4'>&nbsp;</td>";
				} else {
					$html .= "			<td>&nbsp;</td>";
					$html .= "			<td class='frmLabel'>" . $item->getAttr("label") . "</td>";
					$html .= "          <td><div id='" . $item->getAttr("nom") . "'></div></td>";
					$html .= "			<td>&nbsp;</td>";
				}
			}
			$html .= "		</tr>";
		}
		$html .= "		<tr>";
		$html .= "			<td colspan='4'>&nbsp;</th>";
		$html .= "		</tr>";		
		$html .= "		<tr>";
		$html .= "			<td></td>";
		$html .= "			<td colspan='2' align='center'><input type='submit' name='submit' value='Envoyer'/>";
		$html .= "			 <input type='reset'  name='reset'  value='Effacer'/></td>";
		$html .= "			<td></td>";
		$html .= "		</tr>";		
		$html .= "		<tr><td colspan='4'>&nbsp;</td></tr>";		
		$html .= "		<tr><td colspan='4'><i>Les champs <span class='frmObligatoire'>*</span> sont obligatoires.</i></td></tr>";		
		$html .= "	</table>";
		$html .= "</form>";
					
		return $html;
	}	
	
	
	/* Fonction pour faire la validation du formulaire */
	public function validerFormulaire(){	
		$OK = true;
		$i=0;
		
		// Tableau de erreures
		$mesErreurs = Array(
			"Le formulaire n'est pas bien formé", 		
			"Le champ est obligatoire",
			"La valeur du champ email n'est pas valide",
			"Les valeurs du champs n'est pas une valeur numérique valide",
		);
		
		$i = 0;
		$items = &$this->getAttr("items");
		$lim = count($items);
		
		for($i=0; $i<$lim; $i++) {
			$item = &$items[$i];					
			if(($item->getAttr("type")!="titre")&&($item->getAttr("type")!="hidden")&&
			   ($item->getAttr("type")!="div")&&($item->getAttr("type")!="ligne")) {
			   
			switch($item->getAttr("type")) {								
				// Select
				case "select": {
					
					$valeurs =  $item->getAttr("valeur");					
					$vals = $valeurs[0];
					$labs = $valeurs[1];
					$sels = $valeurs[2];
																
					for($j=0;$j<count($vals);$j++) {					
						if($vals[$j]==$_REQUEST[$item->getAttr("nom")])
							$sels[$j] = true;
						else 
							$sels[$j] = false;												
					}																	
					$valeurs[0] = $vals;
					$valeurs[1] = $labs;
					$valeurs[2] = $sels;		
					$item->setAttr("valeur",$valeurs);					
				} break;
				
				// TextArea
				case "textarea": {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
						$OK=false;
					} else { 
						$item->setAttr("erreur","");
						$item->setAttr("valeur",self::getValue($_REQUEST[$item->getAttr("nom")]));
					}				
				} break;
				
				// Radio, CheckBox
				case "radio": { 
					$valeurs =  $item->getAttr("valeur");					
					$vals = $valeurs[0];
					$labs = $valeurs[1];
					$sels = $valeurs[2];
																
					for($j=0;$j<count($vals);$j++) {						
						if($vals[$j]==$_REQUEST[$item->getAttr("nom")])
							$sels[$j] = true;
						else 
							$sels[$j] = false;						
					}												
					$valeurs[0] = $vals;
					$valeurs[1] = $labs;
					$valeurs[2] = $sels;		
					$item->setAttr("valeur",$valeurs);
				} break;
				
				// Checkbox
				case "checkbox": {
					$valeurs =  $item->getAttr("valeur");					
					$noms = $valeurs[0];
					$labs = $valeurs[1];
					$sels = $valeurs[2];	
										
					$j=0;						
					for($j=0;$j<count($noms);$j++) {
						$nom = $noms[$j];
						if(isset($_REQUEST[$nom])) 
							$sels[$j] = true;
						 else 
							$sels[$j] = false;																	
					}												
					$valeurs[0] = $noms;
					$valeurs[1] = $labs;
					$valeurs[2] = $sels;							
					$item->setAttr("valeur",$valeurs);					
				} break;
				
				// file
				case "file": {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_FILES[$item->getAttr("nom")]);						
						$OK=false;
					} else { 
						$item->setAttr("erreur","");
						$item->setAttr("valeur",$_FILES[$item->getAttr("nom")]);
					}				
				} break;
				
				// dateTime
				case "dateTime": {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
						$OK=false;
					} else { 
						$item->setAttr("erreur","");
						$item->setAttr("valeur",self::getValue($_REQUEST[$item->getAttr("nom")]));
					}															
				} break;				
				
				// email
				case "email": {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
						$OK=false;
					} else { 				
						if((!self::isVide($_REQUEST[$item->getAttr("nom")]))&&(!self::isMailValide($_REQUEST[$item->getAttr("nom")]))) {
							$item->setAttr("erreur", $mesErreurs[2]);
							$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
							$OK=false;
						} else {
							$item->setAttr("erreur","");
							$item->setAttr("valeur",self::getValue($_REQUEST[$item->getAttr("nom")]));
						}											
					}														
				} break;				
				
				// Number
				case "number": {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
						$OK=false;
					} else { 				
						if(!self::isNumber($_REQUEST[$item->getAttr("nom")])) {
							$item->setAttr("erreur", $mesErreurs[3]);
							$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
							$OK=false;						
						} else {
							$item->setAttr("erreur","");
							$item->setAttr("valeur",self::getValue($_REQUEST[$item->getAttr("nom")]));
						}											
					}														
				} break;
				
				// textBox, password, hidden 
				default: {
					if(($item->getAttr("oblig"))&&(self::isVide($_REQUEST[$item->getAttr("nom")]))) {
						$item->setAttr("erreur", $mesErreurs[1]);
						$item->setAttr("valeur",$_REQUEST[$item->getAttr("nom")]);
						$OK=false;
					} else { 
						$item->setAttr("erreur","");
						$item->setAttr("valeur",self::getValue($_REQUEST[$item->getAttr("nom")]));
					}				
				}									
			}
			$this->setAttr("items",$items);
			}
		}
					
		return $OK;
	}				
	
	/* Fonction pour verifier si les champs sont VIDES */
	private static function isVide($champ) {
		return(strlen(trim($champ))==0);
	}
	
	/* Fonction pour verifier si les champs EMAIL sont CORRECTES */
	private static function isMailValide($email){
		$valid = true;
		if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
			$valid = false;
		}
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^
			_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			$valid = false;
			}
		}
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) 
				$valid = false;			
			for ($i = 0; $i < sizeof($domain_array); $i++) 
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
					$valid = false;				
			
		}
		return $valid;	
	} 
	
	/* Fonction pour verifier si les champs Number sont CORRECTES */
	private static function isNumber($champ){		 
		return (is_numeric($champ));
	} 
	
	private static function getValue($champ){		
		$value = htmlspecialchars($champ);	
		$value = mysql_escape_string($value);
		return $value;
	}
			
	/**#@-*/	
}
?>
