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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customerFilter.inc.php");

/**
 * Basic view class for customer filters
 *
 */
class weCustomerFilterView {

	/**
	 * filter for view
	 *
	 * @var weAbstractCustomerFilter
	 */
	var $_filter = null;

	/**
	 * Javascript call for making the document hot
	 *
	 * @var string
	 */
	var $_hotScript = '';

	/**
	 * width of filter
	 *
	 * @var integer
	 */
	var $_width = 0;

	/*################### CONSTRUCTOR ####################*/

	/**
	 * Constructor for PHP 4
	 *
	 * @param weAbstractCustomerFilter $filter
	 * @param string $hotScript
	 * @param integer $width
	 * @return weCustomerFilterView
	 */
	function weCustomerFilterView(&$filter, $hotScript="", $width=0) {
		$this->setFilter($filter);
		$this->setHotScript($hotScript);
		$this->setWidth($width);
	}

	/**
	 * Constructor for PHP 5
	 *
	 * @param weAbstractCustomerFilter $filter
	 * @param string $hotScript
	 * @param integer $width
	 * @return weCustomerFilterView
	 */
	function __construct($filter, $hotScript="", $width=0) {
		$this->weCustomerFilterView($filter, $hotScript, $width);
	}

	/*#####################################################*/

	/**
	 * Gets the HTML and Javascript for the filter
	 *
	 * @return string
	 */
	function getFilterHTML() {

		$_script = <<<EO_SCRIPT

<script type="text/javascript">

function $(id) {
	return document.getElementById(id);
}

function updateView() {

EO_SCRIPT;

	$_script .= $this->createUpdateViewScript();
	$_script .= <<<EO_SCRIPT

}

function wecf_hot() {
	$this->_hotScript;
}

function wecf_logic_changed(s) {
	wecf_hot();
	var val = s.options[s.selectedIndex].value;
	var cell = s.parentNode;
	var row = cell.parentNode;
	var prev = row.previousSibling;
	while (prev.nodeName.toLowerCase() != "tr") {
		prev = prev.previousSibling;
	}

	var l = row.childNodes.length;
	var l2 = prev.childNodes.length;

	for (var i=0; i<l2; i++) {
		if (prev.childNodes[i].nodeName.toLowerCase() == "td") {
			prev.childNodes[i].style.paddingBottom = (val=="OR") ? "10px" : "0";
		}
	}
	for (var i=0; i<l; i++) {
		if (row.childNodes[i].nodeName.toLowerCase() == "td") {
			row.childNodes[i].style.paddingTop = (val=="OR") ? "10px" : "0";
			row.childNodes[i].style.borderTop = (val=="OR") ? "1px solid gray" : "0";
		}
	}
}

function removeFromMultiEdit(_multEdit){
	wecf_hot();
	if(_multEdit.itemCount>0){
		while(_multEdit.itemCount>0){
			_multEdit.delItem(_multEdit.itemCount);
		}
	}
}

function addToMultiEdit(_multEdit, paths){
	wecf_hot();
	var path = paths.split(",");
	var found = false;
	var j = 0;
	for (var i = 0; i < path.length; i++) {
		if(path[i]!="") {
			found = false;
			for(j=0;j<_multEdit.itemCount;j++){
				if(_multEdit.form.elements[_multEdit.name+"_variant0_"+_multEdit.name+"_item"+j].value == path[i]) {
					found = true;
				}
			}
			if(!found) {
				_multEdit.addItem();
				_multEdit.setItem(0,(_multEdit.itemCount-1),path[i]);
			}
		}
	}
	_multEdit.showVariant(0);
}

</script>

EO_SCRIPT;

		/* ################# Radio buttons ###############*/
		$_modeRadioOff = we_forms::radiobutton(WECF_OFF, $this->_filter->getMode()===WECF_OFF, 'wecf_mode', $GLOBALS['l_customerFilter']['mode_off'],true, "defaultfont", "wecf_hot();updateView();");
		$_modeRadioAll = we_forms::radiobutton(WECF_ALL, $this->_filter->getMode()===WECF_ALL, 'wecf_mode', $GLOBALS['l_customerFilter']['mode_all'],true, "defaultfont", "wecf_hot();updateView();");
		$_modeRadioSpecific = we_forms::radiobutton(WECF_SPECIFIC, $this->_filter->getMode()===WECF_SPECIFIC, 'wecf_mode', $GLOBALS['l_customerFilter']['mode_specific'],true, "defaultfont", "wecf_hot();updateView();");
		$_modeRadioFilter = we_forms::radiobutton(WECF_FILTER, $this->_filter->getMode()===WECF_FILTER, 'wecf_mode', $GLOBALS['l_customerFilter']['mode_filter'],true, "defaultfont", "wecf_hot();updateView();");


		/* ################# Selector for specific customers ###############*/

		$_customers = id_to_path($this->_filter->getSpecificCustomers(), CUSTOMER_TABLE,"",false,true);
		$_specificCustomersSelect = $this->getMultiEdit('specificCustomersEdit', $_customers, "", $this->_filter->getMode()===WECF_SPECIFIC);

		/* ################# Selector blacklist ###############*/

		$_blackList = id_to_path($this->_filter->getBlackList(), CUSTOMER_TABLE,"",false,true);
		$_blackListSelect = $this->getMultiEdit('blackListEdit', $_blackList, $GLOBALS['l_customerFilter']['black_list'], $this->_filter->getMode()===WECF_FILTER);

		/* ################# Selector for whitelist ###############*/

		$_whiteList = id_to_path($this->_filter->getWhiteList(), CUSTOMER_TABLE,"",false,true);
		$_whiteListSelect = $this->getMultiEdit('whiteListEdit', $_whiteList, $GLOBALS['l_customerFilter']['white_list'], $this->_filter->getMode()===WECF_FILTER);

		/* ################# customer filter ###############*/

		$_filterCustomers = weCustomerFilterView::getDiv($this->getHTMLCustomerFilter(), 'filterCustomerDiv', $this->_filter->getMode()===WECF_FILTER,25);


		/* ################# concate and output ################# */

		$_space = '<div style="height:4px;"></div>';

		return $_script.$_modeRadioOff . $_space . $_modeRadioAll . $_space . $_modeRadioSpecific . $_space . $_specificCustomersSelect . $_space . $_modeRadioFilter . $_filterCustomers .$_blackListSelect . $_whiteListSelect;
	}

