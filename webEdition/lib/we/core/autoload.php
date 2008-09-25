<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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

// include configuration file of webEdition
include_once ($GLOBALS['__WE_BASE_PATH__'] . DIRECTORY_SEPARATOR . 'we' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'we_conf.inc.php');

/**
 * class autoload function
 * 
 * @return void
 */
function __autoload($class_name)
{
	Zend_Loader::loadClass($class_name);
}
