<?php

require_once './lib/DB/UserDao.php';
require_once './lib/Util/Context.php';

class EditUserHandler{

	public function handleForm(Context $context, $action){

		//TODO: Check user level >= ADMIN
		if($action == "savePassword"){

			if((isset($_POST['newpass']) && $_POST['newpass'] != "")
			&& (isset($_POST['confpass']) && $_POST['confpass'] != "")){

				$newPassword = $_POST['newpass'];
				$confirmPassword = $_POST['confpass'];

				if($newPassword = $confirmPassword){

					UserDao::updateUserPassword($_POST['userid'], $newPassword);
					$context->addMessage("Password Successfully Changed.");

				}else{
					$context->addError("Passwords Don't Match.");
				}
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else if($action == "saveEmail"){

			if((isset($_POST['email']) && $_POST['email'] != "")){

				$email = $_POST['email'];
				UserDao::updateUserEmail($_POST['userid'], $email);
				$context->addMessage("Email Successfully Changed.");
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else if($action == "saveUserLevel"){

			if((isset($_POST['level']) && $_POST['level'] != "")){

				$userlevel = $_POST['level'];
				UserDao::updateUserLevel($_POST['userid'], $userlevel);
				$context->addMessage("User Level Successfully Changed.");
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else if($action == "saveNotes"){

			if((isset($_POST['notes']) && $_POST['notes'] != "")){

				$notes = $_POST['notes'];
				UserDao::updateUserNotes($_POST['userid'], $notes);
				$context->addMessage("Notes Successfully Changed.");
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else if($action == "saveName"){

			if((isset($_POST['name']) && $_POST['name'] != "")){

				$name = $_POST['name'];
				UserDao::updateName($_POST['userid'], $name);
				$context->addMessage("Name Successfully Changed.");
					
			}else{
				$context->addError("Required Field Left Blank.");
			}

		}else{

			$context->addError("Incorrect Action.");

		}

	}

}

?>