	/**
	 * Creates the content for the JavaScript updateView() function
	 *
	 * @return string
	 */
	function createUpdateViewScript() {

		return <<<EOS

	var f = document.forms[0];
	var r = f.wecf_mode;
	var modeRadioOff 		= r[0];
	var modeRadioAll 		= r[1];
	var modeRadioSpecific 	= r[2];
	var modeRadioFilter 	= r[3];

	$('specificCustomersEditDiv').style.display = modeRadioSpecific.checked ? "block" : "none";
	$('blackListEditDiv').style.display = modeRadioFilter.checked ? "block" : "none";
	$('whiteListEditDiv').style.display = modeRadioFilter.checked ? "block" : "none";
	$('filterCustomerDiv').style.display = modeRadioFilter.checked ? "block" : "none";

EOS;

	}

	/**
	 * Creates a HTML div
	 *
	 * @param string $content  Content of the div
	 * @param string $divId id of the div
	 * @param boolean $isVisible
	 * @param integer $marginLeft
	 * @static
	 * @return string
	 */
	function getDiv($content='', $divId='', $isVisible=true, $marginLeft=0) {
		return '<div'.($divId ? (' id="'.$divId.'"') : '').' style="display:'.($isVisible ? 'block' : 'none').';margin-left:'.$marginLeft.'px;margin-top:5px;margin-bottom:10px;">'.$content.'</div>';
	}

