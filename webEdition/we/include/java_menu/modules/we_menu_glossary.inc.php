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
 * @package    webEdition_javamenu
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_glossary.inc.php");

// File > Glossary Check
$we_menu["1099000"]["text"] = $l_javaMenu["glossary"]["glossary_check"];
$we_menu["1099000"]["parent"] = "1000000";
$we_menu["1099000"]["cmd"] = "check_glossary";
$we_menu["1099000"]["perm"] = "";
$we_menu["1099000"]["enabled"] = "1";
?>