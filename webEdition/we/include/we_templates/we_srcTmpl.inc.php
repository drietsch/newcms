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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tag.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_util.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_forms.inc.php");

$parts = array();

if(isset($we_doc->elements["Charset"]["dat"])){	//	send charset which might be determined in template
	header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
}

if($we_editmode) {
	htmlTop('',isset($we_doc->elements["Charset"]["dat"]) ? $we_doc->elements["Charset"]["dat"] : '');
}
?>

<?php if($we_editmode){ ?>
	<script language="JavaScript" type="text/javascript" src="<?php print JS_DIR ?>windows.js"></script>
	<?php include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_editor_script.inc.php"); ?>
	<?php
		print STYLESHEET;

		$we_button = new we_button();
		
		$_useJavaEditor = $_SESSION["prefs"]['use_jeditor'];
	?>

	<script language="JavaScript" type="text/javascript">

		var weIsTextEditor = true;

		function sizeEditor() {
			var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
			var w = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
			w = Math.max(w,350);
			var editorWidth = w - 37;

			var wizardOpen = weGetCookieVariable("but_weTMPLDocEdit") == "right";

			var editarea = document.getElementById("editarea");

			var wizardTable = document.getElementById("wizardTable");
			var tagAreaCol = document.getElementById("tagAreaCol");
			var tagSelectCol = document.getElementById("tagSelectCol");
			var spacerCol = document.getElementById("spacerCol");
			var tag_edit_area = document.getElementById("tag_edit_area");
			
			if (editarea) {
				editarea.style.width=editorWidth;
			}
			
			if (document.weEditorApplet) {
				document.weEditorApplet.width = editorWidth;
			}
			
			
			if (h) { // h must be set (h!=0), if several documents are opened very fast -> editors are not loaded then => h = 0
				
				
				
				if (wizardTable != null) {
					
					var editorHeight = (h - (wizardOpen ? 110 : 285));
					
					if (editarea) {
						editarea.style.height= (h - (wizardOpen ? 110 : 285)) + "px";
					}
					
					if (document.weEditorApplet && typeof(document.weEditorApplet.setSize) != "undefined") {
						document.weEditorApplet.height = editorHeight;
    					document.weEditorApplet.setSize(editorWidth,editorHeight);
    				}
 					
					
					wizardTable.style.width=editorWidth+"px";
					wizardTableButtons.style.width=editorWidth+"px";
					tagAreaCol.style.width=(editorWidth-300)+"px";
					tag_edit_area.style.width=(editorWidth-300)+"px";
					tagSelectCol.style.width = "250px";
					spacerCol.style.width = "50px";

 				} else {
 					if (editarea) {
 						editarea.style.height = h - 110;
 					}
 					
 					if (document.weEditorApplet && typeof(document.weEditorApplet.setSize) != "undefined") {
						document.weEditorApplet.height = h - 110;
    					document.weEditorApplet.setSize(editorWidth,h - 110);
    				}
				}
			}
  			window.scroll(0,0);

		}
				
		function initEditor() {
			if (document.weEditorApplet) {
				if (top.weEditorWasLoaded && document.weEditorApplet && typeof(document.weEditorApplet.setCode) != "undefined") {
					document.getElementById("weEditorApplet").style.left="0";
					document.weEditorApplet.setCode(document.forms['we_form'].elements["<?php print 'we_'.$we_doc->Name.'_txt[data]'; ?>"].value);					
					document.weEditorApplet.initUndoManager();
					
					sizeEditor();
					checkAndSetHot();
				} else {
					setTimeout(initEditor, 1000);
				}
			} else {
				sizeEditor();
				window.setTimeout('scrollToPosition();',50);
			}
			document.getElementById("bodydiv").style.display="block";
		}
		
		function toggleTagWizard() {
			var w = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
			w = Math.max(w,350);
			var editorWidth = w - 37;
			var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
			var wizardOpen = weGetCookieVariable("but_weTMPLDocEdit") == "down";
			if (document.weEditorApplet) {
				var editorHeight = h- (wizardOpen ? 110 : 285);
				document.weEditorApplet.height = editorHeight;
    			document.weEditorApplet.setSize(editorWidth,editorHeight);
			} else {

				var editarea = document.getElementById("editarea");
				editarea.style.height=h- (wizardOpen ? 110 : 285);
			}

		}
		
		// ################ Java Editor specific Functions
		
		function weEditorSetHiddenText() {
			if (document.weEditorApplet && typeof(document.weEditorApplet.getCode) != "undefined") {
				if (document.weEditorApplet.isHot()) {
					_EditorFrame.setEditorIsHot(true);
					document.weEditorApplet.setHot(false);
				}
				document.forms['we_form'].elements["<?php print 'we_'.$we_doc->Name.'_txt[data]'; ?>"].value = document.weEditorApplet.getCode();
			}
		}

		
		function checkAndSetHot() {
			if (document.weEditorApplet && typeof(document.weEditorApplet.isHot) != "undefined") {
				if (document.weEditorApplet.isHot()) {
					_EditorFrame.setEditorIsHot(true);
				} else {
					setTimeout("checkAndSetHot()", 1000);
				}
			}
		}
		
		function setCode() {
			if (document.weEditorApplet && typeof(document.weEditorApplet.setCode) != "undefined") {
				document.weEditorApplet.setCode(document.forms['we_form'].elements["<?php print 'we_'.$we_doc->Name.'_txt[data]'; ?>"].value);
			}
		}

		// ################## Textarea specific functions #############

		function getScrollPosTop () {
			var elem = document.getElementById("editarea");
			if (elem) {
				return elem.scrollTop;
			}
			return 0;
			
		}

		function getScrollPosLeft () {
			var elem = document.getElementById("editarea");
			if (elem) {
				return elem.scrollLeft;
			}
			return 0;
		}

		function scrollToPosition () {
			var elem = document.getElementById("editarea");
			if (elem) {
				elem.scrollTop=parent.editorScrollPosTop;
				elem.scrollLeft=parent.editorScrollPosLeft;
			}
		}

		function wedoKeyDown(ta,keycode){
		
			if (keycode == 9) { // TAB
				if (ta.setSelectionRange) {
					var selectionStart = ta.selectionStart;
					var selectionEnd = ta.selectionEnd;
					ta.value = ta.value.substring(0, selectionStart)
						  + "\t"
						  + ta.value.substring(selectionEnd);
					ta.focus();
					ta.setSelectionRange(selectionEnd+1, selectionEnd+1);
					ta.focus();
					return false;

				} else if (document.selection) {
					var selection = document.selection;
					var range = selection.createRange();
					range.text = "\t";
					return false;
				}
			}
				
			return true;
		}
		// ############ EDITOR PLUGIN ################
		
		function setSource(source){
			document.forms['we_form'].elements['we_<?php print $we_doc->Name; ?>_txt[data]'].value=source;
			// for Applet
			setCode(source);
		}

		function getSource(){
			if (document.weEditorApplet && typeof(document.weEditorApplet.getCode) != "undefined") {
				return document.weEditorApplet.getCode();
			} else {
				return document.forms['we_form'].elements['we_<?php print $we_doc->Name; ?>_txt[data]'].value;
			}
		}

		function getCharset(){
			return "<?php print !empty($we_doc->elements['Charset']['dat']) ? $we_doc->elements['Charset']['dat'] : $GLOBALS["_language"]["charset"]; ?>";
		}

	</script>
	</head>
	<body class="weEditorBody" style="overflow:hidden;" onLoad="setTimeout('initEditor()',200);" onUnload="doUnload(); parent.editorScrollPosTop = getScrollPosTop(); parent.editorScrollPosLeft = getScrollPosLeft();" onresize="sizeEditor();"><?php //' ?>
		<form name="we_form" method="post" onsubmit="return false;"><?php $we_doc->pHiddenTrans(); ?>
<?php }

	if($we_editmode){ ?>
	<?php
    if( isset($_SESSION["we_wrapcheck"]) &&  $_SESSION["we_wrapcheck"]){
			$wrap = "virtual";
		}
		else {
			$wrap = "off";
		}

		$code = $we_doc->getElement("data");
		if($we_doc->ClassName == "we_htmlDocument"){

			$code = $we_doc->getDocumentCode();
		}

        $maineditor = '<table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
            	';
        
        if ($_useJavaEditor) {
        	
            $maineditor .= '<input type="hidden" name="we_'.$we_doc->Name.'_txt[data]" value="'. htmlspecialchars( $code ) .'" />
            <applet id="weEditorApplet" style="position:relative;right:-3000px;" name="weEditorApplet" code="Editor.class" archive="editor.jar" width="3000" height="3000" MAYSCRIPT SCRIPTABLE codebase="http://'.$SERVER_NAME.((isset($SERVER_PORT) && $SERVER_PORT != 80) ? ":".$SERVER_PORT : "").'/webEdition/editor/">
            	<param name="phpext" value=".php">';
        
	        if ($_SESSION["prefs"]["editorFont"] == 1) {
	        	// translate html font names into java font names
	        	if ($_SESSION["prefs"]["editorFontname"] == "mono") {
	        		$fontname = "monospaced";
	        	} else if ($_SESSION["prefs"]["editorFontname"] == "sans-serif") {
	        		$fontname = "sansserif";
	        	} else {
	        		$fontname = $_SESSION["prefs"]["editorFontname"];
	        	}
	      	 	$maineditor .= '<param name="fontName" value="'.$fontname.'">';
	      	 	$maineditor .= '<param name="fontSize" value="'.$_SESSION["prefs"]["editorFontsize"].'">';
	        }
	        
	        if ($_SESSION["prefs"]["specify_jeditor_colors"] == 1) {
	      	 	$maineditor .= '<param name="normalColor" value="'.$_SESSION["prefs"]["editorFontcolor"].'">';	
	      	 	$maineditor .= '<param name="weTagColor" value="'.$_SESSION["prefs"]["editorWeTagFontcolor"].'">';	
	      	 	$maineditor .= '<param name="weAttributeColor" value="'.$_SESSION["prefs"]["editorWeAttributeFontcolor"].'">';	
	      	 	$maineditor .= '<param name="HTMLTagColor" value="'.$_SESSION["prefs"]["editorHTMLTagFontcolor"].'">';	
	      	 	$maineditor .= '<param name="HTMLAttributeColor" value="'.$_SESSION["prefs"]["editorHTMLAttributeFontcolor"].'">';	
	      	 	$maineditor .= '<param name="piColor" value="'.$_SESSION["prefs"]["editorPiTagFontcolor"].'">';	
	      	 	$maineditor .= '<param name="commentColor" value="'.$_SESSION["prefs"]["editorCommentFontcolor"].'">';	
	       	
	        }
	            	
	        $maineditor .=	'
	            	</applet>
	            	';
        } else {
        	$maineditor .= '<textarea id="editarea" style="width: ' . (($_SESSION["prefs"]["editorWidth"] != 0) ? $_SESSION["prefs"]["editorWidth"] : "700") . 'px; height: ' . (($_SESSION["prefs"]["editorHeight"] != 0) ? $_SESSION["prefs"]["editorHeight"] : "320") . 'px;' . (($_SESSION["prefs"]["editorFont"] == 1) ? " font-family: " . $_SESSION["prefs"]["editorFontname"] . "; font-size: " . $_SESSION["prefs"]["editorFontsize"] . "px;" : "") . '" id="data" name="we_'.$we_doc->Name.'_txt[data]" wrap="'.$wrap.'" '.(($BROWSER=="NN6" && ( !isset($_SESSION["we_wrapcheck"]) || !$_SESSION["we_wrapcheck"] )) ? '' : ' rows="20" cols="80"').' onChange="_EditorFrame.setEditorIsHot(true);" '.(($GLOBALS["BROWSER"]=="IE") ? 'onkeydown="return wedoKeyDown(this,event.keyCode);"' : 'onkeypress="return wedoKeyDown(this,event.keyCode);"').'>'
        			. htmlspecialchars( $code ) . '</textarea>';
        }
        
        $maineditor .=	'</td>
         </tr>   
         <tr>
            <td align="left">';
		$maineditor .= getPixel(2,10).'<br><table cellpadding="0" cellspacing="0" border="0" width="100%">
	    <tr>';

		$maineditor .= '<td align="right" class="defaultfont">'.
					($_useJavaEditor ? "" : we_forms::checkbox(	"1",
										( isset($_SESSION["we_wrapcheck"]) && $_SESSION["we_wrapcheck"] == "1" ),
										"we_wrapcheck_tmp",
										$l_global["wrapcheck"],
										false,
										"defaultfont",
										"we_cmd('wrap_on_off',this.checked)")) . '</td>	</tr>
        </table></td></tr></table>
';
$znr = -1;
$wepos="";
array_push($parts,array("headline"=>"","html"=>$maineditor,"space"=>0));
	?>
<?php } else { ?>
	<?php print $maineditor; ?>
<?php }  ?>