	/**
	 * Creates a multi edit gui element for use in customerFilterViews
	 *
	 * @param string $name
	 * @param array $data
	 * @param string $headline
	 * @param boolean $isVisible
	 * @return string
	 */
	function getMultiEdit($name, $data, $headline="", $isVisible=true) {

		$we_button = new we_button();

		$_delBut = addslashes('<img src="'.IMAGE_DIR.'/button/btn_function_trash.gif" onclick="javascript:#####placeHolder#####;wecf_hot();" style="cursor: pointer; width: 27px;-moz-user-select: none;">');

		$_script = <<<EO_SCRIPT

var $name = new multi_edit("{$name}MultiEdit",document.we_form,0,"$_delBut",$this->_width,false);
$name.addVariant();
document.we_form.{$name}Control.value = $name.name;

EO_SCRIPT;


		if(is_array($data)){
			foreach ($data as $_dat) {

				$_script .= "\n" . $name. '.addItem();
' .$name . '.setItem(0,('.$name.'.itemCount-1),"'. $_dat . '");
';

			}
		}

		$_script .= '
'.$name.'.showVariant(0);
';

		$_addbut = $we_button->create_button("add", "javascript:we_cmd('openSelector','','" . CUSTOMER_TABLE . "','','','fillIDs();opener.addToMultiEdit(opener.".$name.", top.allPaths);opener.wecf_hot();','','','',1)");

		$_buttonTable = $we_button->create_button_table(array(
					$we_button->create_button("delete_all", "javascript:removeFromMultiEdit(".$name.")"),
					$_addbut
				)
			);

		$_select = hidden($name.'Control',(isset($_REQUEST[$name.'Control']) ? $_REQUEST[$name.'Control'] : 0)) .
			hidden($name.'Count',(isset($data) ? count($data) : '0')) .
			($headline ? '<div class="defaultfont">'.$headline.'</div>' : '') .
			'<div id="'.$name.'MultiEdit" style="overflow:auto;background-color:white;padding:5px;width:'.($this->_width+($GLOBALS['BROWSER']=="IE" ? 13 : 0)).'px; height: 120px; border: #AAAAAA solid 1px;margin-bottom:5px;"></div>' .
			'<div style="width:'.($this->_width+13).'px;" align="right">'.$_buttonTable . '</div>
<script type="text/javascript">' . $_script . '</script>';
		return weCustomerFilterView::getDiv($_select, $name. 'Div', $isVisible,22);
	}

