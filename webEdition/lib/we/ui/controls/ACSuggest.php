<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * Class to display an autoselector
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_ACSuggest
{

	/**
	 * inputfields attribute
	 *
	 * @var array
	 */
	protected $inputfields = array();

	/**
	 * containerfields attribute
	 *
	 * @var array
	 */
	protected $containerfields = array();

	/**
	 * containerwidth attribute
	 *
	 * @var array
	 */
	protected $containerwidth = array();

	/**
	 * tables attribute
	 *
	 * @var array
	 */
	protected $tables = array();

	/**
	 * contentTypes attribute
	 *
	 * @var array
	 */
	protected $contentTypes = array();

	/**
	 * weMaxResults attribute
	 *
	 * @var array
	 */
	protected $weMaxResults = array();

	/**
	 * queryDelay attribute
	 *
	 * @var array
	 */
	protected $queryDelay = array();

	/**
	 * layer attribute
	 *
	 * @var array
	 */
	protected $layer = array();

	/**
	 * setOnSelectFields attribute
	 *
	 * @var array
	 */
	protected $setOnSelectFields = array();

	/**
	 * inputfields attribute
	 *
	 * @var array
	 */
	protected $checkFieldsValues = array();

	/**
	 * selectors attribute
	 *
	 * @var array
	 */
	protected $selectors = array();

	/**
	 * ct attribute
	 *
	 * @var array
	 */
	protected $ct = array();

	/**
	 * inputMayBeEmpty attribute
	 *
	 * @var array
	 */
	protected $inputMayBeEmpty = array();

	/**
	 * _doOnItemSelect attribute
	 *
	 * @var array
	 */
	protected $_doOnItemSelect = array();

	/**
	 * _doOnTextfieldBlur attribute
	 *
	 * @var array
	 */
	protected $_doOnTextfieldBlur = array();

	/**
	 * preCheck attribute
	 *
	 * @var string
	 */
	protected $preCheck = "";

	/**
	 * acId attribute
	 *
	 * @var string
	 */
	protected $acId = "";

	/**
	 * checkFieldValue attribute
	 *
	 * @var boolean
	 */
	protected $checkFieldValue = true;

	/**
	 * containerWidth attribute
	 *
	 * @var string
	 */
	protected $containerWidth = "";

	/**
	 * containerWidthForAll attribute
	 *
	 * @var integer
	 */
	protected $containerWidthForAll = 0;

	/**
	 * contentType attribute
	 *
	 * @var string
	 */
	protected $contentType = "folder";

	/**
	 * inputAttribs attribute
	 *
	 * @var integer
	 */
	protected $inputAttribs = 0;

	/**
	 * inputDisabled attribute
	 *
	 * @var iunteger
	 */
	protected $inputDisabled = 0;

	/**
	 * inputId attribute
	 *
	 * @var string
	 */
	protected $inputId = "";

	/**
	 * inputName attribute
	 *
	 * @var string
	 */
	protected $inputName = "";

	/**
	 * inputValue attribute
	 *
	 * @var string
	 */
	protected $inputValue = "";

	/**
	 * label attribute
	 *
	 * @var string
	 */
	protected $label = "";

	/**
	 * maxResults attribute
	 *
	 * @var integer
	 */
	protected $maxResults = 20;

	/**
	 * mayBeEmpty attribute
	 *
	 * @var integer
	 */
	protected $mayBeEmpty = 1;

	/**
	 * resultName attribute
	 *
	 * @var string
	 */
	protected $resultName = "";

	/**
	 * resultValue attribute
	 *
	 * @var string
	 */
	protected $resultValue = "";

	/**
	 * resultId attribute
	 *
	 * @var string
	 */
	protected $resultId = "";

	/**
	 * rootDir attribute
	 *
	 * @var string
	 */
	protected $rootDir = "";

	/**
	 * selectButton attribute
	 *
	 * @var string
	 */
	protected $selectButton = "";

	/**
	 * selectButtonSpace attribute
	 *
	 * @var string
	 */
	protected $selectButtonSpace = "";

	/**
	 * selector attribute
	 *
	 * @var string
	 */
	protected $selector = "Dir";

	/**
	 * trashButton attribute
	 *
	 * @var string
	 */
	protected $trashButton = "";

	/**
	 * trashButtonSpace attribute
	 *
	 * @var string
	 */
	protected $trashButtonSpace = "";

	/**
	 * table attribute
	 *
	 * @var string
	 */
	protected $table = '';

	/**
	 * width attribute
	 *
	 * @var integer
	 */
	protected $width = 280;

	/**
	 * addJS attribute
	 *
	 * @var string
	 */
	protected $addJS = "";

	/**
	 * doOnItemSelect attribute
	 *
	 * @var string
	 */
	protected $doOnItemSelect = "";

	/**
	 * doOnTextfieldBlur attribute
	 *
	 * @var string
	 */
	protected $doOnTextfieldBlur = "";

	/**
	 * onChange attribute
	 *
	 * @var string
	 */
	protected $_onChange = '';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * get instance of class we_ui_controls_ACSuggest
	 *
	 * @var string
	 */
	public function &getInstance()
	{
		if (!isset($GLOBALS['__weSuggest__'])) {
			$GLOBALS['__weSuggest__'] = new we_ui_controls_ACSuggest();
		}
		return $GLOBALS['__weSuggest__'];
	}

	/**
	 * Retrieve onChange attribute
	 * 
	 * @return string
	 */
	public function getOnChange()
	{
		return $this->_onChange;
	}

	/**
	 * Set onChange attribute
	 * 
	 * @param string $_onChange
	 */
	public function setOnChange($_onChange)
	{
		$this->_onChange = $_onChange;
	}

	/**
	 * set disabled attribute
	 *
	 * @param string $_disabled
	 */
	function setInputDisabled($_disabled)
	{
		$this->inputDisabled = $_disabled;
	
	}

	/**
	 * This function generates the individual js code for the autocomletion
	 *
	 * @return String
	 */
	function getYuiJs()
	{
		$client = we_ui_Client::getInstance();
		/**
		 * @todo 	1. value
		 * 			2. table
		 * 			3. contenttype
		 * 			4. ?
		 * 			5. id
		 */
		$weSelfContentType = (isset($GLOBALS['we_doc']) && isset($GLOBALS['we_doc']->ContentType)) ? $GLOBALS['we_doc']->ContentType : '';
		$weSelfID = (isset($GLOBALS['we_doc']) && isset($GLOBALS['we_doc']->ID)) ? $GLOBALS['we_doc']->ID : '';
		
		if (is_array($this->inputfields) && !count($this->inputfields))
			return;
		
		$safariEventListener = "";
		$doSafariOnTextfieldBlur = "";
		$initVars = "	var ajaxMaxResponseTime = 1500;\n";
		$initVars .= "	var ajaxResponseStep = 100;\n";
		$initVars .= "	var ajaxResponseCT = 0;\n";
		$initVars .= "	var countMark = 0;\n";
		$initVars .= "	var ajaxURL = \"/webEdition/rpc/rpc.php\";\n";
		$weFieldWS = "	/* WORKSPACES */\n";
		$weFieldWS .= "	var weWorkspacePathArray = new Array();\n";
		$fildsById = "\n	/* AC-FIEDS BY ID */\n";
		$fildsById .= "	var yuiAcFieldsById = new Array()\n";
		$fildsObj = "\n	/* AC-FIEDS */\n";
		$fildsObj .= "	var yuiAcFields = {\n";
		$invalidFields = <<<HTS
		if(parent && parent.weAutoCompetionFields && parent.weAutoCompetionFields.length>0) {

			for(i=0; i< parent.weAutoCompetionFields.length; i++) {
				if(parent.weAutoCompetionFields[i] && parent.weAutoCompetionFields[i].id && !parent.weAutoCompetionFields[i].valid) {
					YAHOO.autocoml.markNotValid(i);
				}
			}
		}
HTS;
		
		$inputfields = "";
		$tables = "";
		$oACDS = "";
		$oACDSInit = "";
		$oAutoCompInit = "";
		$oAutoCompRes = "";
		$declare = "";
		$onSelect = "";
		$onBlur = "";
		$onFocus = "";
		$doAjax = "";
		$weAcFields = "";
		$postData = "protocol=text&cmd=SelectorGetSelectedId";
		// loop fields
		for ($i = 0; $i < count($this->inputfields); $i++) {
			$safariEventListener .= "YAHOO.util.Event.addListener('" . $this->inputfields[$i] . "','blur',YAHOO.autocoml.doSafariOnTextfieldBlur_$i);\n";
			$weErrorMarkId = str_replace("Input", "ErrorMark", $this->inputfields[$i]);
			//$weWorkspacePathArray = we_util_Strings::makeArrayFromCSV(we_util_Path::id2Path(get_ws($this->tables[$i])));
			$weWorkspacePathArray = "";
			$weWorkspacePathArrayJS = "";
			if (is_array($weWorkspacePathArray)) {
				$ix = 0;
				foreach ($weWorkspacePathArray as $val) {
					if ($ix > 0)
						$weWorkspacePathArrayJS .= ",";
					$weWorkspacePathArrayJS .= '"' . $val . '"';
					$ix++;
				}
			}
			$weFieldWS .= "\tweWorkspacePathArray[$i] = new Array($weWorkspacePathArrayJS);\n";
			
			$weAcFields .= <<<HTS
if(parent && parent.weAutoCompetionFields && !parent.weAutoCompetionFields[$i]) {
	parent.weAutoCompetionFields[$i] = {
		'id' : yuiAcFields.set_$i.id,
		'valid' : true,
		'cType' : yuiAcFields.set_$i.cType
	}
}

HTS;
			
			$fildsById .= "	yuiAcFieldsById['" . $this->inputfields[$i] . "']={'index':'$i','set':'set_$i'};\n";
			
			$fildsObj .= ($i > 0 ? ",\n\t\t" : "\t\t") . "'set_$i': {\n";
			$fildsObj .= "			'id' : '" . $this->inputfields[$i] . "',\n";
			$fildsObj .= "			'old': document.getElementById('" . $this->inputfields[$i] . "').value,\n";
			$fildsObj .= "			'selector': '" . $this->selectors[$i] . "',\n";
			$fildsObj .= "			'sel': '',\n";
			$fildsObj .= "			'newval': null,\n";
			$fildsObj .= "			'run': false,\n";
			$fildsObj .= "			'found': 0,\n";
			$fildsObj .= "			'cType': '',\n";
			$fildsObj .= "			'valid': true,\n";
			$fildsObj .= "			'countMark': 0,\n";
			$fildsObj .= "			'changed': false,\n";
			$fildsObj .= "			'table': '" . $this->tables[$i] . "',\n";
			$fildsObj .= "			'cTypes': '" . $this->contentTypes[$i] . "',\n";
			$fildsObj .= "			'workspace': new Array(" . $weWorkspacePathArrayJS . "),\n";
			$fildsObj .= "			'mayBeEmpty': " . ($this->inputMayBeEmpty[$i] ? "true" : "false");
			$oACDSInit .= ($i > 0 ? ", " : "") . 'oACDS_' . $i;
			$oAutoCompInit .= ($i > 0 ? ", " : "") . 'oAutoComp_' . $i;
			$oAutoCompRes .= "	var oAutoCompRes_$i = new Array();\n";
			
			if (isset($this->setOnSelectFields[$i]) && is_array($this->setOnSelectFields[$i])) {
				$initVars .= "	var selInputVal_" . $i . ";\n";
				$onSelectInit = "";
				$onSelectDecl = "";
				if (count($this->setOnSelectFields[$i])) {
					$fildsObjId = ",\n			'fields_id': new Array(";
					$fildsObjVal = ",\n			'fields_val': new Array(";
					for ($j = 0; $j < count($this->setOnSelectFields[$i]); $j++) {
						if ($j > 0) {
							$fildsObjId .= ",";
							$fildsObjVal .= ",";
						}
						$fildsObjId .= "'" . $this->setOnSelectFields[$i][$j] . "'";
						$fildsObjVal .= "document.getElementById('" . $this->setOnSelectFields[$i][$j] . "').value";
						$onSelectInit .= "var yuiAcOnSelectField_" . $j . ";\n";
						$onSelectDecl .= "if ((yuiAcOnSelectField_" . $j . " = document.getElementById('" . $this->setOnSelectFields[$i][$j] . "')) && (typeof(params[" . (3) . "])!=undefined)) {\n";
						$onSelectDecl .= "				yuiAcOnSelectField_" . $j . ".value = params[" . (3) . "];\n";
						$onSelectDecl .= "			}\n";
					}
					$fildsObj .= $fildsObjId . ")" . $fildsObjVal . ")";
				}
				$onSelect .= <<<HTS

		doOnItemSelect_$i: function(param1,param2) {
			param=param2.toString();
			params=param.split(',');
			$onSelectInit
			if((yuiAcFields.set_$i.selector=='docSelector'||yuiAcFields.set_$i.selector =='Docselector')&&params[4]=='folder') {
				yuiAcFields.set_$i.valid = false;
				yuiAcFields.set_$i.cType = params[4];
			} else {
				yuiAcFields.set_$i.valid=true;
				yuiAcFields.set_$i.sel = params[3];
				yuiAcFields.set_$i.cType = params[4];
				YAHOO.autocoml.unmarkNotValid($i);
				$onSelectDecl
			}
			yuiAcFields.set_$i.found = 1;
			yuiAcFields.set_$i.run = false;
			selInputVal_$i = document.getElementById(yuiAcFields.set_$i.id).value;
			yuiAcFields.set_$i.newval = document.getElementById(yuiAcFields.set_$i.id).value;
			inputID = yuiAcFields.set_$i.id;
			resultID = yuiAcFields.set_$i.fields_id[0];
			{$this->_doOnItemSelect[$i]}
		},
		

		doOnDataRequestEvent_$i: function() {
			yuiAcFields.set_$i.found = 0;
			yuiAcFields.set_$i.run = true;
			yuiAcFields.set_$i.changed = true;
		},

		
		doOnDataReturnEvent_$i: function(param1,param2) {
			param=param2.toString();
			params=param.split(',');
			if(params.length<4) {
				if(document.getElementById('{$this->inputfields[$i]}').value == "/" && (yuiAcFields.set_$i.selector == "dirSelector" || yuiAcFields.set_$i.selector == "Dirselector" || yuiAcFields.set_$i.selector == "selector")) {
					document.getElementById(yuiAcFields.set_$i.fields_id[0]).value = '0';
					YAHOO.autocoml.unmarkNotValid($i);
					if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[$i].valid = true;
				} else if (document.getElementById('{$this->inputfields[$i]}').value =="" && (yuiAcFields.set_$i.selector == "docSelector" || yuiAcFields.set_$i.selector == "Docselector") && yuiAcFields.set_{$i}.mayBeEmpty) {
					document.getElementById(yuiAcFields.set_$i.fields_id[0]).value = "";
					YAHOO.autocoml.unmarkNotValid($i);
					if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[$i].valid = true;
				} else {
					YAHOO.autocoml.markNotValid($i);
					if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[$i].valid = false;

				}
			} else {
				document.getElementById('$weErrorMarkId').style.visibility = 'hidden';
				if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[$i].valid = true;
			}
			yuiAcFields.set_$i.run = false;
		},

		
		doOnDataErrorEvent_$i: function() {
			yuiAcFields.set_$i.run = false;
			yuiAcFields.set_$i.valid = false;
		},
		
		
		doOnDataReturnEvent_$i: function() {
			yuiAcFields.set_$i.run = false;
		},
		
		
		doOnUnmatchedItemSelectEvent_$i: function() {
			yuiAcFields.set_$i.run = false;
		},
		

HTS;
			
			}
			if (isset($this->checkFieldsValues[$i]) && $this->checkFieldsValues[$i]) {
				$initVars .= "	var oldInputVal_" . $i . ";\n";
				$initVars .= "	var newInputVal_" . $i . ";\n";
				$additionalFields = "";
				if (isset($this->setOnSelectFields[$i]) && is_array($this->setOnSelectFields[$i])) {
					for ($j = 0; $j < count($this->setOnSelectFields[$i]); $j++) {
						$initVars .= "	var old_" . $this->setOnSelectFields[$i][$j] . ";\n";
						$additionalFields .= ($j > 0 ? "," : "") . $this->setOnSelectFields[$i][$j];
					}
				}
				$onBlur .= <<<HTS
		doSafariOnTextfieldBlur_$i: function(e) {
			YAHOO.autocoml.doOnTextfieldBlur_$i();
		},
		
		
		doOnTextfieldBlur_$i: function() {
			//document.getElementById(yuiAcFields.set_$i.id).blur();
			wsValid_$i = true;
			if(yuiAcFields.set_{$i}.workspace.length > 0) {
				wsValid_$i = false;
				var wsPathInput_$i = document.getElementById(yuiAcFields.set_$i.id).value;
				for(i=0; i<yuiAcFields.set_{$i}.workspace.length; i++) {
					if(wsPathInput_$i.length >= yuiAcFields.set_{$i}.workspace[i].length) {
						if(wsPathInput_$i.substr(0,yuiAcFields.set_{$i}.workspace[i].length) == yuiAcFields.set_{$i}.workspace[i])	{
							wsValid_$i = true;
						}
					}
				}
			}
			if(document.getElementById(yuiAcFields.set_$i.id).value =="/" && (yuiAcFields.set_$i.selector == "dirSelector"|| yuiAcFields.set_$i.selector == "Dirselector"|| yuiAcFields.set_$i.selector == "selector") && wsValid_$i) {
				document.getElementById(yuiAcFields.set_{$i}.fields_id[0]).value = '0';
				yuiAcFields.set_$i.newval = '/';
				yuiAcFields.set_$i.run = false;
				YAHOO.autocoml.unmarkNotValid($i);
			} else if (document.getElementById(yuiAcFields.set_$i.id).value =="" && (yuiAcFields.set_{$i}.selector == "docSelector" || yuiAcFields.set_{$i}.selector == "Docselector" || yuiAcFields.set_$i.selector == "dirSelector" || yuiAcFields.set_$i.selector == "Dirselector" || yuiAcFields.set_$i.selector == "selector") && yuiAcFields.set_$i.mayBeEmpty) {
				document.getElementById(yuiAcFields.set_$i.fields_id[0]).value = "";
				yuiAcFields.set_$i.run = false;
				YAHOO.autocoml.unmarkNotValid($i);
			} else {
				switch(true) {
					case (!wsValid_$i):                                   // ERROR: Not valid workspace
						debug('Not valid workspace');
						YAHOO.autocoml.markNotValid($i);
						break;
					case (ajaxResponseCT > ajaxMaxResponseTime):          // ERROR: No respone - timeout
						debug('Timeout');
						YAHOO.autocoml.markNotValid($i);
						break;
					case (yuiAcFields.set_$i.run):                        // ERROR: Request is running
						debug('Running');
						ajaxResponseCT +=ajaxResponseStep;
						setTimeout('YAHOO.autocoml.doOnTextfieldBlur_$i()',ajaxResponseStep);
						break;
					case (yuiAcFields.set_$i.found == 2):                 // ERROR: No result found
						debug('No reault');
						YAHOO.autocoml.markNotValid($i);
						break;
					case (yuiAcFields.set_$i.found == 0):                 // ERROR: Nothing found
						debug('found=0');
						newInputVal_$i = document.getElementById(yuiAcFields.set_$i.id).value;
						if(newInputVal_$i != selInputVal_$i || newInputVal_$i != oldInputVal_$i) {
							yuiAcFields.set_$i.run = true;
							YAHOO.autocoml.doAjax(ajaxCallback_$i, '$postData&we_cmd[1]='+newInputVal_$i+'&we_cmd[2]='+yuiAcFields.set_{$i}.table+'&we_cmd[3]={$this->contentTypes[$i]}&we_cmd[4]={$additionalFields}&we_cmd[5]=$i');
							setTimeout('YAHOO.autocoml.doOnTextfieldBlur_$i()',ajaxResponseStep);
						}
						break;
					case ((yuiAcFields.set_$i.selector == "docSelector" || yuiAcFields.set_$i.selector == "Docselector") && yuiAcFields.set_$i.cType=="folder") :   // ERROR: Wrong type
						debug('folder');
						YAHOO.autocoml.markNotValid($i);
						break;
					default:
						debug('checkfields');
						YAHOO.autocoml.checkFields();
				}
			}
			if (typeof _EditorFrame != 'undefined' && yuiAcFields.set_$i.old != yuiAcFields.set_$i.newval && yuiAcFields.set_$i.newval!=null) {
				_EditorFrame.setEditorIsHot(true);
			}
			inputID = yuiAcFields.set_$i.id;
			resultID = yuiAcFields.set_$i.fields_id[0];
			{$this->_doOnTextfieldBlur[$i]}
			yuiAcFields.set_$i.changed=false;
		},
		

		doOnContainerCollapse_$i: function(){
			//setTimeout('YAHOO.autocoml.doOnTextfieldBlur_$i()',100);
		},


HTS;
				
				$onFocus .= "		doOnTextfieldFocus_" . $i . ": function() {\n";
				$onFocus .= "			ajaxResponseCT=0;\n";
				$onFocus .= "			oldInputVal_" . $i . " = document.getElementById('" . $this->inputfields[$i] . "').value;\n";
				if (isset($this->setOnSelectFields[$i]) && is_array($this->setOnSelectFields[$i])) {
					for ($j = 0; $j < count($this->setOnSelectFields[$i]); $j++) {
						$onFocus .= "			old_" . $this->setOnSelectFields[$i][$j] . " = document.getElementById('" . $this->setOnSelectFields[$i][$j] . "').value;\n";
					}
				}
				
				//$onFocus .= "			YAHOO.autocoml.unmarkNotValid($i);";
				$onFocus .= "			if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[yuiAcFields.set_{$i}.id] = false;\n";
				$onFocus .= "			yuiAcFields.set_$i.set = '';\n";
				
				$onFocus .= "		},\n";
				$doAjax .= <<<HTS

		doAjax: function(callback, postdata) {
			var request = YAHOO.util.Connect.asyncRequest('POST', ajaxURL, callback, postdata);
		},
		
		
HTS;
				
				$initVars .= <<<HTS

				
	var ajaxCallback_$i = {
		success: function(o) {
			if(o.responseText != undefined && o.responseText != ''){
				eval(o.responseText);
				if(weResponse.type=='error') {
					//for (i=0; i < yuiAcFields.set_$i.fields_id.length; i++) {
						document.getElementById(yuiAcFields.set_$i.fields_id[0]).value = yuiAcFields.set_$i.fields_val[0];
					//}
					yuiAcFields.set_$i.found = 2;
					yuiAcFields.set_$i.newval='';
					YAHOO.autocoml.markNotValid($i);
					yuiAcFields.set_$i.newval = '';
				} else {
					if(weResponse.data.contentType=='folder' && (yuiAcFields.set_{$i}.selector == 'docSelector' || yuiAcFields.set_{$i}.selector == 'Docselector')) {
						document.getElementById(weResponse.data.id).value = "";
						YAHOO.autocoml.markNotValid($i);
						yuiAcFields.set_$i.newval = '';
					} else {
						document.getElementById(weResponse.data.id).value = weResponse.data.value;
						YAHOO.autocoml.unmarkNotValid($i);
						yuiAcFields.set_$i.newval = document.getElementById(yuiAcFields.set_$i.id).value;
					}
					yuiAcFields.set_$i.found = 1;
				}
			}
			yuiAcFields.set_$i.run = false;
		},
		failure: function(o) {
			for (i=1; i < yuiAcFields.set_$i.fields_id.length; i++) {
				document.getElementById(yuiAcFields.set_$i.fields_id[i]).value = yuiAcFields.set_$i.fields_val;
			}
			yuiAcFields.set_$i.run = false;
			yuiAcFields.set_{$i}.valid=false;
			YAHOO.autocoml.markNotValid($i);
			yuiAcFields.set_$i.newval = '';
		}
	};
	
	
HTS;
			
			}
			// EOF loop fields
			

			$fildsObj .= "		}";
			$declare .= 'oACDS_' . $i . ' = new YAHOO.widget.DS_XHR(ajaxURL, ["\n", "\t"]);
			oACDS_' . $i . '.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
			oACDS_' . $i . '.maxCacheEntries = 60;
			oACDS_' . $i . '.queryMatchSubset = false;
			oACDS_' . $i . '.scriptQueryAppend  = "protocol=text&cmd=SelectorSuggest&we_cmd[2]="+yuiAcFields.set_' . $i . '.table+"&we_cmd[3]="+yuiAcFields.set_' . $i . '.cTypes+"&we_cmd[4]=' . $weSelfContentType . '&we_cmd[5]=' . $weSelfID . '&we_cmd[6]=' . $this->rootDir . '";
			oACDS_' . $i . '.scriptQueryParam  = "we_cmd[1]";
			var myInput = document.getElementById("' . $this->inputfields[$i] . '");
			var myContainer = document.getElementById("' . $this->containerfields[$i] . '");
			oAutoComp_' . $i . ' = new YAHOO.widget.AutoComplete(myInput,myContainer,oACDS_' . $i . ');
			oAutoComp_' . $i . '.maxResultsDisplayed = ' . $this->weMaxResults[$i] . ';
			oAutoComp_' . $i . '.queryDelay = 0;';
			if (isset($this->setOnSelectFields[$i]) && is_array($this->setOnSelectFields[$i])) {
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.itemSelectEvent.subscribe(YAHOO.autocoml.doOnItemSelect_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.dataRequestEvent.subscribe(YAHOO.autocoml.doOnDataRequestEvent_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.dataReturnEvent.subscribe(YAHOO.autocoml.doOnDataReturnEvent_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.unmatchedItemSelectEvent.subscribe(YAHOO.autocoml.doOnUnmatchedItemSelectEvent_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.dataErrorEvent.subscribe(YAHOO.autocoml.doOnDataErrorEvent_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.dataReturnEvent.subscribe(YAHOO.autocoml.doOnDataReturnEvent_' . $i . ');';
			}
			if (isset($this->checkFieldsValues[$i]) && $this->checkFieldsValues[$i]) {
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.textboxBlurEvent.subscribe(YAHOO.autocoml.doOnTextfieldBlur_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.textboxFocusEvent.subscribe(YAHOO.autocoml.doOnTextfieldFocus_' . $i . ');';
				$declare .= "\n\t\t\t" . 'oAutoComp_' . $i . '.containerCollapseEvent.subscribe(YAHOO.autocoml.doOnContainerCollapse_' . $i . ');';
			}
			$declare .= '
			oAutoComp_' . $i . '.formatResult = function(oResultItem, sQuery) {
				var sKey = oResultItem[0];
				var nQuantity = oResultItem[1];
				var sKeyQuery = sKey.substr(0, sQuery.length);
				var sKeyRemainder = sKey.substr(sQuery.length);
				oAutoCompRes_' . $i . '[sKeyQuery] = oResultItem[2];
				var aMarkup = ["<div id=\'ysearchresult\'>",
					//nQuantity,
					"<span style=\'font-weight:bold\'>",
					sKeyQuery,
					"</span>",
					sKeyRemainder,
					"</div>"];
				return (aMarkup.join(""));
			};

			';
		}
		
		$declare .= <<<HTS
/*
		if(parent && parent.weAutoCompetionFields && parent.weAutoCompetionFields.length>0) {
			for(arrayIndex in parent.weAutoCompetionFields) {
				if(parent.weAutoCompetionFields[arrayIndex] ) YAHOO.autocoml.markNotValid(i);
			}
		}
		*/
HTS;
		
		$fildsObj .= "\n	};\n";
		$out = "
<script type=\"text/javascript\">

YAHOO.autocoml = function(){
$weFieldWS
$fildsById
$fildsObj
$initVars
	var $oACDSInit;
	var $oAutoCompInit;
	$oAutoCompRes

	return {
$onSelect
$onBlur
$onFocus
$doAjax
		init: function() {
			$declare
			$weAcFields
			$invalidFields
		},
		validateForm: function() {
			// Validate form inputs here
			return false;
		},
		checkFields: function() {
			for(i=0; i<" . count($this->inputfields) . "; i++) {
				set = eval('yuiAcFields.set_'+i);
				if(!set.valid) {
					document.getElementById(set.fields_id[0]='');
					YAHOO.autocoml.markNotValid(i);
				}
			}
			return true;
		},
		checkRunnigProcess: function() {
			for(i=0; i<" . count($this->inputfields) . "; i++) {
				set = eval('yuiAcFields.set_'+i);
				if(set.run) {
					return true;
				}
			}
			return false;
		},
		markNotValid: function(setNr) {
			set = eval('yuiAcFields.set_'+setNr);
			set.valid = false;
			set.run = false;
			var _elem = document.getElementById(set.id);
			if (_elem != null) {
				weInputAppendClass(_elem, 'we_ui_controls_TextInput_Error');
			}
			if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[setNr].valid = false;
		},
		unmarkNotValid: function(setNr) {
			set = eval('yuiAcFields.set_'+setNr);
			set.valid = true;
			set.run = false;
			set.found = 1;
			var _elem = document.getElementById(set.id);
			if (_elem != null) {
				weInputRemoveClass(_elem, 'we_ui_controls_TextInput_Error');
			}
			if(parent && parent.weAutoCompetionFields) parent.weAutoCompetionFields[setNr].valid = true;
		},
		checkACFields: function() {
			if(YAHOO.autocoml.checkRunnigProcess()) return {'running':true};
			for(i=0; i<" . count($this->inputfields) . "; i++) {
				set = eval('yuiAcFields.set_'+i);
				if(!set.valid) {
					return {'running':false, 'valid':false};
				}
			}
			return {'running':false, 'valid':true};
		},

		selectorSetValid: function(setFieldId) {
			for(i=0; i<" . count($this->inputfields) . "; i++) {
				set = eval('yuiAcFields.set_'+i);
				if(set.id==setFieldId) {
					YAHOO.autocoml.unmarkNotValid(i);
				}
			}
		},

		checkOnContainerCollapse: function(setNr) {
			set = eval('yuiAcFields.set_'+setNr);
			if(set.set=='') {
			}
		},


		modifySetById: function(fId,param,value){
			set = yuiAcFieldsById[fId].set;
			yuiAcFields[set][param]=value;
			YAHOO.autocoml.init();
		},
		isValidById: function(fId){
			if(fId) {
				if(YAHOO.autocoml.counter < 10 && yuiAcFields[yuiAcFieldsById[fId].set]['run']) {
					YAHOO.autocoml.counter++;
					setTimeout('YAHOO.autocoml.isValidById(\"'+fId+'\")',100);
				} else {
					YAHOO.autocoml.counter=0;
					return yuiAcFields[yuiAcFieldsById[fId].set]['valid'];
				}
			} else {
				return false;
			}
		},
		counter: 0,		
				
		isValid: function(){
			var isValid = true;
			for(fId in yuiAcFieldsById){
				if( document.getElementById(fId).style.display != 'none' && !yuiAcFields[yuiAcFieldsById[fId].set]['valid']) {
					isValid = false;
				}
			}
			return isValid;
		},
		isRunnigProcess: function(){
			var isRunning = false;
			for(fId in yuiAcFieldsById){
				if( document.getElementById(fId).style.display != 'none' && yuiAcFields[yuiAcFieldsById[fId].set]['run']) {
					isRunning = true;
				}
			}
			return isRunning;
		},
		setValidById: function(fId){
			YAHOO.autocoml.unmarkNotValid(yuiAcFieldsById[fId].index);
			yuiAcFields[yuiAcFieldsById[fId].set]['valid']=true;
		},
		setNotValidById: function(fId){
			YAHOO.autocoml.markNotValid(yuiAcFieldsById[fId].index);
			yuiAcFields[yuiAcFieldsById[fId].set]['valid']=false;
		},

		restoreById: function(fId){
			set = yuiAcFieldsById[fId].set;
			YAHOO.autocoml.markValid(yuiAcFieldsById[fId].index);
			document.getElementById(fId).value  = yuiAcFields[yuiAcFieldsById[fId].set]['old'];
			document.getElementById(yuiAcFields[yuiAcFieldsById[fId].set]['fields_id'][0]).value  = yuiAcFields[yuiAcFieldsById[fId].set]['fields_val'][0];
		},


		setOldVal: function(set) {
		}
	}
}();

YAHOO.util.Event.addListener(this,'load',YAHOO.autocoml.init);
{$this->preCheck}
" . ($client->getBrowser() == we_ui_Client::kBrowserWebkit ? $safariEventListener : "") . "

function weInputAppendClass(inp, cls) {
	if (inp.className) {
		var _class = inp.className;
		var _arr = _class.split(/ /);
		if (!weInputInArray(_arr, cls)) {
			_arr.push(cls);
		}
		var _newCls = _arr.join(' ');
		inp.className =  _newCls;
	} else {
		inp.setAttribute('class', cls);
	}
}

function weInputRemoveClass(inp, cls) {
	if (inp.className) {
		var _class = inp.className;
		var _arr = _class.split(/ /);
		if (weInputInArray(_arr, cls)) {
			var _newArr = new Array();
			var _l = _arr.length;
			for (var i=0; i< _l; i++) {
				if (_arr[i] !== cls) {
					_newArr.push(_arr[i]);
				}
			}

			if (_newArr.length > 0) {
				var _newCls = _newArr.join(' ');
				inp.className = _newCls;
			} else {
				inp.className = null;
			}
		}
	}
}

function weInputInArray(arr, val) {
	var _l = arr.length;
	for (var i=0; i<_l; i++) {
		if (arr[i] === val) {
			return true;
		}
	}
	return false;
}

{$this->addJS}

/********************************************************/
var weShowDebug = true;
var debugsizeW=145;
var debugsizeH='100%';
function debug(text){
" . ($_SERVER['HTTP_HOST'] == 'we.damjan.intra' ? "
	if(weShowDebug){
		document.getElementById('damd').style.display='';
		document.getElementById('debug').innerHTML += text+'<br>';
	}
	" : "") . "
}
function doDebugResizeW(){
	if(debugsizeW<600) {
		debugsize=600;
		document.getElementById('DebugResizeW').innerHTML='&lt;';
	} else {
		debugsize=145;
		document.getElementById('DebugResizeW').innerHTML='&gt;';
	}
	document.getElementById('damd').style.width=debugsize;
}
function doDebugResizeH(){
	if(debugsizeH=='30px') {
		debugsizeH='100%';
		document.getElementById('DebugResizeH').innerHTML='A';
	} else {
		debugsizeH='30px';
		document.getElementById('DebugResizeH').innerHTML='V';
	}
	document.getElementById('damd').style.height=debugsizeH;
}

</script>
<div style='display:none; position:absolute; top:0px; width:145px; height:100%; background:yellow; border: 1px solid red; color:red; z-index:10000' id='damd'>
	<div align='center'><button onclick='document.getElementById(\"debug\").innerHTML=\"\"'>clear</button><button id='DebugResizeW' onclick='doDebugResizeW()'>&gt;</button><button id='DebugResizeH' onclick='doDebugResizeH()'>A</button></div><hr>
	<div id='debug'></div>
</div>
	";
		return $out;
	}

	/**
	 * This function generates the individual css code for the autocomletion
	 *
	 * @return unknown
	 */
	function getYuiCss()
	{
		
		$client = we_ui_Client::getInstance();
		$inputfields = "";
		$containerfields = "";
		$yuiAcContent = "";
		$ysearchquery = "";
		$yuiAcShadow = "";
		$ul = "";
		$li = "";
		$yuAcHighlight = "";
		$layer = "";
		$layerZ = "";
		for ($i = 0; $i < count($this->inputfields); $i++) {
			if ($client->getBrowser() == we_ui_Client::kBrowserIE) {
				$width = $this->containerwidth[$i] - 4;
				$overflow = 'overflow:hidden;';
			} else {
				$width = $this->containerwidth[$i] - 8;
				$overflow = '';
			}
			
			$inputfields .= ($i > 0 ? ", " : "") . "#" . $this->inputfields[$i];
			$containerfields .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i];
			$yuiAcContent .= "#" . $this->containerfields[$i] . " .yui-ac-content {	
				position:absolute;
				left:0px;
				" . $overflow . "
				width:" . $width . "px;
				border:1px solid #404040;
				background:#fff;z-index:9050;
			}\n";
			$ysearchquery .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i] . " .ysearchquery";
			$yuiAcShadow .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i] . " .yui-ac-shadow";
			$ul .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i] . " ul";
			$li .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i] . " li";
			$yuAcHighlight .= ($i > 0 ? ", " : "") . "#" . $this->containerfields[$i] . " li.yui-ac-highlight";
		}
		for ($i = 0; $i < count($this->layer); $i++) {
			$layer .= ($i > 0 ? ", " : "") . "#" . $this->layer[$i];
			$layerZ .= "#" . $this->layer[$i] . " {z-index:" . (9010 - $i) . ";}\n";
		}
		$out = "";
		if ($client->getBrowser() == we_ui_Client::kBrowserIE) {
			$out .= "$inputfields {
				position:relative;
				width:100%;
				margin-top:-1px;
			}\n";
			$out .= "$containerfields {
				position:relative;
				top:-2px;
				left:0px;
				width:100%;
				z-index:10000;
			}\n";
			$out .= "$yuiAcContent";
			$out .= "$ul {
				padding:0px;
				background-color:#fff;
			}\n";
			$out .= "$li {
				padding:0px 0px 0px 5px;
				cursor:default;
				white-space:nowrap;
			}\n";
			$out .= "$yuAcHighlight {
				background:#B5D5FF;
				height:13px;
				overflow:hidden;
			}\n";
			$out .= "div.yui-ac-bd li div{
				height:13px;
				overflow:hidden;
				font-size:10px;
				font-family: Verdana, Arial, sans-serif;
			}\n";
			$out .= "div.yui-ac-bd li span{
				font-size:10px;
				font-family: Verdana, Arial, sans-serif;
			}\n";
			$out .= "div.yui-ac-bd ul{
				margin:0px 0px -3px 0px;
				padding:0px;
				list-style:none;
			}\n";
		} else {
			$out .= "$inputfields {
				position:relative;
				width:100%;
			}\n";
			$out .= "$containerfields {
				position:relative;
				top:3px;
				left:6px;
			}\n";
			$out .= "$yuiAcContent";
			$out .= "$ul {
				padding:0px;
				background-color:#fff;
				border:1px solid #000;
			}\n";
			$out .= "$li {
				padding:0px 0px 0px 5px;
				cursor:default;
				white-space:nowrap;
			}\n";
			$out .= "$yuAcHighlight {
				background:#B5D5FF;
			}\n";
			$out .= "div.yui-ac-bd li div{
				font-size:10px;
				font-family: Verdana, Arial, sans-serif;
			}\n";
			$out .= "div.yui-ac-bd li span{\n
				font-size:10px;\n
				font-family: Verdana, Arial, sans-serif;
			}\n";
			$out .= "div.yui-ac-bd ul{
				margin:-7px;
				margin-top:-5px;
				padding:0px;
				list-style:none;
			}\n";
		}
		$out .= "";
		
		return empty($inputfields) ? "" : $out;
	}

	/**
	 * Set id and value for the input field
	 *
	 * @param String $name
	 * @param String $value
	 * @param Array $attribs 
	 * @param Boolean $disabled 
	 */
	function setInput($name, $value = "", $attribs = "", $disabled = false, $markHot = "")
	{
		$this->inputId = '';
		$this->inputName = $name;
		$this->inputValue = $value;
		$this->inputAttribs = "";
		
		$this->inputDisabled = $disabled;
	
	}

	/**
	 * get HTML of autocompleter
	 * 
	 * @return string
	 */
	function getHTML()
	{
		
		$selectButtonSpace = $this->selectButtonSpace;
		$inputId = empty($this->inputId) ? "yuiAcInput" . $this->acId : $this->inputId;
		$resultId = empty($this->resultId) ? "yuiAcResult" . $this->acId : $this->resultId;
		$containerWidth = (empty($this->containerWidth) ? $this->width : $this->containerWidth);
		
		$client = we_ui_Client::getInstance();
		
		$this->setAutocompleteField($inputId, "yuiAcContainer" . $this->acId, $this->table, $this->contentType, $this->selector, $this->maxResults, 0, "yuiAcLayer" . $this->acId, array($resultId), $this->checkFieldValue, ($client->getBrowser() == we_ui_Client::kBrowserIE ? $containerWidth : ($containerWidth - 8)), $this->mayBeEmpty);
		
		$input = new we_ui_controls_TextField();
		$input->setId($inputId);
		$input->setName($this->inputName);
		$input->setClass($this->inputName);
		$input->setValue($this->inputValue);
		$input->setSize(30);
		$input->setWidth($this->width);
		$input->setDisabled($this->inputDisabled);
		$input->setOnChange($this->getOnChange());
		
		$inputField = $input->getHTML();
		$resultField = we_ui_layout_Form::hidden($this->resultName, $this->resultValue, array('id' => $resultId));
		
		$autoSuggest = "<div style=\"width:" . $this->width . "px;\" id=\"yuiAcLayer{$this->acId}\" >" . $inputField . "<div id=\"yuiAcContainer{$this->acId}\"></div></div>";
		
		$table = new we_ui_layout_Table();
		$table->addHTML($resultField . $autoSuggest, 0, 0);
		$table->setId('table_' . $inputId);
		$table->nextColumn();
		$table->addHTML(we_ui_layout_Image::getPixel($selectButtonSpace, 4), 1, 0);
		$table->nextColumn();
		$table->addHTML($this->selectButton, 2, 0);
		
		$this->acId = "";
		$this->containerWidth = "";
		$this->containerWidthForAll = 0;
		$this->contentType = "folder";
		$this->label = "";
		$this->maxResults = 20;
		$this->mayBeEmpty = 1;
		$this->resultName = "";
		$this->resultValue = "";
		$this->resultId = "";
		$this->selectButton = "";
		$this->selectButtonSpace = "";
		$this->selector = "Dir";
		$this->trashButton = "";
		$this->trashButtonSpace = "";
		$this->table = '';
		$this->width = 280;
		$this->doOnItemSelect = "";
		$this->doOnTextfieldBlur = "";
		
		return $table->getHTML();
	}

	/**
	 * get inputId
	 * 
	 * @return integer
	 */
	function getInputId()
	{
		return $this->inputId;
	}

	/****************************************************************/
	/*                             setter                           */
	/****************************************************************/
	/**
	 * set AcId and rootDir
	 * 
	 * @param integer $val
	 * @param string $rootDir
	 */
	function setAcId($val, $rootDir = "")
	{
		$this->acId = $val;
		$this->rootDir = $rootDir;
	}

	/**
	 * Additional javascript code
	 *
	 * @param unknown_type $val
	 */
	function setAddJS($val)
	{
		$this->addJS = $val;
	}

	/**
	 * Setts the width of the suggest container. Default is input field width
	 *
	 * @param Int $containerWidth
	 * @param Boolean $containerWidthforAll
	 */
	function setContainerWidth($containerWidth)
	{
		$this->containerWidth = $containerWidth;
	}

	/**
	 * Set the content tye to filter result
	 *
	 * @param unknown_type $val
	 */
	function setContentType($val)
	{
		$this->contentType = $val;
	}

	/**
	 * Set DoOnItemSelect
	 *
	 * @param unknown_type $val
	 */
	function setDoOnItemSelect($val)
	{
		$this->doOnItemSelect = $val;
	}

	/**
	 * Set DoOnTextfieldBlur
	 *
	 * @param unknown_type $val
	 */
	function setDoOnTextfieldBlur($val)
	{
		$this->doOnTextfieldBlur = $val;
	}

	/**
	 * Set InputId
	 *
	 * @param unknown_type $val
	 */
	function setInputId($val = '')
	{
		if ($val == '') {
			$this->inputId = "yuiAcInput" . $this->acId;
		} else {
			$this->inputId = $val;
		}
	}

	/**
	 * Set InputName
	 *
	 * @param unknown_type $val
	 */
	function setInputName($val)
	{
		$this->inputName = $val;
	}

	/**
	 * Set InputValue
	 *
	 * @param unknown_type $val
	 */
	function setInputValue($val)
	{
		$this->inputValue = $val;
	}

	/**
	 * Set MaxResults
	 *
	 * @param unknown_type $val
	 */
	function setMaxResults($val)
	{
		$this->maxResults = $val;
	}

	/**
	 * Flag if the autocompleter my be empty
	 *
	 * @param unknown_type $val
	 */
	function setMayBeEmpty($val)
	{
		$this->mayBeEmpty = $val;
	}

	/**
	 * Set Label
	 *
	 * @param unknown_type $val
	 */
	function setLabel($val)
	{
		$this->label = $val;
	}

	/**
	 * Set name, value and id for the result field
	 *
	 * @param unknown_type $resultID
	 * @param unknown_type $resultValue
	 */
	function setResult($resultName, $resultValue = "", $resultID = "")
	{
		$this->resultName = $resultName;
		$this->resultId = $resultID;
		$this->resultValue = $resultValue;
	}

	/**
	 * Set ResultId
	 *
	 * @param unknown_type $val
	 */
	function setResultId($val)
	{
		$this->resultId = $val;
	}

	/**
	 * Set ResultName
	 *
	 * @param unknown_type $val
	 */
	function setResultName($val)
	{
		$this->resultValue = $val;
	}

	/**
	 * Set ResultValue
	 *
	 * @param unknown_type $val
	 */
	function setResultValue($val)
	{
		$this->resultValue = $val;
	}

	/**
	 * Set SelectButton
	 *
	 * @param unknown_type $val
	 * @param integer $space
	 */
	function setSelectButton($val, $space = 20)
	{
		$this->selectButton = $val;
		$this->selectButtonSpace = $space;
	}

	/**
	 * Set the selector
	 *
	 * @param String $val
	 */
	function setSelector($val)
	{
		$this->selector = $val;
	}

	/**
	 * Set the table for query result
	 *
	 * @param unknown_type $val
	 */
	function setTable($val)
	{
		$this->table = $val;
	}

	/**
	 * Set TrashButton
	 *
	 * @param unknown_type $val
	 * @param integer $space
	 */
	function setTrashButton($val, $space = 10)
	{
		$this->trashButton = $val;
		$this->trashButtonSpace = $space;
	}

	/**
	 * Set Width
	 *
	 * @param unknown_type $var
	 */
	function setWidth($var)
	{
		$this->width = $var;
	}

	/**
	 * This function sets the values for the autocompletion fields
	 *
	 * @param unknown_type $inputFieldId
	 * @param unknown_type $containerFieldId
	 * @param unknown_type $table
	 * @param unknown_type $contentType
	 * @param unknown_type $maxResults
	 * @param unknown_type $queryDelay
	 * @param unknown_type $layerId
	 * @param unknown_type $setOnSelectFields
	 * @param unknown_type $checkFieldsValue
	 * @param unknown_type $containerwidth
	 */
	function setAutocompleteField($inputFieldId, $containerFieldId, $table, $contentType = "", $selector = "", $maxResults = 10, $queryDelay = 0, $layerId = null, $setOnSelectFields = null, $checkFieldsValue = true, $containerwidth = "100%", $inputMayBeEmpty = 'true')
	{
		array_push($this->inputfields, $inputFieldId);
		array_push($this->containerfields, $containerFieldId);
		array_push($this->tables, $table);
		array_push($this->contentTypes, $contentType);
		array_push($this->selectors, $selector);
		array_push($this->weMaxResults, $maxResults);
		array_push($this->queryDelay, $queryDelay);
		$layerId ? array_push($this->layer, $layerId) : "";
		array_push($this->setOnSelectFields, $setOnSelectFields);
		array_push($this->checkFieldsValues, $checkFieldsValue);
		array_push($this->containerwidth, $containerwidth);
		array_push($this->inputMayBeEmpty, $inputMayBeEmpty);
		switch ($contentType) {
			case "dirSelector" :
				array($this->ct, "folder");
				break;
			case "Dirselector" :
				array($this->ct, "folder");
				break;
			case "docSelector" :
				array($this->ct, "doc");
				break;
			case "Docselector" :
				array($this->ct, "doc");
				break;
		}
		array_push($this->_doOnItemSelect, $this->doOnItemSelect);
		$this->doOnItemSelect = "";
		array_push($this->_doOnTextfieldBlur, $this->doOnTextfieldBlur);
		$this->doOnTextfieldBlur = "";
	}
}