<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class CreateUserBody extends Body{

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

	private function generateUserLevelDropdown($formName, $selectedLevel = RES_USERLEVEL_USER){
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

	public function generateHTML(){

		
		
		return "<center><h3>Create User (".strtoupper(Config::login_type).")</h3></center>".$this->context->getErrorHTML().$this->context->getMessagesHTML()."<table class=\"userinfo\">
	
			<form action=\"./index.php?pageid=createUser\" method=\"POST\">
			<input type=\"hidden\" name=\"action\" value=\"createUser\"
			<tr>
				<td colspan=\"4\" class=\"header\">User Info</td>
			</tr>
			<tr>
				<td class=\"centeredcellbold\">Name</td>
				<td class=\"centeredcell\"><input type=\"text\" name=\"name\" /></td>
				<td class=\"centeredcellbold\">Username</td>
				<td class=\"centeredcell\"><input type=\"text\" name=\"username\" /></td>
			</tr>
				<td class=\"centeredcellbold\">Email</td>
				<td class=\"centeredcell\"><input type=\"text\" name=\"email\" /></td>
				<td class=\"centeredcellbold\">Userlevel</td>
				<td class=\"centeredcell\">".$this->generateUserLevelDropdown("userlevel")."</td>
			<tr>
				<td colspan=\"4\" class=\"centeredcell\"><input type=\"submit\" value=\"Create!\" /></td>
			</tr>
			</form>
			
		</table>";

	}

}

?>