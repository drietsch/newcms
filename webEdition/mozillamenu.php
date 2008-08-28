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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/java_menu/weJavaMenu.inc.php");
header("Content-Type: application/vnd.mozilla.xul+xml");
$port = defined("HTTP_PORT") ? HTTP_PORT : "";
$jmenu = new weJavaMenu("",SERVER_NAME,"top.load","http",$port,500,30,(isset($_REQUEST['pre'])?$_REQUEST['pre']:""));
print $jmenu->getXUL($_language["charset"]);
?>