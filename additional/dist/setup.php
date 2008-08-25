<?php
/**
 * webEdition configuration script
 * 
 * - check system requirements
 * - show configuration recommendations (webserver and PHP)
 * - show configuration form
 * - update database settings
 * - update language setting * 
 * 
 * (c) 2008 by Living-E AG
 * @author Alexander Lindenstruth
 * @version 0.1
 */

// some utility features:
if(isset($_REQUEST["phpinfo"])) {
	phpinfo();
	exit();
}
// first some includes:
if(
	!is_readable('./webEdition/we/include/we_version.php') || 
	!is_readable('./webEdition/we/include/conf/we_conf.inc.php') || 
	!is_dir('./webEdition') || 
	!is_dir('./webEdition/lib/we')) {
	die("No webEdition installation found. This script has to be placed in your DOCUMENT_ROOT besides your webEdition folder!");
}
include_once './webEdition/we/include/we_version.php';
include_once './webEdition/lib/we/core/autoload.php';
@session_start();
if(isset($_REQUEST["debug"]) && !isset($_SESSION["debug"])) $_SESSION["debug"] = true;
if(isset($_REQUEST["debugoff"]) && isset($_SESSION["debug"])) unset($_SESSION["debug"]);

// html code for additional html header tags: 
$header = "";
// boolean for error state (for disabling the next button if any errors occured)
$errors = false;

$steps = array(
	array(
		"id" => "1",
		"title" => "webEdition setup",
		"name" => "welcome"
	),
	array(
		"id" => "2",
		"title" => "System requirements",
		"name" => "requirements"
	),
	array(
		"id" => "3",
		"title" => "Filesystem checks",
		"name" => "filesystem"
	),
	array(
		"id" => "4",
		"title" => "Database settings",
		"name" => "database"
	),
	array(
		"id" => "5",
		"title" => "Check database settings",
		"name" => "databasecheck"
	),
	array(
		"id" => "6",
		"title" => "Language selection",
		"name" => "language"
	),
	array(
		"id" => "7",
		"title" => "Summary",
		"name" => "summary"
	),
	array(
		"id" => "8",
		"title" => "Installation",
		"name" => "installation"
	),
	array(
		"id" => "9",
		"title" => "Setup complete.",
		"name" => "finish"
	),
);

// identify current step:
if(isset($_REQUEST["step"]) && !empty($_REQUEST["step"]) && intval($_REQUEST) >= "1" && intval($_REQUEST) <= sizeof($steps)) {
	$currentStep = $steps[intval($_REQUEST["step"]) - 1];
} else {
	$currentStep = $steps[0];
}

// function for executing steps:
function step_welcome() {
	$output = '<b>Welcome to webEdition 6!</b><br />
This webEdition setup script will guide you through the initial configuration steps:
<ul>
		<li>System requirements and recommendations</li>
		<li>Filesystem checks (write permissions etc.)</li>
		<li>Database configuration and checks</li>
		<li>Language and character set</li>
		<li>Database installation and webEdition configuration</li>
</ul>
<b>Important:</b> Please remember to delete this script afterwards in order to prevent system damage by misuse!
<br /><br />
	';
	// session and cookie test:
	$sessionid = session_id();
	if(!$sessionid) { 
		$_SESSION["we_test"] = @session_id();
		$_COOKIE["we_test"] = @session_id();
	} else {
		$_SESSION["we_test"] = "";
		$_COOKIE["we_test"] = "";
	}
	return $output;
}

