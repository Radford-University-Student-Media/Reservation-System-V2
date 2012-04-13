<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Util/SessionUtil.php';

class ViewWarningsBody extends Body{
	
	private $context;
	
	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getTitle(){
	
		return "View Warnings";
	
	}
	
	public function getScriptsHTML(){
		return "";
	}
	
	public function generateHTML(){
		$myuser = UserDao::getUserByUsername(SessionUtil::getUsername());
		$user = UserDao::getUserByID($_GET['userid']);
		
		if($myuser->userlevel <  RES_USERLEVEL_ADMIN){
			$this->context->addError("Not Authorized.");
			return $this->context->getErrorHTML();
		}
		
		$warnings = WarningDao::getAllWarningsForUser($user->id);
		
		$options = "";
		
		foreach($warnings as $warning){
			$options .= $warning->toOptionHTML();
		}
		
		$warningSelect = $user." has no warnings.";
		
		if($options != "")
			$warningSelect = "<form action=\"./index.php\" method=\"GET\">".
				"<input type=\"hidden\" name=\"pageid\" value=\"viewWarning\" />".
				"<select name=\"warnid\">".$options."</select>".
				"<input type=\"submit\" value=\"View\" />".
				"</form>";
		
		return "<center><h3>View Warnings For ".$user."</h3></center>".$warningSelect;
	}
	
}

?>