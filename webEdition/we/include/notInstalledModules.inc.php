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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

print 
		'<script type="text/javascript">var win = window.open("http://modules.webedition.de/index.php?modules=' . rawurlencode(
				$_SESSION["we_module_list"]) . '&language=' . $GLOBALS["WE_LANGUAGE"] . '&weversion=' . WE_VERSION . '","nomods","width=640,height=480,scrollbars=yes,statusbar=no,menubar=no,resizable=yes")</script>';
?>