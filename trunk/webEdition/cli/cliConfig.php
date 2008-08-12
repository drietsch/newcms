<?php
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