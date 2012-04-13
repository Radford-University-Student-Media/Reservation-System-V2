<?php

require_once './config.php';

class SessionUtil{
	
	private static function getSessionPrefix(){
	
		return Config::location;
	
	}
	
	public static function start(){
	
		session_name(md5(Config::location.session_name()));
		$return = session_start();
		session_regenerate_id();
		return $return;
	
	}
	
	public static function clear(){
	
		session_unset();
	
	}
	
	public static function destroy(){
	
		return session_destroy();
	
	}
	
	public static function restart(){
	
		SessionUtil::clear();
		SessionUtil::destroy();
		SessionUtil::start();
	
	}

	public static function getVariable($vName){
	
		return $_SESSION[SessionUtil::getSessionPrefix()."~".$vName];
	
	}
	
	public static function setVariable($vName, $value){
	
		$_SESSION[SessionUtil::getSessionPrefix()."~".$vName] = $value;
	
	}
	
	public static function isVariableSet($vName){
	
		return isset($_SESSION[SessionUtil::getSessionPrefix()."~".$vName]);
	
	}
	
	public static function setUsername($username){
		SessionUtil::setVariable("username", $username);
	}
	
	public static function getUsername(){
	
		return SessionUtil::getVariable("username");
	
	}
	
	public static function setUserlevel($userlevel){
		SessionUtil::setVariable("userlevel", $userlevel);
	}
	
	public static function getUserlevel(){
	
		return SessionUtil::getVariable("userlevel");
	
	}
	
	public static function setLastViewed($size, $webadId){
		
		SessionUtil::setVariable("last-".$size, $webadId);
		
	}
	
	public static function getLastViewed($size){
		
		return SessionUtil::getVariable("last-".$size);
		
	}
	
	public static function isLoggedIn(){
	
		return SessionUtil::isVariableSet("username") && SessionUtil::isVariableSet("userlevel");
	
	}

}

?>