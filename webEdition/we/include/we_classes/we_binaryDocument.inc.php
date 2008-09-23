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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_document.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
if (!isset($GLOBALS["WE_IS_DYN"])) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/metadata.inc.php");
}

/*  a class for handling binary-documents like images. */
class we_binaryDocument extends we_document
{
	######################################################################################################################################################
	##################################################################### Variables ######################################################################
	######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_binaryDocument";

	/* The HTML-Code which can be included in a HTML Document */
	var $html="";

	var $IsBinary = true;

	var $EditPageNrs = array(WE_EDITPAGE_PROPERTIES,WE_EDITPAGE_INFO,WE_EDITPAGE_CONTENT,WE_EDITPAGE_VERSIONS);

	var $LoadBinaryContent = true;

	/**
	 * Flag which indicates that the doc has changed!
	 * @var boolean
	 */
	var $DocChanged = false;

	######################################################################################################################################################
	##################################################################### FUNCTIONS ######################################################################
	######################################################################################################################################################


	/** Constructor
	* @return we_binaryDocument
	* @desc Constructor for we_binaryDocument
	*/
	function we_binaryDocument(){
		$this->we_document();
		array_push($this->persistent_slots,"html","DocChanged");
	}


	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor(){
		global $we_responseText,$we_JavaScript;
		switch($this->EditPageNr){
			case WE_EDITPAGE_PROPERTIES:
			return "we_templates/we_editor_properties.inc.php";
			case WE_EDITPAGE_IMAGEEDIT:
			return "we_templates/we_image_imageedit.inc.php";
			case WE_EDITPAGE_INFO:
			return "we_templates/we_editor_info.inc.php";
			case WE_EDITPAGE_CONTENT:
			return "we_templates/we_editor_binaryContent.inc.php";
			case WE_EDITPAGE_VERSIONS:
				return "we_versions/we_editor_versions.inc.php";
			break;
			default:
			$this->EditPageNr = WE_EDITPAGE_PROPERTIES;
			$_SESSION["EditPageNr"] = WE_EDITPAGE_PROPERTIES;
			return "we_templates/we_editor_properties.inc.php";
		}
	}

	/**
	* @return void
	* @param boolean $from
	* @desc loads the data of the document
	*/
	function we_load($from=LOAD_MAID_DB){
		we_document::we_load($from);
		//$this->i_getContentData($this->LoadBinaryContent);
	}

	function i_getContentData($loadBinary=1){
		parent::i_getContentData(true);
		$_sitePath = $this->getSitePath();
		if(file_exists($_sitePath)){
			if(filesize($_sitePath)){
				$this->setElement("data",$_sitePath,"image");
			}
		}
	}


	function we_save($resave=0){
		if( parent::we_save($resave) ){
			$this->DocChanged = false;
			$this->elements["data"]["dat"] = $this->getSitePath();
			return $this->insertAtIndex();
		}else{
			return false;
		}
	}

	function i_getDocument($includepath="") {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
		return (isset($this->elements["data"]["dat"]) && file_exists($this->elements["data"]["dat"])) ? weFile::load($this->elements["data"]["dat"]) : "";
	}

	/* gets the filesize of the document */
	function getFilesize(){
		return filesize($this->elements["data"]["dat"]);
	}

	function insertAtIndex(){
		$this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE DID=".$this->ID);
		if(isset($this->IsSearchable) && $this->IsSearchable && $this->Published){
			$text = "";
			$this->resetElements();
			while(list($k,$v) = $this->nextElement("")){
					$foo = (isset($v["dat"]) && substr($v["dat"],0,2) == "a:") ? unserialize($v["dat"]) : "";
					if(!is_array($foo)){
						if(isset($v["type"]) && $v["type"] == "txt"){
							$text .= " ".(isset($v["dat"]) ? $v["dat"] : "");
						}
					}
			}
			return $this->DB_WE->query("INSERT INTO " . INDEX_TABLE . " (DID,Text,BText,Workspace,WorkspaceID,Category,Doctype,Title,Description,Path) VALUES('".$this->ID."','$text','$text','".addslashes($this->ParentPath)."','".addslashes($this->ParentID)."','".addslashes($this->Category)."','','".addslashes($this->getElement("Title"))."','".addslashes($this->getElement("Description"))."','".addslashes($this->Path)."')");
		}
		return true;

	}

	function we_new(){
		we_document::we_new();
		$this->Filename=$this->i_getDefaultFilename();

	}

	/**
	 * @abstract tries to read ebmedded metadata from file
	 * @return bool false if either no metadata is available or something went wrong
	 */
	function getMetaData($fieldsonly = false) {
		return false;
	}


	function i_setElementsFromHTTP() {
		// preventing fields from override
		if (isset($_REQUEST['we_cmd'][0]) && $_REQUEST['we_cmd'][0] == 'update_file') {
			return;
		}
		parent::i_setElementsFromHTTP();
	}