function step_requirements() {
	global $errors;
	$output = "Checking if all system requirements are met. Some additional tests are performed as they are needed for webEdition to be fully functional but are not essential to run webEdition.<br /><br /><b>Basic Requirements:</b><ul style=\"list-style-position:outside;\">";
	$errors = false;
	if(PHP_VERSION < "5.1") {
		$output.=tpl_error("PHP Version 5.1 or newer required!");
		$errors = true;
	} else {
		$output.=tpl_ok("Your PHP Version is up to date (Version ".PHP_VERSION.")");
	}
	if(!is_callable("mysql_query")) {
		$output.=tpl_error("PHP MySQL Support is required for running webEdition! MySQL servers at version 4.1 or newer are supported.");
		$errors = true;
	} else {
		$mysqlVersion = mysql_get_client_info();
		$output.=tpl_ok("PHP MySQL support available (Client API Version ".$mysqlVersion." found)");
	}

	$output .= "</ul><b>Additional requirements:</b><ul style=\"list-style-position:outside;\">";
	if(!is_callable("curl_getinfo")) {
		$output.=tpl_warning("curl support is not available.<br />You need at least curl or allow_url_fopen activated for using webEdition liveUpdate, the First Steps Wizard or the application installer.");
	} else {
		$curlVersion = curl_version();
		$output.=tpl_ok("curl support is available (Version ".$curlVersion["version"]." found)");
	}
	if(ini_get("allow_url_fopen") == "Off") {
		$output.=tpl_warning("allow_url_fopen deactivated.<br />You need at least curl or allow_url_fopen activated for using webEdition liveUpdate.");
	} else {
		$output.=tpl_ok("allow_url_fopen activated.");
	}
	
	if(!is_callable("mb_convert_encoding")) {
		$output.=tpl_warning("PHP multibyte functions not available");
	} else {
		$output.=tpl_ok("PHP multibyte functions available");
	}
	if(!is_callable("gd_info")) {
		$output.=tpl_warning("gdlib functions not available");
	} else {
		$output.=tpl_ok("gdlib functions available (Verison ".GD_VERSION." found)");
	}
	$output .= "</ul>";
	if($errors === true) {
		$output .= tpl_errorbox("Some of the essential system requirements are not met. Please check the informations given above and update yor system!<br /><a href=\"?phpinfo\" target=\"_blank\">Click here</a> to check your system's PHP configuration.");
	}
	// session and cookie test:
	$output .= "</ul><b>Session / cookie test:</b><ul style=\"list-style-position:outside;\">";
	if(isset($_SESSION["we_test"]) && $_SESSION["we_test"] == @session_id()) {
		$output.=tpl_error("Session test failed. Maybe restarting your browser may help.");
	} else {
		$output.=tpl_ok("Session test");
	}
	if(isset($_COOKIE["we_test"]) && $_COOKIE["we_test"] == @session_id()) {
		$output.=tpl_error("Cookie test failed. Maybe cookies are disabled in your browser.");
	} else {
		$output.=tpl_ok("Cookie test");
	}
	return $output;
}

