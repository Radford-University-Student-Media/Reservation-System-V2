<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class WarnUserBody extends Body{

	private $context;

	public function __construct(Context $context){
		$this->context = $context;
	}

	public function getMinimumUserLevel(){
		return RES_USERLEVEL_ADMIN;
	}

	public function getTitle(){

		return "Warn User";

	}

	public function getScriptsHTML(){
		return "";
	}

	public function generateHTML(){

		if(isset($_GET['userid'])){
			$userId = $_GET['userid'];
		}else if(isset($_POST['userId'])){
			$userId = $_POST['userId'];
		}else{
			$this->context->addError("No user selected.");
			return $this->context->getErrorHTML().$this->context->getMessagesHTML();
		}
		
		$user = UserDao::getUserByID($userId);

		return "<center><h3>Create Warning For ".$user."</h3></center>".
		$this->context->getErrorHTML().$this->context->getMessagesHTML().
		"<br /><form action=\"./index.php?pageid=warnUser\" method=\"POST\">
		<input type=\"hidden\" name=\"action\" value=\"createWarning\">
		<input type=\"hidden\" name=\"userId\" value=\"".$user->id."\">
			<table class=\"warning\">
			
				<tr>
				
					<td colspan=2 class=\"header\">Warn Reason</td>
					
				</tr>
				
				<tr>
				
					<td colspan=2 class=\"centeredcellbold\"><textarea cols=\"55\" rows=\"7\" name=\"reason\"></textarea></td>
				
				</tr>
				
				<tr>
				
					<td class=\"centeredcell\"><select name=\"type\"><option value=\"1\">Active</option><option value=\"2\">Notification</option><option value=\"3\">Inactive</option></select></td>
					<td class=\"centeredcell\"><input type=\"submit\" value=\"Warn\"></textarea></td>
				
				</tr>
			
			</table>
		
		</form>";

	}

}

?>