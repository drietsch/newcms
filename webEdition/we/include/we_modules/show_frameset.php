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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
protect();
htmlTop();
print we_htmlElement::jsElement('
	function toggleBusy(){
	}
	var makeNewEntry = 0;
	var publishWhenSave = 0;
	var weModuleWindow = true;
');
print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js"));
if(isset($_REQUEST['mod']) && !isset($mod)) {
	$mod = $_REQUEST['mod'];
}
?>
	</head>
	<frameset rows="26,*" border="0" framespacing="0" frameborder="no">;
		<frame src="<?php print WE_MODULE_PATH; ?>navi.php?mod=<?php echo $mod ?>" name="navi" noresize scrolling="no">
		<frame src="<?php print WE_MODULE_PATH; ?>show.php?mod=<?php echo $mod . (empty($_REQUEST["we_cmd"][1]) ? '' : "&msg_param=" . $_REQUEST["we_cmd"][1]) . (isset($_REQUEST['sid']) ? '&sid=' . $_REQUEST['sid'] : '') . (isset($_REQUEST['bid']) ? '&bid=' . $_REQUEST['bid'] : ''); ?>" name="content" noresize scrolling="no">
	</frameset>
	<body bgcolor="#ffffff"></body>
</html>