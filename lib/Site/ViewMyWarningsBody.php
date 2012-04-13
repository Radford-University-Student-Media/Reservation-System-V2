<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Util/SessionUtil.php';

class ViewMyWarningsBody extends Body{
	
	private $context;
	
	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getTitle(){
	
		return "View My Warnings";
	
	}
	
	public function getScriptsHTML(){
		return "";
	}
	
	public function generateHTML(){
		$user = UserDao::getUserByUsername(SessionUtil::getUsername());
		
		$warnings = WarningDao::getAllWarningsForUser($user->id);
		
		$options = "";
		
		foreach($warnings as $warning){
			$options .= $warning->toOptionHTML();
		}
		
		$warningSelect = "You have no warnings. :)";
		
		if($options != "")
			$warningSelect = "<form action=\"./index.php\" method=\"GET\">".
				"<input type=\"hidden\" name=\"pageid\" value=\"viewWarning\" />".
				"<select name=\"warnid\">".$options."</select>".
				"<input type=\"submit\" value=\"View\" />".
				"</form>";
		
		return "<center><h3>View My Warnings</h3></center>".$warningSelect;
	}
	
}

?>