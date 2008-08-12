<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//





include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSuggest.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/copy_folder.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_browser_check.inc.php");


class copyFolderFrag extends taskFragment{

	var $copyToPath="";

	function init(){
		$fromID = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] :  0;
		$toID = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] :  0;
		$CreateTemplate = isset($_REQUEST["CreateTemplate"]) ? $_REQUEST["CreateTemplate"] : false;
		$CreateDoctypes = isset($_REQUEST["CreateDoctypes"]) ? $_REQUEST["CreateDoctypes"] : false;
		$CreateTemplateInFolderID = isset($_REQUEST["CreateTemplateInFolderID"]) ? $_REQUEST["CreateTemplateInFolderID"] : 0;
		$OverwriteCategories = isset($_REQUEST["OverwriteCategories"]) ? $_REQUEST["OverwriteCategories"] : false;
		$newCategories = array();
		foreach ($_REQUEST as $name => $val) {
			if(!is_array($val)) {
				if(eregi("^me(.*)variant0_me(.*)_item", $name)) {
					$newCategories[] = path_to_id($val, CATEGORY_TABLE);
				}
			}
		}
		$newCategories = implode(",", $newCategories);


		if(isset($_SESSION["WE_CREATE_DOCTYPE"])){
			unset($_SESSION["WE_CREATE_DOCTYPE"]);
		}
		if(isset($_SESSION["WE_CREATE_TEMPLATE"])){
			unset($_SESSION["WE_CREATE_TEMPLATE"]);
		}
		if($fromID &&  $toID){
			//  "fromID"  cannot be a parent  of "toID"

			$fromPath = id_to_path($fromID);
			$db = new DB_WE();
			$this->alldata = array();

			// make it twice to be sure that all linked IDs are correct
			$db->query("SELECT ID,ParentID,Text,Path,IsFolder,ClassName,ContentType,Category FROM ".FILE_TABLE." WHERE (Path like'$fromPath/%') AND ContentType != 'text/webedition' ORDER BY IsFolder DESC,Path");
			while($db->next_record()){
				$db->Record["CopyToId"] = $toID;
				$db->Record["CopyFromId"] = $fromID;
				$db->Record["CopyFromPath"] = $fromPath;
				$db->Record["IsWeFile"] = 0;
				$db->Record["CreateTemplate"] = $CreateTemplate ? 1 : 0;
				$db->Record["CreateDoctypes"] = $CreateDoctypes ? 1 : 0;
				$db->Record["CreateTemplateInFolderID"] = $CreateTemplateInFolderID;
				$db->Record["OverwriteCategories"] = $OverwriteCategories;
				$db->Record["newCategories"] = $newCategories;
				array_push($this->alldata,$db->Record);
			}

			for($num=0;$num<2;$num++){
				$db->query("SELECT ID,ParentID,Text,TemplateID,Path,IsFolder,ClassName,ContentType,Category FROM ".FILE_TABLE." WHERE (Path like'$fromPath/%') AND ContentType = 'text/webedition' ORDER BY IsFolder DESC,Path");
				while($db->next_record()){

					// check if the template exists
					$TemplateExists = false;
					if($CreateTemplate) {
						$TemplateExists = (id_to_path($db->f('TemplateID'), TEMPLATES_TABLE)!=""?1:0);
					}

					$db->Record["CopyToId"] = $toID;
					$db->Record["CopyFromId"] = $fromID;
					$db->Record["CopyFromPath"] = $fromPath;
					$db->Record["IsWeFile"] = 1;
					$db->Record["num"] = $num;
					$db->Record["CreateTemplate"] = $CreateTemplate ? $TemplateExists : 0;
					$db->Record["CreateDoctypes"] = $CreateDoctypes ? 1 : 0;
					$db->Record["CreateTemplateInFolderID"] = $CreateTemplateInFolderID;
					$db->Record["OverwriteCategories"] = $OverwriteCategories;
					$db->Record["newCategories"] = $newCategories;
					array_push($this->alldata,$db->Record);
				}
			}

		}


	}

	function doTask(){
		if(is_array($this->data)){
			if($this->copyFile()){
				if($this->data["IsWeFile"] && $this->data["num"]){
					$pbText = (sprintf($GLOBALS["l_copyFolder"]["rewrite"], basename($this->data["Path"])));
				}else{
					$pbText = (sprintf($this->data["IsFolder"] ? $GLOBALS["l_copyFolder"]["copyFolder"] : $GLOBALS["l_copyFolder"]["copyFile"], basename($this->data["Path"])));
				}
				print '<script type="text/javascript">parent.document.getElementById("pbTd").style.display="block";parent.setProgress('.((int)((100/count($this->alldata))*(1+$this->currentTask))).');parent.setProgressText("pbar1","'.addslashes($pbText).'");</script>';
				flush();

			}else{
				exit("Error importing File: ".$this->data["Path"]);
			}
		}

	}

	function copyFile(){
		global $we_doc;

		$we_doc = $this->getDocument();
		$this->copyToPath = id_to_path($this->data["CopyToId"]);
		$path = ereg_replace('^'.$this->data["CopyFromPath"]."/",$this->copyToPath."/",$this->data["Path"]);
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/".$this->data["ClassName"].".inc.php");
		$we_doc = new $this->data["ClassName"];
		if($this->data["IsFolder"]){
			$we_doc->initByPath($path);
			if(!$we_doc->we_save()){
				return false;
			}
		}else{
			$we_doc->initByID($this->data["ID"]);
			// if file  exists the file will overwritten, if not a new one (with no id) will be created
			$we_doc->ID = f("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$path."'","ID",$GLOBALS["DB_WE"]);
			$we_doc->Path = $path;
			$we_doc->OldPath = "";
			$pid = $this->getPid($path,$GLOBALS["DB_WE"]);
			$we_doc->setParentID($pid);
			switch($we_doc->ContentType){
				case "text/webedition":
					$oldTemplateID = $we_doc->TemplateID;
					$this->parseWeDocument($we_doc);

					// check if we need to create a template
					if($this->data["CreateTemplate"]){
						$CreateMasterTemplate = isset($_REQUEST["CreateMasterTemplate"]) ? $_REQUEST["CreateTemplate"] : false;
						$CreateIncludedTemplate = isset($_REQUEST["CreateIncludedTemplate"]) ? $_REQUEST["CreateTemplate"] : false;
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_template.inc.php");
						// check if a template was created from prior doc
						if(!(isset($_SESSION["WE_CREATE_TEMPLATE"]) && isset($_SESSION["WE_CREATE_TEMPLATE"][$we_doc->TemplateID]))){

							$createdTemplate = $this->copyTemplate($we_doc->TemplateID,$this->data["CreateTemplateInFolderID"],$CreateMasterTemplate,$CreateIncludedTemplate);

						}

						$we_doc->setTemplateID($_SESSION["WE_CREATE_TEMPLATE"][$we_doc->TemplateID]);


					}

					if($this->data['OverwriteCategories']) {
						$we_doc->Category = $this->data['newCategories'];
					} else {
						// remove duplicates
						$old = explode(",", $we_doc->Category);
						$tmp = explode(",", $this->data['newCategories']);
						$new = array_unique(array_merge($old, $tmp));
						$we_doc->Category = implode(",", $new);
					}

					if($we_doc->DocType && $this->data["CreateDoctypes"]){
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_docTypes.inc.php");
						// check if a doctype was created from prior doc
						if(!(isset($_SESSION["WE_CREATE_DOCTYPE"]) && isset($_SESSION["WE_CREATE_DOCTYPE"][$we_doc->DocType]))){

							$dt = new we_docTypes();;
							$dt->initByID($we_doc->DocType,DOC_TYPES_TABLE);
							$dt->ID  = 0;
						    $dt->DocType =  $dt->DocType . "_copy";
						    // if file exists we need  to create a new one!
						    if($file_id = f("SELECT ID FROM ".DOC_TYPES_TABLE." WHERE DocType='".$dt->DocType."'","ID",$GLOBALS["DB_WE"])){
								$z=0;
								$footext = $dt->DocType."_".$z;
								while(f("SELECT ID FROM ".DOC_TYPES_TABLE." WHERE DocType='$footext'","ID",$GLOBALS["DB_WE"])){
									$z++;
									$footext = $dt->DocType."_".$z;
								}
								$dt->DocType = $footext;

							}
							$path =  id_to_path($dt->ParentID);
							if($this->mustChange($path)){
								$dt->ParentPath = $this->getNewPath($path);
								$dt->ParentID = $this->getID($dt->ParentPath,$GLOBALS["DB_WE"]);
							}

							if($dt->Templates){

								$templArray =  makeArrayFromCSV($dt->Templates);
								$newTemplateIDs = array();
								foreach($templArray as $id){
									if($id  == $oldTemplateID){
										array_push($newTemplateIDs,$we_doc->TemplateID);
									}else{
										array_push($newTemplateIDs,$id);
									}
								}
								$dt->Templates = makeCSVFromArray($newTemplateIDs);
								$dt->TemplateID = $we_doc->TemplateID;
							}

							$dt->we_save();
							$newID = $dt->ID;

							if(!isset($_SESSION["WE_CREATE_DOCTYPE"])){
								$_SESSION["WE_CREATE_DOCTYPE"] = array();
							}
							$_SESSION["WE_CREATE_DOCTYPE"][$we_doc->DocType] = $newID;

						}

						$we_doc->DocType =  $_SESSION["WE_CREATE_DOCTYPE"][$we_doc->DocType];

					}
					
					// bugfix 0001582
					$we_doc->OldPath = $we_doc->Path;
					break;
				case "text/html":
				case "text/plain":
				case "text/css":
				case "text/js":
					$this->parseTextDocument($we_doc);
					break;
			}
			
			if(!$we_doc->we_save()){
				return false;
			}

			if($we_doc->Published){
				if(!$we_doc->we_publish()){
					return false;
				}
			}
		}
		return true;
	}

	function copyTemplate($templateID, $parentID, $CreateMasterTemplate=false, $CreateIncludedTemplate=false, $counter=0) {
		$counter++;
		$templVars = array();
		if(!isset($_SESSION["WE_CREATE_TEMPLATE"])){
			$_SESSION["WE_CREATE_TEMPLATE"] = array();
		}
		if (!isset($_SESSION["WE_CREATE_TEMPLATE"][$templateID])) {

			$templ = new we_template();
			$templ->initByID($templateID,TEMPLATES_TABLE);
			$templ->ID  = 0;
			$templ->OldPath = "";
			$templ->setParentID($parentID);
		    $templ->Path=$templ->getParentPath().(($templ->getParentPath() != "/") ? "/" : "").$templ->Text;
		    // if file exists we need  to create a new one!
		    if($file_id = f("SELECT ID FROM ".TEMPLATES_TABLE." WHERE Path='".$templ->Path."'","ID",$GLOBALS["DB_WE"])){
				$z=0;
				$footext = $templ->Filename."_".$z.$templ->Extension;
				while(f("SELECT ID FROM ".TEMPLATES_TABLE." WHERE Text='$footext' AND ParentID='".$templ->ParentID."'","ID",$GLOBALS["DB_WE"])){
					$z++;
					$footext = $templ->Filename."_".$z.$templ->Extension;
				}
				$templ->Text = $footext;
				$templ->Filename = $templ->Filename."_".$z;
				$templ->Path=$templ->getParentPath().(($templ->getParentPath() != "/") ? "/" : "").$templ->Text;

			}
			$this->ParseTemplate($templ);
			$templ->we_save();
			$newID = $templ->ID;
			$templVars['newID'] = $newID;


			$_SESSION["WE_CREATE_TEMPLATE"][$templateID] = $newID;
			if($counter <10) {
				if ($CreateMasterTemplate && $templ->MasterTemplateID>0) {
					if (isset($_SESSION["WE_CREATE_TEMPLATE"][$templ->MasterTemplateID])) {
						$templ->MasterTemplateID = $_SESSION["WE_CREATE_TEMPLATE"][$templ->MasterTemplateID];
					} else {
						$createdMasterVars = $this->copyTemplate($templ->MasterTemplateID, $parentID, $CreateMasterTemplate, $CreateIncludedTemplate, $counter);
						$templ->MasterTemplateID = $createdMasterVars['newID'];
					}
					$templ->we_save();
				}
				if ($CreateIncludedTemplate && !empty($templ->IncludedTemplates)) {
					$includedTemplates = explode(",", $templ->IncludedTemplates);
					$code = $templ->elements['data']['dat'];
					foreach ($includedTemplates as $incTempl) {
						if (!empty($incTempl) && $incTempl > 0) {
							if (isset($_SESSION["WE_CREATE_TEMPLATE"][trim($incTempl)])) {
								$templID = str_replace($incTempl, $_SESSION["WE_CREATE_TEMPLATE"][trim($incTempl)],$templ->IncludedTemplates);
								$newTemplId = $_SESSION["WE_CREATE_TEMPLATE"][trim($incTempl)];
							} else {
								$createdIncVars = $this->copyTemplate(trim($incTempl), $parentID, $CreateMasterTemplate, $CreateIncludedTemplate, $counter);
								$templID = str_replace($incTempl, $createdIncVars['newID'],$templ->IncludedTemplates);
								$newTemplId = $createdIncVars['newID'];
							}
							$tp = new we_tagParser();
							$tags = $tp->getAllTags($code);
							foreach($tags as $tag) {
								$regs = array();
								$xid = 0;
								if (preg_match('|^<we:include ([^>]+)>$|i',$tag,$regs)) {
									if (preg_match('|type *= *" *template *"|i', $regs[1])) {
										$foo = array();

										$attributes = $regs[1];

										preg_match_all('/([^=]+)= *("[^"]*")/', $attributes, $foo, PREG_PATTERN_ORDER);
										foreach ($foo[1] as $k=>$v) {
											if (trim($v) == "id") {
												$xid = abs(str_replace('"','',$foo[2][$k]));
												break;
											}
										}
										if ($xid == $incTempl) {
											$newtag = preg_replace('|id *= *" *'.$xid.' *"|i','id="'.$newTemplId.'"',$tag);
											$code = str_replace($tag, $newtag, $code);
										}

									}
								}
							}
						}
					}
					$templ->elements['data']['dat'] = $code;
					$templ->we_save();
				}
			}
		}
		return $templVars;
	}

	function ParseTemplate(&$we_doc){
		// parse hard  coded  links in template  :TODO: check for ="/Path ='Path and =Path
		$we_doc->elements["data"]["dat"] = str_replace($this->data["CopyFromPath"]."/",$this->copyToPath."/",$we_doc->elements["data"]["dat"]);

		$ChangeTags = array();

		$ChangeTags["a"] = array("id");
		$ChangeTags["url"] = array("id");
		$ChangeTags["img"] = array("id");
		$ChangeTags["listview"] = array("triggerid","workspaceID");
		$ChangeTags["ifSelf"] = array("id");
		$ChangeTags["ifNotSelf"] = array("id");
		$ChangeTags["form"] = array("id","onsuccess","onerror","onmailerror");
		$ChangeTags["include"] = array("id");
		$ChangeTags["addDelNewsletterEmail"] = array("mailid","id");
		$ChangeTags["css"] = array("id");
		$ChangeTags["icon"] = array("id");
		$ChangeTags["js"] = array("id");
		$ChangeTags["linkToSEEM"] = array("id");
		$ChangeTags["linkToSeeMode"] = array("id");
		$ChangeTags["listdir"] = array("id");
		$ChangeTags["printVersion"] = array("triggerid");
		$ChangeTags["quicktime"] = array("id");
		$ChangeTags["sendMail"] = array("id");
		$ChangeTags["write"] = array("triggerid");
		$ChangeTags["flashmovie"] = array("id");
		$ChangeTags["delete"] = array("pid");

		$changed = false;

		$tp = new we_tagParser();
		$tags = $tp->getAllTags($we_doc->elements["data"]["dat"]);
		foreach($tags as $tag) {
			$destTag = $tag;
			if (eregi('<we:([^> /]+)',$tag,$regs)) { // starttag found
				$tagname = $regs[1];
				if(isset($ChangeTags[$tagname])){
					foreach( $ChangeTags[$tagname] as $attribname) {
						if(ereg($attribname.'="([0-9]+)"',$tag,$regs)){
							$id = $regs[1];
							$path = id_to_path($id,FILE_TABLE,$GLOBALS["DB_WE"]);
							if($this->mustChange($path)){
								$changed = true;
								$pathTo = $this->getNewPath($path);
								$idTo = $this->getID($pathTo,$GLOBALS["DB_WE"]);
								$idTo = $idTo ? $idTo : "##WEPATH##".$pathTo." ###WEPATH###";
								$destTag = ereg_replace($attribname.'="[0-9]+"',$attribname.'="'.$idTo.'"',$destTag);
							}

						}
					}
				}
			}
			if($changed){
				$changed =  false;
				$we_doc->elements["data"]["dat"] = str_replace($tag,$destTag,$we_doc->elements["data"]["dat"]);
			}
		}

	}

	function parseWeDocument(&$we_doc){
		$DB_WE = new DB_WE();

		$hrefs = array();
		foreach($we_doc->elements as $k=>$v) {
			if(isset($v["type"])){
				switch($v["type"]){
					case "txt":
						if(ereg("(.+)_we_jkhdsf_(.+)",$k,$regs)){  // is a we:href field
							if(!in_array($regs[1],$hrefs)){
								array_push($hrefs,$regs[1]);
								$int = ((!isset($we_doc->elements[$regs[1]."_we_jkhdsf_int"]["dat"])) || $we_doc->elements[$regs[1]."_we_jkhdsf_int"]["dat"] == "") ? 0 : $we_doc->elements[$regs[1]."_we_jkhdsf_int"]["dat"];
								if($int) {
									if (isset($we_doc->elements[$regs[1]."_we_jkhdsf_intID"]["dat"])) {
										$intID = $we_doc->elements[$regs[1]."_we_jkhdsf_intID"]["dat"];
										$path = id_to_path($intID,FILE_TABLE,$DB_WE);
										if($this->mustChange($path)){
											$pathTo = $this->getNewPath($path);
											$idTo = $this->getID($pathTo,$DB_WE);
											$we_doc->elements[$regs[1]."_we_jkhdsf_intID"]["dat"] = $idTo ? $idTo : "##WEPATH##".$pathTo." ###WEPATH###";
											$we_doc->elements[$regs[1]."_we_jkhdsf_intPath"]["dat"] = $pathTo;
										}
									}
								}else {
									if (isset($we_doc->elements[$regs[1]]["dat"])) {
										$path = $we_doc->elements[$regs[1]]["dat"];
										if($this->mustChange($path)){
											$we_doc->elements[$regs[1]]["dat"] = $this->getNewPath($path);
										}
									}
								}
							}
						}else if(substr($we_doc->elements[$k]["dat"],0,2) == "a:" && is_array(unserialize($we_doc->elements[$k]["dat"]))){ // is a we:link field
							$link = unserialize($we_doc->elements[$k]["dat"]);
							if (isset($link["type"]) && ($link["type"] == "int")) {
								$intID = $link["id"];
								$path = id_to_path($intID,FILE_TABLE,$DB_WE);
								if($this->mustChange($path)){
									$pathTo = $this->getNewPath($path);
									$link["id"] = $this->getID($pathTo,$DB_WE);
									$we_doc->elements[$k]["dat"] = serialize($link);
								}
							}
						}else{ // iis a normal  text field
							$this->parseInternalLinks($we_doc->elements[$k]["dat"],$DB_WE);
							// :TODO: check for ="/Path ='Path and =Path
							$we_doc->elements[$k]["dat"] = str_replace($this->data["CopyFromPath"]."/",$this->copyToPath."/",$we_doc->elements[$k]["dat"]);
						}
						break;
					case "img":
						$path = id_to_path(isset($we_doc->elements[$k]["bdid"]) ? $we_doc->elements[$k]["bdid"] : 0,FILE_TABLE,$DB_WE);
						if($this->mustChange($path)){
							$pathTo = $this->getNewPath($path);
							$idTo = $this->getID($pathTo,$DB_WE);
							$we_doc->elements[$k]["bdid"] = $idTo ? $idTo : "##WEPATH##".$pathTo." ###WEPATH###";
						}
						break;
					case "linklist":
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_linklist.inc.php");
						$ll = new we_linklist($we_doc->elements[$k]["dat"]);
						$changed = false;
						for($i=0;$i<sizeof($ll->listArray);$i++){
							$id = $ll->getID($i);
							$path = id_to_path($id,FILE_TABLE,$DB_WE);
							if($this->mustChange($path)){
								$pathTo = $this->getNewPath($path);
								$idTo = $this->getID($pathTo,$DB_WE);
								$ll->setID($i,$idTo);
								$changed=true;
							}
						}

						if($changed){
							$we_doc->elements[$k]["dat"] = serialize($ll->listArray);
						}

						break;
				}

			}

		}
	}

	function getHref($name,$db="",$fn='$this->getElement') {
		if(!$db){
			$db = new_DB_WE();
		}
		$n = $attribs["name"];
		$nint = $n."_we_jkhdsf_int";
		eval('$int = ('.$fn.'($nint) == "") ? 0 : '.$fn.'($nint);');
		if($int) {
			$nintID = $n."_we_jkhdsf_intID";
			eval('$intID = '.$fn.'($nintID);');
			return f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='$intID'","Path",$db);
		}
		else {
			eval('$extPath = '.$fn.'($n);');
			return $extPath;
		}
	}
	function getNewPath($oldPath){
		if($oldPath == $this->data["CopyFromPath"]){
			return 	$this->copyToPath;
		}
		// :TODO: check for ="/Path ='Path and =Path
		return ereg_replace('^'.$this->data["CopyFromPath"]."/",$this->copyToPath."/",$oldPath);
	}

	function mustChange($path){
		return substr($path,0,strlen($this->data["CopyFromPath"])) == $this->data["CopyFromPath"];

	}

	function parseTextDocument(&$we_doc){
		$doc = $we_doc->i_getDocument();
		//:TODO: check for ="/Path ='Path and =Path
		$doc = str_replace($this->data["CopyFromPath"]."/",$this->copyToPath."/",$we_doc->i_getDocument());
		$we_doc->i_setDocument($doc);
	}

	function parseInternalLinks(&$text,$DB_WE){
		if(preg_match_all('/(href|src)="document:([^" ]+)/i',$text,$regs,PREG_SET_ORDER)){
			for($i=0;$i<sizeof($regs);$i++){
				$id = $regs[$i][2];

				$path = id_to_path($id,FILE_TABLE,$DB_WE);
				if($this->mustChange($path)){
					$pathTo = $this->getNewPath($path);
					$idTo = $this->getID($pathTo,$DB_WE);
					$idTo = $idTo ? $idTo : "##WEPATH##".$pathTo." ###WEPATH###";
					$text = eregi_replace('(href|src)="document:'.$id,$regs[$i][1].'="document:'.$idTo,$text);
				}
			}
		}
	}

	function getID($path,$db){
		return  f("SELECT ID FROM ".FILE_TABLE." WHERE Path='$path'","ID",$db);
	}

	function getPid($path,$db){
		$path = dirname($path);
		if($path ==  "/"){
			return 0;
		}
		return f("SELECT ID FROM ".FILE_TABLE." WHERE Path='$path'","ID",$db);
	}

	function getDocument(){
		$we_ContentType = $this->data["ContentType"];
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_init_doc.inc.php");
		return $we_doc;
	}

	function finish(){

		$we_button = new we_button();
		$cancelButton = $we_button->create_button("cancel","javascript:top.close()");


		if(isset($_SESSION["WE_CREATE_DOCTYPE"])){
			unset($_SESSION["WE_CREATE_DOCTYPE"]);
		}

		if(isset($_SESSION["WE_CREATE_TEMPLATE"])){

			$pbText = $GLOBALS["l_copyFolder"]["prepareTemplates"];

			print '<script type="text/javascript">parent.document.getElementById("pbTd").style.display="block";parent.setProgress(0);parent.setProgressText("pbar1","'.addslashes($pbText).'");</script>';
			flush();
			print '<script language="JavaScript">setTimeout(\'self.location = "/webEdition/we/include/copyFolder.inc.php?finish=1"\',100);</script>';
			#unset($_SESSION["WE_CREATE_TEMPLATE"]);
		}else{
			print '<script language="JavaScript">top.opener.top.we_cmd("load","'.FILE_TABLE.'");' . we_message_reporting::getShowMessageCall($GLOBALS["l_copyFolder"]["copy_success"], WE_MESSAGE_NOTICE) . 'top.close();</script>';
		}
	}

	function printHeader(){
		$yuiSuggest =& weSuggest::getInstance();
		$out  = WE_DEFAULT_HEAD;
		$out .= STYLESHEET;
		$out .= $yuiSuggest->getYuiJsFiles();
		$out .= $yuiSuggest->getYuiCssFiles();
		$js = <<<HTS
function fsubmit(e) {
	return false;
}

HTS;
		$out .= we_htmlElement::jsElement($js);
		print we_htmlElement::htmlHead($out);
	}

	function formCreateTemplateDirChooser(){
		global $BROWSER;
		$we_button = new we_button();
		$table = TEMPLATES_TABLE;

		$textname = 'foo';
		$idname = 'CreateTemplateInFolderID';
		$path = "/";
		$myid = 0;
		
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("Template");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($textname,$path,"",1);
		$yuiSuggest->setLabel($GLOBALS["l_copyFolder"]["destdir"]);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(0);
		$yuiSuggest->setResult($idname,$myid);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable($table);
		$yuiSuggest->setWidth(370);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:we_cmd('openDirselector',document.we_form.elements['$idname'].value,'".TEMPLATES_TABLE."','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value','opener.document.we_form.CreateTemplate.checked=true;')", true, 100, 22, "", "", true, false));
		
		return $yuiSuggest->getHTML();
		
	}


	function formCreateCategoryChooser() {

		$we_button = new we_button();

		$addbut = $we_button->create_button("add", "javascript:we_cmd('openCatselector','','" . CATEGORY_TABLE . "','','','fillIDs();opener.addCat(top.allPaths);')");
		$del_but = addslashes(we_htmlElement::htmlImg(array('src'=>IMAGE_DIR.'/button/btn_function_trash.gif','onclick'=>'javascript:#####placeHolder#####;','style'=>'cursor: pointer; width: 27px;-moz-user-select: none;')));


		$js = we_htmlElement::jsElement('',array('src'=>JS_DIR.'utils/multi_edit.js?'.time()));

		$category_js = '
			var categories_edit = new multi_edit("categories",document.we_form,0,"' . $del_but . '",478,false);
			categories_edit.addVariant();

		';
		$category_js .= '
			categories_edit.showVariant(0);
		';

		$js .= we_htmlElement::jsElement($category_js);

		$table = new we_htmlTable(array('id'=>'CategoriesBlock','style'=>'display: block;','cellpadding' => 0,'cellspacing' => 0,'border'=>0),5,2);

		$table->setCol(0,0, array('colspan'=>2), getPixel(5,5));
		$table->setCol(1,0,array('class'=>'defaultfont','width'=>100),$GLOBALS["l_copyFolder"]['categories']);
		$table->setCol(1,1,array('class'=>'defaultfont'),we_forms::checkbox("1", 0, 'OverwriteCategories', $GLOBALS["l_copyFolder"]["overwrite_categories"], false, "defaultfont", "toggleButton();"));
		$table->setCol(2,0, array('colspan'=>2), we_htmlElement::htmlDiv(array('id'=>'categories','class'=>'blockWrapper','style'=>'width: 488px; height: 60px; border: #AAAAAA solid 1px;')));

		$table->setCol(3,0, array('colspan'=>2), getPixel(5,5));

		$table->setCol(4,0, array('colspan'=>'2','align'=>'right'),
			$we_button->create_button_table(array(
					$we_button->create_button("delete_all", "javascript:removeAllCats()"),
					$addbut
				)
			)
		);

		return 	$table->getHtmlCode().$js;
	}


}


