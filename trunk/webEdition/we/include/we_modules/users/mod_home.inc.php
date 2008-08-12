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

$createUser = $we_button->create_button("create_user", "javascript:top.opener.top.we_cmd('new_user');", true, -1, -1, "", "", !we_hasPerm("NEW_USER"));
$createAlias = $createGroup = "";

if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"]) {
	$createGroup = $we_button->create_button("create_group", "javascript:top.opener.top.we_cmd('new_group');", true, -1, -1, "", "", !we_hasPerm("NEW_GROUP"));
	$createAlias = $we_button->create_button("create_alias", "javascript:top.opener.top.we_cmd('new_alias');", true, -1, -1, "", "", !we_hasPerm("NEW_ALIAS"));
}

$content = $createUser.getPixel(2,14).$createGroup.getPixel(2,14).$createAlias;

$modimage = "user.gif"

?>