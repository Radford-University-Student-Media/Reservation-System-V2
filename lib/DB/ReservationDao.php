<?php

require_once './lib/DB/Database.php';
require_once './lib/DB/Reservation.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Util/EmailUtil.php';

class ReservationDao{
	
	const table_name = 'reservations';
	
	public static function createReservation($userId, $equipId, $length, $startDate, $endDate, $userComment){
		$userId = Database::makeStringSafe($userId);
		$equipId = Database::makeStringSafe($equipId);
		$length = Database::makeStringSafe($length);
		$startDate = Database::makeStringSafe($startDate);
		$endDate = Database::makeStringSafe($endDate);
		$userComment = Database::makeStringSafe($userComment);
		
		Database::doQuery("INSERT INTO ".Database::addPrefix(ReservationDao::table_name).
		" SET user_id = '$userId', equip_id = '$equipId', length = '$length',".
		" start_date = '$startDate', end_date = '$endDate', user_comment = '$userComment'");
		
		return ReservationDao::getReservation(mysql_insert_id()); 
	}
	
	public static function deleteReservation($resId){
		
		Database::doQuery("DELETE FROM ".Database::addPrefix(ReservationDao::table_name).
		" WHERE res_id = '".Database::makeStringSafe($resId)."'");
		
	}
	
	public static function updateReservationStatus($resId, $status, $sendEmail){
		Database::doQuery("UPDATE ".Database::addPrefix(ReservationDao::table_name).
		" SET mod_status = '".Database::makeStringSafe($status)."'".
		" WHERE res_id = '".Database::makeStringSafe($resId)."'");
		
		if($sendEmail){
			$reservation = ReservationDao::getReservation($resId);
			$user = UserDao::getUserByID($reservation->userId);
			EmailUtil::sendUpdateReservationNotice($user, $reservation);
		}
	}
	
	public static function getReservation($resId){
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(ReservationDao::table_name)." WHERE res_id = '".Database::makeStringSafe($resId)."'");
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_assoc($result);
			return new Reservation($row['res_id'], $row['equip_id'], $row['user_id'], $row['start_date'], $row['end_date'], $row['checked_out_by'], $row['check_out_date'], $row['checked_in_by'], $row['check_in_date'], $row['length'], $row['user_comment'], $row['admin_comment'], $row['mod_status']);
		}else{
			return null;
		}
	}
	
	public static function getReservationsForUser($userId, $limit = 5){
		
		$result = Database::doQuery("SELECT * FROM ".Database::addPrefix(ReservationDao::table_name)." WHERE user_id = '".Database::makeStringSafe($userId)."' LIMIT ".Database::makeStringSafe($limit));
		
		$reservations = array();
		
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$reservations[] = new Reservation($row['res_id'], $row['equip_id'], $row['user_id'], $row['start_date'], $row['end_date'], $row['checked_out_by'], $row['check_out_date'], $row['checked_in_by'], $row['check_in_date'], $row['length'], $row['user_comment'], $row['admin_comment'], $row['mod_status']);
			}
		}
		
		return $reservations;
		
	}
	
	public static function getReservationsForEquipmentByDate($equipId, $startDate, $endDate){
		$equipId = Database::makeStringSafe($equipId);
		
		$query = "SELECT * FROM ".Database::addPrefix(ReservationDao::table_name)." WHERE equip_id = '".$equipId."'".
		" AND (('$startDate' BETWEEN start_date AND end_date) OR ('$endDate' BETWEEN start_date AND end_date))";
		
		echo $query;
		
		$result = Database::doQuery($query);
		
		$reservations = array();
		
		if(mysql_num_rows($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$reservations[] = new Reservation($row['res_id'], $row['equip_id'], $row['user_id'], $row['start_date'], $row['end_date'], $row['checked_out_by'], $row['check_out_date'], $row['checked_in_by'], $row['check_in_date'], $row['length'], $row['user_comment'], $row['admin_comment'], $row['mod_status']);
			}
		}
		
		return $reservations;
		
	}

}

?>