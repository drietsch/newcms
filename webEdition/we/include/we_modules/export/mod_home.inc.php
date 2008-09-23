<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


$we_button = new we_button();

$content = 	$we_button->create_button("new_export", "javascript:top.opener.top.we_cmd('new_export');", true, -1, -1, "", "", !we_hasPerm("NEW_EXPORT")) . getPixel(2,14) .
			$we_button->create_button("new_export_group", "javascript:top.opener.top.we_cmd('new_export_group');", true, -1, -1, "", "", !we_hasPerm("NEW_EXPORT")) . getPixel(2,14);

$modimage = "export.gif";
?>