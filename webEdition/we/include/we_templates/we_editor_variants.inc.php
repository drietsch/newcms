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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");


//	send charset, if one is set:
if(isset($we_doc->elements["Charset"]["dat"]) && $we_doc->elements["Charset"]["dat"] && $we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES ){
	header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
}

htmlTop();
?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
<?php print STYLESHEET; ?>
	</head>
	<body class="weEditorBody" onUnload="doUnload()">
		<form name="we_form" method="post" onsubmit="return false;"><?php $we_doc->pHiddenTrans(); ?>
<?php

	switch ($we_doc->ContentType) {
		case 'text/webedition':
			include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/we_editor_variants_webEditionDocument.inc.php');
		break;

		case 'objectFile':
			include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/we_editor_variants_objectFile.inc.php');
		break;

		case 'text/weTmpl':
			include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/we_template_variant.inc.php');
		break;

		default:
			print $we_doc->ContentType . ' not available (' . __FILE__ .')';
		break;
	}
?>
		</form>
</body>
</html>