class copyFolderFinishFrag extends copyFolderFrag{


	function init(){
		if(isset($_SESSION["WE_CREATE_TEMPLATE"])){
			$this->alldata = array();
			foreach($_SESSION["WE_CREATE_TEMPLATE"] as $id){
				array_push($this->alldata ,$id);
			}
			unset($_SESSION["WE_CREATE_TEMPLATE"]);
		}
	}

	function doTask(){
		if($this->correctTemplate()){


			$pbText = sprintf($GLOBALS["l_copyFolder"]["correctTemplate"], basename(id_to_path($this->data, TEMPLATES_TABLE)));

			print '<script type="text/javascript">parent.document.getElementById("pbTd").style.display="block";parent.setProgress('.((int)((100/count($this->alldata))*($this->currentTask+1))).');parent.setProgressText("pbar1","'.addslashes($pbText).'");</script>';
			flush();

		}else{
			exit("Error correctiing Template with id: ".$this->data);
		}

	}

	function correctTemplate(){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_template.inc.php");

		$templ = new we_template();;
		$templ->initByID($this->data,TEMPLATES_TABLE);
		$content = $templ->elements["data"]["dat"];

		if(preg_match_all('/##WEPATH##([^ ]+) ###WEPATH###/i',$content,$regs,PREG_SET_ORDER)){
			for($i=0;$i<sizeof($regs);$i++){
				$path = $regs[$i][1];
				$id = $this->getID($path,$GLOBALS["DB_WE"]);
				$content = str_replace('##WEPATH##'.$path.' ###WEPATH###',$id,$content);
			}
		}
		$templ->elements["data"]["dat"] = $content;
		return $templ->we_save();

	}

