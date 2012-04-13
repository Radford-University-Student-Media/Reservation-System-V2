<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class UserAdminBody extends Body{

	private $context;

	public function __construct($context){
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

	public function generateHTML(){

		$users = UserDao::getAllUsersOrderByName();
		
		$userOptions = "";
		foreach($users as $user){
			$userOptions = $userOptions."<option value=\"".$user->id."\">".$user->name."</option>";
		}
		
		return "<center><h3>Manage Users</h3></center>
	<center><form action=\"index.php\" method=\"GET\"><input type=\"hidden\" name=\"pageid\" value=\"editUser\"><select name=\"userid\" size=10>
	".$userOptions."
	</select><br><input type=\"button\" value=\"Create User\" onClick=\"window.location = './index.php?pageid=createUser'\"><input type=\"submit\" value=\"Edit\"></form></center>";;

	}

}

?>