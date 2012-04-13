<?php

require_once 'Page.php';
require_once './lib/DB/EquipmentDao.php';

class MoreInfoBody extends Body{

	public function getTitle(){
	
		return "More Information";
	
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getScriptsHTML(){
		return "";
	}

	public function generateHTML(){
	
		$equip = EquipmentDao::getEquipmentByID($_GET['equipid']);
		
		return "<center><h3>Equipment Info</h3></center>
	<table class=\"equipinfo\">
	
		<tr>
		
			<td colspan=2 class=\"header\">".$equip->name."</td>
		
		</tr>
	
		<tr>
			
			<td class=\"centeredcellbold\">Checkout Length</td>
			<td class=\"centeredcell\">".$equip->maxLength." Day(s) Max</td>
		
		</tr>
		
		<tr>
		
			<td class=\"centeredcell\"><img src=\"./getpicture.php?equip=".$equip->id."\"</td>
			<td class=\"topaligncell\">".$equip->description."</td>
				
		</tr>
			
		<tr>
		
			<td class=\"centeredcell\"><a href=\"./viewsched.php?equipid=".$equip->id."\" target=\"_blank\">View Schedule</a></td>
			<td class=\"centeredcell\"><a href=\"./index.php?pageid=reservation&equipid=".$equip->id."\">Reserve</a></td>
			
		</tr>
					
	</table>";
	
	}

}

?>