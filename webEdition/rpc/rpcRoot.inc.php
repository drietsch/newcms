<?php
/**
 * 
 * @package RPC
 * @copyright living-e AG
 */

define('RPC_DIR', str_replace("\\", "/",dirname(__FILE__)) . '/');
define('RPC_URL', str_replace($_SERVER['DOCUMENT_ROOT'],'',RPC_DIR));

ini_set('include_path',	ini_get('include_path') . PATH_SEPARATOR . RPC_DIR);

define('NO_SESS',1); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolLookup.class.php');

?>