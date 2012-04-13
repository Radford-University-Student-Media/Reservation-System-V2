<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Site/Body.php';

class MyAccountBody extends Body{

	private $context;

	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}

	function getTitle(){
		return "My Account";
	}

	function getScriptsHTML(){
		return "";
	}

	function generateHTML(){

		$user = UserDao::getUserByUsername(SessionUtil::getUsername());

		$changePasswordRows = "";
		if(Config::login_type == LOGIN_TYPE_DB){
			$changePasswordRows = "
			
			<tr>
				
				<td class=\"centeredcellbold\">Change Password</td>
				<td class=\"centeredcellbold\">Current Password</td>
				<td class=\"centeredcellbold\">New Password</td>
				<td class=\"centeredcellbold\">Confirm Password</td>
		
			</tr>
			
			<tr>
				
					<form action=\"./index.php?pageid=savepassword\" method=\"POST\"><td class=\"centeredcellbold\"><input type=\"submit\" value=\"Save Password\"></td>
					<td class=\"centeredcell\"><input type=\"password\" name=\"curpass\"></td>
					<td class=\"centeredcell\"><input type=\"password\" name=\"newpass\"></th>
					<td class=\"centeredcell\"><input type=\"password\" name=\"confpass\"></td></form>
			
				</tr>";
		}

		return "<center><h3>My Account</h3>".$this->context->getErrorHTML()."</center>
			
			<table class=\"myaccount\">
			
				<tr>
				
					<td colspan=4 class=\"header\">Edit User Information</td>
				
				</tr>
				
				<tr>
		
					<td class=\"centeredcellbold\">Username</td>
					<td colspan=3 class=\"centeredcell\">".$user->username."</td>
					
				</tr>
			
				<tr>
		
					<td class=\"centeredcellbold\">Name</th>
					<td colspan=3 class=\"centeredcell\">".$user->name."</td>
					
				</tr>
			
				".$changePasswordRows."
			
				<tr>
					
					<form action=\"./index.php?pageid=saveemail\" method=\"POST\">
					<td colspan=1 class=\"centeredcellbold\">Email</th><td colspan=3 class=\"centeredcell\"><input type=\"text\" name=\"email\" size=30 value=\"".$user->email."\"><input type=\"submit\" value=\"Save Email\"></td></form>
						
				</tr>
		
				<tr>
				
					<td colspan=1 class=\"centeredcellbold\">Warnings</th>
					<td class=\"centeredcellbold\" colspan=3><a href=\"./index.php?pageid=viewMyWarnings\">".WarningDao::getWarningCountForUserByType($user->id, RES_WARNING_ACTIVE)."(".WarningDao::getWarningCountForUser($user->id).")</a></td>
				
				</tr>
					
			</table>";

	}

}