	function getHTMLCustomerFilter() {

		$we_button=new we_button();

		$_filter_args = array();

		$GLOBALS['DB_WE']->query("SHOW FIELDS FROM " . CUSTOMER_TABLE);
		while ($GLOBALS['DB_WE']->next_record()) {
			$_filter_args[$GLOBALS['DB_WE']->f("Field")] = $GLOBALS['DB_WE']->f("Field");
		}

		$_filter_op = array(
			'0'=>$GLOBALS['l_customerFilter']['equal'],
			'1'=>$GLOBALS['l_customerFilter']['not_equal'],
			'2'=>$GLOBALS['l_customerFilter']['less'],
			'3'=>$GLOBALS['l_customerFilter']['less_equal'],
			'4'=>$GLOBALS['l_customerFilter']['greater'],
			'5'=>$GLOBALS['l_customerFilter']['greater_equal'],
			'6'=>$GLOBALS['l_customerFilter']['starts_with'],
			'7'=>$GLOBALS['l_customerFilter']['ends_with'],
			'8'=>$GLOBALS['l_customerFilter']['contains'],
			'9'=>$GLOBALS['l_customerFilter']['in']

		);

		$_filter_logic = array('AND' => $GLOBALS['l_customerFilter']['AND'], 'OR' => $GLOBALS['l_customerFilter']['OR']);

		$_filter = $this->_filter->getFilter();

		if(empty($_filter)) {
			$this->_filter->setFilter(
				array(
					array(
							'logic'=> '',
							'field'=> 'id',
							'operation'=> '0',
							'value'=> ''
					)
				)
			);
		}

		$_i = 0;
		$_adv_row = '';
		$_first = 0;

		$_styleLogic = 'border: #AAAAAA solid 1px; width: 59px; margin-right: 5px;';
		$_styleLeft = 'border: #AAAAAA solid 1px; width: 160px; margin-right: 5px;';
		$_styleMiddle = 'border: #AAAAAA solid 1px; width: 138px; margin-right: 5px;';
		$_styleRight = 'border: #AAAAAA solid 1px; width: 160px; margin-right: 5px;';

		$_filter = $this->_filter->getFilter();
		foreach ($_filter as $_key => $_value) {

				$_adv_row .= '
				<tr id="filterRow_'.$_i.'">
					<td style="padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						(($_i == 0) ? getPixel(64,1) : htmlSelect('filterLogic_'.$_i,$_filter_logic,1,$_value['logic'],false,'onchange="wecf_logic_changed(this);" class="defaultfont" style="'.$_styleLogic.'"'))
						.
					'</td>
					<td style="padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						htmlSelect('filterSelect_'.$_i,$_filter_args,1,$_value['field'],false,'onchange="wecf_hot();" class="defaultfont" style="'.$_styleLeft.'"')
						.
					'</td>
					<td style="padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						htmlSelect('filterOperation_'.$_i,$_filter_op,1,$_value['operation'],false,'onchange="wecf_hot();" class="defaultfont" style="'.$_styleMiddle.'"')
						.
					'</td>
					<td style="padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						'<input name="filterValue_'.$_i.'" value="'.$_value['value'].'" type="text" onchange="wecf_hot();" class="defaultfont" style="'.$_styleRight.'"/>' .
					'</td>
					<td style="padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						$we_button->create_button("image:btn_function_plus", "javascript:addRow($_i)",true, 25)
						.
					'</td>
					<td style="padding-left:5px;padding-top: '.($_value['logic']=="OR" ? "10px;border-top:1px solid gray" : "4px;border-top:0").';padding-bottom:'.
						((isset($_filter[$_key+1]) && $_filter[$_key+1]['logic']== 'OR') ? '10px' : '0') .';">'.
						(($_i == 0) ? getPixel(25,1) : $we_button->create_button("image:btn_function_trash", "javascript:delRow($_i)",true, 25))
						.
					'</td>
				</tr>
				';
				$_i++;
				$_first = 1;

		}

		$_filter_logic_str = '';

		foreach ($_filter_logic as $_key => $_str) {
			$_filter_logic_str .= '<option value="'.$_key.'">'.$_str.'</option>';
		}

		$_filter_args_str = '';

		foreach ($_filter_args as $_str) {
			$_filter_args_str .= '<option value="'.$_str.'">'.$_str.'</option>';
		}

		$_filter_op_str = '';

		foreach ($_filter_op as $_key => $_str) {
			$_filter_op_str .= '<option value="'.$_key.'">'.$_str.'</option>';
		}

		$_filterTable ='
		<table border="0" cellpadding="0" cellspacing="0" width="'.$this->_width.' height="50">
			<tbody id="filterTable">
				'.$_adv_row.'
			</tbody>
		</table>
		';

		$js = we_htmlElement::jsElement('
			String.prototype.trim=function () {
   				return this.replace(/^\s+|\s+$/g,"");
			}

			function addRow(rowNr) {

				var _table = document.getElementById("filterTable");
				if (_table) {
					var _numRows = _table.rows.length;

					if (typeof(rowNr) == "undefined") {
						rowNr = _numRows;
					}

					var _newRow = _table.insertRow(rowNr);

					_numRows++;

					var _cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";

		       		if (rowNr > 0) {
						_cell.innerHTML=\'<select onchange="wecf_logic_changed(this);" class="weSelect" size="1" style="'.$_styleLogic.'">'.$_filter_logic_str.'</select>\';
		       		} else {
		       			_cell.innerHTML=\''.getPixel(64,1).'\';
		       		}
	       			_newRow.appendChild(_cell);

					_cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";
					_cell.innerHTML=\'<select onchange="wecf_hot();" class="weSelect" size="1" style="'.$_styleLeft.'">'.$_filter_args_str.'</select>\';
        			_newRow.appendChild(_cell);

        			_cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";
					_cell.innerHTML=\'<select onchange="wecf_hot();" class="weSelect" size="1" style="'.$_styleMiddle.'">'.$_filter_op_str.'</select>\';
        			_newRow.appendChild(_cell);

					_cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";
					_cell.innerHTML=\'<input onchange="wecf_hot();" type="text" style="'.$_styleRight.'"/>\';
        			_newRow.appendChild(_cell);

        			_cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";
        			_newRow.appendChild(_cell);

        			_cell = document.createElement("TD");
					_cell.style.paddingTop = "4px";
 					_cell.style.paddingLeft = "5px";
        			_newRow.appendChild(_cell);

        			updateFilterTable();
        			wecf_hot();
				}
			}

			function delRow(rowNr) {
				var _table = document.getElementById("filterTable");
				if(_table){
					var _trows = _table.rows;
					var _rowID = "filterRow_" + rowNr;

		        	for (var i=0; i < _trows.length; i++) {
		        		if (_rowID == _trows[i].id) {
		        			_table.deleteRow(i);
		        			break;
		        		}
		        	}

		        	updateFilterTable();

				}
				wecf_hot();
			}

			function updateFilterTable() {

 				var _table = document.getElementById("filterTable");
				if (_table) {
		   			var _row;
					var _numRows = _table.rows.length;

	    			// now loop through all rows and set names and buttons
	    			for (var i = 0; i < _numRows; i++) {

	    				_row = _table.rows[i];

	    				_row.id = "filterRow_"+i;

	    				_cell = _row.cells[0];  // logic
	 					if (_cell.innerHTML.trim().toLowerCase().substring(0,4) == "<img" && i > 0) {
							_cell.innerHTML=\'<select onchange="wecf_logic_changed(this);" class="weSelect" name="filterLogic_\'+i+\'" size="1" style="'.$_styleLogic.'">'.$_filter_logic_str.'</select>\';
						}

						if (i > 0) {
							_cell.firstChild.name = "filterLogic_" + i;
						}

	    				_cell = _row.cells[1];  // field
	    				_cell.firstChild.name = "filterSelect_"+i;

	    				_cell = _row.cells[2];  // operator
	    				_cell.firstChild.name = "filterOperation_"+i;

	    				_cell = _row.cells[3];  // value
	    				_cell.firstChild.name = "filterValue_"+i;

	    				_cell = _row.cells[4];  // plus
	    				_cell.innerHTML =\''.$we_button->create_button("image:btn_function_plus", "javascript:addRow('+i+')",true, 25).'\';

	    				_cell = _row.cells[5];  // trash
	    				_cell.innerHTML = (i==0) ? \''.getPixel(25,1).'\' : \''.$we_button->create_button("image:btn_function_trash", "javascript:delRow('+i+')",true, 25).'\';

						if (i > 0) {
							_cell = _row.cells[0]
							var elem = _cell.firstChild;

							var _logic = elem.options[elem.selectedIndex].value;
							var _prevRow = _table.rows[i-1];

							for (var n = 0; n < _prevRow.cells.length; n++) {
								_prevRow.cells[n].style.paddingBottom = (_logic=="OR") ? "10px" : "0";
							}
							for (var n = 0; n < _row.cells.length; n++) {
								_row.cells[n].style.paddingTop = (_logic=="OR") ? "10px" : "0";
								_row.cells[n].style.borderTop = (_logic=="OR") ? "1px solid gray" : "0";
							}
						}
					}
       			}
			}

		');


		return $js . $_filterTable . '<div style="height:5px;"></div>' . $we_button->create_button("image:btn_function_plus", "javascript:addRow()");


	}

	/*#########################################################################################
	############################### mutator and accessor methods ##############################
	#########################################################################################*/

	/**
	 * accessor method for $this->_filter
	 *
	 * @return weAbstractCustomerFilter
	 */
	function getFilter() {
		return $this->_filter;
	}

	/**
	 * mutator method for $this->_filter
	 *
	 * @param weAbstractCustomerFilter $filter
	 */
	function setFilter(&$filter) {
		$this->_filter = $filter;
	}

	/**
	 * accessor method for $this->_hotScript
	 *
	 * @return string
	 */
	function getHotScript() {
		return $this->_hotScript;
	}

	/**
	 * mutator method for $this->_hotScript
	 *
	 * @param string $hotScript
	 */
	function setHotScript($hotScript) {
		$this->_hotScript = $hotScript;
	}

	/**
	 * accessor method for $this->_width
	 *
	 * @return integer
	 */
	function getWidth() {
		return $this->_width;
	}

	/**
	 * mutator method for $this->_width
	 *
	 * @param integer $width
	 */
	function setWidth($width) {
		$this->_width = $width;
	}


}



?>