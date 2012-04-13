<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Site/Page.php';

require_once './lib/Util/Context.php';
require_once './lib/Util/SessionUtil.php';

class PlaceReservationBody extends Body{

	private $context;
	
	public function __construct(Context $context){
		$this->context = $context;
	}
	
	public function getMinimumUserLevel(){
		return RES_USERLEVEL_USER;
	}
	
	public function getTitle(){

		return "Home";

	}

	public function getScriptsHTML(){
		return "
		<script type=\"text/javascript\">
			$(document).ready(function(){
				$('.date').datepicker();
				$('.date').datepicker( 'option', 'altField', '#startdate' );
				$('.date').datepicker( 'option', 'altFormat', 'yy-mm-dd' );
				$('.date').datepicker( 'option', 'defaultDate', +1 );
			})
		</script>
		<script type=\"text/javascript\">
			function checkDate(){

				if(document.reservation.startdate.value == \"".Database::CurrentMySQLDate()."\"){

					return confirm(\"Reservations placed on the same day as they are created cannot be guaranteed to be ready for their start date. By continuing you are acknowledging that. Would you like to continue?\");

				}else{
					return true;
				}

			}
		</script>";
	}

	public function generateHTML(){
		
		$user = UserDao::getUserByUsername(SessionUtil::getUsername());
		if(WarningDao::getWarningCountForUserByType($user->id, RES_WARNING_ACTIVE) > RES_WARNING_MAX_ACTIVE){
			$this->context->addError("You have too many Active Warnings (more than ".RES_WARNING_MAX_ACTIVE.") on your account to place Reservations.");
			return $this->context->getErrorHTML().$this->context->getMessagesHTML();
		}

		//TODO: do we need this?
		$allEquipment = EquipmentDao::getAllEquipment();
		$equipArray = array();
		//^^^^^^^^^^^^^^^^^^^^^^^^^^
		
		$page = "";
		$success = false;
		
		if(isset($_POST['equip_id']) && $_POST['equip_id'] != ""){
			if(count($this->context->getErrors()) == 0){
				$page = "Successfully Created Reservation.";
				$success = true;
			}else{
				$_GET['equipid'] = $_POST['equip_id'];
			}
		}
		
		if(!$success && isset($_GET['equipid']) && $_GET['equipid'] != ""){

			$equip = EquipmentDao::getEquipmentByID($_GET['equipid']);
			
			if($equip != null){
				
				if(SessionUtil::getUserlevel() >= $equip->minUserLevel){
				
				$lengthOptions = "";

				for($i = 1; $i <= $equip->maxLength; $i++){
					if($i > 1)
						$lengthOptions = $lengthOptions . "<option value=\"".$i."\">".$i." Days</option>";
					else
						$lengthOptions = $lengthOptions . "<option value=\"".$i."\">".$i." Day</option>";
				}
				
				$page = "

		<form name=\"reservation\" action=\"./index.php?pageid=placeReservation\" method=\"POST\" onsubmit=\"return checkDate();\">
		<input type=\"hidden\" name=\"action\" value=\"createReservation\">
		<input type=\"hidden\" name=\"equip_id\" value=\"".$_GET['equipid']."\">
		<table class=\"reservation\">
		
			<tr>
			
				<td colspan=4 class=\"header\">Reserve the ".$equip->name."</td>
			
			</tr>
		
			<tr>
			
				<td class=\"centeredcellbold\">Date (YYYY-MM-DD)</td>
				<td class=\"centeredcell\">
					<input type=\"text\" readonly name=\"start_date\" id=\"startdate\" class=\"date\" value=\"blah\"/>
				</td>
				<td class=\"centeredcellbold\">Length</td>
				<td class=\"centeredcell\"><select name=\"length\">".$lengthOptions."</select></td>
		
			</tr>

			<tr>
			
				<td colspan=1 class=\"centeredcellbold\">User Comment</th>
				<td class=\"centeredcell\" colspan=3><textarea rows=5 cols=45 name=\"user_comment\"></textarea></td>
			
			</tr>
				
				<tr>
				
					<td colspan=4 class=\"centeredcell\"><input type=\"submit\" value=\"Reserve\"></td>
		
				</tr>
				
			</table>
			</form></div>";
				
				}else{
					$this->context->addError("Cannot reserve equipment (User Level).");
				}
				
			}else{
				$this->context->addError("No equipment with ID '".$_GET['equipid']."'.");
			}
			
		}else{
			
			if(!$success)
				$this->context->addError("No equipment selected.");
			
		}
		
		return "<center><h3>Place Reservation</h3>".$this->context->getErrorHTML()."</center>".$page;

	}

}

?>