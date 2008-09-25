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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/rebuild.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/rebuild/rebuildFragment.inc.php");



/**
* Class which contains all functions for the
* rebuild dialog and the rebuild function
* @static
*/
class we_rebuild_wizard{

	/**
	* Dummy function for stupid people who want to call the constructor for this static class
	*
	* @return we_rebuild_wizard
	*/
	function we_rebuild_wizard(){
		exit("This is a static class! Don't call the constructor directly!");
	}

	/**
	* returns HTML for the Body Frame
	*
	* @return string
	*/
	function getBody(){
		$step = isset($_REQUEST["step"]) ? $_REQUEST["step"] : "0";
		eval('$contents = we_rebuild_wizard::getStep'.$step.'();');
		return we_rebuild_wizard::getPage($contents);
	}

	/**
	* returns HTML for the Frame with the progress bar
	*
	* @return string
	*/
	function getBusy(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");
		$dc = isset($_REQUEST["dc"]) ? $_REQUEST["dc"] : 0;
		
		$WE_PB = new we_progressBar(0,0,true);
		$WE_PB->setStudLen($dc ? 490 : 200);
		$WE_PB->addText("",0,"pb1");
		$js = $WE_PB->getJSCode();
		$pb = $WE_PB->getHTML();

		$js .= 		'<script type="text/javascript">'
				.	'function showRefreshButton() {'
				.	'  prevBut = document.getElementById(\'prev\');'
				.	'  nextBut = document.getElementById(\'next\');'
				.	'  refrBut = document.getElementById(\'refresh\');'
				.	'  prevBut.style.display = \'none\';'
				.	'  nextBut.style.display = \'none\';'
				.	'  refrBut.style.display = \'\';'
				.	'}'
				.	'function showPrevNextButton() {'
				.	'  prevBut = document.getElementById(\'prev\');'
				.	'  nextBut = document.getElementById(\'next\');'
				.	'  refrBut = document.getElementById(\'refresh\');'
				.	'  refrBut.style.display = \'none\';'
				.	'  prevBut.style.display = \'\';'
				.	'  nextBut.style.display = \'\';'
				.	'}'
				.	'</script>';

		$WE_BTN = new we_button();
		$cancelButton = $WE_BTN->create_button("cancel","javascript:top.close();");
		$refreshButton = $WE_BTN->create_button("refresh","javascript:parent.wizcmd.location.reload();", true, -1, -1, "", "", false, false);

		$nextbutdisabled = !(we_hasPerm("REBUILD_ALL") || we_hasPerm("REBUILD_FILTERD") || we_hasPerm("REBUILD_OBJECTS") || we_hasPerm("REBUILD_INDEX") || we_hasPerm("REBUILD_THUMBS") || we_hasPerm("REBUILD_META"));
		
		if($dc){
			$buttons = $WE_BTN->create_button_table(array($refreshButton, $cancelButton), 10);
			$pb = htmlDialogLayout($pb,$GLOBALS["l_rebuild"]["rebuild"],$buttons);
		}else{
			$prevButton = $WE_BTN->create_button("back","javascript:parent.wizbody.handle_event('previous');", true, -1, -1, "", "", true, false);
			$nextButton = $WE_BTN->create_button("next","javascript:parent.wizbody.handle_event('next');", true, -1, -1, "", "", $nextbutdisabled, false);

			$content2 = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0"), 1, 4);
			$content2->setCol(0, 0, array("id" => "prev", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $prevButton);
			$content2->setCol(0, 1, array("id" => "next", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $nextButton);
			$content2->setCol(0, 2, array("id" => "refresh", "style"=>"display:none; padding-left:10px;", "align" => "right"), $refreshButton);
			$content2->setCol(0, 3, array("id" => "cancel", "style"=>"display:table-cell; padding-left:10px;", "align" => "right"), $cancelButton);

			$content = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "100%"), 1, 2);
			$content->setCol(0, 0, array("id"=>"progr", "style"=>"display:none", "align"=>"left"), $pb);
			$content->setCol(0, 1, array("align" => "right"), $content2->getHtmlCode());

		}


		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET.
				($dc ? "" : we_htmlElement::jsElement($WE_BTN->create_state_changer(false))).$js).
			we_htmlElement::htmlBody(array("class"=>($dc ? "weDialogBody" : "weDialogButtonsBody")), ($dc ? $pb : $content->getHtmlCode())
			)
		);

	}

	/**
	* returns HTML for the Cmd Frame
	*
	* @return string for now it is an empty page
	*/
	function getCmd(){
		return we_rebuild_wizard::getPage(array("",""));
	}

	/**
	* returns the HTML for the First Step (0) of the wizard
	*
	* @return string
	*/
	function getStep0() {
		$btype = isset($_REQUEST["btype"]) ? $_REQUEST["btype"] : "rebuild_all";
		$categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : "";
		$doctypes = (isset($_REQUEST["doctypes"]) && is_array($_REQUEST["doctypes"])) ? makeCSVFromArray($_REQUEST["doctypes"],true) : "";
		$folders = isset($_REQUEST["folders"]) ? $_REQUEST["folders"] : (($dws = get_def_ws()) ? $dws : "");
		$maintable = isset($_REQUEST["maintable"]) ? $_REQUEST["maintable"] : 0;
		$tmptable = isset($_REQUEST["tmptable"]) ? $_REQUEST["tmptable"] : 0;
		$thumbsFolders = isset($_REQUEST["thumbsFolders"]) ? $_REQUEST["thumbsFolders"] : (($dws = get_def_ws()) ? $dws : "");
		$thumbs = (isset($_REQUEST["thumbs"]) && is_array($_REQUEST["thumbs"])) ? makeCSVFromArray($_REQUEST["thumbs"],true) : "";
		$catAnd = isset($_REQUEST["catAnd"]) ? $_REQUEST["catAnd"] : 0;
		$metaFolders = isset($_REQUEST["metaFolders"]) ? $_REQUEST["metaFolders"] : (($dws = get_def_ws()) ? $dws : "");
		$metaFields = isset($_REQUEST["_field"]) ? $_REQUEST["_field"] : array();
		$onlyEmpty = isset($_REQUEST["onlyEmpty"]) ? $_REQUEST["onlyEmpty"] : 0;

		if (isset($_REQUEST["type"])) {
			$type = $_REQUEST["type"];
		} else {
			if (we_hasPerm("REBUILD_ALL") || we_hasPerm("REBUILD_FILTERD")) {
				$type = "rebuild_documents";
			} else if (defined("OBJECT_FILES_TABLE") && we_hasPerm("REBUILD_OBJECTS") ) {
				$type = "rebuild_objects";
			} else if (we_hasPerm("REBUILD_INDEX") ) {
				$type = "rebuild_index";
			} else if (we_hasPerm("REBUILD_THUMBS") ) {
				$type = "rebuild_thumbnails";
			} else if (we_hasPerm("REBUILD_NAVIGATION") ) {
				$type = "rebuild_navigation";
			} else if (we_hasPerm("REBUILD_META") ) {
				$type = "rebuild_metadata";
			} else {
				$type = "";
			}
		}

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_image_edit.class.php");

		$parts = array();
		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_documents", ($type=="rebuild_documents" && (we_hasPerm("REBUILD_ALL") || we_hasPerm("REBUILD_FILTERD"))), "type", $GLOBALS["l_rebuild"]["documents"], true, "defaultfont", "setNavStatDocDisabled()", (!(we_hasPerm("REBUILD_ALL")  || we_hasPerm("REBUILD_FILTERD")) ), $GLOBALS["l_rebuild"]["txt_rebuild_documents"], 0, 495),
			"space"		=> 0)
		);

		if(defined("OBJECT_FILES_TABLE")){

			array_push($parts, array(
				"headline"	=> "",
				"html"		=> we_forms::radiobutton("rebuild_objects", ($type=="rebuild_objects" && we_hasPerm("REBUILD_OBJECTS")), "type", $GLOBALS["l_rebuild"]["rebuild_objects"], true, "defaultfont", "setNavStatDocDisabled()", (!we_hasPerm("REBUILD_OBJECTS")), $GLOBALS["l_rebuild"]["txt_rebuild_objects"], 0, 495),
				"space"		=> 0)
			);
		}

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_index", ($type=="rebuild_index" && we_hasPerm("REBUILD_INDEX")), "type", $GLOBALS["l_rebuild"]["rebuild_index"], true, "defaultfont", "setNavStatDocDisabled()", (!we_hasPerm("REBUILD_INDEX")), $GLOBALS["l_rebuild"]["txt_rebuild_index"], 0, 495),
			"space"		=> 0)
		);

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_thumbnails", ($type=="rebuild_thumbnails" && we_hasPerm("REBUILD_THUMBS")), "type", $GLOBALS["l_rebuild"]["thumbnails"], true, "defaultfont", "setNavStatDocDisabled()", (we_image_edit::gd_version()==0 || (!we_hasPerm("REBUILD_THUMBS"))), $GLOBALS["l_rebuild"]["txt_rebuild_thumbnails"], 0, 495),
			"space"		=> 0)
		);

		$_navRebuildHTML = '<div>