function step_filesystem() {
	global $errors;
	$output = "Some Directories have to be writable by the webserver for running webEdition:<ul>";
	if(!is_writable('./')) {
		$output .= tpl_error("DOCUMENT ROOT is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("./ (DOCUMENT_ROOT)");
	}
	if(!is_writable('./webEdition/site')) {
		$output .= tpl_error("webEdition/site is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("webEdition/site");
	}
	if(!is_writable('./webEdition/we/templates')) {
		$output .= tpl_error("webEdition/we/templates is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("webEdition/we/templates");
	}
	if(!is_writable('./webEdition/we/include/conf')) {
		$output .= tpl_error("The webEdition configuration file is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("webEdition/we/include/conf");
	}
	if(!is_writable('./webEdition/we/include/conf/we_conf.inc.php')) {
		$output .= tpl_error("The webEdition configuration file is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("webEdition/we/include/conf/we_conf.inc.php");
	}
	if(!is_writable('./webEdition/we/tmp')) {
		$output .= tpl_error("The webEdition temporary directory file is not writable!");
		$errors = true;
	} else {
		$output .= tpl_ok("webEdition/we/tmp");
	}
	if(!is_writable('./webEdition/liveUpdate/tmp')) {
		$output .= tpl_warning("The webEdition liveUpdate temporary directory file is not writable! You will not be able to use this feature.");
	} else {
		$output .= tpl_ok("webEdition/liveUpdate/tmp");
	}
	$output .= "</ul>";
	if($errors === true) {
		$output .= tpl_errorbox("There were some errors regarding file access privileges. Please fix these issues (i.e. via ftp) and try again.");
	} else {
		$output .= "All these directories seem to be writable by the webserver.<br /><br />";
	}
	$output .= "Sometimes there may occur problems while using webEdition regarding file access permissions, even if the directories seem to be writable to this script. If that happens you should verify all access privileges and file owner informations of the critical webEdition directories. This can be done with ftp applications like <a href=\"http://www.filezilla-project.org\" target=\"_blank\">FileZilla</a>.";
	return $output;
}

function step_database() {
	global $header;
	$output = "Please enter all informations required to connect to the database server:<br /><br />";
	// database host name
	$input_host = new we_ui_controls_TextField();
	$input_host->setName('db_host');
	if(isset($_SESSION["db_host"]) && !empty($_SESSION["db_host"])) {
		$input_host->setValue($_SESSION["db_host"]);
	} else {
		$input_host->setValue('localhost');
	}
	$input_host->setWidth(200);
	
	// database name:
	$input_database = new we_ui_controls_TextField();
	$input_database->setName('db_database');
	if(isset($_SESSION["db_database"]) && !empty($_SESSION["db_database"])) {
		$input_database->setValue($_SESSION["db_database"]);
	} else {
		$input_database->setValue('webedition');
	}
	$input_database->setWidth(200);
	
	// table prefix:
	$input_tableprefix = new we_ui_controls_TextField();
	$input_tableprefix->setName('db_tableprefix');
	if(isset($_SESSION["db_tableprefix"]) && !empty($_SESSION["db_tableprefix"])) {
		$input_tableprefix->setValue($_SESSION["db_tableprefix"]);
	} else {
		$input_tableprefix->setValue('');
	}
	$input_tableprefix->setWidth(200);
	
	// database username:
	$input_username = new we_ui_controls_TextField();
	$input_username->setName('db_username');
	if(isset($_SESSION["db_username"]) && !empty($_SESSION["db_username"])) {
		$input_username->setValue($_SESSION["db_username"]);
	} else {
		$input_username->setValue('');
	}
	$input_username->setWidth(200);
	
	// database user password:
	$input_password = new we_ui_controls_TextField();
	$input_password->setName('db_password');
	if(isset($_SESSION["db_password"])) {
		$input_password->setValue($_SESSION["db_password"]);
	} else {
		$input_password->setValue('');
	}
	$input_password->setWidth(200);
	$input_password->setClass("small");
	$input_password->setType("password");
	
	foreach($input_host->getJSFiles() as $jsFile) {
		$header .= '<script src="'.$jsFile.'" language="JavaScript" type="text/javascript"></script>';
	}
	foreach($input_host->getCSSFiles() as $cssFile) {
		$header .= '<link href="'.$cssFile["path"].'" media = "'.$cssFile["media"].'" rel="styleSheet" type="text/css">';
	}
	$output .= '<table class="small">';
	$output .= '<tr><td style="width:80px;">Server: </td><td>'.$input_host->getHTML().'</td></tr>';
	$output .= '<tr><td style="width:80px;">Database: </td><td>'.$input_database->getHTML().'</td></tr>';
	$output .= '<tr><td style="width:80px;">Table prefix: </td><td>'.$input_tableprefix->getHTML().'</td></tr>';
	$output .= '<tr><td style="width:80px;">Username: </td><td>'.$input_username->getHTML().'</td></tr>';
	$output .= '<tr><td style="width:80px;">Password: </td><td>'.$input_password->getHTML().'</td></tr>';
	$output .= '</table>';
	return $output;
}

function step_databasecheck() {
	global $errors;
	$output = "Some checks are being performed to verify that the database server is fully operational:<ul>";
	if((!isset($_SESSION["db_host"]) || empty($_SESSION["db_host"])) && (!isset($_REQUEST["db_host"]) || empty($_REQUEST["db_host"]))) {
		$output .= tpl_error("Please enter the host name of your MySQL database server.");
		$errors = true;
	} else if(isset($_REQUEST["db_host"])) {
		$_SESSION["db_host"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["db_host"]))));
	}
	if((!isset($_SESSION["db_database"]) || empty($_SESSION["db_database"])) && (!isset($_REQUEST["db_database"]) || empty($_REQUEST["db_database"]))) {
		$output .= tpl_error("Please enter the database name to be used by webEdition. This database does not need to exist yet, if the specified database user has the permission to create databases.");
		$errors = true;
	} else if(isset($_REQUEST["db_database"])) {
		$_SESSION["db_database"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["db_database"]))));
	}
	if(isset($_REQUEST["db_tableprefix"])) {
		$_SESSION["db_tableprefix"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["db_tableprefix"]))));
	} else if(!isset($_SESSION["db_tableprefix"])) {
		$_SESSION["db_tableprefix"] = '';
	}
	
	if((!isset($_SESSION["db_username"]) || empty($_SESSION["db_username"])) && (!isset($_REQUEST["db_username"]) || empty($_REQUEST["db_username"]))) {
		$output .= tpl_error("Please enter the username for accessing your MySQL database server.");
		$errors = true;
	} else if(isset($_REQUEST["db_username"])) {
		$_SESSION["db_username"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["db_username"]))));
	}
	if(!isset($_SESSION["db_password"]) && !isset($_REQUEST["db_password"])) {
		$output .= tpl_error("Please enter the password for accessing your MySQL database server.");
		$errors = true;
	} else if(isset($_REQUEST["db_password"])) {
		$_SESSION["db_password"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["db_password"]))));
		if(empty($_REQUEST["db_password"])) {
			$output .= tpl_warning("No password entered. Are you sure?");
		}
	}
	if($errors) {
		$output .= tpl_errorbox("Please enter the missing informations.");
		return $output.'</ul>';
	}
	
	// check connection to db server using the entered data
	$conn = @mysql_connect($_SESSION["db_host"],$_SESSION["db_username"],$_SESSION["db_password"]);
	if(!$conn) {
		$output .= tpl_error("Could not connect to MySQL database server.");
		$errors = true;
		return $output.'</ul>';
	} else {
		$output .= tpl_ok("Connection test succeeded");
	}
	
	// check if selected database already exists:
	$op_createdb = false;
	//$result = @mysql_list_dbs($conn);
	$result = @mysql_query("use ".$_SESSION["db_database"],$conn);
	//$dblist = mysql_fetch_array($result);
	//$output .= print_r($dblist,true);
	//if(!in_array($_SESSION["db_database"],$dblist)) {
	if(!$result) {
		$output .= tpl_info("The database \"".$_SESSION["db_database"]."\" does not exist yet. Will try to create it.");
		$op_createdb = true;
	} else {
		$output .= tpl_ok("The database \"".$_SESSION["db_database"]."\" exists already");
		$op_createdb = false;
	}
	
	// try to create db:
	if($op_createdb === true) {
		if(!@mysql_query("create database ".$_SESSION["db_database"],$conn)) {
			$output .= tpl_error("Could not create the database. Message from the server: ".mysql_error($conn));
			$errors = true;
			return $output.'</ul>';
		}
	}
	$result = @mysql_query("use ".$_SESSION["db_database"],$conn);
	
	// check if there is already a webEdition installation present:
	
	$result = @mysql_query("select ID from ".$_SESSION["db_tableprefix"]."tblUser",$conn);
	if(!$result) {
		$output .= tpl_ok("The selected database obviously does not conain any previous webEdition installations using this table prefix");
	} else {
		$data = @mysql_num_rows($result);
		if(!empty($data)) {
			$output .= tpl_warning("There is obviously a previous webEdition installation in the selected database. <b>All data will be lost if you continue this installation!</b> Please backup your data or use an alternate table prefix.");
		} else {
			$output .= tpl_ok("The selected database obviously does not conain any previous webEdition installations using this table prefix");
		}
	}
		
	// check for required database access permissions (select, insert, alter, update, drop)
	$output .= "</ul>Performing some permission tests for important database operations:<ul>";
	if(!@mysql_query("CREATE TABLE  `we_installer_test` (`id` VARCHAR( 100 ) NOT NULL) ENGINE = MYISAM;",$conn)) {
		$output .= tpl_error("CREATE TABLE failed: ".mysql_error($conn));
		$errors = true;
	} else {
		$output .= tpl_ok("CREATE TABLE succeeded");
	}
	if(!@mysql_query("INSERT INTO `we_installer_test` VALUES('eins');",$conn)) {
		$output .= tpl_error("INSERT failed: ".mysql_error($conn));
		$errors = true;
	} else {
		$output .= tpl_ok("INSERT succeeded");
	}
	if(!@mysql_query("UPDATE `we_installer_test` SET `id` = 'zwei' WHERE `id` != 'zwei';",$conn)) {
		$output .= tpl_error("UPDATE failed: ".mysql_error($conn));
		$errors = true;
	} else {
		$output .= tpl_ok("UPDATE succeeded");
	}
	if(!@mysql_query("DROP TABLE `we_installer_test`;",$conn)) {
		$output .= tpl_error("DROP TABLE failed: ".mysql_error($conn));
		$errors = true;
	} else {
		$output .= tpl_ok("DROP TABLE succeeded");
	}
	$output .= "</ul>";
	if($errors === false) {
	 	$output .= "All seems to be ok, all requirements are met.";
	} else {
		$output .= tpl_errorbox("There were some problems with the MySQL database server, please check the informations given above and fix these issues to continue the webEdition installation.");
	}
	
	//$output .= "<br /><br /><br /><br /><br /><br />";
	return $output;
}

