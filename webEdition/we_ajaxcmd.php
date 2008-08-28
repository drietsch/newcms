<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

if(!isset($_REQUEST["we_cmd"])){
	exit();
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
//protect();
switch($_REQUEST["we_cmd"][0]){
	case "selectorSuggest" :
		$include = "we_ajax/weSelectorSuggest.inc.php";
		break;
}

include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/".$include);
?>