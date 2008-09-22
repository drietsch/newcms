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

if (isset($noSess) && $noSess) {
	if (!defined("NO_SESS")) {
		define("NO_SESS", 1);
	}
}
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_live_tools.inc.php");

//  Diese we_cmds werden auf den Seiten gespeichert und nicht �bergeben!!!!!
//  Sie kommen von showDoc.php
$id = abs(isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "");
$tmplID = abs(isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : "");
$baseHref = addslashes(isset($_REQUEST["we_cmd"][5]) ? $_REQUEST["we_cmd"][5] : "");
$we_editmode = addslashes(isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : "");
$createFromTmpFile = addslashes(isset($_REQUEST["we_cmd"][7]) ? $_REQUEST["we_cmd"][7] : "");

$we_ID = $id;
$we_Table = FILE_TABLE;

$we_dt = isset($_SESSION["we_data"][$we_transaction]) ? $_SESSION["we_data"][$we_transaction] : "";

// init document
include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_editors/we_init_doc.inc.php");

if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] != "ResetVersion") {
	if (isset($FROM_WE_SHOW_DOC) && $FROM_WE_SHOW_DOC) { // when called showDoc.php
		$publ = $we_doc->Published;
		$prot = getServerProtocol();
		$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://" . $_SERVER["HTTP_HOST"] : "";
		if ((!$we_doc->IsDynamic) && $publ && (!$tmplID)) { // if the document is not a dynamic php-doc and is published we make a redirect to the static page
			header("Location: " . $preurl . $we_doc->Path);
			exit();
		} else 
			if ($we_doc->IsDynamic && (!$publ) && (!$tmplID)) { // if the document is a dynamic php-doc and is not published we make a redirect to dummy page that does not exist, so the user gets a 404-Errpr Page from the server
				header("Location: $preurl/this_file_does_not_exist_on_this_server");
				exit();
			}
	}
}

// deal with customerFilter
// @see we_object_showDocument.inc.php
if ($we_doc->documentCustomerFilter && !isset($GLOBALS["getDocContentVersioning"])) {
	
	// call session_start to init session, otherwise NO customer can exist
	@session_start();
	
	if ($_visitorHasAccess = $we_doc->documentCustomerFilter->accessForVisitor($we_doc)) {
		
		if (!($_visitorHasAccess == WECF_ACCESS || $_visitorHasAccess == WECF_CONTROLONTEMPLATE)) {
			
			// user has NO ACCESS => show errordocument
			$_errorDocId = $we_doc->documentCustomerFilter->getErrorDoc($_visitorHasAccess);
			if ($_errorDocPath = id_to_path($_errorDocId, FILE_TABLE)) { // use given document instead !
				header("Location: " . getServerProtocol(true) . $_SERVER["HTTP_HOST"] . $_errorDocPath);
				unset($_errorDocPath);
				unset($_errorDocId);
				exit();
			
			} else {
				die("Customer has no access to this document");
			
			}
		}
	}
}

$we_doc->EditPageNr = $we_editmode ? WE_EDITPAGE_CONTENT : WE_EDITPAGE_PREVIEW;

if ($tmplID && ($we_doc->ContentType == "text/webedition")) { // if the document should displayed with an other template
	$we_doc->setTemplateID($tmplID);
}
$we_doc->setCache();

if ($we_include = $we_doc->editor($baseHref)) {
	if (substr(strtolower($we_include), 0, strlen($_SERVER["DOCUMENT_ROOT"])) == strtolower($_SERVER["DOCUMENT_ROOT"])) {
		if ((!defined("WE_CONTENT_TYPE_SET")) && isset($we_doc->elements["Charset"]["dat"]) && $we_doc->elements["Charset"]["dat"]) { //	send charset which might be determined in template
			define("WE_CONTENT_TYPE_SET", 1);
			//	@ -> to aware of unproper use of this element, f. ex in include-File
			@header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
		}
		
		// use the Document Cache
		if (($we_doc->CacheType == 'document' || $we_doc->CacheType == 'full') && $we_doc->CacheLifeTime > 0) {
			$GLOBALS['weCacheOutput'] = false;
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCache.class.php");
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weDocumentCache.class.php");
			
			$weDocumentCache = new weDocumentCache($GLOBALS["we_doc"]->ID, $we_doc->CacheLifeTime);
			
			if ($weDocumentCache->start()) {
				
				// The weDocumentCache must be pushed to a stack because otherwise it could be
				// overwritten in one of the potential includes
				if (!isset($weDocumentCaches) || !is_array($weDocumentCaches)) {
					$weDocumentCaches = array();
				
				}
				array_push($weDocumentCaches, $weDocumentCache);
				
				include ($we_include);
				
				// get the last weDocumentCache from the stack
				$weDocumentCache = array_pop($weDocumentCaches);
				
				$weDocumentCache->end();
			
			}
			$GLOBALS['weCacheOutput'] = true;
			
			ob_start();
			include ($weDocumentCache->getCacheFilename());
			$content = ob_get_contents();
			ob_end_clean();
			
			//
			// --> Start Glossary Replacement
			//
			

			if (defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
				if(isset($we_doc->InGlossar) && $we_doc->InGlossar) {
					include_once (WE_GLOSSARY_MODULE_DIR . "weGlossaryCache.php");
					include_once (WE_GLOSSARY_MODULE_DIR . "weGlossaryReplace.php");
					
					weGlossaryReplace::start();
				}
			
			}
			
			//
			// --> Include Content
			//
			eval("?>" . $content);
			
			//
			// --> Finish Glossary Replacement
			//
			

			if (defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
				if(isset($we_doc->InGlossar) && $we_doc->InGlossar) {
					weGlossaryReplace::end($GLOBALS["we_doc"]->Language);
				}
			
			}
			
		// do not cache the document
		} else {
			
			//
			// --> Start Glossary Replacement
			//
			

			if (defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
				if(isset($we_doc->InGlossar) && $we_doc->InGlossar) {
					include_once (WE_GLOSSARY_MODULE_DIR . "weGlossaryCache.php");
					include_once (WE_GLOSSARY_MODULE_DIR . "weGlossaryReplace.php");
					
					weGlossaryReplace::start();
				}
			
			}
			
			//
			// --> Include Content
			//
			

			include ($we_include);
			
			//
			// --> Finish Glossary Replacement
			//
			

			if (defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])) {
				if(isset($we_doc->InGlossar) && $we_doc->InGlossar) {
					weGlossaryReplace::end($GLOBALS["we_doc"]->Language);
				}
			
			}
		
		}
	
	} else {
		protect(); //	only inside webEdition !!!
		include ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . $we_include);
	}
} else {
	exit("Nothing to include ...");
}

?>