	function finish(){


		if(isset($_SESSION["WE_CREATE_TEMPLATE"])){
			unset($_SESSION["WE_CREATE_TEMPLATE"]);
		}
		print '<script language="JavaScript">top.opener.top.we_cmd("load","'.FILE_TABLE.'");' . we_message_reporting::getShowMessageCall($GLOBALS["l_copyFolder"]["copy_success"], WE_MESSAGE_NOTICE) . 'top.close();</script>';

	}

	function printHeader(){
		print "<html>\n".we_htmlElement::htmlHead(WE_DEFAULT_HEAD.STYLESHEET);
	}


}

$yuiSuggest =& weSuggest::getInstance();

if( isset($_REQUEST["we_cmd"][3]) && $_REQUEST["we_cmd"][3]) {

	$we_button = new we_button();

	$js = 'self.focus();

		function removeAllCats(){
			if(categories_edit.itemCount>0){
				while(categories_edit.itemCount>0){
					categories_edit.delItem(categories_edit.itemCount);
				}
			}
		}

		function addCat(paths){
			var path = paths.split(",");
			var found = false;
			var j = 0;
			for (var i = 0; i < path.length; i++) {
				if(path[i]!="") {
					found = false;
					for(j=0;j<categories_edit.itemCount;j++){
						if(categories_edit.form.elements[categories_edit.name+"_variant0_"+categories_edit.name+"_item"+j].value == path[i]) {
							found = true;
						}
					}
					if(!found) {
						categories_edit.addItem();
						categories_edit.setItem(0,(categories_edit.itemCount-1),path[i]);
					}
				}
			}
			categories_edit.showVariant(0);
		}

		function we_cmd(){
			var args = "";
			var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

			switch (arguments[0]){
				case "openDirselector":
					new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,true,true,true);
					break;
				case "openCatselector":
					new jsWindow(url,"we_cateditor",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);
					break;
				default:
					for(var i = 0; i < arguments.length; i++){
						args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
					}
					eval("opener.we_cmd("+args+")");
			}
		}
		var lastCFolder;
		function toggleButton() {
			if(document.getElementById(\'CreateTemplate\').checked) {
				weButton.enable(\'select\');
				if(acin = document.getElementById(\'yuiAcInputTemplate\')) {
					document.getElementById(\'yuiAcInputTemplate\').disabled=false;
					lastCFolder = acin.value;
					acin.readOnly=false;
				}
				return true;
			} else {
				weButton.disable(\'select\');
				if(acin = document.getElementById(\'yuiAcInputTemplate\')) {
					document.getElementById(\'yuiAcInputTemplate\').disabled=true;
					acin.readOnly=true;
					acin.value = lastCFolder;
				}
				return true;
			}
			return false;
		}
		function incTemp(val) {
			if(val) {
				document.getElementsByName("CreateMasterTemplate")[0].disabled=false;
				document.getElementsByName("CreateIncludedTemplate")[0].disabled=false;
				document.getElementById("label_CreateMasterTemplate").style.color = "black";
				document.getElementById("label_CreateIncludedTemplate").style.color = "black";
			} else {
				document.getElementsByName("CreateMasterTemplate")[0].checked=false;
				document.getElementsByName("CreateIncludedTemplate")[0].checked=false;
				document.getElementsByName("CreateMasterTemplate")[0].disabled=true;
				document.getElementsByName("CreateIncludedTemplate")[0].disabled=true;
				document.getElementById("label_CreateMasterTemplate").style.color = "gray";
				document.getElementById("label_CreateIncludedTemplate").style.color = "gray";
			}
		}
		';
	$js =	 we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
			we_htmlElement::jsElement($js);

	$yes_button = $we_button->create_button("ok", "form:we_form");
	$cancel_button = $we_button->create_button("cancel", "javascript:self.close();");

	$pb=new we_progressBar(0);
	$pb->setStudLen(270);
	$pb->addText("&nbsp;",0,"pbar1");
	$pbHTML = $pb->getHTML() . $pb->getJSCode();



	$buttons = '<table border="0" cellpadding="0" cellspacing="0" width="300"><tr><td align="left" id="pbTd" style="display:none;">'.
					$pbHTML.'</td><td align="right">'.
					$we_button->position_yes_no_cancel($yes_button,  null, $cancel_button).
					'</td></tr></table>';
	$content = '<table border="0" cellpadding="0" cellspacing="0" width="500"><tr><td>'.
					we_forms::checkbox("1", 0, 'CreateTemplate', $GLOBALS["l_copyFolder"]["create_new_templates"], false, "defaultfont", "toggleButton(); incTemp(this.checked)").'
					<div id="imTemp" style="display:block">'.
					we_forms::checkbox("1", 0, 'CreateMasterTemplate', $GLOBALS["l_copyFolder"]["create_new_masterTemplates"], false, "defaultfont", "",1).
					we_forms::checkbox("1", 0, 'CreateIncludedTemplate', $GLOBALS["l_copyFolder"]["create_new_includedTemplates"], false, "defaultfont", "",1).'
					</div></td><td valign="top">'.
					we_forms::checkbox("1", 0, 'CreateDoctypes', $GLOBALS["l_copyFolder"]["create_new_doctypes"]).'
					</td></tr>
					<tr><td colspan="2">'.getPixel(2,5).'</td></tr>
					<tr><td colspan="2">'.copyFolderFrag::formCreateTemplateDirChooser().'</td></tr>
					<tr><td colspan="2">'.getPixel(2,5).'<br>'.copyFolderFrag::formCreateCategoryChooser().
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[0]","value"=>$_REQUEST["we_cmd"][0])).
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[1]","value"=>$_REQUEST["we_cmd"][1])).
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[2]","value"=>$_REQUEST["we_cmd"][2])).
					'</td></tr></table>';

	copyFolderFrag::printHeader();
	print '<body class="weDialogBody">'."\n".$js."\n".'<form onsubmit="return fsubmit(this)" name="we_form" target="pbUpdateFrame" method="get">'."\n";
	print htmlDialogLayout($content,$GLOBALS["l_copyFolder"]["headline"].": ".shortenPath(id_to_path($_REQUEST["we_cmd"][1]),46),$buttons);
	print '</form>';
	print '<iframe frameborder="0" src="about:blank" name="pbUpdateFrame" width="0" height="0" id="pbUpdateFrame"></iframe>';
	print $yuiSuggest->getYuiCss();
	print $yuiSuggest->getYuiJs();
	print '</body></html>';
}else{

	if(isset($_REQUEST["finish"])){
		$fr = new copyFolderFinishFrag("we_copyFolderFinish",1,0,array("bgcolor"=>"#FFFFFF","marginwidth"=>15,"marginheight"=>10,"leftmargin"=>15,"topmargin"=>10));
	}else{
		$fr = new copyFolderFrag("we_copyFolder",1,0,array("bgcolor"=>"#FFFFFF","marginwidth"=>15,"marginheight"=>10,"leftmargin"=>15,"topmargin"=>10));
	}
}

?>