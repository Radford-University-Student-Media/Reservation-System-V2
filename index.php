<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once './config.php';
require_once './lib/Util/Constants.php';

require_once './lib/DB/Database.php';

require_once './lib/Site/Page.php';
require_once './lib/Site/StandardLayout.php';
require_once './lib/Site/StandardNavigation.php';

require_once './lib/Util/Context.php';
require_once './lib/Util/EmailUtil.php';
require_once './lib/Util/SessionUtil.php';

if(!SessionUtil::start())
echo "Error Starting Session";

Database::Open();

$context = new Context();
$context->setPageID("home");

$setPageVar = false;

if(isset($_GET['pageid'])){
	$context->setPageID($_GET['pageid']);
}
else if(isset($_POST['pageid'])){
	$context->setPageID($_POST['pageid']);
}

if(isset($_POST['action'])){

	$action = $_POST['action'];

	if($action == "setPageVar"){
		$setPageVar = true;
	}else{

		if($context->getPageID() == "login"){

			require_once './lib/Form/LoginHandler.php';
			$loginHandler = new LoginHandler();
			$loginHandler->handleForm($context, $action);

		}else if($context->getPageID() == "placeReservation"){

			require_once './lib/Form/PlaceReservationHandler.php';
			$placeReservationHandler = new PlaceReservationHandler();
			$placeReservationHandler->handleForm($context, $action);

		}else if($context->getPageID() == "editUser"){

			require_once './lib/Form/Admin/EditUserHandler.php';
			$editUserHandler = new EditUserHandler();
			$editUserHandler->handleForm($context, $action);

		}else if($context->getPageID() == "createUser"){

			require_once './lib/Form/Admin/CreateUserHandler.php';
			$createUserHandler = new CreateUserHandler();
			$createUserHandler->handleForm($context, $action);

		}else if($context->getPageID() == "viewReservation"){

			require_once './lib/Form/ViewReservationHandler.php';
			$viewReservationHandler = new ViewReservationHandler();
			$viewReservationHandler->handleForm($context, $action);
			$_GET['resid'] = $_POST['resid'];

		}else if($context->getPageID() == "adminWarning"){

			require_once './lib/Form/Admin/AdminWarningHandler.php';
			$adminWarningHandler = new AdminWarningHandler();
			$adminWarningHandler->handleForm($context, $action);

		}else if($context->getPageID() == "warnUser"){

			require_once './lib/Form/Admin/WarnUserHandler.php';
			$warnUserHandler = new WarnUserHandler();
			$warnUserHandler->handleForm($context, $action);

		}

	}

}

if(!SessionUtil::isLoggedIn()){
	$context->setPageID("login");
}

$pageBody;

if($context->getPageID() == "home"){
	require_once './lib/Site/HomeBody.php';
	$pageBody = new HomeBody();
}
else if($context->getPageID() == "login"){
	require_once './lib/Site/LoginBody.php';
	$pageBody = new LoginBody($context);
}
else if($context->getPageID() == "logout"){
	SessionUtil::restart();
	$context->setPageID("login");
	require_once './lib/Site/LoginBody.php';
	$pageBody = new LoginBody($context);
}
else if($context->getPageID() == "myAccount"){
	require_once './lib/Site/MyAccountBody.php';
	$pageBody = new MyAccountBody($context);
}
else if($context->getPageID() == "ourEquip"){
	require_once './lib/Site/OurEquipBody.php';
	$pageBody = new OurEquipBody($context);
}
else if($context->getPageID() == "placeReservation"){
	require_once './lib/Site/PlaceReservationBody.php';
	$pageBody = new PlaceReservationBody($context);
}
else if($context->getPageID() == "viewReservation"){
	require_once './lib/Site/ViewReservationBody.php';
	$pageBody = new ViewReservationBody($context);
}
else if($context->getPageID() == "moreInfo"){
	require_once './lib/Site/MoreInfoBody.php';
	$pageBody = new MoreInfoBody($context);
}
else if($context->getPageID() == "viewMyWarnings"){
	require_once './lib/Site/ViewMyWarningsBody.php';
	$pageBody = new ViewMyWarningsBody($context);
}
else if($context->getPageID() == "userAdmin"){
	require_once './lib/Site/Admin/UserAdminBody.php';
	$pageBody = new UserAdminBody($context);
}
else if($context->getPageID() == "editUser"){
	require_once './lib/Site/Admin/EditUserBody.php';
	$pageBody = new EditUserBody($context);
}
else if($context->getPageID() == "createUser"){
	require_once './lib/Site/Admin/CreateUserBody.php';
	$pageBody = new CreateUserBody($context);
}
else if($context->getPageID() == "viewWarnings"){
	require_once './lib/Site/ViewWarningsBody.php';
	$pageBody = new ViewWarningsBody($context);
}
else if($context->getPageID() == "viewWarning"){
	require_once './lib/Site/ViewWarningBody.php';
	$pageBody = new ViewWarningBody($context);
}
else if($context->getPageID() == "adminWarning"){
	require_once './lib/Site/Admin/AdminWarningBody.php';
	$pageBody = new AdminWarningBody($context);
}
else if($context->getPageID() == "warnUser"){
	require_once './lib/Site/Admin/WarnUserBody.php';
	$pageBody = new WarnUserBody($context);
}
else{
	//$context->setPageID("home");
	require_once './lib/Site/HomeBody.php';
	$pageBody = new HomeBody();
}

$pageNavigation = new StandardNavigation($context);
$layout = new StandardLayout($pageNavigation, $pageBody);

$page = new Page($layout);

$page->displayPage();

Database::Close();

?>