<?php if($we_editmode){ ?>
	<?php if($we_doc->ContentType=="text/weTmpl"){ ?>
		<?php

			// Code Wizard
			require_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/weCodeWizard/classes/weCodeWizardSnippet.inc.php");
			require_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/weCodeWizard/classes/weCodeWizard.inc.php");

			$CodeWizard = new weCodeWizard();

			// NEW TAGWIZARD
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagWizard.class.php');
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/we_tag_groups.inc.php');
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/enc_we_tag_wizard.inc.php');
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/javaMenu/module_information.inc.php');

			$allWeTags = weTagWizard::getExistingWeTags();

			$tagGroups = weTagWizard::getWeTagGroups($allWeTags);

			$groupselect = '<select class="weSelect" style="width: 250px;" id="weTagGroupSelect" name="we_'.$we_doc->Name.'_TagWizardSelection" onchange="selectTagGroup(this.value);">';
			$groupJs = "tagGroups = new Array();\n";

			$selectedGroup = isset($we_doc->TagWizardSelection) && !empty($we_doc->TagWizardSelection) ? $we_doc->TagWizardSelection : "alltags";
			$groupselect .= '<optgroup label="' . $GLOBALS['l_weCodeWizard']['snippets'] . '">';
			$groupselect .= '<option value="snippet_standard" '. ($selectedGroup=="snippet_standard"? "selected" : "") . '>' . $GLOBALS['l_weCodeWizard']['standard_snippets'] . '</option>';
			$groupselect .= '<option value="snippet_custom" '. ($selectedGroup=="snippet_custom"? "selected" : "") . '>' . $GLOBALS['l_weCodeWizard']['custom_snippets'] . '</option>';
			$groupselect .= '</optgroup>';
			$groupselect .= '<optgroup label="we:tags">';

			foreach ($tagGroups as $tagGroupName => $tags) {

				if ($tagGroupName == 'custom') {
					$groupselect .= '<option value="-1" disabled="disabled">----------</option>';
				}
				$groupselect .= '<option value="' . $tagGroupName . '"' . ($tagGroupName==$selectedGroup?' selected="selected"':'') . '">' . (in_array($tagGroupName, $GLOBALS['_we_active_modules']) ? $l_javaMenu["module_information"][$tagGroupName]["text"] : (isset($GLOBALS['l_we_tag_groups'][$tagGroupName]) ? $GLOBALS['l_we_tag_groups'][$tagGroupName] : $GLOBALS['l_we_tag_wizard'][$tagGroupName] )) . '</option>';
				if ($tagGroupName == 'alltags') {
					$groupselect .= '<option value="-1" disabled="disabled">----------</option>';
				}
				$groupJs .= "tagGroups['" . $tagGroupName . "'] = new Array('" . implode("', '", $tags) . "');\n";
			}
			$groupselect .= '</optgroup>';
			$groupselect .= '</select>';

			$tagselect = '<select onkeydown="evt=event?event:window.event; return openTagWizWithReturn(evt)" class="defaultfont" style="width: 250px; height: 100px;" size="7" ondblclick="edit_wetag(this.value);" name="tagSelection" id="tagSelection" onChange="weButton.enable(\'btn_direction_right_applyCode\')">';

			for ($i=0;$i<sizeof($allWeTags); $i++) {
				$tagselect .= '
	<option value="' . $allWeTags[$i] . '">' . $allWeTags[$i] . '</option>';
			}


			$tagselect .= '
</select>';

			// buttons
			$editTagbut   = $we_button->create_button("image:btn_direction_right", "javascript:executeEditButton();",true,100,22,"","",false,false,"_applyCode");
			$selectallbut = $we_button->create_button("selectAll", "javascript:document.getElementById(\"tag_edit_area\").focus(); document.getElementById(\"tag_edit_area\").select();");
			$prependbut   = $we_button->create_button("prepend", 'javascript:insertAtStart(document.getElementById("tag_edit_area").value);');
			$appendbut    = $we_button->create_button("append", 'javascript:insertAtEnd(document.getElementById("tag_edit_area").value);');
			$addCursorPositionbut    = $we_button->create_button("addCursorPosition", 'javascript:addCursorPosition(document.getElementById("tag_edit_area").value);_EditorFrame.setEditorIsHot(true);');

			$tagWizardHtml = $CodeWizard->getJavascript();
			$tagWizardHtml .= '
		<script type="text/javascript">
			function executeEditButton() {
				if(document.getElementById(\'weTagGroupSelect\').value == \'snippet_custom\') {
					YUIdoAjax(document.getElementById(\'codesnippet_custom\').value);

				} else if(document.getElementById(\'weTagGroupSelect\').value == \'snippet_standard\') {
					YUIdoAjax(document.getElementById(\'codesnippet_standard\').value);

				} else {
					var _sel=document.getElementById(\'tagSelection\');
					if(_sel.selectedIndex > -1) {
						edit_wetag(_sel.value);
					}
				}
		 	}

		 	function openTagWizardPrompt( _wrongTag ) {


		 		var _prompttext = "' . $GLOBALS['l_we_tag_wizard']['insert_tagname'] . '";
		 		if ( _wrongTag ) {
		 			_prompttext = "' . sprintf( $GLOBALS['l_we_tag_wizard']['insert_tagname_not_exist'], '\"" + _wrongTag + "\"' ) . '\n\n" + _prompttext;
		 		}

		 		var _tagName = prompt(_prompttext);
		 		var _tagExists = false;

		 		if ( typeof(_tagName) == "string") {

			 		for ( i=0; i < tagGroups["alltags"].length && !_tagExists; i++ ) {
			 			if ( tagGroups["alltags"][i] == _tagName ) {
			 				_tagExists = true;

			 			}
			 		}

			 		if ( _tagExists ) {
			 			edit_wetag(_tagName, 1);

			 		} else {
			 			openTagWizardPrompt( _tagName );

			 		}
			 	}
		 	}

			function edit_wetag(tagname, insertAtCursor) {
				if (!insertAtCursor) {
					insertAtCursor = 0;
				}
				we_cmd("open_tag_wizzard", tagname, insertAtCursor);

			}
			
			function insertAtStart(tagText) {
				if (document.weEditorApplet && typeof(document.weEditorApplet.insertAtStart) != "undefined") {
					document.weEditorApplet.insertAtStart(tagText);
				} else {
				 	document.we_form["we_' . $we_doc->Name . '_txt[data]"].value = tagText + "\n" + document.we_form["we_' . $we_doc->Name . '_txt[data]"].value;
				}
				_EditorFrame.setEditorIsHot(true);
			}
			
			function insertAtEnd(tagText) {
				if (document.weEditorApplet && typeof(document.weEditorApplet.insertAtEnd) != "undefined") {
					document.weEditorApplet.insertAtEnd(tagText);
				} else {
					document.we_form["we_' . $we_doc->Name . '_txt[data]"].value += "\n" + tagText;
				}
				_EditorFrame.setEditorIsHot(true);
			
			}
			
			function addCursorPosition ( tagText ) {
			
				if (document.weEditorApplet && typeof(document.weEditorApplet.replaceSelection) != "undefined") {
					document.weEditorApplet.replaceSelection(tagText);
				} else {
			
					var weForm = document.we_form["we_' . $we_doc->Name . '_txt[data]"];
					if(document.selection)
					    {
					        weForm.focus();
					        document.selection.createRange().text=tagText;
					        document.selection.createRange().select();
					    }
					else if (weForm.selectionStart || weForm.selectionStart == "0")
						{
							intStart = weForm.selectionStart;
							intEnd = weForm.selectionEnd;
							weForm.value = (weForm.value).substring(0, intStart) + tagText + (weForm.value).substring(intEnd, weForm.value.length);
						    window.setTimeout("scrollToPosition();",50);
							weForm.focus();
						    weForm.selectionStart = eval(intStart+tagText.length);
						    weForm.selectionEnd = eval(intStart+tagText.length);
						}
					else
						{
							weForm.value += tagText;
						}
				}
			}

			function selectTagGroup(groupname) {

				if(groupname == "snippet_custom") {
					document.getElementById(\'codesnippet_standard\').style.display = \'none\';
					document.getElementById(\'tagSelection\').style.display = \'none\';
					document.getElementById(\'codesnippet_custom\').style.display = \'block\';

				} else if(groupname == "snippet_standard") {
					document.getElementById(\'codesnippet_custom\').style.display = \'none\';
					document.getElementById(\'tagSelection\').style.display = \'none\';
					document.getElementById(\'codesnippet_standard\').style.display = \'block\';

				} else if (groupname != "-1") {
					document.getElementById(\'codesnippet_custom\').style.display = \'none\';
					document.getElementById(\'codesnippet_standard\').style.display = \'none\';
					document.getElementById(\'tagSelection\').style.display = \'block\';
					elem = document.getElementById("tagSelection");

					for(var i=(elem.options.length-1); i>=0;i--) {
						elem.options[i] = null;
					}

					for (var i=0; i<tagGroups[groupname].length; i++) {
						elem.options[i] = new Option(tagGroups[groupname][i],tagGroups[groupname][i]);
					}
				}
			}

			' . $groupJs . '
			function openTagWizWithReturn (Ereignis) {
				if (!Ereignis)
				Ereignis = window.event;
				if (Ereignis.which) {
				Tastencode = Ereignis.which;
				} else if (Ereignis.keyCode) {
				Tastencode = Ereignis.keyCode;
				}
				if (Tastencode==13) edit_wetag(document.getElementById("tagSelection").value);
				return false;
			}
		</script>
		<table id="wizardTable" style="width: 700px;" class="defaultfont" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">' . $groupselect . '</td>
		</tr>
		<tr>
			<td>'.getPixel(5,5).'</td>
		</tr>
		<tr>
			<td id="tagSelectCol" style="width: 250px;">' . $tagselect . $CodeWizard->getSelect() . $CodeWizard->getSelect('custom') . '</td>
			<td id="spacerCol" style="width: 50px;" align="center">' . $editTagbut . '</td>
			<td id="tagAreaCol" style="width: 100%;" align="right">' . we_htmlElement::htmlTextArea(array('name'=> 'we_'.$we_doc->Name.'_TagWizardCode', 'id' => 'tag_edit_area', 'style'=>'width:400px; height:100px;' . (($_SESSION["prefs"]["editorFont"] == 1) ? " font-family: " . $_SESSION["prefs"]["editorFontname"] . "; font-size: " . $_SESSION["prefs"]["editorFontsize"] . "px;" : "") , 'class'=>'defaultfont'), $we_doc->TagWizardCode ) . '</td>
		</tr>
		<tr>
			<td>'.getPixel(5,5).'</td>
		</tr>
	</table>
	<table id="wizardTableButtons" class="defaultfont" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td id="tagSelectColButtons" style="width: 250px;"></td>
			<td id="spacerColButtons" style="width: 50px;"></td>
			<td id="tagAreaColButtons" style="width: 100%;" align="right">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td style="padding-right:10px;">' . $selectallbut . '</td>
					<td style="padding-right:10px;">' . $prependbut . '</td>
					<td style="padding-right:10px;">' . $appendbut . '</td>
					<td>' . $addCursorPositionbut . '</td>
				</table>
			</td>
		</tr>
	</table>';

	array_push($parts,array("headline"=>"","html"=>$tagWizardHtml,"space"=>0));
	$wepos = weGetCookieVariable("but_weTMPLDocEdit");
$znr=1;
		?>
	<?php }  ?>
<?php
print we_multiIconBox::getJS();
print '<div id="bodydiv" style="display:none;">'.we_multiIconBox::getHTML("weTMPLDocEdit","100%",$parts,20,"",$znr,$GLOBALS["l_we_class"]["showTagwizard"],$GLOBALS["l_we_class"]["hideTagwizard"],($wepos=="down"),"",'toggleTagWizard();').'</div>';
?></body>

<?php
if (isset($selectedGroup)) {
	echo "<script type='text/javascript'>
	selectTagGroup('$selectedGroup');
	</script>";
}
 ?>
</html>
<?php }  ?>
