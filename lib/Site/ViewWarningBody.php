<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Util/SessionUtil.php';

class ViewWarningBody extends Body{
	
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
		$warning = WarningDao::getWarningByID($_GET['warnid']);
		$user = UserDao::getUserByID($warning->userId);
		
		if($user->id != $myuser->id && $myuser->userlevel <  RES_USERLEVEL_ADMIN){
			$this->context->addError("Not Authorized.");
			return $this->context->getErrorHTML();
		}
		
		$warnings = WarningDao::getAllWarningsForUser($user->id);
		
		$options = "";
		
		foreach($warnings as $warning){
			$options .= $warning->toOptionHTML();
		}
		
		$warningSelect = $user." has no warnings.";
		
		if($options != ""){
			$warningSelect = "<form action=\"./index.php\" method=\"GET\">".
				"<input type=\"hidden\" name=\"pageid\" value=\"viewWarning\" />".
				"<select>".$options."</select>".
				"<input type=\"submit\" value=\"View\" />".
				"</form>";
		}
		
		$adminRow = "";
		if($myuser->userlevel >= RES_USERLEVEL_ADMIN){
			$adminRow = "<tr><form action=\"./index.php?pageid=adminWarning\" method=\"POST\">".
			"<td colspan=2 class=\"centeredcellbold\">".
			"<input type=\"hidden\" name=\"action\" value=\"deleteWarning\" />".
			"<input type=\"hidden\" name=\"warnId\" value=\"".$warning->id."\" />".
			"<input type=\"submit\" value=\"Delete\" /></td></form></tr>";
		}
		
		return "<center><h3>View Warning For ".$user."</h3></center><table class=\"warning\">
			
			<tr>
			
				<td class=\"header\">Type</td>
				<td class=\"header\">Time</td>
			
			</tr>
			<tr>
			
				<td class=\"centeredcell\">".$warning->getTypeString()."</td>
				<td class=\"centeredcell\">".$warning->datetime."</td>
			
			</tr>
			<tr>
			
				<td colspan=2 class=\"header\">Warning Reason</td>
			
			</tr>
			
			<tr>
			
				<td colspan=2 class=\"centeredcell\"><textarea cols=\"55\" rows=\"7\" readonly>".$warning->reason."</textarea></td>
			
			</tr>
			".$adminRow."
		
		</table>";
		
	}
	
}

?>