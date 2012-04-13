<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class OurEquipBody extends Body{

	private $context;
	
	public function __construct($context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getTitle(){

		return "Home";

	}

	public function getScriptsHTML(){
		return "";
	}

	//TODO: Implement equipment statuses
	private function getEquipmentTable($equipKeys, $equipArray){
		$ourequipment = "";
		foreach($equipKeys as $key){
		
			$ourequipment = $ourequipment . "<h3>".$key."</h3><table class=\"ourequip\">
				
					<tr>
					
						<td width=\"40%\" class=\"header\" id=\"".$key."\">Equipment Name</th>
						<td width=\"15%\"  class=\"header\">--</th>
						<td width=\"25%\" class=\"header\">Status</th>
						<td width=\"20%\" class=\"header\">--</th>
						
					</tr>";
		
			foreach($equipArray[$key] as $row){
		
				$status = "-";
				
				/*
					The current piece of equipment is NOT at Calhoun
				*/
				//if(isEquipmentOut($row['equip_id'], getCurrentMySQLDate())){
					//$status = "Out";
				//}
		
				/*
					The current piece of equipment will be out of Calhoun in a few days
				-For exact length see isEquipmentReserved() in functions.php
				*/
				//else if(isEquipmentReserved($row['equip_id'], getCurrentMySQLDate())){
					//$status = "Reserved";
				//}
		
				//else{
					//$status = "Available";
				//}
		
				/*
					Check logged in user's user level against the equipments min user level
				*/
				if(SessionUtil::getUserlevel() >= $row->minUserLevel){
					
					if($row->checkOutFrom == -1){
						
						$ourequipment = $ourequipment . "<tr><td class=\"centeredcell\">".$row->name."</td><td class=\"centeredcell\"><a href=\"./index.php?pageid=moreInfo&equipid=".$row->id."\">More Info</a></td><td class=\"centeredcell\">".$status."</td><td class=\"centeredcell\"><a href=\"./index.php?pageid=placeReservation&equipid=".$row->id."\">Reserve</a></td></tr>";
		
					}else{
							
						$user = UserDao::getUserByID($row->checkOutFrom);
							
						$ourequipment = $ourequipment . "<tr><td class=\"centeredcell\">".$row->name."</td><td class=\"centeredcell\"><a href=\"./index.php?pageid=moreInfo&equipid=".$row->id."\">More Info</a></td><td class=\"centeredcell\" colspan=2>Checkout from<br><a href=\"mailto:".$user->email."\">".$user->name."</a></td></tr>";
							
					}
						
				}
		
		
			}
		
			$ourequipment = $ourequipment . "</table>";
		
		}
		
		return $ourequipment;
	}
	
	public function generateHTML(){

		$allEquipment = EquipmentDao::getAllEquipment();
		$equipArray = array();

		foreach($allEquipment as $equip){
			if(array_key_exists($equip->type, $equipArray)){
			
				array_push($equipArray[$equip->type], $equip);
			
			}else{
			
				$equipArray[$equip->type] = array($equip->type => $equip);
			
			}
		}

		$equipKeys = array_keys($equipArray);
		$typelinks = "";

		$i = 0;
		foreach($equipKeys as $key){

			$typelinks = $typelinks . "<a href=\"#".$key."\">".$key."</a>";

			if($i+1 < count($equipKeys)){

				$typelinks = $typelinks . " - ";
				$i++;

			}

		}
		
		return "<center><h3>Our Equipment</h3></center>
		<center><b>".$typelinks."</b></center>".$this->getEquipmentTable($equipKeys, $equipArray);

	}

}

?>