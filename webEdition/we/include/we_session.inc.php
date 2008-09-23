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

if (!isset($_SESSION))
	@session_start();

if (!isset($_SESSION["user"])) {
	$_SESSION["user"] = array(
		"ID" => "", "Username" => "", "workSpace" => "", "isWeSession" => false
	);
}

if ((isset($_POST["username"]) && isset($_POST["md5password"])) && isset($_SESSION["we_secret"])) {
	
	$_userdata = getHash(
			"SELECT passwd, username, LoginDenied, ID FROM " . USER_TABLE . " WHERE username='" . addslashes(
					$_POST["username"]) . "'", 
			$DB_WE);
	
	$hash = (isset($_userdata["passwd"]) && isset($_SESSION["we_secret"])) ? md5(
			$_userdata["passwd"] . $_SESSION["we_secret"]) : "";
	
	if ($hash !== "" && $hash === $_POST["md5password"]) {
		if ($_userdata["LoginDenied"]) { // userlogin is denied 
			$GLOBALS["userLoginDenied"] = true;
		
		} else {
			
			unset($_SESSION["we_secret"]);
			if (!(isset($_SESSION["user"]) && is_array($_SESSION["user"]))) {
				$_SESSION["user"] = array();
			}
			$_SESSION["user"]["Username"] = $_userdata["username"];
			$_SESSION["user"]["ID"] = $_userdata["ID"];
			
			$a = array();
			$f = array();
			$t = array();
			$o = array();
			$n = array();
			$nl = array();
			$_userGroups = array(); //	Get Groups user belongs to.
			$db_tmp = new DB_WE();
			$get_ws = 0;
			$get_wst = 0;
			$get_wso = 0;
			$get_wsn = 0;
			$get_wsnl = 0;
			
			$DB_WE->query(
					(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array(
							"busers", 
							$GLOBALS["_pro_modules"])) ? ("SELECT ParentID,workSpace,workSpaceTmp,workSpaceNav,workSpaceObj,workSpaceNwl,ParentWs,ParentWst,ParentWsn,ParentWso,ParentWsnl FROM " . USER_TABLE . " WHERE ID=" . $_SESSION["user"]["ID"] . " OR Alias=" . $_SESSION["user"]["ID"]) : "SELECT workSpace FROM " . USER_TABLE . " WHERE ID=" . $_SESSION["user"]["ID"]);
			while ($DB_WE->next_record()) {
				// get workspaces
				$a = makeArrayFromCSV($DB_WE->f("workSpace"));
				foreach ($a as $k => $v)
					if (!in_array($v, $f))
						array_push($f, $v);
				if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array(
						"busers", 
						$GLOBALS["_pro_modules"])) {
					$a = makeArrayFromCSV($DB_WE->f("workSpaceTmp"));
					foreach ($a as $k => $v) {
						if (!in_array($v, $t)) {
							array_push($t, $v);
						}
					}
					
					$a = makeArrayFromCSV($DB_WE->f("workSpaceNav"));
					foreach ($a as $k => $v) {
						if (!in_array($v, $n)) {
							array_push($n, $v);
						}
					}
					
					$a = makeArrayFromCSV($DB_WE->f("workSpaceObj"));
					foreach ($a as $k => $v) {
						if (!in_array($v, $o)) {
							array_push($o, $v);
						}
					}
					
					$a = makeArrayFromCSV($DB_WE->f("workSpaceNwl"));
					foreach ($a as $k => $v) {
						if (!in_array($v, $nl)) {
							array_push($nl, $v);
						}
					}
					
					// get parent workspaces
					$pid = $DB_WE->f("ParentID");
					$get_ws = $DB_WE->f("ParentWs");
					$get_wst = $DB_WE->f("ParentWst");
					$get_wso = $DB_WE->f("ParentWso");
					$get_wsn = $DB_WE->f("ParentWsn");
					$get_wsnl = $DB_WE->f("ParentWsnl");
					
					while ($pid) { //	For each group
						

						array_push($_userGroups, $pid);
						
						$db_tmp->query(
								"SELECT ParentID,workSpace,workSpaceTmp,workSpaceNav,workSpaceObj,workSpaceNwl,ParentWs,ParentWst,ParentWsn,ParentWso,ParentWsnl FROM " . USER_TABLE . " WHERE ID=" . $pid);
						if ($db_tmp->next_record()) {
							if ($get_ws) {
								$a = makeArrayFromCSV($db_tmp->f("workSpace"));
								foreach ($a as $k => $v)
									if (!in_array($v, $f))
										array_push($f, $v);
							}
							if ($get_wst) {
								$a = makeArrayFromCSV($db_tmp->f("workSpaceTmp"));
								foreach ($a as $k => $v)
									if (!in_array($v, $t))
										array_push($t, $v);
							}
							if ($get_wso) {
								$a = makeArrayFromCSV($db_tmp->f("workSpaceObj"));
								foreach ($a as $k => $v)
									if (!in_array($v, $o))
										array_push($o, $v);
							}
							if ($get_wsn) {
								$a = makeArrayFromCSV($db_tmp->f("workSpaceNav"));
								foreach ($a as $k => $v)
									if (!in_array($v, $n))
										array_push($n, $v);
							}
							if ($get_wsnl) {
								$a = makeArrayFromCSV($db_tmp->f("workSpaceNwl"));
								foreach ($a as $k => $v)
									if (!in_array($v, $nl))
										array_push($nl, $v);
							}
							$pid = $db_tmp->f("ParentID");
							$get_ws = $db_tmp->f("ParentWs");
							$get_wst = $db_tmp->f("ParentWst");
							$get_wso = $db_tmp->f("ParentWso");
							$get_wsn = $db_tmp->f("ParentWsn");
							$get_wsnl = $db_tmp->f("ParentWsnl");
						} else {
							$pid = 0;
						}
					}
				}
			}
			$_SESSION["user"]["workSpace"] = implode(",", $f);
			$_SESSION["user"]["groups"] = $_userGroups; //	order: first is folder with user himself (deepest in tree)
			if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array(
					"busers", 
					$GLOBALS["_pro_modules"])) {
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $t);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $o);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $n);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $nl);
			}
			
			$_SESSION["prefs"] = getHash("SELECT * from " . PREFS_TABLE, $DB_WE);
			
			$exprefs = getHash("SELECT * FROM " . PREFS_TABLE . " WHERE userID=" . $_userdata["ID"], $DB_WE);
			if (is_array($exprefs) && (isset($exprefs["userID"]) && $exprefs["userID"] != 0) && sizeof($exprefs) > 0) {
				$_SESSION["prefs"] = $exprefs;
			
			} else {
				$table = PREFS_TABLE;
				$_SESSION["prefs"]["userID"] = $_userdata["ID"];
				doInsetQuery($DB_WE, $table, $_SESSION["prefs"]);
			}
			
			if (isset($_SESSION["user"]["Username"]) && isset($_SESSION["user"]["ID"]) && $_SESSION["user"]["Username"] && $_SESSION["user"]["ID"]) {
				include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/users/we_users.inc.php");
				$foo = new we_user();
				$foo->initFromDB($_SESSION["user"]["ID"]);
				$_SESSION["perms"] = $foo->getAllPermissions();
			} else {
				$_SESSION["perms"]["ADMINISTRATOR"] = 1;
			}
			$_SESSION["user"]["isWeSession"] = true; // for pageLogger, to know that it is really a webEdition session
			

			$_SESSION["user"]["workSpace"] = implode(",", $f);
			$_SESSION["user"]["groups"] = $_userGroups; //	order: first is folder with user himself (deepest in tree)
			if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array(
					"busers", 
					$GLOBALS["_pro_modules"])) {
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $t);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $o);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $n);
				$_SESSION["user"]["workSpace"] .= ";" . implode(",", $nl);
			}
			
			$_SESSION["prefs"] = getHash("SELECT * from " . PREFS_TABLE, $DB_WE);
			
			$exprefs = getHash("SELECT * FROM " . PREFS_TABLE . " WHERE userID=" . $_userdata["ID"], $DB_WE);
			if (is_array($exprefs) && (isset($exprefs["userID"]) && $exprefs["userID"] != 0) && sizeof($exprefs) > 0) {
				$_SESSION["prefs"] = $exprefs;
			
			} else {
				$table = PREFS_TABLE;
				$_SESSION["prefs"]["userID"] = $_userdata["ID"];
				doInsetQuery($DB_WE, $table, $_SESSION["prefs"]);
			}
			
			if (isset($_SESSION["user"]["Username"]) && isset($_SESSION["user"]["ID"]) && $_SESSION["user"]["Username"] && $_SESSION["user"]["ID"]) {
				include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/users/we_users.inc.php");
				$foo = new we_user();
				$foo->initFromDB($_SESSION["user"]["ID"]);
				$_SESSION["perms"] = $foo->getAllPermissions();
			} else {
				$_SESSION["perms"]["ADMINISTRATOR"] = 1;
			}
			$_SESSION["user"]["isWeSession"] = true; // for pageLogger, to know that it is really a webEdition session
		}
	} else {
		$_SESSION["user"]["Username"] = "";
		while (list($name, $val) = each($_SESSION)) {
			unset($_SESSION[$name]);
		}
	}
}
$we_transaction = isset($_REQUEST["we_transaction"]) ? $_REQUEST["we_transaction"] : md5(uniqID(rand()));

if (!isset($_SESSION["we_data"])) {
	$_SESSION["we_data"] = array(
		"$we_transaction" => ""
	);
}

$_SESSION["EditPageNr"] = (isset($_SESSION["EditPageNr"]) && (($_SESSION["EditPageNr"] != "") || ($_SESSION["EditPageNr"] == "0"))) ? $_SESSION["EditPageNr"] : 1;

?>