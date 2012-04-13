<?php

class Equipment{
	
	public $id;
	public $name;
	public $type;
	public $serial;
	public $description;
	public $maxLength;
	public $picture;
	public $minUserLevel;
	public $checkOutFrom;
	
	public function __construct($id, $name, $type, $serial, $description,
		$maxLength, $picture, $minUserLevel, $checkOutFrom){
		
		$this->id = $id;
		$this->name = $name;
		$this->type = $type;
		$this->serial = $serial;
		$this->description = $description;
		$this->maxLength = $maxLength;
		$this->picture = $picture;
		$this->minUserLevel = $minUserLevel;
		$this->checkOutFrom = $checkOutFrom;
		
	}	
	
	public function __toString(){
		return "<a href=\"./index.php?pageid=moreInfo&equipid=".$this->id."\">".$this->name."</a>";
	}
}

?>