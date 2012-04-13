<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Util/Context.php';
require_once './lib/Util/EmailUtil.php';

class WarnUserHandler{

	public function handleForm(Context $context, $action){

		if(UserDao::getUserByUsername(SessionUtil::getUsername())->userlevel == RES_USERLEVEL_ADMIN){
			if($action == "createWarning"){

				if((isset($_POST['userId']) && $_POST['userId'] != "") &&
				(isset($_POST['reason']) && $_POST['reason'] != "") &&
				(isset($_POST['type']) && $_POST['type'] != "")){

					$user = UserDao::getUserByID($_POST['userId']);

					if($user != null){
						$warning = WarningDao::warnUser($_POST['userId'], $_POST['reason'], $_POST['type']);
						EmailUtil::sendWarningNoticeToUser($warning);
						$context->addMessage("Successfully warned ".$user);
					}else{
						$context->addError("No such user.");
					}

				}else{
					$context->addError("Required field left blank.");
				}

			}else{
				$context->addError("Incorrect Action.");
			}
		}else{
			$context->addError("Not Authorized.");
		}

	}

}

?>
