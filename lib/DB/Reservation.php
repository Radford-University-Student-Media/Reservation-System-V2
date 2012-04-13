<?php

class Reservation{
	
	public $id;
	public $equipId;
	public $userId;
	public $startDate;
	public $endDate;
	public $checkedOutBy;
	public $checkOutDate;
	public $checkedInBy;
	public $checkedInDate;
	public $length;
	public $userComment;
	public $adminComment;
	public $modStatus;
	
	public function __construct($id, $equipId, $userId, $startDate, $endDate,
		$checkedOutBy, $checkedOutDate, $checkedInBy, $checkedInDate, $length,
		$userComment, $adminComment, $modStatus){
		
		$this->id = $id;
		$this->equipId = $equipId;
		$this->userId = $userId;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->checkedOutBy = $checkedOutBy;
		$this->checkedOutDate = $checkedOutDate;
		$this->checkedInBy = $checkedInBy;
		$this->checkedInDate = $checkedInDate;
		$this->length = $length;
		$this->userComment = $userComment;
		$this->adminComment = $adminComment;
		$this->modStatus = $modStatus;
		
	}
	
	public function getModStatus(){
		return $this->modStatus;
	}
	
	public function getModStatusString(){
		
		return Reservation::modStatusToString($this->modStatus);
	}
	
	public function getColoredModStatusString(){
		
		$statusString = Reservation::modStatusToString($this->modStatus);
		
		if($this->modStatus == RES_STATUS_CONFIRMED)
			$status = "<font color=\"#005500\">".$statusString."</font>";
		else if($this->modStatus == RES_STATUS_CHECKED_OUT)
			$status = "<font color=\"#005500\">".$statusString."</font>";
		else if($this->modStatus == RES_STATUS_CHECKED_IN)
			$status = "<font color=\"#005500\">".$statusString."</font>";
		else if($this->modStatus == RES_STATUS_PENDING)
			$status = $statusString;
		else if($this->modStatus == RES_STATUS_DENIED)
			$status = "<font color=\"#FF0000\">".$statusString."</font>";
		else
			$status = "<font color=\"#FF0000\">".$statusString."</font>";
		
		return $status;
	}
	
	public static function modStatusToString($status){
		if($status == RES_STATUS_PENDING){
		
			$status = "Pending";
		
		}
		else if($status == RES_STATUS_CONFIRMED){
		
			$status = "Approved";
		
		}
		else if($status == RES_STATUS_DENIED){
		
			$status = "Denied";
		
		}
		else if($status == RES_STATUS_CHECKED_IN){
		
			$status = "Checked-In";
		
		}
		else if($status == RES_STATUS_CHECKED_OUT){
			$status = "Checked-Out";
		}else{
			$status = "Unknown";
		}
		
		return $status;
	}

}

?>