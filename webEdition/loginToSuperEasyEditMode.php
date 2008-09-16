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


// Activate the webEdition error handler
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler(false);

if(!isset($_SESSION)) @session_start();

while(list($name, $val) = each($_SESSION)){
	if($name != "webuser"){
		unset($_SESSION[$name]);
	}
}

if(isset($_POST["username"]) && isset($_POST["passwd"]) && isset($_POST["id"]) && isset($_POST["type"])){
	
	$_SESSION["we_set_registered"] = true;
	
	//	login to supereasyeditmode
	//	write login_file
	$login_id = md5(uniqid(time()));
	$fp=fopen(TMP_DIR."/".session_id()."_login_id.php","wb");
	fputs($fp,$login_id);
	fclose($fp);

	$_POST["md5password"] = $_POST["passwd"];
	
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
<input type="hidden" name="login_id" value="' . $login_id . '">
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