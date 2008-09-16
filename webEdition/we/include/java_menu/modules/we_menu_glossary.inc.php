<?php        
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_glossary.inc.php");

// File > Glossary Check
$we_menu["1099000"]["text"] = $l_javaMenu["glossary"]["glossary_check"];
$we_menu["1099000"]["parent"] = "1000000";
$we_menu["1099000"]["cmd"] = "check_glossary";
$we_menu["1099000"]["perm"] = "";
$we_menu["1099000"]["enabled"] = "1";
?>