function step_language() {
	global $errors;
	$output = "Please select a language to be used by webEdition. You can change this at any time using the webEdition preferences dialog window.";
	if(!is_dir('./webEdition/we/include/we_language/')) {
		$output .= tpl_errorbox('There is a problem with your webEdition installation, could not find the language directory. Please verify that the installation archive has been completely unpacked into this directory.');
		$errors = true;
		return $output;
	}
	$langdirs = scandir('./webEdition/we/include/we_language/');
	//$output .= print_r($langdirs,true);
	foreach($langdirs as $lang) {
		if(substr(0,1,$lang) != "." && strtoupper($lang) != "CVS" && strtoupper($lang) != "SVN") {
			if(is_readable('./webEdition/we/include/we_language/'.$lang.'/translation.inc.php')) {
				include_once('./webEdition/we/include/we_language/'.$lang.'/translation.inc.php');
			}
		}
	}
	asort($_language["translation"]);
	$defaultLanguage = "English_UTF-8";
	$defaultLanguageTranslation = "English (UTF-8)";
	$isoLanguages = false;
	if(!isset($_SESSION["we_language_translation"])) {
		$currentLanguage = $defaultLanguageTranslation;
	} else {
		$currentLanguage = $_SESSION["we_language_translation"];
	}
	$output .= '<input type="hidden" name="we_language_translation" value="'.$currentLanguage.'" />';
	$output .= '<div style="display:block; margin:10px; text-align:center;"><select name="we_language" onchange="document.getElementsByName(\'we_language_translation\')[0].value = this[this.selectedIndex].text;">';
	foreach($_language["translation"] as $k => $v) {
		if(!isset($_SESSION["we_language"]) && $k == $defaultLanguage) {
			$selected = 'selected="selected" ';
		} else if(isset($_SESSION["we_language"]) && $_SESSION["we_language"] == $k) {
			$selected = 'selected="selected" ';
		} else {
			$selected = "";
		}
		// check if this an iso encoded language (needed for displaying an additional information box):
		if(!strpos($v,"UTF-8")) {
			$isoLanguages = true;
			$v .= " (ISO 8859-1)";
		}
		$output .= '<option '.$selected.'name="'.$v.'" value="'.$k.'">'.$v.'</li>';
	}
	$output .= '</select></div>';
	// additional information box for iso encoded languages:
	if($isoLanguages === true) {
		$output .= "<b>Important:</b> We strongly recommend using UTF-8 for new projects. webEdition still contains a couple of ISO-8859-1 (ISO Latin-1) encoded translations for backwards compatibility, but all new translations are and will be UTF-8 encoded.<br /><br />";
	}
	$output .= "If your language is missing in this list, feel free to contribute a new translation to the webEdition community. You can find more informations about contributing code and translations on the <a href=\"http://www.webedition.de\" target=\"_blank\">webEdition website</a>.";
	return $output;
}

