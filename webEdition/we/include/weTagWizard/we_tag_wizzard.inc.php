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

$tagName = $_REQUEST['we_cmd'][1];
$openAtCursor = $_REQUEST['we_cmd'][2] === "1" ? true : false;

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData.class.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/taged.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_tag.inc.php");

if (function_exists('protect')) {
	protect();
} else {
	exit();
}

// include wetag depending on we_cmd[1]
$weTag = weTagData::getTagData($tagName);

if ( !$weTag ) {
	print sprintf($l_taged['tag_not_found'], $tagName);
	exit;
}

$we_button = new we_button();

// needed javascript for the individual tags
	// #1 - all attributes of this we:tag (ids of attributes)
	$_attributes = $weTag->getAllAttributes(true);
	if (sizeof($_attributes)) {
		
		$jsAllAttributes = 'var allAttributes = new Array("';
		$jsAllAttributes .= implode('", "', $_attributes);
		$jsAllAttributes .= '");';
		
	} else {
		$jsAllAttributes = 'var allAttributes = new Array();';
	}
	
	// #2 all required attributes
	$_reqAttributes = $weTag->getRequiredAttributes();
	$jsReqAttributes = "var reqAttributes = new Object();";
	foreach ($_reqAttributes as $_attribName) {
		$jsReqAttributes .= "\n\treqAttributes[\"$_attribName\"] = 1;";
	}
	
	// #3 all neccessary stuff for typeAttribute
	if ($typeAttribute = $weTag->getTypeAttribute()) {
		
		// name of the attribute
		$typeAttributeJs = "var typeAttributeId = \"" . $typeAttribute->getIdName() . "\";\n";
		
		// allowed attributes
		$_typeOptions = $weTag->getTypeAttributeOptions();
		
		if ($_typeOptions) {
			
			$typeAttributeJs .= "var typeAttributeAllows = new Object();\n";
			
			foreach ($_typeOptions as $option) {
				
				$_allowedAttribs = $option->getAllowedAttributes($_attributes);
				
				if (sizeof($_allowedAttribs)) {
					
					$typeAttributeJs .= "\ttypeAttributeAllows[\"" . $option->getName() . "\"] = new Array(\"";
					
					$typeAttributeJs .= implode('","', $_allowedAttribs );
					$typeAttributeJs .= "\");\n";
					
				} else {
					$typeAttributeJs .= "\ttypeAttributeAllows[\"" . $option->getName() . "\"] = new Array();\n";
				}
			}
			
			reset($_typeOptions);
			$typeAttributeJs .= "var typeAttributeRequires = new Object();\n";
			
			foreach ($_typeOptions as $option) {
				
				$_reqAttribs = $option->getRequiredAttributes($_attributes);
				if (sizeof($_reqAttribs)) {
					$typeAttributeJs .= "\ttypeAttributeRequires[\"" . $option->getName() . "\"] = new Array(\"";
					
					$typeAttributeJs .= implode('","', $_reqAttribs );
					$typeAttributeJs .= "\");\n";
					
				} else {
					$typeAttributeJs .= "\ttypeAttributeRequires[\"" . $option->getName() . "\"] = new Array();\n";
				}
				
			}
			
			$typeAttributeJs .= "weTagWizard.typeAttributeAllows = typeAttributeAllows;\nweTagWizard.typeAttributeRequires = typeAttributeRequires;\n";
		}
		$typeAttributeJs .= "weTagWizard.typeAttributeId = typeAttributeId;\n";
	} else {
		$typeAttributeJs = '';
	}
// additional javascript for the individual tags - end



// print html header of page
print htmlTop();
print STYLESHEET;
print '
<link href="'.CSS_DIR.'tagWizard.css" rel="styleSheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'windows.js"></script>
<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'tagWizard.js"></script>
<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'keyListener.js"></script>
<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'attachKeyListener.js"></script>
<script type="text/javascript">

function closeOnEscape() {
	return true;
}

function applyOnEnter(evt) {
	
	_elemName = "target";
	if ( typeof(evt["srcElement"]) != "undefined" ) { // IE
		_elemName = "srcElement";
	}
	
	if (	!( evt[_elemName].tagName == "SELECT")
		) {
		we_cmd("saveTag");
		return true;
	}

	
}

</script>
<script type="text/javascript">

' . $jsAllAttributes . '

' . $jsReqAttributes . '

weTagWizard = new weTagWizard("' . $weTag->getName() . '");
weTagWizard.allAttributes = allAttributes;
weTagWizard.reqAttributes = reqAttributes;
' . ($weTag->needsEndTag() ? 'weTagWizard.needsEndTag = true;' : '') . '

