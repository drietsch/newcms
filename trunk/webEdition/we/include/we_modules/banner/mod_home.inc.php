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

$createBanner = $we_button->create_button("new_banner", "javascript:top.opener.top.we_cmd('new_banner');", true, -1, -1, "", "", !we_hasPerm("NEW_BANNER"));
$createGroup = $we_button->create_button("new_bannergroup", "javascript:top.opener.top.we_cmd('new_bannergroup');", true, -1, -1, "", "", !we_hasPerm("NEW_BANNER"));


$content = $createBanner.getPixel(2,14).$createGroup;

$modimage = "banner.gif";

?>