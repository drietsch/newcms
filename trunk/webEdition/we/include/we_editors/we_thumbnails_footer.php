<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

/*****************************************************************************
 * CREATE JAVASCRIPT
 *****************************************************************************/

// Define needed JS
$_javascript = <<< END_OF_SCRIPT
<!--
function we_save() {
	top.we_thumbnails.document.getElementById('thumbnails_dialog').style.display = 'none';

	top.we_thumbnails.document.getElementById('thumbnails_save').style.display = '';

	top.we_thumbnails.document.we_form.save_thumbnails.value = 'true';

	top.we_thumbnails.document.we_form.submit();
}


//-->
END_OF_SCRIPT;

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

print STYLESHEET . we_htmlElement::jsElement($_javascript) . "</head>";

$we_button = new we_button();

$okbut = $we_button->create_button("save", "javascript:we_save();");
$cancelbut = $we_button->create_button("close", "javascript:".((isset($_REQUEST["closecmd"]) && $_REQUEST["closecmd"]) ?  ($_REQUEST["closecmd"].";") : "")."top.close()");

print we_htmlElement::htmlBody(array("class"=>"weDialogButtonsBody"), $we_button->position_yes_no_cancel($okbut, "", $cancelbut, 10, "", "",0) . "</html>");

?>