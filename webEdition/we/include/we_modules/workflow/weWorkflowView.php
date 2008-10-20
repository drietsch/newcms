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


/* the parent class of storagable webEdition classes */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflow.php");
include_once(WE_WORKFLOW_MODULE_DIR."weWorkflowDocument.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");

class weWorkflowView extends weWorkflowBase{

	// workflow array; format workflow[workflowID]=workflow_name
	var $workflows=array();
	//default workflow
	var $workflowDef;
	//default document
	var $documentDef;

	//what is current display 0-workflow(default);1-document;
	var $show=0;

	//wat page is currentlly displed 0-properties(default);1-overview;
	var $page=0;

	var $hiddens=array();

	function weWorkflowView(){
		weWorkflowBase::weWorkflowBase();
		$this->workflowDef=new weWorkflow();
		$this->documentDef=new weWorkflowDocument();
        	$this->hiddens[]="ID";
		$this->hiddens[]="Type";
		$this->hiddens[]="Status";
		$this->hiddens[]="Folders";
		$this->hiddens[]="Categories";
		$this->hiddens[]="ObjCategories";
        	$this->hiddens[]="DocType";
		$this->hiddens[]="Objects";
		$this->show=0;
		$this->page=0;
	}

	function getHiddens(){
		$out=$this->htmlHidden("home","0");
		$out.=$this->htmlHidden("wcmd","new_workflow");
		$out.=$this->htmlHidden("wid",$this->workflowDef->ID);
		$out.=$this->htmlHidden("pnt","edit");
		$out.=$this->htmlHidden("wname",$this->uid);
		$out.=$this->htmlHidden("page",$this->page);
		return $out;
	}


	function getHiddensFormPropertyPage(){
		$out="";
		$out.=$this->htmlHidden($this->uid."_Text",$this->workflowDef->Text);
		$out.=$this->htmlHidden($this->uid."_Type",$this->workflowDef->Type);
		$out.=$this->htmlHidden($this->uid."_FolderPath",$this->workflowDef->FolderPath);
		$out.=$this->htmlHidden($this->uid."_Folders",$this->workflowDef->Folders);
		$out.=$this->htmlHidden($this->uid."_DocType",$this->workflowDef->DocType);
		$out.=$this->htmlHidden($this->uid."_Categories",$this->workflowDef->Categories);
		$out.=$this->htmlHidden($this->uid."_ObjCategories",$this->workflowDef->ObjCategories);
		$out.=$this->htmlHidden($this->uid."_Objects",$this->workflowDef->Objects);

		return $out;
	}

	function getHiddensFormOverviewPage(){
		$out="";
		$out.=$this->htmlHidden("wcat","0");
		$out.=$this->htmlHidden("wocat","0");
		$out.=$this->htmlHidden("wfolder","0");
		$out.=$this->htmlHidden("wobject","0");

        	$counter=0;
		$counter1=0;
		foreach($this->workflowDef->steps as $sk=>$sv){
			$out.=$this->htmlHidden($this->uid."_step".$counter."_sid",$sv->ID);
			$out.=$this->htmlHidden($this->uid."_step".$counter."_and",$sv->stepCondition);
			$out.=$this->htmlHidden($this->uid."_step".$counter."_Worktime",$sv->Worktime);
			$out.=$this->htmlHidden($this->uid."_step".$counter."_timeAction",$sv->timeAction);
			$counter1=0;
			foreach($sv->tasks as $tk=>$tv){
				$out.=$this->htmlHidden($this->uid."_task".$counter.$counter1."_tid",$tv->ID);
				$out.=$this->htmlHidden($this->uid."_task_".$counter."_".$counter1."_userid",$tv->userID);
				$out.=$this->htmlHidden($this->uid."_task_".$counter."_".$counter1."_Edit",($tv->Edit ? 1 : 0));
				$out.=$this->htmlHidden($this->uid."_task_".$counter."_".$counter1."_Mail",($tv->Mail ? 1 : 0));
				$counter1++;
			}

			$counter++;
		}
		$out.=$this->htmlHidden("wsteps",$counter);
		$out.=$this->htmlHidden("wtasks",$counter1);

		return $out;
	}


	function workflowHiddens(){
		$out="";
		foreach($this->hiddens as $key=>$val){
			$attval="";
			if(in_array($val,$this->workflowDef->persistents)) eval('$attval=$this->workflowDef->'.$val.';');
			else eval('$attval=$this->'.$val.';');
			$out.=$this->htmlHidden($this->uid."_".$val,$attval);
		}
		return $out;
	}

