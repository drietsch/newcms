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

$DB_WE->query("
	DELETE
	FROM " . LOCK_TABLE . "
	WHERE UserID='" . $_SESSION["user"]["ID"] . "'");
$DB_WE->query("
	UPDATE " . USER_TABLE . "
	SET Ping=0
	WHERE ID='" . $_SESSION["user"]["ID"] . "'");

?>
<script language="JavaScript" type="text/javascript">
<!--
<?php

cleanTempFiles(1);

if (isset($_SESSION["prefs"]["userID"])) { //	bugfix 2585, only update prefs, when userId is available
	doUpdateQuery($DB_WE, PREFS_TABLE, $_SESSION["prefs"], " WHERE userID=" . $_SESSION["prefs"]["userID"]);
}

//	getJSCommand
if (isset($_SESSION["SEEM"]["startId"])) { // logout from webEdition opened with tag:linkToSuperEasyEditMode
	

	$_path = $_SESSION["SEEM"]["startPath"];
	
	$jsCommand = "top.location.replace('" . $_path . "');";
	
	while (list($name, $val) = each($_SESSION)) {
		if ($name != "webuser") {
			unset($_SESSION[$name]);
		}
	}

} else { //	normal logout from webEdition.
	

	$jsCommand = "top.close();\n";

}

print $jsCommand;

?>
//-->
</script>