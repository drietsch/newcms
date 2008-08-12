<?php
	// Activate the webEdition error handler
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
	we_error_handler(false);

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_global.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
	$GLOBALS["DB_WE"] = new DB_WE;
	if($GLOBALS["we_doc"]){
		$GLOBALS["WE_DOC_ID"] = $GLOBALS["we_doc"]->ID;
		if(!isset($GLOBALS["WE_MAIN_ID"])) $GLOBALS["WE_MAIN_ID"] = $GLOBALS["we_doc"]->ID;
		if(!isset($GLOBALS["WE_MAIN_DOC"])) $GLOBALS["WE_MAIN_DOC"] = clone($GLOBALS["we_doc"]);
		if(!isset($GLOBALS["WE_MAIN_DOC_REF"])) $GLOBALS["WE_MAIN_DOC_REF"] = &$GLOBALS["we_doc"];
		if(!isset($GLOBALS["WE_MAIN_EDITMODE"])) $GLOBALS["WE_MAIN_EDITMODE"] = isset($GLOBALS["we_editmode"]) ? $GLOBALS["we_editmode"] : "";
		$GLOBALS["WE_DOC_ParentID"] = $GLOBALS["we_doc"]->ParentID;
		$GLOBALS["WE_DOC_Path"] = $GLOBALS["we_doc"]->Path;
		$GLOBALS["WE_DOC_IsDynamic"] = $GLOBALS["we_doc"]->IsDynamic;
		$GLOBALS["WE_DOC_FILENAME"] = $GLOBALS["we_doc"]->Filename;
		$GLOBALS["WE_DOC_Category"] = isset($GLOBALS["we_doc"]->Category) ? $GLOBALS["we_doc"]->Category : "";
		$GLOBALS["WE_DOC_EXTENSION"] = $GLOBALS["we_doc"]->Extension;
		$GLOBALS["TITLE"] = $GLOBALS["we_doc"]->getElement("Title");
		$GLOBALS["KEYWORDS"] = $GLOBALS["we_doc"]->getElement("Keywords");
		$GLOBALS["DESCRIPTION"] = $GLOBALS["we_doc"]->getElement("Description");
		$GLOBALS["CHARSET"] = $GLOBALS["we_doc"]->getElement("Charset");
		$__tmp = explode("_",$GLOBALS["we_doc"]->Language);
		$__lang = strtolower($__tmp[0]);
		if ($__lang) {
			$__parts = split("_", $GLOBALS["WE_LANGUAGE"]);
			$__last = array_pop($__parts);
			// Charset of page is not UTF-8 but languge files of page are UTF-8
			// Then change language files to non UTF-8 pedant if available
			if (count($__parts) && $__last === "UTF-8" && $GLOBALS["CHARSET"] !== "UTF-8") {
				$__lang = $__parts[0];
				if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$__lang)) {
					$GLOBALS["WE_LANGUAGE"] = $__lang;
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
				}


			// Charset of page is  UTF-8 but languge files of page are not UTF-8
			// Then change language files to UTF-8 pedant if available
			} else if ($__last !== "UTF-8" && $GLOBALS["CHARSET"] === "UTF-8") {
				$__lang = $GLOBALS["WE_LANGUAGE"] . "_UTF-8";
				if (file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$__lang)) {
					$GLOBALS["WE_LANGUAGE"] = $__lang;
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
				}
			}
		}
	}
	?><?php if( (!isset($GLOBALS["WE_HTML_HEAD_BODY"]) || !$GLOBALS["WE_HTML_HEAD_BODY"] ) && (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"])): ?><?php $GLOBALS["WE_HTML_HEAD_BODY"] = true; ?><html><head><title></title><?php if(isset($GLOBALS["we_baseHref"]) && $GLOBALS["we_baseHref"]): ?><base href="<?php print $GLOBALS["we_baseHref"] ?>" /><?php endif ?>

<?php if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] ): ?>
<?php print STYLESHEET_BUTTONS_ONLY . SCRIPT_BUTTONS_ONLY; ?>
<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php"); ?>
<?php endif ?></head>
<body <?php if(isset($we_editmode) && $we_editmode) print " onUnload=\"doUnload()\""; ?>>
<?php if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) : ?>
<form name="we_form" method="post" onsubmit="return false;"><?php $GLOBALS["we_doc"]->pHiddenTrans() ?>
<?php endif ?><?php endif ?><?php
/*
require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/lib/we/net/Http.php");

$http = new we_net_Http();
$http->uri = "http://update.ali.intra/webEdition/liveUpdate.php";
$response = $http->get();
echo $http->status." ".$http->statustext;
error_log(print_r($response,true));
*/

require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/lib/we/net/LiveUpdate.php");
$lu = new we_net_LiveUpdate();
//$lu->checkConnection();
echo $lu->sendRequest("fdasdf");

?><?php if((!isset($WE_HTML_HEAD_BODY) || !$WE_HTML_HEAD_BODY ) && (isset($we_editmode) && $we_editmode)): ?><?php if (isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"]) : ?>
</form>
<?php endif ?>
</body></html><?php $WE_HTML_HEAD_BODY = true; ?><?php endif ?><?php if(isset($GLOBALS["we_editmode"]) && $GLOBALS["we_editmode"] ): ?><script language="JavaScript" type="text/javascript">setTimeout("doScrollTo();",100);</script><?php endif ?>