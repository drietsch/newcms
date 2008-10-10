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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_temporaryDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_delete_fn.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/object.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/object_classfoldersearch.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_document.inc.php");

include_once(WE_USERS_MODULE_DIR . "we_users_util.php");

$javascript = "";
if(isset($_REQUEST["do"]) && $_REQUEST["do"] == "delete") {
	$javascript .= $we_doc->deleteObjects();
} elseif(isset($_REQUEST["do"]) && $_REQUEST["do"] == "unpublish") {
	$javascript .= $we_doc->publishObjects(false);
} elseif(isset($_REQUEST["do"]) && $_REQUEST["do"] == "publish") {
	$javascript .= $we_doc->publishObjects();
}

protect();
// Ausgabe beginnen
htmlTop();

echo '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>';

echo $we_doc->getSearchJS();

if($javascript != "") {
	echo '<script language="JavaScript" type="text/javascript">'.$javascript.'</script>';
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php");

print STYLESHEET;

echo '</head>

<body class="weEditorBody" onUnload="doUnload()">';

$_parts = array();
$_parts[] = array("html"=>$we_doc->getSearchDialog());
$_parts[] = array("html"=>$we_doc->searchFields());

echo we_multiIconBox::getHTML("","100%",$_parts,"30","",-1,"","",false);

echo '
</body>
</html>';

?>