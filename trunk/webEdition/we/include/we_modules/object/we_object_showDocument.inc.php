<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
define("NO_SESS",1);
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once(WE_OBJECT_MODULE_DIR ."we_objectFile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_webEditionDocument.inc.php");
if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_live_tools.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/we_SEEM.class.php");
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_template.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/navigationHistory.class.php");


/**
 * showContent()
 * @desc     Generates and prints a default template to see the attribs of an object.
 *
 * @param    msg		string
 */
function showContent(){

	$_previewMode = 1;
	include_once(WE_OBJECT_MODULE_DIR."we_editor_contentobjectFile.inc.php");
	exit;
}

$_userID = (isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"]->isLockedByUser() : 0);

if(  ($_userID != 0 && $_userID != $_SESSION["user"]["ID"]) || (isset($_REQUEST["we_cmd"][0]) && $_REQUEST["we_cmd"][0] == "switch_edit_page" || (isset($_SESSION["EditPageNr"]) && $_SESSION["EditPageNr"] == WE_EDITPAGE_PREVIEW))){	//	Preview-Mode of Tabs

	//	We must choose the right template to show the object.
	//	Therefore we must look, if $_SESSION["SEEM"]["lastPath"] exists to check the workspace.
	//	First check the workspaces for the document.
	//	choose the template matching to the actual workspace.
	//	If wrong workspace or no template can be found, just show the name/value pairs.

	// init document
	$we_transaction = $_REQUEST["we_transaction"];

	$we_dt = $_SESSION["we_data"][$we_transaction];

	//	determine Path from last opened wE-Document
	$_lastDoc = isset($_SESSION['last_webEdition_document']) ? $_SESSION['last_webEdition_document'] : array();


	if(isset($_SESSION["we_data"][$we_transaction]["0"]["Templates"]) ){

		$tids = makeArrayFromCSV($_SESSION["we_data"][$we_transaction]["0"]["Templates"]);	//	get all templateIds.
		$workspaces = makeArrayFromCSV($_SESSION["we_data"][$we_transaction]["0"]["Workspaces"]);

		array_push($workspaces, $_SESSION["we_data"][$we_transaction]["0"]["ExtraWorkspaces"]);
		array_push($tids, $_SESSION["we_data"][$we_transaction]["0"]["ExtraTemplates"]);

		$tmpDB = new DB_WE();

		if(isset($_lastDoc['Path'])){

			if(sizeof($workspaces) > 0 ){ 	// get the correct template

				//	Select a matching workspace.
				for($i=0;$i < sizeof($workspaces); $i++){

					$workspace = id_to_path($workspaces[$i],FILE_TABLE,$tmpDB);

					if($workspace != "" && strpos($_lastDoc['Path'], $workspace) === 0 && $tids[$i] != ""){

							//	init document
							$tid = $tids[$i];
							$GLOBALS["we_doc"]->we_initSessDat($we_dt);
							$_REQUEST["we_objectID"] = $_SESSION["we_data"][$we_transaction][0]["ID"];
							break;
					}
				}
				unset($tmpDB);
			}
		}
		if (!isset($tid)) {

			for ($i=0;$i<sizeof($tids);$i++) {
				$path = id_to_path($tids[$i], TEMPLATES_TABLE);
				if ($path && $path != '/') {
					$tid = $tids[$i];
					break;
				}
			}
		}
		unset($tmpDB);
	}

	if (isset($tid)) {

		//	init document
		$GLOBALS["we_doc"]->we_initSessDat($we_dt);
		$_REQUEST["we_objectID"] = $_SESSION["we_data"][$we_transaction][0]["ID"];

	} else {
		showContent();
		exit;
	}


} else if(isset($_REQUEST["we_cmd"][3]) && $_REQUEST["we_cmd"][3]){

	$tid = $_REQUEST["we_cmd"][2];
	$we_transaction = $_REQUEST["we_cmd"][3];

	// init document
	$we_dt = $_SESSION["we_data"][$we_transaction];
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

} else {	//	view with template

	$tid = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : (isset($we_objectTID) ? $we_objectTID : "");

	$GLOBALS["we_obj"] = new we_objectFile();
	$GLOBALS["we_obj"]->initByID($_REQUEST["we_objectID"],OBJECT_FILES_TABLE);

	if(!$GLOBALS["we_obj"]->Published){

		header("HTTP/1.1 404 Not Found");

		if (defined('ERROR_DOCUMENT_NO_OBJECTFILE')) {

			$path = id_to_path(ERROR_DOCUMENT_NO_OBJECTFILE, FILE_TABLE);
			if ($path) {
				header("Location: $path");
			}
		}
		exit;
	}

	$GLOBALS["we_doc"] = new we_webEditionDocument();
	$GLOBALS["we_doc"]->initByID($_REQUEST["we_cmd"][1],FILE_TABLE);
	$GLOBALS["we_doc"]->elements = $GLOBALS["we_obj"]->elements;
	$GLOBALS["we_doc"]->Templates = $GLOBALS["we_obj"]->Templates;
	$GLOBALS["we_doc"]->ExtraTemplates = $GLOBALS["we_obj"]->ExtraTemplates;
	$GLOBALS["we_doc"]->TableID = $GLOBALS["we_obj"]->TableID;
	$GLOBALS["we_doc"]->CreatorID = $GLOBALS["we_obj"]->CreatorID;
	$GLOBALS["we_doc"]->ModifierID = $GLOBALS["we_obj"]->ModifierID;
	$GLOBALS["we_doc"]->RestrictOwners = $GLOBALS["we_obj"]->RestrictOwners;
	$GLOBALS["we_doc"]->Owners = $GLOBALS["we_obj"]->Owners;
	$GLOBALS["we_doc"]->OwnersReadOnly = $GLOBALS["we_obj"]->OwnersReadOnly;
	$GLOBALS["we_doc"]->Category = $GLOBALS["we_obj"]->Category;
	$GLOBALS["we_doc"]->ObjectID=$GLOBALS["we_obj"]->ObjectID;
	$GLOBALS["we_doc"]->OF_ID=$GLOBALS["we_obj"]->ID;
	$GLOBALS["we_doc"]->Charset=$GLOBALS["we_obj"]->Charset;
	$GLOBALS["we_doc"]->elements['Charset']['dat'] = $GLOBALS["we_obj"]->Charset; // for charset-tag

}

// deal with customerFilter
// @see we_showDocument.inc.php
if ( isset($GLOBALS["we_obj"]) && $GLOBALS["we_obj"]->documentCustomerFilter ) {

	// call session_start to init session, otherwise NO customer can exist
	@session_start();

	if ( $_visitorHasAccess = $GLOBALS["we_obj"]->documentCustomerFilter->accessForVisitor($GLOBALS["we_obj"]) ) {

		if ( !($_visitorHasAccess == WECF_ACCESS || $_visitorHasAccess == WECF_CONTROLONTEMPLATE) ) {

			// user has NO ACCESS => show errordocument
			$_errorDocId = $GLOBALS["we_obj"]->documentCustomerFilter->getErrorDoc( $_visitorHasAccess );

			if ( $_errorDocPath = id_to_path($_errorDocId, FILE_TABLE) ) { // use given document instead !
				header("Location: " . getServerProtocol(true) . $_SERVER["HTTP_HOST"] . $_errorDocPath);
				unset($_errorDocPath);
				unset($_errorDocId);
				exit();

			} else {
				die( "Customer has no access to this document" );

			}
		}
	}
}


if (!isset($pid) || !($pid) ) {
	$pid = f("SELECT ParentID FROM " .FILE_TABLE. " WHERE Path='".$_SERVER["PHP_SELF"]."'","ParentID",$DB_WE);
}

if (!isset($tid) || !($tid) ) {
	$tid = $GLOBALS["we_obj"]->getTemplateID($pid);
}

if (!$tid) {
	$tids = makeArrayFromCSV(f("Select Templates FROM ".OBJECT_TABLE." WHERE ID='".$GLOBALS["we_obj"]->TableID."'","Templates",$DB_WE));
	if (sizeof($tids)) {
		$tid = $tids[0];
	}
}

if (!$tid) {

	header("HTTP/1.1 404 Not Found");

	if (defined('ERROR_DOCUMENT_NO_OBJECTFILE')) {

		$path = id_to_path(ERROR_DOCUMENT_NO_OBJECTFILE, FILE_TABLE);
		if ($path) {
			header("Location: $path");
		}
	}
	exit;
}

$tmplPath = preg_replace('/.tmpl$/i','.php',f("SELECT Path FROM ".TEMPLATES_TABLE." WHERE ID='$tid'","Path",$DB_WE));

if((!defined("WE_CONTENT_TYPE_SET")) && isset($GLOBALS["we_doc"]->Charset) && $GLOBALS["we_doc"]->Charset){	//	send charset which might be determined in template
	define("WE_CONTENT_TYPE_SET",1);
	//	@ -> to aware of unproper use of this element, f. ex in include-File
	@header("Content-Type: text/html; charset=" . $GLOBALS["we_doc"]->Charset);
}

// Caching
$h = getHash("Select CacheType, CacheLifeTime FROM ".OBJECT_TABLE." WHERE ID='".$we_doc->TableID."'",$DB_WE);
$we_doc->CacheType = isset($h["CacheType"]) ? $h["CacheType"] : "none";
$we_doc->CacheLifeTime = isset($h["CacheLifeTime"]) ? $h["CacheLifeTime"] : 0;

//	If in webEdition, parse the document !!!!
if(isset($_SESSION["we_data"][$we_transaction]["0"]["InWebEdition"]) && $_SESSION["we_data"][$we_transaction]["0"]["InWebEdition"]){		//	In webEdition, parse the file.
	$contentOrig = join('', file(TEMPLATE_DIR . $tmplPath));

	ob_start();
    eval("?>" . $contentOrig);
    $contents = ob_get_contents();
    ob_end_clean();
	print we_SEEM::parseDocument($contents);
} else {	//	Not in webEdition, just show the file.


	// use the Document Cache
	if( ($we_doc->CacheType == 'document' || $we_doc->CacheType == 'full') && $we_doc->CacheLifeTime > 0) {
		$GLOBALS['weCacheOutput'] = false;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/cache/weCache.class.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/cache/weDocumentCache.class.php");

		$weDocumentCache = new weDocumentCache($we_ID, $we_doc->CacheLifeTime);
		if($weDocumentCache->start()) {

			// The weDocumentCache must be pushed to a stack because otherwise it could be
			// overwritten in one of the potential includes
			if(!isset($weDocumentCaches) ||!is_array($weDocumentCaches)) {
				$weDocumentCaches = array();

			}
			array_push($weDocumentCaches, $weDocumentCache);

			include(TEMPLATE_DIR . $tmplPath);

			// get the last weDocumentCache from the stack
			$weDocumentCache = array_pop($weDocumentCaches);

			$weDocumentCache->end();

		}

		$GLOBALS['weCacheOutput'] = true;


		//
		// --> Start Glossary Replacement
		//

		if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryCache.php");
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryReplace.php");

			weGlossaryReplace::start();

		}

		//
		// --> Include Content
		//

		include($weDocumentCache->getCacheFilename());

		//
		// --> Finish Glossary Replacement
		//

		if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
			weGlossaryReplace::end($GLOBALS["we_doc"]->Language);

		}

	// do not cache the document
	} else {

		//
		// --> Start Glossary Replacement
		//

		if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryCache.php");
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryReplace.php");

			weGlossaryReplace::start();

		}

		//
		// --> Include Content
		//

		include(TEMPLATE_DIR . $tmplPath);

		//
		// --> Finish Glossary Replacement
		//

		if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
			weGlossaryReplace::end($GLOBALS["we_doc"]->Language);

		}

	}

}

?>
