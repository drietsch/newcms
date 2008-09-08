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


include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/versions.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_ContentTypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");


class weVersions {
	
	protected $ID;
	protected $documentID;
	protected $documentTable;
	protected $documentElements;
	protected $documentScheduler;
	protected $documentCustomFilter;
	protected $timestamp;
	protected $status;
	protected $version = 1;
	protected $binaryPath;
	protected $modifications;
	protected $modifierID;
	protected $IP;
	protected $Browser;
	protected $ContentType;
	protected $Text;
	protected $ParentID;
	protected $Icon;
	protected $CreationDate;
	protected $CreatorID;
	protected $Path;
	protected $TemplateID;
	protected $Filename;
	protected $Extension;
	protected $IsDynamic;
	protected $IsSearchable;
	protected $ClassName;
	protected $DocType;
	protected $Category;
	protected $RestrictOwners;
	protected $Owners;
	protected $OwnersReadOnly;
	protected $Language;
	protected $WebUserID;
	protected $Workspaces;
	protected $ExtraWorkspaces;
	protected $ExtraWorkspacesSelected;
	protected $Templates;
	protected $ExtraTemplates;
	protected $TableID;
	protected $ObjectID;
	protected $IsClassFolder;
	protected $IsNotEditable;
	protected $Charset;
	protected $active;
	protected $fromScheduler;
	protected $fromImport;
	protected $resetFromVersion;
	
	public $contentTypes = array();
	public $persistent_slots = array();
	public $modFields = array();
	
	/**
	 * @return unknown
	 */
	public function getActive() {
		return $this->active;
	}
	
	/**
	 * @return unknown
	 */
	public function getBinaryPath() {
		return $this->binaryPath;
	}
	
	/**
	 * @return unknown
	 */
	public function getBrowser() {
		return $this->browser;
	}
	
	/**
	 * @return unknown
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 * @return unknown
	 */
	public function getCharset() {
		return $this->charset;
	}
	
	/**
	 * @return unknown
	 */
	public function getClassName() {
		return $this->className;
	}
	
	/**
	 * @return unknown
	 */
	public function getContentType() {
		return $this->contentType;
	}
	
