<?php

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Util/Context.php';
require_once './lib/Util/DateUtil.php';
require_once './lib/Util/SessionUtil.php';

class PlaceReservationHandler{

	public function handleForm(Context $context, $action){
		
		if($action == "createReservation"){
			
			if((isset($_POST['equip_id']) && $_POST['equip_id'] != "") &&
			(isset($_POST['start_date']) && $_POST['start_date'] != "") &&
			(isset($_POST['length']) && $_POST['length'] != "")){
				
				$equipId = $_POST['equip_id'];
				$equip = EquipmentDao::getEquipmentByID($equipId);
				
				if($equip != null){
					
					if(SessionUtil::getUserlevel() >= $equip->minUserLevel){
						
						$startDate = $_POST['start_date'];
						$endDate = DateUtil::incrementDate($startDate, $_POST['length']);
						
						$reservations = ReservationDao::getReservationsForEquipmentByDate($equipId, $startDate, $endDate);
						
						if(count($reservations) == 0){
							
							$user = UserDao::getUserByUsername(SessionUtil::getUsername());
							
							$reservation = ReservationDao::createReservation($user->id, $equipId, $_POST['length'], $startDate, $endDate, $_POST['user_comment']);
							
							EmailUtil::sendNewReservationNotices($user, $reservation);
							
						}else{
							$context->addError("Reservations already exist during selected dates ($startDate and $endDate).");
						}
						
					}else{
						$context->addError("Cannot reserve equipment (User Level).");
					}
					
				}else{
					$context->addError("No such equipment.");
				}
				
			}else{
				$context->addError("Required Field Left Blank.");
			}
			
		}else{
			$context->addError("Incorrect Action.");
		}
		
	}
}

?>