' . we_forms::radiobutton("rebuild_navigation", ($type=="rebuild_navigation" && we_hasPerm("REBUILD_NAVIGATION")), "type", $GLOBALS["l_rebuild"]["navigation"], false, "defaultfont", "setNavStatDocDisabled()", !we_hasPerm("REBUILD_NAVIGATION"), $GLOBALS["l_rebuild"]["txt_rebuild_navigation"], 0, 495) . '
</div>
<div style="padding:10px 20px;">
' . we_forms::checkbox(1, false, 'rebuildStaticAfterNavi', $GLOBALS["l_rebuild"]["rebuildStaticAfterNaviCheck"],false,'defaultfont', '', true, $GLOBALS["l_rebuild"]["rebuildStaticAfterNaviHint"],0,475) . '
</div>';

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $_navRebuildHTML,
			"space"		=> 0)
		);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
		$metaDataFields = weMetaData::getDefinedMetaDataFields();

		$_rebuildMetaDisabled = true;
		foreach($metaDataFields as $md) {
			if ($md['importFrom'] !== "") {
				$_rebuildMetaDisabled = false;
				break;
			}
		}

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_metadata", ($type=="rebuild_metadata" && we_hasPerm("REBUILD_META")), "type", $GLOBALS["l_rebuild"]["metadata"], true, "defaultfont", "setNavStatDocDisabled()", (!we_hasPerm("REBUILD_META")) || $_rebuildMetaDisabled, $GLOBALS["l_rebuild"]["txt_rebuild_metadata"], 0, 495),
			"space"		=> 0)
		);

		$allbutdisabled = !(we_hasPerm("REBUILD_ALL") || we_hasPerm("REBUILD_FILTERD") || we_hasPerm("REBUILD_OBJECTS") || we_hasPerm("REBUILD_INDEX") || we_hasPerm("REBUILD_THUMBS") || we_hasPerm("REBUILD_META"));


		$js = 	"\n".
				'window.onload = function(){top.focus();}'."\n".
				'function handle_event(what){'."\n".
				'	f = document.we_form;'."\n".
				'	switch(what){'."\n".
				'		case "previous":'."\n".
				'			break;'."\n".
				'		case "next":'."\n".
				'			selectedValue="";'."\n".
				'			for(var i=0;i<f.type.length;i++){'."\n".
				'				if(f.type[i].checked){;'."\n".
				'					selectedValue = f.type[i].value;'."\n".
						'		}'."\n".
				'			}'."\n".
				'			goTo(selectedValue)'."\n".
				'			break;'."\n".
				'	}'."\n".
				'}'."\n".

				'function goTo(where){'."\n".
				'	f = document.we_form;'."\n".
				'	switch(where){'."\n".
				'		case "rebuild_thumbnails":'."\n".
				'		case "rebuild_documents":'."\n".
				'			f.target="wizbody";'."\n".
				'			break;'."\n".
				'		case "rebuild_objects":'."\n".
				'		case "rebuild_index":'."\n".
				'		case "rebuild_navigation":'."\n".
				'			set_button_state(1);'."\n".
				'			f.target="wizcmd";'."\n".
				'			f.step.value="2";'."\n".
				'			break;'."\n".
				'	}'."\n".
				'	f.submit();'."\n".
				'}'."\n".

				'function set_button_state(alldis) {'."\n" .
				'	if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){'."\n" .
				'		top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "disabled");'."\n" .
				'		if(alldis){'."\n" .
				'			top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "disabled");'."\n" .
				'			top.frames["wizbusy"].showRefreshButton();'."\n" .
				'		}else{'."\n" .
				'			top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");'."\n" .
				'		}'."\n" .
				'	}else{'."\n" .
				'		setTimeout("set_button_state("+(alldis ? 1 : 0)+")",300);'."\n" .
				'	}'."\n" .
				'}'."\n".
				'set_button_state('.($allbutdisabled ? 1 : 0).');'."\n";

		$js .= '
	function setNavStatDocDisabled() {
		var radio = document.getElementById("type");
		var check = document.getElementById("rebuildStaticAfterNavi");
		var checkLabel = document.getElementById("label_rebuildStaticAfterNavi");
		check.disabled=(!radio.checked);
		checkLabel.style.color = radio.checked ? "" : "gray";
	}
