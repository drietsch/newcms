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