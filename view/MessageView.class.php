<?php

	session_start();

class MessageView {
	private $titre ;
	private $message ;
	private $mode ;
	private $retour ;
	
	private $user;
	
	public function __construct($titre, $message, $mode, $retour = null) {
		$this->titre = $titre;
		$this->message = $message;
		$this->mode = $mode;
		$this->retour = $retour;
		
		$ba = new BourseAuth();
		$this->user = $ba->getUserProfile();				
	}

	public function display() {												
		$mv = new MainView();		
		$mv->addTitre($this->titre); 		
		$mv->addMenu(null);	
		$mv->addContenu($this->detailMessage());
		$mv->render(); 
	}
	
	public function detailMessage() {			
		$sousTitre = ($this->mode!="ERREUR")?"<h4>OK!!!</h4>":"<h4 color='red'>ERREUR!!!</h4>"; 					
		$liu = "/ScolBoursePHP/index.php" . $this->retour;					
		$body = "<BR/><BR/>"; 
		$body .= "<div align='left'>";		 				 
		$body .= $sousTitre;	
		$body .= "	 <p><i>" . $this->message . "</i></p><BR/>";	
		$body .= "	 <a href='" . $liu . "'>Retourner</a>";					 
		$body .= "</div>" ;
		$body .= "<BR/>" ;			
		return $body;
	}
}
?>