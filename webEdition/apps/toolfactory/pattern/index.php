// include autoload function
include_once('../../lib/we/core/autoload.php');

// include configuration
include_once('<?php print $TOOLNAME;?>/conf/meta.conf.php');

// get controller instabce
$controller = Zend_Controller_Front::getInstance();

// set path fpr controller directory
$controller->setControllerDirectory('./controllers');

// turn on exceptions
$controller->throwExceptions(true); // should be turned off in production server 

// disables automatic view rendering
$controller->setParam('noViewRenderer', true);

// set some app specific parameter
$controller->setParam('appDir',dirname($_SERVER['SCRIPT_NAME']));
$controller->setParam('appPath',dirname($_SERVER['SCRIPT_FILENAME']));
$controller->setParam('appName', '<?php print $TOOLNAME;?>');

// alerts a message and exits when a user is not logged in or when the session is expired
we_core_Permissions::protect();

// run!
$controller->dispatch();