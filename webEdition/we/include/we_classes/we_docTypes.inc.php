<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_class
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_browserDetect.inc.php');

define("WE_FORM_PARENT_FOLDER",3);
define("WE_FORM_PARENT_ID",4);
define("WE_FORM_TEMPLATE_ID",8);
define("WE_FORM_EXTENSION",2);
define("WE_FORM_IS_DYNAMIC",9);
define("WE_FORM_IS_DYNAMIC_HIDDEN",9);

class we_docTypes extends we_class {

	/*
	* Variables
	*/

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_docTypes";

	/* The Text that will be shown in the tree-menue */
	var $DocType="New DocType";
	var $Table = DOC_TYPES_TABLE;
	var $Extension=".html";
	var $ParentID="0";
	var $ParentPath="";
	var $TemplateID=0;
	var $ContentTable="";
	var $IsDynamic=false;
	var $IsSearchable=false;
	var $JavaScript = "";
	var $Notify = "";
	var $NotifyTemplateID="";
	var $NotifySubject = "";
	var $NotifyOnChange="";
	var $Templates="";
	var $SubDir = SUB_DIR_NO;
	var $Category="";
	var $Language="";

	/*
	* Functions
	*/

	/* Constructor */
	function we_docTypes() {
		$this->we_class();
		array_push($this->persistent_slots,"Category","DocType","Extension","ParentID","ParentPath","TemplateID","ContentTable","IsDynamic","IsSearchable","Notify","NotifyTemplateID","NotifySubject","NotifyOnChange","SubDir","Templates","Language");
	}

	function we_save($resave=0){
		$idArr = makeArrayFromCSV($this->Templates);
		$newIdArr = array();
		if(sizeof($idArr)){
			foreach($idArr as $id){
				$path = id_to_path($id,TEMPLATES_TABLE);
				if($id && $path){
					array_push($newIdArr,$id);
				}
			}
		}
		$this->Templates = makeCSVFromArray($newIdArr);

		return we_class::we_save($resave);
	}
	
	function we_save_exim() {
		return we_class::we_save(0);
	}
	

