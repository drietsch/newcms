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

$createUser = $we_button->create_button("create_user", "javascript:top.opener.top.we_cmd('new_user');", true, -1, -1, "", "", !we_hasPerm("NEW_USER"));
$createAlias = $createGroup = "";

if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"]) {
	$createGroup = $we_button->create_button("create_group", "javascript:top.opener.top.we_cmd('new_group');", true, -1, -1, "", "", !we_hasPerm("NEW_GROUP"));
	$createAlias = $we_button->create_button("create_alias", "javascript:top.opener.top.we_cmd('new_alias');", true, -1, -1, "", "", !we_hasPerm("NEW_ALIAS"));
}

$content = $createUser.getPixel(2,14).$createGroup.getPixel(2,14).$createAlias;

$modimage = "user.gif"

?>