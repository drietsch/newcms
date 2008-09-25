<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_cli
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * ATTENTION
 *
 * The following line needs to be deleted or commented
 * before starting a cli script. It prevents from fraudulent use.
 * We recommend moving the cli scripts to secure location
 * before deleting this line. A secure location is either
 * outside the DOCUMENT_ROOT of your webserver or in a
 * password protected directory!
 *
 */
exit();

/**
 * The following 2 lines needs to be modified if you
 * are starting the script from command line. If
 * you call the script from http, nothing needs
 * to be done here.
 */

$SERVER_NAME = (isset($SERVER_NAME) && $SERVER_NAME) ? $SERVER_NAME : '__SERVER_NAME__';  // replace __SERVER_NAME__  with the name (domain) of your server eg. www.living-e.de
$_SERVER['DOCUMENT_ROOT'] = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '__PATH_TO_DOCUMENT_ROOT__'; //replace __PATH_TO_DOCUMENT_ROOT__  with the server path of your domains root directory

?>