	function saveInSession(&$save) {
		$save = array();
		$save[0] = array();
		for($i=0;$i<sizeof($this->persistent_slots);$i++) {
			eval('$save[0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
		}
	}

	function we_initSessDat($sessDat) {
		we_class::we_initSessDat($sessDat);
		if(is_array($sessDat)) {
			for($i=0;$i<sizeof($this->persistent_slots);$i++) {
				if(isset($sessDat[0][$this->persistent_slots[$i]])) {
					eval('$this->'.$this->persistent_slots[$i].'=$sessDat[0][$this->persistent_slots[$i]];');
				}
			}
		}
		$this->i_setElementsFromHTTP();

		if($this->Language == "") {
			$this->initLanguageFromParent();
		}
	}


	function initLanguageFromParent() {

		$ParentID = $this->ParentID;
		$i = 0;
		while($this->Language == "") {
			if($ParentID == 0 || $i > 20) {
				we_loadLanguageConfig();
				$this->Language = $GLOBALS['weDefaultFrontendLanguage'];
				if($this->Language == "") {
					$this->Language = "de_DE";
				}

			} else {
				$Query = "SELECT Language, ParentID FROM " . $this->Table . " WHERE ID = " . $ParentID;
				$this->DB_WE->query($Query);

				while($this->DB_WE->next_record()) {
					$ParentID = $this->DB_WE->f("ParentID");
					$this->Language = $this->DB_WE->f("Language");

				}

			}
			$i++;

		}

	}

	function formLanguage() {

		we_loadLanguageConfig();

		$value = ($this->Language!=""?$this->Language:$GLOBALS['weDefaultFrontendLanguage']);

		$inputName = "we_".$this->Name."_Language";

		$_languages = $GLOBALS['weFrontendLanguages'];

		return $this->htmlFormElementTable($this->htmlSelect($inputName, $_languages, 1, $value, false, "", "value", 521),
			$GLOBALS['l_we_class']['language'],
			"left",
			"defaultfont");

	}

	function formCategory() {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_global;

		$we_button = new we_button();
		$addbut = $we_button->create_button("add", "javascript:we_cmd('openCatselector', '', '" . CATEGORY_TABLE . "', '', '', 'fillIDs();opener.we_cmd(\\'dt_add_cat\\', top.allIDs);')", false, 92, 22, "", "", (!we_hasPerm("EDIT_KATEGORIE")));

		$cats = new MultiDirChooser(521,$this->Category,"dt_delete_cat",$addbut,"","Icon,Path", CATEGORY_TABLE);
		return $this->htmlFormElementTable($cats->get(),$GLOBALS["l_we_class"]["category"]);
	}

	function addCat($id) {
		$cats = makeArrayFromCSV($this->Category);
		$ids = makeArrayFromCSV($id);
		foreach($ids as $id){
			if($id && (!in_array($id,$cats))) {
				array_push($cats,$id);
			}
		}
		$this->Category=makeCSVFromArray($cats,true);
	}

	function delCat($id) {
		$cats = makeArrayFromCSV($this->Category);
		if(in_array($id,$cats)) {
			$pos = getArrayKey($id,$cats);
			if($pos != "" || $pos=="0") {
				array_splice($cats,$pos,1);
			}
		}
		$this->Category=makeCSVFromArray($cats,true);
	}

	/*
	* Form functions for generating the html of the input fields
	*/

	function formDocTypeHeader() {
		global $l_we_class;
		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td>
						'.$this->formDocTypes2().'</td>
					<td>
						'.getPixel(20,2).'</td>
					<td>
						'.$this->formNewDocType().'
						'.getPixel(2,10).'
						'.$this->formDeleteDocType().'</td>
				</tr>
			</table>';
		return $content;
	}

	function formName() {
		return $this->formInputField("","DocType","",24,520,32);
	}

	function formDocTypeTemplates() {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
		global $l_global;

		$we_button = new we_button();
		$addbut = $we_button->create_button("add", "javascript:we_cmd('openDocselector', '', '" . TEMPLATES_TABLE . "', '', '', 'fillIDs();opener.we_cmd(\\'add_dt_template\\', top.allIDs);', '', '', 'text/weTmpl', 1,1)");

		$templ = new MultiDirChooser(521,$this->Templates,"delete_dt_template",$addbut,"","Icon,Path", TEMPLATES_TABLE);
		return $templ->get();
	}

	function formDocTypeDefaults() {
		global $l_we_class,$l_global,$BROWSER;

		$content = '
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="3">
						'.$this->formDirChooser($BROWSER=="IE"?403:409).'</td>
				</tr>
				<tr>
					<td>
						'.getPixel(300,5).'</td>
					<td>
						'.getPixel(20,5).'</td>
					<td>
						'.getPixel(200,5).'</td>
				</tr>
				<tr>
					<td>
						'.$this->formSubDir(300).'</td>
					<td>
						'.getPixel(20,2).'</td>
					<td>
						'.$this->formExtension(200).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.getPixel(2,5).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.$this->formTemplatePopup(521).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.getPixel(2,5).'</td>
				</tr>
				<tr>
					<td>
						'.$this->formIsDynamic().'</td>
					<td></td>
					<td>
						'.$this->formIsSearchable().'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.getPixel(2,5).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.$this->formLanguage(521).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.getPixel(2,5).'</td>
				</tr>
				<tr>
					<td colspan="3">
						'.$this->formCategory(521).'</td>
				</tr>
			</table>';

		return $content;

	}

	/**
	* @return string
	* @param  array $arrHide
	* @desc   returns HTML-Code for a doctype select-box without doctypes given in $array
	* @return string
	*/
	function formDocTypes2($arrHide=array()) {
		global $l_we_class;
		$vals = array();
		$q=getDoctypeQuery($this->DB_WE);
		$this->DB_WE->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");

		while($this->DB_WE->next_record()) {
			$v = $this->DB_WE->f("ID");
			$t = $this->DB_WE->f("DocType");
			if(in_array($t, $arrHide)){
				continue;
			}
			$vals[$v]=$t;
		}
		return $this->htmlSelect("DocTypes",$vals,"8",$this->ID,false,'style="width:328px" onChange="we_cmd(\'change_docType\',this.options[this.selectedIndex].value)"');
	}

	function formDirChooser($width=100) {
		global $l_we_class,$BROWSER;
		
		$yuiSuggest =& weSuggest::getInstance();
		
		$textname = 'we_'.$this->Name.'_ParentPath';
		$idname = 'we_'.$this->Name.'_ParentID';

		$we_button = new we_button();
		$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector', document.forms['we_form'].elements['" . $idname . "'].value, '" . FILE_TABLE . "', 'document.forms[\\'we_form\\'].elements[\\'" . $idname . "\\'].value', 'document.forms[\\'we_form\\'].elements[\\'" . $textname  . "\\'].value', '', '" . session_id() . "')");
		$yuiSuggest->setAcId("Path");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($textname,$this->ParentPath);
		$yuiSuggest->setLabel($l_we_class["dir"]);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($idname,$this->ParentID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setWidth($width - ($BROWSER=="IE"? 0 : 10));
		$yuiSuggest->setSelectButton($button);
		
		return $yuiSuggest->getHTML();
		
	}

	function formExtension($width=100) {
		global $l_we_class;
		$exts = $GLOBALS["WE_CONTENT_TYPES"]["text/webedition"]["Extension"];
		return $this->htmlFormElementTable(getExtensionPopup("we_".$this->Name."_Extension",$this->Extension,explode(",",$GLOBALS["WE_CONTENT_TYPES"]["text/webedition"]["Extension"]),$width),$l_we_class["extension"]);
	}

	/* creates the Template PopupMenue */
	function formTemplatePopup($width=100) {
		global $l_we_class;

		$tlist="";
		if($this->TemplateID!="")
			$tlist=$this->TemplateID;
		if($this->Templates!="")
			$tlist.=",".$this->Templates;
		$tlist=implode(",",array_unique(explode(",",$tlist)));
		$sqlTeil="";
		if($tlist!="")
			$sqlTeil="WHERE IsFolder=0 AND ID IN($tlist)";
		else
			$sqlTeil="WHERE IsFolder=0";
		return $this->formSelect2("",$width,"TemplateID", TEMPLATES_TABLE,"ID","Path",$l_we_class["standard_template"],$sqlTeil,1,$this->TemplateID,false,"","","left","defaultfont","","",array(0,$l_we_class["none"]));
	}

	// return DocumentType HTML
	function formDocTypeDropDown($selected=-1, $width=200, $onChange="") {
		global $l_we_class;
		$this->DocType = $selected;
		return  $this->formSelect2(
			"",								// element type
			$width,							// width
			"DocType",						// name
			DOC_TYPES_TABLE,				// table
			"ID",							// value in DB
			"DocType",						// txt in DB
			$l_we_class["doctype"],			// text
			"ORDER BY DocType",				// sql Part
			1,								// size
			$selected,						// selectedIndex
			false,							// multiply
			$onChange,						// on change part
			"",								// attribs
			"left",							// textalign
			"defaultfont",					// textclass
			"",								// pre code
			"",								// postcode
		array(-1,$l_we_class["nodoctype"])	// first element
		);
	}

	function formIsDynamic() {
		global $l_we_class;
		$isDyn = $this->IsDynamic ? 1 : 0;
		$n = "we_".$this->Name."_IsDynamic";
		$v = $this->IsDynamic;

		$out="\nfunction switchExt(){\n";
		$out.='var a=document.we_form.elements;'."\n";
		if ($this->ID) {
			$out.='if(confirm("'.$l_we_class["confirm_ext_change"].'")){'."\n";
		}
		$DefaultDynamicExt = (defined("DEFAULT_DYNAMIC_EXT") ? DEFAULT_DYNAMIC_EXT : ".php");
		$DefaultStaticExt = (defined("DEFAULT_STATIC_EXT") ? DEFAULT_STATIC_EXT : ".html");
		$out.='if(a["we_'.$this->Name.'_IsDynamic"].value==1) {var changeto="'.$DefaultDynamicExt.'";} else {var changeto="'.$DefaultStaticExt.'";}'."\n";
		$out .= 'a["we_'.$this->Name.'_Extension"].value=changeto;'."\n";
		if ($this->ID) {
			$out.="}\n";
		}
		$out.="}\n";
		$out="\n".'<script language="JavaScript" type="text/javascript">'.$out.'</script>'."\n";

		return we_forms::checkbox(1, $v ? true : false, "check_" . $n, $l_we_class["IsDynamic"], true, "defaultfont", "this.form.elements['" . $n . "'].value = (this.checked ? '1' : '0'); switchExt();") . $this->htmlHidden($n, $v) . $out;
	}

	function formIsSearchable() {
		global $l_we_class;
		$isSearchable = $this->IsSearchable ? 1 : 0;
		$n = "we_".$this->Name."_IsSearchable";
		$v = $isSearchable ;

		return we_forms::checkbox(1, $v ? true : false, "check_" . $n, $l_we_class["IsSearchable"], false, "defaultfont", "this.form.elements['" . $n . "'].value = (this.checked ? '1' : '0');") . $this->htmlHidden($n, $v);
	}

	function formSubDir($width=100) {
		global $l_we_class;
		$vals = array();
		for($i=0;$i<sizeof($l_we_class["subdir"]);$i++) {
			$vals[(String)$i] = $l_we_class["subdir"][$i];
		}
		return $this->htmlFormElementTable($this->htmlSelect('we_'.$this->Name.'_SubDir',$vals,$size=1,$this->SubDir,false,"","value",$width),$l_we_class["subdirectory"]);
	}

	function formNewDocType() {
		$we_button = new we_button();
		return $we_button->create_button("new_doctype", "javascript:we_cmd('newDocType')");
	}

	function formDeleteDocType() {
		$we_button = new we_button();
		return $we_button->create_button("delete_doctype", "javascript:we_cmd('deleteDocType', '" . $this->ID . "')");
	}

}

?>