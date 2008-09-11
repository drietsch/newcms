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

/**
 * class representing the model data of the search
 */

// remove trailing slash
if (isset($_SERVER["DOCUMENT" . "_ROOT"]) && substr($_SERVER["DOCUMENT" . "_ROOT"], -1) == "/") {
	$_SERVER["DOCUMENT" . "_ROOT"] = substr($_SERVER["DOCUMENT" . "_ROOT"], 0, -1);
}
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/define.conf.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolModel.class.php');

include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/tools.inc.php');

class searchtool extends weToolModel
{

	/**
	 * @var integer: default ParentId in which own searches are saved
	 */
	var $ParentID = 8;

	/**
	 * @var string: classname
	 */
	var $ModelClassName = 'searchtool';

	/**
	 * @var string: name of the icon in the tree
	 */
	var $Icon = 'Suche.gif';

	/**
	 * @var string: toolname
	 */
	var $toolName = 'weSearch';

	/**
	 * @var tinyint: flag if the search ist predefined or not
	 */
	var $predefined;

	/**
	 * for each search there are seperate variables
	 * 
	 * @var integer: position to start the search
	 */
	var $searchstartDocSearch = 0;

	var $searchstartTmplSearch = 0;

	var $searchstartAdvSearch = 0;

	/**
	 * @var array: includes the text to search for
	 */
	var $searchDocSearch = array();

	var $searchTmplSearch = array();

	var $searchAdvSearch = array();

	/**
	 * @var array: includes the operators
	 */
	var $locationDocSearch = array();

	var $locationTmplSearch = array();

	var $locationAdvSearch = array();

	/**
	 * @var tinyint: flag that shows what you are searching for in the docsearch
	 */
	var $searchForTextDocSearch = 1;

	var $searchForTitleDocSearch = 0;

	var $searchForContentDocSearch = 0;

	/**
	 * @var tinyint: flag that shows what you are searching for in the tmplsearch
	 */
	var $searchForTextTmplSearch = 1;

	var $searchForContentTmplSearch = 0;

	/**
	 * @var array: shows which tables you have to search in in the advsearch
	 */
	var $search_tables_advSearch = array();

	/**
	 * @var integer: folder-ids of the docsearch and the tmplsearch
	 */
	var $folderIDDoc;

	var $folderIDTmpl;

	/**
	 * @var tinyint: flag that shows what view is set in each search
	 */
	var $setViewDocSearch = 0;

	var $setViewTmplSearch = 0;

	var $setViewAdvSearch = 0;

	/**
	 * @var int: gives the number of entries in each search for one page
	 */
	var $anzahlDocSearch = 10;

	var $anzahlTmplSearch = 10;

	var $anzahlAdvSearch = 10;

	/**
	 * @var string: gives the order
	 */
	var $OrderDocSearch = "Text";

	var $OrderTmplSearch = "Text";

	var $OrderAdvSearch = "Text";

	/**
	 * @var array: includes the searchfiels which you are searching in
	 */
	var $searchFieldsDocSearch = array();

	var $searchFieldsTmplSearch = array();

	var $searchFieldsAdvSearch = array();

	var $activTab = 1;

	/**
	 * Default Constructor
	 * Can load or create new searchtool object depends of parameter
	 */
	
	function searchtool($weSearchID = 0)
	{
		
		parent::weToolModel(SUCHE_TABLE);
		
		if ($weSearchID) {
			$this->ID = $weSearchID;
			$this->load($weSearchID);
		}
	
	}

	function setIsFolder($value)
	{
		
		$this->IsFolder = $value;
		
		if ($value) {
			$this->Icon = 'folder.gif';
		} else {
			$this->Icon = 'Suche.gif';
		}
	
	}
	
	function filenameNotValid($text) {
		if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
			$text = utf8_decode($text);
		}
		return eregi('[^a-zäöü0-9._-]', $text);
	}

	function getLangText($path, $text)
	{
		
		$_text = $text;
		switch ($path) {
			case '/Vordefinierte Suchanfragen' :
				$_text = $GLOBALS['l_weSearch']['vordefinierteSuchanfragen'];
				break;
			case '/Vordefinierte Suchanfragen/Dokumente' :
				$_text = $GLOBALS['l_weSearch']['dokumente'];
				break;
			case '/Vordefinierte Suchanfragen/Objekte' :
				$_text = $GLOBALS['l_weSearch']['objekte'];
				break;
			case '/Vordefinierte Suchanfragen/Dokumente/Unveröffentlichte Dokumente' :
				$_text = $GLOBALS['l_weSearch']['unveroeffentlicheDokumente'];
				break;
			case '/Vordefinierte Suchanfragen/Dokumente/Statische Dokumente' :
				$_text = $GLOBALS['l_weSearch']['statischeDokumente'];
				break;
			case '/Vordefinierte Suchanfragen/Dokumente/Dynamische Dokumente' :
				$_text = $GLOBALS['l_weSearch']['dynamischeDokumente'];
				break;
			case '/Vordefinierte Suchanfragen/Objekte/Unveröffentlichte Objekte' :
				$_text = $GLOBALS['l_weSearch']['unveroeffentlicheObjekte'];
				break;
			case '/Eigene Suchanfragen' :
				$_text = $GLOBALS['l_weSearch']['eigeneSuchanfragen'];
				break;
			case '/Versionen' :
				$_text = $GLOBALS['l_weSearch']['versionen'];
				break;
			case '/Versionen/Dokumente' :
				$_text = $GLOBALS['l_weSearch']['dokumente'];
				break;
			case '/Versionen/Objekte' :
				$_text = $GLOBALS['l_weSearch']['objekte'];
				break;
			case '/Versionen/Dokumente/gelöschte Dokumente' :
				$_text = $GLOBALS['l_weSearch']['geloeschteDokumente'];
				break;
			case '/Versionen/Objekte/gelöschte Objekte' :
				$_text = $GLOBALS['l_weSearch']['geloeschteObjekte'];
				break;
			default:
				$_text = $_text;
				if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
					$_text = utf8_encode($_text);
				}
		}
		
		return $_text;
	
	}

}
?>