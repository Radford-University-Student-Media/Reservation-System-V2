<?php

require_once 'Navigation.php';
require_once 'Body.php';

abstract class Layout{

	private $navigation;
	private $body;
	
	public function __construct($navi, $_body){
	
		$this->navigation = $navi;
		$this->body = $_body;
	
	}
	
	public function getNavigation(){
	
		return $this->navigation;
	
	}
	
	public function setNavigation(Navigation $navi){
	
		$this->navigation = $navi;
	
	}
	
	public function getBody(){
	
		return $this->body;
	
	}
	
	public function setBody(Body $_body){
	
		$this->body = $_body;
	
	}
	
	public abstract function generateHTML();

}

?>