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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
protect();

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');

$_margin_top = 5;
$_space_size = 100;
$_input_size = 440;

$we_button = new we_button();

$_path = isset($_REQUEST['we_cmd'][1]) ? $_REQUEST['we_cmd'][1] : '';

$_id = (!empty($_path)) ? path_to_id($_path, NAVIGATION_TABLE) : 0;

$_cmd = 'opener.we_cmd("add_navi",' . $_id . ',document.we_form.Text.value,dir.options[dir.selectedIndex].value,document.we_form.Ordn.value);';

$_navi = new weNavigation($_id);

$_wrkNavi = '';

if (!we_hasPerm('ADMINISTRATOR')) {
	$_wrkNavi = makeArrayFromCSV(
			f(
					'SELECT workSpaceNav FROM ' . USER_TABLE . ' WHERE ID=' . $_SESSION['user']['ID'], 
					'workSpaceNav', 
					new DB_WE()));
	$_condition = array();
	foreach ($_wrkNavi as $_key => $_value) {
		$_condition[] = 'Path LIKE "' . id_to_path($_value, NAVIGATION_TABLE) . '/%"';
	}
	$_dirs = array();
	$_def = null;
} else {
	$_dirs = array(
		'0' => '/'
	);
	$_def = 0;
}

if ($_id) {
	$_def = $_navi->ParentID;
}

$_db = new DB_WE();
$_db->query(
		'SELECT * FROM ' . NAVIGATION_TABLE . ' WHERE IsFolder=1 ' . (!empty($_wrkNavi) ? ' AND (ID IN (' . implode(
				',', 
				$_wrkNavi) . ') OR (' . implode(' OR ', $_condition) . '))' : '') . ' ORDER BY Path;');
while ($_db->next_record()) {
	if ($_def === null) {
		$_def = $_db->f('ID');
	}
	$_dirs[$_db->f('ID')] = $_db->f('Path');
}

$_parts = array();

$_parts[] = array(
	
		'headline' => $l_navigation['name'], 
		'html' => htmlTextInput(
				'Text', 
				24, 
				$_navi->Text, 
				'', 
				'style="width: ' . $_input_size . 'px;" onblur="if(document.we_form.Text.value!=\'\') switch_button_state(\'save\', \'save_enabled\', \'enabled\'); else switch_button_state(\'save\', \'save_disabled\', \'disabled\');" onkeyup="if(document.we_form.Text.value!=\'\') switch_button_state(\'save\', \'save_enabled\', \'enabled\'); else switch_button_state(\'save\', \'save_disabled\', \'disabled\');"'), 
		'space' => $_space_size, 
		'noline' => 1
);

$_parts[] = array(
	
		'headline' => $l_navigation['group'], 
		'html' => htmlSelect(
				'ParentID', 
				$_dirs, 
				1, 
				$_navi->ParentID, 
				false, 
				($GLOBALS['BROWSER'] == "IE" ? '' : 'style="width: ' . $_input_size . 'px;" ') . 'onChange="queryEntries(this.value)"'), 
		'space' => $_space_size, 
		'noline' => 1
);

$_parts[] = array(
	
		'headline' => '', 
		'html' => '<div id="details" class="blockWrapper" style="width: ' . $_input_size . 'px;height: 100px;"></div>', 
		'space' => $_space_size, 
		'noline' => 1
);

$_parts[] = array(
	
		'headline' => $l_navigation['order'], 
		'html' => hidden('Ordn', $_navi->Ordn) . htmlTextInput(
				'OrdnTxt', 
				8, 
				($_navi->Ordn + 1), 
				'', 
				'onchange="document.we_form.Ordn.value=(document.we_form.OrdnTxt.value-1);"', 
				'text', 
				117) . getPixel(6, 5) . htmlSelect(
				'OrdnSelect', 
				array(
					'begin' => $l_navigation['begin'], 'end' => $l_navigation['end']
				), 
				1, 
				'', 
				false, 
				'onchange="document.we_form.OrdnTxt.value=document.we_form.OrdnSelect.options[document.we_form.OrdnSelect.selectedIndex].text;document.we_form.Ordn.value=this.value;"', 
				"value", 
				317), 
		'space' => $_space_size, 
		'noline' => 1
);

$_js = $we_button->create_state_changer(false) . '
				function save() {
					var dir = document.we_form.ParentID;
					' . $_cmd . '
					self.close();

				}
				
				var ajaxObj = { 
				 
				    handleSuccess:function(o){ 
				        this.processResult(o); 
				        
				        if(o["responseText"]) {
				        
				        	document.getElementById("details").innerHTML = "";
				        	
				        	eval(o["responseText"]);
				        	
				        	var items = weResponse.data.split(",");
				        	
				        	var i = 0;
				        	
				        	for(s in items) {
				        		i++;
				        		var row = items[s].split(":");
				        		if(row.length>1) {
				        			document.getElementById("details").innerHTML += "<div style=\"width: 40px; float: left;\">"+i+"</div><div style=\"width: 220px;\">"+row[1]+"</div>";
				        		}
				        	}

				        }
				        
				    }, 
				 
				    handleFailure:function(o){ 
				        // Failure handler 
				    }, 
				 
				    processResult:function(o){ 
				        // This member is called by handleSuccess 
				    }, 
				 
				    startRequest:function(id) { 
				       YAHOO.util.Connect.asyncRequest("POST", "/webEdition/rpc/rpc.php", callback, "cmd=GetNaviItems&nid="+id); 
				    } 
				 
				}; 
	 
	 
				var callback = 
				{ 
				    success:ajaxObj.handleSuccess, 
				    failure:ajaxObj.handleFailure, 
				    scope: ajaxObj 
				}; 
	 
				
				function queryEntries(id) {
					ajaxObj.startRequest(id); 
				
				}
							
				
				
		';
$buttonsBottom = '<div style="float:right">' . $we_button->position_yes_no_cancel(
		$we_button->create_button('save', 'javascript:save();', true, 100, 22, '', '', ($_id ? false : true), false), 
		null, 
		$we_button->create_button('close', 'javascript:self.close();')) . '</div>';

$_body = we_htmlElement::htmlBody(
		array(
			"class" => "weDialogBody", "onLoad" => "loaded=1;queryEntries(" . $_def . ")"
		), 
		we_htmlElement::htmlForm(
				array(
					"name" => "we_form", "onsubmit" => "return false"
				), 
				we_multiIconBox::getHTML(
						'', 
						'100%', 
						$_parts, 
						30, 
						$buttonsBottom, 
						-1, 
						'', 
						'', 
						false, 
						$l_navigation['add_navigation'], 
						"", 
						311)))

;

$_head = WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . we_htmlElement::jsElement(
		'', 
		array(
			'src' => '/webEdition/js/libs/yui/yahoo-min.js'
		)) . "\n" . we_htmlElement::jsElement('', array(
	'src' => '/webEdition/js/libs/yui/event-min.js'
)) . "\n" . we_htmlElement::jsElement('', array(
	'src' => '/webEdition/js/libs/yui/connection-min.js'
)) . "\n" . we_htmlElement::jsElement($_js);

print we_htmlElement::htmlHtml(we_htmlElement::htmlHead($_head) . $_body);

?>