';

		$dthidden = "";
		$doctypesArray = makeArrayFromCSV($doctypes);
		for($i=0; $i<sizeof($doctypesArray); $i++){
			$dthidden .= we_htmlElement::htmlHidden(array("name" => "doctypes[$i]", "value" => $doctypesArray[$i]));
		}

		$thumbsHidden = "";
		$thumbsArray = makeArrayFromCSV($thumbs);
		for($i=0; $i<sizeof($thumbsArray); $i++){
			$thumbsHidden .= we_htmlElement::htmlHidden(array("name" => "thumbs[$i]", "value" => $thumbsArray[$i]));
		}

		$metaFieldsHidden = "";
		foreach ($metaFields as $_key=>$_val){
			$metaFieldsHidden .= we_htmlElement::htmlHidden(array("name" => "_field[$_key]", "value" => $_val));
		}

		return array($js,we_multiIconBox::getHTML("", "100%", $parts, 40,"", -1, "", "", false, $GLOBALS["l_rebuild"]["rebuild"]).
							$dthidden.
							$thumbsHidden.
							$metaFieldsHidden .
							we_htmlElement::htmlHidden(array("name" => "catAnd", "value" => $catAnd)).
							we_htmlElement::htmlHidden(array("name" => "thumbsFolders", "value" => $thumbsFolders)).
							we_htmlElement::htmlHidden(array("name" => "metaFolders", "value" => $metaFolders)).
							we_htmlElement::htmlHidden(array("name" => "maintable", "value" => $maintable)).
							we_htmlElement::htmlHidden(array("name" => "tmptable", "value" => $tmptable)).
							we_htmlElement::htmlHidden(array("name" => "categories", "value" => $categories)).
							we_htmlElement::htmlHidden(array("name" => "folders", "value" => $folders)).
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "btype", "value" => $btype)).
							we_htmlElement::htmlHidden(array("name" => "onlyEmpty", "value" => $onlyEmpty)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "rebuild")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "1")));
	}

	/**
	* returns the HTML for the Second Step (1) of the wizard
	*
	* @return string
	*/
	function getStep1() {
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "rebuild_documents";

		switch($type){
			case "rebuild_documents":
				return we_rebuild_wizard::getRebuildDocuments();
			case "rebuild_thumbnails":
				return we_rebuild_wizard::getRebuildThumbnails();
			case "rebuild_metadata":
				return we_rebuild_wizard::getRebuildMetadata();
		}

	}

	/**
	* returns the HTML for the Third Step (2) of the wizard. - Here the real work (loop) is done - it should be displayed in the cmd frame
	*
	* @return string
	*/
	function getStep2() {
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "rebuild_documents";
		$btype = isset($_REQUEST["btype"]) ? $_REQUEST["btype"] : "rebuild_all";
		$categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : "";
		$doctypes = (isset($_REQUEST["doctypes"]) && is_array($_REQUEST["doctypes"])) ? makeCSVFromArray($_REQUEST["doctypes"],true) : "";
		$folders = isset($_REQUEST["folders"]) ? $_REQUEST["folders"] : "";
		$maintable = isset($_REQUEST["maintable"]) ? $_REQUEST["maintable"] : 0;
		$tmptable = isset($_REQUEST["tmptable"]) ? $_REQUEST["tmptable"] : 0;
		$thumbsFolders = isset($_REQUEST["thumbsFolders"]) ? $_REQUEST["thumbsFolders"] : "";
		$thumbs = (isset($_REQUEST["thumbs"]) && is_array($_REQUEST["thumbs"])) ? makeCSVFromArray($_REQUEST["thumbs"],true) : "";
		$catAnd = isset($_REQUEST["catAnd"]) ? $_REQUEST["catAnd"] : 0;
		$templateID = isset($_REQUEST["templateID"]) ? $_REQUEST["templateID"] : 0;
		$metaFolders = isset($_REQUEST["metaFolders"]) ? $_REQUEST["metaFolders"] : (($dws = get_def_ws()) ? $dws : "");
		$metaFields = isset($_REQUEST["_field"]) ? $_REQUEST["_field"] : array();
		$onlyEmpty = isset($_REQUEST["onlyEmpty"]) ? $_REQUEST["onlyEmpty"] : 0;

		$taskname = md5(session_id()."_rebuild");
		$currentTask = isset($_GET["fr_".$taskname."_ct"]) ? $_GET["fr_".$taskname."_ct"] : 0;
		$taskFilename = FRAGMENT_LOCATION.$taskname;


		$js = 'function set_button_state() {'."\n" .
					'	if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){'."\n" .
					'		top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "enabled");'."\n" .
					'		top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");'."\n" .
					'	}else{'."\n" .
					'		setTimeout("set_button_state()",300);'."\n" .
					'	}'."\n" .
					'}'."\n".
					'set_button_state();'."\n";
		if(!(file_exists($taskFilename) && $currentTask)){
			switch($type){
				case "rebuild_documents":
					$data = we_rebuild::getDocuments($btype,$categories,$catAnd,$doctypes,$folders,$maintable,$tmptable,$templateID);
					break;
				case "rebuild_thumbnails":
					if(!$thumbs){
						return array($js.";top.frames[\"wizbusy\"].showPrevNextButton();" . we_message_reporting::getShowMessageCall($GLOBALS["l_rebuild"]["no_thumbs_selected"], WE_MESSAGE_WARNING),"");
					}
					$data = we_rebuild::getThumbnails($thumbs,$thumbsFolders);
					break;
				case "rebuild_index":
					$data = we_rebuild::getIndex();
					break;
				case "rebuild_objects":
					$data = we_rebuild::getObjects();
					break;
				case "rebuild_navigation":
					$data = we_rebuild::getNavigation();
					break;
				case "rebuild_metadata":
					$data = we_rebuild::getMetadata($metaFields, $onlyEmpty, $metaFolders);
					break;
			}
			if(count($data)){
				$fr = new rebuildFragment($taskname,1,0,array(),$data);

				return array();
			}else{
				return array($js.we_message_reporting::getShowMessageCall($GLOBALS["l_rebuild"]["nothing_to_rebuild"],1).'top.wizbusy.showPrevNextButton();', "");
			}
		}else{
				$fr = new rebuildFragment($taskname,1,0,array());

				return array();
		}

	}

	/**
	* returns HTML for the category form
	*
	* @return string
	* @param string $categories csv value with category IDs
	* @param boolean $catAnd if the categories should be connected with AND
	*/
	function formCategory($categories,$catAnd){

		global $l_global;

		if(defined("ISP_VERSION") && ISP_VERSION){
			return "";
		}
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		$we_button = new we_button();

		$catAndCheck = we_forms::checkbox("1",$catAnd,"catAnd",$GLOBALS["l_rebuild"]["catAnd"],false,"defaultfont","document.we_form.btype[2].checked=true;");
		$delallbut = $we_button->create_button("delete_all","javascript:document.we_form.btype[2].checked=true;we_cmd('del_all_cats')");
		$addbut = $we_button->create_button("add", "javascript:document.we_form.btype[2].checked=true;we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.we_cmd(\\'add_cat\\',top.allIDs);')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));
		$butTable = $we_button->create_button_table(array($delallbut, $addbut));
		$upperTable = '<table border="0" cellpadding="0" cellspacing="0" width="495"><tr><td align="left">'.$catAndCheck.'</td><td align="right">'.$butTable.'</td></tr></table>';

		$cats = new MultiDirChooser(495,$categories,"del_cat",$upperTable,"","Icon,Path", CATEGORY_TABLE);
		return $GLOBALS["l_global"]["categorys"]."<br>".getPixel(1,3)."<br>".$cats->get();
	}

	/**
	* returns HTML for the doctypes form
	*
	* @return string
	* @param string $doctypes csv value with doctype IDs
	*/
	function formDoctypes($doctypes){

		global $_isp_hide_doctypes;

		$GLOBALS["DB_WE"]->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " Order By DocType");
		$DTselect = $GLOBALS["l_global"]["doctypes"]."<br>".getPixel(1,3)."<br>".'<select class="defaultfont" name="doctypes[]" size="5" multiple style="width: 495px" onchange="document.we_form.btype[2].checked=true;">'."\n";

		$doctypesArray = makeArrayFromCSV($doctypes);
		while($GLOBALS["DB_WE"]->next_record()){
			if(defined("ISP_VERSION") && ISP_VERSION){
				if(in_array($GLOBALS["DB_WE"]->f("DocType"), $_isp_hide_doctypes)){
					continue;
				}
			}
			$DTselect .= '<option value="'.$GLOBALS["DB_WE"]->f("ID").'"'.(in_array($GLOBALS["DB_WE"]->f("ID"),$doctypesArray) ? " selected" : "").'>'.$GLOBALS["DB_WE"]->f("DocType")."</option>\n";
		}
		$DTselect .= "</select>\n";
		return $DTselect;
	}

	/**
	* returns HTML for the directories form
	*
	* @return string
	* @param string $folders csv value with directory IDs
	* @param boolean $thumnailpage if it should displayed in the thumbnails page or on an other page
	*/
	function formFolders($folders,$thumnailpage=false, $width="495"){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:".($thumnailpage ? "" : "document.we_form.btype[2].checked=true;")."we_cmd('del_all_folders')");
		$addbut    = $we_button->create_button("add", "javascript:".($thumnailpage ? "" : "document.we_form.btype[2].checked=true;")."we_cmd('openDirselector','','".FILE_TABLE."','','','fillIDs();opener.we_cmd(\\'add_folder\\',top.allIDs);','','','',1)");

		$dirs = new MultiDirChooser($width,$folders,"del_folder",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",FILE_TABLE);

		return ($thumnailpage ? $GLOBALS["l_rebuild"]["thumbdirs"] : $GLOBALS["l_rebuild"]["dirs"])."<br>".getPixel(1,3)."<br>".$dirs->get();

	}

	/**
	* returns HTML for the thumbnails form
	*
	* @return string
	* @param string $thumbs csv value with thumb IDs
	*/
	function formThumbs($thumbs){
		$GLOBALS["DB_WE"]->query("SELECT ID,Name FROM " . THUMBNAILS_TABLE . " Order By Name");
		$Thselect = $GLOBALS["l_rebuild"]["thumbnails"]."<br>".getPixel(1,3)."<br>".
			'<select class="defaultfont" name="thumbs[]" size="10" multiple style="width: 520px">'."\n";

		$thumbsArray = makeArrayFromCSV($thumbs);
		while($GLOBALS["DB_WE"]->next_record()){
			$Thselect .= '<option value="'.$GLOBALS["DB_WE"]->f("ID").'"'.(in_array($GLOBALS["DB_WE"]->f("ID"),$thumbsArray) ? " selected" : "").'>'.$GLOBALS["DB_WE"]->f("Name")."</option>\n";
		}
		$Thselect .= "</select>\n";
		return $Thselect;
	}

	function formMetadata($metaFields, $onlyEmpty) {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
		$metaDataFields = weMetaData::getDefinedMetaDataFields();

		$_html = '<script type="text/javascript">document._errorMessage='.(count($metaFields) ? '""' : '"'.addslashes($GLOBALS["l_rebuild"]["noFieldsChecked"]).'"').'</script>';
		$_html .= htmlAlertAttentionBox($GLOBALS["l_rebuild"]["expl_rebuild_metadata"],2,520);
		$_html .= '<div class="defaultfont" style="margin:10px 0 5px 0;">'.$GLOBALS["l_rebuild"]["metadata"].':</div>'."\n";

		$we_button = new we_button();

		$selAllBut = $we_button->create_button("selectAll","javascript:we_cmd('select_all_fields');");
		$deselAllBut = $we_button->create_button("deselectAll","javascript:we_cmd('deselect_all_fields');");

		foreach ($metaDataFields as $md) {
			if ($md['importFrom']) {
				$checked = isset($metaFields[$md['tag']]) && $metaFields[$md['tag']];
				$_html .= we_forms::checkbox(1,$checked,"_field[" . $md['tag'] . "]",$md['tag'],false,"defaultfont","checkForError()");
			}
		}

		$_html .= $we_button->create_button_table(
			array (
				$selAllBut,
				$deselAllBut
			),
			10,
			array('style' => 'margin:10px 0 20px 0;')
		);

		$_html .= we_forms::checkbox(1,$onlyEmpty, 'onlyEmpty',$GLOBALS["l_rebuild"]["onlyEmpty"]);


		return $_html;
	}

	/**
	* returns Array with javascript (array[0]) and HTML Content (array[1]) for the rebuild document page
	*
	* @return array
	*/
	function getRebuildDocuments(){

		$thumbsFolders = isset($_REQUEST["thumbsFolders"]) ? $_REQUEST["thumbsFolders"] : "";
		$metaFolders = isset($_REQUEST["metaFolders"]) ? $_REQUEST["metaFolders"] : "";
		$metaFields = isset($_REQUEST["_field"]) ? $_REQUEST["_field"] : array();
		$thumbs = (isset($_REQUEST["thumbs"]) && is_array($_REQUEST["thumbs"])) ? makeCSVFromArray($_REQUEST["thumbs"],true) : "";
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "rebuild_documents";
		$btype = isset($_REQUEST["btype"]) ? $_REQUEST["btype"] : "rebuild_all";
		$categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : "";
		$doctypes = (isset($_REQUEST["doctypes"]) && is_array($_REQUEST["doctypes"])) ? makeCSVFromArray($_REQUEST["doctypes"],true) : "";
		$folders = isset($_REQUEST["folders"]) ? $_REQUEST["folders"] : "";
		$maintable = isset($_REQUEST["maintable"]) ? $_REQUEST["maintable"] : 0;
		$tmptable = isset($_REQUEST["tmptable"]) ? $_REQUEST["tmptable"] : 0;
		$catAnd = isset($_REQUEST["catAnd"]) ? $_REQUEST["catAnd"] : 0;
		$onlyEmpty = isset($_REQUEST["onlyEmpty"]) ? $_REQUEST["onlyEmpty"] : 0;


		$ws = get_ws(FILE_TABLE,true);
		if($ws && strpos($ws,(",0,")) !== true && ($folders=="" || $folders == "0")){
			$folders = get_def_ws(FILE_TABLE);
		}
		$parts = array();

		if($_SESSION["perms"]["ADMINISTRATOR"]){
			$all_content = we_forms::checkbox("1",$maintable,"maintable",$GLOBALS["l_rebuild"]["rebuild_maintable"],false,"defaultfont","document.we_form.btype[0].checked=true;");
			$all_content .= we_forms::checkbox("1",$tmptable,"tmptable",$GLOBALS["l_rebuild"]["rebuild_tmptable"],false,"defaultfont","document.we_form.btype[0].checked=true;");
		}else{
			$all_content = "";
		}

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_all", ($btype=="rebuild_all" &&  we_hasPerm("REBUILD_ALL")), "btype", $GLOBALS["l_rebuild"]["rebuild_all"], true, "defaultfont", "", (!we_hasPerm("REBUILD_ALL")), $GLOBALS["l_rebuild"]["txt_rebuild_all"], 0, 495,"",$all_content),
			"space"		=> 0)
		);

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> we_forms::radiobutton("rebuild_templates", ($btype=="rebuild_templates" &&  we_hasPerm("REBUILD_TEMPLATES")), "btype", $GLOBALS["l_rebuild"]["rebuild_templates"], true, "defaultfont", "", (!we_hasPerm("REBUILD_TEMPLATES")), $GLOBALS["l_rebuild"]["txt_rebuild_templates"], 0, 495),
			"space"		=> 0)
		);

		$filter_content = we_rebuild_wizard::formCategory($categories,$catAnd).'<br>'.getPixel(2,5)."<br>".
						we_rebuild_wizard::formDoctypes($doctypes).'<br>'.getPixel(2,10)."<br>".
						we_rebuild_wizard::formFolders($folders);

		$filter_content = we_forms::radiobutton("rebuild_filter", ($btype=="rebuild_filter" && we_hasPerm("REBUILD_FILTERD") || ($btype=="rebuild_all" && (!we_hasPerm("REBUILD_ALL")) && we_hasPerm("REBUILD_FILTERD"))), "btype", $GLOBALS["l_rebuild"]["rebuild_filter"], true, "defaultfont", "", (!we_hasPerm("REBUILD_FILTERD")), $GLOBALS["l_rebuild"]["txt_rebuild_filter"], 0, 495,"",$filter_content);


		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $filter_content,
			"space"		=> 0)
		);

		$thumbsHidden = "";
		$thumbsArray = makeArrayFromCSV($thumbs);
		for($i=0; $i<sizeof($thumbsArray); $i++){
			$thumbsHidden .= we_htmlElement::htmlHidden(array("name" => "thumbs[$i]", "value" => $thumbsArray[$i]));
		}
		$metaFieldsHidden = "";
		foreach ($metaFields as $_key=>$_val){
			$metaFieldsHidden .= we_htmlElement::htmlHidden(array("name" => "_field[$_key]", "value" => $_val));
		}
		return array(we_rebuild_wizard::getPage2Js(),we_multiIconBox::getHTML("", "100%", $parts, 40, "", -1, "", "", false, $GLOBALS["l_rebuild"]["rebuild_documents"]).
							$thumbsHidden.
							$metaFieldsHidden.
							we_htmlElement::htmlHidden(array("name" => "thumbsFolders", "value" => $thumbsFolders)).
							we_htmlElement::htmlHidden(array("name" => "metaFolders", "value" => $metaFolders)).
							we_htmlElement::htmlHidden(array("name" => "metaFields", "value" => $metaFields)).
							we_htmlElement::htmlHidden(array("name" => "onlyEmpty", "value" => $onlyEmpty)).
							we_htmlElement::htmlHidden(array("name" => "folders", "value" => $folders)).
							we_htmlElement::htmlHidden(array("name" => "categories", "value" => $categories)).
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "rebuild")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "2")));
	}

	/**
	* returns Array with javascript (array[0]) and HTML Content (array[1]) for the rebuild metadata page
	*
	* @return array
	*/
	function getRebuildThumbnails(){

		$thumbsFolders = isset($_REQUEST["thumbsFolders"]) ? $_REQUEST["thumbsFolders"] : "";
		$metaFolders = isset($_REQUEST["metaFolders"]) ? $_REQUEST["metaFolders"] : "";
		$metaFields = isset($_REQUEST["_field"]) ? $_REQUEST["_field"] : array();
		$thumbs = (isset($_REQUEST["thumbs"]) && is_array($_REQUEST["thumbs"])) ? makeCSVFromArray($_REQUEST["thumbs"],true) : "";
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "rebuild_documents";
		$categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : "";
		$doctypes = (isset($_REQUEST["doctypes"]) && is_array($_REQUEST["doctypes"])) ? makeCSVFromArray($_REQUEST["doctypes"],true) : "";
		$folders = isset($_REQUEST["folders"]) ? $_REQUEST["folders"] : "";
		$catAnd = isset($_REQUEST["catAnd"]) ? $_REQUEST["catAnd"] : 0;
		$onlyEmpty = isset($_REQUEST["onlyEmpty"]) ? $_REQUEST["onlyEmpty"] : 0;

		$ws = get_ws(FILE_TABLE,true);

		// check if folers are in Workspace of User

		if ($ws && $folders) {
			$newFolders = array();
			$wsArray = makeArrayFromCSV($ws);
			$foldersArray = makeArrayFromCSV($folders);
			for($i=0; $i< count($foldersArray); $i++) {
				if (in_workspace($foldersArray[$i],$ws)) {
					array_push($newFolders,$foldersArray[$i]);
				}
			}
			$folders = makeCSVFromArray($newFolders);
		}

		if($ws && strpos($ws,(",0,")) !== true && ($thumbsFolders=="" || $thumbsFolders == "0")){
			$thumbsFolders = get_def_ws(FILE_TABLE);
		}
		$parts = array();

		$content = we_rebuild_wizard::formThumbs($thumbs).
						'<br>'.getPixel(2,15)."<br>".
						we_rebuild_wizard::formFolders($thumbsFolders,true,520);



		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $content,
			"space"		=> 0)
		);


		$dthidden = "";
		$doctypesArray = makeArrayFromCSV($doctypes);
		for($i=0; $i<sizeof($doctypesArray); $i++){
			$dthidden .= we_htmlElement::htmlHidden(array("name" => "doctypes[$i]", "value" => $doctypesArray[$i]));
		}
		$metaFieldsHidden = "";
		foreach ($metaFields as $_key=>$_val){
			$metaFieldsHidden .= we_htmlElement::htmlHidden(array("name" => "_field[$_key]", "value" => $_val));
		}
		return array(we_rebuild_wizard::getPage2Js("thumbsFolders"),we_multiIconBox::getHTML("", "100%", $parts, 40, "", -1, "", "", false, $GLOBALS["l_rebuild"]["rebuild_thumbnails"]).
							$dthidden.
							$metaFieldsHidden.
							we_htmlElement::htmlHidden(array("name" => "catAnd", "value" => $catAnd)).
							we_htmlElement::htmlHidden(array("name" => "thumbsFolders", "value" => $thumbsFolders)).
							we_htmlElement::htmlHidden(array("name" => "metaFolders", "value" => $metaFolders)).
							we_htmlElement::htmlHidden(array("name" => "metaFields", "value" => $metaFields)).
							we_htmlElement::htmlHidden(array("name" => "onlyEmpty", "value" => $onlyEmpty)).
							we_htmlElement::htmlHidden(array("name" => "folders", "value" => $folders)).
							we_htmlElement::htmlHidden(array("name" => "categories", "value" => $categories)).
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "rebuild")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "2")));
	}

	function getRebuildMetadata(){

		$thumbsFolders = isset($_REQUEST["thumbsFolders"]) ? $_REQUEST["thumbsFolders"] : "";
		$metaFolders = isset($_REQUEST["metaFolders"]) ? $_REQUEST["metaFolders"] : "";
		$onlyEmpty = isset($_REQUEST["onlyEmpty"]) ? $_REQUEST["onlyEmpty"] : 0;
		$metaFields = isset($_REQUEST["_field"]) ? $_REQUEST["_field"] : array();
		$thumbs = (isset($_REQUEST["thumbs"]) && is_array($_REQUEST["thumbs"])) ? makeCSVFromArray($_REQUEST["thumbs"],true) : "";
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "rebuild_documents";
		$categories = isset($_REQUEST["categories"]) ? $_REQUEST["categories"] : "";
		$doctypes = (isset($_REQUEST["doctypes"]) && is_array($_REQUEST["doctypes"])) ? makeCSVFromArray($_REQUEST["doctypes"],true) : "";
		$folders = isset($_REQUEST["folders"]) ? $_REQUEST["folders"] : "";
		$maintable = isset($_REQUEST["maintable"]) ? $_REQUEST["maintable"] : 0;
		$catAnd = isset($_REQUEST["catAnd"]) ? $_REQUEST["catAnd"] : 0;

		$ws = get_ws(FILE_TABLE,true);

		// check if folers are in Workspace of User

		if ($ws && $folders) {
			$newFolders = array();
			$wsArray = makeArrayFromCSV($ws);
			$foldersArray = makeArrayFromCSV($folders);
			for($i=0; $i< count($foldersArray); $i++) {
				if (in_workspace($foldersArray[$i],$ws)) {
					array_push($newFolders,$foldersArray[$i]);
				}
			}
			$folders = makeCSVFromArray($newFolders);
		}

		if($ws && strpos($ws,(",0,")) !== true && ($metaFolders=="" || $metaFolders == "0")){
			$metaFolders = get_def_ws(FILE_TABLE);
		}
		$parts = array();

		$content = we_rebuild_wizard::formMetadata($metaFields, $onlyEmpty).
						'<br>'.getPixel(2,15)."<br>".
						we_rebuild_wizard::formFolders($metaFolders,true,520);



		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $content,
			"space"		=> 0)
		);


		$dthidden = "";
		$doctypesArray = makeArrayFromCSV($doctypes);
		for($i=0; $i<sizeof($doctypesArray); $i++){
			$dthidden .= we_htmlElement::htmlHidden(array("name" => "doctypes[$i]", "value" => $doctypesArray[$i]));
		}
		$thumbsHidden = "";
		$thumbsArray = makeArrayFromCSV($thumbs);
		for($i=0; $i<sizeof($thumbsArray); $i++){
			$thumbsHidden .= we_htmlElement::htmlHidden(array("name" => "thumbs[$i]", "value" => $thumbsArray[$i]));
		}
		return array(we_rebuild_wizard::getPage2Js("metaFolders"),we_multiIconBox::getHTML("", "100%", $parts, 40, "", -1, "", "", false, $GLOBALS["l_rebuild"]["rebuild_metadata"]).
							$dthidden.
							$thumbsHidden.
							we_htmlElement::htmlHidden(array("name" => "catAnd", "value" => $catAnd)).
							we_htmlElement::htmlHidden(array("name" => "metaFolders", "value" => $metaFolders)).
							we_htmlElement::htmlHidden(array("name" => "thumbsFolders", "value" => $thumbsFolders)).
							we_htmlElement::htmlHidden(array("name" => "folders", "value" => $folders)).
							we_htmlElement::htmlHidden(array("name" => "categories", "value" => $categories)).
							we_htmlElement::htmlHidden(array("name" => "fr", "value" => "body")).
							we_htmlElement::htmlHidden(array("name" => "type", "value" => $type)).
							we_htmlElement::htmlHidden(array("name" => "we_cmd[0]", "value" => "rebuild")).
							we_htmlElement::htmlHidden(array("name" => "step", "value" => "2")));
	}


	/**
	* returns HTML for the frameset
	*
	* @return string
	*/
	function getFrameset(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");

		$tail = "";
		if(isset($_REQUEST["btype"])){
			$tail .= "&amp;btype=".rawurlencode($_REQUEST["btype"]);
		}
		if(isset($_REQUEST["type"])){
			$tail .= "&amp;type=".rawurlencode($_REQUEST["type"]);
		}
		if(isset($_REQUEST["templateID"])){
			$tail .= "&amp;templateID=".rawurlencode($_REQUEST["templateID"]);
		}
		if(isset($_REQUEST["step"])){
			$tail .= "&amp;step=".rawurlencode($_REQUEST["step"]);
		}
		if(isset($_REQUEST["responseText"])){
			$tail .= "&amp;responseText=".rawurlencode($_REQUEST["responseText"]);
		}



		$taskname = md5(session_id()."_rebuild");
		$taskFilename = FRAGMENT_LOCATION.$taskname;
		if(file_exists($taskFilename)){
			@unlink($taskFilename);
		}

		$cmdFrameHeight =   (isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0) ? 30 : 0;

		if($tail){
			$fst = new we_htmlFrameset(array(
				"rows" => "*,$cmdFrameHeight",
				"framespacing" => 0,
				"border" => 0,
				"frameborder" => "no")
			);

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=rebuild&amp;fr=busy&amp;dc=1", "name" => "wizbusy"));
			$fst->setFrameAttributes(0, array("scrolling" => "no","onload"=>"wizcmd.location='".WEBEDITION_DIR."we_cmd.php?we_cmd[0]=rebuild&amp;fr=body".$tail."';"));

			$fst->addFrame(array("src" => HTML_DIR."white.html", "name" => "wizcmd"));
			$fst->setFrameAttributes(1, array("scrolling" => "no"));

		}else{
			$fst = new we_htmlFrameset(array(
				"rows" => "*,40,$cmdFrameHeight",
				"framespacing" => 0,
				"border" => 0,
				"frameborder" => "no")
			);

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=rebuild&amp;fr=body", "name" => "wizbody"));
			$fst->setFrameAttributes(0, array("scrolling" => "auto"));

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=rebuild&amp;fr=busy", "name" => "wizbusy"));
			$fst->setFrameAttributes(1, array("scrolling" => "no"));

			$fst->addFrame(array("src" => WEBEDITION_DIR."we_cmd.php?we_cmd[0]=rebuild&amp;fr=cmd", "name" => "wizcmd"));
			$fst->setFrameAttributes(2, array("scrolling" => "no"));

		}


		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				we_htmlElement::jsElement("", array("src" => JS_DIR . "we_showMessage.js")) .
				we_htmlElement::htmlTitle($GLOBALS["l_rebuild"]["rebuild"])).$fst->getHtmlCode());


	}

	/**
	* returns Javascript for step 2 (1)
	*
	* @return string
	* @param string $folders csv value with directory IDs
	*/
	function getPage2Js($folders="folders"){
			$js = 	"\n".
				'function handle_event(what){'."\n".
				'	f = document.we_form;'."\n".
				'	switch(what){'."\n".
				'		case "previous":'."\n".
				'			f.step.value=0'."\n".
				'			f.target="wizbody";'."\n".
				'			break;'."\n".
				'		case "next":'."\n".
				'			if (typeof(document._errorMessage) != "undefined" && document._errorMessage !== ""){'."\n" .
				'				'.we_message_reporting::getShowMessageCall($GLOBALS["l_rebuild"]["noFieldsChecked"], WE_MESSAGE_ERROR)."\n" .
				'				return;'."\n" .
				'			} else {'."\n" .
				'				top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "disabled");'."\n" .
				'				top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "disabled");'."\n" .
				'				top.frames["wizbusy"].showRefreshButton();'."\n" .
				'				f.step.value=2'."\n".
				'				f.target="wizcmd";'."\n".
				'			}'."\n".
				'			break;'."\n".
				'	}'."\n".
				'	f.submit();'."\n".
				'}'."\n".


				'function we_cmd() {'."\n".
				'	f = document.we_form;'."\n".
				'	var args = "";'."\n".
				'	var url = "' . WEBEDITION_DIR . 'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}'."\n".
				'	switch (arguments[0]) {'."\n".
				'	case "openDirselector":'."\n".
				'		new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,true,true,true);'."\n".
				'		break;'."\n".
				'	case "openCatselector":'."\n".
				'		new jsWindow(url,"we_catselector",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);'."\n".
				'		break;'."\n".
				'	case "add_cat":'."\n".
				'		var catsToAdd = makeArrayFromCSV(arguments[1]);'."\n".
				'		var cats = makeArrayFromCSV(f.categories.value);'."\n".
				'		for(var i=0;i<catsToAdd.length;i++){'."\n".
				'			if(!inArray(catsToAdd[i],cats)){'."\n".
				'				cats.push(catsToAdd[i]);'."\n".
				'			};'."\n".
				'		};'."\n".
				'		f.categories.value = makeCSVFromArray(cats);'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "del_cat":'."\n".
				'		var catToDel = arguments[1];'."\n".
				'		var cats = makeArrayFromCSV(f.categories.value);'."\n".
				'		var newcats = new Array();'."\n".
				'		for(var i=0;i<cats.length;i++){'."\n".
				'			if(cats[i] != catToDel){'."\n".
				'				newcats.push(cats[i]);'."\n".
				'			};'."\n".
				'		};'."\n".
				'		f.categories.value = makeCSVFromArray(newcats);'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "del_all_cats":'."\n".
				'		f.categories.value = "";'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "add_folder":'."\n".
				'		var foldersToAdd = makeArrayFromCSV(arguments[1]);'."\n".
				'		var folders = makeArrayFromCSV(f.'.$folders.'.value);'."\n".
				'		for(var i=0;i<foldersToAdd.length;i++){'."\n".
				'			if(!inArray(foldersToAdd[i],folders)){'."\n".
				'				folders.push(foldersToAdd[i]);'."\n".
				'			};'."\n".
				'		};'."\n".
				'		f.'.$folders.'.value = makeCSVFromArray(folders);'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "del_folder":'."\n".
				'		var folderToDel = arguments[1];'."\n".
				'		var folders = makeArrayFromCSV(f.'.$folders.'.value);'."\n".
				'		var newfolders = new Array();'."\n".
				'		for(var i=0;i<folders.length;i++){'."\n".
				'			if(folders[i] != folderToDel){'."\n".
				'				newfolders.push(folders[i]);'."\n".
				'			};'."\n".
				'		};'."\n".
				'		f.'.$folders.'.value = makeCSVFromArray(newfolders);'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "del_all_folders":'."\n".
				'		f.'.$folders.'.value = "";'."\n".
				'		f.step.value=1;'."\n".
				'		f.submit();'."\n".
				'		break;'."\n".
				'	case "deselect_all_fields":'."\n".
				'		var _elem = document.we_form.elements;'."\n".
				'		var _elemLength = _elem.length;'."\n".
				'		for (var i=0; i<_elemLength; i++) {'."\n".
				'			if (_elem[i].name.substring(0,7) == "_field[") {'."\n".
				'				_elem[i].checked = false;'."\n".
				'			}'."\n".
				'		}'."\n".
				'		document._errorMessage = "'.addslashes($GLOBALS["l_rebuild"]["noFieldsChecked"]).'";'."\n".
				'		break;'."\n".
				'	case "select_all_fields":'."\n".
				'		var _elem = document.we_form.elements;'."\n".
				'		var _elemLength = _elem.length;'."\n".
				'		for (var i=0; i<_elemLength; i++) {'."\n".
				'			if (_elem[i].name.substring(0,7) == "_field[") {'."\n".
				'				_elem[i].checked = true;'."\n".
				'			}'."\n".
				'		}'."\n".
				'		document._errorMessage = "";'."\n".
				'		break;'."\n".
				'	default:'."\n".
				'		for(var i = 0; i < arguments.length; i++) {'."\n".
				'			args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");'."\n".
				'		}'."\n".
				'		eval("opener.top.we_cmd("+args+")");'."\n".
				'	}'."\n".
				'}'."\n".


				'function checkForError() {'."\n".
				'	var _elem = document.we_form.elements;'."\n".
				'	var _elemLength = _elem.length;'."\n".
				'	var _fieldsChecked = false;'."\n".
				'	for (var i=0; i<_elemLength; i++) {'."\n".
				'		if (_elem[i].name.substring(0,7) == "_field[") {'."\n".
				'			if(_elem[i].checked){'."\n".
				'				_fieldsChecked=true;break;'."\n".
				'			}'."\n".
				'		}'."\n".
				'	}'."\n".
				'	if (_fieldsChecked === false) {'."\n".
				'		document._errorMessage = "'.addslashes($GLOBALS["l_rebuild"]["noFieldsChecked"]).'";'."\n".
				'	} else {'."\n".
				'		document._errorMessage = "";'."\n".
				'	}'."\n".
				'}'."\n".


				'function makeArrayFromCSV(csv) {'."\n".
				'	if(csv.length && csv.substring(0,1)==","){csv=csv.substring(1,csv.length);}'."\n".
				'	if(csv.length && csv.substring(csv.length-1,csv.length)==","){csv=csv.substring(0,csv.length-1);}'."\n".
				'	if(csv.length==0){return new Array();}else{return csv.split(/,/);};'."\n".
				'}'."\n".

				'function inArray(needle,haystack){'."\n".
				'	for(var i=0;i<haystack.length;i++){'."\n".
				'		if(haystack[i] == needle){return true;}'."\n".
				'	}'."\n".
				'	return false;'."\n".
				'}'."\n".

				'function makeCSVFromArray(arr) {'."\n".
				'	if(arr.length == 0){return "";};'."\n".
				'	return ","+arr.join(",")+",";'."\n".
				'}'."\n".


				'function set_button_state() {'."\n" .
				'	if(top.frames["wizbusy"] && top.frames["wizbusy"].switch_button_state){'."\n" .
				'		top.frames["wizbusy"].back_enabled = top.frames["wizbusy"].switch_button_state("back", "back_enabled", "enabled");'."\n" .
				'		top.frames["wizbusy"].next_enabled = top.frames["wizbusy"].switch_button_state("next", "next_enabled", "enabled");'."\n" .
				'	}else{'."\n" .
				'		setTimeout("set_button_state()",300);'."\n" .
				'	}'."\n" .
				'}'."\n".
				'set_button_state();'."\n";
		return $js;
	}

	/**
	* returns Javascript for step 2 (1)
	*
	* @return string
	* @param array first element (array[0]) must be a javascript, second element (array[1]) must be the Body HTML
	*/
	function getPage($contents){
		if(!sizeof($contents)){
			return "";
		}
		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET . "\n" . '<script src="'.JS_DIR.'windows.js" language="JavaScript" type="text/javascript"></script>'."\n".
								($contents[0] ?
								we_htmlElement::jsElement("<!--\n".$contents[0]."\n//-->") :
								"")).
			we_htmlElement::htmlBody(array(
				"class"=>"weDialogBody"

				),
				we_htmlElement::htmlForm(array("name" => "we_form", "method" => "post", "action" => WEBEDITION_DIR . "we_cmd.php"),$contents[1])
			)
		);

	}
}

?>