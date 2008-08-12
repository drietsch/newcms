<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: autoload.php,v 1.9 2008/07/25 14:36:25 thomas.kneip Exp $
 */

/*
 * Sets some global variables which are needed 
 * for other classes and scripts and defines 
 * the __autoload() function
 */

// Absolute Server Path to the webEdition base directory
$GLOBALS['__WE_BASE_PATH__'] = realpath(dirname(str_replace('\\', '/', __FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

// Absolute Server Path to the lib directory
$GLOBALS['__WE_LIB_PATH__'] = $GLOBALS['__WE_BASE_PATH__'] . DIRECTORY_SEPARATOR . 'lib';

// Absolute Server Path to the apps directory
$GLOBALS['__WE_APP_PATH__'] = $GLOBALS['__WE_BASE_PATH__'] . DIRECTORY_SEPARATOR . 'apps';

// Absolute URL to the webEdition base directory (eg. "/webEdition")
$GLOBALS['__WE_BASE_URL__'] = '/' . basename(str_replace('\\', '/', $GLOBALS['__WE_BASE_PATH__']));

// Absolute URL to the lib directory (eg. "/webEdition/lib")
$GLOBALS['__WE_LIB_URL__'] = $GLOBALS['__WE_BASE_URL__'] . '/lib';

// Absolute URL to the apps directory (eg. "/webEdition/apps")
$GLOBALS['__WE_APP_URL__'] = $GLOBALS['__WE_BASE_URL__'] . '/apps';

// add __WE_LIB_PATH__ and __WE_APP_PATH__ to the include_path
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $GLOBALS['__WE_LIB_PATH__'] . PATH_SEPARATOR . $GLOBALS['__WE_APP_PATH__']);

// include Zend_Loader, which is needed by the autoload function
require 'Zend/Loader.php';

include_once ($GLOBALS['__WE_BASE_PATH__'] . DIRECTORY_SEPARATOR . 'we' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'conf'. DIRECTORY_SEPARATOR . 'we_conf.inc.php');

function __autoload($class_name)
{
	Zend_Loader::loadClass($class_name);
}
