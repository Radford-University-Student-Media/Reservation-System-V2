<?php

require_once 'Layout.php';

class UnauthErrorLayout extends Layout{

	public function __construct(){
	
		parent::__construct(null, null);
	
	}

	public function generateHTML(){
	
		return "<html><head><title>Unauthorized Access</title></head><body>Unauthorized Access</body></html>";
	
	}

}

?>