<?php

require_once './lib/DB/UserDao.php';
require_once './lib/DB/WarningDao.php';

require_once './lib/Util/Context.php';

class AdminWarningHandler{

	public function handleForm(Context $context, $action){

		if(UserDao::getUserByUsername(SessionUtil::getUsername())->userlevel == RES_USERLEVEL_ADMIN){
			if($action == "deleteWarning"){

				$warning = WarningDao::getWarningByID($_POST['warnId']);
				if($warning != null){
					WarningDao::deleteWarning($warning->id);
					$context->addMessage("Successfully deleted warning.");
				}else{
					$context->addError("No such warning.");
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
