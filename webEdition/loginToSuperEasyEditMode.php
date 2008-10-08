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


// Activate the webEdition error handler
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler(false);

if(!isset($_SESSION)) @session_start();

while(list($name, $val) = each($_SESSION)){
	if($name != "webuser"){
		unset($_SESSION[$name]);
	}
}

if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["id"]) && isset($_POST["type"])){
	
	$_SESSION["we_set_registered"] = true;
		
	//	Login
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

	if(isset($_SESSION["user"]["Username"])){	//	login ok!

		//	we must give some information, that we start in Super-Easy-Edit-Mode
		$_SESSION["we_mode"] = "seem";
		$_SESSION["SEEM"]["startId"] = $_POST["id"];
		$_SESSION["SEEM"]["startType"] = $_POST["type"];
		$_SESSION["SEEM"]["startPath"] = $_POST["path"];
		
		$_SESSION["SEEM"]["open_selected"]   = true;	//	This var is only temporary
		
		//	now start webEdition
		print '
<html>
<body>
<form name="startSuperEasyEditMode" method="post" action="/webEdition/webEdition.php">
</form>
<script language="javascript">
document.forms[\'startSuperEasyEditMode\'].submit();
</script>
</body>
</html>
		';
	
	} else {
		
		print "Ein Fehler trat auf. - 1";
	}
	
} else {
	
	print "Es trat ein Fehler auf. - 2";
}



?>