<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Site/Page.php';

class EditUserBody extends Body{

	private $context;

	public function __construct(Context $context){
		$this->context = $context;
	}

	public function getMinimumUserLevel(){
		return RES_USERLEVEL_ADMIN;
	}

	public function getTitle(){

		return "User Admin";

	}

	public function getScriptsHTML(){
		return "";
	}

	private function generateUserLevelDropdown($formName, $selectedLevel){
		$selectedText = array();

		for($i = 0; $i <= RES_USERLEVEL_ADMIN; $i++){

			$selectedText[$i] = "";

		}

		$selectedText[$selectedLevel] = "selected=\"selected\"";

		return "<select name=\"".$formName."\">
				<option value=\"".RES_USERLEVEL_NOLOGIN."\" ".$selectedText[RES_USERLEVEL_NOLOGIN].">".RES_USERLEVEL_STRING_NOLOGIN."</option>
				<option value=\"".RES_USERLEVEL_USER."\" ".$selectedText[RES_USERLEVEL_USER].">".RES_USERLEVEL_STRING_USER."</option>
				<option value=\"".RES_USERLEVEL_LEADER."\" ".$selectedText[RES_USERLEVEL_LEADER].">".RES_USERLEVEL_STRING_LEADER."</option>
				<option value=\"".RES_USERLEVEL_PROFESSOR."\" ".$selectedText[RES_USERLEVEL_PROFESSOR].">".RES_USERLEVEL_STRING_PROFESSOR."</option>
				<option value=\"".RES_USERLEVEL_ADMIN."\" ".$selectedText[RES_USERLEVEL_ADMIN].">".RES_USERLEVEL_STRING_ADMIN."</option>
			</select>";
	}
	
	private function generatePasswordRows($user){
		return "<tr>
		
			<td class=\"centeredcellbold\">Change Password</td>
			<td class=\"centeredcellbold\">New Password</td>
			<td class=\"centeredcellbold\">Confirm Password</td>
			<td class=\"centeredcellbold\">--</td>
	
		</tr>
	
		<tr>
		
			<form action=\"./index.php?pageid=editUser\" method=\"POST\">
			<input type=\"hidden\" name=\"action\" value=\"savePassword\">
			<input type=\"hidden\" name=\"userid\" value=\"".$user->id."\">
			<td class=\"centeredcellbold\">--</td>
			<td class=\"centeredcell\"><input type=\"password\" name=\"newpass\"></td>
			<td class=\"centeredcell\"><input type=\"password\" name=\"confpass\"></th>
			<td class=\"centeredcell\"><input type=\"submit\" value=\"Save Password\"></td>
			</form>
	
		</tr>";
	}

	public function generateHTML(){

		$userid;
		
		if(isset($_GET['userid'])){
			$userid = $_GET['userid'];
		}
		else if(isset($_POST['userid'])){
			$userid = $_POST['userid'];
		}
		
		if(isset($userid)){

			$user = UserDao::getUserByID($userid);
			
			$passwordRows = "";
			if(Config::login_type == LOGIN_TYPE_DB){
				$passwordRows = $this->generatePasswordRows($user);
			}
	
			return $this->context->getErrorHTML().$this->context->getMessagesHTML()."<table class=\"userinfo\">
		
			<tr>
			
				<td colspan=4 class=\"header\">User Information</td>
			
			</tr>
		
			<tr>
	
				<td class=\"centeredcellbold\">Username</th>
				<td colspan=3 class=\"centeredcell\">".$user->username."</td>
				
			</tr>
		
			<tr>
				<form action=\"./index.php?pageid=editUser\" method=\"POST\">
				<input type=\"hidden\" name=\"action\" value=\"saveName\">
				<input type=\"hidden\" name=\"userid\" value=\"".$user->id."\">
				<td class=\"centeredcellbold\">Name</td>
				<td colspan=3 class=\"centeredcell\"><input type=\"text\" name=\"name\" size=\"25\" value=\"".$user->name."\"><input type=\"submit\" value=\"Save Name\"></td>
				</form>
				
			</tr>
			
			".$passwordRows."
		
			<tr>
				
				<td colspan=1 class=\"centeredcellbold\">Email</td>
				<form action=\"./index.php?pageid=editUser\" method=\"POST\">
				<input type=\"hidden\" name=\"action\" value=\"saveEmail\">
				<input type=\"hidden\" name=\"userid\" value=\"".$user->id."\">
				<td colspan=3 class=\"centeredcell\"><input type=\"text\" name=\"email\" size=30 value=\"".$user->email."\"><input type=\"submit\" value=\"Save Email\"></td>
				</form>
					
			</tr>
		
			<tr>
				
				<td colspan=1 class=\"centeredcellbold\">Userlevel</td>
				<form action=\"./index.php?pageid=editUser\" method=\"POST\">
				<td colspan=3 class=\"centeredcell\">
				<input type=\"hidden\" name=\"action\" value=\"saveUserLevel\">
				<input type=\"hidden\" name=\"userid\" value=\"".$user->id."\">
				".$this->generateUserLevelDropdown("level", $user->userlevel)."<input type=\"submit\" value=\"Save Level\"></td>
				</form>
					
			</tr>
	
			<tr>
			
				<td colspan=1 class=\"centeredcellbold\">Warnings</td>
				<td class=\"centeredcell\" colspan=2><a href=\"./index.php?pageid=viewWarnings&userid=".$user->id['user_id']."\">".WarningDao::getWarningCountForUserByType($user->id, RES_WARNING_ACTIVE)."(".WarningDao::getWarningCountForUser($user->id).")</a></td>
				<td class=\"centeredcell\" colspan=1><a href=\"./index.php?pageid=warnUser&userid=".$user->id."\">Warn User</a></td>
			
			</tr>
			
			<tr>
			
				<td colspan=4 class=\"centeredcellbold\">User Notes</th>
			
			</tr>
			
			<tr>
			
				<td colspan=4 class=\"centeredcellbold\">
				<br><form action=\"./index.php?pageid=editUser\" method=\"POST\">
				<input type=\"hidden\" name=\"action\" value=\"saveNotes\">
				<input type=\"hidden\" name=\"userid\" value=\"".$user->id."\">
				<textarea cols=60 rows=8 name=\"notes\">".$user->notes."</textarea>
				<br><input type=\"submit\" value=\"Save Notes\"></form></th>
			
			</tr>
				
		</table>";
		
		}else{
			$this->context->addError("No User Selected");
			return $this->context->getErrorHTML().$this->context->getMessagesHTML();
		}

	}

}

?>