// information about the type-attribute
' . $typeAttributeJs . '
function we_cmd(){
    
	var args = "";
	var url = "' . WEBEDITION_DIR . 'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
	switch (arguments[0]){
		
		case "switch_type":
			weTagWizard.changeType(arguments[1]);
		break;
		
		case "saveTag":
		
			if (strWeTag = weTagWizard.getWeTag()) {
				
				' . 
					( $openAtCursor
						? '
				var contentEditor = opener.top.weEditorFrameController.getVisibleEditorFrame();
				contentEditor.window.addCursorPosition( strWeTag );
				self.close();;
				'
						: '
				var contentEditor = opener.top.weEditorFrameController.getVisibleEditorFrame();
				contentEditor.document.we_form.elements["tag_edit_area"].value=strWeTag;
    			contentEditor.document.we_form.elements["tag_edit_area"].select();
    			self.close();'

					) . '
			
				
				
			} else {
				
				if (weTagWizard.missingFields.length) {
					
					req = "";
					for (i=0;i<weTagWizard.missingFields.length;i++) {
						req += "- " + weTagWizard.missingFields[i] + "\n";
					}
					req = "' . $l_taged['fill_required_fields'] . '\n" + req;
					' . we_message_reporting::getShowMessageCall("req", WE_MESSAGE_WARNING, true) . '
				} else {
					' . we_message_reporting::getShowMessageCall($l_taged['no_type_selected'], WE_MESSAGE_WARNING) . '
				}
			}
		break;
		
		case "openDirselector":
			new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,true,true,true);
			break;
		case "openDocselector":
			new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_DOCSELECTOR_WIDTH.','.WINDOW_DOCSELECTOR_HEIGHT.',true,true,true,true);
			break;
		case "openSelector":
			new jsWindow(url,"we_fileselector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
			break;
		case "openCatselector":
			new jsWindow(url,"we_catselector",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);
			break;
		case "browse_users":
	        new jsWindow(url,"browse_users",-1,-1,500,300,true,false,true);
	        break;
		default:
			for(var i = 0; i < arguments.length; i++){
				args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
			}
			eval("opener.top.we_cmd("+args+")");
			break;
	    }
    }
</script>
</head>
<body onload="window.focus();" class="defaultfont">
<form name="we_form" onsubmit="we_cmd(\'saveTag\'); return false;">
';
// start building the content of the page

$content = '';

// get all attributes
$typeAttribCode = $weTag->getTypeAttributeCodeForTagWizard();
$attributesCode = $weTag->getAttributesCodeForTagWizard();
$defaultValueCode = ($weTag->needsEndTag() ? $weTag->getDefaultValueCodeForTagWizard() : '');

if ($typeAttribCode) {
	
	$typeAttribCode = "
	<hr />
	<fieldset>
		<div class='legend'><strong>" . $GLOBALS['l_taged']['type_attribute'] . "</strong></div>
		$typeAttribCode
	</fieldset>";
}
if ($attributesCode) {
	
	$attributesCode = "
	<hr />
	<fieldset>
		<div class='legend'><strong>" . $GLOBALS['l_taged']['attributes'] . "</strong></div>
		" . ($typeAttribCode ? '<ul id="no_type_selected_attributes"><li>' . $GLOBALS['l_taged']['no_type_selected'] . '</li></ul>' : '' ) . "
		" . ($typeAttribCode ? '<ul id="no_attributes_for_type" style="display: none;"><li>' . $GLOBALS['l_taged']['no_attributes_for_type'] . '</li></ul>' : '' ) . "
		$attributesCode
	</fieldset>";
}
if ($defaultValueCode) {
	
	$defaultValueCode = "
	<hr />
	<fieldset>
		<div class='legend'><strong>" . we_htmlElement::htmlLabel(array('id'=>'label_weTagData_defaultValue', 'for' => 'weTagData_defaultValue'), $GLOBALS['l_taged']['defaultvalue'] . ':<br />') . "</strong></div>
		$defaultValueCode
	</fieldset>";
}

$code = "
	<fieldset>
		<div class='legend'><strong>" . $GLOBALS['l_taged']['description'] . "</strong></div>
		" . $l_we_tag[$weTag->getName()]['description'] . "
	</fieldset>
	$typeAttribCode
	$attributesCode
	$defaultValueCode
";



$_buttons = we_button::position_yes_no_cancel(
	$we_button->create_button('ok',"javascript:we_cmd('saveTag');"),
	null,
	$we_button->create_button('cancel',"javascript:self.close();")
);

?>
<div id="divTagName">
	<h1>&lt;we:<?php print $weTag->getName(); ?>&gt;</h1>
</div>
<div id="divContent">
	<?php print $code; ?>
	<br>
</div>
<div id="divButtons">
	<div style="padding-top: 8px;">
		<?php print $_buttons; ?>
	</div>
</div>
<input type="submit" style="width:1px; height:1px; padding:0px; margin:0px; color:#fff; background-color:#fff; border:0px;">


<?php
print '
</form>
</body>
</html>';
?>