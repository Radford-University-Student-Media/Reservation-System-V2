<?php

require_once './lib/Util/SessionUtil.php';

class User{
	
	public $id;
	public $username;
	public $name;
	public $password;
	public $email;
	public $userlevel;
	public $warnings;
	public $notes;
	
	public function __construct($id, $username, $name, $password, $email, $userlevel, $warnings, $notes){
		
		$this->id = $id;
		$this->username = $username;
		$this->name = $name;
		$this->password = $password;
		$this->email = $email;
		$this->userlevel = $userlevel;
		$this->warnings = $warnings;
		$this->notes = $notes;
		
	}
	
	public function __toString(){ 
		if(SessionUtil::getUserlevel() >= RES_USERLEVEL_ADMIN)
			return "<a href=\"./index.php?pageid=editUser&userid=".$this->id."\">".$this->name."</a>";
		return $this->name;
	}
	
}

?>