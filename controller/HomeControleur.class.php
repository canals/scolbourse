<?php

	session_start();

/**
 * controller.Article.class.php : classe qui represente le controlleur des Articles de l'application
 *
 * @author RIVAS Ronel
 * @author SUSTAITA Luis
 * @package controller
 */

class HomeControleur extends AbstractControleur {

	public static $MNU_ID = "mnuHome";
	
	public function __construct(){
		// Pour g&eacute;rer les menus
		$_SESSION['mnuId'] = self::$MNU_ID;
	}
		 
	public function detailAction() {	
		$this->defaultAction();
	}
	
	public function listeAction() {	
		$this->defaultAction();
	}
		 
	public function defaultAction() {		
		$auth = new BourseAuth();
		$user = $auth->getUserProfile();

                //var_dump($user);

		if($user==null){
			// Page de authentication
			$this->getPageAuthentication();									
		} else {			
			try {
				$auth->checkAuthLevel(BourseAuth::$ADMIN_LEVEL) ; 
				// L'utilisateur est l'administrateur. HOME ADMINISTRATION
				$this->getHomeAdministration(); 
			} catch(AuthException $a) {
				// L'utilisateur est un Benevole. HOME BENEVOLE
				$this->getHomeBenevole();  
			}					
		}				 	
	}
	
	private function getPageAuthentication(){
		$view = new HomeView(null,"auth");
		$view->display();	
	}
	
	private function getHomeAdministration(){			
		$view = new HomeView(null,"admin");
		$view->display();				  				
	}
	
	private function getHomeBenevole(){
		$oid = ($this->valeur!=null) ? $this->valeur : 0 ;		
		$famille = Famille::findById($oid);	
					
		$view = new HomeView($famille,"user");
		$view->display();				
	}		
			
}

?>