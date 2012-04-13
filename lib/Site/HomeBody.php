<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class HomeBody extends Body{

	public function getTitle(){
	
		return "Home";
	
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_NOLOGIN;
	}
	
	public function getScriptsHTML(){
		return "";
	}

	public function generateHTML(){
	
		$username = SessionUtil::getUsername();
		$user = UserDao::getUserByUsername($username);
		$reservations = ReservationDao::getReservationsForUser($user->id, 5);
		
		$reservationHTML = "";
		foreach($reservations as $res){
			$status = $res->getModStatusString();
			$equipment = EquipmentDao::getEquipmentByID($res->equipId);
			$reservationHTML = $reservationHTML . 
				"<tr>
			
					<td class=\"myequip".$status."\">".$equipment->name."</td>
					<td class=\"myequip".$status."\">".$status."</td>
					<td class=\"myequip".$status."\">".$res->startDate."</td>
					<td class=\"myequip".$status."\">".$res->endDate."</td>
					<td class=\"myequip".$status."\"><a href=\"./index.php?pageid=viewReservation&resid=".$res->id."\">View</a></td>
						
				</tr>";
			
		}
		
		return OfficeHourCalendar::HTML."<h3>Your Reservations</h3>
		
		<table class=\"myequip\">
		
			<tr>
		
				<td class=\"header\">Equipment Name</td>
				<td class=\"header\">Status</td>
				<td class=\"header\">Check-out Date</td>
				<td class=\"header\">Due Date</td>
				<td class=\"header\">-</td>
			
			</tr>
			
			".$reservationHTML."
	
		</table>";
	
	}

}

?>