	/**
	 * returns HTML code for embedded metadata of current image with custom form fields
	 */
	function formMetaData() {
		/*
		 * the following steps are to be implemented in this method:
		 * 1. fetch all metadata fields from db
		 * 2. fetch metadata for this image from db (is already done via $this->elements)
		 * 3. render form fields with metadata from db
		 * 4. show button to copy metadata from image into the form fields
		 */
		global $DB_WE;

		// first we fetch all defined metadata fields from tblMetadata:
		$_defined_fields = weMetaData::getDefinedMetaDataFields();


		// show an alert if there are none
		if(empty($_defined_fields)) {
			return "";
		}

		// second we build all input fields for them and take
		// the elements of this imageDocument as values:
		$_fieldcount = sizeof($_defined_fields);
		$_fieldcounter = (int)0; // needed for numbering the table rows
		$_content = new we_htmlTable(array("border" => 0, "cellpadding" => 0, "cellspacing" => 0, "style" => "margin-top:4px;"), ($_fieldcount * 2), 5);
		$_mdcontent = "";
		for($i=0; $i<$_fieldcount; $i++) {
			$_tagName = $_defined_fields[$i]["tag"];
			if ($_tagName != "Title" && $_tagName != "Description" && $_tagName != "Keywords") {
				$_type = $_defined_fields[$i]["type"];


				switch ($_type) {

					case "textarea":
						$_inp = $this->formTextArea('txt',$_tagName,$_tagName,10,30,' onChange="_EditorFrame.setEditorIsHot(true);" style="width:508px;height:150px;border: #AAAAAA solid 1px" class="wetextarea"');
					break;

					case "wysiwyg":
						$_inp = $this->formTextArea('txt',$_tagName,$_tagName,10,30,' onChange="_EditorFrame.setEditorIsHot(true);" style="width:508px;height:150px;border: #AAAAAA solid 1px" class="wetextarea"');
					break;

					case "date":
						$_inp = htmlFormElementTable(
							getDateInput2('we_'.$this->Name.'_date['.$_tagName.']', abs($this->getElement($_tagName)),true),
							$_tagName
						);
					break;

					default:
						$_inp = $this->formInput2(508, $_tagName, 23, "txt", ' onChange="_EditorFrame.setEditorIsHot(true);"');
				}


				$_content->setCol($_fieldcounter, 0, array("colspan" => 5), $_inp);
				$_fieldcounter++;
				$_content->setCol($_fieldcounter, 0, array("colspan" => 5), getPixel(1, 5));
				$_fieldcounter++;
			}
		}

		$_mdcontent.=$_content->getHtmlCode();

		// Return HTML
		return $_mdcontent;
	}

	/**
	 * Returns HTML code for Upload Button and infotext
	 */
	function formUpload() {
		$we_button = new we_button();
		$uploadButton = $we_button->create_button("upload", "javascript:we_cmd('editor_uploadFile')", true,150,22,"","",false,true,"",true);
		$fs = $GLOBALS["we_doc"]->getFilesize();
		$fs = $GLOBALS["l_metadata"]["filesize"].": ".round(($fs / 1024),2)."&nbsp;KB";
		$_metaData = $this->getMetaData();
		$_mdtypes = array();

		if ($_metaData) {
			if (isset($_metaData["exif"]) && count($_metaData["exif"])) {
				$_mdtypes[] = "Exif";
			}
			if (isset($_metaData["iptc"]) && count($_metaData["iptc"])) {
				$_mdtypes[] = "IPTC";
			}

		}

		$filetype = $GLOBALS["l_metadata"]["filetype"].": ";
		if(!empty($this->Extension)) {
			$filetype .= substr($this->Extension,1);
		}

		$md = $GLOBALS["l_metadata"]["supported_types"].": ";

		if(count($_mdtypes) > 0) {
			$_mdTypesTxt = implode(", ", $_mdtypes);
		} else {
			$_mdTypesTxt = $GLOBALS["l_metadata"]["none"];
		}

		$md .= '<a href="javascript:parent.frames[0].setActiveTab(\'tab_2\');we_cmd(\'switch_edit_page\',2,\''.$GLOBALS['we_transaction'].'\');">';
		$md.= $_mdTypesTxt;
		$md .= '</a>';
		$foo = '<table cellpadding="0" cellspacing="0" border="0" width="500">
		';
			$foo .= '<tr style="vertical-align:top;">
						<td class="defaultfont">' .
						$uploadButton . '<br />' .
						$fs . '<br />' .
						$filetype . '<br />'.
						$md . '</td>
						<td width="100px" style="text-align:right;">';
							$foo.=$this->getThumbnail();
			$foo .= '</td>
					</tr>
					<tr>
							<td>' . getPixel(2, 20) . '</td>
							<td>' . getPixel(2, 20) . '</td>
					</tr>
					<tr>';
			if($GLOBALS["we_doc"]->getFilesize() != 0){
					$foo .= '<td colspan="2" class="defaultfont">' . htmlAlertAttentionBox($GLOBALS['l_we_class']["upload_will_replace"],1,508) . '</td>';
			} else {
					$foo .= '<td colspan="2" class="defaultfont">' . htmlAlertAttentionBox($GLOBALS['l_we_class']["upload_single_files"],1,508) . '</td>';
			}
			$foo .= '</tr>';


		$foo .= '</table>';

		return $foo;
	}

	function getThumbnail() {
		return ""; // TODO
	}

	function savebinarydata() {
		$_data = $this->getElement("data");
		if($_data && !file_exists($_data)) {
			$_path = weFile::saveTemp($_data);
			$this->setElement('data',$_path);
		}
	}
}

?>