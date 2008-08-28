<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/permissionhandler/permissionhandler.class.php");


if(defined("MESSAGING_SYSTEM") && (!isset($_REQUEST["SEEM_edit_include"]) || !$_REQUEST["SEEM_edit_include"] )) { ?>
    <html>
    <head>
    <frameset cols="*,<?php if($BROWSER == "NN"){ print "60"; } else { print "50"; } ?>" framespacing="0" border="0" frameborder="NO">
        <frame src="/webEdition/headermenu.php" name="header_menu" scrolling="no" noresize>
        <frame src="<?php print WE_MESSAGING_MODULE_PATH; ?>header_msg.php" name="header_msg" scrolling="no" noresize>
    </frameset>
    </head>
    <body>
    </body>
    </html>
<?php
} else {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/headermenu.php");
}
?>