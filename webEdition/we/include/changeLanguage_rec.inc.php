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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/we_class.inc.php");

protect();
$ok = false;

if ($_SESSION["perms"]["ADMINISTRATOR"]) {
	$we_transaction = $_REQUEST["we_cmd"][1];
	// init document
	$we_dt = $_SESSION["we_data"][$we_transaction];
	
	include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_editors/we_init_doc.inc.php");
	
	$ok = $we_doc->changeLanguageRecursive();

}

htmlTop();
?>
<script language="JavaScript" type="text/javascript"><!--
	<?php
	
	if ($ok) {
		print we_message_reporting::getShowMessageCall($GLOBALS["l_we_class"]["grant_language_ok"], WE_MESSAGE_NOTICE);
	} else {
		print we_message_reporting::getShowMessageCall($GLOBALS["l_we_class"]["grant_language_notok"], WE_MESSAGE_ERROR);
	}
	?>
//-->
</script>
</head>

<body>
</body>

</html>