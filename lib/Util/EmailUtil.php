<?php

require_once './lib/DB/Reservation.php';
require_once './lib/DB/User.php';
require_once './lib/DB/UserDao.php';
require_once './lib/DB/Warning.php';



class EmailUtil{

	private static $emailFunction;
	
	public static function setEmailFunction($function){
		$emailFunction = $function;
	}
	
	private static function getEmailFunction(){
		if(isset($emailFunction)){
			return $emailFunction;
		}else{
			return create_function('$to, $subject, $body','mail($to, $subject, $body);');
		}
	}
	
	public static function sendEmail($to, $subject, $body){
		$emailFunction = EmailUtil::getEmailFunction();
		$emailFunction($to, $subject, $body);
	}
	
	public static function sendUpdateReservationNotice(User $user, Reservation $reservation){
		$body = "Your reservation has been updated to ".$reservation->getModStatusString().".".
		"You can view your reservation at: ".Config::location."index.php?pageid=viewReservation&resid=".$reservation->id;
		
		EmailUtil::sendEmail($user->email, "Reservation Updated", $body);
	}
	
	public static function sendNewReservationNotices(User $user, Reservation $reservation){
	
		EmailUtil::sendReservationNoticeToAdmins($reservation);
	
	}

	public static function sendNewReservationNoticeToAdmins(Reservation $reservation){
		
		
		$body = "A new reservation has been created and is awaiting approval.".
				"You can view the reservation at: ".Config::location."index.php?pageid=viewReservation&resid=".$reservation->id;
		
		EmailUtil::sendEmail($user->email, "New Reservation Notice", $body);
	}
	
	public static function sendWarningNoticeToUser(Warning $warning){
		$user = UserDao::getUserByID($warning->userId);
		if($warning->type == RES_WARNING_NOTE){
			$body = "You have been issued a Notification, you can view it at: ".Config::location."index.php?pageid=viewWarning&warnid=".$warning->id;
			EmailUtil::sendEmail($user->email, "New Notification", $body);
		}else{
			$body = "You have been issued an ".$warning->getTypeString()." Warning, you can view it at: ".Config::location."index.php?pageid=viewWarning&warnid=".$warning->id;
			EmailUtil::sendEmail($user->email, "New ".$warning->getTypeString()." Warning Notice", $body);
		}
	}

}
?>