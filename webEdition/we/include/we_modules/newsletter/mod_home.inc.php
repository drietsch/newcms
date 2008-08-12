<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


$we_button = new we_button();

$createNl = $we_button->create_button("new_newsletter", "javascript:top.opener.top.we_cmd('new_newsletter');", true, -1, -1, "", "", !we_hasPerm("NEW_NEWSLETTER"));
$createNg = $we_button->create_button("new_newsletter_group", "javascript:top.opener.top.we_cmd('new_newsletter_group');", true, -1, -1, "", "", !we_hasPerm("NEW_NEWSLETTER"));

$content = $createNl.getPixel(2,14).$createNg.getPixel(2,14);

$modimage = "newsletter.gif";

?>