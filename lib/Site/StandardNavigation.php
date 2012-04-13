<?php

require_once './lib/Site/Navibutton.php';
require_once './lib/Site/Navigation.php';

require_once './lib/Util/SessionUtil.php';

class StandardNavigation extends Navigation{

	private $context;

	public function __construct($context){
	
		$this->context = $context;
	
	}

	public function generateHTML(){
	
		if(SessionUtil::isLoggedIn()){
	
			$userlevel = SessionUtil::getUserlevel();
			$navi = "";
			if($userlevel == RES_USERLEVEL_NOLOGIN){
			
				$navi = $navi . "<tr><td class=\"navi\">
							<a href=\"./index.php?pageid=logout\" class=\"navi\">Logout</a>
						</td></tr>";
			
			}
			if($userlevel > RES_USERLEVEL_NOLOGIN){
			
				$navi = $navi . "<tr><td class=\"navi\">
							<a href=\"./index.php?pageid=home\" class=\"navi\">Home</a> - 
							<a href=\"./index.php?pageid=ourEquip\" class=\"navi\">Our Equipment</a> - 
							<a href=\"./index.php?pageid=myAccount\" class=\"navi\">My Account</a> - 
							<a href=\"./index.php?pageid=logout\" class=\"navi\">Logout</a>
						</td></tr>";
			
			}
			if($userlevel == 3){
			
				$navi = $navi . "<tr>
						<td class=\"adminnaviouter\">
							<table cellpadding=0 cellspacing=0 border=0 class=\"adminnavi\">
								<tr>
									<td class=\"adminnaviinner\">
										&nbsp;&nbsp<a href=\"./index.php?pageid=browseres\" class=\"navi\">Browse Reservations</a>&nbsp;&nbsp
									</td>
								</tr>
							</table>
						</td>";
			
			}
			if($userlevel >= RES_USERLEVEL_ADMIN){
			
				$navi = $navi . "<tr>
					
						<td class=\"adminnaviouter\">
							<table cellpadding=0 cellspacing=0 border=0 class=\"adminnavi\">
								<tr>
									<td class=\"adminnaviinner\">
										&nbsp;&nbsp;<a href=\"./index.php?pageid=userAdmin\" class=\"navi\">Users</a> - 
										<a href=\"./index.php?pageid=manageequip\" class=\"navi\">Equipment</a> - 
										<a href=\"./index.php?pageid=browseres\" class=\"navi\">Browse Reservations</a> - 
										<a href=\"./index.php?pageid=makeres\" class=\"navi\">Make Reservation</a> - 
										<a href=\"./index.php?pageid=manageblackouts\" class=\"navi\">Blackouts</a> - 
										<a href=\"./index.php?pageid=messages\" class=\"navi\">Messages</a>&nbsp;&nbsp;
									</td>
								</tr>
							</table>
						</td>
						
					</tr>";
			
			}
			
			return $navi;
		
		}
	
	}

}

?>