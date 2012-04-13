<?php

require_once './lib/DB/UserDao.php';
require_once './lib/Util/Context.php';

class CreateUserHandler{

	public function handleForm(Context $context, $action){

		if($action == "createUser"){

			if((isset($_POST['username']) && $_POST['username'] != "")
			&& (isset($_POST['userlevel']) && $_POST['userlevel'] != "")
			&& (isset($_POST['name']) && $_POST['name'] != "")
			&& (isset($_POST['email']) && $_POST['email'] != "")){

				$password = "";
				if(Config::login_type == LOGIN_TYPE_DB)
					$password = CryptoUtil::generatePassword(9,4);
				
				UserDao::createUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['userlevel'], $password);
				
				$message = "Created User -- Username: ".$_POST['username'];
				if(Config::login_type == LOGIN_TYPE_DB)
					$message .= " Password: ".$password;
				
				$context->addMessage($message);
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else{

			$context->addError("Incorrect Action.");

		}

	}

}

?>
