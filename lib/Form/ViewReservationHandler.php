<?php

require_once './lib/DB/ReservationDao.php';

require_once './lib/Util/Context.php';

class ViewReservationHandler{

	public function handleForm(Context $context, $action){
	
		if($action == "delete"){
				
			if(SessionUtil::getUserlevel() == RES_USERLEVEL_ADMIN){
				ReservationDao::deleteReservation($_POST['resid']);
			}else{
				$context->addError("Action Not Allowed (Userlevel)");
			}
		
		}else if($action == "checkin"){
			
			if(SessionUtil::getUserlevel() >= RES_USERLEVEL_LEADER){
				ReservationDao::updateReservationStatus($_POST['resid'], RES_STATUS_CHECKED_IN, false);
			}else{
				$context->addError("Action Not Allowed (Userlevel)");
			}
			
		}else if($action == "checkout"){
			
			if(SessionUtil::getUserlevel() >= RES_USERLEVEL_LEADER){
				ReservationDao::updateReservationStatus($_POST['resid'], RES_STATUS_CHECKED_OUT, false);
			}else{
				$context->addError("Action Not Allowed (Userlevel)");
			}
			
		}else if($action == "updateStatus"){
		
			if(SessionUtil::getUserlevel() == RES_USERLEVEL_ADMIN){
				ReservationDao::updateReservationStatus($_POST['resid'], $_POST['status'], true);
			}else{
				$context->addError("Action Not Allowed (Userlevel)");
			}
			
		}else{
		
			$context->addError("Incorrect Action.");
			
		}
	
	}

}

?>