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

if (!isset($GLOBALS["WE_IS_DYN"])) {
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_live_tools.inc.php");
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_forms.inc.php");
}

if (version_compare(phpversion(), '5.0') < 0) {
	eval('
    function clone($object) {
      return $object;
    }
    ');
}

// bugfix for php 4.1
if (!function_exists('is_a')) {

	function is_a($anObject, $aClass)
	{
		
		return get_class($anObject) == strtolower($aClass) or is_subclass_of($anObject, $aClass);
	}
}

function we_getModuleNameByContentType($ctype)
{
	
	global $_we_active_modules;
	
	$_moduleDir = "";
	for ($i = 0; $i < sizeof($_we_active_modules); $i++) {
		
		if (ereg($_we_active_modules[$i], $ctype)) {
			$_moduleDir = $_we_active_modules[$i];
		}
	}
	return $_moduleDir;
}

function we_getGlobalPath()
{
	if (isset($GLOBALS["WE_MAIN_DOC"]) && isset($GLOBALS["WE_MAIN_DOC"]->Path)) {
		return $GLOBALS["WE_MAIN_DOC"]->Path;
	} else {
		return "";
	}

}

function rmPhp($in)
{
	$out = "";
	$starttag = strpos($in, "<?");
	if ($starttag === false)
		return $in;
	$lastStart = 0;
	while (!($starttag === false)) {
		$endtag = strpos($in, "?" . ">", $starttag);
		$out .= substr($in, $lastStart, ($starttag - $lastStart));
		$lastStart = $endtag + 2;
		$starttag = strpos($in, "<?", $lastStart);
	}
	if ($lastStart < strlen($in))
		$out .= substr($in, $lastStart, (strlen($in) - $lastStart));
	return $out;
}

function decodetmlSpecialChars($in)
{
	$out = str_replace("&lt;", "<", $in);
	$out = str_replace("&gt;", ">", $out);
	$out = str_replace("&quot;", '"', $out);
	$out = str_replace("&#039;", "'", $out);
	$out = str_replace("&amp;", "&", $out);
	return $out;
}

function we_getTagAttributeTagParser($name, $attribs, $default = "", $isFlag = false, $checkForFalse = false)
{
	$out = "";
	if ($isFlag) {
		if ($checkForFalse) {
			$out = (isset($attribs[$name]) && ($attribs[$name] == "false" || $attribs[$name] == "off" || $attribs[$name] == "0")) ? false : true;
		} else {
			$out = (isset($attribs[$name]) && ($attribs[$name] == "true" || $attribs[$name] == "on" || $attribs[$name] == $name || $attribs[$name] == "1")) ? true : false;
		}
	} else {
		$out = isset($attribs[$name]) ? $attribs[$name] : $default;
	}
	return decodetmlSpecialChars($out);
}

function we_getTagAttribute($name, $attribs, $default = "", $isFlag = false, $checkForFalse = false)
{
	$value = isset($attribs[$name]) ? $attribs[$name] : "";
	if (ereg('^\\\\?\$(.+)$', $value, $regs)) {
		$value = isset($GLOBALS[$regs[1]]) ? $GLOBALS[$regs[1]] : "";
	}
	$out = "";
	if ($isFlag) {
		if ($checkForFalse) {
			$out = ($value == "false" || $value == "off" || $value == "0") ? false : true;
		} else {
			$out = ($value == "true" || $value == "on" || $value == $name || $value == "1") ? true : false;
		}
	} else {
		$out = strlen($value) ? $value : $default;
	}
	return decodetmlSpecialChars($out);
}

function we_getIndexFileIDs($db)
{
	$db->query(
			"
		SELECT ID
		FROM " . FILE_TABLE . "
		WHERE IsSearchable=1 AND ((Published > 0 AND (ContentType='text/html' OR ContentType='text/webedition')) OR (ContentType='application/*') )");
	$anz = $db->num_rows();
	$list = "";
	while ($db->next_record())
		$list .= $db->f("ID") . ",";
	$list = ereg_replace('^(.*),$', '\1', $list);
	return $list;
}

function we_getIndexObjectIDs($db)
{
	$db->query("
		SELECT ID
		FROM " . OBJECT_FILES_TABLE . "
		WHERE Published > 0 AND Workspaces != ''");
	$anz = $db->num_rows();
	$list = "";
	while ($db->next_record())
		$list .= $db->f("ID") . ",";
	$list = ereg_replace('^(.*),$', '\1', $list);
	return $list;
}

function correctUml($in)
{
	$in = str_replace("�", "ae", $in);
	$in = str_replace("�", "oe", $in);
	$in = str_replace("�", "ue", $in);
	$in = str_replace("�", "Ae", $in);
	$in = str_replace("�", "Oe", $in);
	$in = str_replace("�", "Ue", $in);
	return str_replace("�", "ss", $in);
}

function we_html2uml($text)
{
	
	$text = str_replace("&uuml;", "�", $text);
	$text = str_replace("&Uuml;", "�", $text);
	$text = str_replace("&auml;", "�", $text);
	$text = str_replace("&Auml;", "�", $text);
	$text = str_replace("&ouml;", "�", $text);
	$text = str_replace("&Ouml;", "�", $text);
	$text = str_replace("&szlig;", "�", $text);
	
	return $text;
}

function inWorkflow($doc)
{
	if (!defined("WORKFLOW_TABLE"))
		return false;
	if (!$doc->IsTextContentDoc)
		return false;
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
	if (!$doc->ID)
		return false;
	return weWorkflowUtility::inWorkflow($doc->ID, $doc->Table);
}

function getAllowedClasses($db = "")
{
	if (!$db) {
		$db = new DB_WE();
	}
	$out = array();
	if (defined("OBJECT_TABLE")) {
		$ws = get_ws();
		$ofWs = get_ws(OBJECT_FILES_TABLE);
		$ofWsArray = makeArrayFromCSV(id_to_path($ofWs, OBJECT_FILES_TABLE));
		
		if (abs($ofWs) == 0) {
			$ofWs = 0;
		}
		if (abs($ws) == 0) {
			$ws = 0;
		}
		$db->query("
			SELECT ID,Workspaces,Path
			FROM " . OBJECT_TABLE . "
			WHERE IsFolder=0");
		
		while ($db->next_record()) {
			$path = $db->f("Path");
			if (!$ws || $_SESSION["perms"]["ADMINISTRATOR"] || (!$db->f("Workspaces")) || in_workspace(
					$db->f("Workspaces"), 
					$ws, 
					FILE_TABLE, 
					"", 
					true)) {
				
				$path2 = $path . "/";
				if (!$ofWs || $_SESSION["perms"]["ADMINISTRATOR"]) {
					array_push($out, $db->f("ID"));
				} else {
					
					// object Workspace check (New since Version 4.x)
					foreach ($ofWsArray as $w) {
						if ($w == $db->f("Path") || (strlen($w) >= strlen($path2) && substr($w, 0, strlen($path2)) == ($path2))) {
							array_push($out, $db->f("ID"));
							break;
						}
					}
				}
			}
		}
	}
	return $out;
}

function getObjectRootPathOfObjectWorkspace($classDir, $classId, $db = "")
{
	if (!$db) {
		$db = new DB_WE();
	}
	$rootPath = "/";
	$rootId = $classId;
	if (defined("OBJECT_TABLE")) {
		$ws = get_ws(OBJECT_FILES_TABLE);
		if (abs($ws) == 0) {
			$ws = 0;
		}
		$db->query(
				"
			SELECT ID,Path
			FROM " . OBJECT_FILES_TABLE . "
			WHERE IsFolder=1 AND Path LIKE '" . $classDir . "%'");
		while ($db->next_record()) {
			if (!$ws || in_workspace($db->f("ID"), $ws, OBJECT_FILES_TABLE, "", true)) {
				if ($rootPath == "/" || strlen($db->f("Path")) < strlen($rootPath)) {
					$rootPath = $db->f("Path");
					$rootId = $db->f("ID");
				}
			}
		}
	}
	return $rootId;
}

function weFileExists($id, $table = FILE_TABLE, $db = "")
{
	if ($id == "0")
		return true;
	if (!$db)
		$db = new DB_WE();
	return f("SELECT ID FROM $table WHERE ID='$id'", "ID", $db);
}

function makePIDTail($pid, $cid, $db = "", $table = FILE_TABLE)
{
	$pid_tail = "";
	if (!$db)
		$db = new DB_WE();
	if ($table == FILE_TABLE) {
		$parentIDs = array();
		array_push($parentIDs, $pid);
		while ($pid != 0) {
			$pid = f("
				SELECT ParentID
				FROM " . FILE_TABLE . "
				WHERE ID='$pid'", "ParentID", $db);
			array_push($parentIDs, $pid);
		}
		$foo = f("
			SELECT DefaultValues
			FROM " . OBJECT_TABLE . "
			WHERE ID='" . $cid . "'", "DefaultValues", $db);
		$fooArr = unserialize($foo);
		if (isset($fooArr["WorkspaceFlag"]))
			$flag = $fooArr["WorkspaceFlag"];
		else
			$flag = 1;
		if ($flag)
			$pid_tail = " ( " . OBJECT_X_TABLE . $cid . ".OF_Workspaces='' OR ";
		else
			$pid_tail = " ( ";
		foreach ($parentIDs as $pid)
			$pid_tail .= " " . OBJECT_X_TABLE . $cid . ".OF_Workspaces like '%,$pid,%' OR " . OBJECT_X_TABLE . $cid . ".OF_ExtraWorkspacesSelected like '%," . $pid . ",%' OR ";
		$pid_tail = ereg_replace('^(.*)OR ', '\1', $pid_tail) . ")";
		if (trim($pid_tail) == "( )")
			return "1";
	} else {
		return "1";
	}
	return $pid_tail;
}

function we_getInputRadioField($name, $value, $itsValue, $atts)
{
	
	//  This function replaced fnc: we_getRadioField
	$atts['type'] = 'radio';
	$atts['name'] = $name;
	$atts['value'] = htmlspecialchars($itsValue);
	if ($value == $itsValue) {
		$atts['checked'] = 'checked';
	}
	return getHtmlTag('input', $atts);
}

function we_getTextareaField($name, $value, $atts)
{
	
	$atts['name'] = $name;
	$atts['rows'] = isset($atts['rows']) ? $atts['rows'] : 5;
	$atts['cols'] = isset($atts['cols']) ? $atts['cols'] : 20;
	
	return getHtmlTag('textarea', $atts, htmlspecialchars($value), true);
}

function we_getInputTextInputField($name, $value, $atts)
{
	
	//  This function replaced we_getTextinputField, but that is still used by we_sessionField
	$atts['type'] = 'text';
	$atts['name'] = $name;
	$atts['value'] = htmlspecialchars($value);
	
	return getHtmlTag('input', $atts);
}

function we_getInputPasswordField($name, $value, $atts)
{
	
	//  This function replaced we_getTextinputField, but that is still used by we_sessionField
	$atts['type'] = 'password';
	$atts['name'] = $name;
	$atts['value'] = htmlspecialchars($value);
	
	return getHtmlTag('input', $atts);
}

function we_getHiddenField($name, $value, $xml = false)
{
	return '<input type="hidden" name="' . $name . '" value="' . htmlspecialchars($value) . '" ' . ($xml ? " /" : "") . '>';
}

function we_getInputChoiceField($name, $value, $values, $atts, $mode, $valuesIsHash = false)
{
	
	//  This function replaced we_getChoiceField
	//  we need input="text" and select-box
	

	//  First input='text'
	//<input type="text"'.($size ? ' size="'.$size.'"' : '').' name="'.$name.'" value="'.htmlspecialchars($value).'" '.$attr.($xml ? " /" :"").'>
	$textField = getHtmlTag(
			'input', 
			array_merge($atts, array(
				'type' => 'text', 'name' => $name, 'value' => htmlspecialchars($value)
			)));
	
	$opts = getHtmlTag('option', array(
		'value' => ''
	), '', true) . "\n";
	
	if ($valuesIsHash) {
		
		foreach ($values as $_val => $_text) {
			$attsOpts['value'] = htmlspecialchars($_val);
			$opts .= getHtmlTag('option', $attsOpts, htmlspecialchars($_text)) . "\n";
		}
	
	} else {
		// options of select Menu
		$options = makeArrayFromCSV($values);
		if (isset($atts['xml'])) {
			$attsOpts['xml'] = $atts['xml'];
		}
		
		for ($i = 0; $i < sizeof($options); $i++) {
			$attsOpts['value'] = htmlspecialchars($options[$i]);
			$opts .= getHtmlTag('option', $attsOpts, htmlspecialchars($options[$i])) . "\n";
		}
	}
	
	// select menu
	if ($mode == "add") {
		$onchange = 'this.form.elements[\'' . $name . '\'].value += ((this.form.elements[\'' . $name . '\'].value ? \' \' : \'\') + this.options[this.selectedIndex].value);';
	} else {
		$onchange = 'this.form.elements[\'' . $name . '\'].value=this.options[this.selectedIndex].value;';
	}
	if (isset($atts['id'])) { //  use another ID!!!!
		$atts['id'] = 'tmp_' . $atts['id'];
	}
	$atts['onchange'] = $onchange . 'this.selectedIndex=0;';
	$atts['name'] = 'tmp_' . $name;
	$atts['size'] = isset($atts['size']) ? $atts['size'] : 1;
	$atts = removeAttribs($atts, array(
		'size'
	)); //  remove size for choice
	$selectMenue = getHtmlTag('select', $atts, $opts, true);
	return '<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $textField . '</td><td>' . $selectMenue . '</td></tr></table>';
}

function we_getInputCheckboxField($name, $value, $attr)
{
	
	//  returns a checkbox with associated hidden-field
	//  This function replaced function: we_getCheckboxField, but is still used one time
	

	$tmpname = md5(uniqid(time()));
	if ($value) {
		$attr['checked'] = 'checked';
	}
	$attr['type'] = 'checkbox';
	$attr['value'] = 1;
	$attr['name'] = $tmpname;
	$attr['onclick'] = 'this.form.elements[\'' . $name . '\'].value=(this.checked) ? 1 : 0';
	
	// hiddenField
	if (isset($attr['xml'])) {
		$_attsHidden['xml'] = $attr['xml'];
	}
	$_attsHidden['type'] = 'hidden';
	$_attsHidden['name'] = $name;
	$_attsHidden['value'] = htmlspecialchars($value);
	
	return getHtmlTag('input', $attr) . getHtmlTag('input', $_attsHidden);
}

function we_getSelectField($name, $value, $values, $attribs = array(), $addMissing = true)
{
	
	$options = makeArrayFromCSV($values);
	$attribs['name'] = $name;
	$content = '';
	$isin = 0;
	for ($i = 0; $i < sizeof($options); $i++) {
		if ($options[$i] == $value) {
			$content .= getHtmlTag('option', array(
				'value' => $options[$i], 'selected' => 'selected'
			), $options[$i], true) . "\n";
			$isin = 1;
		} else {
			$content .= getHtmlTag('option', array(
				'value' => $options[$i]
			), $options[$i], true) . "\n";
		}
	}
	if ((!$isin) && $addMissing) {
		$content .= getHtmlTag('option', array(
			'value' => htmlspecialchars($value), 'selected' => 'selected'
		), htmlspecialchars($value), true) . "\n";
	}
	return getHtmlTag('select', $attribs, $content, true);
}

function we_getCatsFromDoc($doc, $tokken = ",", $showpath = false, $db = "", $rootdir = "/", $catfield = "")
{
	return we_getCatsFromIDs(
			(isset($doc->Category) ? $doc->Category : ""), 
			$tokken, 
			$showpath, 
			$db, 
			$rootdir, 
			$catfield);
}

function we_getCatsFromIDs($catIDs, $tokken = ",", $showpath = false, $db = "", $rootdir = "/", $catfield = "")
{
	if (!$db)
		$db = new DB_WE();
	if ($catIDs) {
		$foo = makeArrayFromCSV($catIDs);
		$cats = array();
		$field = $catfield ? $catfield : ($showpath ? "Path" : "Category");
		if ($catfield) {
			$showpath = false;
		}
		if (!isset($GLOBALS["WE_CATEGORY_CACHE"])) {
			$GLOBALS["WE_CATEGORY_CACHE"] = array();
		}
		for ($i = 0; $i < sizeof($foo); $i++) {
			if (!isset($GLOBALS["WE_CATEGORY_CACHE"][$foo[$i]])) {
				$GLOBALS["WE_CATEGORY_CACHE"][$foo[$i]] = getHash(
						"SELECT ID,Path,Category,Catfields FROM " . CATEGORY_TABLE . " WHERE ID='" . $foo[$i] . "'", 
						$db);
			}
			if ($field == "Title" || $field == "Description") {
				if ($GLOBALS["WE_CATEGORY_CACHE"][$foo[$i]]["Catfields"]) {
					$_arr = unserialize($GLOBALS["WE_CATEGORY_CACHE"][$foo[$i]]["Catfields"]);
					array_push(
							$cats, 
							($field == "Description") ? parseInternalLinks($_arr["default"][$field], 0) : $_arr["default"][$field]);
				} else {
					array_push($cats, "");
				}
			} else {
				array_push($cats, $GLOBALS["WE_CATEGORY_CACHE"][$foo[$i]][$field]);
			}
		}
		if (($showpath || $catfield == "Path") && strlen($rootdir)) {
			for ($i = 0; $i < sizeof($cats); $i++) {
				if (substr($cats[$i], 0, strlen($rootdir)) == $rootdir) {
					$cats[$i] = substr($cats[$i], strlen($rootdir));
				}
			}
		}
		return makeCSVFromArray($cats, false, $tokken);
	}
	return "";
}

function initObject($classID, $formname = "we_global_form", $categories = "", $parentid = '')
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_modules/object/we_objectFile.inc.php");
	
	$session = isset($GLOBALS["WE_SESSION_START"]) && $GLOBALS["WE_SESSION_START"];
	
	if (!(isset($GLOBALS["we_object"]) && is_array($GLOBALS["we_object"])))
		$GLOBALS["we_object"] = array();
	$GLOBALS["we_object"][$formname] = new we_objectFile();
	if ((!$session) || (!isset($_SESSION["we_object_session_$formname"]))) {
		if ($session) {
			$_SESSION["we_object_session_$formname"] = array();
		}
		$GLOBALS["we_object"][$formname]->we_new();
		if (isset($_REQUEST["we_editObject_ID"]) && $_REQUEST["we_editObject_ID"])
			$GLOBALS["we_object"][$formname]->initByID($_REQUEST["we_editObject_ID"], OBJECT_FILES_TABLE);
		else {
			$GLOBALS["we_object"][$formname]->TableID = $classID;
			$GLOBALS["we_object"][$formname]->setRootDirID(true);
			$GLOBALS["we_object"][$formname]->resetParentID();
			$GLOBALS["we_object"][$formname]->restoreDefaults();
			if (strlen($categories)) {
				$categories = makeIDsFromPathCVS($categories, CATEGORY_TABLE);
				$GLOBALS["we_object"][$formname]->Category = $categories;
			}
		}
		
		// save parentid
		if ($parentid) {
			
			// check if parentid is in correct folder ...
			

			$parentfolder = new we_folder();
			$parentfolder->initByID($parentid, OBJECT_FILES_TABLE);
			
			if ($parentfolder) {
				
				if (($GLOBALS["we_object"][$formname]->ParentPath == $parentfolder->Path) || strpos(
						$parentfolder->Path . '/', 
						$GLOBALS["we_object"][$formname]->ParentPath) === 0) {
					$GLOBALS["we_object"][$formname]->ParentID = $parentfolder->ID;
					$GLOBALS["we_object"][$formname]->Path = $parentfolder->Path . '/' . $GLOBALS["we_object"][$formname]->Filename;
				}
			}
		}
		
		if ($session) {
			$GLOBALS["we_object"][$formname]->saveInSession($_SESSION["we_object_session_$formname"]);
		}
		$GLOBALS["we_object"][$formname]->DefArray = $GLOBALS["we_object"][$formname]->getDefaultValueArray();
	} else {
		if (isset($_REQUEST["we_editObject_ID"]) && $_REQUEST["we_editObject_ID"])
			$GLOBALS["we_object"][$formname]->initByID($_REQUEST["we_editObject_ID"], OBJECT_FILES_TABLE);
		else 
			if ($session)
				$GLOBALS["we_object"][$formname]->we_initSessDat($_SESSION["we_object_session_$formname"]);
		if ($classID && ($GLOBALS["we_object"][$formname]->TableID != $classID))
			$GLOBALS["we_object"][$formname]->TableID = $classID;
		if (strlen($categories)) {
			$categories = makeIDsFromPathCVS($categories, CATEGORY_TABLE);
			$GLOBALS["we_object"][$formname]->Category = $categories;
		}
	}
	if (isset($_REQUEST["we_returnpage"])) {
		$GLOBALS["we_object"][$formname]->setElement("we_returnpage", $_REQUEST["we_returnpage"]);
	}
	if (isset($_REQUEST["we_ui_$formname"]) && is_array($_REQUEST["we_ui_$formname"])) {
		$dates = array();
		
		foreach ($_REQUEST["we_ui_$formname"] as $n => $v) {
			if (ereg('^we_date_([a-zA-Z0-9_]+)_(day|month|year|minute|hour)$', $n, $regs)) {
				$dates[$regs[1]][$regs[2]] = $v;
			} else {
				$v = removePHP($v);
				$GLOBALS["we_object"][$formname]->i_convertElemFromRequest("", $v, $n);
				$GLOBALS["we_object"][$formname]->setElement($n, $v);
			}
		
		}
		
		foreach ($dates as $k => $v) {
			$GLOBALS["we_object"][$formname]->setElement(
					$k, 
					mktime(
							$dates[$k]["hour"], 
							$dates[$k]["minute"], 
							0, 
							$dates[$k]["month"], 
							$dates[$k]["day"], 
							$dates[$k]["year"]));
		}
	}
	if (isset($_REQUEST["we_ui_" . $formname . "_categories"])) {
		$cats = $_REQUEST["we_ui_" . $formname . "_categories"];
		// Bug Fix #750
		if (is_array($cats)) {
			$cats = implode(",", $cats);
		}
		$cats = makeIDsFromPathCVS($cats, CATEGORY_TABLE);
		$GLOBALS["we_object"][$formname]->Category = $cats;
	}
	foreach ($GLOBALS["we_object"][$formname]->persistent_slots as $slotname) {
		if ($slotname != "categories" && isset($_REQUEST["we_ui_" . $formname . "_" . $slotname])) {
			eval('$GLOBALS["we_object"][$formname]->' . $slotname . '  =  $_REQUEST["we_ui_".$formname."_".$slotname];');
		}
	}
	
	checkAndPrepareImage($formname, "we_object");
	
	if ($session) {
		$GLOBALS["we_object"][$formname]->saveInSession($_SESSION["we_object_session_$formname"]);
	}
	return $GLOBALS["we_object"][$formname];
}

function initDocument($formname = "we_global_form", $tid = "", $doctype = "", $categories = "")
{
	
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_classes/we_webEditionDocument.inc.php");
	//  check if a <we:sessionStart> Tag was before
	$session = isset($GLOBALS["WE_SESSION_START"]) && $GLOBALS["WE_SESSION_START"];
	
	if (!(isset($GLOBALS["we_document"]) && is_array($GLOBALS["we_document"])))
		$GLOBALS["we_document"] = array();
	$GLOBALS["we_document"][$formname] = new we_webEditionDocument();
	if ((!$session) || (!isset($_SESSION["we_document_session_$formname"]))) {
		if ($session)
			$_SESSION["we_document_session_$formname"] = array();
		$GLOBALS["we_document"][$formname]->we_new();
		if (isset($_REQUEST["we_editDocument_ID"]) && $_REQUEST["we_editDocument_ID"]) {
			$GLOBALS["we_document"][$formname]->initByID($_REQUEST["we_editDocument_ID"], FILE_TABLE);
		} else {
			$dt = f(
					"SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType like '" . $doctype . "'", 
					"ID", 
					$GLOBALS["we_document"][$formname]->DB_WE);
			$GLOBALS["we_document"][$formname]->changeDoctype($dt);
			if ($tid) {
				$GLOBALS["we_document"][$formname]->setTemplateID($tid);
			}
			if (strlen($categories)) {
				$categories = makeIDsFromPathCVS($categories, CATEGORY_TABLE);
				$GLOBALS["we_document"][$formname]->Category = $categories;
			}
		}
		if ($session)
			$GLOBALS["we_document"][$formname]->saveInSession($_SESSION["we_document_session_$formname"]);
	} else {
		if (isset($_REQUEST["we_editDocument_ID"]) && $_REQUEST["we_editDocument_ID"])
			$GLOBALS["we_document"][$formname]->initByID($_REQUEST["we_editDocument_ID"], FILE_TABLE);
		else 
			if ($session)
				$GLOBALS["we_document"][$formname]->we_initSessDat($_SESSION["we_document_session_$formname"]);
		if (strlen($categories)) {
			$categories = makeIDsFromPathCVS($categories, CATEGORY_TABLE);
			$GLOBALS["we_document"][$formname]->Category = $categories;
		}
	}
	
	if (isset($_REQUEST["we_returnpage"]))
		$GLOBALS["we_document"][$formname]->setElement("we_returnpage", $_REQUEST["we_returnpage"]);
	if (isset($_REQUEST["we_ui_$formname"]) && is_array($_REQUEST["we_ui_$formname"])) {
		$dates = array();
		foreach ($_REQUEST["we_ui_$formname"] as $n => $v) {
			if (ereg('^we_date_([a-zA-Z0-9_]+)_(day|month|year|minute|hour)$', $n, $regs)) {
				$dates[$regs[1]][$regs[2]] = $v;
			} else {
				$v = removePHP($v);
				$GLOBALS["we_document"][$formname]->setElement($n, $v);
			}
		}
		
		foreach ($dates as $k => $v)
			$GLOBALS["we_document"][$formname]->setElement(
					$k, 
					mktime(
							$dates[$k]["hour"], 
							$dates[$k]["minute"], 
							0, 
							$dates[$k]["month"], 
							$dates[$k]["day"], 
							$dates[$k]["year"]));
	}
	
	if (isset($_REQUEST["we_ui_" . $formname . "_categories"])) {
		$cats = $_REQUEST["we_ui_" . $formname . "_categories"];
		// Bug Fix #750
		if (is_array($cats)) {
			$cats = implode(",", $cats);
		}
		$cats = makeIDsFromPathCVS($cats, CATEGORY_TABLE);
		$GLOBALS["we_document"][$formname]->Category = $cats;
	}
	foreach ($GLOBALS["we_document"][$formname]->persistent_slots as $slotname) {
		if ($slotname != "categories" && isset($_REQUEST["we_ui_" . $formname . "_" . $slotname])) {
			eval('$GLOBALS["we_document"][$formname]->' . $slotname . '  =  $_REQUEST["we_ui_".$formname."_".$slotname];');
		}
	}
	
	checkAndPrepareImage($formname, "we_document");
	
	if ($session) {
		$GLOBALS["we_document"][$formname]->saveInSession($_SESSION["we_document_session_$formname"]);
	}
	return $GLOBALS["we_document"][$formname];
}

function checkAndPrepareImage($formname, $key = "we_document")
{
	// check to see if there is an image to create or to change
	if (isset($_FILES["we_ui_$formname"]) && is_array($_FILES["we_ui_$formname"])) {
		
		$webuserId = isset($_SESSION["webuser"]["ID"]) ? $_SESSION["webuser"]["ID"] : 0;
		
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_classes/we_imageDocument.inc.php");
		if (isset($_FILES["we_ui_$formname"]["name"]) && is_array($_FILES["we_ui_$formname"]["name"])) {
			foreach ($_FILES["we_ui_$formname"]["name"] as $imgName => $filename) {
				
				$_imgDataId = isset($_REQUEST['WE_UI_IMG_DATA_ID_' . $imgName]) ? $_REQUEST['WE_UI_IMG_DATA_ID_' . $imgName] : false;
				
				if ($_imgDataId !== false && isset($_SESSION[$_imgDataId])) {
					
					$_SESSION[$_imgDataId]['doDelete'] = false;
					
					if (isset($_REQUEST["WE_UI_DEL_CHECKBOX_" . $imgName]) && $_REQUEST["WE_UI_DEL_CHECKBOX_" . $imgName] == 1) {
						$_SESSION[$_imgDataId]['doDelete'] = true;
					} else 
						if ($filename) {
							// file is selected, check to see if it is an image
							$ct = getContentTypeFromFile($filename);
							if ($ct == "image/*") {
								$imgId = abs($GLOBALS[$key][$formname]->getElement($imgName));
								
								// move document from upload location to tmp dir
								$_SESSION[$_imgDataId]["serverPath"] = TMP_DIR . "/" . md5(
										uniqid(rand(), 1));
								move_uploaded_file(
										$_FILES["we_ui_$formname"]["tmp_name"][$imgName], 
										$_SESSION[$_imgDataId]["serverPath"]);
								
								include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
								$we_size = we_thumbnail::getimagesize($_SESSION[$_imgDataId]["serverPath"]);
								
								if (count($we_size) == 0) {
									unset($_SESSION[$_imgDataId]);
									return;
								}
								
								$tmp_Filename = $imgName . "_" . md5(uniqid(rand(), 1)) . "_" . preg_replace(
										"/[^A-Za-z0-9._-]/", 
										"", 
										$_FILES["we_ui_$formname"]["name"][$imgName]);
								
								if ($imgId) {
									$_SESSION[$_imgDataId]["id"] = $imgId;
								}
								
								$_SESSION[$_imgDataId]["fileName"] = eregi_replace(
										'^(.+)\..+$', 
										"\\1", 
										$tmp_Filename);
								$_SESSION[$_imgDataId]["extension"] = (strpos($tmp_Filename, ".") > 0) ? eregi_replace(
										'^.+(\..+)$', 
										"\\1", 
										$tmp_Filename) : "";
								$_SESSION[$_imgDataId]["text"] = $_SESSION[$_imgDataId]["fileName"] . $_SESSION[$_imgDataId]["extension"];
								
								//image needs to be scaled
								if ((isset(
										$_SESSION[$_imgDataId]["width"]) && $_SESSION[$_imgDataId]["width"]) || (isset(
										$_SESSION[$_imgDataId]["height"]) && $_SESSION[$_imgDataId]["height"])) {
									$fh = fopen($_SESSION[$_imgDataId]["serverPath"], "rb");
									$imageData = fread($fh, filesize($_SESSION[$_imgDataId]["serverPath"]));
									fclose($fh);
									$thumb = new we_thumbnail();
									$thumb->init(
											"dummy", 
											$_SESSION[$_imgDataId]["width"], 
											$_SESSION[$_imgDataId]["height"], 
											$_SESSION[$_imgDataId]["keepratio"], 
											$_SESSION[$_imgDataId]["maximize"], 
											false, 
											'', 
											"dummy", 
											0, 
											"", 
											"", 
											$_SESSION[$_imgDataId]["extension"], 
											$we_size[0], 
											$we_size[1], 
											$imageData, 
											"", 
											$_SESSION[$_imgDataId]["quality"]);
									
									$imgData = "";
									$thumb->getThumb($imgData);
									
									$fh = fopen($_SESSION[$_imgDataId]["serverPath"], "wb");
									fwrite($fh, $imgData);
									fclose($fh);
									
									$we_size = we_thumbnail::getimagesize($_SESSION[$_imgDataId]["serverPath"]);
								}
								
								$_SESSION[$_imgDataId]["imgwidth"] = $we_size[0];
								$_SESSION[$_imgDataId]["imgheight"] = $we_size[1];
								$_SESSION[$_imgDataId]["type"] = $_FILES["we_ui_$formname"]["type"][$imgName];
								$_SESSION[$_imgDataId]["size"] = $_FILES["we_ui_$formname"]["size"][$imgName];
							
							}
						}
				}
			
			}
		}
	}
}

function checkAndCreateImage($formname, $type = "we_document")
{
	$webuserId = isset($_SESSION["webuser"]["ID"]) ? $_SESSION["webuser"]["ID"] : 0;
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_classes/we_imageDocument.inc.php");
	
	foreach ($_REQUEST as $key => $_imgDataId) {
		if (preg_match('|^WE_UI_IMG_DATA_ID_(.*)$|', $key, $regs)) {
			$_imgName = $regs[1];
			$imgId = isset($_SESSION[$_imgDataId]["id"]) ? $_SESSION[$_imgDataId]["id"] : 0;
			if (isset($_SESSION[$_imgDataId]['doDelete']) && $_SESSION[$_imgDataId]['doDelete'] == 1) {
				
				if ($imgId) {
					$imgDocument = new we_imageDocument();
					$imgDocument->initByID($imgId);
					if ($imgDocument->WebUserID == $webuserId) {
						//everything ok, now delete
						$GLOBALS["NOT_PROTECT"] = true;
						include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_delete_fn.inc.php");
						deleteEntry($imgId, FILE_TABLE);
						$GLOBALS["NOT_PROTECT"] = false;
						$GLOBALS[$type][$formname]->setElement($_imgName, 0);
					}
				}
			} else 
				if (isset($_SESSION[$_imgDataId]['serverPath'])) {
					if (substr($_SESSION[$_imgDataId]['type'], 0, 6) == "image/") {
						$imgDocument = new we_imageDocument();
						
						if ($imgId) {
							// document has already an image
							// so change binary data
							$imgDocument->initByID(
									$imgId);
						}
						
						$imgDocument->Filename = $_SESSION[$_imgDataId]['fileName'];
						$imgDocument->Extension = $_SESSION[$_imgDataId]['extension'];
						$imgDocument->Text = $_SESSION[$_imgDataId]['text'];
						
						if (!$imgId) {
							$imgDocument->setParentID($_SESSION[$_imgDataId]['parentid']);
						}
						$imgDocument->Path = $imgDocument->getParentPath() . (($imgDocument->getParentPath() != "/") ? "/" : "") . $imgDocument->Text;
						
						$imgDocument->setElement("width", $_SESSION[$_imgDataId]["imgwidth"], "attrib");
						$imgDocument->setElement("height", $_SESSION[$_imgDataId]["imgheight"], "attrib");
						$imgDocument->setElement("origwidth", $_SESSION[$_imgDataId]["imgwidth"]);
						$imgDocument->setElement("origheight", $_SESSION[$_imgDataId]["imgheight"]);
						
						$imgDocument->setElement("type", 'image/*', "attrib");
						
						$imgDocument->setElement("data", $_SESSION[$_imgDataId]["serverPath"], "image");
						
						$imgDocument->setElement("filesize", $_SESSION[$_imgDataId]["size"], "attrib");
						
						$imgDocument->Table = FILE_TABLE;
						$imgDocument->Published = time();
						$imgDocument->WebUserID = $webuserId;
						$imgDocument->we_save();
						$newId = $imgDocument->ID;
						$GLOBALS[$type][$formname]->setElement($_imgName, $newId);
					}
				
				}
			if (isset($_SESSION[$_imgDataId])) {
				unset($_SESSION[$_imgDataId]);
			}
		}
	}
}

function makeIDsFromPathCVS($paths, $table = FILE_TABLE, $prePostKomma = true)
{
	if (strlen($paths) == 0 || strlen($table) == 0)
		return "";
	$foo = makeArrayFromCSV($paths);
	$db = new DB_WE();
	$outArray = array();
	foreach ($foo as $path) {
		$path = trim($path);
		if (substr($path, 0, 1) != "/")
			$path = "/" . $path;
		$id = f("
			SELECT ID
			FROM $table
			WHERE Path='$path'", "ID", $db);
		if ($id)
			array_push($outArray, $id);
	}
	return makeCSVFromArray($outArray, $prePostKomma);
}

function getCatSQLTail($catCSV = '', $table = FILE_TABLE, $catOr = false, $db = "", $fieldName = "Category", $getParentCats = true, $categoryids = '')
{
	$cat_tail = "";
	if (!$db)
		$db = new DB_WE();
	
	if ($categoryids) {
		
		$idarray = makeArrayFromCSV($categoryids);
		
		foreach ($idarray as $catId) {
			$catId = trim($catId);
			if ($catId) {
				$sql = getSQLForOneCatId($catId, $table, $db, $fieldName, $getParentCats);
				$cat_tail .= ($sql . ($catOr ? " OR " : " AND "));
			}
		}
		
		if ($catOr) {
			$cat_tail = ereg_replace('^(.*)OR $', '\1', $cat_tail);
		} else {
			$cat_tail = ereg_replace('^(.*)AND $', '\1', $cat_tail);
		}
		$cat_tail = trim($cat_tail);
		
		if ($cat_tail == "") {
			$cat_tail = " AND " . $table . "." . $fieldName . " = '-1' ";
		} else {
			$cat_tail = " AND (" . $cat_tail . ") ";
		}
	
	} else 
		if ($catCSV) {
			$foo = makeArrayFromCSV($catCSV);
			foreach ($foo as $cat) {
				$cat = trim($cat);
				if (strlen($cat) > 0 && substr($cat, -1) == "/") {
					$cat = substr($cat, 0, strlen($cat) - 1);
				}
				if (substr($cat, 0, 1) != "/") {
					$cat = "/" . $cat;
				}
				$sql = getSQLForOneCat($cat, $table, $db, $fieldName, $getParentCats);
				$cat_tail .= ($sql . ($catOr ? " OR " : " AND "));
			}
			
			if ($catOr) {
				$cat_tail = ereg_replace('^(.*)OR $', '\1', $cat_tail);
			} else {
				$cat_tail = ereg_replace('^(.*)AND $', '\1', $cat_tail);
			}
			
			$cat_tail = trim($cat_tail);
			
			if ($cat_tail == "") {
				$cat_tail = " AND " . $table . "." . $fieldName . " = '-1' ";
			} else {
				$cat_tail = " AND (" . $cat_tail . ") ";
			}
		}
	
	return $cat_tail;
}

function getSQLForOneCatId($cat, $table = FILE_TABLE, $db = "", $fieldName = "Category", $getParentCats = true)
{
	if (!$db) {
		$db = new DB_WE();
	}
	// 1st get path of id
	$query = '
		SELECT Path
		FROM ' . CATEGORY_TABLE . '
		WHERE ID = ' . $cat;
	
	$db->query($query);
	if ($db->next_record()) {
		$catPath = $db->f('Path');
		return getSQLForOneCat($catPath, $table, $db, $fieldName, $getParentCats);
	} else {
		return '';
	}
}

function getSQLForOneCat($cat, $table = FILE_TABLE, $db = "", $fieldName = "Category", $getParentCats = true)
{
	if (!$db)
		$db = new DB_WE();
	$sql = "";
	$q = "
		SELECT DISTINCT ID
		FROM " . CATEGORY_TABLE . "
		WHERE Path LIKE '" . $cat . "/%' OR Path='" . $cat . "'";
	
	$db->query($q);
	$z = 0;
	while ($db->next_record())
		$sql .= " " . $table . "." . $fieldName . " like '%," . $db->f("ID") . ",%' OR ";
	$sql = ereg_replace('^(.*)OR $', '\1', $sql);
	if ($sql)
		return "( $sql )";
	else
		return "";
}

function getHttpOption()
{
	if (ini_get('allow_url_fopen') != 1) {
		@ini_set('allow_url_fopen', '1');
		if (ini_get('allow_url_fopen') != 1) {
			if (function_exists('curl_init')) {
				return 'curl';
			} else {
				return 'none';
			}
		}
	}
	return 'fopen';
}

function getCurlHttp($server, $path, $files = array(), $port = '', $protocol = 'http', $username = '', $password = '', $header = false)
{
	
	$_response = array(
		'data' => '', // data if successful
'status' => 0, // 0=ok otherwise error
'error' => '' // error string
	);
	
	$server = str_replace('http://', '', $server);
	
	$port = defined('HTTP_PORT') ? HTTP_PORT : 80;
	
	$_pathA = explode('?', $path);
	
	$_url = $protocol . '://' . $server . ':' . $port . $_pathA[0];
	
	$_params = array();
	
	$_session = curl_init();
	curl_setopt($_session, CURLOPT_URL, $_url);
	curl_setopt($_session, CURLOPT_RETURNTRANSFER, 1);
	
	if ($username != '') {
		curl_setopt($_session, CURLOPT_USERPWD, $username . ':' . $password);
	}
	
	if (isset($_pathA[1]) && $_pathA[1] != '') {
		$_url_param = explode('&', $_pathA[1]);
		$_len = count($_url_param);
		for ($i = 0; $i < $_len; $i++) {
			$_param_split = explode('=', $_url_param[$i]);
			$_params[$_param_split[0]] = isset($_param_split[1]) ? $_param_split[1] : '';
		}
	}
	
	if (!empty($files)) {
		foreach ($files as $k => $v) {
			$_params[$k] = '@' . $v;
		}
	}
	
	if (!empty($_params)) {
		curl_setopt($_session, CURLOPT_POST, 1);
		curl_setopt($_session, CURLOPT_POSTFIELDS, $_params);
	}
	
	if ($header) {
		curl_setopt($_session, CURLOPT_HEADER, 1);
	}
	
	if (defined('WE_PROXYHOST') && WE_PROXYHOST != '') {
		
		$_proxyhost = defined('WE_PROXYHOST') ? WE_PROXYHOST : '';
		$_proxyport = (defined('WE_PROXYPORT') && WE_PROXYPORT) ? WE_PROXYPORT : '80';
		$_proxy_user = defined('WE_PROXYUSER') ? WE_PROXYUSER : '';
		$_proxy_pass = defined('WE_PROXYPASSWORD') ? WE_PROXYPASSWORD : '';
		
		if ($_proxyhost != '') {
			curl_setopt($_session, CURLOPT_PROXY, $proxyhost . ":" . $proxyport);
			if ($proxy_user != '') {
				curl_setopt($_session, CURLOPT_PROXYUSERPWD, $proxy_user . ':' . $proxy_pass);
			}
			curl_setopt($_session, CURLOPT_SSL_VERIFYPEER, FALSE);
		}
	}
	
	$_data = curl_exec($_session);
	
	if (curl_errno($_session)) {
		$_response['status'] = 1;
		$_response['error'] = curl_error($_session);
		return false;
	} else {
		$_response['status'] = 0;
		$_response['data'] = $_data;
		curl_close($_session);
	}
	
	return $_response;
}

function getHTTP($server, $url, $port = "", $username = "", $password = "")
{
	
	$_opt = getHttpOption();
	
	if ($_opt == 'fopen') {
		
		if (!$port) {
			$port = defined("HTTP_PORT") ? HTTP_PORT : 80;
		}
		
		$foo = "http://" . (($username && $password) ? "$username:$password@" : "") . $server . ":" . $port . $url;
		$page = "Server Error: Failed opening URL: $foo";
		$fh = @fopen($foo, "rb");
		if ($fh) {
			$page = "";
			while (!feof($fh))
				$page .= fgets($fh, 1024);
			fclose($fh);
		}
		return $page;
	
	} else 
		if ($_opt == 'curl') {
			
			$_response = getCurlHttp($server, $url, array(), $port, 'http', $username, $password);
			
			if ($_response['status'] != 0) {
				return $_response['error'];
			} else {
				return $_response['data'];
			}
		
		} else {
			return "Server error: Unable to open URL (php configuration directive allow_url_fopen=Off)";
		}
}

function attributFehltError($attribs, $attr, $tag, $canBeEmpty = false)
{
	if ($canBeEmpty) {
		if (!isset($attribs[$attr]))
			return parseError(sprintf($GLOBALS["l_parser"]["attrib_missing2"], $attr, $tag));
	} else {
		if (!isset($attribs[$attr]) || $attribs[$attr] == "")
			return parseError(sprintf($GLOBALS["l_parser"]["attrib_missing"], $attr, $tag));
	}
	return "";
}

function parseError($text)
{
	return "<b>" . $GLOBALS["l_parser"]["error_in_template"] . ":</b> $text<br>\n";
}

function std_numberformat($content)
{
	if (ereg('.*,[0-9]*$', $content)) {
		// Deutsche Schreibweise
		$umschreib = ereg_replace('(.*),([0-9]*)$', '\1.\2', $content);
		$pos = strrpos($content, ",");
		$vor = str_replace(".", "", substr($umschreib, 0, $pos));
		$content = $vor . substr($umschreib, $pos, strlen($umschreib) - $pos);
	} else 
		if (ereg('.*\.[0-9]*$', $content)) {
			// Englische Schreibweise
			$pos = strrpos($content, ".");
			$vor = substr($content, 0, $pos);
			$vor = ereg_replace('[,\.]', '', $vor);
			$content = $vor . substr($content, $pos, strlen($content) - $pos);
		} else
			$content = ereg_replace('[,\.]', '', $content);
	return $content;
}

function decode($in)
{
	$out = "";
	for ($i = 0; $i < strlen($in); $i++)
		$out .= chr(ord(substr($in, $i, 1)) + 1);
	return $out;
}

function encode($in)
{
	$out = "";
	for ($i = 0; $i < strlen($in); $i++)
		$out .= chr(ord(substr($in, $i, 1)) - 1);
	return $out;
}

function deleteContentFromDB($id, $table)
{
	$DB_WE = new DB_WE();
	$dbc = new DB_WE();
	if (!$DB_WE->query(
			"
		SELECT *
		FROM " . LINK_TABLE . "
		WHERE DID=$id AND DocumentTable='" . substr($table, strlen(TBL_PREFIX)) . "'")) {
		return false;
	}
	while ($DB_WE->next_record())
		$dbc->query("
			DELETE
			FROM " . CONTENT_TABLE . "
			WHERE ID=" . $DB_WE->f("CID"));
	return $DB_WE->query(
			"
		DELETE
		FROM " . LINK_TABLE . "
		WHERE DID=$id AND DocumentTable='" . substr($table, strlen(TBL_PREFIX)) . "'");
}

function cleanTempFiles($cleanSessFiles = 0)
{
	global $DB_WE;
	$db2 = new DB_WE();
	$sess = $DB_WE->query("
		SELECT Date,Path
		FROM " . CLEAN_UP_TABLE . "
		WHERE Date <= " . (time() - 300));
	if ($DB_WE->num_rows())
		while ($DB_WE->next_record()) {
			$p = $DB_WE->f("Path");
			if (file_exists($p))
				deleteLocalFile($DB_WE->f("Path"));
			$db2->query(
					"
				DELETE
				FROM " . CLEAN_UP_TABLE . "
				WHERE DATE=" . $DB_WE->f("Date") . " AND Path='" . $DB_WE->f(
							"Path") . "'");
		}
	if ($cleanSessFiles) {
		$seesID = session_id();
		$DB_WE->query("
			SELECT Date,Path
			FROM " . CLEAN_UP_TABLE . "
			WHERE Path like '%$seesID%'");
		if ($DB_WE->num_rows())
			while ($DB_WE->next_record()) {
				$p = $DB_WE->f("Path");
				if (file_exists($p))
					deleteLocalFile($DB_WE->f("Path"));
				$db2->query("
					DELETE
					FROM " . CLEAN_UP_TABLE . "
					WHERE Path like '%$seesID%'");
			}
	}
	$d = dir(TMP_DIR);
	while (false !== ($entry = $d->read())) {
		if ($entry != "." && $entry != "..") {
			$foo = TMP_DIR . "/" . $entry;
			if (filemtime($foo) <= (time() - 300)) {
				if (is_dir($foo))
					deleteLocalFolder($foo, 1);
				else 
					if (file_exists($foo))
						deleteLocalFile($foo);
			}
		}
	}
	$d->close();
	
	// when a fragment task was stopped by the user, the tmp file will not be deleted! So we have to clean up
	$d = dir(WE_FRAGMENT_DIR);
	while (false !== ($entry = $d->read())) {
		if ($entry != "." && $entry != "..") {
			$foo = WE_FRAGMENT_DIR . "/" . $entry;
			if (filemtime($foo) <= (time() - 3600 * 24)) {
				if (is_dir($foo))
					deleteLocalFolder($foo, 1);
				else 
					if (file_exists($foo))
						deleteLocalFile($foo);
			}
		}
	}
	$d->close();
}

function getUsedTemplatesOfTemplate($id, &$arr)
{
	global $DB_WE;
	$_hash = getHash(
			"SELECT IncludedTemplates, MasterTemplateID FROM " . TEMPLATES_TABLE . " WHERE ID=" . abs($id), 
			$DB_WE);
	$_tmplCSV = isset($_hash['IncludedTemplates']) ? $_hash['IncludedTemplates'] : "";
	$_masterTemplateID = isset($_hash['MasterTemplateID']) ? $_hash['MasterTemplateID'] : 0;
	
	$_tmpArr = makeArrayFromCSV($_tmplCSV);
	foreach ($_tmpArr as $_tid) {
		if (!in_array($_tid, $arr) && $_tid != $id) {
			$arr[] = $_tid;
		}
	}
	foreach ($_tmpArr as $_tid) {
		getUsedTemplatesOfTemplate($_tid, $arr);
	}
	
	$_tmpArr = makeArrayFromCSV($_tmplCSV);
	foreach ($_tmpArr as $_tid) {
		if (!in_array($_tid, $arr) && $_tid != $id) {
			$arr[] = $_tid;
		}
	}
	if ($_masterTemplateID && !in_array($_masterTemplateID, $arr)) {
		getUsedTemplatesOfTemplate($_masterTemplateID, $arr);
	}
	
	foreach ($_tmpArr as $_tid) {
		getUsedTemplatesOfTemplate($_tid, $arr);
	}

}

function getTemplatesOfTemplate($id, &$arr)
{
	global $DB_WE;
	$DB_WE->query(
			"SELECT ID FROM " . TEMPLATES_TABLE . " WHERE MasterTemplateID=" . abs($id) . " OR IncludedTemplates LIKE '%," . abs(
					$id) . ",%'");
	while ($DB_WE->next_record()) {
		array_push($arr, $DB_WE->f("ID"));
	}
	$foo = $arr;
	
	$_len = count($foo);
	
	if (in_array($id, $arr)) {
		return;
	}
	
	for ($i = 0; $i < $_len; $i++) {
		getTemplatesOfTemplate($foo[$i], $arr);
	}

}

function getTemplAndDocIDsOfTemplate($id, $staticOnly = true, $publishedOnly = false, $PublishedAndTemp = false)
{
	global $DB_WE;
	if (!$id)
		return 0;
	
	$returnIDs = array();
	$returnIDs["templateIDs"] = array();
	$returnIDs["documentIDs"] = array();
	
	getTemplatesOfTemplate($id, $returnIDs["templateIDs"]);
	
	// first we need to check if template is included within other templates
	//$DB_WE->query("SELECT ID FROM ".TEMPLATES_TABLE." WHERE MasterTemplateID=".abs($id)." OR IncludedTemplates LIKE '%,".abs($id).",%'");
	//while ($DB_WE->next_record()) {
	//	array_push($returnIDs["templateIDs"], $DB_WE->f("ID"));
	//}
	

	// Bug Fix 6615
	if ($PublishedAndTemp) {
		$where = " temp_template_id='" . $id . "' OR ";
		$where .= " TemplateID='" . $id . "' OR ";
		foreach ($returnIDs["templateIDs"] as $tid) {
			$where .= " temp_template_id='" . $tid . "' OR ";
			$where .= " TemplateID='" . $tid . "' OR ";
		}
	} else {
		$where = " TemplateID='" . $id . "' OR ";
		foreach ($returnIDs["templateIDs"] as $tid) {
			$where .= " TemplateID='" . $tid . "' OR ";
		}
	}
	// remove last OR
	$where = substr($where, 0, strlen($where) - 3);
	$where = '(' . $where . ')';
	
	if ($staticOnly) {
		$where .= " AND IsDynamic=0";
	}
	
	if ($publishedOnly) {
		$where .= " AND Published>0";
	}
	
	$DB_WE->query("
		SELECT ID
		FROM " . FILE_TABLE . "
		WHERE $where");
	
	while ($DB_WE->next_record()) {
		array_push($returnIDs["documentIDs"], $DB_WE->f("ID"));
	}
	return $returnIDs;
}

function ObjectUsedByObjectFile($id)
{
	global $DB_WE;
	if (!$id)
		return 0;
	$DB_WE->query("
		SELECT ID
		FROM " . OBJECT_FILES_TABLE . "
		WHERE TableID='" . $id . "'");
	return $DB_WE->num_rows();
}

function deleteLocalFile($filename)
{
	if (!file_exists($filename))
		return false;
	return unlink($filename);
}

function dbDateToTimeStamp($date, $time = "")
{
	list($y, $m, $d) = explode("-", $date);
	list($hr, $min, $sec) = $time ? explode(":", $time) : array(
		0, 0, 0
	);
	return mktime($hr, $min, $sec, $m, $d, $y);
}

function we_makeHiddenFields($filter = "")
{
	$filterArr = explode(",", $filter);
	$hidden = "";
	if ($_REQUEST) {
		reset($_REQUEST);
		while (list($key, $val) = each($_REQUEST))
			if (!in_array($key, $filterArr)) {
				if (is_array($val)) {
					for ($i = 0; $i < sizeof($val); $i++)
						$hidden .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($val[$i]) . '">';
				} else
					$hidden .= '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars($val) . '">';
			}
	}
	return $hidden;
}

function we_make_attribs($attribs, $doNotUse = "")
{
	$attr = "";
	$fil = explode(",", $doNotUse);
	//array_push($fil,"xml");
	array_push($fil, "user");
	array_push($fil, "removefirstparagraph");
	if (is_array($attribs)) {
		reset($attribs);
		while (list($k, $v) = each($attribs))
			if (!in_array($k, $fil))
				$attr .= "$k=\"$v\" ";
		$attr = trim($attr);
	}
	return $attr;
}

function debug($text)
{
	$fp = fopen(TMP_DIR . "/debug.txt", "ab");
	fwrite($fp, $text);
	fclose($fp);
}

function debug2html($text)
{
	if (!($fp = fopen(LOG_DIR . "/debug.html", "ab"))) {
		mkdir(WE_LOG, 0755);
		$fp = fopen(LOG_DIR . "/debug.html", "ab");
	}
	
	fwrite($fp, "<pre>" . $text . "</pre>");
	fclose($fp);
}

function we_hasPerm($perm)
{
	
	if (isset($_SESSION["perms"]["ADMINISTRATOR"]) && $_SESSION["perms"]["ADMINISTRATOR"]) {
		return true;
	}
	
	return ((isset($_SESSION["perms"][$perm]) && $_SESSION["perms"][$perm]) || (!isset($_SESSION["perms"][$perm])));
}

function we_userCanEditModule($modName)
{
	global $_we_available_modules;
	$one = false;
	$set = array();
	$enable = 1;
	if ($_SESSION["perms"]["ADMINISTRATOR"]) {
		return true;
	}
	foreach ($_we_available_modules as $m)
		if ($m["name"] == $modName) {
			
			$p = isset($m["perm"]) ? $m["perm"] : "";
			$or = explode("||", $p);
			foreach ($or as $k => $v) {
				$and = explode("&&", $v);
				$one = true;
				foreach ($and as $key => $val) {
					array_push($set, 'isset($_SESSION["perms"]["' . trim($val) . '"])');
					$and[$key] = '$_SESSION["perms"]["' . trim($val) . '"]';
					$one = false;
				}
				$or[$k] = implode(" && ", $and);
				if ($one && !in_array('isset($_SESSION["perms"]["' . trim($v) . '"])', $set))
					array_push($set, 'isset($_SESSION["perms"]["' . trim($v) . '"])');
			}
			$set_str = implode(" || ", $set);
			$condition_str = implode(" || ", $or);
			eval('if (' . $set_str . '){ if (' . $condition_str . ') { $enable=1; } else { $enable=0; } }');
			return $enable;
		}
	return $enable;
}

function makeOwnersSql($useCreatorID = true)
{
	if (defined("BIG_USER_MODULE") && in_array("busers", $GLOBALS["_pro_modules"]) && (!$_SESSION["perms"]["ADMINISTRATOR"])) {
		$aliases = array(
			$_SESSION["user"]["ID"]
		);
		we_getAliases($_SESSION["user"]["ID"], $aliases, $GLOBALS["DB_WE"]);
		$q = $useCreatorID ? "CreatorID IN ('" . implode("','", $aliases) . "') OR " : "";
		foreach ($aliases as $id)
			$q .= "Owners like '%,$id,%' OR ";
		$groups = array(
			$_SESSION["user"]["ID"]
		);
		we_getParentIDs(USER_TABLE, $_SESSION["user"]["ID"], $groups, $GLOBALS["DB_WE"]);
		foreach ($aliases as $id)
			we_getParentIDs(USER_TABLE, $id, $groups, $GLOBALS["DB_WE"]);
		foreach ($groups as $id)
			$q .= "Owners like '%,$id,%' OR ";
		$q = ereg_replace('^(.*) OR $', '\1', $q);
		return " AND ( RestrictOwners=0 OR (" . $q . ")) ";
	} else
		return "";
}

function we_getParentIDs($table, $id, &$ids, $db = "")
{
	if (!$db)
		$db = new DB_WE();
	$pid = f("
		SELECT ParentID
		FROM $table
		WHERE ID='$id'", "ParentID", $db);
	while ($pid > 0) {
		array_push($ids, $pid);
		$pid = f("
			SELECT ParentID
			FROM $table
			WHERE ID='" . $pid . "'", "ParentID", $db);
	}
}

function we_getAliases($id, &$ids, $db = "")
{
	if (!$db)
		$db = new DB_WE();
	if (!defined("BIG_USER_MODULE") || !in_array("busers", $GLOBALS["_pro_modules"]))
		return;
	$db->query("
		SELECT ID
		FROM " . USER_TABLE . "
		WHERE Alias='$id'", "ID", $db);
	while ($db->next_record())
		array_push($ids, $db->f("ID"));
}

function we_isOwner($csvOwners)
{
	include_once (WE_USERS_MODULE_DIR . "we_users_util.php");
	if ($_SESSION["perms"]["ADMINISTRATOR"]) {
		return true;
	}
	$ownersArray = makeArrayFromCSV($csvOwners);
	if (in_array($_SESSION["user"]["ID"], $ownersArray)) {
		return true;
	}
	return isUserInUsers($_SESSION["user"]["ID"], $csvOwners);
}

function makeArrayFromCSV($csv)
{
	
	$csv = str_replace("\\,", "###komma###", $csv);
	
	if (substr($csv, 0, 1) == ",") {
		$csv = substr($csv, 1);
	}
	
	if (substr($csv, -1) == ",") {
		$csv = substr($csv, 0, strlen($csv) - 1);
	}
	
	if ($csv == "" && $csv != "0") {
		
		$foo = array();
	
	} else {
		
		$foo = explode(",", $csv);
		
		for ($i = 0; $i < sizeof($foo); $i++) {
			
			$foo[$i] = str_replace("###komma###", ",", $foo[$i]);
		}
	}
	return $foo;
}

function makeCSVFromArray($arr, $prePostKomma = false, $sep = ",")
{
	if (!sizeof($arr))
		return "";
	
	$replaceKomma = (count($arr) > 1) || ($prePostKomma == true);
	
	if ($replaceKomma) {
		for ($i = 0; $i < sizeof($arr); $i++) {
			$arr[$i] = str_replace($sep, "###komma###", $arr[$i]);
		}
	}
	$out = implode($sep, $arr);
	if ($prePostKomma) {
		$out = $sep . $out . $sep;
	}
	if ($replaceKomma) {
		$out = str_replace("###komma###", "\\$sep", $out);
	}
	return $out;
}

function shortenPath($path, $len)
{
	if (strlen($path) <= $len || strlen($path) < 10)
		return $path;
	$l = ($len / 2) - 2;
	return substr($path, 0, $l) . "...." . substr($path, $l * -1);
}

function shortenPathSpace($path, $len)
{
	if (strlen($path) <= $len || strlen($path) < 10)
		return $path;
	$l = $len;
	return substr($path, 0, $l) . " " . shortenPathSpace(substr($path, $l), $len);
}

function in_parentID($id, $pid, $table = FILE_TABLE, $db = "")
{
	if (abs($pid) != 0 && abs($id) == 0)
		return false;
	if (abs($pid) == 0 || $id == $pid || ($id == "" && $id != "0"))
		return true;
	if (!$db)
		$db = new DB_WE();
	$p = f("
		SELECT ParentID
		FROM $table
		WHERE ID='$id'", "ParentID", $db);
	while ($p) {
		if ($p == $pid)
			return true;
		$p = f("
			SELECT ParentID
			FROM $table
			WHERE ID='$p'", "ParentID", $db);
	}
	return false;
}

function in_workspace($IDs, $wsIDs, $table = FILE_TABLE, $db = "", $objcheck = false)
{
	if (!$db) {
		$db = new DB_WE();
	}
	if (!is_array($IDs)) {
		$IDs = makeArrayFromCSV($IDs);
	}
	if (!is_array($wsIDs)) {
		$wsIDs = makeArrayFromCSV($wsIDs);
	}
	if (!sizeof($wsIDs)) {
		return true;
	}
	if (!sizeof($IDs)) {
		return true;
	}
	if (in_array(0, $wsIDs)) {
		return true;
	}
	if ((!$objcheck) && in_array(0, $IDs)) {
		return false;
	}
	foreach ($IDs as $id) {
		foreach ($wsIDs as $ws) {
			if (in_parentID($id, $ws, $table, $db) || ($id == $ws) || ($id == 0)) {
				return true;
			}
		}
	}
	return false;
}

function userIsOwnerCreatorOfParentDir($folderID, $tab)
{
	if ($tab != FILE_TABLE && $tab != OBJECT_FILES_TABLE)
		return true;
	if ($_SESSION["perms"]["ADMINISTRATOR"])
		return true;
	if ($folderID == 0)
		return true;
	include_once (WE_USERS_MODULE_DIR . "we_users_util.php");
	$db = new DB_WE();
	$db->query("
		SELECT RestrictOwners,Owners,CreatorID
		FROM $tab
		WHERE ID='$folderID'");
	if ($db->next_record())
		if ($db->f("RestrictOwners")) {
			$ownersArr = makeArrayFromCSV($db->f("Owners"));
			foreach ($ownersArr as $uid)
				addAllUsersAndGroups($uid, $ownersArr);
			array_push($ownersArr, $db->f("CreatorID"));
			$ownersArr = array_unique($ownersArr);
			if (in_array($_SESSION["user"]["ID"], $ownersArr)) {
				return true;
			} else {
				return false;
			}
		} else {
			$pid = f("SELECT ParentID FROM $tab WHERE ID='$folderID'", "ParentID", $db);
			return userIsOwnerCreatorOfParentDir($pid, $tab);
		}
	return true;
}

function path_to_id($path, $table = FILE_TABLE)
{
	$db = new DB_WE();
	if ($path == "/") {
		return 0;
	}
	return abs(f("SELECT ID FROM $table WHERE Path='$path'", "ID", $db));
}

function weConvertToIds($paths, $table)
{
	if (!is_array($paths))
		return array();
	$paths = array_unique($paths);
	$ids = array();
	foreach ($paths as $p) {
		$ids[] = path_to_id($p, $table);
	}
	return $ids;
}

function path_to_id_ct($path, $table = FILE_TABLE, &$contentType)
{
	$db = new DB_WE();
	if ($path == "/") {
		return 0;
	}
	$res = getHash("SELECT ID,ContentType FROM $table WHERE Path='$path'", $db);
	$contentType = isset($res["ContentType"]) ? $res["ContentType"] : null;
	
	return abs(isset($res["ID"]) ? $res["ID"] : 0);
}

function id_to_path($IDs, $table = FILE_TABLE, $db = "", $prePostKomma = false, $asArray = false, $endslash = false)
{
	if (!is_array($IDs) && !$IDs) {
		return "/";
	}
	if (!$db) {
		$db = new DB_WE();
	}
	if (!is_array($IDs)) {
		$IDs = makeArrayFromCSV($IDs);
	}
	$foo = array();
	foreach ($IDs as $id) {
		if ($id == 0) {
			array_push($foo, "/");
		} else {
			$foo2 = getHash("SELECT Path,IsFolder FROM $table WHERE ID='$id'", $db);
			if (isset($foo2["Path"])) {
				if ($endslash && $foo2["IsFolder"]) {
					$foo2["Path"] .= "/";
				}
				array_push($foo, $foo2["Path"]);
			}
		}
	}
	if ($asArray) {
		return $foo;
	} else {
		return makeCSVFromArray($foo, $prePostKomma);
	}
}

function getHashArrayFromCSV($csv, $firstEntry = "", $db)
{
	if (!$csv)
		return array();
	if (!$db)
		$db = new DB_WE();
	$IDArr = makeArrayFromCSV($csv);
	$out = $firstEntry ? array(
		"0" => $firstEntry
	) : array();
	foreach ($IDArr as $i => $id) {
		if (strlen($id) && ($path = id_to_path($id, FILE_TABLE, $db))) {
			$out[$id] = $path;
		}
	}
	return $out;
}

function getPathsFromTable($table = FILE_TABLE, $db = "", $type = FILE_ONLY, $wsIDs = "", $order = "Path", $limitCSV = "", $first = "")
{
	if (!$db)
		$db = new DB_WE();
	$limitCSV = ereg_replace('^,(.*),$', '\1', $limitCSV);
	$q = "";
	if ($wsIDs) {
		$idArr = makeArrayFromCSV($wsIDs);
		$wsPaths = makeArrayFromCSV(id_to_path($wsIDs, $table, $db));
		$qfoo = " ( ";
		for ($i = 0; $i < sizeof($wsPaths); $i++)
			if ((!$limitCSV) || in_workspace($idArr[$i], $limitCSV, FILE_TABLE, $db))
				$qfoo .= " Path like '" . $wsPaths[$i] . "%' OR ";
		if ($qfoo == " ( ")
			$qfoo = "";
		$qfoo = ereg_replace('^(.*)OR $', '\1', $qfoo);
		if ($qfoo)
			$qfoo .= " ) ";
		else
			return array();
		$q .= $qfoo;
	}
	$q2 = "";
	switch ($type) {
		case FILE_ONLY :
			$q2 = " IsFolder=0 ";
			break;
		case FOLDER_ONLY :
			$q2 = " IsFolder=1 ";
			break;
	}
	$q3 = "";
	$out = $first ? array(
		"0" => $first
	) : array();
	$db->query(
			"
		SELECT ID,Path
		FROM $table " . (($q || $q2 || $q3) ? "
		WHERE " : "") . $q . (($q && $q2) ? " AND " : "") . $q2 . ((($q || $q2) && $q3) ? " AND " : "") . $q3 . "
		ORDER BY $order");
	while ($db->next_record())
		$out[$db->f("ID")] = $db->f("Path");
	return $out;
}

function pushChildsFromArr(&$arr, $table = FILE_TABLE, $isFolder = "")
{
	$tmpArr = $arr;
	$tmpArr2 = array();
	foreach ($arr as $id)
		pushChilds($tmpArr, $id, $table, $isFolder);
	foreach (array_unique($tmpArr) as $id)
		array_push($tmpArr2, $id);
	return $tmpArr2;
}

function pushChilds(&$arr, $id, $table = FILE_TABLE, $isFolder = "")
{
	$db = new DB_WE();
	array_push($arr, $id);
	$db->query(
			"
		SELECT ID
		FROM $table
		WHERE ParentID='$id'" . (($isFolder != "" || $isFolder == "0") ? (" AND IsFolder='$isFolder'") : ""));
	while ($db->next_record())
		pushChilds($arr, $db->f("ID"), $table, $isFolder);
}

function uniqueCSV($csv, $prePost = false)
{
	$arr = array_unique(makeArrayFromCSV($csv));
	$foo = array();
	foreach ($arr as $v)
		array_push($foo, $v);
	return makeCSVFromArray($foo, $prePost);
}

function get_ws($table = FILE_TABLE, $prePostKomma = false)
{
	
	switch ($table) {
		case FILE_TABLE :
			$type = 0;
			break;
		case TEMPLATES_TABLE :
			$type = 1;
			break;
		case NAVIGATION_TABLE :
			$type = 3;
			break;
		default :
			if (defined('OBJECT_FILES_TABLE') && $table == OBJECT_FILES_TABLE) {
				$type = 2;
				break;
			} else 
				if (defined('NEWSLETTER_TABLE') && $table == NEWSLETTER_TABLE) {
					$type = 4;
					break;
				}
			return "";
	}
	
	if (isset($_SESSION) && isset($_SESSION['perms'])) {
		
		if ($_SESSION["perms"]["ADMINISTRATOR"]) {
			return "";
		}
		if ($_SESSION["user"]["workSpace"] && $_SESSION["user"]["workSpace"] != ";") {
			$a = explode(";", $_SESSION["user"]["workSpace"]);
			return makeCSVFromArray(makeArrayFromCSV($a[$type]), $prePostKomma);
		}
	}
	return "";
}

function we_readParents($id, &$parentlist, $tab, $match = 'ContentType', $matchvalue = 'folder')
{
	$db_temp = new DB_WE();
	$db_temp1 = new DB_WE();
	$db_temp->query("
		SELECT ParentID
		FROM $tab
		WHERE ID='" . $id . "'");
	while ($db_temp->next_record())
		if ($db_temp->f("ParentID") == 0) {
			array_push($parentlist, $db_temp->f("ParentID"));
			break;
		} else {
			$db_temp1->query("
				SELECT $match
				FROM $tab
				WHERE ID='" . $db_temp->f("ParentID") . "'");
			if ($db_temp1->next_record())
				if ($db_temp1->f($match) == $matchvalue) {
					array_push($parentlist, $db_temp->f("ParentID"));
					we_readParents($db_temp->f("ParentID"), $parentlist, $tab);
				}
		}
}

function we_readChilds($pid, &$childlist, $tab, $folderOnly = true, $where = '', $match = 'ContentType', $matchvalue = 'folder')
{
	$db_temp = new DB_WE();
	$db_temp->query(
			"
		SELECT ID,$match
		FROM $tab
		WHERE " . ($folderOnly ? " IsFolder=1 AND " : "") . "ParentID='" . $pid . "'" . $where);
	while ($db_temp->next_record()) {
		if ($db_temp->f($match) == $matchvalue) {
			we_readChilds($db_temp->f("ID"), $childlist, $tab, $folderOnly);
		}
		array_push($childlist, $db_temp->f("ID"));
	}
}

function getWsQueryForSelector($tab, $includingFolders = true)
{
	
	$wsQuery = '';
	
	if ($_SESSION['perms']['ADMINISTRATOR']) {
		return '';
	}
	
	if ($ws = makeArrayFromCSV(get_ws($tab))) {
		$paths = id_to_path($ws, $tab, '', false, true);
		$wsQuery .= ' AND (';
		foreach ($paths as $path) {
			$parts = explode("/", $path);
			array_shift($parts);
			$last = array_pop($parts);
			$path = "/";
			foreach ($parts as $part) {
				
				$path .= $part;
				if ($includingFolders) {
					$wsQuery .= ' (Path = "' . $path . '") OR ';
				} else {
					$wsQuery .= ' (Path LIKE "' . $path . '/%") OR ';
				}
				$path .= "/";
			
			}
			$path .= $last;
			if ($includingFolders) {
				$wsQuery .= ' (Path = "' . $path . '" OR Path LIKE "' . $path . '/%") OR ';
			} else {
				$wsQuery .= ' (Path LIKE "' . $path . '/%") OR ';
			}
			$wsQuery .= ' (Path LIKE "' . $path . '/%") OR ';
		
		}
		$wsQuery .= ' 0 )'; // end with "OR 0"
	}
	return $wsQuery;
}

function getWsFileList($table, $childsOnly = false)
{
	if ($_SESSION["perms"]["ADMINISTRATOR"]) {
		return "";
	}
	if ($table != FILE_TABLE && $table != TEMPLATES_TABLE) {
		return "";
	}
	$db = new DB_WE();
	$wsFileList = "";
	
	$workspaces = makeArrayFromCSV(get_ws($table));
	if (sizeof($workspaces)) {
		$childList = array();
		foreach ($workspaces as $value) {
			array_push($childList, $value);
			$myPath = id_to_path($value, $table);
			$_query = "SELECT ID FROM $table WHERE 0 ";
			if (!$childsOnly) {
				$parts = explode("/", $myPath);
				array_shift($parts);
				array_pop($parts);
				$path = "/";
				foreach ($parts as $part) {
					$path .= $part;
					$_query .= "OR PATH = '$path' ";
					$path .= "/";
				}
			}
			$_query .= "OR PATH LIKE '$myPath/%' OR PATH = '$myPath' ";
			$db->query($_query);
			while ($db->next_record()) {
				array_push($childList, $db->f("ID"));
			}
		}
		if (sizeof($wsFileList)) {
			$wsFileList = implode(",", $childList);
		}
	}
	return $wsFileList;

}

function get_def_ws($table = FILE_TABLE, $prePostKomma = false)
{
	if (!get_ws($table, $prePostKomma)) { // WORKARROUND
		return "";
	}
	if ($_SESSION["perms"]["ADMINISTRATOR"])
		return "";
	$ws = "";
	if (defined("BIG_USER_MODULE") && in_array("busers", $GLOBALS["_pro_modules"])) {
		$foo = f(
				"
			SELECT workSpaceDef
			FROM " . USER_TABLE . "
			WHERE ID='" . $_SESSION["user"]["ID"] . "'", 
				"workSpaceDef", 
				new DB_WE());
		$ws = makeCSVFromArray(makeArrayFromCSV($foo), $prePostKomma);
	}
	if ($ws == "") {
		$wsA = makeArrayFromCSV(get_ws($table, $prePostKomma));
		if (sizeof($wsA))
			return $wsA[0];
		else
			return "";
	} else
		return $ws;
}

function getArrayKey($needle, $haystack)
{
	if (!is_array($haystack))
		return "";
	foreach ($haystack as $i => $val) {
		if ($val == $needle) {
			return $i;
		}
	}
	return "";
}

function p_r($val)
{
	print "<pre>";
	print_r($val);
	print "</pre>";
}

function getHrefForObject($id, $pid, $path = "", $DB_WE = "")
{
	
	if (!$path)
		$path = $_SERVER["PHP_SELF"];
	if (!$DB_WE)
		$DB_WE = new DB_WE();
	
	if (!$id) {
		return "";
	} else 
		if (!$GLOBALS["we_doc"]->InWebEdition) {
			
			// check if object is published.
			$published = f(
					"SELECT Published FROM " . OBJECT_FILES_TABLE . " WHERE ID='$id'", 
					"Published", 
					$DB_WE);
			if (!$published) {
				$GLOBALS["we_link_not_published"] = 1;
				return "";
			}
		}
	
	$foo = getHash(
			"
		SELECT Workspaces, ExtraWorkspacesSelected
		FROM " . OBJECT_FILES_TABLE . "
		WHERE ID='" . $id . "'", 
			$DB_WE);
	if (count($foo) == 0)
		return "";
	$showLink = false;
	
	if ($foo["Workspaces"]) {
		if (in_workspace($pid, $foo["Workspaces"], FILE_TABLE, $DB_WE))
			$showLink = true;
		else 
			if ($foo["ExtraWorkspacesSelected"]) {
				if (in_workspace($pid, $foo["ExtraWorkspacesSelected"], FILE_TABLE, $DB_WE))
					$showLink = true;
			}
	}
	if ($showLink) {
		
		$path = getNextDynDoc($path, $pid, $foo["Workspaces"], $foo["ExtraWorkspacesSelected"], $DB_WE);
		if (!$path)
			return "";
		return $path . "?we_objectID=" . $id . "&amp;pid=$pid";
	} else {
		if ($foo["Workspaces"]) {
			$fooArr = makeArrayFromCSV($foo["Workspaces"]);
			$path = id_to_path($fooArr[0], FILE_TABLE, $DB_WE);
			$path = f(
					"
				SELECT Path
				FROM " . FILE_TABLE . "
				WHERE Published > 0 AND ContentType='text/webedition' AND IsDynamic=1 AND Path like '$path%'", 
					"Path", 
					$DB_WE);
			if (!$path)
				return "";
			return $path . "?we_objectID=" . $id . "&amp;pid=$pid";
		} else
			return "";
	}
}

function getNextDynDoc($path, $pid, $ws1, $ws2, $DB_WE = "")
{
	if (!$DB_WE)
		$DB_WE = new DB_WE();
	if (f("
		SELECT IsDynamic
		FROM " . FILE_TABLE . "
		WHERE Path='$path'", "IsDynamic", $DB_WE)) {
		return $path;
	}
	$arr1 = makeArrayFromCSV(id_to_path($ws1, FILE_TABLE, $DB_WE));
	$arr2 = makeArrayFromCSV(id_to_path($ws2, FILE_TABLE, $DB_WE));
	$arr3 = makeArrayFromCSV($ws1);
	$arr4 = makeArrayFromCSV($ws2);
	foreach ($arr1 as $i => $ws)
		if (in_workspace($pid, $arr3[$i])) {
			$path = f(
					"
				SELECT Path
				FROM " . FILE_TABLE . "
				WHERE Published > 0 AND ContentType='text/webedition' AND IsDynamic=1 AND Path like '$ws%'", 
					"Path", 
					$DB_WE);
			if ($path)
				return $path;
		}
	foreach ($arr2 as $i => $ws)
		if (in_workspace($pid, $arr4[$i])) {
			$path = f(
					"
				SELECT Path
				FROM " . FILE_TABLE . "
				WHERE Published > 0 AND ContentType='text/webedition' AND IsDynamic=1 AND Path like '$ws%'", 
					"Path", 
					$DB_WE);
			if ($path)
				return $path;
		}
	return "";
}

function parseInternalLinks(&$text, $pid, $path = "")
{
	$DB_WE = new DB_WE();
	
	if (preg_match_all('/(href|src)="document:(\d+)("|[^"]+")/i', $text, $regs, PREG_SET_ORDER)) {
		for ($i = 0; $i < sizeof($regs); $i++) {
			if (isset($GLOBALS["we_doc"]->InWebEdition) && $GLOBALS["we_doc"]->InWebEdition) {
				$foo = getHash("
					SELECT Path
					FROM " . FILE_TABLE . "
					WHERE ID='" . $regs[$i][2] . "'", $DB_WE);
			} else {
				$foo = getHash(
						"
					SELECT Path
					FROM " . FILE_TABLE . "
					WHERE ID='" . $regs[$i][2] . "' AND Published > 0", 
						$DB_WE);
			}
			
			if (isset($foo["Path"])) {
				$text = str_replace(
						$regs[$i][1] . '="document:' . $regs[$i][2] . $regs[$i][3], 
						$regs[$i][1] . '="' . $foo["Path"] . $regs[$i][3], 
						$text);
			} else {
				$text = eregi_replace('<a [^>]*href="document:' . $regs[$i][2] . '"[^>]*>([^<]+)</a>', '\1', $text);
				$text = eregi_replace('<a [^>]*href="document:' . $regs[$i][2] . '"[^>]*>', '', $text);
				$text = eregi_replace('<img [^>]*src="document:' . $regs[$i][2] . '"[^>]*>', '', $text);
			}
		}
	}
	if (preg_match_all('/src="thumbnail:([^" ]+)"/i', $text, $regs, PREG_SET_ORDER)) {
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
		for ($i = 0; $i < sizeof($regs); $i++) {
			list($imgID, $thumbID) = explode(",", $regs[$i][1]);
			$thumbObj = new we_thumbnail();
			if ($thumbObj->initByImageIDAndThumbID($imgID, $thumbID)) {
				$text = eregi_replace(
						'src="thumbnail:' . $regs[$i][1] . '"', 
						'src="' . $thumbObj->getOutputPath() . '"', 
						$text);
			} else {
				$text = eregi_replace('<img[^>]+src="thumbnail:' . $regs[$i][1] . '[^>]+>', '', $text);
			}
		}
	}
	if (defined("OBJECT_TABLE")) {
		if (preg_match_all('/href="object:(\d+)(\??)("|[^"]+")/i', $text, $regs, PREG_SET_ORDER)) {
			for ($i = 0; $i < sizeof($regs); $i++) {
				$href = getHrefForObject($regs[$i][1], $pid, $path);
				if (isset($GLOBALS["we_link_not_published"])) {
					unset($GLOBALS["we_link_not_published"]);
				}
				if ($href) {
					if ($regs[$i][2] == "?") {
						$text = str_replace(
								'href="object:' . $regs[$i][1] . "?", 
								'href="' . $href . "&amp;", 
								$text);
					} else {
						$text = str_replace(
								'href="object:' . $regs[$i][1] . $regs[$i][2] . $regs[$i][3], 
								'href="' . $href . $regs[$i][2] . $regs[$i][3], 
								$text);
					}
				} else {
					$text = eregi_replace(
							'<a [^>]*href="object:' . $regs[$i][1] . '"[^>]*>([^<]+)</a>', 
							'\1', 
							$text);
					$text = eregi_replace('<a [^>]*href="object:' . $regs[$i][1] . '"[^>]*>', '', $text);
				}
			}
		}
	}
	$suchmuster = "/\<a>(.*)\<\/a>/siU";
	$ersetzung = "$1";
	
	$text = preg_replace($suchmuster, $ersetzung, $text);
	
	return $text;
}

function removeHTML($val)
{
	$val = eregi_replace('<br ?/?>', '###BR###', $val);
	$val = eregi_replace('<\?', '###?###', $val);
	$val = eregi_replace('\?>', '###/?###', $val);
	$val = eregi_replace('<[^><]+>', '', $val);
	$val = eregi_replace('###BR###', '<br>', $val);
	$val = eregi_replace('###\?###', '<?', $val);
	$val = eregi_replace('###/\?###', '?>', $val);
	return $val;
}

function removePHP($val)
{
	$val = str_replace("<?", "", $val);
	$val = str_replace("?>", "", $val);
	$val = eregi_replace('<script +language[^p]+php[^>]*>', '', $val);
	return $val;
}

function getMysqlVer($nodots = true)
{
	
	$DB_WE = new DB_WE();
	$DB_WE->query("SELECT VERSION() AS Version");
	
	if ($DB_WE->next_record()) {
		$res = explode('-', $DB_WE->f("Version"));
	} else {
		$DB_WE->query("SHOW VARIABLES LIKE 'version'");
		if ($DB_WE->next_record()) {
			$res = explode('-', $DB_WE->f("Value"));
		}
	}
	if (isset($res)) {
		if ($nodots) {
			$strver = substr(str_replace(".", "", $res[0]), 0, 4);
			
			$ver = (int)$strver;
			if (strlen($ver) < 4) {
				$ver = sprintf("%04d", $ver);
				if (substr($ver, 0, 1) == "0")
					$ver = (int)(substr($ver, 1) . "0");
			}
			
			return $ver;
		} else {
			return $res[0];
		}
	}
	return '';

}

function we_mail($recipient, $subject, $txt, $from = "")
{
	if (runAtWin()) {
		if ($txt)
			$txt = str_replace("\n", "\r\n", $txt);
		if ($header)
			$header = str_replace("\n", "\r\n", $header);
	}
	
	//@mail($recipient,$subject,$txt,$header);
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_mailer_class.inc.php');
	$_mailer = new we_mailer($recipient, $subject, $txt, $from);
	$_mailer->send();

}

function runAtWin()
{
	return eregi("win", PHP_OS) && (!eregi("darwin", PHP_OS));
}

function debug2($variable)
{
	ob_start("debug");
	p_r($variable);
	ob_end_clean();
}

function error_log2($variable)
{
	ob_start("error_log");
	print_r($variable);
	ob_end_clean();
}

function weMemDebug($label = "")
{
	error_log("$label: " . round(((memory_get_usage() / 1024) / 1024), 3) . " MB");
}

//  This Function writes the full content of an array. So you can test the content
//  $_POST or $_GET or $_REQUEST or whatever u want(p.ex)
//  This information is written in the TMP_DIR/debug.txt
//	if output == html, all information is printed in the actual document.
//	if output == error_log, all information is printed in the error_log
//	if output == error_log, all information is printed in the error_log


/**
 * @return void
 * @param array $array
 * @param string $arrayname
 * @param string $output
 * @desc	This function writes the full content (recursion) of an arrray. This is
 *			useful for debugging $_POST or $_GET or $_REQUEST or $_SESSION, etc.
 *			when $output == error_log - the information is written in the php_error_log (default)
 *			when $output == html - the information is written in the actual document
 *			when $output == debug - the information is written in the TMP_DIR/debug.txt
 */
function recGetParameters($array, $arrayname, $output = "error_log")
{
	
	reset($array);
	while (list($key, $val) = each($array)) {
		
		if ($arrayname != "") {
			$key = "[\"" . $key . "\"]";
		}
		if (is_array($val)) {
			
			switch ($output) {
				
				case "html" :
					print "<br><b>" . $arrayname . $key . " = " . $val . "</b><br>\n";
					break;
				
				case "debug" :
					debug("\n" . $arrayname . $key . " = " . $val . "\n");
					break;
				
				default :
					error_log($arrayname . $key . ' = ' . $val);
					break;
			}
			recGetParameters($val, $arrayname . $key, $output);
		
		} else {
			
			switch ($output) {
				
				case "html" :
					print $arrayname . $key . " = " . $val . "<br>\n";
					break;
				
				case "debug" :
					debug($arrayname . $key . " = " . $val . "\n");
					break;
				
				default :
					error_log($arrayname . $key . ' = ' . $val);
					break;
			}
		}
	}
}

function weSetCookieVariable($name, $value)
{
	$c = isset($_COOKIE["we" . session_id()]) ? $_COOKIE["we" . session_id()] : "";
	$vals = array();
	if ($c) {
		$parts = explode("&", $c);
		foreach ($parts as $p) {
			$foo = explode("=", $p);
			$vals[rawurldecode($foo[0])] = rawurldecode($foo[1]);
		}
	}
	$vals[$name] = $value;
	$c = "";
	foreach ($vals as $k => $v) {
		$c += rawurlencode($k) . "=" . rawurlencode($v) . "&";
	}
	if (strlen($c)) {
		$c = substr($c, 0, strlen($c) - 1);
	}
	$_COOKIE["we" . session_id()] = $c;
}

function weGetCookieVariable($name)
{
	$c = isset($_COOKIE["we" . session_id()]) ? $_COOKIE["we" . session_id()] : "";
	$vals = array();
	if ($c) {
		$parts = explode("&", $c);
		foreach ($parts as $p) {
			$foo = explode("=", $p);
			$vals[rawurldecode($foo[0])] = rawurldecode($foo[1]);
		}
		return (isset($vals[$name]) ? $vals[$name] : "");
	}
	return "";
}

function getContentTypeFromFile($dat)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_ContentTypes.inc.php");
	
	if (is_dir($dat)) {
		return "folder";
	} else {
		$ext = strtolower(ereg_replace('^.*(\..+)$', '\1', $dat));
		if ($ext) {
			$extensions = array();
			foreach ($GLOBALS["WE_CONTENT_TYPES"] as $ct => $fields) {
				$extensions = explode(",", $fields["Extension"]);
				if (in_array($ext, $extensions)) {
					return $ct;
				}
			}
		}
	}
	return "application/*";
}

function getUploadMaxFilesize($mysql = false, $db = "")
{
	
	$post_max_size = we_convertIniSizes(ini_get("post_max_size"));
	$upload_max_filesize = we_convertIniSizes(ini_get("upload_max_filesize"));
	
	if (!defined("WE_MAX_UPLOAD_SIZE") || WE_MAX_UPLOAD_SIZE == 0) {
		
		if ($mysql) {
			return min($post_max_size, $upload_max_filesize, getMaxAllowedPacket($db));
		} else {
			return min($post_max_size, $upload_max_filesize);
		}
	} else {
		return WE_MAX_UPLOAD_SIZE * 1024 * 1024;
	}
}

function getMaxAllowedPacket($db = "")
{
	if (!$db) {
		$db = new DB_WE();
	}
	$db->query("SHOW VARIABLES");
	$max_allowed_packet = 0;
	
	while ($db->next_record()) {
		if ($db->f("Variable_name") == "max_allowed_packet") {
			return $db->f("Value");
		}
	}
}

function we_convertIniSizes($in)
{
	if (eregi('^([0-9]+)M$', $in, $regs)) {
		return 1024 * 1024 * abs($regs[1]);
	} else 
		if (eregi('^([0-9]+)K$', $in, $regs)) {
			return 1024 * abs($regs[1]);
		} else {
			return abs($in);
		}
}

function we_getDocumentByID($id, $includepath = "", $db = "", $charset = "")
{
	if (!$db) {
		$db = new DB_WE();
	}
	// look what document it is and get the className
	$clNm = f("SELECT ClassName FROM " . FILE_TABLE . " WHERE ID='" . $id . "'", "ClassName", $db);
	//include the right class
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_classes/$clNm.inc.php");
	// init Document
	

	if (isset($GLOBALS["we_doc"])) {
		$backupdoc = $GLOBALS["we_doc"];
	}
	eval('$GLOBALS["we_doc"] = new ' . $clNm . '();');
	$GLOBALS["we_doc"]->initByID($id, FILE_TABLE, LOAD_MAID_DB);
	$content = $GLOBALS["we_doc"]->i_getDocument($includepath);
	$charset = $GLOBALS["we_doc"]->getElement("Charset");
	if (!$charset) {
		$charset = "ISO-8859-1";
	}
	
	if (isset($backupdoc)) {
		$GLOBALS["we_doc"] = $backupdoc;
	}
	return $content;
}

function we_getObjectFileByID($id, $includepath = "")
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_modules/object/we_objectFile.inc.php");
	$mydoc = new we_objectFile();
	$mydoc->initByID($id, OBJECT_FILES_TABLE, LOAD_MAID_DB);
	return $mydoc->i_getDocument($includepath);
}

/**
 * @return str
 * @param bool $slash
 * @desc returns the protocol, the webServer is running, http or https, when slash is true - :// is added to protocol
 */
function getServerProtocol($slash = false)
{
	
	$_prot = "http";
	
	if (we_isHttps()) {
		$_prot = "https";
	}
	if ($slash) {
		return $_prot . "://";
	} else {
		return $_prot;
	}

}

function we_check_email($email)
{
	$email = html_entity_decode($email);
	$namePart[0] = "";
	if (preg_match('/<(.)*>/', $email, $_email)) {
		$namePart = substr($email, 0, strpos($email, "<"));
		$namePart = preg_replace('/"(.)*"/', "x", $namePart);
		$namePart = preg_replace('/\\\\(.)/', "y", $namePart);
		if (strpos($namePart, '"'))
			return false;
		$email = substr($_email[0], 1, strlen($_email[0]) - 2);
	}
	$tmp = str_replace("\@", "#####:::::at:::::#####", $email);
	$parts = split('@', $tmp);
	if (count($parts) != 2)
		return false;
	$parts[0] = str_replace("#####:::::at:::::#####", "\@", $parts[0]);
	$parts[0] = preg_replace('/"(.)*"/', "x", $parts[0]);
	$parts[0] = preg_replace('/\\\\(.)/', "y", $parts[0]);
	$parts[1] = str_replace("#####:::::at:::::#####", "\@", $parts[1]);
	return !preg_match('/[ ,;\\\\\[\]()\<\>�]/', implode("", $parts));
}

function getRequestVar($name, $default, $yescode = "", $nocode = "")
{
	if (isset($_REQUEST[$name])) {
		if ($yescode != "")
			eval($yescode);
		return $_REQUEST[$name];
	} else {
		if ($nocode != "")
			eval($nocode);
		return $default;
	}
}

/**
 * Gets the Directory for thumbnails
 *
 * @return str
 * @param bool $realpath  if set to true, Document_ROOT will be appended before
 */
function getThumbDirectory($realpath = false)
{
	$dir = (defined("WE_THUMBNAIL_DIRECTORY") && WE_THUMBNAIL_DIRECTORY) ? WE_THUMBNAIL_DIRECTORY : "/__we_thumbs__";
	$dir = ereg_replace('^\.?(.*)$', '\1', $dir);
	if (substr($dir, 0, 1) != "/") {
		$dir = "/" . $dir;
	}
	return ($realpath ? $_SERVER["DOCUMENT_ROOT"] : "") . $dir;
}

/**
 * Converts a given number in a via array specified system.
 * as default a number is converted in the matching chars 0->^,1->a,2->b, ...
 * other systems can simply set via the parameter $chars for example -> array(0,1)
 * for bin-system
 *
 * @return string
 * @param int $value
 * @param array[optional] $chars
 * @param string[optional] $str
 */
function number2System($value, $chars = array(), $str = "")
{
	
	if (!(is_array($chars) && sizeof($chars) > 1)) { //	in case of error take default-array
		

		$chars = array(
			
				'^', 
				'a', 
				'b', 
				'c', 
				'd', 
				'e', 
				'f', 
				'g', 
				'h', 
				'i', 
				'j', 
				'k', 
				'l', 
				'm', 
				'n', 
				'o', 
				'p', 
				'q', 
				'r', 
				's', 
				't', 
				'u', 
				'v', 
				'w', 
				'x', 
				'y', 
				'z'
		);
	}
	$base = sizeof($chars);
	
	//	get some information about the numbers:
	$_rest = $value % $base;
	$_result = ($value - $_rest) / $base;
	
	//	1. Deal with the rest
	$str = $chars[$_rest] . $str;
	
	//	2. Deal with remaining result
	if ($_result > 0) {
		return number2System($_result, $chars, $str);
	} else {
		return $str;
	}
}

/**
 * returns the HTML for a quality output select box
 *
 * @return string
 * @param string $name
 * @param string[optional] $sel
 */

function we_qualitySelect($name = "quality", $sel = 8)
{
	return '<select name="' . $name . '" class="weSelect" size="1">
<option value="0"' . (($sel == 0) ? ' selected' : '') . '>0 - ' . $GLOBALS["l_we_class"]["quality_low"] . '</option>
<option value="1"' . (($sel == 1) ? ' selected' : '') . '>1</option>
<option value="2"' . (($sel == 2) ? ' selected' : '') . '>2</option>
<option value="3"' . (($sel == 3) ? ' selected' : '') . '>3</option>
<option value="4"' . (($sel == 4) ? ' selected' : '') . '>4 - ' . $GLOBALS["l_we_class"]["quality_medium"] . '</option>
<option value="5"' . (($sel == 5) ? ' selected' : '') . '>5</option>
<option value="6"' . (($sel == 6) ? ' selected' : '') . '>6</option>
<option value="7"' . (($sel == 7) ? ' selected' : '') . '>7</option>
<option value="8"' . (($sel == 8) ? ' selected' : '') . '>8 - ' . $GLOBALS["l_we_class"]["quality_high"] . '</option>
<option value="9"' . (($sel == 9) ? ' selected' : '') . '>9</option>
<option value="10"' . (($sel == 10) ? ' selected' : '') . '>10 - ' . $GLOBALS["l_we_class"]["quality_maximum"] . '</option>
</select>
';

}

/**
 * This function returns preference for given name; Checks first the users preferences and then global
 *
 * @param          string                                  $name
 *
 * @see            getAllGlobalPrefs()
 *
 * @return         string
 */

function getPref($name)
{
	if (isset($_SESSION["prefs"][$name])) {
		return $_SESSION["prefs"][$name];
	} else {
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/weConfParser.class.php");
		$file_name = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/conf/we_conf_global.inc.php";
		$parser = weConfParser::getConfParserByFile($file_name);
		$all = $parser->getData();
		return isset($all[$name]) ? $all[$name] : "";
	}

}

/**
 * The function saves the user pref in the session and the database; The function works with user preferences only
 *
 * @param          string                                  $name
 * @param          string                                  $value
 *
 * @see            setUserPref()
 *
 * @return         boolean
 */
function setUserPref($name, $value)
{
	if (isset($_SESSION['prefs'][$name]) && isset($_SESSION['prefs']['userID']) && $_SESSION['prefs']['userID']) {
		$_SESSION['prefs'][$name] = $value;
		$_db = new DB_WE();
		$_db->query(
				'UPDATE ' . PREFS_TABLE . ' SET ' . $name . '="' . addslashes($value) . '" WHERE userId=' . $_SESSION['prefs']['userID']);
		return true;
	}
	return false;
}

/**
 * This function creates the given path in the repository and returns the id of the last created folder
 *
 * @param          string				$path
 * @param          string				$table
 * @param          array				$pathids
 *
 * @return         string
 */

function makePath($path, $table, &$pathids, $owner = 0)
{
	include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_folder.inc.php");
	$path = str_replace("\\", "/", $path);
	$patharr = explode("/", $path);
	$mkpath = "";
	$pid = 0;
	$ids = array();
	foreach ($patharr as $elem) {
		if ($elem != "" && $elem != "/") {
			$mkpath .= "/" . $elem;
			$id = path_to_id($mkpath, $table);
			if (!$id) {
				$new = new we_folder();
				$new->Text = $elem;
				$new->Filename = $elem;
				$new->ParentID = $pid;
				$new->Path = $mkpath;
				$new->Table = $table;
				$new->CreatorID = $owner;
				$new->ModifierID = $owner;
				$new->Owners = ',' . $owner . ',';
				$new->OwnersReadOnly = serialize(array(
					$owner => 0
				));
				$new->we_save();
				$id = $new->ID;
				$pathids[] = $id;
			}
			$pid = $id;
		}
	}
	
	return $pid;
}

/**
 * This function clears path from double slashes and back slashes
 *
 * @param          string                                  $path
 *
 *
 * @return         string
 */

function clearPath($path)
{
	return ereg_replace("/+", "/", str_replace("\\", "/", $path));

}

/**
 * @return	string
 * @param	string $element
 * @param	[opt]array $attribs
 * @param	[opt]string $content
 * @param	[opt]boolean $forceEndTag=false
 * @desc	returns the html element with the given attribs.attr[pass_*] is replaced by "*" to loop some
 *          attribs through the tagParser.
 */

function getHtmlTag($element, $attribs = array(), $content = "", $forceEndTag = false, $onlyStartTag = false)
{
	
	//	default at the moment is xhtml-style
	$_xmlClose = false;
	
	//	take values given from the tag - later from preferences.
	$xhtml = (defined('XHTML_DEFAULT') && XHTML_DEFAULT == 1) ? true : false;
	
	if (isset($attribs["xml"]) && $attribs["xml"]) {
		$xhtml = ($attribs["xml"] == "true" || $attribs["xml"] == "on" || $attribs["xml"] == "xml" || $attribs["xml"] == 1) ? true : false;
	}
	
	// at the moment only transitional is supported
	$xhtmlType = (isset($attribs["xmltype"]) ? $attribs["xmltype"] : "transitional");
	
	//	remove x(ht)ml-attributs
	$attribs = removeAttribs($attribs, array(
		"xml", "xmltype"
	));
	
	if ($xhtml) { //	xhtml, check if and what we shall debug
		

		$_xmlClose = true;
		
		if (defined('XHTML_DEBUG') && XHTML_DEBUG) { //  check if XHTML_DEBUG is activated - system pref
			

			include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/validation/xhtml.inc.php');
			
			$showWrong = (isset($_SESSION['prefs']['xhtml_show_wrong']) && $_SESSION['prefs']['xhtml_show_wrong'] && isset(
					$GLOBALS['we_doc']) && $GLOBALS['we_doc']->InWebEdition); //  check if XML_SHOW_WRONG is true (user) - only in webEdition
			$removeWrong = (defined('XHTML_REMOVE_WRONG') && XHTML_REMOVE_WRONG); //  check if XML_REMOVE_WRONG is true (constant)
			

			validateXhtmlAttribs($element, $attribs, $xhtmlType, $showWrong, $removeWrong);
		}
	}
	
	$_tag = "<$element";
	
	foreach ($attribs as $k => $v) {
		$_tag .= ' ' . str_replace('pass_', '', $k) . "=\"$v\"";
	}
	if ($content != "" || $forceEndTag) { //	use endtag
		$_tag .= ">$content</$element>";
	} else { //	xml style or not
		$_tag .= (($_xmlClose && !$onlyStartTag) ? ' />' : '>');
	}
	return $_tag;
}

/**
 * converts xml String Attribute to boolean attribute
 *
 * @return bool
 * @param string $xml
 *
 */
function getXmlAttributeValueAsBoolean($xml)
{
	if ($xml == "true" || $xml == "xml" || $xml == "on" || $xml == 1) {
		return true;
	} else 
		if ($xml == "false" || $xml == "off") {
			return false;
		} else {
			return (defined('XHTML_DEFAULT') && XHTML_DEFAULT == 1) ? true : false;
		}
}

/**
 * @return array
 * @param array $attribs
 * @param array $remove
 * @desc removes all entries of $attribs, where the key from attribs is in values of $remove
 */
function removeAttribs($attribs, $remove = array())
{
	
	array_push($remove, "user");
	
	for ($i = 0; $i < sizeof($remove); $i++) {
		if (array_key_exists($remove[$i], $attribs)) {
			unset($attribs[$remove[$i]]);
		}
	}
	return $attribs;
}

/**
 * @return array
 * @param array $atts
 * @param array $ignore
 * @desc Removes all empty values from assoc array without the in $ignore given
 */
function removeEmptyAttribs($atts, $ignore = array())
{
	
	foreach ($atts as $k => $v) {
		if (!in_array($k, $ignore) && $v == "") {
			unset($atts[$k]);
		}
	}
	return $atts;
}

/**
 * @return array
 * @param array $atts
 * @param array $ignore
 * @desc only uses the attribs given in the array use
 */
function useAttribs($atts, $use = array())
{
	
	foreach ($atts as $k => $v) {
		if (!in_array($k, $use)) {
			unset($atts[$k]);
		}
	}
	return $atts;
}

/**
 * This function works in very same way as the standard array_splice function
 * except the second parametar is the array index and not just offset
 * The functions modifies the array that has been passed by reference as the first function parametar
 *
 * @param          array                                  $a
 * @param          interger                                $start
 * @param          integer                                 $len
 *
 *
 * @return         none
 */
function new_array_splice(&$a, $start, $len = 1)
{
	$ks = array_keys($a);
	$k = array_search($start, $ks);
	if ($k !== false) {
		$ks = array_splice($ks, $k, $len);
		foreach ($ks as $k)
			unset($a[$k]);
	}
}

/**
 * This function works oposit to htmlentities function
 *
 * @param          array                                  $code
 *
 *
 * @return         string
 */
function rhtmlentities($code)
{
	$table = get_html_translation_table(HTML_ENTITIES);
	$rtable = array_flip($table);
	return strtr($code, $rtable);
}

/**
 * Returns number od days for given month
 *
 * @param          int                                  $month
 * @param          int                                  $year
 *
 *
 * @return         int
 */
function getNumberOfDays($month, $year)
{
	if (in_array($month, array(
		1, 3, 5, 7, 8, 10, 12
	)))
		$numofdays = "31";
	else 
		if (is_int($year / 4) && $month == 2)
			$numofdays = "29";
		else 
			if ($month == 2)
				$numofdays = "28";
			else
				$numofdays = "30";
	
	return $numofdays;
}

/**
 * Returns "where query" for Doctypes depending on which workspace the user have
 *
 * @param	object	$db
 *
 *
 * @return         string
 */
function getDoctypeQuery($db = "")
{
	if (!$db) {
		$db = new DB_WE();
	}
	
	$hideDts = '';
	if (defined('ISP_VERSION') && ISP_VERSION && $GLOBALS["_isp_hide_doctypes"]) {
		$hideDts = ' AND DocType NOT IN ("' . implode('","', $GLOBALS["_isp_hide_doctypes"]) . '")';
	}
	
	$q = "WHERE 1 $hideDts ORDER BY DocType";
	
	$paths = array();
	$ws = get_ws(FILE_TABLE);
	if ($ws) {
		$b = makeArrayFromCSV($ws);
		foreach ($b as $k => $v) {
			if ((!defined("WE_DOCTYPE_WORKSPACE_BEHAVIOR")) || WE_DOCTYPE_WORKSPACE_BEHAVIOR == 0) {
				$db->query("SELECT ID,Path FROM " . FILE_TABLE . " WHERE ID='" . $v . "'");
				while ($db->next_record()) {
					array_push(
							$paths, 
							"(ParentPath = '" . $db->f("Path") . "' || ParentPath like '" . $db->f("Path") . "/%')");
				}
			} else {
				$_tmp_path = id_to_path($v);
				while ($_tmp_path && $_tmp_path != "/") {
					array_push($paths, "ParentPath = '" . $_tmp_path . "'");
					$_tmp_path = dirname($_tmp_path);
				}
			}
		}
	}
	if (is_array($paths) && count($paths) > 0) {
		$q = "WHERE ((" . implode(" OR ", $paths) . ") OR ParentPath='') $hideDts ORDER BY DocType";
	}
	
	return $q;
}

function unhtmlentities($string)
{
	
	// replace numeric entities
	$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
	$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
	
	// replace literal entities
	$trans_tbl = get_html_translation_table(HTML_ENTITIES);
	$trans_tbl = array_flip($trans_tbl);
	
	return strtr($string, $trans_tbl);
}

/**
 * Makes a relative path from an absolute path
 *
 * @param	string	$docpath Absolute Path of document
 * @param	string	$linkpath Absolute Path of link (href or src)
 *
 * @return         string
 */
function makeRelativePath($docpath, $linkpath)
{
	$parentPath = dirname($docpath);
	$newLinkPath = "";
	while ($parentPath != substr($linkpath, 0, strlen($parentPath))) {
		$parentPath = dirname($parentPath);
		$newLinkPath .= "../";
	}
	$rest = substr($linkpath, strlen($parentPath));
	if (substr($rest, 0, 1) == "/") {
		$rest = substr($rest, 1);
	}
	return $newLinkPath . $rest;
}

function we_loadLanguageConfig()
{
	
	$file = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/conf/we_conf_language.inc.php";
	if (!file_exists($file) || !is_file($file)) {
		if (WE_LANGUAGE == "Deutsch") {
			we_writeLanguageConfig('de_DE', array(
				'de_DE', 'en_GB'
			));
		
		} else {
			we_writeLanguageConfig('en_GB', array(
				'de_DE', 'en_GB'
			));
		
		}
	
	}
	include_once ($file);

}

function we_writeLanguageConfig($default, $available = array())
{
	
	$locales = "";
	sort($available);
	foreach ($available as $Locale) {
		$temp = explode("_", $Locale);
		if (sizeof($temp) == 1) {
			$locales .= "	'" . $Locale . "' => \$GLOBALS['l_languages']['" . $temp[0] . "'],\n";
		} else {
			$locales .= "	'" . $Locale . "' => \$GLOBALS['l_languages']['" . $temp[0] . "'] . \" (\" . \$GLOBALS['l_countries']['" . $temp[1] . "'] . \")\",\n";
		}
	
	}
	
	$code = '<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/countries.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/languages.inc.php");

$GLOBALS["weFrontendLanguages"] = array(
' . $locales . '
);

$GLOBALS["weDefaultFrontendLanguage"] = "' . $default . '";

?>';
	
	$file = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/conf/we_conf_language.inc.php";
	$fh = fopen($file, "w+");
	if (!$fh) {
		return false;
	}
	fputs($fh, $code);
	return fclose($fh);

}

function setSupportDebugging($duration = 60)
{
	if ($_SESSION["perms"]["ADMINISTRATOR"]) {
		$supportfile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we_sselector_inc.php";
		$duration = ($duration > 180 ? 180 : $duration) * 60;
		$supportStart = time();
		$supportIP = $_SERVER['REMOTE_ADDR'];
		$phpstr = "<?php
		define('SUPPORT_IP', '$supportIP');
		define('SUPPORT_DURATION', $duration);
		define('SUPPORT_START', $supportStart);
		?>";
		$fp = fopen($supportfile, 'wb');
		fwrite($fp, $phpstr);
		fclose($fp);
	}
}

function unsetSupportDebugging()
{
	$supportfile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we_sselector_inc.php";
	if (file_exists($supportfile)) {
		unlink($supportfile);
	}
}

function getObjectsForDocWorkspace($id)
{
	
	if (is_array($id)) {
		$ids = $id;
	} else {
		$ids = array(
			$id
		);
	}
	$db = new DB_WE();
	
	if (!defined("OBJECT_FILES_TABLE")) {
		return array();
	
	}
	
	$where = array();
	foreach ($ids as $id) {
		$where[] = 'Workspaces LIKE "%,' . $id . ',%"';
		$where[] = 'ExtraWorkspaces LIKE "%,' . $id . ',%"';
	}
	
	$out = array();
	$db->query('SELECT ID,Path FROM ' . OBJECT_FILES_TABLE . ' WHERE ' . implode(' OR ', $where));
	
	while ($db->next_record()) {
		$out[$db->f('ID')] = $db->f('Path');
	}
	
	return $out;

}

function we_filenameNotValid($filename)
{
	if (substr($filename, 0, 2) === "..") {
		return true;
	}
	return eregi('[^a-z0-9._-]', $filename);
}

function we_getIcon($contentType, $extension)
{
	if ($contentType == "application/*") {
		switch ($extension) {
			case ".pdf" :
				return "pdf.gif";
			case ".zip" :
			case ".sit" :
			case ".hqx" :
			case ".bin" :
				return "zip.gif";
			case ".doc" :
				return "word.gif";
			case ".xls" :
				return "excel.gif";
			case ".ppt" :
				return "powerpoint.gif";
		}
		return "prog.gif";
	
	} else {
		return $GLOBALS["WE_CONTENT_TYPES"][$contentType]['Icon'];
	}
}

function we_isHttps()
{
	return isset($_SERVER["HTTPS"]) && (strtoupper($_SERVER["HTTPS"]) == "ON" || $_SERVER["HTTPS"] == 1);
}

//check if number is positive
function pos_number($val)
{
	return (bool)is_numeric($val) && $val == (int)$val && $val > 0;
}

?>