<?php

require_once './lib/DB/UserDao.php';
require_once './lib/Util/Context.php';
require_once './lib/Util/LDAPUtil.php';
require_once './lib/Util/RemoteLDAPUtil.php';

class LoginHandler{
	
	public function handleForm($context, $action){

		if($action == "login"){

			$authed = false;
				
			if(Config::login_type == LOGIN_TYPE_LDAP){
					
				$authed = false;

				if(Config::ldap_type == LDAP_TYPE_REMOTE){
					$authed = RemoteLDAPUtil::auth($_POST['username'], $_POST['password']);
				}else if(Config::ldap_type == LDAP_TYPE_LOCAL){
					$authed = LDAPUtil::authLDAPUser($_POST['username'], $_POST['password']);
				}

			}else if(Config::login_type == LOGIN_TYPE_DB){

				$authed = UserDao::authUser($_POST['username'], $_POST['password']);

			}
				
			if($authed){
					
				$user = UserDao::getUserByUsername($_POST['username']);

				if($user != null && $user instanceof User){
						
					SessionUtil::setUsername($user->username);
					SessionUtil::setUserlevel($user->userlevel);
					
					if(isset($_POST['redir']) && $_POST['redir'] != ''
					&& !strpos($_POST['redir'], 'login')
					&& !strpos($_POST['redir'], 'logout')){
						header("location: ".$_POST['redir']);
					}else{
						$context->setPageID("home");
					}
						
				}else{
						
					$context->addError("Incorrect Login");
						
				}
					
			}else{
					
				$context->addError("Incorrect Login");
					
			}

		}else{
				
			$context->addError("Incorrect Action.");
				
		}

	}

}

?>