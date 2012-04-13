<?php

require_once './Config.php';

class CryptoUtil{

	private static $iv = "1b84j4pi";

	/*

		New Encryption Scheme, BLOWFISH

	*/

	public static function encrypt($text){
	
		return mcrypt_encrypt(MCRYPT_BLOWFISH,Config::blowfish_key,$text,MCRYPT_MODE_CFB, CryptoUtil::$iv);
		
	}

	/*
		
		New Encryption Scheme, BLOWFISH

	*/

	public static function decrypt($text){

		return mcrypt_decrypt(MCRYPT_BLOWFISH,Config::blowfish_key,$text,MCRYPT_MODE_CFB, CryptoUtil::$iv);
		
	}
	
	public static function generatePassword($length=9, $strength=0) {
		$vowels = 'aeiouy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEIOUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

}

?>