function step_summary() {
	global $errors;
	//print_r($_SESSION);
	$output = "";
	if((!isset($_SESSION["we_language"]) || empty($_SESSION["we_language"])) && (!isset($_REQUEST["we_language"]) || empty($_REQUEST["we_language"]))) {
		$output .= tpl_errorbox("Please select a valid language used by webEdition.");
		$errors = true;
	} else if(isset($_REQUEST["we_language"])) {
		$_SESSION["we_language"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["we_language"]))));
		$_SESSION["we_language_translation"] = str_replace("/*","",str_replace('"','',str_replace("'","",trim($_REQUEST["we_language_translation"]))));
	}
	// webEdition settings:
	$output .= '<fieldset><legend>webEdition:</legend><table class="small" style="width:100%; table-layout:fixed;">';
	$output .= '<tr><td style="width:100px;">Language:</td><td>'.(isset($_SESSION["we_language_translation"]) ? $_SESSION["we_language_translation"] : ' - ').'</td></tr>';
	$output .= '<tr><td>webEdition Code:</td><td>'.(isset($_SESSION["we_language"]) ? $_SESSION["we_language"] : ' - ').'</td></tr>';
	$output .= '</table></fieldset><br />';
	
	// database settings:
	$output .= '<fieldset><legend>Database server:</legend><table class="small" style="width:100%; table-layout:fixed;">';
	$output .= '<tr><td style="width:100px;">Server name:</td><td>'.(isset($_SESSION["db_host"]) ? $_SESSION["db_host"] : ' - ').'</td></tr>';
	$output .= '<tr><td>Database name:</td><td>'.(isset($_SESSION["db_database"]) ? $_SESSION["db_database"] : ' - ').'</td></tr>';
	$output .= '<tr><td>Table prefix:</td><td>'.(isset($_SESSION["db_tableprefix"]) ? $_SESSION["db_tableprefix"] : ' - ').'</td></tr>';
	$output .= '<tr><td>Username:</td><td>'.(isset($_SESSION["db_username"]) ? $_SESSION["db_username"] : ' - ').'</td></tr>';
	$output .= '<tr><td>Password:</td><td>'.(isset($_SESSION["db_password"]) ? $_SESSION["db_password"] : ' - ').'</td></tr>';
	$output .= '</table></fieldset>';
	if(
		!isset($_SESSION["db_host"]) || 
		empty($_SESSION["db_host"]) || 
		!isset($_SESSION["db_database"]) || 
		empty($_SESSION["db_database"]) || 
		!isset($_SESSION["db_tableprefix"]) || 
		!isset($_SESSION["db_username"]) || 
		empty($_SESSION["db_username"]) || 
		!isset($_SESSION["db_password"]) || 
		!isset($_SESSION["we_language_translation"]) || 
		empty($_SESSION["we_language_translation"]) || 
		!isset($_SESSION["we_language"]) ||  
		empty($_SESSION["we_language"]) 
		) {
		$errors = true;
	}
	return $output;
}

