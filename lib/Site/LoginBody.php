<?php

require_once './lib/Site/Page.php';
require_once 'OfficeHourCalendar.php';

class LoginBody extends Body{

	private $context;

	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_NOLOGIN;
	}
	
	public function getTitle(){
	
		return "Login";
	
	}

	public function getScriptsHTML(){
		if(!isset($_POST['redir']))
			return "<script type=\"text/javascript\">window.onload = function(){document.loginform.redir.value = window.location;document.loginform.username.focus()};</script>";
		else{
			return "<script type=\"text/javascript\">window.onload = function(){document.loginform.redir.value = '".$_POST['redir']."';document.loginform.username.focus()};</script>";
		}
	}

	public function generateHTML(){
	
		return $this->context->getErrorHTML()."<center><h3>Welcome!</h3>
		<font color=\"#FF0000\"></font></center>
	
		<form action=\"./index.php\" method=\"POST\" name=\"loginform\">
		<input type=\"hidden\" name=\"redir\" value=\"\">
		<input type=\"hidden\" name=\"pageid\" value=\"login\">
		<input type=\"hidden\" name=\"action\" value=\"login\">
			<table class=\"login\">
				<tr>
					<td colspan=2 class=\"header\">User Login</td>
				</tr>
				<tr>
					<td class=\"centeredcellbold\">Username</td>
					<td class=\"centeredcell\"><input type=\"text\" name=\"username\"></td>
				</tr>
				<tr>
					<td class=\"centeredcellbold\">Password</td>
					<td class=\"centeredcell\"><input type=\"password\" name=\"password\"></td>
				</tr>
				<tr>
					<td colspan=2 class=\"centeredcellbold\"><input type=\"submit\" value=\"Login\"></td>
				</tr>
			</table>
		
		</form></centered>".OfficeHourCalendar::HTML;
	
	}

}

?>