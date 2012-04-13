<?php

require_once 'OfficeHourCalendar.php';

require_once './lib/DB/EquipmentDao.php';
require_once './lib/DB/ReservationDao.php';
require_once './lib/DB/UserDao.php';

require_once './lib/Site/Page.php';

class AdminWarningBody extends Body{

	private $context;

	public function __construct(Context $context){
		$this->context = $context;
	}

	public function getMinimumUserLevel(){
		return RES_USERLEVEL_ADMIN;
	}

	public function getTitle(){

		return "Warning Admin";

	}

	public function getScriptsHTML(){
		return "";
	}

	public function generateHTML(){



		return "<center><h3>Warning Admin</h3></center>".
		$this->context->getErrorHTML().$this->context->getMessagesHTML();

	}

}

?>