function step_installation() {
	global $errors;
	$output = "<b>Installation of database tables:</b><br /><br />";
	// read and parse database dump:
	if(!is_readable("./dump.sql") && !is_readable("./sql_dumps/dump/complete.sql")) {
		$output .= tpl_error("Could not read database dump file.");
		$errors = true;
		return $output;
	}
	if(is_readable("./dump.sql")) {
		$dbdata = file_get_contents("./dump.sql");
	} else {
		$dbdata = file_get_contents("./sql_dumps/dump/complete.sql");
	}
	$dbdata = str_replace("`","",$dbdata);
	$dbqueries = explode("/* query separator */",$dbdata);
	echo sizeof($dbqueries).' queries found.';
	$conn = @mysql_connect($_SESSION["db_host"],$_SESSION["db_username"],$_SESSION["db_password"]);
	if(!$conn) {
		$output .= tpl_error("Could not connect to database server. Message from server: ".mysql_error());
		$errors = true;
		return $output;
	} else {
		$output .= tpl_ok("connected to database server on \"".$_SESSION["db_host"]."\"");
	}
	// select database:
	if(!@mysql_query("use ".$_SESSION["db_database"],$conn)) {
		$output .= tpl_error("Error using specified database. Message from server: ".mysql_error());
		$errors = true;
		return $output;
	} else {
		$output .= tpl_ok("Using specified database \"".$_SESSION["db_database"]."\"");
	}
	// drop all existing tables beginning with $prefix$tbl:
	$res = @mysql_query('show tables where Tables_in_'.$_SESSION["db_database"].' LIKE "'.$_SESSION["db_tableprefix"].'tbl%"',$conn);
	while($table = @mysql_fetch_array($res)) {
		@mysql_query("drop table ".$table[0],$conn);
		echo $table[0]." dropped.<br />";
	}
	// insert table prefix and install all tables from sql dump:
	$queryTypes = array("CREATE TABLE","INSERT INTO","ALTER TABLE","UPDATE");
	$queryErrors = false;
	foreach($dbqueries as $dbquery) {
		if(isset($_SESSION["db_tableprefix"]) && !empty($_SESSION["db_tableprefix"])) {
			foreach($queryTypes as $queryType) {
				$dbquery = str_replace($queryType." tbl",$queryType." ".$_SESSION["db_tableprefix"]."tbl",$dbquery);
			}
		}
		if(!empty($dbquery)) {
			if(!@mysql_query($dbquery,$conn)) {
				if(mysql_errno() != "1065") {
					$output .= tpl_warning("error executing query. Message from server: ".mysql_error());
					print("<pre>".$dbquery."</pre><hr />");
					$queryErrors = true;
				}
				//$output .= tpl_warning("error executing query.");
			} else {
				//print("<pre>".mysql_info($conn)."</pre><hr />");
			}
		}
	} if($queryErrors === true) {
		$output .= tpl_ok("There were some errors while executing the database queries.");
	} else {
		$output .= tpl_ok("Executed all queries successfully to the selected database.");
	}
	//print("<pre>".$dbdata."</pre>");
	$output .= "<br /><b>Writing webEdition configuration:</b><br /><br />";
	
	//$output .= "<li><i>under construction ...</i></li>";
	// set the language of the default user 
	if(!@mysql_query('UPDATE '.$_SESSION["db_tableprefix"].'tblPrefs set Language = "'.$_SESSION["we_language"].'" where userID="1"',$conn)) {
		$output .= tpl_warning("Could not change the default user's language settings. Message from server: ".mysql_error());
		print("<pre>".$dbquery."</pre><hr />");
		$queryErrors = true;
		//$output .= tpl_warning("error executing query.");
	} else {
		$output .= tpl_ok("Changed the default user's language to ".$_SESSION["we_language"]);
	}
	@mysql_close($conn);
	// write database connection data to we_conf.inc.php
	if(!is_writable('./webEdition/we/include/conf/we_conf.inc.php')) {
		tpl_error("Could not open webEdition configuration file for writing.");
		$errors = true;
	} else {
		$we_config = file_get_contents('./webEdition/we/include/conf/we_conf.inc.php');
		//$we_config = str_replace('define("WE_LANGUAGE","English_UTF-8");','define("WE_LANGUAGE","'.$_SESSION["we_language"].'");',$we_config);
		//$we_config = preg_replace('/(define\("WE_LANGUAGE",")(\s*)+("\);)/i','$1'.$_SESSION["we_language"].'$3',$we_config);
		str_replace('define("TBL_PREFIX","");','define("TBL_PREFIX","'.$_SESSION["db_tableprefix"].'"',$we_config);
		if(strstr($_SESSION["we_language"],"UTF-8")) {
			$we_config = preg_replace('/(define\("DB_CHARSET",")(\w*)("\);)/i','$1UTF-8$3',$we_config);
		}
		$we_config = preg_replace('/(define\("DB_HOST",")(\w*)("\);)/i','$1'.$_SESSION["db_host"].'$3',$we_config);
		$we_config = preg_replace('/(define\("DB_DATABASE",")(\w*)("\);)/i','$1'.$_SESSION["db_database"].'$3',$we_config);
		$we_config = preg_replace('/(define\("DB_USER",")(\w*)("\);)/i','$1'.$_SESSION["db_username"].'$3',$we_config);
		$we_config = preg_replace('/(define\("DB_PASSWORD",")(\w*)("\);)/i','$1'.$_SESSION["db_password"].'$3',$we_config);
		$we_config = preg_replace('/(define\("TBL_PREFIX",")(\w*)("\);)/i','$1'.$_SESSION["db_tableprefix"].'$3',$we_config);
		$we_config = preg_replace('/(define\("WE_LANGUAGE",")(\w*)(\055?)(\w*)("\);)/i','$1'.$_SESSION["we_language"].'$5',$we_config);
		$output .= tpl_ok("Changed the system's default language to ".$_SESSION["we_language"]);
		$output .= tpl_ok("Saved database configuration.");
		if(!file_put_contents('./webEdition/we/include/conf/we_conf.inc.php',$we_config)) {
			$output .= tpl_error("Could not write webEdition configuration file.");
			$errors = true;
		} else {
			$output .= tpl_ok("webEdition configuration file written.");
		}
		//error_log($we_config);
		/*
		define("DB_HOST","localhost");
		define("DB_DATABASE","wedev_svn");
		define("DB_USER","root");
		define("DB_PASSWORD","root");
		define("TBL_PREFIX","");
		define("DB_CHARSET","");
		define("WE_LANGUAGE","English_UTF-8");
		*/ 
	}
	
	return $output;
	
	
}

