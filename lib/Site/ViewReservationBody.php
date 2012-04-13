<?php

require_once './lib/Site/Page.php';
require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

class ViewReservationBody extends Body{

	private $context;
	
	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getTitle(){
	
		return "View Reservation";
	
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getScriptsHTML(){
		return "";
	}
	
	private function getCheckinCell(Reservation $reservation){
		if(SessionUtil::getUserlevel() >= RES_USERLEVEL_LEADER){
			$checkinCell = "&nbsp;-&nbsp;";
			
			if($reservation->modStatus == RES_STATUS_CONFIRMED){
			
				$checkinCell = "<input type=\"hidden\" value=\"checkout\" name=\"action\">
							<input type=\"hidden\" value=\"".$reservation->id."\" name=\"resid\">
							<input type=\"submit\" value=\"Check Out\">";
			
			}else if($reservation->modStatus == RES_STATUS_CHECKED_OUT){
			
				$checkinCell = "<input type=\"hidden\" value=\"checkin\" name=\"action\">
							<input type=\"hidden\" value=\"".$reservation->id."\" name=\"resid\">
							<input type=\"submit\" value=\"Check In\">";
			
			}
			return $checkinCell;
		}else{
			return "";
		}
	}
	
	private function getCheckinRow(Reservation $reservation){
		if(SessionUtil::getUserlevel() == RES_USERLEVEL_ADMIN){
			return "<tr>
					
					<form action=\"./index.php?pageid=viewReservation\" method=\"POST\">
					<td class=\"centeredcellbold\">
					".$this->getCheckinCell($reservation)."
					</td>
					</form>
					<form action=\"./index.php?pageid=viewReservation\" method=\"POST\" onSubmit=\"return confirm('Are you sure you want to delete this reservation?')\">
					<td class=\"centeredcellbold\">
						<input type=\"hidden\" value=\"delete\" name=\"action\">
						<input type=\"hidden\" value=\"".$reservation->id."\" name=\"resid\">
						<input type=\"submit\" value=\"Delete\">
					</td>
					</form>
					<form action=\"./index.php?pageid=viewReservation\" method=\"POST\">
					<td class=\"centeredcellbold\">
						<input type=\"hidden\" value=\"".$reservation->id."\" name=\"resid\">
						<select name=\"status\">
							<option value=\"".RES_STATUS_CONFIRMED."\">Approve</option>
							<option value=\"".RES_STATUS_DENIED."\">Deny</option>
						</select>
					</td>
					<td class=\"centeredcellbold\">
						<input type=\"hidden\" value=\"updateStatus\" name=\"action\">
						<input type=\"hidden\" value=\"".$reservation->id."\" name=\"resid\">
						<input type=\"submit\" value=\"Update\">
					</td>
					</form>
					
				</tr>";
		}else{
			return "";
		}
	}

	public function generateHTML(){
	
		$reservation = ReservationDao::getReservation($_GET['resid']);
		
		if($reservation == null){
			$this->context->addError("Reservation Doesn't Exist.");
			return $this->context->getErrorHTML();
		}
		
		$user = UserDao::getUserByID($reservation->userId);
		$equip = EquipmentDao::getEquipmentByID($reservation->equipId);
		
		return "
			<center><h3>Reseravation Info</h3></center>
			<table class=\"viewreservation\">
				<tr>
					
					<td colspan=4 class=\"header\">User Information</td>
					
				</tr>
				<tr>
			
					<td class=\"centeredcellbold\">Name</th>
					<td class=\"centeredcell\">".$user."</td>
					<td class=\"centeredcellbold\">Warnings</th>
					<td class=\"centeredcell\"><a href=\"./index.php?pageid=viewWarnings&userid=".$user->id['user_id']."\">".WarningDao::getWarningCountForUserByType($user->id, RES_WARNING_ACTIVE)."(".WarningDao::getWarningCountForUser($user->id).")</a></td>
					
				</tr>
				<tr>
					
					<td colspan=4 class=\"header\">Equipment Information</td>
					
				</tr>
				<tr>
					
					<td colspan=2 class=\"centeredcellbold\">Name</th>
					<td colspan=2 class=\"centeredcell\">".$equip."</td>
					
				</tr>
				<tr>
					
					<td colspan=4 class=\"header\">Reservation Information</td>
				
				</tr>
				<tr>
				
					<td class=\"centeredcellbold\">Start Date</td>
					<td class=\"centeredcell\">".$reservation->startDate."</td>
					<td class=\"centeredcellbold\">End Date</td>
					<td class=\"centeredcell\">".$reservation->endDate."</td>
					
				</tr>
				<tr>
					<td colspan=4 class=\"centeredcellbold\">Current Status: ".$reservation->getColoredModStatusString()."</td>
				</tr>
				<tr>
					
					<td colspan=4 class=\"centeredcellbold\">User Comment</td>
					
				</tr>
				<tr>
					
					<td colspan=4 class=\"topaligncell\">&nbsp;".$reservation->userComment."</td>
					
				</tr>
				<tr>
					
					<td colspan=4 class=\"centeredcellbold\">Admin Comment</td>
					
				</tr>
				<tr>
					
					<td colspan=4 class=\"topaligncell\">&nbsp;".$reservation->adminComment."</td>
					
				</tr>
				".$this->getCheckinRow($reservation)."
			
			</table>
		
		";
	
	}

}

?>