	function getProperties(){
		if(isset($_REQUEST["home"]) && $_REQUEST["home"]){
			$GLOBALS["we_print_not_htmltop"] = true;
			$GLOBALS["we_head_insert"] = $this->getPropertyJS();
			$GLOBALS["we_body_insert"] = '<form name="we_form">'."\n";
			$GLOBALS["we_body_insert"] .= $this->getHiddens().'</form>'."\n";
			$GLOBALS["mod"] = "workflow";
			ob_start();
			include($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/home.inc.php");
            $out = ob_get_contents();
            ob_end_clean();
		}else{
			$out=$this->getPropertyJS().'</head><body class="weEditorBody" onload="loaded=1;" onunload="doUnload()"><form name="we_form" onsubmit="return false">'."\r\n";
			$out.=$this->getHiddens();
			if($this->show){
				$out.=$this->getDocumentInfo();
			}
			else{
				$out.=$this->workflowHiddens();
				$parts = array();

				if($this->page==0){

					$_space = 143;

					$out .= $this->getHiddensFormOverviewPage();

					array_push($parts, $this->getWorkflowHeaderMultiboxParts($_space));
					$_type = $this->getWorkflowTypeHTML();
					array_push($parts, array(	"headline" => $GLOBALS["l_workflow"]["type"],
												"space"    => $_space-25,
												"html"     => $_type));
					//	Workflow-Type
					$out .= we_multiIconBox::getHTML("workflowProperties", "100%", $parts,30);
				}
				else{
					$out .= $this->getHiddensFormPropertyPage();
					$out .= htmlDialogLayout($this->getStepsHTML(),"");
				}
			}
			$out.="\r\n</form>\r\n";
			$out.='</body></html>';
		}
		return $out;

	}

	/**
	* @return array		can be used by class we_multibox.inc.php as $content-array
	* @desc Enter description here...
 	*/
	function getWorkflowHeaderMultiboxParts($space){

		return array(	"headline" => $GLOBALS["l_workflow"]["name"],
						"html"     => htmlTextInput($this->uid."_Text",37,$this->workflowDef->Text,"",' id="yuiAcInputPathName" onchange="top.content.setHot();" onblur="parent.edheader.setPathName(this.value); parent.edheader.setTitlePath()"',"text",498),
						"space"    => $space
					);
	}

	function getWorkflowSelectHTML(){
		$vals = array();
        	$vals=$this->workflowDef->getAllWorkflowsInfo();
		return htmlSelect("wid",$vals,4,$this->workflowDef->ID,false,"onclick='we_cmd(\"edit_workflow\")'","value",200);
	}

	function getWorkflowTypeHTML(){
		global $l_workflow;
		$out="";

		$vals   = array();
		$vals[] = getPixel(2,10);
		$vals[] = $this->getFoldersHTML();
		$out   .= $this->getTypeTableHTML(we_forms::radiobutton(WE_WORKFLOW_FOLDER, ($this->workflowDef->Type==WE_WORKFLOW_FOLDER ? "1" : "0"), $this->uid."_Type", $l_workflow["type_dir"],true,"defaultfont",'onclick=top.content.setHot();'),
											$vals,25);
		$vals   = array();
		$vals[] = getPixel(2,10);
		$vals[] = $this->getDocTypeHTML();
		$vals[] = getPixel(2,10);
		$vals[] = $this->getCategoryHTML();
		$out   .= $this->getTypeTableHTML(we_forms::radiobutton(WE_WORKFLOW_DOCTYPE_CATEGORY, ($this->workflowDef->Type==WE_WORKFLOW_DOCTYPE_CATEGORY ? "1" : "0"), $this->uid."_Type", $l_workflow["type_doctype"],true,"defaultfont",'onclick=top.content.setHot();'),
											$vals,25);

		if(defined("OBJECT_TABLE")){
			$vals   = array();
			$vals[] = getPixel(2,10);
			$vals[] = $this->getObjectHTML();
			$vals[] = getPixel(2,10);
			$vals[] = $this->getObjCategoryHTML();
			$out   .= $this->getTypeTableHTML(	we_forms::radiobutton(WE_WORKFLOW_OBJECT, ($this->workflowDef->Type==WE_WORKFLOW_OBJECT ? "1" : "0"), $this->uid."_Type", $l_workflow["type_object"],true,"defaultfont",'onclick=top.content.setHot();'),
											$vals,25);
		}

		return $out;
	}

	function getFoldersHTML(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_workflow;

		$we_button = new we_button();

		$delallbut="";
		$addbut="";


		$delallbut = $we_button->create_button("delete_all", "javascript:top.content.setHot();we_cmd('del_all_folders');");
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openDirselector','','".FILE_TABLE."','','','fillIDs();opener.we_cmd(\\'add_folder\\',top.allIDs);','','','',true)");


		$dirs = new MultiDirChooser(495,$this->workflowDef->Folders,"del_folder",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",FILE_TABLE,"defaultfont","","top.content.setHot();");

		return htmlFormElementTable($dirs->get(),$l_workflow["dirs"]);

	}

	function getCategoryHTML(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_workflow;

		$we_button = new we_button();

		$delallbut="";
		$addbut="";


		$delallbut = $we_button->create_button("delete_all", "javascript:top.content.setHot();we_cmd('del_all_cats')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openCatselector','','".CATEGORY_TABLE."','','','fillIDs();opener.we_cmd(\\'add_cat\\',top.allIDs);')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));

		$cats = new MultiDirChooser(495,$this->workflowDef->Categories,"del_cat", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CATEGORY_TABLE,"defaultfont","","top.content.setHot();");

		return htmlFormElementTable($cats->get(),$l_workflow["categories"]);

	}

	function getObjCategoryHTML(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_workflow;

		$we_button = new we_button();

		$delallbut="";
		$addbut="";


		$delallbut = $we_button->create_button("delete_all", "javascript:top.content.setHot();we_cmd('del_all_objcats')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openCatselector','','".CATEGORY_TABLE."','','','fillIDs();opener.we_cmd(\\'add_objcat\\',top.allIDs);')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));

		$cats = new MultiDirChooser(495,$this->workflowDef->ObjCategories,"del_objcat", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CATEGORY_TABLE,"defaultfont","","top.content.setHot();");

		return htmlFormElementTable($cats->get(),$l_workflow["categories"]);

	}

	function getObjectHTML(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_workflow;

		$we_button = new we_button();

		$delallbut="";
		$addbut="";


		$delallbut = $we_button->create_button("delete_all", "javascript:top.content.setHot();we_cmd('del_all_objects')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));
		$addbut    = $we_button->create_button("add", "javascript:top.content.setHot();we_cmd('openObjselector','','".OBJECT_TABLE."','','','opener.we_cmd(\\'add_object\\',top.currentID);')", false, 100, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));

		$cats = new MultiDirChooser(495,$this->workflowDef->Objects,"del_object", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",OBJECT_TABLE,"defaultfont","","top.content.setHot();");

		return htmlFormElementTable($cats->get(),$l_workflow["classes"]);

	}

	function getStatusHTML(){
		global $l_workflow;
		$out = we_forms::checkboxWithHidden("1", "status_workflow", $l_workflow["active"],false,"defaultfont","top.content.setHot();");
		return $out;
	}

	function getStepsHTML(){
		global $l_workflow, $BROWSER;

		$we_button = new we_button();

		$headline=array();
		$content=array();

		$ids="";

		$headline[0]["dat"]='<div class="middlefont">'.$l_workflow["step"].'</div>';
		$headline[1]["dat"]='<div class="middlefont">'.$l_workflow["and_or"].'</div>';
		$headline[2]["dat"]='<div class="middlefont">'.$l_workflow["worktime"].'</div>';

		$counter=0;
		$counter1=0;
		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');
		$yuiSuggest =& weSuggest::getInstance();

		/***** BROWSER DEPENDENCIES *****/
		switch ($BROWSER){
			case "IE" :
				$_spacer_1_height = 13;
				$_spacer_2_height = 5;
				break;
			default:
				$_spacer_1_height = 7;
				$_spacer_2_height = 5;
		}
		
		/***** WORKFLOWSTEPS *****/
		foreach($this->workflowDef->steps as $sk=>$sv){
			$ids.=$this->htmlHidden($this->uid."_step".$counter."_sid",$sv->ID);
			$content[$counter][0]["dat"]=$counter+1;
			$content[$counter][0]["height"]="";
			$content[$counter][0]["align"]="center";


			$content[$counter][1]["dat"]='<table><tr valign="top"><td>'.we_forms::radiobutton("1",$sv->stepCondition ? 1 : 0,$this->uid."_step".$counter."_and","",false,"defaultfont","top.content.setHot();").'</td><td>'.getPixel(5,5).'</td><td>'.we_forms::radiobutton("0",$sv->stepCondition ? 0 : 1,$this->uid."_step".$counter."_and","",false,"defaultfont","top.content.setHot();").'</td></tr></table>';
			$content[$counter][1]["height"]="";
			$content[$counter][1]["align"]="";

			$content[$counter][2]["dat"]='<table cellpadding="0" cellspacing="0"><tr><td>'.getPixel(5,7).'</td></tr><tr valign="middle"><td class="middlefont">'.htmlTextInput($this->uid."_step".$counter."_Worktime","15",$sv->Worktime,"",'onChange="top.content.setHot();"').'</td></tr>';
			$content[$counter][2]["dat"].='<tr valign="middle"><td>'.getPixel(5,$_spacer_1_height).'</td><tr>';
			$content[$counter][2]["dat"].='<tr valign="top">';
			$content[$counter][2]["dat"].='<td class="middlefont">'.we_forms::checkboxWithHidden($sv->timeAction==1,$this->uid."_step".$counter."_timeAction",$l_workflow["go_next"],false,"middlefont","top.content.setHot();").'</td>';
			$content[$counter][2]["dat"].='</tr></table>';


			$content[$counter][2]["height"]="";
			$content[$counter][2]["align"]="";


			$counter1=0;
			foreach($sv->tasks as $tk=>$tv){
				$ids.=$this->htmlHidden($this->uid."_task".$counter."_".$counter1."_tid",$tv->ID);
				$headline[$counter1+3]["dat"]=$l_workflow["user"].(string )($counter1+1);

				$foo=f("SELECT Path FROM ".USER_TABLE." WHERE ID=".abs($tv->userID),"Path",$this->db);
				
				$button = $we_button->create_button("select", "javascript:top.content.setHot();we_cmd('browse_users','document.we_form.".$this->uid."_task_".$counter."_".$counter1."_userid.value','document.we_form.".$this->uid."_task_".$counter."_".$counter1."_usertext.value','*',document.we_form.".$this->uid."_task_".$counter."_".$counter1."_userid.value);");
				
				$yuiSuggest->setAcId("User_".$counter."_".$counter1);
				$yuiSuggest->setContentType("0,1");
				$yuiSuggest->setInput($this->uid."_task_".$counter."_".$counter1."_usertext",$foo,array("onChange"=>"top.content.setHot();"));
				$yuiSuggest->setMaxResults(10);
				$yuiSuggest->setMayBeEmpty(false);
				$yuiSuggest->setResult($this->uid."_task_".$counter."_".$counter1."_userid",$tv->userID);
				$yuiSuggest->setSelector("Docselector");
				$yuiSuggest->setTable(USER_TABLE);
				$yuiSuggest->setWidth(200);
				$yuiSuggest->setContainerWidth(305);
				$yuiSuggest->setSelectButton($button,6);
		
				$out="";
				$out.='<table cellpadding="0" cellspacing="0">';
				$out.='<tr valign="middle"><td colspan="4">'.getPixel(5,$_spacer_2_height).'</td><tr>';
				$out.='<tr valign="middle"><td>'.$yuiSuggest->getHTML().'</td>';

				$out.='</tr></table>';

				$out.='<table cellpadding="0" cellspacing="0">';
				$out.='<tr valign="middle"><td colspan="3">'.getPixel(5,0).'</td><tr>';
				$out.='<tr valign="top">';

				$out.='<td class="middlefont" align="right">'.we_forms::checkboxWithHidden($tv->Mail,$this->uid."_task_".$counter."_".$counter1."_Mail",$l_workflow["send_mail"],false,"middlefont","top.content.setHot();").'</td>';
				$out.='<td>'.getPixel(20,1).'</td>';
				$out.='<td class="middlefont">'.we_forms::checkboxWithHidden($tv->Edit,$this->uid."_task_".$counter."_".$counter1."_Edit",$l_workflow["edit"],false,"middlefont","top.content.setHot();").'</td>';


				$out.='</tr></table>';
				$content[$counter][$counter1+3]["dat"]=$out;
				$content[$counter][$counter1+3]["height"]="";
				$content[$counter][$counter1+3]["align"]="";
				$counter1++;
			}

			$counter++;
		}
		$out  = we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/yahoo-min.js")); 
		$out .= we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/dom-min.js")); 
		$out .= we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/event-min.js")); 
		$out .= we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/connection-min.js")); 
		$out .= we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/animation-min.js")); 
		$out .= we_htmlElement::jsElement("",array("src"=>JS_DIR."libs/yui/autocomplete-min.js")); 
		$out .= $yuiSuggest->getYuiFiles();

		$out .='	<table style="margin-right:30px;">
				<tr valign="top">
					<td>'.htmlDialogBorder3(400,300,$content,$headline).'</td>
					<td><table cellpadding="0" cellspacing="0">
						<tr><td>'.getPixel(5,3).'</td></tr>
						<tr><td>' . $we_button->create_button_table(	array($we_button->create_button("image:btn_function_plus", "javascript:top.content.setHot();addTask()",true,30), $we_button->create_button("image:btn_function_trash", "javascript:top.content.setHot();delTask()",true,30))) . '</td>
						</tr>
						</table></td>
				</tr>
				<tr valign="top">
					<td colspan="2" nowrap>' . $we_button->create_button_table( array( $we_button->create_button("image:btn_function_plus", "javascript:top.content.setHot();addStep()",true,30), $we_button->create_button("image:btn_function_trash", "javascript:top.content.setHot();delStep()",true,30))) .'</td></tr>
				</table>';
		$out .= $yuiSuggest->getYuiCode();
		$out .=$this->htmlHidden("wsteps",$counter);
		$out .=$this->htmlHidden("wtasks",$counter1);
		return $ids.$out;

	}

	function getTypeTableHTML($head,$values,$ident=0,$textalign="left",$textclass="defaultfont"){
		$out='<table cellpadding="0" cellspacing="0" border="0">'.($head ? '<tr><td class="'.trim($textclass).'" align="'.trim($textalign).'" colspan="2">'.$head.'</td></tr>' : '');
		foreach($values as $key=>$val){
			$out.='<tr><td>'.getPixel($ident,5).'</td><td class="'.trim($textclass).'">'.$val.'</td></tr>';
		}
		$out.='</table>';
		return $out;
	}

	function getBoxHTML($w,$h,$content,$headline="",$width=120){
		$out="";
		$headline = ereg_replace(" ","&nbsp;",$headline);
		if($headline){
			$out='<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="24" height="15"></td>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="'.$width.'" height="15"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td valign="top" class="defaultgray">'.$headline.'</td>
				<td>'.$content.'</td>
			</tr>
			<tr>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="24" height="15"></td>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="'.$width.'" height="15"></td>
				<td></td>
			</tr></table>';
		}else{
			$out='<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="24" height="15"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>'.$content.'</td>
			</tr>
			<tr>
				<td><img src="'.IMAGE_DIR.'pixel.gif" width="24" height="15"></td>
				<td></td>
			</tr></table>';
		}
		return $out;
	}

    function getDocTypeHTML($width=498){
		global $l_workflow;

		$pop="";

		$vals = array();
		$q=getDoctypeQuery($this->db);
		$this->db->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
 		while($this->db->next_record()){
			$v = $this->db->f("ID");
			$t = $this->db->f("DocType");
			$vals[$v]=$t;
		}
		$pop = htmlSelect($this->uid."_DocType",$vals,1,$this->workflowDef->DocType,false,'onChange="top.content.setHot();"',"value",$width,"defaultfont");

        return htmlFormElementTable($pop,$l_workflow["doctype"]);
	}

	function htmlHidden($name,$value=""){
		return '<input type="hidden" name="'.trim($name).'" value="'.htmlspecialchars($value).'">';
	}

	/* creates the DirectoryChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formDirChooser($width="",$rootDirID=0,$table=FILE_TABLE,$Pathname="ParentPath",$Pathvalue="",$IDName="ParentID",$IDValue="",$cmd=""){
		$table = FILE_TABLE;

		$we_button = new we_button();

		$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector',document.we_form.elements['$IDName'].value,'$table','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','".session_id()."','$rootDirID')");
		return htmlFormElementTable(htmlTextInput($Pathname,30,$Pathvalue,"",'onChange="top.content.setHot();" readonly',"text",$width,0),
			"",
			"left",
			"defaultfont",
			$this->htmlHidden($IDName,$IDValue),
			getPixel(20,4),
			$button);
	}

	function getJSTopCode(){
		global $l_workflow;
	
		$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : '';
		$title = '';
		foreach($GLOBALS["_we_available_modules"] as $modData){
			if($modData["name"] == $mod){
				$title	= "webEdition " . $GLOBALS["l_global"]["modules"] . ' - ' .$modData["text"];
				break;
			}
		}
		?>
		<script language="JavaScript" type="text/javascript">

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			parent.document.title = "<?php print $title; ?>";

			function we_cmd(){
				var args = "";
				var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				if(hot == "1") {
					if(confirm("<?php print $l_workflow["save_changed_workflow"]?>")) {
						arguments[0] = "save_workflow";
					} else {
						top.content.usetHot();
					}
				}
				switch (arguments[0]){
			        case "exit_workflow":
						if(hot != "1") {
							eval('top.opener.top.we_cmd(\'exit_modules\')');
						}
				        break;
					case "new_workflow":
						top.content.resize.right.editor.edbody.document.we_form.wcmd.value=arguments[0];
						top.content.resize.right.editor.edbody.document.we_form.wid.value=arguments[1];
						top.content.resize.right.editor.edbody.submitForm();
					break;
					case "delete_workflow":
						<?php if(!we_hasPerm("DELETE_WORKFLOW")):
							print we_message_reporting::getShowMessageCall($l_workflow["no_perms"], WE_MESSAGE_ERROR);
						else:?>
						if(top.content.resize.right.editor.edbody.loaded){
							if(!confirm("<?php print $l_workflow["delete_question"]?>")) return;
						}
						else { <?php print we_message_reporting::getShowMessageCall($l_workflow["nothing_to_delete"], WE_MESSAGE_ERROR); ?> }

						top.content.resize.right.editor.edbody.document.we_form.wcmd.value=arguments[0];
						top.content.resize.right.editor.edbody.submitForm();
						<?php endif?>
					break;
					case "save_workflow":
						<?php if(!we_hasPerm("EDIT_WORKFLOW") && !we_hasPerm("NEW_WORKFLOW")):
							print we_message_reporting::getShowMessageCall($l_workflow["no_perms"], WE_MESSAGE_ERROR);
						else:?>
						if(top.content.resize.right.editor.edbody.loaded){
							top.content.resize.right.editor.edbody.setStatus(top.content.resize.right.editor.edfooter.document.we_form.status_workflow.value);
							chk=top.content.resize.right.editor.edbody.checkData();
							if(!chk) return;
							num=top.content.resize.right.editor.edbody.getNumOfDocs();
							if(num>0) if(!confirm("<?php print $l_workflow["save_question"]?>")) return;
						}
						else { <?php print we_message_reporting::getShowMessageCall($l_workflow["nothing_to_save"], WE_MESSAGE_ERROR); ?> }
						top.content.resize.right.editor.edbody.document.we_form.wcmd.value=arguments[0];
						top.content.resize.right.editor.edbody.submitForm();
						top.content.usetHot();
						<?php endif?>
					break;
					case "edit_workflow":
					case "show_document":
						top.content.resize.right.editor.edbody.document.we_form.wcmd.value=arguments[0];
						top.content.resize.right.editor.edbody.document.we_form.wid.value=arguments[1];
						top.content.resize.right.editor.edbody.submitForm();
					break;
					case "empty_log":
						new jsWindow("<?php print WE_WORKFLOW_MODULE_PATH ?>edit_workflow_frameset.php?pnt=qlog","log_question",-1,-1,360,230,true,false,true);
					break;
        				default:
        					for(var i = 0; i < arguments.length; i++){
							args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
						}
						eval('top.opener.top.we_cmd('+args+')');
				}
			}
	</script>
	<?php
	}

	function getCmdJS(){
	?>
		<script language="JavaScript" type="text/javascript">
				function submitForm(){
					var f = self.document.we_form;
					f.target = "cmd";
					f.method = "post";
					f.submit();
			}
		</script>
	<?php
	}

	function getPropertyJS(){
		global $l_workflow;
	?>
		<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR; ?>windows.js"></script>
		<script language="JavaScript" type="text/javascript">
			var loaded;

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}

			function we_cmd(){
				var args = "";
				var url = "<?php print WEBEDITION_DIR; ?>we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]){
					case "browse_users":
						new jsWindow(url,"browse_users",-1,-1,500,300,true,false,true);
        				break;
					case "openDirselector":
						new jsWindow(url,"we_fileselector",-1,-1,<?php echo WINDOW_DIRSELECTOR_WIDTH . ',' . WINDOW_DIRSELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openCatselector":
						new jsWindow(url,"we_catselector",-1,-1,<?php echo WINDOW_CATSELECTOR_WIDTH . ',' . WINDOW_CATSELECTOR_HEIGHT; ?>,true,true,true,true);
						break;
					case "openObjselector":
						url = "/webEdition/we_cmd.php?we_cmd[0]=openDocselector&we_cmd[8]=object&we_cmd[1]=&we_cmd[2]=<?php print (defined("OBJECT_TABLE") ? OBJECT_TABLE :""); ?>&we_cmd[5]="+arguments[5]+"&we_cmd[9]=1";
						new jsWindow(url,"we_objectselector",-1,-1,650,400,true,true,true);
						break;
					case "add_cat":
					case "del_cat":
					case "del_all_cats":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.wcat.value=arguments[1];
						submitForm();
						break;
					case "add_objcat":
					case "del_objcat":
					case "del_all_objcats":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.wocat.value=arguments[1];
						submitForm();
						break;
					case "add_folder":
					case "del_folder":
					case "del_all_folders":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.wfolder.value=arguments[1];
						submitForm();
						break;
					case "add_object":
					case "del_object":
					case "del_all_objects":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.wobject.value=arguments[1];
						submitForm();
						break;
					case "switchPage":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.page.value=arguments[1];
						submitForm();
						break;
        			default:
        				for(var i = 0; i < arguments.length; i++){
							args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
						}
						eval('top.content.we_cmd('+args+')');
				}
			}


			function submitForm(){
					var f = self.document.we_form;
					f.target = "edbody";
					f.method = "post";
					f.submit();
			}
		<?php if(!$this->show):?>


			function clickCheck(a){
				if(a.checked) a.value=1;
				else a.value=0;
			}

			function addStep(){
				document.we_form.wsteps.value++;
				document.we_form.wcmd.value="reload_table";
				submitForm();

			}

			function addTask(){
				document.we_form.wtasks.value++;
				document.we_form.wcmd.value="reload_table";
				submitForm();

			}

			function delStep(){
				if(document.we_form.wsteps.value>1){
					document.we_form.wsteps.value--;
					document.we_form.wcmd.value="reload_table";
					submitForm();
				}
				else{
					<?php print we_message_reporting::getShowMessageCall($l_workflow["del_last_step"], WE_MESSAGE_ERROR); ?>
				}
			}

			function setStatus(val){
				document.we_form.<?php print $this->uid;?>_Status.value=val;

			}

			function getStatusContol(){
				return document.we_form.<?php print $this->uid;?>_Status.value;
			}

			function delTask(){
				if(document.we_form.wtasks.value>1){
					document.we_form.wtasks.value--;
					document.we_form.wcmd.value="reload_table";
					submitForm();
				}
				else{
					<?php print we_message_reporting::getShowMessageCall($l_workflow["del_last_task"], WE_MESSAGE_ERROR); ?>
				}
			}

			function getNumOfDocs(){
				return <?php $this->workflowDef->loadDocuments(); print count($this->workflowDef->documents)?>;
			}

			function sprintf(){
				if (!arguments || arguments.length < 1) return;

				var argum = arguments[0];
				var regex = /([^%]*)%(%|d|s)(.*)/;
				var arr = new Array();
				var iterator = 0;
				var matches = 0;

				while (arr=regex.exec(argum)){
                var left = arr[1];
                var type = arr[2];
                var right = arr[3];

                matches++;
                iterator++;

                var replace = arguments[iterator];

                if (type=='d') replace = parseInt(param) ? parseInt(param) : 0;
                else if (type=='s') replace = arguments[iterator];
                        argum = left + replace + right;
				}
				return argum;
			}


			function checkData(){
				var nsteps=document.we_form.wsteps;
				var ntasks=document.we_form.wtasks;
				ret=false;
				if(document.we_form.<?php print $this->uid?>_Text.value=="") ret=true;
				if(ret){
					<?php print we_message_reporting::getShowMessageCall($l_workflow["name_empty"], WE_MESSAGE_ERROR); ?>
					return false;
				}

				ret=false;
				if(document.we_form.<?php print $this->uid?>_Folders.value=="" && document.we_form.<?php print $this->uid?>_Type.value==1) ret=true;
				if(ret){
					<?php print we_message_reporting::getShowMessageCall($l_workflow["folders_empty"], WE_MESSAGE_ERROR); ?>
					return false;
				}

				ret=false;
				if((document.we_form.<?php print $this->uid?>_DocType.value==0 && document.we_form.<?php print $this->uid?>_Categories.value=="") && document.we_form.<?php print $this->uid?>_Type.value==0) ret=true;
				if(ret){
					<?php print we_message_reporting::getShowMessageCall($l_workflow["doctype_empty"], WE_MESSAGE_ERROR); ?>
					return false;
				}

				ret=false;
				if(document.we_form.<?php print $this->uid?>_Objects.value=="" && document.we_form.<?php print $this->uid?>_Type.value==2) ret=true;
				if(ret){
					<?php print we_message_reporting::getShowMessageCall($l_workflow["objects_empty"], WE_MESSAGE_ERROR); ?>
					return false;
				}

				ret=false;
				for(i=0;i<nsteps.value;i++){
					eval('if(document.we_form.<?php print $this->uid?>_step'+i+'_Worktime.value=="") ret=true;');
					if(ret){
						var _txt = "<?php print addslashes($l_workflow["worktime_empty"]); ?>";
						<?php print we_message_reporting::getShowMessageCall("_txt.replace(/%s/,i+1)", WE_MESSAGE_ERROR, true); ?>
						return false;
					}
					userempty=true;
					for(j=0;j<ntasks.value;j++){
						eval('if(document.we_form.<?php print $this->uid?>_task_'+i+'_'+j+'_userid.value!=0) userempty=false;');
					}
					if(userempty){
						var _txt = "<?php print addslashes($l_workflow["user_empty"]); ?>";

						<?php print we_message_reporting::getShowMessageCall("_txt.replace(/%s/,i+1)", WE_MESSAGE_ERROR, true); ?>
						return false;
					}

				}
				return true;
			}

		<?php endif?>
		</script>
	<?php
	}

	function processCommands(){
		global $l_workflow;
 		if(isset($_REQUEST["wcmd"]))
		switch($_REQUEST["wcmd"]){
			case "new_workflow":
				$this->workflowDef=new weWorkflow();
				$this->page = 0;
				print '<script language="JavaScript" type="text/javascript">
					top.content.resize.right.editor.edheader.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edheader";
					top.content.resize.right.editor.edfooter.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edfooter";
					</script>';
			break;
			case "add_cat":
				$arr=makeArrayFromCSV($this->workflowDef->Categories);
				if(isset($_REQUEST["wcat"])){
					$ids = makeArrayFromCSV($_REQUEST["wcat"]);
					foreach($ids as $id){
						if(strlen($id) && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->workflowDef->Categories=makeCSVFromArray($arr,true);
				}
			break;
			case "del_cat":
				$arr=makeArrayFromCSV($this->workflowDef->Categories);
				if(isset($_REQUEST["wcat"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["wcat"]) array_splice($arr,$k,1);
					}
					$this->workflowDef->Categories=makeCSVFromArray($arr,true);
				}
			break;
			case "del_all_cats":
				$this->workflowDef->Categories="";
			break;
			case "add_objcat":
				$arr=makeArrayFromCSV($this->workflowDef->ObjCategories);
				if(isset($_REQUEST["wocat"])){
					$ids = makeArrayFromCSV($_REQUEST["wocat"]);
					foreach($ids as $id){
						if(strlen($id) && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->workflowDef->ObjCategories=makeCSVFromArray($arr,true);
				}
			break;
			case "del_objcat":
				$arr=array();
				$arr=makeArrayFromCSV($this->workflowDef->ObjCategories);
				if(isset($_REQUEST["wocat"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["wocat"]) array_splice($arr,$k,1);
					}
					$this->workflowDef->ObjCategories=makeCSVFromArray($arr,true);
				}
			break;
			case "del_all_objcats":
				$this->workflowDef->ObjCategories="";
			break;
			case "add_folder":
				$arr=makeArrayFromCSV($this->workflowDef->Folders);
				if(isset($_REQUEST["wfolder"])){
					$ids = makeArrayFromCSV($_REQUEST["wfolder"]);
					foreach($ids as $id){
						if(strlen($id) && (!in_array($id,$arr))) {
							array_push($arr,$id);
						}
					}
					$this->workflowDef->Folders=makeCSVFromArray($arr,true);
				}
				break;
			case "del_folder":
				$arr=array();
				$arr=makeArrayFromCSV($this->workflowDef->Folders);
				if(isset($_REQUEST["wfolder"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["wfolder"]) array_splice($arr,$k,1);
					}
					$this->workflowDef->Folders=makeCSVFromArray($arr,true);
				}
			break;
			case "del_all_folders":
				$this->workflowDef->Folders="";
			break;
			case "add_object":
				$arr=array();
				$arr=makeArrayFromCSV($this->workflowDef->Objects);
				if(isset($_REQUEST["wobject"])){
					$arr[]=$_REQUEST["wobject"];
					$this->workflowDef->Objects=makeCSVFromArray($arr,true);
				}
			break;
			case "del_object":
				$arr=array();
				$arr=makeArrayFromCSV($this->workflowDef->Objects);
				if(isset($_REQUEST["wobject"])){
					foreach($arr as $k=>$v){
						if($v==$_REQUEST["wobject"]) array_splice($arr,$k,1);
					}
					$this->workflowDef->Objects=makeCSVFromArray($arr,true);
				}
			break;
			case "del_all_objects":
				$this->workflowDef->Objects="";
			break;
			case "reload":
					print '<script language="JavaScript" type="text/javascript">
					top.content.resize.right.editor.edheader.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edheader&page='.$this->page.'&txt='.$this->workflowDef->Text.'";
					top.content.resize.right.editor.edfooter.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edfooter";
					</script>';
			break;
			case "edit_workflow":
    				$this->show=0;
				if(isset($_REQUEST["wid"])){
			        	$this->workflowDef = new weWorkflow($_REQUEST["wid"]);
		        	}

				$_REQUEST["wcmd"]="reload";
				$this->processCommands();
			break;
			case "switchPage":
				if(isset($_REQUEST["page"])){
					$this->page=$_REQUEST["page"];
				}
			break;
			case "save_workflow":
				if(isset($_REQUEST["wid"])){
					$newone=false;
               if(!$this->workflowDef->ID) $newone=true;
					$exist=false;
					$double = 0;
					if($newone)
						$this->db->query("SELECT COUNT(*) AS Count FROM ".WORKFLOW_TABLE." WHERE Text='".mysql_real_escape_string($this->workflowDef->Text)."'");
					else
						$this->db->query("SELECT COUNT(*) AS Count FROM ".WORKFLOW_TABLE." WHERE Text='".mysql_real_escape_string($this->workflowDef->Text)."' AND ID<>".abs($this->workflowDef->ID)."");

					if($this->db->next_record()){
						$double = $this->db->f("Count");
					}

               if(!we_hasPerm("EDIT_WORKFLOW") && !we_hasPerm("NEW_WORKFLOW")){
						print '<script language="JavaScript" type="text/javascript">';
						print we_message_reporting::getShowMessageCall($l_workflow["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}
					else if($newone && !we_hasPerm("NEW_WORKFLOW")){
						print '<script language="JavaScript" type="text/javascript">';
						print we_message_reporting::getShowMessageCall($l_workflow["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}
					else{
						if($double){
							print '<script language="JavaScript" type="text/javascript">';
							print we_message_reporting::getShowMessageCall($l_workflow["double_name"], WE_MESSAGE_ERROR);
							print '</script>';
							return;
						}
						$childs="";
						$this->workflowDef->loadDocuments();
						foreach($this->workflowDef->documents as $k=>$v)
							$childs.="top.content.deleteEntry(".$v["ID"].",'file');\n";
			        	$this->workflowDef->save();
						print '<script language="JavaScript" type="text/javascript">';
						if($newone) print 'top.content.makeNewEntry("workflow_folder",'.$this->workflowDef->ID.',0,"'.$this->workflowDef->Text.'",true,"folder","weWorkflowDef","'.$this->workflowDef->Status.'");';
						else print 'top.content.updateEntry('.$this->workflowDef->ID.',0,"'.$this->workflowDef->Text.'","'.$this->workflowDef->Status.'");';
						print $childs;
						print 'top.content.resize.right.editor.edheader.document.getElementById("headrow").innerHTML="' . we_htmlElement::htmlB($l_workflow['workflow']. ': ' . htmlspecialchars($this->workflowDef->Text)).'";';
						print we_message_reporting::getShowMessageCall($l_workflow["save_ok"], WE_MESSAGE_NOTICE);
						print '</script>';
					}
		        	}
			break;
			case "show_document":
				if(isset($_REQUEST["wid"])){
					$this->show=1;
					$this->page=0;
					$this->documentDef->load($_REQUEST["wid"]);
					print '<script language="JavaScript" type="text/javascript">
					top.content.resize.right.editor.edheader.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edheader&art=1&txt='.$this->documentDef->document->Text.'";
					top.content.resize.right.editor.edfooter.location="' . WE_WORKFLOW_MODULE_PATH . 'edit_workflow_frameset.php?pnt=edfooter&art=1";
					</script>';

		        	}
			break;
			case "delete_workflow":
				if(isset($_REQUEST["wid"])){
					if(!we_hasPerm("DELETE_WORKFLOW")){
						print '<script language="JavaScript" type="text/javascript">';
						print we_message_reporting::getShowMessageCall($l_workflow["no_perms"], WE_MESSAGE_ERROR);
						print '</script>';
						return;
					}
					else{

						$this->workflowDef = new weWorkflow($_REQUEST["wid"]);
						if($this->workflowDef->delete()){
							$this->workflowDef = new weWorkflow();
							print '<script language="JavaScript" type="text/javascript">
							top.content.deleteEntry('.$_REQUEST["wid"].',"folder");
							' . we_message_reporting::getShowMessageCall($l_workflow["delete_ok"], WE_MESSAGE_NOTICE) . '
							</script>';
						}else{
							print '<script language="JavaScript" type="text/javascript">
							' . we_message_reporting::getShowMessageCall($l_workflow["delete_nok"], WE_MESSAGE_ERROR) . '
							</script>';
						}
					}
				}
			break;
			case "reload_table":
				$this->page=1;
			break;
			case "empty_log":
				$stamp=0;
				if(isset($_REQUEST["wopt"]) && $_REQUEST["wopt"]){
					$t=explode(",",$_REQUEST["wopt"]);
					$stamp=mktime($t[3],$t[4],0,$t[1],$t[0],$t[2]);
				}
				$this->Log->clearLog($stamp);
				print '<script language="JavaScript" type="text/javascript">
					' . we_message_reporting::getShowMessageCall($l_workflow["empty_log_ok"], WE_MESSAGE_NOTICE) . '
					</script>';
			break;
            		default:
		}
	}

	function processVariables(){
		if(isset($_REQUEST["wname"])) $this->uid=$_REQUEST["wname"];
		foreach($this->workflowDef->persistents as $key=>$val){
			$varname=$this->uid."_".$val;
			if(isset($_REQUEST[$varname])){
				eval('$this->workflowDef->'.$val.'="'.$_REQUEST[$varname].'";');
			}
		}

		$wsteps=0;
		$wtasks=0;

		if(isset($_REQUEST["wsteps"])) $wsteps=$_REQUEST["wsteps"];
		if(isset($_REQUEST["wtasks"])) $wtasks=$_REQUEST["wtasks"];
		if(isset($_REQUEST["page"])) $this->page=$_REQUEST["page"];


		$this->workflowDef->steps=array();
		if($wsteps==0){
			$this->workflowDef->addNewStep();
			$this->workflowDef->addNewTask();
		}

		for($i=0;$i<$wsteps;$i++) $this->workflowDef->addNewStep();
		for($j=0;$j<$wtasks;$j++) $this->workflowDef->addNewTask();

		foreach($this->workflowDef->steps as $skey=>$sval){


			$this->workflowDef->steps[$skey]->workflowID=$this->workflowDef->ID;

			$varname=$this->uid."_step".$skey."_sid";
			if(isset($_REQUEST[$varname])){
				if($_REQUEST[$varname]) $this->workflowDef->steps[$skey]->ID=$_REQUEST[$varname];
			}

			$varname=$this->uid."_step".$skey."_and";
			if(isset($_REQUEST[$varname])){
				$this->workflowDef->steps[$skey]->stepCondition=$_REQUEST[$varname] ? 1 : 0;
			}

			$varname=$this->uid."_step".$skey."_Worktime";
			if(isset($_REQUEST[$varname])){
				$this->workflowDef->steps[$skey]->Worktime=$_REQUEST[$varname];
			}

			$varname=$this->uid."_step".$skey."_timeAction";
			if(isset($_REQUEST[$varname])){
				$this->workflowDef->steps[$skey]->timeAction=$_REQUEST[$varname];
			}

			foreach($this->workflowDef->steps[$skey]->tasks as $tkey=>$tval){

				$this->workflowDef->steps[$skey]->tasks[$tkey]->stepID=$this->workflowDef->steps[$skey]->ID;

				$varname=$this->uid."_task_".$skey."_".$tkey."_tid";
				if(isset($_REQUEST[$varname])){
					$this->workflowDef->steps[$skey]->tasks[$tkey]->ID=$_REQUEST[$varname];
				}

				$varname=$this->uid."_task_".$skey."_".$tkey."_userid";
				if(isset($_REQUEST[$varname])){
					$this->workflowDef->steps[$skey]->tasks[$tkey]->userID=$_REQUEST[$varname];
				}

				$varname=$this->uid."_task_".$skey."_".$tkey."_usertext";
				if(isset($_REQUEST[$varname])){
					$this->workflowDef->steps[$skey]->tasks[$tkey]->username=$_REQUEST[$varname];
				}

				$varname=$this->uid."_task_".$skey."_".$tkey."_Edit";
				if(isset($_REQUEST[$varname])){
					$this->workflowDef->steps[$skey]->tasks[$tkey]->Edit=$_REQUEST[$varname];
				}

				$varname=$this->uid."_task_".$skey."_".$tkey."_Mail";
				if(isset($_REQUEST[$varname])){
					$this->workflowDef->steps[$skey]->tasks[$tkey]->Mail=$_REQUEST[$varname];
				}

			}
		}

	}


	function getDocumentInfo(){
		if($this->documentDef->workflow->Type==WE_WORKFLOW_OBJECT)return $this->getObjectInfo();
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");

		$_space = 100;
		$_parts = array();

		$out = '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'tooltip.js"></script>';

		//	Part - file-information
		array_push(	$_parts, array(	"headline" => $l_we_editor_info["content_type"],
									"html"     => $l_we_editor_info[$this->documentDef->document->ContentType],
									"space"    => $_space,
									"noline"   => (($this->documentDef->document->ContentType != "folder" && $this->documentDef->workflow->Type!=WE_WORKFLOW_OBJECT) ? 1 : 0)
								)
					);
		if($this->documentDef->document->ContentType != "folder" && $this->documentDef->workflow->Type!=WE_WORKFLOW_OBJECT){
			$GLOBALS["we_doc"]=$this->documentDef->document;
			$fs = $this->documentDef->document->getFilesize($this->documentDef->document->Path);
			array_push(	$_parts, array(	"headline" => $l_we_editor_info["file_size"],
										"html"     => round(($fs / 1024),2)."&nbsp;KB&nbsp;(".number_format ($fs,0,",",".")."&nbsp;Byte)",
										"space"    => $_space
									)
					);
		}

		//	Part - publish-information

		array_push(	$_parts, array(	"headline" => $l_we_editor_info["creation_date"],
									"html"     => date($l_we_editor_info["date_format"], $this->documentDef->document->CreationDate),
									"space"    => $_space,
									"noline"   => 1
								)
				);

		if($this->documentDef->document->CreatorID){
			$this->db->query("SELECT First,Second,username FROM ".USER_TABLE." WHERE ID=".$this->documentDef->document->CreatorID);
			if($this->db->next_record())
				array_push(	$_parts, array(	"headline" => $GLOBALS["l_users"]["created_by"],
											"html"     => $this->db->f("First").' '.$this->db->f("Second").' ('.$this->db->f("username") . ')',
											"space"    => $_space,
											"noline"   => 1
										)
						);
		}

			array_push(	$_parts, array(	"headline" => $l_we_editor_info["changed_date"],
										"html"     => date($l_we_editor_info["date_format"], $this->documentDef->document->ModDate),
										"space"    => $_space,
										"noline"   => 1
									)
					);

		if($this->documentDef->document->ModifierID){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
			$this->db->query("SELECT First,Second,username FROM ".USER_TABLE." WHERE ID=".$this->documentDef->document->ModifierID);
			if($this->db->next_record())
				array_push(	$_parts, array(	"headline" => $GLOBALS["l_users"]["changed_by"],
											"html"     => $this->db->f("First").' '.$this->db->f("Second").' ('.$this->db->f("username").')',
											"space"    => $_space,
											"noline"   => 1
										)
						);
		}

		if($this->documentDef->document->ContentType == "text/html" || $this->documentDef->document->ContentType == "text/webedition"){
			array_push(	$_parts, array(	"headline" => $l_we_editor_info["lastLive"],
										"html"     => ($this->documentDef->document->Published ? date($l_we_editor_info["date_format"],$this->documentDef->document->Published) : "-"),
										"space"    => $_space
									)
						);
		}


		//	Part - Path-information

		if($this->documentDef->document->Table != TEMPLATES_TABLE && $this->documentDef->workflow->Type!=WE_WORKFLOW_OBJECT){
			$rp = $this->documentDef->document->getRealPath();
			$http = $this->documentDef->document->getHttpPath();
			$showlink = ($this->documentDef->document->ContentType=="text/html" ||
					$this->documentDef->document->ContentType=="text/webedition" ||
					$this->documentDef->document->ContentType=="image/*"  ||
					$this->documentDef->document->ContentType=="application/x-shockwave-flash");

			array_push(	$_parts, array(	"headline" => $l_we_editor_info["local_path"],
										"html"     => '<a href="#" style="text-decoration:none;cursor:text" class="defaultfont" onMouseOver="showtip(this,event,\''.$rp.'\')" onMouseOut="hidetip()">'.shortenPath($rp,74).'</a>',
										"space"    => $_space,
										"noline"   => 1
									)
						);

			array_push(	$_parts, array(	"headline" => $l_we_editor_info["http_path"],
										"html"     => ($showlink ? '<a href="'.$http.'" target="_blank" onMouseOver="showtip(this,event,\''.$http.'\')" onMouseOut="hidetip()">' : '').shortenPath($http,74).($showlink ? '</a>' : ''),
										"space"    => $_space
									)
						);
		}

		//	Logbook
		array_push(	$_parts, array(	"headline" => "",
									"html"     => $this->getDocumentStatus($this->documentDef->ID),
									"space"    => 0
								)
					);
		$out  .= we_multiIconBox::getHTML("", "100%", $_parts, 30 );
		return $out;
	}


	function getObjectInfo(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");

		$_parts = array();
		$_space = 150;

		//	Dokument properties
		array_push($_parts, array(	"headline" => "ID",
									"html"     => $this->documentDef->document->ID,
									"space"    => $_space,
									"noline"   => 1
									)
					);
		array_push($_parts, array(	"headline" => $l_we_editor_info["content_type"],
									"html"     => $l_we_editor_info[$this->documentDef->document->ContentType],
									"space"    => $_space,
									)
					);

		// publish information
		array_push($_parts, array(	"headline" => $l_we_editor_info["creation_date"],
									"html"     => date($l_we_editor_info["date_format"], $this->documentDef->document->CreationDate),
									"space"    => $_space,
									"noline"   => 1
									)
					);
		if(false){
   			$this->db->query("SELECT First,Second,username FROM ".USER_TABLE." WHERE ID=".$this->documentDef->document->CreatorID);
   			if($this->db->next_record()){
   				array_push($_parts, array(	"headline" => $l_users["created_by"],
											"html"     => $this->db->f("First").' '.
											              $this->db->f("Second") .
											              ' ('.$this->db->f("username").')',
											"space"    => $_space,
											"noline"   => 1
											)
							);
			}
		}
		array_push($_parts, array(	"headline" => $l_we_editor_info["changed_date"],
									"html"     => date($l_we_editor_info["date_format"], $this->documentDef->document->ModDate),
									"space"    => $_space,
									"noline"   => 1
									)
					);
		if(false){
   			$this->db->query("SELECT First,Second,username FROM ".USER_TABLE." WHERE ID=".$this->documentDef->document->ModifierID);
   			if($this->db->next_record()){
   				array_push($_parts, array(	"headline" => $l_users["changed_by"],
											"html"     => $this->db->f("First").' '.$this->db->f("Second").' ('.$this->db->f("username").')',
											"space"    => $_space,
											"noline"   => 1
											)
							);
			}
		}

		array_push($_parts, array(	"headline" => $l_we_editor_info["lastLive"],
									"html"     => ($this->documentDef->document->Published ? date($l_we_editor_info["date_format"],$this->documentDef->document->Published) : "-"),
									"space"    => $_space,
									)
					);

		array_push($_parts, array(	"headline" => "",
									"html"     => $this->getDocumentStatus($this->documentDef->ID),
									"space"    => 0,
									)
					);

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php");

		$out  = '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'windows.js"></script>
		</head>
		<body class="weEditorBody" onunload="doUnload()">
				<form name="we_form">'.$this->documentDef->document->hiddenTrans().'<table cellpadding="6" cellspacing="0" border="0">';


		$out .= we_multiIconBox::getHTML("", "100%", $_parts, 30);


		$out .= '</form></body>
		</html>';


		return $out;

	}

	function getTime($seconds){
		$ret=array("hour"=>0,"min"=>0,"sec"=>0);
		$ret["min"]=floor($seconds/60);
		$ret["sec"]=$seconds-($ret["min"]*60);
		$ret["hour"]=floor($ret["min"]/60);
		$ret["min"]=$ret["min"]-($ret["hour"]*60);
		return $ret;
	}


	function getDocumentStatus($workflowDocID){
		global $l_workflow;
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");

		$we_button = new we_button();

		$db=new DB_WE;
		$headline[0]["dat"]='<div class="middlefont">'.$l_workflow["step"]."</div>";

		$workflowDocument=new weWorkflowDocument($workflowDocID);

		$counter=0;
		$counter1=0;
		$current=$workflowDocument->findLastActiveStep();
		if($current<0) return $l_workflow["cannot_find_active_step"];
		foreach($workflowDocument->steps as $sk=>$sv){

			$workflowStep=new weWorkflowStep($sv->workflowStepID);

			$now=date($l_we_editor_info["date_format"],time());
			$start=date($l_we_editor_info["date_format"],$sv->startDate);

			$secs=time()-$sv->startDate;
			$elapsed=weWorkflowView::getTime($secs);

			$secs=($sv->startDate+($workflowStep->Worktime*3600))-time();
			$remained=weWorkflowView::getTime($secs);

			if($remained["hour"]<0){
				if($sk>$current){
					$finished_font="middlefont";
					$notfinished_font="middlefontgray";
				}
				else{
					$finished_font="middlefontred";
					$notfinished_font="middlefontred";
				}
			}
			else{
				$finished_font="middlefont";
				$notfinished_font="middlefontgray";
			}

			$end=date($l_we_editor_info["date_format"],$sv->startDate+$workflowStep->Worktime*3600);

			$content[$counter][0]["dat"]=($sv->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').($counter+1)."</div>";
			$content[$counter][0]["height"]="";
			$content[$counter][0]["align"]="center";

			$counter1=0;
			foreach($sv->tasks as $tk=>$tv){

				$headline[$counter1+1]["dat"]=$l_workflow["user"].(string )($counter1+1);

				$workflowTask=new weWorkflowTask($tv->workflowTaskID);

				$foo=f("SELECT username FROM ".USER_TABLE." WHERE ID=".abs($workflowTask->userID),"username",$db);

				if($sk==$current)
					$out=($tv->Status==WORKFLOWDOC_TASK_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').$foo."</div>";
				else if($sk<$current)
					$out='<div class="'.$finished_font.'">'.$foo.'</div>';
				else
					$out='<div class="'.$notfinished_font.'">'.$foo.'</div>';

				$content[$counter][$counter1+1]["dat"]=$out;
				$content[$counter][$counter1+1]["height"]="";
				$content[$counter][$counter1+1]["align"]="";
				$counter1++;
			}


			$headline[$counter1+1]["dat"]=$l_workflow["worktime"];

         $content[$counter][$counter1+1]["dat"]=($sv->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').$workflowStep->Worktime.'</div>';
			$content[$counter][$counter1+1]["height"]="";
			$content[$counter][$counter1+1]["align"]="right";

			if($sk<=$current){
				$counter1++;
				$headline[$counter1+1]["dat"]=$l_workflow["time_elapsed"];


				$content[$counter][$counter1+1]["dat"]=($sv->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').$elapsed["hour"].":".$elapsed["min"].":".$elapsed["sec"]."</div>";
				$content[$counter][$counter1+1]["height"]="";
				$content[$counter][$counter1+1]["align"]="right";

				$counter1++;
				$headline[$counter1+1]["dat"]=$l_workflow["time_remained"];

				$content[$counter][$counter1+1]["dat"]=($sv->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').$remained["hour"].":".$remained["min"].":".$remained["sec"]."</div>";
				$content[$counter][$counter1+1]["height"]="";
				$content[$counter][$counter1+1]["align"]="right";

				$counter1++;

				$headline[$counter1+1]["dat"]=$l_workflow["step_plan"];

				$content[$counter][$counter1+1]["dat"]=($sv->Status==WORKFLOWDOC_STEP_STATUS_UNKNOWN ? '<div class="'.$notfinished_font.'">':'<div class="'.$finished_font.'">').$end."</div>";
				$content[$counter][$counter1+1]["height"]="";
				$content[$counter][$counter1+1]["align"]="right";
			}




			$counter++;
		}

		$wfType = f("SELECT ".WORKFLOW_TABLE.".Type as Type FROM ".WORKFLOW_TABLE.",".WORKFLOW_DOC_TABLE." WHERE ".WORKFLOW_DOC_TABLE.".workflowID=".WORKFLOW_TABLE.".ID AND ".WORKFLOW_DOC_TABLE.".ID=".abs($workflowDocument->ID),"Type",$db);
		$out='<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td></td><td>'.htmlDialogBorder3(400,300,$content,$headline).'</td><td>'.getPixel(15,10).'</td>
		</tr>
			<td></td><td>'.getPixel(10,10).'</td><td>'.getPixel(15,10).'</td>
		<tr>
			<td></td><td>' . $we_button->create_button("logbook", "javascript:new jsWindow('" . WE_WORKFLOW_MODULE_PATH . "edit_workflow_frameset.php?pnt=log&art=".$workflowDocument->document->ID."&type=".$wfType."','workflow_history',-1,-1,640,480,true,false,true);").'</td><td>'.getPixel(15,10).'</td>
		</tr>
		</table>';


		return $out;

	}

	function getLogForDocument($docID,$type=0){
		global $l_workflow;
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
		$db=new DB_WE;

		$we_button = new we_button();

		$headlines=array();
		$content=array();

		$headlines[0]["dat"]=$l_workflow["action"];
		$headlines[1]["dat"]=$l_workflow["description"];
		$headlines[2]["dat"]=$l_workflow["time"];
		$headlines[3]["dat"]=$l_workflow["user"];

		$logs=array();
		$logs=weWorkflowLog::getLogForDocument($docID,"DESC",$type);
		$counter=0;

		$offset = isset($_REQUEST["offset"]) ? $_REQUEST["offset"] : 0;
		$art = isset($_REQUEST["art"]) ? $_REQUEST["art"] : "";
		$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";
		$numRows = NUMBER_LOGS;
		$anz = $GLOBALS["ANZ_LOGS"];

		foreach($logs as $v){
				$content[$counter]=array();
				$content[$counter][0]["dat"]='<div class="middlefont">'.$v["Type"]."</div>";
				$content[$counter][0]["height"]="";
				$content[$counter][0]["align"]="";

				$content[$counter][1]["dat"]='<div class="middlefont">'.$v["Description"]."</div>";
				$content[$counter][1]["height"]="";
				$content[$counter][1]["align"]="";

				$content[$counter][2]["dat"]='<div class="middlefont"><nobr>'.date($l_we_editor_info["date_format"],$v["logDate"])."</nobr></div>";
				$content[$counter][2]["height"]="";
				$content[$counter][2]["align"]="right";

				$foo=getHash("SELECT First,Second,username FROM ".USER_TABLE." WHERE ID='".$v["userID"]."'",$db);
				$content[$counter][3]["dat"]='<div class="middlefont">'.((isset($foo["First"]) && $foo["First"]) ? $foo["First"] : "-")." ".((isset($foo["Second"]) && $foo["Second"]) ? $foo["Second"]:"-") .((isset($foo["username"]) && $foo["username"]) ? " (".$foo["username"].")" : "")."</div>";
				$content[$counter][3]["height"]="";
				$content[$counter][3]["align"]="left";

				$counter++;
		}

		$nextprev = '<table cellpadding="0" cellspacing="0" border="0"><tr><td>';
		if($offset){
			$nextprev .= $we_button->create_button("back", WE_WORKFLOW_MODULE_PATH . "edit_workflow_frameset.php?pnt=log&art=$art&type=$type&offset=".($offset-$numRows)); //bt_back
		}else{
			$nextprev .= $we_button->create_button("back", "", false, 100, 22, "", "", true);
		}

		$nextprev .= getPixel(23,1)."</td><td class='defaultfont' style=\"padding: 0 10px 0 10px;\"><b>".(($anz)?$offset+1:0)."-";

		if( ($anz-$offset) < $numRows){
			$nextprev .= $anz;
		}else{
			$nextprev .= $offset+$numRows;
		}

		$nextprev .= getPixel(5,1)." ".$GLOBALS["l_global"]["from"]." ".getPixel(5,1).$anz."</b></td><td>".getPixel(23,1);

		if(($offset+$numRows) < $anz){
			$nextprev .= $we_button->create_button("next", WE_WORKFLOW_MODULE_PATH . "edit_workflow_frameset.php?pnt=log&art=$art&type=$type&offset=".($offset+$numRows)."&order=$order"); //bt_back
		}else{
			$nextprev .= $we_button->create_button("next", "", "", 100, 22, "", "", true);
		}
		$nextprev .= "</td><td></tr></table>";

		$buttonsTable = '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td>' .$nextprev . '</td><td align="right">' . $we_button->create_button("close", "javascript:self.close();") . '</td></tr></table>';


		if(count($logs)) {
			return htmlDialogLayout(htmlDialogBorder3(580,300,$content,$headlines),"",$buttonsTable);
		} else {
			return htmlDialogLayout('<div style="width:500px" class="middlefontgray" align="center"><center>-- '.$l_workflow["log_is_empty"].' --</center></div>', '', $we_button->create_button("close", "javascript:self.close();"));
		}

	}

	function getLogQuestion(){
		global $l_workflow;
		$we_button = new we_button();

		$js='<script language="JavaScript" type="text/javascript">

			function clear(){
				opener.top.content.cmd.document.we_form.wcmd.value="empty_log";
				if(document.we_form.clear_opt.value==1){
					var day=document.we_form.log_time_day.options[document.we_form.log_time_day.selectedIndex].text;
					var month=document.we_form.log_time_month.options[document.we_form.log_time_month.selectedIndex].text;
					var year=document.we_form.log_time_year.options[document.we_form.log_time_year.selectedIndex].text;
					var hour=document.we_form.log_time_hour.options[document.we_form.log_time_hour.selectedIndex].text;
					var min=document.we_form.log_time_minute.options[document.we_form.log_time_minute.selectedIndex].text;

					var timearr=[day,month,year,hour,min];
					opener.top.content.cmd.document.we_form.wopt.value=timearr.join();
				}
				else{
					if(!confirm("'.$l_workflow["emty_log_question"].'")) return;
				}
				opener.top.content.cmd.submitForm();
				close();
			}
			self.focus();
		</script>';
		$out=$this->htmlHidden("clear_opt","1");
		$out.='<form name="we_form">';
		$out.='<table cellpading="0" cellspacing="0">';
		$out.='<tr>';
		$out.='<td class="defaultfont">'.$l_workflow["log_question_text"].'</td>';
		$out.='</tr>';
		$out.='<tr>';
		$out.='<td>'.getPixel(10,10).'</td>';
		$out.='</tr>';

		$out.='<tr>';
		$vals=array();
		$vals[]='<table cellpading="0" cellspacing="0"><tr><td>'.getPixel(22,5).'</td><td>'.getDateInput2("log_time%s",(time()-(336*3600))).'</td></tr></table>';
		$out.='<td>'.$this->getTypeTableHTML(we_forms::radiobutton("1",true,"clear_time",$l_workflow["log_question_time"],true,"defaultfont","javascript:document.we_form.clear_opt.value=1;"),$vals).'</td>';
		$out.='</tr>';

		$out.='<tr>';
		$out.='<td>'.getPixel(22,10)."<br>".we_forms::radiobutton("0",false,"clear_time",$l_workflow["log_question_all"],true,"defaultfont","javascript:document.we_form.clear_opt.value=0;").'</td>';
		$out.='</tr>';

		$out.='</tr>';
		$out.='</table>';
		$out=$js.htmlDialogLayout( $out,
									$l_workflow["empty_log"],
									$we_button->position_yes_no_cancel(	$we_button->create_button("ok", "javascript:self.clear();"),
																		"",
																		$we_button->create_button("cancel", "javascript:self.close();")
																		)
									) . '</form>';

		return $out;

	}


}




?>