function step_finish() {
	$output = "The webEdition installation is now finished. It is located in the subdirectory \"/webEdition/\", you can enter webEdition by <a href=\"/webEdition/\" target=\"_blank\">clicking here</a>. 
	If you want more informations about how to use webEdition, visit our website or join the webEdition community.<br /><br />
	";
	$output .= "<b>Important:</b><br /><br />";
	$output .= "Please don't forget to remove this script (setup.php) in order to prevent damage to your website by misuse.<br /><br />";
	$output .= "The first thing you should do is to change the default password and username to less obvious ones, by default it is:
	<p style=\"margin-left:20px;\"><b>Username:</b> admin<br /><b>Password:</b> admin</p>
	you can do that using the webEdition user management module (located at the top of the \"Extras\" menu).";
	//return "<br />Live long and prosper!<br /><br /><br /><br /><br /><br />";
	return $output;
}
// html template functions:

// error message box:
function tpl_errorbox($text = "") {
	return '<div style="display:block; padding:3px; padding-left:24px; margin:3px 0px 3px 0px; border:1px solid red; background: url(./webEdition/images/icons/invalid.gif) 3px center no-repeat;" />'.$text.'</div>';
}

// informational message:
function tpl_info($text = "") {
	return '<li>INFO: '.$text.'</li>';
}

// error message:
function tpl_error($text = "") {
	return '<li><font color="red">ERROR: </font>'.$text.'</li>';
}

// succes message:
function tpl_ok($text = "") {
	return '<li>'.$text.' - <font color="green">OK</font></li>';
}

// warning message:
function tpl_warning($text = "") {
	return '<li><font color="orange">WARNING:</font> '.$text.'</li>';
}

// title text
if(isset($currentStep["title"])) {
	$stepTitle = '<big><b>'.$currentStep["id"].'. '.$currentStep["title"].'</b></big><br /><br />';
} else {
	$stepTitle = '';
}

// step navigation (2 buttons):
function tpl_navigation($step = "1") {
	global $header, $currentStep, $steps, $errors;
	$nextID = $step + 1;
	$prevID = $step - 1;
	// next button
	$buttonNext = new we_ui_controls_Button();
	$buttonNext->setWidth(120);
	$buttonNext->setTextPosition('right');
	/*
	if($step == sizeof($steps)) {
		$buttonNext->setHref('./webEdition/');
		$buttonNext->setTarget('_blank');
		$buttonNext->setText('start webEdition');
		$buttonNext->setTitle('start webEdition in a new window');
	} else {
		*/
		$buttonNext->setTitle('next step');
		$buttonNext->setText('next');
		$buttonNext->setTarget('_self');
		$buttonNext->setType('submit');
		if($step >= sizeof($steps) || $errors === true) {
			$buttonNext->setDisabled(true);
		} else {
			$buttonNext->setHref('?step='.$nextID);
		}
	//}
	// back button
	$buttonPrev = new we_ui_controls_Button();
	$buttonPrev->setTitle('previous step');
	$buttonPrev->setText('back');
	$buttonPrev->setType('href');
	$buttonPrev->setTarget('_self');
	if($step == "1" || $step == sizeof($steps)) {
		$buttonPrev->setDisabled(true);
	} else {
		$buttonPrev->setHref('?step='.$prevID);
	}
	$buttonPrev->setWidth(120);
	$buttonPrev->setTextPosition('left');
	
	foreach($buttonNext->getJSFiles() as $jsFile) {
		$header .= '<script src="'.$jsFile.'" language="JavaScript" type="text/javascript"></script>';
	}
	foreach($buttonNext->getCSSFiles() as $cssFile) {
		$header .= '<link href="'.$cssFile["path"].'" media = "'.$cssFile["media"].'" rel="styleSheet" type="text/css">';
	}
	
	$output = '<div style="display:block; margin:10px 0px 10px 0px;"><div style="float:left;">'.$buttonPrev->getHTML().'</div>';
	$output .= '<div style="float:right;">'.$buttonNext->getHTML().'</div></div>';
	return $output;
}

// buffer
ob_start();
if(is_callable("step_".$currentStep["name"])) {
	$output = call_user_func("step_".$currentStep["name"]);
} else {
	$output = '<br /><i>under construction...</i><br /><br /><br /><br /><br /><br />';
}
$navigation = tpl_navigation($currentStep["id"]);
$bufferedOutput = ob_get_contents();
ob_end_clean();
?>
<html>
<head>
	<title>webEdition &bull; initial configuration</title>
	<meta http-equiv="expires" content="0">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="imagetoolbar" content="no">
	<meta name="generator" content="webEdition Version <?php echo WE_VERSION ?>">
	<style type="text/css">
	fieldset {
		border:1px solid #888;
	}
	legend {
		font-weight:bold;
	}
	div.debug {
		position:absolute;
		margin:0px auto;
		background:transparent;
		width:100%;
		height:110px;
		overflow:auto;
		z-index:99;
		font-size:9pt;
		font-weight:normal;
		border-bottom:1px solid #333;
	}
	</style>
	<link href="/webEdition/css/global.php?WE_LANGUAGE=English_UTF-8" rel="styleSheet" type="text/css">
	<?php echo $header; ?>
</head>
<body bgcolor="#386AAB" class="header" onload="" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
<div class="debug"<?php if(isset($_SESSION["debug"])) {echo ' style="display:block;"';} else {echo ' style="display:none;"';} ?>>
<?php echo $bufferedOutput; ?>
</div>
<table width="100%" height="100%" style="width: 100%; height: 100%;">
	<tr>
		<td align="center" valign="middle">
			<form action="/setup.php?step=<?php echo ($currentStep["id"] + 1) ?>" method="post">
			<input name="step" value="<?php echo $currentStep["id"] + 1 ?>" type="hidden" />
			<table cellpadding="0" cellspacing="0" border="0" style="width:818px;">
				<tr style="height:10px;">
					<td style="width:260px;background-color:#386AAB;"></td>
					<td rowspan="2" style="width:430px;">
						<table border="0" cellpadding="0" cellspacing="0" style="background-image:url(/webEdition/images/info/info.jpg);background-repeat: no-repeat;background-color:#EBEBEB;">
							<tr>
								<td colspan="3" width="432" height="110"><img src="/webEdition/images/pixel.gif" width="432" height="110" border="0"></td>
							</tr>
							<tr>
								<td width="432" colspan="3"><img src="/webEdition/images/pixel.gif" width="432" height="15" border="0"></td>
							</tr>
							<tr>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="1" border="0"></td>
								<td width="402" class="small">
								<?php 
								echo $stepTitle;
								echo $output; 
								echo $navigation;
								?>
								</td>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="1" border="0"></td>
							</tr>
							<tr>
								<td width="432" colspan="3"><img src="/webEdition/images/pixel.gif" width="432" height="10" border="0"></td>
							</tr>
							<tr>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="1" border="0"></td>
								<td width="402" class="small">Version: <?php echo WE_VERSION ?></td>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="1" border="0"></td>
							</tr>
							<tr>
								<td width="432" colspan="3"><img src="/webEdition/images/pixel.gif" width="432" height="10" border="0"></td>
							</tr>
							<tr>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="5" border="0"></td>
								<td width="402" class="small">&copy; 2000-2008 living-e AG. All rights reserved</td>
								<td width="15"><img src="/webEdition/images/pixel.gif" width="15" height="1" border="0"></td>
							</tr>
							<tr>
								<td width="432" colspan="3"><img src="/webEdition/images/pixel.gif" width="432" height="10" border="0"></td>
							</tr>
							<tr>
								<td width="432" colspan="3">
									<img src="/webEdition/images/pixel.gif" width="432" height="10" border="0">
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" style="width:260px;background-image:url(/webEdition/images/login/right.jpg);background-repeat:repeat-y;">
						<img src="/webEdition/images/login/top_r.jpg" width="260" height="10"/>
					</td>
				</tr>
				<tr>
					<td  valign="bottom" style="width:260px;height:296px;background-color:#386AAB;">
						<img src="/webEdition/images/login/left	.jpg" width="260" height="296" />
					</td>
					<td valign="bottom" style="width:260px;height:296px;background-image:url(/webEdition/images/login/right.jpg);background-repeat:repeat-y;">
						<img src="/webEdition/images/login/bottom_r.jpg" width="260" height="296" />
					</td>
				</tr>
				<tr style="height:100px;">
					<td style="width:260px;"><img src="/webEdition/images/login/bottom_l2.jpg" width="260" height="100" /></td>
					<td style="background-image:url(/webEdition/images/login/bottom.jpg);height:100px;"><img src="/webEdition/images/login/bottom_l.jpg" width="184" height="100" /></td>
					<td style="width:260px;"><img src="/webEdition/images/login/bottom_r2.jpg" width="260" height="100" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</body>
</html>
