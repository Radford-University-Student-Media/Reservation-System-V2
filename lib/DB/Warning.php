<?php

class Warning {
	
	public $id;
	public $userId;
	public $reason;
	public $type;
	public $datetime;
	
	public function __construct($id, $userId, $reason, $type, $datetime){
		$this->id = $id;
		$this->userId = $userId;
		$this->reason = $reason;
		$this->type = $type;
		$this->datetime = $datetime;
	}
	
	public function getTypeString(){
		$typeMapping = array(RES_WARNING_ACTIVE => "Active", RES_WARNING_NOTE => "Note", RES_WARNING_INACTIVE => "Inactive");
		return $typeMapping[$this->type];
	}
	
	public function toOptionHTML(){
		return "<option value=\"".$this->id."\">".$this->datetime." - ".$this->getTypeString()."</option>";
	}
	
}

?>