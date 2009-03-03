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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
//include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/"."weBackup.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");

define("BACKUP_MODE",1);
define("RECOVER_MODE",2);

class weBackupWizard{

	var $mode; //1-backup;2-recover
	var $frameset;
	var $db;

	function weBackupWizard($frameset="",$mode=BACKUP_MODE){
		$this->setFrameset($frameset);
		$this->setMode($mode);
		$this->db=new DB_WE();
	}

 	function setFrameset($frameset){
 		$this->frameset=$frameset;
 	}

 	function setMode($mode){
 		$this->mode=$mode;
 	}

	function getJSDep($mode,$docheck,$doclick){
		global $l_backup;
		return we_htmlElement::jsElement('
			function we_submitForm(target,url) {
				var f = self.document.we_form;
				f.target = target;
				f.action = url;
				f.method = "post";
				f.submit();
			}


			function doCheck(opt){
				switch (opt) {
					'.$docheck.'
				}
			}

			function doClick(opt) {
				switch (opt) {
					'.$doclick.'
				}
				if (a.checked){
					switch(opt) {
						case 101:
							if(!document.we_form.handle_core.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_temporary_dep"], WE_MESSAGE_NOTICE) . '
							}
						break;
						case 12:
							if(!document.we_form.handle_core.checked || !document.we_form.handle_object.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								document.we_form.handle_object.value=1;								
								document.we_form.handle_object.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_versions_dep"], WE_MESSAGE_NOTICE) . '
							}
						break;
						case 13:
							if(!document.we_form.handle_core.checked || !document.we_form.handle_object.checked  || !document.we_form.handle_versions.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								document.we_form.handle_object.value=1;								
								document.we_form.handle_object.checked=true;
								document.we_form.handle_versions.value=1;								
								document.we_form.handle_versions.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_versions_binarys_dep"], WE_MESSAGE_NOTICE) . '
							}
						break;
						case 14:
							if(!document.we_form.handle_core.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_binary_dep"], WE_MESSAGE_NOTICE) . '
							}
						break;
						case 55:
							if(!document.we_form.handle_core.checked || !document.we_form.handle_object.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								document.we_form.handle_object.value=1;
								document.we_form.handle_object.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_schedule_dep"], WE_MESSAGE_NOTICE) . '
							}
						break;
					'.((defined("SHOP_TABLE")) ? ('
						case 30:
							'.((defined("CUSTOMER_TABLE")) ? ('
							if(!document.we_form.handle_customer.checked) {
								document.we_form.handle_customer.value=1;
								document.we_form.handle_customer.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_shop_dep"], WE_MESSAGE_NOTICE) . '
							}
						') : ('')).'
							break;
					') : '').
					((defined("WORKFLOW_TABLE")) ? ('
						case 35:
							if(!document.we_form.handle_user.checked || !document.we_form.handle_core.checked) {
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								document.we_form.handle_user.value=1;
								document.we_form.handle_user.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_workflow_dep"], WE_MESSAGE_NOTICE) . '
							}
							break;
					') : '').
					((defined("MESSAGING_SYSTEM")) ? ('
						case 40:
							if(!document.we_form.handle_user.checked) {
								document.we_form.handle_user.value=1;
								document.we_form.handle_user.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_todo_dep"], WE_MESSAGE_NOTICE) . '
							}
							break;
					') : '').
					((defined("NEWSLETTER_TABLE")) ? ('
						case 45:
							'.((defined("CUSTOMER_TABLE")) ? ('
							if(!document.we_form.handle_customer.checked || !document.we_form.handle_core.checked || !document.we_form.handle_object.checked){
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								document.we_form.handle_object.value=1;
								document.we_form.handle_object.checked=true;
								document.we_form.handle_customer.value=1;
								document.we_form.handle_customer.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_newsletter_dep"], WE_MESSAGE_NOTICE) . '
							}
						') : ('')).'
							break;
					') : '').
					((defined("BANNER_TABLE")) ? ('
						case 50:
							if(!document.we_form.handle_core.checked){
								document.we_form.handle_core.value=1;
								document.we_form.handle_core.checked=true;
								' . we_message_reporting::getShowMessageCall($l_backup[$mode."_banner_dep"], WE_MESSAGE_NOTICE) . '
							}
							break;
					') : '').'
					}
				}
				else{
					var mess="";
					switch(opt) {
						case 10:
	 					'.((defined("WORKFLOW_TABLE")) ? ('
						if(document.forms["we_form"].elements["handle_workflow"].checked){
							document.forms["we_form"].elements["handle_workflow"].checked=false;
							mess+="\n-'.$l_backup[$mode."_workflow_data"].'";
						}
						') : ('')).'
	 					'.((defined("NEWSLETTER_TABLE")) ? ('
						if(document.forms["we_form"].elements["handle_newsletter"].checked){
							document.forms["we_form"].elements["handle_newsletter"].checked=false;
							mess+="\n-'.$l_backup[$mode."_newsletter_data"].'";
						}
						') : ('')).'
	 					'.((defined("BANNER_TABLE")) ? ('
						if(document.forms["we_form"].elements["handle_banner"].checked){
							document.forms["we_form"].elements["handle_banner"].checked=false;
							mess+="\n-'.$l_backup[$mode."_banner_data"].'";
						}
						') : ('')).'
	 					'.((defined("SCHEDULE_TABLE")) ? ('
						if(document.forms["we_form"].elements["handle_schedule"].checked){
							document.forms["we_form"].elements["handle_schedule"].checked=false;
							mess+="\n-'.$l_backup[$mode."_schedule_data"].'";
						}
						') : ('')).'
						if(document.forms["we_form"].elements["handle_versions"].checked){
							document.forms["we_form"].elements["handle_versions"].checked=false;
							mess+="\n-'.$l_backup[$mode."_versions_data"].'";
						}
						if(document.forms["we_form"].elements["handle_versions_binarys"].checked){
							document.forms["we_form"].elements["handle_versions_binarys"].checked=false;
							mess+="\n-'.$l_backup[$mode."_versions_binarys_data"].'";
						}
						if(document.forms["we_form"].elements["handle_temporary"].checked){
							document.forms["we_form"].elements["handle_temporary"].checked=false;
							mess+="\n-'.$l_backup[$mode."_temporary_data"].'";
						}
						if(mess!="") {
							tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_core_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
							' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
						}
						break;

						'.((defined("OBJECT_TABLE")) ? ('
			 			case 11:
			 				'.((defined("SCHEDULE_TABLE")) ? ('
							if(document.forms["we_form"].elements["handle_schedule"].checked){
								document.forms["we_form"].elements["handle_schedule"].checked=false;
								mess+="\n-'.$l_backup[$mode."_schedule_data"].'";
							}
						') : ('')).'
						if(document.forms["we_form"].elements["handle_versions"].checked){
							document.forms["we_form"].elements["handle_versions"].checked=false;
							mess+="\n-'.$l_backup[$mode."_versions_data"].'";
						}
						if(document.forms["we_form"].elements["handle_versions_binarys"].checked){
							document.forms["we_form"].elements["handle_versions_binarys"].checked=false;
							mess+="\n-'.$l_backup[$mode."_versions_binarys_data"].'";
						}
						if(mess!="") {
							tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_object_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
							' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
						}
						break;
						case 12:

						if(document.forms["we_form"].elements["handle_versions_binarys"].checked){
							document.forms["we_form"].elements["handle_versions_binarys"].checked=false;
							mess+="\n-'.$l_backup[$mode."_versions_binarys_data"].'";
						}
						if(mess!="") {
							tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_versions_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
							' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
						}
						break;
						') : ('')).'
						
						case 14:
							if(mess!="") {
								tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_binary_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
								' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
							}
						break;
			 			case 20:
			 				'.((defined("WORKFLOW_TABLE")) ? ('
							if(document.forms["we_form"].elements["handle_workflow"].checked){
								document.forms["we_form"].elements["handle_workflow"].checked=false;
								mess+="\n-'.$l_backup[$mode."_workflow_data"].'";
							}
			 			'.((defined("MESSAGING_SYSTEM")) ? ('
							if(document.forms["we_form"].elements["handle_todo"].checked){
								document.forms["we_form"].elements["handle_todo"].checked=false;
								mess+="\n-'.$l_backup[$mode."_todo_data"].'";
							}
						') : ('')).'
						if(mess!="") {
							tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_user_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
							' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
						}
						break;
						') : ('')).'
						'.((defined("CUSTOMER_TABLE")) ? ('
			 			case 25:
			 				'.((defined("SHOP_TABLE")) ? ('
							if(document.forms["we_form"].elements["handle_shop"].checked){
								document.forms["we_form"].elements["handle_shop"].checked=false;
								mess+="\n-'.$l_backup[$mode."_shop_data"].'";
							}
						') : ('')).'
			 			'.((defined("NEWSLETTER_TABLE")) ? ('
							if(document.forms["we_form"].elements["handle_newsletter"].checked){
								document.forms["we_form"].elements["handle_newsletter"].checked=false;
								mess+="\n-'.$l_backup[$mode."_newsletter_data"].'";
							}
						') : ('')).'
						if(mess!="") {
							tmpMess = "'.sprintf($l_backup["unselect_dep2"],$l_backup[$mode."_customer_data"]).'"+mess+"\n'.$l_backup["unselect_dep3"].'";
							' . we_message_reporting::getShowMessageCall("tmpMess", WE_MESSAGE_NOTICE, true) . '
						}
						break;
						') : ('')).'
					}
				}
			}
		');
	}

 	function  getHTMLFrameset(){

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

		$frameset->setAttributes(array("rows"=>((isset($_SESSION["prefs"]["debug_normal"]) && $_SESSION["prefs"]["debug_normal"] != 0) ? "*,40,100,100" : "*,40,0,0" )));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=body","name"=>"body","scrolling"=>"auto","noresize"=>null));
		$frameset->addFrame(array("src"=>$this->frameset,"name"=>"busy","scrolling"=>"no"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=cmd","name"=>"cmd","scrolling"=>"no","noresize"=>null));
		$frameset->addFrame(array("src/webEdition/html/blank.html","name"=>"checker","scrolling"=>"no","noresize"=>null));

		$head=WE_DEFAULT_HEAD."\n" . STYLESHEET ."\n";
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}


 	function getHTMLStep($step){

 		if($this->mode==BACKUP_MODE){
 			if($step==1) return $this->getHTMLBackupStep1();
 			else if($step==2) return $this->getHTMLBackupStep2();
 			else if($step==3) return $this->getHTMLBackupStep3();
 		}
 	 	if($this->mode==RECOVER_MODE){
 			if($step==1) return $this->getHTMLRecoverStep1();
 			else if($step==2) return $this->getHTMLRecoverStep2();
 			else if($step==3) return $this->getHTMLRecoverStep3();
 			else if($step==4) return $this->getHTMLRecoverStep4();
 		}

 	}

 	function  getHTMLRecoverStep1(){
		global $l_backup;

		$parts=array();

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["save_before"],1,600),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>$l_backup["save_question"],"space"=>0,"noline"=>1));

		$js=we_htmlElement::jsElement('
			function startStep(){
				self.focus();
				top.busy.location="'.$this->frameset.'?pnt=busy&step=1";
			}
		');

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onLoad"=>"startStep()"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
							we_multiIconBox::getHTML("backup_options", "100%", $parts, 30, "", -1,"","",false,$l_backup["step1"])
						)
					)
		);
		$head=WE_DEFAULT_HEAD."\n".$js;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title"],$head);
		$head.= "\n" . STYLESHEET . "\n";

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}

	function  getHTMLRecoverStep2(){
		global $l_backup;

		$parts=array();

		$js=we_htmlElement::jsElement('
			function we_submitForm(target,url) {
				var f = self.document.we_form;
				f.target = target;
				f.action = url;
				f.method = "post";
				f.submit();
			}

			function startStep(){
				top.busy.location="'.$this->frameset.'?pnt=busy&step=2";
			}

			self.focus();
		');

		array_push($parts,array("headline"=>"","html"=>we_forms::radiobutton("import_server", true, "import_from", $l_backup["import_from_server"]),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::radiobutton("import_upload", false, "import_from", $l_backup["import_from_local"]),"space"=>0,"noline"=>1));

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody", "onLoad"=>"startStep();"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
							we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"body")).
							we_htmlElement::htmlHidden(array("name"=>"step","value"=>"3")).
							we_multiIconBox::getHTML("backup_options", "100%", $parts, 30, "", -1,"","",false,$l_backup["step2"])
						)
					)
		);

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title"],$head);
		$head=$head."\n" . STYLESHEET . "\n".$js;

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}

 	function  getHTMLRecoverStep3(){

 		global $l_backup;
		if(isset($_SESSION['weBackupVars'])){
			// workaround for php bug #18071
			// bug: session has been restarted
			$_SESSION['weBackupVars'] = array();
			// workaround end
			unset($_SESSION['weBackupVars']);
		}
		$we_button=new we_button();
		$parts=array();

		$js="";

		$maxsize = getUploadMaxFilesize();

		if (isset($_REQUEST["import_from"]) && $_REQUEST["import_from"]=="import_upload") {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");
			if($maxsize){
				array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["charset_warning"], 1, 600, false),"space"=>0,"noline"=>1));
				array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox(sprintf($l_newFile["max_possible_size"],round($maxsize / (1024*1024),3)."MB"),1,600),"space"=>0,"noline"=>1));
				array_push($parts,array("headline"=>"","html"=>we_htmlElement::htmlInput(array("name"=>"we_upload_file","type"=>"file","size"=>"35")),"space"=>0,"noline"=>1));
				array_push($parts,array("headline"=>"","html"=>getPixel(1,1),"space"=>0,"noline"=>1));
			}

		}
		else {

			$js='extra_files=new Array();
				extra_files_desc=new Array();
			';
			$select=new we_htmlSelect(array("name"=>"backup_select","size"=>"7","style"=>"width: 600px;"));

			$d = dir($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR);
			$files=array();
			$extra_files=array();
			while($entry=$d->read()) {
				if($entry!="." && $entry!=".." && $entry!="CVS" && $entry!="download" && $entry!="tmp" && !@is_dir($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR . $entry)) {
					$filename=$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."/".$entry;
					$filesize=round(filesize($filename)/1024,2);
					$filedate=date("d.m.Y H:i:s.",filemtime($filename));
					if(ereg('^weBackup_',$entry)) {
						$ts=ereg_replace('^weBackup_',"",$entry);
						$ts=ereg_replace('.php',"",$ts);
						$ts=ereg_replace('.xml',"",$ts);
						$ts=ereg_replace('.gz',"",$ts);
						$ts=ereg_replace('.bz',"",$ts);
						$ts=ereg_replace('.zip',"",$ts);

						if(is_numeric($ts) || (substr_count($ts, '_') == 6)) {

							if (!($ts<1004569200)) {
								$comp=weFile::getCompression($entry);
								$files[$entry]=$l_backup["backup_form"].date("d.m.Y H:i:s",$ts).($comp && $comp!="none" ? " ($comp)" : "")." ".$filesize." KB";
							} else if ((substr_count($ts, '_') == 6)) {
								$comp=weFile::getCompression($entry);
								$_dateParts = explode('__', $ts);
								$_date = explode('_', $_dateParts[0]);
								$_date = array_reverse($_date);
								$files[$entry]=$l_backup["backup_form"] . ( implode('.', $_date) .  ' ' . implode(':', explode('_', $_dateParts[1])) ) . ($comp && $comp!="none" ? " ($comp)" : "")." ".$filesize." KB";
							} else {
								$extra_files[$entry]=$entry." $filedate $filesize KB";
							}
						}
						else {
							$extra_files[$entry]=$entry." $filedate $filesize KB";
						}
					}
					else {
						$extra_files[$entry]=$entry." $filedate $filesize KB";
					}
				}
			}
			$d->close();

			krsort($files);
			asort($extra_files);
			$i=0;

			/*foreach($files as $fk=>$fv)	$select->addOption($fk,$fv);*/


			$default = we_htmlSelect::getNewOptionGroup(array('style'=>'font-weight: bold; font-style: normal; color: darkblue;','label'=>$l_backup['we_backups']));
			$other = we_htmlSelect::getNewOptionGroup(array('style'=>'font-weight: bold; font-style: normal; color: darkblue;','label'=>$l_backup['other_files']));

			foreach($files as $fk=>$fv) {
				if(strlen($fv)>75){
					$fv = addslashes(substr($fv,0,65) . '...' . substr($fv,-10));
				}
				$default->addChild(we_htmlSelect::getNewOption($fk,$fv));
			}
			foreach($extra_files as $fk=>$fv) {
				if(strlen($fv)>75){
					$fv = addslashes(substr($fv,0,65) . '...' . substr($fv,-10));
				}
				$other->addChild(we_htmlSelect::getNewOption($fk,$fv));
			}

			$select->addChild($default);
			$select->addChild($other);

			foreach($extra_files as $fk=>$fv){
				$js.='extra_files["'.$i.'"]="'.$fk.'";
						extra_files_desc["'.$i.'"]="'.$fv.'"
				';
				$i++;
			}

			array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["charset_warning"], 1, 600, false),"space"=>0,"noline"=>1));
			array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["select_server_file"], 2, 600, false),"space"=>0,"noline"=>1));
			array_push($parts,array("headline"=>"","html"=>$select->getHtmlCode(),"space"=>0,"noline"=>1));
			//array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "show_all", $l_backup["show_all"], false, "defaultfont", "showAll()"),"space"=>0,"noline"=>1));
			array_push($parts,array("headline"=>"","html"=> $we_button->create_button("delete_backup", "javascript:delSelected();",true,100,22,'','',false,false),"space"=>0));
		}

		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, "rebuild", $l_backup["rebuild"], false),"space"=>0));

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["delold_notice"], 3, 600, false),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>$we_button->create_button("delete", "javascript:delOldFiles();",true,100,22,'','',false,false),"space"=>0));

		$form_properties=array(
					10=>"handle_core",
					14=>"handle_binary",
					100=>"handle_settings",
					101=>"handle_temporary",
					300=>"handle_extern",
					320=>"backup_log"					
		);

		if (defined("OBJECT_TABLE")) $form_properties[11]="handle_object";
		$form_properties[20]="handle_user";
		if (defined("CUSTOMER_TABLE")) $form_properties[25]="handle_customer";
		if (defined("SHOP_TABLE")) $form_properties[30]="handle_shop";
		if (defined("WORKFLOW_TABLE")) $form_properties[35]="handle_workflow";
		if (defined("MESSAGING_SYSTEM")) $form_properties[40]="handle_todo";
		if (defined("NEWSLETTER_TABLE")) $form_properties[45]="handle_newsletter";
		if (defined("BANNER_TABLE")) $form_properties[50]="handle_banner";
		if (defined("SCHEDULE_TABLE")) $form_properties[55]="handle_schedule";
		if (defined("EXPORT_TABLE")) $form_properties[60]="handle_export";
		if (defined("VOTING_TABLE")) $form_properties[65]="handle_voting";
		if (defined("SPELLCHECKER")) $form_properties[70]="handle_spellchecker";
		if (defined("GLOSSARY_TABLE")) $form_properties[75]="handle_glossary";
		$form_properties[12]="handle_versions";
		$form_properties[13]="handle_versions_binarys";

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolFrames.class.php');
		$i = 0;
		$_tools = weToolLookup::getToolsForBackup();
		foreach ($_tools as $_tool){
			$form_properties[700+$i]="handle_tool_" . $_tool;
			$i++;
		}
		
		ksort($form_properties);

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["import_options"], 2, 600, false),"space"=>70,"noline"=>1));

		$docheck="";
		$doclick="";
		$doclickall1="";
		$doclickall2="";
		foreach($form_properties as $k=>$v){
			$docheck.='
				case '.$k.':
					document.we_form.'.$v.'.checked=true;
					doClick('.$k.');
				break;
			';

			$doclick.='
				case '.$k.':
					var a=document.we_form.'.$v.';
				break;
			';
			if($k>2 && $k<101){
				array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, $v, $l_backup[str_replace("handle","import",$v)."_data"], false, "defaultfont", "doClick($k);"),"space"=>70,"noline"=>1));
				$doclickall1.="doCheck($k);";
			}
			else{
				$doclickall2.="doCheck($k);";
			}
		}

		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1,true, "handle_temporary", $l_backup["import_temporary_data"], false, "defaultfont", "doClick(101);"),"space"=>70,"noline"=>1));
		
		
		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["tools_import_desc"], 2, 600, false),"space"=>70,"noline"=>1));
		foreach ($_tools as $_tool) {
			include(weToolLookup::getLanguageInclude($_tool));
			if(isset(${'l_' . $_tool}["import_tool_" . $_tool . "_data"])) {
				$text = ${'l_' . $_tool}["import_tool_" . $_tool . "_data"];
			}
			else {
				include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');
				Zend_Loader::loadClass('we_core_Local');
				$translate = we_core_Local::addTranslation('apps.xml');
				we_core_Local::addTranslation('default.xml', $_tool);
				$text = $translate->_('Restore '. $_tool .' data');
			}
			array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, 'handle_tool_' . $_tool, $text, false, "defaultfont", "doClick($k);"),"space"=>70,"noline"=>1));
		}
		
		
		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["extern_exp"], 1, 600, false),"space"=>70,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "handle_extern", $l_backup["import_extern_data"], false, "defaultfont", "doClick(300);"),"space"=>70,"noline"=>1));

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["backup_log_exp"], 2, 600, false),"space"=>70,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "backup_log", $l_backup["export_backup_log"], false, "defaultfont", "doClick(320);"),"space"=>70,"noline"=>1));


		$js=we_htmlElement::jsElement($js);
		$js.=we_htmlElement::jsElement('',array("src"=>JS_DIR."windows.js"));
		$js.=weBackupWizard::getJSDep("import",$docheck,$doclick);
		$js.=we_htmlElement::jsElement($we_button->create_state_changer(false) .'

			function startBusy() {
				top.busy.location="'.$this->frameset.'?pnt=busy&operation_mode=busy&step=4";
			}

			function startImport() {

				var _usedEditors = top.opener.top.weEditorFrameController.getEditorsInUse();
				for (frameId in _usedEditors) {
					_usedEditors[frameId].setEditorIsHot( false );

				}
				top.opener.top.weEditorFrameController.closeAllDocuments();

				'.((isset($_REQUEST["import_from"]) && $_REQUEST["import_from"]=="import_upload") ? ('
				if(document.we_form.we_upload_file.value) {
					startBusy();
					top.body.delete_enabled = top.body.switch_button_state("delete", "delete_enabled", "disabled");
					document.we_form.action = "/webEdition/we/include/we_editors/we_backup_cmd.php";
					setTimeout("document.we_form.submit()",100);
				}
				else
					' . we_message_reporting::getShowMessageCall($l_backup["nothing_selected"], WE_MESSAGE_WARNING) . '
				') : ('
				if(document.we_form.backup_select.value) {
					startBusy();
					top.body.delete_backup_enabled = top.body.switch_button_state("delete_backup", "delete_backup_enabled", "disabled");
					top.body.delete_enabled = top.body.switch_button_state("delete", "delete_enabled", "disabled");
					document.we_form.action = "/webEdition/we/include/we_editors/we_backup_cmd.php";
					setTimeout("document.we_form.submit()",100);
				}
				else
					' . we_message_reporting::getShowMessageCall($l_backup["nothing_selected_fromlist"], WE_MESSAGE_WARNING) . '
				')).'
			}

			function showAll() {
				var a=document.we_form.backup_select.options;
				var b=document.we_form.show_all;

				if(b.checked){
					b.value=1;
					for(i=0;i<extra_files.length;i++)
						a[a.length]=new Option(extra_files_desc[i],extra_files[i]);
				}
				else {
					b.value=0;
					for(i=a.length-1;i>-1;i--)
						for(j=extra_files.length-1;j>-1;j--)
							if(a[i].value==extra_files[j]) {
								a[i]=null;
								break;
							}
					}
				}

				function delOldFiles(){
					if(confirm("'.$l_backup["delold_confirm"].'")) top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=deleteall";
				}

				function startStep(){
					top.busy.location="'.$this->frameset.'?pnt=busy&step=3";
				}

				function delSelected(){
					var sel = document.we_form.backup_select;
					if(sel.selectedIndex>-1){
						if(confirm("'.$l_backup["del_backup_confirm"].'")) top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=deletebackup&bfile="+sel.options[sel.selectedIndex].value;
					} else {
						' . we_message_reporting::getShowMessageCall($l_backup["nothing_selected_fromlist"], WE_MESSAGE_WARNING) . '
					}
				}

				function delSelItem(){
					var sel = document.we_form.backup_select;
					if(sel.selectedIndex>-1){
						sel.remove(sel.selectedIndex);
					}
				}

				self.focus();
		');

		if((isset($_REQUEST["import_from"]) && $_REQUEST["import_from"]=="import_upload")) $form_attribs=array("name"=>"we_form","method"=>"post","action"=>$this->frameset,"target"=>"cmd","enctype"=>"multipart/form-data");
		else $form_attribs=array("name"=>"we_form","method"=>"post","action"=>$this->frameset,"target"=>"cmd");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onLoad"=>"startStep();"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm($form_attribs,
							we_htmlelement::htmlHidden(array("name"=>"pnt","value"=>"cmd")).
							we_htmlelement::htmlHidden(array("name"=>"cmd","value"=>"import")).
							we_htmlelement::htmlHidden(array("name"=>"step","value"=>"3")).
							we_htmlelement::htmlHidden(array("name"=>"MAX_FILE_SIZE","value"=>$maxsize)).
							we_htmlelement::htmlInput(array("type"=>"hidden","name"=>"operation_mode","value"=>"import")).
							we_multiIconBox::getJS().
							we_multiIconBox::getHTML("backup_options", "100%", $parts, 30, "", 7,$l_backup["recover_option"], "<b>".$l_backup["recover_option"]."</b>",false,$l_backup["step3"])
						)
					)
		);

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title"],$head);
		$head=$head."\n" . STYLESHEET . "\n".$js;

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}


	function getHTMLRecoverStep4(){
		global $l_backup;


		$parts=array();

		if(isset($_SESSION['weBackupVars'])){
			// workaround for php bug #18071
			// bug: session has been restarted
			$_SESSION['weBackupVars'] = array();
			// workaround end
			unset($_SESSION['weBackupVars']);
		}

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["finished_success"],2,600),"space"=>0,"noline"=>1));

		$js=we_htmlElement::jsElement('
			function stopBusy() {
				top.busy.location="'.$this->frameset.'?pnt=busy&step=5";
				if(top.opener.top.header)
					top.opener.top.header.document.location.reload();
 			}
			self.focus();
		');

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>"stopBusy()"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","enctype"=>"multipart/form-data"),
							we_multiIconBox::getHTML("backup_options", "100%", $parts, 34, "", -1,"","",false,$l_backup["step3"])
						)
					)
		);

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title"],$head);
		$head=$head."\n" . STYLESHEET . $js . "\n";

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

	}


 	function  getHTMLBackupStep1(){
 		global $l_backup,$l_export;

 		if(isset($_SESSION['weBackupVars'])) {
			// workaround for php bug #18071
			// bug: session has been restarted
			$_SESSION['weBackupVars'] = array();
			// workaround end
 			unset($_SESSION['weBackupVars']);
 		}

 		$parts = array();
		$form_properties=array(
					1=>"export_server",
					2=>"export_send",
					10=>"handle_core",
					14=>"handle_binary",
					100=>"handle_settings",
					101=>"handle_temporary",
					300=>"handle_extern",
					320=>"backup_log"
		);

		if (defined("OBJECT_TABLE")) $form_properties[11]="handle_object";
		$form_properties[20]="handle_user";
		if (defined("CUSTOMER_TABLE")) $form_properties[25]="handle_customer";
		if (defined("SHOP_TABLE")) $form_properties[30]="handle_shop";
		if (defined("WORKFLOW_TABLE")) $form_properties[35]="handle_workflow";
		if (defined("MESSAGING_SYSTEM")) $form_properties[40]="handle_todo";
		if (defined("NEWSLETTER_TABLE")) $form_properties[45]="handle_newsletter";
		if (defined("BANNER_TABLE")) $form_properties[50]="handle_banner";
		if (defined("SCHEDULE_TABLE")) $form_properties[55]="handle_schedule";
		if (defined("EXPORT_TABLE")) $form_properties[60]="handle_export";
		if (defined("VOTING_TABLE")) $form_properties[65]="handle_voting";
		if (defined("SPELLCHECKER")) $form_properties[70]="handle_spellchecker";
		if (defined("GLOSSARY_TABLE")) $form_properties[75]="handle_glossary";
		$form_properties[12]="handle_versions";
		$form_properties[13]="handle_versions_binarys";

		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolFrames.class.php');
		$i = 0;
		$_tools = weToolLookup::getToolsForBackup();
		foreach ($_tools as $_tool){
			$form_properties[700+$i]="handle_tool_" . $_tool;
			$i++;
		}
		
		ksort($form_properties);

		$compression = weFile::hasCompression("gzip");

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox(($compression ? $l_backup["filename_compression"] : $l_backup["filename_info"]), 2, 600, false),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>$l_backup["filename"].":&nbsp;&nbsp;","html"=>htmlTextInput("filename",32,"weBackup_".date( "Y_m_d__H_i_s" ,time()).".xml","","","text",260),"space"=>100,"noline"=>1));

		$switchbut=7;
		if($compression){
			$switchbut=9;
			array_push($parts,array("headline"=>"","html"=>we_forms::checkbox("gzip", true, "compress", $l_backup["compress"], false, "defaultfont", "",false,$l_backup['ftp_hint']),"space"=>100));
		}


		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["protect_txt"], 2, 600, false),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, "protect", $l_backup["protect"], false, "defaultfont", ""),"space"=>70));

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["export_location"], 2, 600, false),"space"=>0,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, "export_server", $l_backup["export_location_server"], false, "defaultfont", "doClick(1)"),"space"=>70,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "export_send", $l_backup["export_location_send"], false, "defaultfont", "doClick(2)"),"space"=>70));
		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["export_options"], 2, 600, false),"space"=>0,"noline"=>1));

		$docheck="";
		$doclick="";
		$doclickall1="";
		$doclickall2="";
		foreach($form_properties as $k=>$v){
			$docheck.='
				case '.$k.':
					document.we_form.'.$v.'.checked=true;
					doClick('.$k.');
				break;
			';

			$doclick.='
				case '.$k.':
					var a=document.we_form.'.$v.';
				break;
			';
			if($k>2 && $k<101){
				if($v == "handle_versions_binarys") {
					$boxNr = 1;
					$checked = false;
				}
				else {
					$boxNr = 2;
					$checked = true;
				}
				array_push($parts,array("headline"=>"",
										"html"=>htmlAlertAttentionBox($l_backup[str_replace("handle_","",$v)."_info"], $boxNr, 600, false) .
												we_forms::checkbox(1, $checked, $v, $l_backup[str_replace("handle","export",$v)."_data"], false, "defaultfont", "doClick($k);"),
										"space"=>70,
										"noline"=>1
									)
				);
				$doclickall1.="doCheck($k);";
			}
			else{
				$doclickall2.="doCheck($k);";
			}
		}

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["tools_export_desc"], 2, 600, false),"space"=>70,"noline"=>1));
		$k = 700;
		foreach ($_tools as $_tool) {
			include(weToolLookup::getLanguageInclude($_tool));
			if(isset(${'l_' . $_tool}["export_tool_" . $_tool . "_data"])) {
				$text = ${'l_' . $_tool}["export_tool_" . $_tool . "_data"];
				
			}
			else {
				include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');
				Zend_Loader::loadClass('we_core_Local');
				$translate = we_core_Local::addTranslation('apps.xml');
				we_core_Local::addTranslation('default.xml', $_tool);
				$text = $translate->_('Save '. $_tool .' data');
			}
			array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, true, 'handle_tool_' . $_tool, $text, false, "defaultfont", "doClick($k);"),"space"=>70,"noline"=>1));
			$k++;
		}
		
		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["temporary_info"], 2, 600, false).we_forms::checkbox(1, true, "handle_temporary", $l_backup["export_temporary_data"], false, "defaultfont", "doClick(101);"),"space"=>70));
		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["extern_exp"], 1, 600, false),"space"=>70,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "handle_extern", $l_backup["export_extern_data"], false, "defaultfont", "doClick(300);"),"space"=>70,"noline"=>1));

		array_push($parts,array("headline"=>"","html"=>htmlAlertAttentionBox($l_backup["backup_log_exp"], 2, 600, false),"space"=>70,"noline"=>1));
		array_push($parts,array("headline"=>"","html"=>we_forms::checkbox(1, false, "backup_log", $l_backup["export_backup_log"], false, "defaultfont", "doClick(320);"),"space"=>70,"noline"=>1));


		$mode="export";
		$js=we_htmlElement::jsElement('',array("src"=>JS_DIR."windows.js"));
		$js.=weBackupWizard::getJSDep("export",$docheck,$doclick);
		$js.=we_htmlElement::jsElement('
			function startStep(){
				self.focus();
				top.busy.location="'.$this->frameset.'?pnt=busy&step=1";
			}
		');

		$_edit_cookie = weGetCookieVariable("but_edit_image");

		$body=we_htmlElement::htmlBody(array("class"=>"weDialogBody","onload"=>"startStep()"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post",'onsubmit'=>'return false;'),
							we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"cmd")).
							we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"export")).
							we_htmlElement::htmlHidden(array("name"=>"operation_mode","value"=>"backup")).
							we_htmlElement::htmlHidden(array("name"=>"do_import_after_backup","value"=>((isset($_REQUEST["do_import_after_backup"]) && $_REQUEST["do_import_after_backup"]) ? 1 : 0))).
							we_multiIconBox::getJS() .
							we_multiIconBox::getHTML("backup_options1", 580, $parts, 30,"", $switchbut,$l_backup["option"], "<b>".$l_backup["option"]."</b>", $_edit_cookie != false ? ($_edit_cookie == "down") : $_edit_cookie,$l_backup["export_step1"])
						)
					)
		);

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title_export"],$head);
		$head=$head."\n" . STYLESHEET . $js . "\n";

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}


 	function  getHTMLBackupStep2(){
 		global $l_backup;

		$ok=true;
		$content="";

		$table = new we_htmlTable(array('cellpadding' => 0, 'cellspacing' => 0, 'border' => 0, 'class' => 'defaultfont'), 4, 1);

		$table->setCol(0, 0, null, $l_backup['finish']);
		$table->setCol(1, 0, null, getPixel(5,20));

		if($_SESSION['weBackupVars']['options']['export2send']) {
			$_down=$_SESSION['weBackupVars']['backup_file'];
			if(is_file($_SESSION['weBackupVars']['backup_file'])) {

				$_php_version = phpversion();

				// automatic file download does not work for IE, also problems on strato account
				//if( 1 || ini_get('safe_mode') || eregi('4.2.4-dev',$_php_version) || eregi('4.1.1',$_php_version) || eregi('5.0.1',$_php_version) || eregi('5.0.4',$_php_version) ) {

					include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');

					$_link = weBackupUtil::getHttpLink(
												SERVER_NAME,
												str_replace($_SERVER['DOCUMENT_ROOT'],'',$_down),
												(defined('HTTP_PORT') ? HTTP_PORT : 80),
												(defined('HTTP_USERNAME') ? HTTP_USERNAME : ''),
												(defined('HTTP_PASSWORD') ? HTTP_PASSWORD : '')
					);


					include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weBrowser.class.php');

					$table->setCol(2, 0,array('class'=>'defaultfont'),
						weBrowser::getDownloadLinkText() . '<br><br>' .
						we_htmlElement::htmlA(array('href'=>$_link),$l_backup['download_file'])
					);

				/*} else {

					//print we_htmlElement::htmlMeta(array('http-equiv' => 'refresh', 'content' => '2; URL='.$this->frameset.'?pnt=body&step=3&backupfile='.urlencode($_down)));
					$table->setCol(2, 0, null,
						$l_backup['download_starting'].
						we_htmlElement::htmlA(array('href'=>$this->frameset.'?pnt=body&step=3&backupfile='.urlencode($_down)),$l_backup['download'])
					);

				}*/

			} else {
				$table->setCol(2, 0, null,$l_backup['download_failed']);
			}
		}


		$table->setCol(3, 0, null,getPixel(5,5));

		$content.=$table->getHtmlCode();

		$do_import_after_backup = (isset($_SESSION['weBackupVars']['options']['do_import_after_backup']) && $_SESSION['weBackupVars']['options']['do_import_after_backup']) ? 1 : 0;
		$js=we_htmlElement::jsElement('
			function startStep(){
				self.focus();
				top.busy.location="'.$this->frameset.'?pnt=busy&do_import_after_backup='.$do_import_after_backup.'&step=3";
			}
		');

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title_export"],$head);
		$head=$head."\n" . STYLESHEET . "\n" . $js;
		$body=we_htmlElement::htmlBody(array('class'=>'weDialogBody','onLoad'=>'startStep();'),
			we_htmlElement::htmlCenter(
				we_htmlElement::htmlForm(array('name'=>'we_form','method'=>'post'),
					htmlDialogLayout($content,$l_backup['export_step2'])
				)
			)
		);

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead($head).
			$body
		);
 	}


 	function  getHTMLBackupStep3(){
 		global $l_backup;
 		@set_time_limit(0);
		if (isset($_GET["backupfile"])) {
			$_filename = urldecode($_GET["backupfile"]);

			if (file_exists($_filename) && eregi($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR,$_filename)){				// Does file exist and does it saved in backup dir?
				$_size = filesize($_filename);

				if (we_isHttps()) {																		// Additional headers to make downloads work using IE in HTTPS mode.
					header("Pragma: ");
					header("Cache-Control: ");
					header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");									// HTTP 1.1
					header("Cache-Control: post-check=0, pre-check=0", false);
				} else {
					header("Cache-control: private");
				}

				header("Content-Type: application/force-download");
				header("Content-Disposition: attachment; filename=\"" . trim(htmlentities(basename($_filename))) . "\"");
				header("Content-Description: " . trim(htmlentities(basename($_filename))));
				header("Content-Length: " . $_size);


				//$_filehandler = readfile($_filename);

				$_filehandler = fopen($_filename, 'rb');
				if($_filehandler){
					while(!feof($_filehandler) ){
						print(fread($_filehandler, 8192));
						flush();
					}
					fclose($_filehandler);
				} else {
					print $this->build_error_message();
				}

			} else {
				print $this->build_error_message();
			}
		} else {
			print $this->build_error_message();
		}

		if(	isset($_SESSION['weBackupVars']['backup_file']) && isset($_SESSION['weBackupVars']['options']['export2server']) &&
			is_file($_SESSION['weBackupVars']['backup_file']) && $_SESSION['weBackupVars']['options']['export2server']!=1) {

				insertIntoCleanUp($_SESSION['weBackupVars']['backup_file'],time());

		}

		if(isset($_SESSION['weBackupVars'])) {
			// workaround for php bug #18071
			// bug: session has been restarted
			$_SESSION['weBackupVars'] = array();
			// workaround end
			unset($_SESSION['weBackupVars']);
		}

 	}

	function build_error_message() {
		global $l_backup;

		$_header = getHtmlTop() . STYLESHEET;

		$_error_message = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0, "class" => "defaultfont"), 1, 1);
		$_error_message->setCol(0, 0, null, $l_backup["download_failed"]);

		return $_header . '<body class="weDialogBody">' . we_htmlElement::htmlCenter(htmlDialogLayout($_error_message->getHtmlCode(), $l_backup["export_step2"]));
	}

 	function getHTMLExtern(){
 		global $l_backup;


		$w = $_REQUEST["w"] ? $_REQUEST["w"] : "exp";

		$txt = $l_backup["extern_backup_question_".$w];

		$yesCmd = "self.close();";
		$noCmd = "top.opener.top.body.clearExtern();".$yesCmd;

		$js=we_htmlElement::jsElement('
				self.focus();
		');

		$body=we_htmlElement::htmlBody(array("class"=>"weEditorBody","onBlur"=>"self.focus()","onload"=>"self.focus();"),
					we_htmlElement::htmlCenter(
						we_htmlElement::htmlForm(array("name"=>"we_form"),
							htmlYesNoCancelDialog($txt, IMAGE_DIR . "alert.gif", "ja", "nein", "", $yesCmd, $noCmd)
						)
					)
		);

		$head=WE_DEFAULT_HEAD;
		$head=str_replace(WE_DEFAULT_TITLE,$l_backup["wizard_title"],$head);
		$head=$head . "\n" .	STYLESHEET . $js . "\n";

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}

 	function  getHTMLBusy(){
		global $l_backup;
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_progressBar.inc.php");

		$head=WE_DEFAULT_HEAD."\n" . STYLESHEET . "\n";
		$body="";

		$table=new we_htmlTable(array("border"=>"0","align"=>"right","cellpadding"=>"0","cellspacing"=>"0"),2,4);
		$table->setCol(0,0,null,getPixel(15,5));

		if (isset($_REQUEST["operation_mode"])) {
				if($_REQUEST["operation_mode"]=="busy"){
						$text="";
						$progress="";

						if (isset($_REQUEST["current_description"]) && $_REQUEST["current_description"]) {
							$text=$_REQUEST["current_description"];
						} else {
							$text=$l_backup["working"];
						}

						if (isset($_REQUEST["percent"]) && $_REQUEST["percent"]) {
							$progress = $_REQUEST["percent"];
						} else {
							$progress = 0;
						}

						$ver = getMysqlVer();
						if ($ver >= 3230) {
							$progress=new we_progressBar($progress);
							$progress->setStudLen(200);
							$progress->addText($text,0,"current_description");
							$head.=$progress->getJSCode();
							$body.=$progress->getHtml();

						} else {
							$head.=we_htmlElement::jsElement('
									function setProgressText(name,text){
									}
									function setProgress(progress){
									}
							');
							$body.=we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."busy.gif"));
						}
						$table->setCol(0,1,null,$body);
						$table->setCol(1,1,null,getPixel(250,1));
				}
			}

			$step=isset($_REQUEST["step"]) ? $_REQUEST["step"] : 0;
			$we_button = new we_button();

			if($this->mode==1){
				switch($step){
					case 1:
						$head.=we_htmlElement::jsElement('
								function doExport() {
									if((!top.body.document.we_form.export_send.checked) && (!top.body.document.we_form.export_server.checked)) {
										' . we_message_reporting::getShowMessageCall($l_backup["save_not_checked"], WE_MESSAGE_WARNING) . '
									}
									else {
										top.busy.location="'.$this->frameset.'?pnt=busy&operation_mode=busy&step=2";
										top.body.we_submitForm("cmd","/webEdition/we/include/we_editors/we_backup_cmd.php");
									}
								}
						');
						$table->setCol(0,2,null,getPixel(355,5));
						$table->setCol(0,3,null,$we_button->position_yes_no_cancel($we_button->create_button("make_backup", "javascript:doExport();"),null,$we_button->create_button("cancel", "javascript:top.close();")));
					break;
					case 2:
						$table->setCol(0,2,null,getPixel(265,5));
						$table->setCol(0,3,null,$we_button->create_button("cancel", "javascript:top.close();"));
					break;
					case 3:
						$do_import_after_backup = (isset($_REQUEST["do_import_after_backup"]) && $_REQUEST["do_import_after_backup"]) ? 1 : 0;
						if ($do_import_after_backup == 1) {
							$body=$we_button->create_button("next", "javascript:top.body.location='/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2';top.busy.location='/webEdition/we/include/we_editors/we_recover_backup.php?pnt=cmd';top.cmd.location='/webEdition/we/include/we_editors/we_recover_backup.php?pnt=busy';");
							//$body=$we_button->create_button("next", "javascript:top.body.location='/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2';javascript:top.busy.location='/webEdition/we/include/we_editors/we_recover_backup.php?pnt=cmd';javascript:top.cmd.location='/webEdition/we/include/we_exim/we_backup_cmd.inc.php?cmd=import';");
						} else if (isset($_SESSION["inbackup"]) && $_SESSION["inbackup"]) {
							$body=$we_button->create_button("next", "javascript:top.opener.weiter();top.close();");
							unset($_SESSION["inbackup"]);
						}else{
							$head.=we_htmlElement::jsElement("<!--\ntop.opener.top.afterBackup=true;\n-->");
							$body=$we_button->create_button("close", "javascript:top.close();");
						}
						$table->setCol(0,2,null,getPixel(495,5));
						$table->setCol(0,3,null,$body);
					break;
					default:
				}
 			}

			if($this->mode==2){
				switch($step){
					case 1:
						$head .= "
						<script type=\"text/javascript\">

						function press_yes() {

							var _usedEditors = top.opener.top.weEditorFrameController.getEditorsInUse();
							var _unsavedChanges = false;
							for (frameId in _usedEditors) {
								if ( _usedEditors[frameId].getEditorIsHot() ) {
									_unsavedChanges = true;
								}
							}

							if (_unsavedChanges) {

								" . we_message_reporting::getShowMessageCall($l_backup["recover_backup_unsaved_changes"], WE_MESSAGE_WARNING) . "

							} else {
								top.body.location='/webEdition/we/include/we_editors/we_make_backup.php?pnt=body&do_import_after_backup=1';
								top.busy.location='/webEdition/we/include/we_editors/we_make_backup.php?pnt=busy';
								top.cmd.location='/webEdition/we/include/we_editors/we_make_backup.php?pnt=cmd';
							}

						}

						</script>";
						$buttons = $we_button->position_yes_no_cancel(
							$we_button->create_button("yes", "javascript:press_yes();"),
							$we_button->create_button("no", "javascript:top.body.location='".$this->frameset."?pnt=body&step=2';"),
							$we_button->create_button("cancel", "javascript:top.close();")
						);
						$table->setCol(0,2,null,getPixel(290,5));
						$table->setCol(0,3,null,$buttons);
					break;
					case 2:

						$nextbuts = $we_button->create_button_table(array(
												$we_button->create_button("back", "javascript:top.body.location='".$this->frameset."?pnt=body&step=1'", true),
												$we_button->create_button("next", "javascript:top.body.we_submitForm('body','".$this->frameset."');")));

						$buttons = $we_button->position_yes_no_cancel($nextbuts,null,$we_button->create_button("cancel", "javascript:top.close();"));

						$table->setCol(0,2,null,getPixel(290,5));
						$table->setCol(0,3,null,$buttons);
					break;
					case 3:
						if (defined("WORKFLOW_TABLE")) {
							include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
							if(count(weWorkflowUtility::getAllWorkflowDocs(FILE_TABLE))>0 || (defined("OBJECT_FILES_TABLE") && count(weWorkflowUtility::getAllWorkflowDocs(OBJECT_FILES_TABLE)))>0) {
								$nextbut = $we_button->create_button("restore_backup", "javascript:if(confirm('".$l_workflow["ask_before_recover"]."')) top.body.startImport();");
							} else {
								$nextbut = $we_button->create_button("restore_backup", "javascript:top.body.startImport();");
							}
						} else {
							$nextbut = $we_button->create_button("restore_backup", "javascript:top.body.startImport();");
						}
						$nextprevbuts = $we_button->create_button_table(array(
												$we_button->create_button("back", "javascript:top.body.location='".$this->frameset."?pnt=body&step=2';"),
												$nextbut));
						$buttons = $we_button->position_yes_no_cancel($nextprevbuts,null,$we_button->create_button("cancel", "javascript:top.close();"));


						$table->setCol(0,2,null,getPixel(240,5));
						$table->setCol(0,3,null,$buttons);
					break;
					case 4:
						$table->setCol(0,2,null,getPixel(260,5));
						$table->setCol(0,3,null,$we_button->create_button("cancel", "javascript:top.close();"));
					break;
					case 5:
						$table->setCol(0,2,null,getPixel(490,5));
						$table->setCol(0,3,null,$we_button->create_button("close", "javascript:top.close();"));
					break;
					default:


				}
 			}

			return we_htmlElement::htmlHtml(
						we_htmlElement::htmlHead($head).
						we_htmlElement::htmlBody(array("class"=>"weDialogButtonsBody"),
							$table->getHtmlCode()
						)
			);

 	}

 	function  getHTMLCmd(){
			global $l_backup, $l_global, $l_alert;
			if (isset($_REQUEST["operation_mode"])) {
				switch ($_REQUEST["operation_mode"]) {
					case "backup":
						if(!is_writable($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp")){
							print we_htmlElement::jsElement('
												top.busy.location="'.$this->frameset.'?pnt=busy";
												' . we_message_reporting::getShowMessageCall( sprintf($GLOBALS["l_backup"]["cannot_save_tmpfile"],BACKUP_DIR), WE_MESSAGE_ERROR) . '

							');
							return "";
						}

						$handle_options=array();

						$handle_options["user"] = (isset($_REQUEST["handle_user"]) && $_REQUEST["handle_user"]) ? 1 : 0;
						$handle_options["customer"] = (isset($_REQUEST["handle_customer"]) && $_REQUEST["handle_customer"]) ? 1 : 0;
						$handle_options["shop"] = (isset($_REQUEST["handle_shop"]) && $_REQUEST["handle_shop"]) ? 1 : 0;
						$handle_options["workflow"] = (isset($_REQUEST["handle_workflow"]) && $_REQUEST["handle_workflow"]) ? 1 : 0;
						$handle_options["todo"] = (isset($_REQUEST["handle_todo"]) && $_REQUEST["handle_todo"]) ? 1 : 0;
						$handle_options["newsletter"] = (isset($_REQUEST["handle_newsletter"]) && $_REQUEST["handle_newsletter"]) ? 1 : 0;
						$handle_options["temporary"] = (isset($_REQUEST["handle_temporary"]) && $_REQUEST["handle_temporary"]) ? 1 : 0;
						$handle_options["banner"] = (isset($_REQUEST["handle_banner"]) && $_REQUEST["handle_banner"]) ? 1 : 0;
						$handle_options["core"] = (isset($_REQUEST["handle_core"]) && $_REQUEST["handle_core"]) ? 1 : 0;
						$handle_options["object"] = (isset($_REQUEST["handle_object"]) && $_REQUEST["handle_object"]) ? 1 : 0;
						$handle_options["schedule"] = (isset($_REQUEST["handle_schedule"]) && $_REQUEST["handle_schedule"]) ? 1 : 0;
						$handle_options["settings"] = (isset($_REQUEST["handle_settings"]) && $_REQUEST["handle_settings"]) ? 1 : 0;
						$handle_options["export"] = (isset($_REQUEST["handle_export"]) && $_REQUEST["handle_export"]) ? 1 : 0;
						$handle_options["voting"] = (isset($_REQUEST["handle_voting"]) && $_REQUEST["handle_voting"]) ? 1 : 0;

						$we_backup_obj=new weBackup($handle_options);
						$temp_filename = (isset($_REQUEST["temp_filename"]) && $_REQUEST["temp_filename"]) ? $_REQUEST["temp_filename"] : "";

						if (!$temp_filename) {
							$we_backup_obj->backup_extern = (isset($_REQUEST["handle_extern"]) && $_REQUEST["handle_extern"]) ? 1 : 0;
							$we_backup_obj->export2server = (isset($_REQUEST["export_server"]) && $_REQUEST["export_server"]) ? 1 : 0;
							$we_backup_obj->export2send = (isset($_REQUEST["export_send"]) && $_REQUEST["export_send"]) ? 1 : 0;
							$we_backup_obj->filename = getRequestVar("filename","weBackup_".time().".xml");
							$we_backup_obj->compress = (isset($_REQUEST["compress"]) && $_REQUEST["compress"]) ? $_REQUEST["compress"] : "none";
							$we_backup_obj->backup_steps = getPref("BACKUP_STEPS");
							if($we_backup_obj->backup_steps == 0) $we_backup_obj->backup_steps=$this->getAutoSteps();
							$we_backup_obj->backup_binary = (isset($_REQUEST["handle_binary"]) && $_REQUEST["handle_binary"]) ? 1 : 0;

							//create file list
							if($we_backup_obj->backup_extern) $we_backup_obj->getFileList();
							//create table list
							//$we_backup_obj->getTableList();

						} else {
							$temp_filename = $we_backup_obj->restoreState($temp_filename);
							$we_backup_obj->setDescriptions();
						}

						$ret = $we_backup_obj->makeBackup();
						$temp_filename = $we_backup_obj->saveState($temp_filename);

						$do_import_after_backup = (isset($_REQUEST["do_import_after_backup"]) && $_REQUEST["do_import_after_backup"]) ? 1 : 0;

						if ($ret == 1) {
							$percent=$we_backup_obj->getExportPercent();
							print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$we_backup_obj->current_description.'");
										if(top.busy.setProgress) top.busy.setProgress('.$percent.');
										top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=backup&do_import_after_backup=' . $do_import_after_backup . '&temp_filename=' . $temp_filename . '";
									')."\n";
						} else if ($ret==-1) {
							print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["finished"].'");
										if(top.busy.setProgress) top.busy.setProgress(100);
										top.body.location="'.$this->frameset.'?pnt=body&step=2&ok=false&do_import_after_backup=' . $do_import_after_backup . '&temp_filename=' . $temp_filename . '";
									')."\n";
						} else {
							$we_backup_obj->writeFooter();
							$ok = $we_backup_obj->printDump2BackupDir();
							$temp_filename = $we_backup_obj->saveState($temp_filename);
							if ($ok) {
								print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["finished"].'");
										if(top.busy.setProgress) top.busy.setProgress(100);
										top.body.location="'.$this->frameset.'?pnt=body&step=2&ok=true&do_import_after_backup=' . $do_import_after_backup . '&temp_filename=' . $temp_filename . '";
									')."\n";
							} else {
								print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["finished"].'");
										if(top.busy.setProgress) top.busy.setProgress(100);
										top.body.location="'.$this->frameset.'?pnt=body&step=2&ok=false&do_import_after_backup=' . $do_import_after_backup . '&temp_filename=' . $temp_filename . '";
									')."\n";
							}
						}
						unset($we_backup_obj);
					break;
					case "rebuild":
						print we_htmlElement::jsElement('
							top.opener.top.openWindow("'.WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_all&responseText='.$l_backup["finished_success"].'","rebuildwin",-1,-1,600,130,0,true);
							setTimeout("top.close();",300);
						');
					break;
					case "import":
						if(!is_writable($_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp")){
							print we_htmlElement::jsElement('
												top.busy.location="'.$this->frameset.'?pnt=busy";
												' . we_message_reporting::getShowMessageCall( sprintf($GLOBALS["l_backup"]["cannot_save_tmpfile"],BACKUP_DIR), WE_MESSAGE_ERROR ) . '

							');
							return "";
						}

						$handle_options=array();
						$handle_options["user"] = (isset($_REQUEST["handle_user"]) && $_REQUEST["handle_user"]) ? 1 : 0;
						$handle_options["customer"] = (isset($_REQUEST["handle_customer"]) && $_REQUEST["handle_customer"]) ? 1 : 0;
						$handle_options["shop"] = (isset($_REQUEST["handle_shop"]) && $_REQUEST["handle_shop"]) ? 1 : 0;
						$handle_options["workflow"] = (isset($_REQUEST["handle_workflow"]) && $_REQUEST["handle_workflow"]) ? 1 : 0;
						$handle_options["todo"] = (isset($_REQUEST["handle_todo"]) && $_REQUEST["handle_todo"]) ? 1 : 0;
						$handle_options["newsletter"] = (isset($_REQUEST["handle_newsletter"]) && $_REQUEST["handle_newsletter"]) ? 1 : 0;
						$handle_options["temporary"] = (isset($_REQUEST["handle_temporary"]) && $_REQUEST["handle_temporary"]) ? 1 : 0;
						$handle_options["banner"] = (isset($_REQUEST["handle_banner"]) && $_REQUEST["handle_banner"]) ? 1 : 0;
						$handle_options["core"] = (isset($_REQUEST["handle_core"]) && $_REQUEST["handle_core"]) ? 1 : 0;
						$handle_options["object"] = (isset($_REQUEST["handle_object"]) && $_REQUEST["handle_object"]) ? 1 : 0;
						$handle_options["schedule"] = (isset($_REQUEST["handle_schedule"]) && $_REQUEST["handle_schedule"]) ? 1 : 0;
						$handle_options["settings"] = (isset($_REQUEST["handle_settings"]) && $_REQUEST["handle_settings"]) ? 1 : 0;
						$handle_options["export"] = (isset($_REQUEST["handle_export"]) && $_REQUEST["handle_export"]) ? 1 : 0;
						$handle_options["voting"] = (isset($_REQUEST["handle_voting"]) && $_REQUEST["handle_voting"]) ? 1 : 0;

						$we_backup_obj=new weBackup($handle_options);
						$temp_filename = (isset($_REQUEST["temp_filename"]) && $_REQUEST["temp_filename"]) ? $_REQUEST["temp_filename"] : "";

						if (!$temp_filename) {

							$we_backup_obj->backup_extern = (isset($_REQUEST["handle_extern"]) && $_REQUEST["handle_extern"]) ? 1 : 0;
							$we_backup_obj->compress = (isset($_REQUEST["compress"]) && $_REQUEST["compress"]) ? 1 : 0;
							$we_backup_obj->backup_steps = getPref("BACKUP_STEPS");
							if($we_backup_obj->backup_steps == 0) $we_backup_obj->backup_steps = $this->getAutoSteps();
							$we_backup_obj->backup_binary = (isset($_REQUEST["handle_binary"]) && $_REQUEST["handle_binary"]) ? 1 : 0;
							$we_backup_obj->rebuild = (isset($_REQUEST["rebuild"]) && $_REQUEST["rebuild"]) ? 1 : 0;

							$backup_select = (isset($_REQUEST["backup_select"]) && $_REQUEST["backup_select"]) ? $_REQUEST["backup_select"] : "";
							$we_upload_file = (isset($_FILES["we_upload_file"]) && $_FILES["we_upload_file"]) ? $_FILES["we_upload_file"] : "";
							$ok = false;

							if ($backup_select) {
								$we_backup_obj->filename = $_SERVER["DOCUMENT_ROOT"] . BACKUP_DIR . $backup_select;
								$ok = true;
							} else if ($we_upload_file && ($we_upload_file != "none")) {
								$we_backup_obj->filename = $_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp/".$_FILES["we_upload_file"]["name"];
								if(!move_uploaded_file($_FILES["we_upload_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"].BACKUP_DIR."tmp/".$_FILES["we_upload_file"]["name"])){
									print we_htmlElement::jsElement('
												top.busy.location="'.$this->frameset.'?pnt=busy";
												' . we_message_reporting::getShowMessageCall( sprintf($GLOBALS["l_backup"]["cannot_save_tmpfile"],BACKUP_DIR), WE_MESSAGE_ERROR ) . '

									');
									return "";
								}
								insertIntoCleanUp($we_backup_obj->filename, time());
								$ok = true;
							} else {
								$we_alerttext = sprintf($l_alert["we_backup_import_upload_err"], ini_get("upload_max_filesize"));
								print "\n".
									we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall($we_alerttext, WE_MESSAGE_ERROR)
									)."\n";
								$ok = false;
							}

							if($handle_options["core"]){
								$we_backup_obj->getSiteFiles();
							 	$we_backup_obj->getFileList($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/templates",true,false);
							}

							$we_backup_obj->getVersion($we_backup_obj->filename);
							$we_backup_obj->file_end = $we_backup_obj->splitFile2();
							if($we_backup_obj->file_end < 0){
								if($we_backup_obj->file_end==-10){
									print we_htmlElement::jsElement('
												top.busy.location="'.$this->frameset.'?pnt=busy";
												' . we_message_reporting::getShowMessageCall( sprintf($l_backup["cannot_split_file"],basename($we_backup_obj->filename)).$l_backup["cannot_split_file_ziped"],  WE_MESSAGE_ERROR ) . '

									');
								}
								else{
									print we_htmlElement::jsElement('
												top.busy.location="'.$this->frameset.'?pnt=busy";
												' . we_message_reporting::getShowMessageCall( sprintf($l_backup["cannot_split_file"],basename($we_backup_obj->filename)),  WE_MESSAGE_ERROR ) . '
									');
								}
								return "";
							}
							if($handle_options["core"]) $we_backup_obj->clearTemporaryData("tblFile");
							if($handle_options["object"]) $we_backup_obj->clearTemporaryData("tblObjectFiles");
						} else {
							$temp_filename = $we_backup_obj->restoreState($temp_filename);
							$we_backup_obj->setDescriptions();
						}

						if(count($we_backup_obj->file_list)){
							for($i=0;$i<$we_backup_obj->backup_steps;$i++){
								if(!count($we_backup_obj->file_list)) break;
								$file=array_pop($we_backup_obj->file_list);
								if(is_dir($file)) @rmdir($file);
								else @unlink($file);
							}
							$temp_filename = $we_backup_obj->saveState($temp_filename);
							$percent = $we_backup_obj->getImportPercent();
							print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["delete_old_files"].'");
										if(top.busy.setProgress) top.busy.setProgress('.$percent.');
										top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=import&temp_filename=' . $temp_filename . '";
							')."\n";

						}
						else if ($we_backup_obj->file_counter < $we_backup_obj->file_end) {
							$filename_tmp = $_SERVER["DOCUMENT_ROOT"] . BACKUP_DIR . "tmp/" . basename($we_backup_obj->filename) . "_" . $we_backup_obj->file_counter;
							$we_backup_obj->file_counter++;
							$ok = $we_backup_obj->restoreChunk($filename_tmp);
							$temp_filename = $we_backup_obj->saveState($temp_filename);
							@unlink($filename_tmp);

							if ($ok) {
								$percent = $we_backup_obj->getImportPercent();
								if($percent==100) $we_backup_obj->current_description=$l_backup["finished"];
								if($we_backup_obj->current_description=="") $we_backup_obj->current_description=$l_backup["working"];;

								print "\n".
									we_htmlElement::jsElement('
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$we_backup_obj->current_description.'");
										if(top.busy.setProgress) top.busy.setProgress('.$percent.');
										top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=import&temp_filename=' . $temp_filename . '";
								')."\n";

							} else {
									print "\n".
										we_htmlElement::jsElement('
											top.busy.location="'.$this->frameset.'?pnt=busy";
											top.body.location="'.$this->frameset.'?pnt=body&step=4&temp_filename='.$temp_filename.'";
									')."\n";
							}

						}
						else{
							$we_backup_obj->doUpdate();
							if(is_file($_SERVER["DOCUMENT_ROOT"] . BACKUP_DIR . "tmp/" .$temp_filename) && $we_backup_obj->rebuild && !count($we_backup_obj->errors)) unlink($_SERVER["DOCUMENT_ROOT"] . BACKUP_DIR . "tmp/" .$temp_filename);
							print "\n".
								we_htmlElement::jsElement('
								top.opener.top.we_cmd("load", "'.FILE_TABLE.'");
								top.opener.top.we_cmd("exit_delete");
								top.busy.location="'.$this->frameset.'?pnt=busy&operation_mode=busy&current_description=' . $l_backup["finished"] . '&percent=100";
								'.($we_backup_obj->rebuild && !count($we_backup_obj->errors) ? ('
									top.cmd.location="'.$this->frameset.'?pnt=cmd&operation_mode=rebuild";
								 ') : ('
								top.body.location="'.$this->frameset.'?pnt=body&step=4&temp_filename='.$temp_filename.'";
								')).'
							')."\n";

						}
					break;
					case "deleteall":
							$_SESSION["backup_delete"]=1;
							$_SESSION["delete_files_nok"]=array();
							$_SESSION["delete_files_info"]=$l_backup["files_not_deleted"];
							print we_htmlElement::jsElement('',array("src"=>JS_DIR."windows.js"));
							print we_htmlElement::jsElement('
									new jsWindow("'.WEBEDITION_DIR.'delFrag.php?currentID=-1","we_del",-1,-1,600,130,true,true,true);
							');
					break;
					case "deletebackup":
						$bfile = $_REQUEST["bfile"];
						if(ereg('\.\.',$bfile)) {
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($l_backup['name_notok'], WE_MESSAGE_ERROR)
							);
						} else {
							if(!is_writable($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . $bfile)) {
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($l_backup['error_delete'], WE_MESSAGE_ERROR));
							} else {
								if(unlink($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . $bfile)){
									print we_htmlElement::jsElement('
										if(top.body.delSelItem) top.body.delSelItem();
									');
								} else {
									print we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall($l_backup['error_delete'], WE_MESSAGE_ERROR)
									);
								}
							}
						}
					break;
					default:
							print "\n".
									we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall($l_backup['error'], WE_MESSAGE_ERROR)
									)."\n";
				}
			}
 	}

	function getParam($params){
		$out="";
		foreach($params as $k=>$v){
			$out.="&$k=$v";
		}
		return $out;
	}


#==============================================================================#

	/**
	 * Function: printErrors
	 *
	 * Description: This function tells the user, if and which error(s) took
	 * place.
	 */

	function printErrors(&$we_backup_obj) {
		global $l_backup;

		$errors = array();
		$errors = $we_backup_obj->getErrors();

		$text="";
		if (count($errors) > 0) {
			foreach ($errors as $k=>$v) {
				$text .= $l_backup["error"] . ' [' . ++$k . ']: ' . $v . "\n";
			}
		}
		else
			$text.=$l_backup["unspecified_error"];


		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0, "class" => "defaultfont"), 3, 1);
		$table->setCol(0, 0, null, $l_backup["finish_error"]);
		$table->setCol(1, 0, null, we_htmlElement::htmlTextArea(array("name"=>"text_errors","cols"=>"45","rows"=>"7"),$text));
		$table->setCol(2, 0, null, getPixel(400,5));
		return $table->getHtmlCode();

}

#==============================================================================#

	/**
	 * Function: printWarnings
	 *
	 * Description: This function tells the user, if and which warning(s)
	 * took place.
	 */


	function printWarnings(&$we_backup_obj) {
		global $l_backup;
		global $SYSTEM;
		global $BROWSER;

		$warnings = array();
		$warnings = $we_backup_obj->getWarnings();

		if (count($warnings) > 0) {

			foreach ($warnings as $k=>$v) {
				$text .= $l_backup["warning"] . ' [' . ++$k . ']: ' . $v . "\n";
			}

			$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0, "class" => "defaultfont"), 3, 1);
			$table->setCol(0, 0, null, $l_backup["finish_warning"]);
			$table->setCol(1, 0, null, we_htmlElement::htmlTextArea(array("name"=>"text_errors","cols"=>"45","rows"=>"7"),$text));
			$table->setCol(2, 0, null, getPixel(400,5));
			return $table->getHtmlCode();
		}
		return "";
	}

#==============================================================================#
	function getPerformanceBox(){
		global $l_backup;

		$weBackup=new weBackup();

		$perf=new we_htmlTable(array("border"=>"0","cellpadding"=>"2","cellspacing"=>"0"),3,5);
		$perf->setCol(0,0,array("class"=>"header_small"),$l_backup["slow"]);
		$perf->setCol(0,1,array(),getPixel(5,2));
		$perf->setCol(0,2,array("class"=>"header_small","align"=>"right"),$l_backup["fast"]);

		$steps=array(1,10,20,60,100,150,200,300,400,500,600,800,1000,5000,10000);
		$steps_code="";
		foreach($steps as $step){
			if($step==$weBackup->default_backup_steps)
				$steps_code.=we_htmlElement::htmlInput(array("type"=>"radio","value"=>"$step","name"=>"backup_steps","checked"=>true))."&nbsp;&nbsp;";
			else
				$steps_code.=we_htmlElement::htmlInput(array("type"=>"radio","value"=>"$step","name"=>"backup_steps"))."&nbsp;&nbsp;";
		}

		$perf->setCol(1,0,array("class"=>"defaultfont","colspan"=>3),$steps_code);

		return $perf->getHtmlCode();

	}

 	function getAutoSteps(){
		$i=0;
		$time = explode(" ",microtime());
		$time = $time[1] + $time[0];
		$start = $time;
		while($i<100000) $i++;
		$time = explode(" ",microtime());
		$time = $time[1] + $time[0];
		$end = $time;
		$total = $end-$start;
		$cpu=(100/($total*1000));
 		$met=ini_get('max_execution_time');
 		return floor($cpu*$met);
 	}

 	function getHTMLChecker() {
 		global $l_backup;

 		$_execute = ini_get('max_execution_time');
 		if(!$_execute) {
 			$_execute = 60;
 		}
 		$_execute = $_execute * 1500;

 		if($this->mode==RECOVER_MODE) {
 			$cmd = 'import';
 		} else {
 			$cmd = 'export';
 		}

 		$_retry = 5;

 		return we_htmlElement::jsElement('
 			var reload = 0;
 			function reloadFrame(){
 				top.cmd.location="/webEdition/we/include/we_editors/we_backup_cmd.php?cmd='.$cmd.'&reload=1";
 				reload++;
 				if(reload<'.$_retry.') {
 					setTimeout("reloadFrame()",'.$_execute.');
 				} else {
 					' . we_message_reporting::getShowMessageCall($l_backup['error_timeout'], WE_MESSAGE_ERROR) . '
 				}
 			}
 			setTimeout("reloadFrame()",'.$_execute.');
 		');

 	}


}

?>