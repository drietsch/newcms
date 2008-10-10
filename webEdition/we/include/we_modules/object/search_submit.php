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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");


###### init document #########
$we_dt = $_SESSION["we_data"][$we_transaction];
include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");
include_once(WE_OBJECT_MODULE_DIR ."we_objectFile.inc.php");

protect();

$we_doc->searchclass->objsearch = isset($_REQUEST["objsearch"]) ? $_REQUEST["objsearch"] : "";
$we_doc->searchclass->objsearchField = isset($_REQUEST["objsearchField"]) ? $_REQUEST["objsearchField"] : "";
$we_doc->searchclass->objlocation = isset($_REQUEST["objlocation"]) ? $_REQUEST["objlocation"] : 0;

if($_REQUEST["todo"] == "add"){
	
		$we_doc->searchclass->height++;
		
		$we_doc->searchclass->searchname = $we_doc->searchclass->objsearch;
		$we_doc->searchclass->searchfield = $we_doc->searchclass->objsearchField;
		$we_doc->searchclass->searchlocation = $we_doc->searchclass->objlocation;
		$we_doc->searchclass->start = 0;
		$we_doc->searchclass->searchstart = 0;
		$we_doc->searchclass->setLimit();

		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
	top.we_cmd("switch_edit_page","' . (isset($go) ? $go : $we_doc->EditPageNr ). '");
</script>';
		
} else if($_REQUEST["todo"] == "delete") {
		
		if($we_doc->searchclass->height == 0) {
			$we_doc->searchclass->objsearch = "";
			$we_doc->searchclass->objsearchField = "";
			$we_doc->searchclass->objlocation = "";
		} else {
			$we_doc->searchclass->removeFilter($_REQUEST['position']);
		}
		
		$we_doc->searchclass->searchname = $we_doc->searchclass->objsearch;
		$we_doc->searchclass->searchfield = $we_doc->searchclass->objsearchField;
		$we_doc->searchclass->searchlocation = $we_doc->searchclass->objlocation;
		
		$we_doc->searchclass->start = 0;
		$we_doc->searchclass->searchstart = 0;
		$we_doc->searchclass->setLimit();
	
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
						top.we_cmd("switch_edit_page","' . (isset($go) ? $go : $we_doc->EditPageNr ). '");
				</script>
				';
		
}else if($_REQUEST["todo"] == "search"){
		$we_doc->searchclass->searchname = $we_doc->searchclass->objsearch;
		$we_doc->searchclass->searchfield = $we_doc->searchclass->objsearchField;
		$we_doc->searchclass->searchlocation = $we_doc->searchclass->objlocation;
		$we_doc->searchclass->start = 0;
		$we_doc->searchclass->searchstart = 0;
		$we_doc->searchclass->setLimit();

		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
						top.we_cmd("switch_edit_page","' . (isset($go) ? $go : $we_doc->EditPageNr ). '");
				</script>
				';
}else if($_REQUEST["todo"]=="changemeta"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
		print '<script language="JavaScript" type="text/javascript">
						top.we_cmd("reload_editpage");
				</script>
				';
}else if($_REQUEST["todo"]=="changedate"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
		print '<script language="JavaScript" type="text/javascript">
						top.we_cmd("reload_editpage");
				</script>
				';
}else if($_REQUEST["todo"]=="changecheckbox"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);
		print '<script language="JavaScript" type="text/javascript">
						top.we_cmd("reload_editpage");
				</script>
				';

}else if($_REQUEST["todo"]=="quickchangemeta"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
					top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["3"].location.replace("/webEdition/we_cmd.php?we_cmd[0]=load_edit_footer&we_transaction='.$we_transaction.'&we_cmd[7]='.$_REQUEST["obj_searchField"].'&we_cmd[6]='.$obj_search.'");
				</script>
				';

}else if($_REQUEST["todo"]=="quickchangedate"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
					top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["3"].location.replace("/webEdition/we_cmd.php?we_cmd[0]=load_edit_footer&we_transaction='.$we_transaction.'&we_cmd[7]='.$_REQUEST["obj_searchField"].'&we_cmd[6]='.$obj_search.'");
				</script>
				';

}else if($_REQUEST["todo"]=="quickcheckbox"){
		$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

		print '<script language="JavaScript" type="text/javascript">
						top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["3"].location.replace("/webEdition/we_cmd.php?we_cmd[0]=load_edit_footer&we_transaction='.$we_transaction.'&we_cmd[7]='.$_REQUEST["obj_searchField"].'&we_cmd[6]='.$obj_search.'");
				</script>
				';

}else if(isset($_REQUEST["obj_searchField"])){
	//echo $obj_searchField."-_".$obj_search;
	$we_doc->searchclass->height=0;
	$we_doc->searchclass->show="AB";
	$go=WE_EDITPAGE_CFWORKSPACE;

	$we_doc->searchclass->searchname = array(0=>$_REQUEST["obj_search"]);
	$we_doc->searchclass->searchfield = array(0=>$_REQUEST["obj_searchField"]);
	$we_doc->searchclass->searchlocation = ((!empty($objlocation))?array(0=>$objlocation):array(0=>"CONTAIN"));
	$we_doc->searchclass->start = 0;
	$we_doc->searchclass->searchstart = 0;
	$we_doc->searchclass->setLimit();
	
	$we_doc->searchclass->objsearch = array(0=>$_REQUEST["obj_search"]);
	$we_doc->searchclass->objsearchField = array(0=>$_REQUEST["obj_searchField"]);
	$we_doc->searchclass->objlocation = ((!empty($objlocation))?array(0=>$objlocation):array(0=>"CONTAIN"));

	$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]);

	print '<script language="JavaScript" type="text/javascript">
					if (top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["1"].document.we_form && top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["1"].document.we_form.elements[\'SearchStart\']) {
						top.weEditorFrameController.getDocumentReferenceByTransaction("'.$_SESSION["we_data"][$we_transaction].'").frames["1"].document.we_form.elements[\'SearchStart\'].value = 0;
					}
					top.we_cmd("switch_edit_page","'.$go.'");
			</script>
			';
}
?>