	/**
	 * @return unknown
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}
	
	/**
	 * @return unknown
	 */
	public function getCreatorID() {
		return $this->creatorID;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocType() {
		return $this->docType;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocumentCustomFilter() {
		return $this->documentCustomFilter;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocumentElements() {
		return $this->documentElements;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocumentID() {
		return $this->documentID;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocumentScheduler() {
		return $this->documentScheduler;
	}
	
	/**
	 * @return unknown
	 */
	public function getDocumentTable() {
		return $this->documentTable;
	}
	
	/**
	 * @return unknown
	 */
	public function getExtension() {
		return $this->extension;
	}
	
	/**
	 * @return unknown
	 */
	public function getExtraTemplates() {
		return $this->extraTemplates;
	}
	
	/**
	 * @return unknown
	 */
	public function getExtraWorkspaces() {
		return $this->extraWorkspaces;
	}
	
	/**
	 * @return unknown
	 */
	public function getExtraWorkspacesSelected() {
		return $this->extraWorkspacesSelected;
	}
	
	/**
	 * @return unknown
	 */
	public function getFilename() {
		return $this->filename;
	}
	
	/**
	 * @return unknown
	 */
	public function getFromImport() {
		return $this->fromImport;
	}
	
	/**
	 * @return unknown
	 */
	public function getFromScheduler() {
		return $this->fromScheduler;
	}
	
	/**
	 * @return unknown
	 */
	public function getIcon() {
		return $this->icon;
	}
	
	/**
	 * @return unknown
	 */
	public function getID() {
		return $this->iD;
	}
	
	/**
	 * @return unknown
	 */
	public function getIP() {
		return $this->iP;
	}
	
	/**
	 * @return unknown
	 */
	public function getIsClassFolder() {
		return $this->isClassFolder;
	}
	
	/**
	 * @return unknown
	 */
	public function getIsDynamic() {
		return $this->isDynamic;
	}
	
	/**
	 * @return unknown
	 */
	public function getIsNotEditable() {
		return $this->isNotEditable;
	}
	
	/**
	 * @return unknown
	 */
	public function getIsSearchable() {
		return $this->isSearchable;
	}
	
	/**
	 * @return unknown
	 */
	public function getLanguage() {
		return $this->language;
	}
	
	/**
	 * @return unknown
	 */
	public function getModifications() {
		return $this->modifications;
	}
	
	/**
	 * @return unknown
	 */
	public function getModifierID() {
		return $this->modifierID;
	}
	
	/**
	 * @return unknown
	 */
	public function getObjectID() {
		return $this->objectID;
	}
	
	/**
	 * @return unknown
	 */
	public function getOwners() {
		return $this->owners;
	}
	
	/**
	 * @return unknown
	 */
	public function getOwnersReadOnly() {
		return $this->ownersReadOnly;
	}
	
	/**
	 * @return unknown
	 */
	public function getParentID() {
		return $this->parentID;
	}
	
	/**
	 * @return unknown
	 */
	public function getPath() {
		return $this->path;
	}
	
	/**
	 * @return unknown
	 */
	public function getResetFromVersion() {
		return $this->resetFromVersion;
	}
	
	/**
	 * @return unknown
	 */
	public function getRestrictOwners() {
		return $this->restrictOwners;
	}
	
	function getStatus() {
		return $this->status; 
	}
	
	/**
	 * @return unknown
	 */
	public function getTableID() {
		return $this->tableID;
	}
	
	/**
	 * @return unknown
	 */
	public function getTemplateID() {
		return $this->templateID;
	}
	
	/**
	 * @return unknown
	 */
	public function getTemplates() {
		return $this->templates;
	}
	
	/**
	 * @return unknown
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 * @return unknown
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}
	
	function getVersion() {
		return $this->version; 
	}
	
	/**
	 * @return unknown
	 */
	public function getWebUserID() {
		return $this->webUserID;
	}
	
	/**
	 * @return unknown
	 */
	public function getWorkspaces() {
		return $this->workspaces;
	}
	
	/**
	 * @param unknown_type $active
	 */
	public function setActive($active) {
		$this->active = $active;
	}
	
	/**
	 * @param unknown_type $binaryPath
	 */
	public function setBinaryPath($binaryPath) {
		$this->binaryPath = $binaryPath;
	}
	
	/**
	 * @param unknown_type $Browser
	 */
	public function setBrowser($browser) {
		$this->browser = $browser;
	}
	
	/**
	 * @param unknown_type $Category
	 */
	public function setCategory($category) {
		$this->category = $category;
	}
	
	/**
	 * @param unknown_type $Charset
	 */
	public function setCharset($charset) {
		$this->charset = $charset;
	}
	
	/**
	 * @param unknown_type $ClassName
	 */
	public function setClassName($className) {
		$this->className = $className;
	}
	
	/**
	 * @param unknown_type $ContentType
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}
	
	/**
	 * @param unknown_type $CreationDate
	 */
	public function setCreationDate($creationDate) {
		$this->creationDate = $creationDate;
	}
	
	/**
	 * @param unknown_type $CreatorID
	 */
	public function setCreatorID($creatorID) {
		$this->creatorID = $creatorID;
	}
	
	/**
	 * @param unknown_type $DocType
	 */
	public function setDocType($docType) {
		$this->docType = $docType;
	}
	
	/**
	 * @param unknown_type $documentCustomFilter
	 */
	public function setDocumentCustomFilter($documentCustomFilter) {
		$this->documentCustomFilter = $documentCustomFilter;
	}
	
	/**
	 * @param unknown_type $documentElements
	 */
	public function setDocumentElements($documentElements) {
		$this->documentElements = $documentElements;
	}
	
	/**
	 * @param unknown_type $documentID
	 */
	public function setDocumentID($documentID) {
		$this->documentID = $documentID;
	}
	
	/**
	 * @param unknown_type $documentScheduler
	 */
	public function setDocumentScheduler($documentScheduler) {
		$this->documentScheduler = $documentScheduler;
	}
	
	/**
	 * @param unknown_type $documentTable
	 */
	public function setDocumentTable($documentTable) {
		$this->documentTable = $documentTable;
	}
	
	/**
	 * @param unknown_type $Extension
	 */
	public function setExtension($extension) {
		$this->extension = $extension;
	}
	
	/**
	 * @param unknown_type $ExtraTemplates
	 */
	public function setExtraTemplates($extraTemplates) {
		$this->extraTemplates = $extraTemplates;
	}
	
	/**
	 * @param unknown_type $ExtraWorkspaces
	 */
	public function setExtraWorkspaces($extraWorkspaces) {
		$this->extraWorkspaces = $extraWorkspaces;
	}
	
	/**
	 * @param unknown_type $ExtraWorkspacesSelected
	 */
	public function setExtraWorkspacesSelected($extraWorkspacesSelected) {
		$this->extraWorkspacesSelected = $extraWorkspacesSelected;
	}
	
	/**
	 * @param unknown_type $Filename
	 */
	public function setFilename($filename) {
		$this->filename = $filename;
	}
	
	/**
	 * @param unknown_type $fromImport
	 */
	public function setFromImport($fromImport) {
		$this->fromImport = $fromImport;
	}
	
	/**
	 * @param unknown_type $fromScheduler
	 */
	public function setFromScheduler($fromScheduler) {
		$this->fromScheduler = $fromScheduler;
	}
	
	/**
	 * @param unknown_type $Icon
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}
	
	/**
	 * @param unknown_type $ID
	 */
	public function setID($iD) {
		$this->iD = $iD;
	}
	
	/**
	 * @param unknown_type $IP
	 */
	public function setIP($iP) {
		$this->iP = $iP;
	}
	
	/**
	 * @param unknown_type $IsClassFolder
	 */
	public function setIsClassFolder($isClassFolder) {
		$this->isClassFolder = $isClassFolder;
	}
	
	/**
	 * @param unknown_type $IsDynamic
	 */
	public function setIsDynamic($isDynamic) {
		$this->isDynamic = $isDynamic;
	}
	
	/**
	 * @param unknown_type $IsNotEditable
	 */
	public function setIsNotEditable($isNotEditable) {
		$this->isNotEditable = $isNotEditable;
	}
	
	/**
	 * @param unknown_type $IsSearchable
	 */
	public function setIsSearchable($isSearchable) {
		$this->isSearchable = $isSearchable;
	}
	
	/**
	 * @param unknown_type $Language
	 */
	public function setLanguage($language) {
		$this->language = $language;
	}
	
	/**
	 * @param unknown_type $modifications
	 */
	public function setModifications($modifications) {
		$this->modifications = $modifications;
	}
	
	/**
	 * @param unknown_type $modifierID
	 */
	public function setModifierID($modifierID) {
		$this->modifierID = $modifierID;
	}
	
	/**
	 * @param unknown_type $ObjectID
	 */
	public function setObjectID($objectID) {
		$this->objectID = $objectID;
	}
	
	/**
	 * @param unknown_type $Owners
	 */
	public function setOwners($owners) {
		$this->owners = $owners;
	}
	
	/**
	 * @param unknown_type $OwnersReadOnly
	 */
	public function setOwnersReadOnly($ownersReadOnly) {
		$this->ownersReadOnly = $ownersReadOnly;
	}
	
	/**
	 * @param unknown_type $ParentID
	 */
	public function setParentID($parentID) {
		$this->parentID = $parentID;
	}
	
	/**
	 * @param unknown_type $Path
	 */
	public function setPath($path) {
		$this->path = $path;
	}
	
	/**
	 * @param unknown_type $resetFromVersion
	 */
	public function setResetFromVersion($resetFromVersion) {
		$this->resetFromVersion = $resetFromVersion;
	}
	
	/**
	 * @param unknown_type $RestrictOwners
	 */
	public function setRestrictOwners($restrictOwners) {
		$this->restrictOwners = $restrictOwners;
	}
	
	function setStatus($status) {
		$this->status = $status; 
	}
	
	/**
	 * @param unknown_type $TableID
	 */
	public function setTableID($tableID) {
		$this->tableID = $tableID;
	}
	
	/**
	 * @param unknown_type $TemplateID
	 */
	public function setTemplateID($templateID) {
		$this->templateID = $templateID;
	}
	
	/**
	 * @param unknown_type $Templates
	 */
	public function setTemplates($templates) {
		$this->templates = $templates;
	}
	
	/**
	 * @param unknown_type $Text
	 */
	public function setText($text) {
		$this->text = $text;
	}
	
	/**
	 * @param unknown_type $timestamp
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}
	
	function setVersion($version) {
		$this->version = $version; 
	}
	
	/**
	 * @param unknown_type $WebUserID
	 */
	public function setWebUserID($webUserID) {
		$this->webUserID = $webUserID;
	}
	
	/**
	 * @param unknown_type $Workspaces
	 */
	public function setWorkspaces($workspaces) {
		$this->workspaces = $workspaces;
	}
	
   /**
	*  Constructor for class 'weVersions'
	*/
	public function __construct(){
			
		$this->contentTypes = $this->getContentTypesVersioning();
		
		if (!is_dir($_SERVER["DOCUMENT_ROOT"].VERSION_DIR)) {
			createLocalFolder($_SERVER["DOCUMENT_ROOT"], VERSION_DIR);
		}
		
		/**
		* fields from tblFile and tblObjectFiles which can be modified
		*/
		$this->modFields = array(
			'status'=> 1, 
			'ParentID'=> 2, 
			'Text'=> 3, 
			'IsSearchable' => 4, 
			'Category' => 5, 
			'CreatorID' => 6, 
			'RestrictOwners' => 7,
			'Owners' => 8,
			'OwnersReadOnly' => 9,
			'Language' => 10,
			'WebUserID' => 11,
			'documentElements' => 12,
			'documentScheduler' => 13,
			'documentCustomFilter' => 14,
			'TemplateID' => 15,
			'Filename' => 16,
			'Extension' => 17,
			'IsDynamic' => 18,
			'DocType' => 19,
			'Workspaces' => 20,
			'ExtraWorkspaces' => 21,
			'ExtraWorkspacesSelected' => 22,
			'Templates' => 23,
			'ExtraTemplates' => 24,
			'Charset' => 25
		);	
	}
	
  	/**
	* ContentTypes which apply for versioning
	* all except classes, templates and folders 
	*/ 
	public function getContentTypesVersioning() {
		
		$contentTypes = array();
		$contentTypes[] = 'all';
		foreach($GLOBALS["WE_CONTENT_TYPES"] as $k => $v) {
			if($k != "object" && $k != "text/weTmpl" && $k != "folder") {
				$contentTypes[] = $k;
			}
		}
		return $contentTypes;
	}
	
	 /**
	* @abstract set first document object if no versions exist
	* for contentType = text/webedition 
	*/
	public function setInitialDocObject($obj) {
		if(is_object($obj)) {	
			$_SESSION['versions']['versionToCompare'] = serialize($obj);
			if(in_array($obj->ContentType,$this->getContentTypesVersioning()) && $obj->ID!=0 && !$this->versionsExist($obj->ID, $obj->ContentType)) {
			    $_SESSION['versions']['initialVersions'] = true;
				$this->save($obj);
			}
		}
	}
	
   /**
	* @abstract count versions
	*/
	public function countVersions($id, $contentType) {
		
		$countVersions = f("SELECT COUNT(*) AS Count FROM ".VERSIONS_TABLE." WHERE documentId = '".$id."' AND ContentType = '".$contentType."'","Count", new DB_WE());
		return $countVersions;
	}
	
	 /**
	* @abstract looks if versions exist for the document
	*/
	public static function versionsExist($id, $contentType) {
		if(self::countVersions($id, $contentType)==0) {
			return false;
		}
		return true;
	}
	
   /**
	* @abstract get versions of one document / object
	* @return array of version-records of one document / object
	*/
	function loadVersionsOfId($id, $table, $where="") {
		
		$versionArr = array();
		$versionArray = array();
		$db = new DB_WE();
		$tblFields = weVersions::getFieldsFromTable(VERSIONS_TABLE);
		
		$query = "SELECT * FROM " . VERSIONS_TABLE . " WHERE documentID='".$id."' AND documentTable='".$table."' ".$where." ORDER BY version ASC";
		$db->query($query);
		while($db->next_record()){
			foreach($tblFields as $k => $v) {
				$versionArray[$v] = $db->f("".$v."");
			}
			
			$versionArr[] = $versionArray;
		}

		return $versionArr;
		
	}
	
   /**
	* @abstract get one version of document / object
	* @return array of version-records of one document / object
	*/
	function loadVersion($where="1") {
		
		$versionArray = array();
		$db = new DB_WE();
		$tblFields = weVersions::getFieldsFromTable(VERSIONS_TABLE);
		
		$query = "SELECT * FROM " . VERSIONS_TABLE . " ". $where." ";
		$db->query($query);
		while($db->next_record()){
			foreach($tblFields as $k => $v) {
				$versionArray[$v] = $db->f("".$v."");
			}
		}

		return $versionArray;
		
	}

   /**
	* @abstract cases in which versions are created
	* 1. if documents are imported
	* 2. there exists no version-record of a document but in tblfile oder tblobjectsfile (document/object was not created new)
	* 3. if document / object is saved, published or unpublished
	*/
	function save($docObj, $status = "saved") {
		
		if(isset($_SESSION["user"]["ID"])) {
			$_SESSION["Versions"]['fromImport'] = 0;
			
			//import
			if(isset($_REQUEST["jupl"]) && $_REQUEST["jupl"]){
				$_SESSION["Versions"]['fromImport'] = 1;
				$this->saveVersion($docObj);
			}
			elseif(isset($_REQUEST["pnt"]) && $_REQUEST["pnt"]=="wizcmd"){
				if($_REQUEST["v"]["type"] == "CSVImport" || $_REQUEST["v"]["type"] == "GXMLImport") {
					$_SESSION["Versions"]['fromImport'] = 1;
					$this->saveVersion($docObj);
				}
				elseif(isset($_SESSION["ExImRefTable"])){
					foreach($_SESSION["ExImRefTable"] as $k => $v) {
						if($v["ID"]==$docObj->ID) {
							$_SESSION["Versions"]['fromImport'] = 1;
							$this->saveVersion($docObj);
						}
					}
				}
			}
			elseif(isset($_REQUEST["we_cmd"][0]) && ($_REQUEST["we_cmd"][0]=="siteImport" || $_REQUEST["we_cmd"][0]=="import_files")){
				$_SESSION["Versions"]['fromImport'] = 1;
				$this->saveVersion($docObj);
			}
			else {
				if((isset($_REQUEST["we_cmd"][0]) && ($_REQUEST["we_cmd"][0]=="save_document" || $_REQUEST["we_cmd"][0]=="unpublish" || $_REQUEST["we_cmd"][0]=="revert_published")) 
					|| (isset($_REQUEST["cmd"]) && ($_REQUEST["cmd"]=="ResetVersion" || $_REQUEST["cmd"]=="PublishDocs" || $_REQUEST["cmd"]=="ResetVersionsWizard")) 
					|| (isset($_REQUEST["type"]) && $_REQUEST["type"]=="reset_versions")
					|| $_SESSION['versions']['initialVersions']){
						if(isset($_SESSION['versions']['initialVersions'])) {
							unset($_SESSION['versions']['initialVersions']);
						}
						$this->saveVersion($docObj, $status);
				}
				
			}
		}

	}
	
	/**
	* @abstract apply preferences 
	*/
	function CheckPreferencesCtypes($ct) {
		
		//if folder was saved don' make versions (if path was changed of folder)
		if(isset($GLOBALS['we_doc']->ClassName)) {
			if ($GLOBALS['we_doc']->ClassName=="we_folder") {
				return false;
			}
		}

		//apply content types in preferences 

		switch ($ct) {
			case "text/webedition":
				if(defined("VERSIONING_TEXT_WEBEDITION") && !VERSIONING_TEXT_WEBEDITION) return false;
				if(!defined("VERSIONING_TEXT_WEBEDITION")) return false;
			break;
			case "image/*":
				if(defined("VERSIONING_IMAGE") && !VERSIONING_IMAGE) return false;
				if(!defined("VERSIONING_IMAGE")) return false;
			break;
			case "text/html":
				if(defined("VERSIONING_TEXT_HTML") && !VERSIONING_TEXT_HTML) return false;
				if(!defined("VERSIONING_TEXT_HTML")) return false;
			break;
			case "text/js":
				if(defined("VERSIONING_TEXT_JS") && !VERSIONING_TEXT_JS) return false;
				if(!defined("VERSIONING_TEXT_JS")) return false;
			break;
			case "text/css":
				if(defined("VERSIONING_TEXT_CSS") && !VERSIONING_TEXT_CSS) return false;
				if(!defined("VERSIONING_TEXT_CSS")) return false;
			break;
			case "text/plain":
				if(defined("VERSIONING_TEXT_PLAIN") && !VERSIONING_TEXT_PLAIN) return false;
				if(!defined("VERSIONING_TEXT_PLAIN")) return false;
			break;
			case "application/x-shockwave-flash":
				if(defined("VERSIONING_FLASH") && !VERSIONING_FLASH) return false;
				if(!defined("VERSIONING_FLASH")) return false;
			break;
			case "video/quicktime":
				if(defined("VERSIONING_QUICKTIME") && !VERSIONING_QUICKTIME) return false;
				if(!defined("VERSIONING_QUICKTIME")) return false;
			break;
			case "application/*":
				if(defined("VERSIONING_SONSTIGE") && !VERSIONING_SONSTIGE) return false;
				if(!defined("VERSIONING_SONSTIGE")) return false;
			break;
			case "text/xml":
				if(defined("VERSIONING_TEXT_XML") && !VERSIONING_TEXT_XML) return false;
				if(!defined("VERSIONING_TEXT_XML")) return false;
			break;
			case "objectFile":
				if(defined("VERSIONING_OBJECT") && !VERSIONING_OBJECT) return false;
				if(!defined("VERSIONING_OBJECT")) return false;
			break;
		}

		return true;
	}
	
	function CheckPreferencesTime($docID, $docTable) {
		
		$db = new DB_WE();
				
		$prefTimeDays = (defined("VERSIONS_TIME_DAYS") && VERSIONS_TIME_DAYS!="-1") ? VERSIONS_TIME_DAYS : ""; 
		$prefTimeWeeks = (defined("VERSIONS_TIME_WEEKS") && VERSIONS_TIME_WEEKS!="-1") ? VERSIONS_TIME_WEEKS : ""; 
		$prefTimeYears = (defined("VERSIONS_TIME_YEARS") && VERSIONS_TIME_YEARS!="-1") ? VERSIONS_TIME_YEARS : ""; 
		
		$prefTime = 0;
		if($prefTimeDays!="") {
			$prefTime = $prefTime + $prefTimeDays;
		}
		if($prefTimeWeeks!="") {
			$prefTime = $prefTime + $prefTimeWeeks;
		}
		if($prefTimeYears!="") {
			$prefTime = $prefTime + $prefTimeYears;
		}
		
		if($prefTime!=0) {
			$deletetime = time() - $prefTime;
			//initial version always stays
			$where = " timestamp < ".$deletetime." AND CreationDate!=timestamp ";
			$this->deleteVersion("", $where);
		}
		
		$prefAnzahl = (defined("VERSIONS_ANZAHL") && VERSIONS_ANZAHL!="") ? VERSIONS_ANZAHL : ""; 

		$anzahl = f("SELECT COUNT(*) AS Count FROM ".VERSIONS_TABLE." WHERE documentId = '".$docID."' AND documentTable = '".$docTable."'","Count",$db);

		if($anzahl > $prefAnzahl && $prefAnzahl!="") {
			$toDelete = $anzahl - $prefAnzahl;
			$query = "SELECT ID, version FROM ".VERSIONS_TABLE." WHERE documentId = '".$docID."' AND documentTable = '".$docTable."' ORDER BY version ASC";
			$m = 0;
			$db->query($query);
			while ($db->next_record()) {
				if($m<$toDelete) {
					$this->deleteVersion($db->f('ID'), "");
					$m++;
				}
			} 	
		}
	}
	
		
   /**
	* @abstract make new version-entry in DB
	*/
	function saveVersion($document, $status = "saved") {
		
		$documentObj = "";
		$db = new DB_WE();
		if(is_object($document)) {
			$documentObj = $document;
			$document = $this->objectToArray($document);
		}
		
		if(isset($document["documentCustomerFilter"]) && is_object($document["documentCustomerFilter"])) {
			$document["documentCustomerFilter"] = $this->objectToArray($document["documentCustomerFilter"]);
		}
		
		$writeVersion = true;
		
		//preferences
		if(!$this->CheckPreferencesCtypes($document["ContentType"])) {
			$writeVersion = false;
		}

		if((isset($_REQUEST["we_cmd"][0]) && $_REQUEST["we_cmd"][0]=="save_document")) {
			if(isset($_REQUEST["we_cmd"][5]) && $_REQUEST["we_cmd"][5]) {
				$status = "published";
			}
		}
		
		if($document["ContentType"]!="objectFile" && $document["ContentType"]!="text/webedition" && $document["ContentType"]!="text/html") {
			$status = "saved";
		}
		
		if($this->IsScheduler()) {
			if($status != "unpublished" && $status != "deleted") {
				$status = "published";
			}
		}
		
		if(isset($_SESSION['versions']['doPublish']) && $_SESSION['versions']['doPublish']) {
			$status = "published";
		}
		
		if($document["ContentType"]=="objectFile" || $document["ContentType"]=="text/webedition" || $document["ContentType"]=="text/html") {
			if((defined("VERSIONS_CREATE") && VERSIONS_CREATE) && $status != "published" && isset($_REQUEST["we_cmd"][5]) && !$_REQUEST["we_cmd"][5]) {
				$writeVersion = false;
			}
		}
		
		//look if there were made changes
		if(isset($_SESSION['versions']['versionToCompare']) && $_SESSION['versions']['versionToCompare']!='') {
			$lastEntry = unserialize($_SESSION['versions']['versionToCompare']);
			$lastEntry = $this->objectToArray($lastEntry);
			$diffExists = array();
			if(is_array($document) && is_array($lastEntry)) {
				$diffExists = $this->array_diff_values($document, $lastEntry);
			}
			$lastEntry = $this->getLastEntry($document["ID"],$document["Table"]);
		
			if((($status=='published' || $status=='saved') && isset($lastEntry['status']) && $status==$lastEntry['status']) && empty($diffExists) && $this->versionsExist($document["ID"],$document["ContentType"])) {
				$writeVersion = false;
			}
		}
		
		if($writeVersion) {
			$mods = true;
			$tblversionsFields = $this->getFieldsFromTable(VERSIONS_TABLE);
			
			$keys = array();
			$vals = array();
	
			for($i=0;$i<count($tblversionsFields);$i++){
				
				$fieldName = $tblversionsFields[$i];
				if($fieldName!="ID") {
					$keys[] = $fieldName;
				
					if(isset($document[$fieldName])) {
						$vals[] = "'".$document[$fieldName]."'";
					}
					else {
						$entry = $this->makePersistentEntry($fieldName, $status, $document, $documentObj);
						$vals[] = "'".$entry."'";
					}	
				}
			}
			
			if(!empty($keys) && !empty($vals) && $mods){
							
				$theKeys = "(". makeCSVFromArray($keys) .")";
				$theValues = "VALUES(". makeCSVFromArray($vals) .")";
				
				$q = "INSERT INTO ".VERSIONS_TABLE." ".$theKeys ." ". $theValues."";
				$db->query($q);
			
				$vers = $this->version;
				if(isset($document["version"])) {
					$vers = $document["version"];
				}
				$q2 = "UPDATE ".VERSIONS_TABLE." SET active = '0' WHERE documentID = '".$document["ID"]."' AND documentTable = '".$document["Table"]."' AND version != '".$vers."'";
				$db->query($q2);	
				
				$_SESSION['versions']['versionToCompare'] = serialize($documentObj);
			}
		}
					
		$this->CheckPreferencesTime($document["ID"], $document["Table"]);
				
	}	
	
	
   /**
	* @abstract give the persistent fieldnames the values if you save, publish or unpublish
	* persistent fieldnames are fields which are not in tblfile or tblobjectsfile and are always saved
	* @return value of field
	*/
	function makePersistentEntry($fieldName, $status, $document, $documentObj) {
			
		$entry = "";			
		$db = new DB_WE();
		
		switch($fieldName) {
			case "documentID":
				$entry = $document["ID"];
			break;
			case "documentTable":
				$entry = $document["Table"];
			break;
			case "documentElements":
				if(!empty($document["elements"]) && is_array($document["elements"])) {						
					$entry = urlencode(htmlentities(serialize($document["elements"]), ENT_QUOTES));
				}
			break;
			case "documentScheduler":
				if(!empty($document["schedArr"]) && is_array($document["schedArr"])) {
					$entry = urlencode(htmlentities(serialize($document["schedArr"]), ENT_QUOTES));
				}
			break;
			case "documentCustomFilter":
				if(!empty($document["documentCustomerFilter"]) && is_array($document["documentCustomerFilter"])) {
					$entry = urlencode(htmlentities(serialize($document["documentCustomerFilter"]), ENT_QUOTES));
				}
			break;
			case "timestamp":
				$lastEntryVersion = f("SELECT ID FROM " . VERSIONS_TABLE . " WHERE documentID='".$document["ID"]."' AND documentTable='".$document["Table"]."' LIMIT 1","ID", $db);
				if($lastEntryVersion) {
					$entry = time();
				}
				else {
					$entry = $document['CreationDate'];
				}
			break;
			case "status":
				$this->setStatus($status);
				$entry = $status;
			break;
			case "version":
				$lastEntryVersion = f("SELECT version FROM " . VERSIONS_TABLE . " WHERE documentID='".$document["ID"]."' AND documentTable='".$document["Table"]."' ORDER BY version DESC LIMIT 1","version",$db);
				if($lastEntryVersion) {
					$newVersion = $lastEntryVersion + 1;
					$this->setVersion($newVersion);
				}
				$entry = $this->getVersion();
			break;
			case "binaryPath":
				$binaryPath =  "";
		
					$binaryPath = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE binaryPath!='' AND version<'".$this->version."' AND documentTable='".$document['Table']."' AND documentID='".$document['ID']."'  ORDER BY version DESC limit 1 ","binaryPath",$db);
							
					if($document["ContentType"]=="objectFile") {
						$binaryPath = "";
					}
					else {	
						$documentPath = substr($document["Path"], 1); 
						$siteFile = $_SERVER["DOCUMENT_ROOT"].SITE_DIR.$documentPath;
						
						$vers = $this->getVersion();
						$versionName = $document["ID"]."_".$document["Table"]."_".$vers.$document["Extension"];
						$binaryPath = VERSION_DIR.$versionName;


						if($document["IsDynamic"]) {
							$this->writePreviewDynFile($document['ID'], $siteFile, $_SERVER["DOCUMENT_ROOT"].$binaryPath, $documentObj);
						}
						elseif(file_exists($siteFile)) {
							copy($siteFile,$_SERVER["DOCUMENT_ROOT"].$binaryPath);
						}								
						
					}
		
				$this->binaryPath = $binaryPath;
				$entry = $binaryPath;
			break;
			case "modifications":
				
				$modifications = array();

				/* get fields which can be changed */
				$fields = $this->getFieldsFromTable(VERSIONS_TABLE);
			
				foreach($fields as $key => $val) {
					if(isset($this->modFields[$val])) {
						
						$query = "SELECT ".$val." FROM " . VERSIONS_TABLE . " WHERE version <'".$this->version."' AND status != 'deleted' AND documentID='".$document["ID"]."' AND documentTable='".$document["Table"]."' ORDER BY version DESC LIMIT 1";
						$db->query($query);
						if($db->next_record()){
							$lastEntryField = $db->f("".$val."");
						}
						
						if(isset($lastEntryField)) {
							
							if($val=="Text" && $document["ContentType"]!="objectFile") {
								$val="";
							}
							
							if(isset($document[$val])) {
								if($document[$val]=="") {
									if($val=="TemplateID") {
										$document[$val] = 0;
									}
									if($val=="WebUserID") {
										$document[$val] = 0;
									}
									if($val=="IsSearchable") {
										$document[$val] = 0;
									}
								}
								//if($lastEntryField!="" && $document[$val]!="") {
									if($document[$val]!=$lastEntryField) {
										
										$modifications[] = $val;
									}
								//}
								elseif(($lastEntryField=="" && $document[$val]=="") || ($lastEntryField==$document[$val])) {
									// do nothing
								}
								else {
									$modifications[] = $val;
								}
								
							}						
							else {							
								if($val=="documentElements" || $val=="documentScheduler" || $val=="documentCustomFilter") {
									$newData = array();
									$diff = array();
									$lastEntryField = unserialize(html_entity_decode(urldecode($lastEntryField), ENT_QUOTES));
									if($lastEntryField=="") {
										$lastEntryField = array();
									}
									
									switch ($val) {
										case "documentElements":
											if(!empty($document["elements"])) {
												$newData = $document["elements"];
												foreach($newData as $k=>$vl) {
													if(isset($lastEntryField[$k]) && is_array($lastEntryField[$k]) && is_array($vl)) {
														$_diff = array_diff_assoc($vl, $lastEntryField[$k]);
														if(!empty($_diff) && isset($_diff['dat'])) {
															$diff[] = $_diff;
														}
													}
												}
											}
										break;
										case "documentScheduler":
										if(empty($document["schedArr"]) && !empty($lastEntryField)) {
											$diff['schedArr'] = true;
										}
										elseif(!empty($document["schedArr"]) && empty($lastEntryField)) {
											$diff['schedArr'] = true;
										}
										if(!empty($document["schedArr"])) {
												$newData = $document["schedArr"];
												foreach($newData as $k=>$vl) {
													 if(isset($lastEntryField[$k]) && is_array($lastEntryField[$k]) && is_array($vl)) {	
													 	$_diff = array_diff_assoc($vl, $lastEntryField[$k]);
														if(!empty($_diff)) {
															$diff = $_diff;
														}
														 foreach($vl as $_k=>$_v) {
															 if(isset($lastEntryField[$k][$_k]) && is_array($lastEntryField[$k][$_k]) && is_array($_v)) {
															 	$_diff2 = array_diff_assoc($_v, $lastEntryField[$k][$_k]);
																if(!empty($_diff2)) {
																	$diff = $_diff2;
																}
															 }
														}
													 }
												}
											}
										break;
										case "documentCustomFilter":
										if(is_array($document["documentCustomerFilter"]) && is_array($lastEntryField)) {
											$_diff = array_diff_assoc($document["documentCustomerFilter"], $lastEntryField);
											if(!empty($_diff)) {
												$diff['documentCustomerFilter'] = $_diff;
											}
										}

										break;
									}

									if(!empty($diff)) {
										$modifications[] = $val;
									}		
									
								}
								if($document["ContentType"]=="application/x-shockwave-flash" || $document["ContentType"]=="application/*" 
								 	|| $document["ContentType"]=="video/quicktime" || $document["ContentType"]=="image/*") {
									if($val=="binaryPath" && $this->binaryPath!="" && $lastEntryField!=$this->binaryPath) {
										//$modifications[] = $val;
									}
								}
								
								if($val=="status" && $lastEntryField!=$this->status) {
									$modifications[] = $val;
								}
							}
						}			
					}
				}
				
				$modConstants = $this->getConstantsOfMod($modifications);
									
				if($modConstants!="") {
					$entry = $modConstants;
				}
				else {
					$entry = "";
				}
			break;
			case "modifierID":
				$modifierID = $_SESSION["user"]["ID"];
				$entry = $modifierID;
			break;
			case "IP":
				$ip = $_SERVER['REMOTE_ADDR'];
				$entry = $ip;
			break;
			case "Browser":
				$browser = $_SERVER['HTTP_USER_AGENT'];
				$entry = $browser;
			break;
			case "active":
				$entry = 1;
			break;
			case "fromScheduler":
				$entry = $this->IsScheduler();
			break;
			case "fromImport":
				$entry = (isset($_SESSION["Versions"]['fromImport']) && $_SESSION["Versions"]['fromImport']) ? 1 : 0;
			break;
			case "resetFromVersion":
				$entry = (isset($document["resetFromVersion"]) && $document["resetFromVersion"]!="") ? $document["resetFromVersion"] : 0 ;
				break;
			default:
				$entry = "";
		}
	
		return $entry;
		
	}
	
	
   /**
	* @abstract look if scheduler was called
	* @return boolean
	*/
	function IsScheduler() {
		
		$fromScheduler = 0;
		if(isset($_SESSION["Versions"]['fromScheduler'])) {
			$fromScheduler = $_SESSION["Versions"]['fromScheduler'];
		}
		
		return $fromScheduler;
	}
		
	/**
	* @abstract get differences between two arrays
	* @return array with difference
	*/
	function array_diff_values( $newArr, $oldArr) {

		$diff = array();

		if(!is_array($newArr)) {
			$newArr = array();
		}
		if(!is_array($oldArr)) {
			$oldArr = array();
		}
		if(empty($newArr) && empty($oldArr)) {	
		}
		elseif(!empty($newArr) && !empty($oldArr)) {

			$_diff = array_diff_assoc($newArr, $oldArr);
			if(isset($_diff['Published'])) {
				unset($_diff['Published']); 
			}
			if(isset($_diff['ModDate'])) {
				unset($_diff['ModDate']); 
			}
			if(isset($_diff['EditPageNr'])) {
				unset($_diff['EditPageNr']); 
			}
			if(isset($_diff['DocStream'])) {
				unset($_diff['DocStream']); 
			}
			if(isset($_diff['DB_WE'])) {
				unset($_diff['DB_WE']); 
			}
			if(!empty($_diff)) {
				$diff = $_diff;
			}
			
			foreach ( $newArr as $k => $v ) {
				if(is_array($v)) {
					if($k=='schedArr') {
						if(empty($v) && !empty($oldArr['schedArr'])) {
							$diff['schedArr'] = true;
						}
						elseif(!empty($v) && empty($oldArr['schedArr'])) {
							$diff['schedArr'] = true;
						}
						else {
							foreach($v as $key=>$val) {
								 if(isset($oldArr['schedArr'][$key]) && is_array($oldArr['schedArr'][$key]) && is_array($val)) {
								 	
								 	$_diff = array_diff_assoc($val, $oldArr['schedArr'][$key]);
									if(!empty($_diff)) {
										$diff['schedArr'][$key] = $_diff;
									}
									foreach($val as $_k=>$_v) {
										 if(isset($oldArr['schedArr'][$key][$_k]) && is_array($oldArr['schedArr'][$key][$_k]) && is_array($_v)) {
										 	$_diff2 = array_diff_assoc($_v, $oldArr['schedArr'][$key][$_k]);
											if(!empty($_diff2)) {
												$diff['schedArr'][$key][$_k] = $_diff2;
											}
										 }
									}
								 }
							}
						}
					}
					elseif($k=='elements') {
						foreach($v as $key=>$val) {
							 if(isset($oldArr['elements'][$key]) && is_array($oldArr['elements'][$key]) && is_array($val)) {
							 	$_diff = array_diff_assoc($val, $oldArr['elements'][$key]);
								if(!empty($_diff) && isset($_diff['dat'])) {
									$diff['elements'][$key] = $_diff;
								}
							 }
						}
					}
					elseif($k=='documentCustomerFilter') {
						if(is_array($v) && isset($oldArr['documentCustomerFilter']) && is_array($oldArr['documentCustomerFilter'])) {
							$_diff = array_diff_assoc($v, $oldArr['documentCustomerFilter']);
							if(!empty($_diff)) {
								$diff['documentCustomerFilter'][$key] = $_diff;
							}
						}
					}
				}				
			}
		}
		else {
			$diff[] = true;
		}

		return $diff;
	}

	
   /**
	* @abstract create file to preview dynamic documents
	*/
	function writePreviewDynFile($id, $siteFile,$tmpFile,$document) {
		
		$out = $this->getDocContent($document, $siteFile);
		weFile::save($tmpFile,$out);

	}
	
	function getDocContent($we_doc, $includepath="") {

		$contents = "";
		$requestBackup = $_REQUEST;
		$docBackup = $GLOBALS["we_doc"];
		//$_REQUEST = "";
		
		$glob = "";
		foreach($GLOBALS as $k=>$v){
			if((!ereg('^[0-9]',$k)) && (!eregi('[^a-z0-9_]',$k)) && $k != "FROM_WE_SHOW_DOC" && $k != "we_doc" && $k != "we_transaction" && $k != "GLOBALS" && $k != "HTTP_ENV_VARS" && $k != "HTTP_POST_VARS" && $k != "HTTP_GET_VARS" && $k != "HTTP_COOKIE_VARS" && $k != "HTTP_SERVER_VARS" && $k != "HTTP_POST_FILES" && $k != "HTTP_SESSION_VARS" && $k != "_GET" && $k != "_POST" && $k != "_REQUEST" && $k != "_SERVER" && $k != "_FILES" && $k != "_SESSION" && $k != "_ENV" && $k != "_COOKIE" && $k!="") $glob .= '$'.$k.",";
		}
		$glob = ereg_replace('(.*),$','\1',$glob);
		eval('global '.$glob.';');

		//$GLOBALS["we_doc"] = $we_doc;
		
		$isdyn = !isset($GLOBALS["WE_IS_DYN"]) ? 'notSet' : $GLOBALS["WE_IS_DYN"];

		if($includepath!='' && file_exists($includepath)) {
			ob_start();
			include($includepath);
			$contents = ob_get_contents();
    		ob_end_clean();
		}
		else {
			ob_start();
			$noSess = true;
			$GLOBALS["WE_IS_DYN"] = 1;
			$we_transaction = "";
			$we_ContentType = $we_doc->ContentType;
			$_REQUEST["we_cmd"] = array();
			$_REQUEST["we_cmd"][1] = $we_doc->ID;
			$FROM_WE_SHOW_DOC = true;
			include($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_showDocument.inc.php");
			$contents = ob_get_contents();
    		ob_end_clean();
		}

		$GLOBALS["we_doc"] = $docBackup;
		$_REQUEST = $requestBackup;
		
		if($isdyn=='notSet') {
			if(isset($GLOBALS["WE_IS_DYN"])) {
				unset($GLOBALS["WE_IS_DYN"]);
			}
		}
		else {
			$GLOBALS["WE_IS_DYN"] = $isdyn;
		}

		return $contents;
	}
		
	
	
   /**
	* @abstract save version-entry in DB which is marked as deleted
	*/
	function setVersionOnDelete($docID, $docTable) {
		
		if(isset($_SESSION["user"]["ID"])) {
			$lastEntry = $this->getLastEntry($docID, $docTable);
			
			$lastEntry['timestamp'] = time();
			$lastEntry['status'] = "deleted";
			$lastEntry['version'] = (isset($lastEntry['version'])) ? $lastEntry['version'] + 1 : 1;
			$lastEntry['modifications'] = 1;
			$lastEntry['modifierID'] = $_SESSION["user"]["ID"];
			$lastEntry['IP'] = $_SERVER['REMOTE_ADDR'];
			$lastEntry['Browser'] = $_SERVER['HTTP_USER_AGENT'];
			$lastEntry['active'] = 1;
			$lastEntry['fromScheduler'] = $this->IsScheduler();	
	
				
			
			$keys = array();
			$vals = array();
					
			foreach($lastEntry as $k => $v){
				if($k!="ID") {
					$keys[] = $k;
					$vals[] = "'".$v."'";	
				}
			}
			
			$doDelete = true;
			//preferences
			if(!$this->CheckPreferencesCtypes($lastEntry['ContentType'])) {
				$doDelete = false;
			}
			
	
			if(defined("VERSIONS_CREATE") && VERSIONS_CREATE) {
				$doDelete = false;
			}
			
	
			if(!empty($keys) && !empty($vals) && $doDelete){
							
				$theKeys = "(". makeCSVFromArray($keys) .")";
				$theValues = "VALUES(". makeCSVFromArray($vals) .")";
				
				$q = "INSERT INTO ".VERSIONS_TABLE." ".$theKeys ." ". $theValues."";
				$db = new DB_WE();
				$db->query($q);
				
				$q2 = "UPDATE ".VERSIONS_TABLE." SET active = '0' WHERE documentID = '".$docID."' AND documentTable = '".$docTable."' AND version != '".$lastEntry['version']."'";
					
				$db->query($q2);
			}
			
			$this->CheckPreferencesTime($docID, $docTable);
		}
	}
	
	
   /**
	* @abstract delete version entry from db and delete version files
	*/
	function deleteVersion($ID="", $where="") {
		
		$db = new DB_WE();
		
		
		if($ID!="") {
			$w = "ID = '" . $ID . "'";
		}
		elseif($where!="") {
			$w = $where;
		}
		
		$query = "SELECT ID,documentID,version,Text,ContentType,documentTable,Path,binaryPath FROM " . VERSIONS_TABLE . " WHERE ".$w." LIMIT 1";

		$db->query($query);
		$binaryPath = "";
		while ($db->next_record()) {
			$binaryPath = $db->f('binaryPath');	
			$_SESSION['versions']['logDeleteIds'][$db->f('ID')]['Text'] = $db->f('Text');	
			$_SESSION['versions']['logDeleteIds'][$db->f('ID')]['ContentType'] = $db->f('ContentType');	
			$_SESSION['versions']['logDeleteIds'][$db->f('ID')]['Path'] = $db->f('Path');		
			$_SESSION['versions']['logDeleteIds'][$db->f('ID')]['Version'] = $db->f('version');	
			$_SESSION['versions']['logDeleteIds'][$db->f('ID')]['documentID'] = $db->f('documentID');					
		}
		
		$filePath = $_SERVER["DOCUMENT_ROOT"].$binaryPath;
		$binaryPathUsed = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE ID!='".$ID."' AND binaryPath='".$binaryPath."' LIMIT 1","binaryPath",$db);

		if(file_exists($filePath) && $binaryPathUsed=="") {
			@unlink($filePath);
		}
		
		$query = "DELETE FROM ".VERSIONS_TABLE." WHERE ".$w." ;";
		
		$db->query($query);
	}
	
	 /**
	* @abstract reset version
	*/
	function resetVersion($ID, $version, $publish) {

		$db = new DB_WE();
		$db2 = new DB_WE();
		
		$resetArray = array();
		$tblFields = array();
		$tableInfo = $db->metadata(VERSIONS_TABLE);

		if(isset($_REQUEST["we_transaction"])) {
			$we_transaction = $_REQUEST["we_transaction"];
		}
		else {
			$we_transaction = $GLOBALS["we_transaction"];
		}
		
		
		for($i=0;$i<sizeof($tableInfo);$i++){
			$tblFields[] = $tableInfo[$i]["name"];
		}
		
		
		$query = "SELECT * FROM " . VERSIONS_TABLE . " WHERE ID='".$ID."'  ";

		$db->query($query);

		if($db->next_record()) {
			foreach($tblFields as $k => $v) {
				$resetArray[$v] = $db->f("".$v."");
			}
		}

		if(is_array($resetArray) && !empty($resetArray)) {
			if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$resetArray["ClassName"].".inc.php")){
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$resetArray["ClassName"].".inc.php");
			}
			elseif(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$resetArray["ClassName"].".inc.php")){
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$resetArray["ClassName"].".inc.php");
			}
				
			$resetDoc = new $resetArray["ClassName"]();
	
			foreach($resetArray as $k=>$v) {
		
				if(isset($resetDoc->$k)) {
					if($k!="ID") {
						$resetDoc->$k = $v;
					}	
				}
				elseif($k=="documentID") {
					$resetDoc->ID = $v;
				}
				elseif($k=="documentElements") {
					if($v!="") {
						$docElements = unserialize(html_entity_decode(urldecode($v), ENT_QUOTES));
						$resetDoc->elements = $docElements;
					}
				}
				elseif($k=="documentScheduler") {
					if($v!="") {
						$docElements = unserialize(html_entity_decode(urldecode($v), ENT_QUOTES));
						$resetDoc->schedArr = $docElements;
					}
				}
				elseif($k=="documentCustomFilter") {
					if($v!="") {
						$docElements = unserialize(html_entity_decode(urldecode($v), ENT_QUOTES));
						$resetDoc->documentCustomerFilter = new weDocumentCustomerFilter();
						foreach($docElements as $k => $v) {
							if(isset($resetDoc->documentCustomerFilter->$k)) {
								if($v!="" || !empty($v)) {
									$resetDoc->documentCustomerFilter->$k = $v;
								}
							}
						}
					}
				}
			}

			if($resetDoc->ContentType=="image/*") {
				$lastBinaryPath = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE documentID='".$resetArray["documentID"]."' AND documentTable='".$resetArray["documentTable"]."' AND version <='".$version."' AND binaryPath !='' ORDER BY version DESC LIMIT 1","binaryPath",$db);
				$resetDoc->elements["data"]["dat"] = $_SERVER["DOCUMENT_ROOT"].$lastBinaryPath;
			}
			
			$resetDoc->EditPageNr = $_SESSION['EditPageNr'];

			$existsInFileTable = f("SELECT ID FROM " . $resetArray["documentTable"] . " WHERE ID='".$resetDoc->ID."' ","ID",$db);
			//if document was deleted
			
			if(empty($existsInFileTable)) {
				//save this id and contenttype to turn the id for the versions
				$oldId = $resetDoc->ID;
				$oldCt = $resetDoc->ContentType;
				$resetDoc->ID = 0;
				$lastEntryVersion = f("SELECT version FROM " . VERSIONS_TABLE . " WHERE documentID='".$resetArray["documentID"]."' AND documentTable='".$resetArray["documentTable"]."' ORDER BY version DESC LIMIT 1","version",$db);				
				$resetDoc->version = $lastEntryVersion + 1;
			}
			
			if($resetArray["ParentID"]!=0) {
				//if folder was deleted
				$existsPath = f("SELECT Path FROM " . $resetArray["documentTable"] . " WHERE ID='".$resetArray["ParentID"]."' AND IsFolder='1' ","Path",$db);
			
				if(empty($existsPath)) {
					// create old folder if it does not exists
	
					$folders = explode("/", $resetArray["Path"]);
					foreach($folders as $k => $v) {
						if($k!=0 && $k!=(count($folders)-1)) {
							
							
							include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_folder.inc.php");
							
							$parentID = (isset($_SESSION['versions']['lastPathID'])) ? $_SESSION['versions']['lastPathID'] : 0;
							
							$folder= new we_folder();
							$folder->we_new();
							$folder->setParentID($parentID);
							$folder->Table=$resetArray["documentTable"];
							$folder->Text=$v;
							$folder->CreationDate=time();
							$folder->ModDate=time();
							$folder->Filename=$v;
							$folder->Published=time();
							$folder->Path=$folder->getPath();
							$folder->CreatorID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : "";
							$folder->ModifierID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : "";
							$existsFolderPathID = f("SELECT ID FROM " . $resetArray["documentTable"] . " WHERE Path='".$folder->Path."' AND IsFolder='1' ","ID",$db);
							if(empty($existsFolderPathID)) {
								$folder->we_save();
								$_SESSION['versions']['lastPathID'] = $folder->ID;
							}
							else {
								$_SESSION['versions']['lastPathID'] = $existsFolderPathID;
							}						
						}
					}
					
					$resetDoc->ID = 0;
					$resetDoc->ParentID = $_SESSION['versions']['lastPathID'];
					$resetDoc->Path = $resetArray["Path"];
					
				}
			}
			
			$existsFile = f("SELECT COUNT(*) as Count FROM " . $resetArray["documentTable"] . " WHERE ID!= '".$resetArray["documentID"]."' AND Path= '".$resetDoc->Path."' ","Count",$db);
			
			$doPark = false;
			if(!empty($existsFile)) {
				$resetDoc->Path = str_replace($resetDoc->Text, "_".$resetArray["documentID"]."_".$resetDoc->Text, $resetDoc->Path);
				$resetDoc->Text = "_".$resetArray["documentID"]."_".$resetDoc->Text;
				if(isset($resetDoc->Filename) && $resetDoc->Filename!="") {
					$resetDoc->Filename = "_".$resetArray["documentID"]."_".$resetDoc->Filename;
					$publish = 0;
					$doPark = true;
				}
				
			}
			
			if((isset($_SESSION['versions']['lastPathID']))) {
				unset($_SESSION['versions']['lastPathID']);
			}
			
			$resetDoc->resetFromVersion = $version;
			
			$resetDoc->saveInSession($_SESSION["we_data"][$we_transaction]);
	
			$GLOBALS['we_doc'] = $resetDoc;
			
			
			if(defined("WORKFLOW_TABLE")) {
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/"."weWorkflowUtility.php");
			}
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_temporaryDocument.inc.php");

			we_temporaryDocument::delete($resetDoc->ID);
			//$resetDoc->initByID($resetDoc->ID);
			$resetDoc->ModDate = time();
			$resetDoc->Published = $resetArray["timestamp"];
			
			$wasPublished = f("SELECT status FROM ".VERSIONS_TABLE." WHERE documentID= '".$resetArray["documentID"]."' AND documentTable= '".$resetArray["documentTable"]."' and status='published' ORDER BY version DESC LIMIT 1 ","status",$db);
			$publishedDoc = $_SERVER["DOCUMENT_ROOT"].$resetDoc->Path;
			$publishedDocExists = true;
			if($resetArray["ContentType"]!="objectFile") {
				$publishedDocExists = file_exists($publishedDoc);
			}
			if($doPark || $wasPublished=="" || !$publishedDocExists) {
				$resetDoc->Published = 0;
			}
			if($publish) {
				$_SESSION['versions']['doPublish'] = true;
			}
			$resetDoc->we_save();
			if($publish) {
				unset($_SESSION['versions']['doPublish']);
				$resetDoc->we_publish();
			}
			
			if(defined("WORKFLOW_TABLE") && $resetDoc->ContentType == "text/webedition") {
				if(weWorkflowUtility::inWorkflow($resetDoc->ID,$resetDoc->Table)){
					weWorkflowUtility::removeDocFromWorkflow($resetDoc->ID,$resetDoc->Table,$_SESSION["user"]["ID"],"");
				}
			}
			
			$_SESSION['versions']['logResetIds'][$resetArray['ID']]['Text'] = $resetArray['Text'];
			$_SESSION['versions']['logResetIds'][$resetArray['ID']]['ContentType'] = $resetArray['ContentType'];
			$_SESSION['versions']['logResetIds'][$resetArray['ID']]['Path'] = $resetArray['Path'];	
			$_SESSION['versions']['logResetIds'][$resetArray['ID']]['Version'] = $resetArray['version'];
			$_SESSION['versions']['logResetIds'][$resetArray['ID']]['documentID'] = $resetArray['documentID'];	

			//update versions if id or path were changed
			if(empty($existsInFileTable)) {
				$q = "UPDATE ".VERSIONS_TABLE." SET documentID = '".$resetDoc->ID."',ParentID = '".$resetDoc->ParentID."',active = '0' WHERE documentID = '".$oldId."' AND ContentType = '".$oldCt."'";
				$db->query($q);
			}
		}
	}
	
	
   /**
	* @abstract return the fieldvalue that has been changed
	*/
	function showValue($k, $v, $table) {
		
		$pathLength = 41;
		
		$db = new DB_WE();
		
		if($k=="timestamp") {
			$v = date("d.m.y - H:i:s", $v);
		}
		if($k=="status") {
			$v = $GLOBALS['l_versions'][$v];
		}
		if($k=="modifierID") {
			$v = id_to_path($v, USER_TABLE);
		}
		if($k=="ParentID") {
			$v = id_to_path($v, $table);
		}
		if($k=="CreatorID") {
			$v = id_to_path($v, USER_TABLE);
		}
		if($k=="TemplateID") {
			$v = id_to_path($v, TEMPLATES_TABLE);
		}
		if($k=="IsSearchable") {
			$v = ($v==1) ? $GLOBALS['l_versions']['activ'] : $GLOBALS['l_versions']['notactiv'];
		}
		if($k=="IsDynamic") {
			$v = ($v==1) ? $GLOBALS['l_versions']['activ'] : $GLOBALS['l_versions']['notactiv'];
		}
		if($k=="DocType") {
			$docType = f("SELECT DocType FROM " . DOC_TYPES_TABLE . " WHERE ID = '".$v."'","DocType",$db);
			$v = $docType;
		}
		if($k=="RestrictOwners") {
			$v = ($v==1) ? $GLOBALS['l_versions']['activ'] : $GLOBALS['l_versions']['notactiv'];
		}
		if($k=="Language") {
			$v = ($v==1) ? $GLOBALS['l_versions']['activ'] : $GLOBALS['l_versions']['notactiv'];
		}
		if($k=="WebUserID") {
			$v = id_to_path($v, CUSTOMER_TABLE);
		}
		if($k=="Workspaces") {
			$v = id_to_path($v, $table);
		}
		if($k=="ExtraWorkspaces") {
			$v = id_to_path($v, $table);
		}
		if($k=="ExtraWorkspacesSelected") {
			$v = id_to_path($v, $table);
		}
		if($k=="Templates") {
			$v = id_to_path($v, $table);
		}
		if($k=="ExtraTemplates") {
			$v = id_to_path($v, TEMPLATES_TABLE);
		}
		if($k=="fromScheduler") {
			$v = ($v==1) ? $GLOBALS['l_versions']['yes'] : $GLOBALS['l_versions']['no'];
		}
		if($k=="fromImport") {
			$v = ($v==1) ? $GLOBALS['l_versions']['yes'] : $GLOBALS['l_versions']['no'];
		}
		if($k=="resetFromVersion") {
			$v = ($v==0) ? "-" : $v;
		}
		
		$v = shortenPathSpace($v,$pathLength);
		
		if($k=="Category") {
			$fieldValueText = "";
			$v = makeArrayFromCSV($v);
				if(!empty($v)) {
					foreach($v as $key) {
						if($fieldValueText!="") {
							$fieldValueText .= "<br/>";
						}
						$fieldValueText .= shortenPathSpace(id_to_path($key, CATEGORY_TABLE),$pathLength);
					}
				}
			$v = $fieldValueText;
		}
		
		if($k=="Owners") {
			$fieldValueText = "";
			$v = makeArrayFromCSV($v);
			if(!empty($v)) {
				foreach($v as $key) {
					if($fieldValueText!="") {
						$fieldValueText .= "<br/>";
					}
					$fieldValueText .= shortenPathSpace(id_to_path($key, USER_TABLE),$pathLength);
				}
			}
			$v = $fieldValueText;
		}
		if($k=="OwnersReadOnly") {
			$fieldValueText = "";
			if($v!=0) {
				$v = unserialize($v);
			}
			if(is_array($v)) {
				foreach($v as $key => $val) {
					if($fieldValueText!="") {
						$fieldValueText .= "<br/>";
					}
					$stat = ($val==1) ? $GLOBALS['l_versions']['activ'] : $GLOBALS['l_versions']['notactiv'];
					$fieldValueText .= shortenPathSpace(id_to_path($key, USER_TABLE), $pathLength).": ".$stat;
					
				}
			}
			$v = $fieldValueText;
			
		}
		
		//Scheduler
		if($k=="task") {
			if($v!=""){
				$v = $GLOBALS['l_versions'][$k."_".$v];
			}
		}
		if($k=="time") {
			$v = date("d.m.y - H:i:s", $v);
		}
		
		if($v=="") {
			$v = getPixel(1,1);
		}
			
		return $v;
		
	}
	
	
   /**
	* @abstract get array of fieldnames from $table
	* @return array of fieldnames
	*/
	function getFieldsFromTable($table) {
		
		$fieldNames = array();
		
		$db = new DB_WE();
		
		$tableInfo = $db->metadata($table);
		for($i=0;$i<sizeof($tableInfo);$i++){
			$fieldNames[] = $tableInfo[$i]["name"];
		}

		return $fieldNames;
	}
	
		
   /**
	* @abstract convert object to array
	* @return array
	*/
	function objectToArray($obj) {
		
		$arr = array();
        $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
        
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? $this->objectToArray($val) : $val;
            $arr[$key] = $val;
        }
        
        return $arr;
	}	
	
	
   /**
	* @abstract get last record of $docID which was saved or published
	* @return array with fields and values
	*/
	function getLastEntry($docID, $docTable) {
				
		$modArray = array();
		$db = new DB_WE();
		$tblFields = $this->getFieldsFromTable(VERSIONS_TABLE);
		
		$db->query("SELECT * FROM " . VERSIONS_TABLE . " WHERE documentID='".$docID."' AND documentTable='".$docTable."' AND status IN ('saved','published') ORDER BY version DESC LIMIT 1");
		if($db->next_record()) {
			foreach($tblFields as $k => $v) {
				$modArray[$v] = $db->f("".$v."");
			}
		}
		
		return $modArray;
	}
			
	
   /**
	* @abstract get values of modifications for DB-entry
	* @return array with fields and values
	*/
	function getConstantsOfMod($modArray) {

		$const = array();

		foreach($modArray as $k => $v) {
			if(isset($this->modFields[$v])) {
				$const[] = $this->modFields[$v];
			}
		}

		return makeCSVFromArray($const);
		
	}

}

?>
