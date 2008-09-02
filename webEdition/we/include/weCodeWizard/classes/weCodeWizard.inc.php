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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] . '/weCodeWizard.inc.php');

class weCodeWizard
{

	/**
	 * Directory where the snippets are located
	 *
	 * @var string
	 */
	var $SnippetPath = "";

	var $SnippetLanguage = "";

	/**
	 * PHP 5 constructor
	 *
	 */
	function __construct()
	{
		$this->SnippetPath = $_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/weCodeWizard/data/";
		
		// identify language for code snippets. currently there are only german and english translations so 
		// english has also to be used for other languages than german/german-utf8 and english:
		

		if (isset($GLOBALS["WE_LANGUAGE"]) && !empty($GLOBALS["WE_LANGUAGE"])) {
			$this->SnippetLanguage = $GLOBALS["WE_LANGUAGE"];
		} else {
			$this->SnippetLanguage = WE_LANGUAGE;
		}
		if (!is_dir($this->SnippetPath . $this->SnippetLanguage)) {
			$this->SnippetLanguage = "English_UTF-8";
		}
	
	}

	/**
	 * PHP 4 constructor
	 *
	 * @return weCodeWizard
	 */
	function weCodeWizard()
	{
		$this->__construct();
	
	}

	/**
	 * get all custom specific snippets
	 *
	 * @return array
	 */
	function _getCustomSnippets()
	{
		
		$SnippetDir = $this->SnippetPath . "custom";
		if (!is_dir($SnippetDir)) {
			return array();
		
		} else {
			return $this->_getSnippetsByDir("custom");
		
		}
	
	}

	/**
	 * get all standard snippets
	 *
	 * @return array
	 */
	function _getStandardSnippets()
	{
		
		$SnippetDir = $this->SnippetPath . $this->SnippetLanguage;
		
		if (!is_dir($SnippetDir)) {
			return array();
		
		} else {
			return $this->_getSnippetsByDir($this->SnippetLanguage);
		
		}
	
	}

	/**
	 * get snippets by directory name
	 *
	 * @return array
	 */
	function _getSnippetsByDir($SnippetDir, $Depth = 0)
	{
		
		$Snippets = array();
		
		$Depth++;
		$_dir = dir($this->SnippetPath . $SnippetDir);
		while (false !== ($_entry = $_dir->read())) {
			
			// ignore files . and ..
			if ($_entry == "." || $_entry == "..") {
				// ignore these
			

			// get the snippets by file if extension is xml
			} else 
				if (!is_dir($this->SnippetPath . $SnippetDir . "/" . $_entry) && eregi(".xml$", $_entry)) {
					// get the snippet
					$_snippet = weCodeWizardSnippet::initByXmlFile(
							$this->SnippetPath . $SnippetDir . "/" . $_entry);
					$_item = array(
						
							'type' => 'option', 
							'name' => $_snippet->getName(), 
							'value' => $SnippetDir . "/" . $_entry
					);
					$Snippets[] = $_item;
					
				// enter subdirectory only if depth is smaller than 2
				} else 
					if (is_dir($this->SnippetPath . $SnippetDir . "/" . $_entry) && $Depth < 2) {
						
						$information = array();
						$_infoFile = $this->SnippetPath . $SnippetDir . "/" . $_entry . "/" . "_information.php";
						if (file_exists($_infoFile) && is_file($_infoFile)) {
							include ($_infoFile);
						
						}
						
						$_foldername = $_entry;
						if (isset($information['foldername'])) {
							$_foldername = $information['foldername'];
						
						}
						
						$_folder = array(
							
								'type' => 'optgroup', 
								'name' => $_foldername, 
								'value' => $this->_getSnippetsByDir($SnippetDir . "/" . $_entry, $Depth)
						);
						$Snippets[] = $_folder;
					
					}
		
		}
		$_dir->close();
		
		$Depth--;
		
		return $Snippets;
	
	}

	/**
	 * create the select box to select a snippet
	 *
	 * @param string $type
	 * @return string
	 */
	function getSelect($type = 'standard')
	{
		
		$_options = array();
		
		switch ($type) {
			case 'custom' :
				$_options = $this->_getCustomSnippets();
				break;
			
			default :
				$_options = $this->_getStandardSnippets();
				break;
		
		}
		
		$_select = "<select id=\"codesnippet_" . $type . "\" name=\"codesnippet_" . $type . "\"  size=\"7\" style=\"width:250px; height: 100px; display: none;\" ondblclick=\"YUIdoAjax(this.value);\" onchange=\"weButton.enable('btn_direction_right_applyCode')\">\n";
		foreach ($_options as $option) {
			if ($option['type'] == 'optgroup' && sizeof($option['value']) > 0) {
				$_select .= "<optgroup label=\"" . $option['name'] . "\">\n";
				
				foreach ($option['value'] as $optgroupoption) {
					
					if ($optgroupoption['type'] == 'option') {
						$_select .= "<option value=\"" . $optgroupoption['value'] . "\">" . $optgroupoption['name'] . "</option>\n";
					
					}
				
				}
				$_select .= "</optgroup>\n";
			
			} else 
				if ($option['type'] == 'option') {
					$_select .= "<option value=\"" . $option['value'] . "\">" . $option['name'] . "</option>\n";
				}
		
		}
		$_select .= "</select>\n";
		
		return $_select;
	
	}

	/**
	 * get the needed javascript for the codewizard
	 *
	 * @return string
	 */
	function getJavascript()
	{
		
		$Js = <<<JS
<script type="text/javascript" src="/webEdition/js/libs/yui/yahoo-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/event-min.js"></script>
<script type="text/javascript" src="/webEdition/js/libs/yui/connection-min.js"></script>

<script type="text/javascript">

var ajaxURL = "/webEdition/rpc/rpc.php";
var ajaxCallback = {
	success: function(o) {
		if(typeof(o.responseText) != 'undefined' && o.responseText != '') {
			document.getElementById('tag_edit_area').value = o.responseText;
		}
	},
	failure: function(o) {
		alert("Failure");
	}
}

function YUIdoAjax(value) {
	YAHOO.util.Connect.asyncRequest('POST', ajaxURL, ajaxCallback, 'protocol=text&cmd=GetSnippetCode&we_cmd[1]=' + value);
}

</script>
JS;
		
		return $Js;
	
	}

}

/**
 * Code Sample
 *
 * $CodeWizard = new weCodeWizard();
 *
 * echo $CodeWizard->buildDialog();
 *
 */

?>