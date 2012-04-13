<?php

require_once 'config.php';

class UserInfo{

	public $authed;
	public $displayName;

}

class RemoteLDAPUtil {

	public static function auth($user, $pass){
		
		$data = array('user' => $user, 'pass' => $pass);
		
		$ch = curl_init(Config::remote_ldap_location);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$return = curl_exec($ch);
		
		$user = unserialize($return);
		
		return $user->authed;
		
	}

}

?>