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


include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/spellchecker.inc.php');
include_once(WE_SPELLCHECKER_MODULE_DIR . '/spellchecker.conf.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/glossary.inc.php');

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/glossary.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

require_once(WE_GLOSSARY_MODULE_DIR . 'weGlossary.php');
require_once(WE_GLOSSARY_MODULE_DIR . 'weGlossaryCache.php');

protect();

htmlTop($GLOBALS['l_glossary']['glossary_check']);

$we_button = new we_button();

print STYLESHEET;

// Step
if(!isset($_REQUEST['we_cmd'][1]) || $_REQUEST['we_cmd'][1] == "") {
	$_REQUEST['we_cmd'][1] = 'frameset';

}

// Transaction
if(!isset($_REQUEST["we_cmd"][2])) {
	die('No Transaction');

}
$Transaction = $_REQUEST["we_cmd"][2];

//
// ---> Main Frame
//

if($_REQUEST["we_cmd"][1] == 'frameset') {

	$ClassName = $_SESSION['we_data'][$Transaction][0]['ClassName'];

	if($ClassName == "we_objectFile") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$ClassName.".inc.php");

	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$ClassName.".inc.php");

	}

	$we_doc = new $ClassName();
	$we_doc->we_initSessDat($_SESSION['we_data'][$Transaction]);

	$Language = $we_doc->Language;

	$DictBase = 'http://'.$_SERVER['SERVER_NAME'].(isset($_SERVER['SERVER_PORT']) ? ':'.$_SERVER['SERVER_PORT'] : ''). WE_SPELLCHECKER_MODULE_PATH . 'dict/';

	include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/spellchecker/spellchecker.conf.inc.php');

	$LanguageDict = null;
	if(isset($spellcheckerConf['lang']) && is_array($spellcheckerConf['lang'])) {
		$LanguageDict = array_search($Language,$spellcheckerConf['lang']);
		$LanguageDict = in_array($LanguageDict,$spellcheckerConf['active']) ? $LanguageDict : null;
	}
	if(is_null($LanguageDict)) {
		$LanguageDict = $spellcheckerConf['default'];
	}

	$UserDict = WE_SPELLCHECKER_MODULE_DIR . '/dict/' . $_SESSION['user']['Username'] . '@'.$_SERVER['SERVER_NAME']. '.dict';

	$AppletCode = 	'<applet name="spellchecker" code="LeSpellchecker.class" archive="lespellchecker.jar" codebase="http://'.$_SERVER['SERVER_NAME'].(isset($_SERVER['SERVER_PORT'])&&$_SERVER['SERVER_PORT']!=80 ? ':'.$_SERVER['SERVER_PORT'] : ''). WE_SPELLCHECKER_MODULE_PATH . '" width="2" height="2" id="applet" scriptable mayscript style="visibility: hidden">' . "\n"
					.	'<param name="CODE" value="LeSpellchecker.class">' . "\n"
					.	'<param name="ARCHIVE" value="lespellchecker.jar">' . "\n"
					.	'<param name="type" value="application/x-java-applet;version=1.1">' . "\n"
					.	'<param name="dictBase" value="' . $DictBase . '">' . "\n"
					.	'<param name="dictionary" value="' . $LanguageDict . '">' . "\n"
					.	'<param name="debug" value="off">' . "\n"
					.	'<param name="user" value="'.$_SESSION['user']['Username'].'@'.$_SERVER['SERVER_NAME'].'">' . "\n"
					.	'<param name="udSize" value="'.(is_file($UserDict) ? filesize($UserDict) : '0').'">' . "\n"
					.	'</applet>';


	//
	// --> get the content
	//

	$SrcBody = "";
	foreach($we_doc->elements as $key => $name) {
		if(		$key != "data"
			&&	$key != "Title"
			&&	$key != "Description"
			&&	$key != "Keywords"
			&&	$key != "Charset"
			&&	isset($we_doc->elements[$key]['type'])
			&&	(
						$we_doc->elements[$key]['type'] == "txt"
					||	$we_doc->elements[$key]['type'] == "input"
				)
			) {
			$SrcBody .= $we_doc->elements[$key]['dat']." ";

		}

	}

	/*
	This is the fastest variant
	*/
	// split the source into tag and non-tag pieces
	$Pieces = preg_split('!(<[^>]*>)!', $SrcBody, -1, PREG_SPLIT_DELIM_CAPTURE);

	// replace words in non-tag pieces
	$ReplBody = "";
	$Before = " ";
	foreach($Pieces as $Piece) {
		if (!ereg("^<", $Piece) && !eregi("<script", $Before)) {
			$ReplBody .= $Piece . " ";
		}
		$Before = $Piece;
	}

	$Text = preg_replace("=<br(>|([\s/][^>]*)>)\r?\n?=i", "\n", $ReplBody);
	$Text = implode(" ", explode("\r\n", $Text));
	$Text = implode(" ", explode("\n", $Text));
	$Text = str_replace("\"", "\\\"", $ReplBody);
	$Text = preg_replace("=<br(>|([\s/][^>]*)>)\r?\n?=i", "\n", $Text);
	$Text = implode(" ", explode("\r\n", $Text));
	$Text = implode(" ", explode("\n", $Text));
	$Text = str_replace("&nbsp;", " ", $Text);
	$Text = preg_replace("/[\t]+/", " ", $Text);
	$Text = preg_replace("/[ ]+/", " ", $Text);

	$ExceptionListFilename = weGlossary::getExceptionFilename($Language);

	if(!file_exists($ExceptionListFilename)) {
		weGlossary::editException($Language, "");
	}

	$ExceptionList = weGlossary::getException($Language);
	$PublishedEntries = weGlossary::getEntries($Language, 'published');
	foreach ($PublishedEntries as $Key => $Value) {
		$ExceptionList[] = $Value['Text'];
	}
	$UnpublishedEntries = weGlossary::getEntries($Language, 'unpublished');
	$List = array();
	foreach ($UnpublishedEntries as $Key => $Value) {
		if($UnpublishedEntries[$Key]['Type'] != "link") {
			$List[] = $Value;
		}
	}

?>
	<script type="text/javascript" src="<?php print JS_DIR . "keyListener.js"; ?>"></script>
	<script type="text/javascript">
	
	function applyOnEnter() {
		top.frames.glossarycheck.checkForm();
		return true;
		
	}
	
	function closeOnEscape() {
		return true;
		
	}
	
	var orginal;
  	var retryjava = 0;
  	var retry = 0;
  	var to;

  	top.opener.top.toggleBusy();

  	function customAdapter() {
  		this.innerHTML;

  		this.getSelectedText = function() {
  		}

  	}

  	function setDialog() {

<?php
	foreach($List as $Key => $Value) {
		$Replaced = false;
		$Value['Text'] = str_replace("\n", "", str_replace("\r\n", "\n", $Value['Text']));
		$TextReplaced = preg_replace("/((<[^>]*)|([^[:alnum:]]){$Value['Text']}([^[:alnum:]]))/e", '"\2"=="\1"?"\1":"\3\4"', " ".$Text." ");
		if(trim($TextReplaced) != trim($Text)) {
			$Replaced = true;
		}
		$Text = trim($TextReplaced);
		if($Replaced) {
			echo "top.frames.glossarycheck.addPredefinedRow('".$Value['Text']."',new Array(),'".$Value['Type']."','".$Value['Title']."','".$Value['Lang']."');\n";
		}

	}

	foreach($ExceptionList as $Key => $Value) {
		$Value = str_replace("\n", "", str_replace("\r\n", "\n", $Value));
		$Text = preg_replace("/((<[^>]*)|([^[:alnum:]]){$Value}([^[:alnum:]]))/e", '"\2"=="\1"?"\1":"\3\4"', " ".$Text." ");
		$Text = trim($Text);
	}

?>
  		orginal = "<?php echo $Text; ?>";
  		window.setTimeout("spellcheck()",1000);

  	}

	function spellcheck() {
		retry = 0;
		if(document.spellchecker.isReady()) {
			top.frames.glossarycheck.document.getElementById("statusText").innerHTML = "<?php print $GLOBALS['l_glossary']['checking'];?>...";
			var text = getTextOnly(orginal);
			document.spellchecker.check(text);
			window.setTimeout("findNext()",2000);
		} else {
			if(retryjava<5) {
				window.setTimeout("spellcheck()",1000);
				retryjava++;
			} else {
				fadeout("spinner",80,10,10);
				top.frames.glossarycheck.noJava();
			}
		}
	}


	function findNext() {
		if(document.spellchecker.isReady()) {
			if(document.spellchecker.isReady()) {
				if(document.spellchecker.nextSuggestion()) {
					temp = document.spellchecker.getMisspelledWord();
					var suggs = document.spellchecker.getSuggestions();
					suggs = suggs + "";
					var suggA = suggs.split("|");
					top.frames.glossarycheck.addRow(temp, suggA);

					clearTimeout(to);
					to = window.setTimeout("findNext()",250);

				} else if(document.spellchecker.isWorking()) {
					clearTimeout(to);
					to = window.setTimeout("findNext()",250);

				} else if(retry<7) {
					clearTimeout(to);
					to = window.setTimeout("findNext()",250);
					retry++;

				} else {
					if(top.frames.glossarycheck.document.getElementById("spinner").style.display!="none") {
						fadeout("spinner",80,10,10);
						top.frames.glossarycheck.activateButtons();
					}
					retry = 0;
					clearTimeout(to);
				}

			}

		} else {
			window.setTimeout("spellcheck()",250);

		}

	}

	function add() {
		document.spellchecker.addWords(top.frames.glossarycheck.AddWords);
	}

	function getTextOnly(text) {
		var newtext  = text.replace(/(<([^>]+)>)/ig," ");
		newtext  = newtext.replace(/\&([^; ]+);/ig," ");
		newtext  = newtext.replace("&amp;","&");

		return newtext;

	}

	function fade(id,opacity) {
		var styleObj = top.frames.glossarycheck.document.getElementById(id).style;
	    styleObj.opacity = (opacity / 100);
	    styleObj.MozOpacity = (opacity / 100);
	    styleObj.KhtmlOpacity = (opacity / 100);
	    styleObj.filter = "alpha(opacity=" + opacity + ")";
	}

	function fadeout(id,from,step,speed) {
		fade(id,from);
		if(from==0) {
			top.frames.glossarycheck.document.getElementById(id).style.display="none";
		} else {
			window.setTimeout("fadeout(\""+id+"\","+(from-step)+","+step+","+speed+")",speed);
		}
	}

  	</script>
	<style type="text/css">
		#applet {
			top: 0px;
			left: 0px;
			z-index: -10;
		}
	</style>
</head>

<body style="margin:0;padding:0;">
	<form name="we_form" action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">

<?php
	if(sizeof($_REQUEST['we_cmd'])>3) {
		for($i = 3; $i < sizeof($_REQUEST['we_cmd']); $i++) {
?>
	<input type="hidden" name="we_cmd[<?php echo ($i-3); ?>]" value="<?php echo $_REQUEST['we_cmd'][$i]; ?>">
<?php
		}
	}
?>

	<script type="text/javascript">
	function we_save_document() {
		top.opener._showGlossaryCheck = 0;
		top.opener.we_save_document();
		top.close();
	}
	function we_reloadEditPage() {
		top.opener.top.we_cmd('switch_edit_page', <?php echo $we_doc->EditPageNr; ?>, '<?php echo $Transaction; ?>', 'save_document');
	}
	</script>
<?php

	echo '<iframe id="glossarycheck" name="glossarycheck" frameborder="0" src="' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=' . $_REQUEST['we_cmd'][0] . '&we_cmd[1]=prepare&we_cmd[2]=' . $_REQUEST['we_cmd'][2] . (isset($_REQUEST['we_cmd'][3]) ? '&we_cmd[3]=' . $_REQUEST['we_cmd'][3] : '' ) . '" width="730px" height="400px" scroll="no" scrolling="no"></iframe>';
	echo $AppletCode;

//
// ---> Form with all unidentified words
//

} else if($_REQUEST["we_cmd"][1] == 'prepare') {

	$configFile = WE_GLOSSARY_MODULE_DIR . "/we_conf_glossary_settings.inc.php";
	if(!file_exists($configFile) || !is_file($configFile)) {
		include_once(WE_GLOSSARY_MODULE_DIR . "/weGlossarySettingControl.class.php");
		weGlossarySettingControl::saveSettings(true);
	}
	include($configFile);

	$Languages = array(
		'de' => 'de',
		'en' => 'en',
		'es' => 'es',
		'fi' => 'fi',
		'ru' => 'ru',
		'nl' => 'nl',
		'pl' => 'pl',
	);

	$Modes = array();
	if(	(
				isset($_SESSION['prefs']['force_glossary_action'])
			&&	$_SESSION['prefs']['force_glossary_action'] == 0
		) && (
				!isset($_REQUEST['we_cmd'][3])
			||	$_REQUEST['we_cmd'][3] != "checkOnly"
		)
		) {
		$Modes[''] = $GLOBALS['l_glossary']['please_choose'];

	}
	$Modes['ignore'] = $GLOBALS['l_glossary']['ignore'];
	if(we_hasPerm("NEW_GLOSSARY")) {
		$Modes['abbreviation'] = $GLOBALS['l_glossary']['abbreviation'];
		$Modes['acronym'] = $GLOBALS['l_glossary']['acronym'];
		$Modes['foreignword'] = $GLOBALS['l_glossary']['foreignword'];
	}
	if(we_hasPerm("EDIT_GLOSSARY_DICTIONARY")) {
		$Modes['exception'] = $GLOBALS['l_glossary']['to_exceptionlist'];
	}
	$Modes['correct'] = $GLOBALS['l_glossary']['correct_word'];
	$Modes['dictionary'] = $GLOBALS['l_glossary']['to_dictionary'];

?>
	<style type="text/css">

		#spinner {
			width: 330px;
			height: 20px;
			padding: 0px;
			z-index: 1;
			position: absolute;
			left:480px;
			top:15px;
		}

		#statusText {
			width: 300px;
			line-height: 15px;
			vertical-align: middle;
			height: 20px;
			text-align: left;
		}

		#statusImage {
			float: left;
			width: 20px;
			height: 20px;
			padding-right: 5px;
		}
	</style>
	<script type="text/javascript" src="<?php echo JS_DIR; ?>weCombobox.js" ></script>
	<script type="text/javascript">

	var table;
	var counter = 0;
	var Combobox = new weCombobox();


	function init () {
		table = document.getElementById('unknown');
		top.setDialog();
	}


	function getTextColumn(text, colspan) {
		text = text+''; 
		var td = document.createElement('td');
		td.setAttribute('style', 'overflow: hidden;');
		td.setAttribute('title', text);
		if(colspan > 1) {
			td.setAttribute("colspan", colspan);
			td.setAttribute("align", "center");
			td.setAttribute("valign", "middle");
			td.setAttribute("height", "220");
		}
		if(text!="<?php echo $GLOBALS['l_glossary']['all_words_identified']; ?>" && text!="<?php echo $GLOBALS['l_glossary']['no_java']; ?>") {
			text = shortenWord(text,20);
		}

		td.appendChild(document.createTextNode(text));
		return td
	}
	
	function shortenWord(text, chars) {
		var newText = "";
		var textlength = text.length;
		if(textlength>chars) {
			var showPointsFrom = Math.round(chars/2)-1;
			var showPointsTo = Math.round(chars/2)+1;
			for(var i=0;i<chars;i++) {
				if(i<showPointsFrom) {
					newText += text.charAt(i);
				}
				if(i>=showPointsFrom && i<=showPointsTo) {
					newText += ".";
				}
				if(i>showPointsTo) {
					var pos = textlength-(chars-i);
					newText += text.charAt(pos);
				}
			}
		}
		else {
			newText = text;
		}
		
		return newText;
	}

	function getImageColumn(src, width, height) {
		var td = document.createElement('td');
		var html;

		html 	=	'<img src="' + src + '" width="' + width + '" height="' + height + '" />';

		td.innerHTML = html;
		return td
	}


	function getActionColumn(word, type) {
		var td = document.createElement('td');
		var html;

		html	=	'<select class="defaultfont" name="item[' + word + '][type]" size="1" id="type_' + counter + '" onChange="disableItem(' + counter + ', this.value);" style="width: 140px">'
<?php
	foreach ($Modes as $Key => $Value) {
		echo "		+	'<option value=\"" . $Key . "\"' + (type == '" . $Key . "' ? ' selected=\"selected\"' : '') + '>" . $Value . "</option>'\n";
	}
?>
				+	'</select>';

		td.innerHTML = html;
		return td
	}


	function getTitleColumn(word, suggestions, title) {
		var td = document.createElement('td');
		var html;

		html	=	'<input class="wetextinput" type="text" name="item[' + word + '][title]" size="24" value="' + title + '" maxlength="100" id="title_' + counter + '" style="display: inline; width: 200px;" onblur="this.className=\'wetextinput\';" disabled=\"disabled\" onfocus="this.className=\'wetextinputselected\'">'
				+	'<select class="defaultfont" name="suggest_' + counter + '" id="suggest_' + counter + '" size="1" onchange="document.getElementById(\'title_' + counter + '\').value=this.value;this.value=\'\';" disabled=\"disabled\" style="width: 200px; display: none;">'
				+	'<option value="' + word + '">' + word + '</option>'
				+	'<optgroup label="<?php echo $GLOBALS['l_glossary']['change_to']; ?>">'
				+	'<option value="">-- <?php echo $GLOBALS['l_glossary']['input']; ?> --</option>'
				+	'</optgroup>';
		if(suggestions.length > 1) {
			html +=		'<optgroup label="<?php echo $GLOBALS['l_glossary']['suggestions']; ?>">';
			for(i = 0; i < suggestions.length; i++) {
				if(suggestions[i] != '') {
					html +=	'<option value="' + suggestions[i] + '">' + suggestions[i] + '</option>';
				}
			}
			html	+	'</optgroup>';
		}
		html	+	'</select>';

		td.innerHTML = html;

		return td
	}


	function getLanguageColumn(word, lang) {
		var td = document.createElement('td');
		var html;

		html	=	'<select class="defaultfont" name="item[' + word + '][lang]" size="1" id="lang_' + counter + '" disabled=\"disabled\" style="width: 100px">'
				+	'<option value="' + lang + '">' + lang + '</option>'
				+	'<optgroup label="<?php echo $GLOBALS['l_glossary']['change_to']; ?>">'
				+	'<option value="">-- <?php echo $GLOBALS['l_glossary']['input']; ?> --</option>'
				+	'</optgroup>'
				+	'<optgroup label="<?php echo $GLOBALS['l_glossary']['languages']; ?>">'

<?php
	foreach ($Languages as $Key => $Value) {
		echo "		+	'<option value=\"" . $Key . "\">" . $Value . "</option>'";
	}
?>
				+	'</optgroup>'
				+	'</select>';

		td.innerHTML = html;
		return td
	}


	function getColumn(text) {
		var td = document.createElement('td');
		td.appendChild(document.createTextNode(text));
		return td
	}


	function addRow(word, suggestions) {
		var tr = document.createElement('tr');

		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		table.appendChild(tr);

		tr = document.createElement('tr');
		tr.appendChild(getTextColumn(word, 1));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getActionColumn(word, ''));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getTitleColumn(word, suggestions, ''));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getLanguageColumn(word, ''));
		table.appendChild(tr);

		Combobox.init('suggest_' + counter, 'wetextinput');
		Combobox.init('lang_' + counter, 'wetextinput');

		counter++;

	}


	function addPredefinedRow(word, suggestions, type, title, lang) {
		var tr = document.createElement('tr');

		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 1, 5));
		table.appendChild(tr);

		tr = document.createElement('tr');
		tr.appendChild(getTextColumn(word, 1));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getActionColumn(word, type));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getTitleColumn(word, suggestions, title));
		tr.appendChild(getImageColumn("<?php echo IMAGE_DIR; ?>pixel.gif", 20, 1));
		tr.appendChild(getLanguageColumn(word, lang));
		table.appendChild(tr);

		Combobox.init('suggest_' + counter, 'wetextinput');
		Combobox.init('lang_' + counter, 'wetextinput');

		disableItem(counter, type);

		counter++;

	}

	function activateButtons() {
		if(counter == 0) {
			var tr = document.createElement('tr');

			tr.appendChild(getTextColumn('<?php echo $GLOBALS['l_glossary']['all_words_identified']; ?>', 7));
			table.appendChild(tr);
			weButton.hide('execute');
<?php
	if(!isset($_REQUEST['we_cmd'][3]) || $_REQUEST['we_cmd'][3] != "checkOnly") {
?>
			weButton.enable('publish');
			weButton.show('publish');
<?php
	}
?>

		} else {
			weButton.enable('execute');

		}

	}

	function noJava() {
		var tr = document.createElement('tr');

		tr.appendChild(getTextColumn('<?php echo $GLOBALS['l_glossary']['no_java']; ?>', 7));
		table.appendChild(tr);
		weButton.hide('execute');
<?php
	if(!isset($_REQUEST['we_cmd'][3]) || $_REQUEST['we_cmd'][3] != "checkOnly") {
?>
		document.getElementById('execute').innerHTML = '<?php echo str_replace("'", "\'", $we_button->create_button("publish", "javascript:top.we_save_document();", true, 120, 22, "", "", true, false)); ?>';
		weButton.enable('publish');
<?php
	}
?>

	}

	function disableItem(id, value) {
		if(value == 'foreignword') {
			document.getElementById('title_' + id).disabled = true;
			document.getElementById('lang_' + id).disabled = false;
			document.getElementById('title_' + id).style.display = 'inline';
			document.getElementById('suggest_' + id).style.display = 'none';

		} else if(value == 'ignore' || value == 'exception' || value == 'dictionary') {
			document.getElementById('title_' + id).disabled = true;
			document.getElementById('lang_' + id).disabled = true;
			document.getElementById('suggest_' + id).style.display = 'none';
			document.getElementById('title_' + id).style.display = 'inline';

		} else if(value == 'correct') {
			document.getElementById('title_' + id).style.display = 'none';
			document.getElementById('lang_' + id).disabled = true;
			document.getElementById('suggest_' + id).disabled = false;
			document.getElementById('title_' + id).disabled = false;
			document.getElementById('suggest_' + id).style.display = 'inline';

		} else if(value == "") {
			document.getElementById('title_' + id).disabled = true;
			document.getElementById('lang_' + id).disabled = true;
			document.getElementById('suggest_' + id).style.display = 'none';
			document.getElementById('title_' + id).style.display = 'inline';
		} else {
			document.getElementById('title_' + id).disabled = false;
			document.getElementById('lang_' + id).disabled = false;
			document.getElementById('suggest_' + id).style.display = 'none';
			document.getElementById('title_' + id).style.display = 'inline';
		}
	}

	function checkForm() {
		for(i = 0; i < counter; i++) {
			type = document.getElementById('type_' +  i).value;
			title = document.getElementById('title_' +  i).value;
			lang = document.getElementById('lang_' +  i).value;
			switch(type) {
				case 'abbreviation':
				case 'acronym':
					if(title == '') {
						document.getElementById('title_' +  i).focus();
						<?php print we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['please_insert_title'], WE_MESSAGE_ERROR); ?>
						return false;
					}
					if(lang == '') {
						document.getElementById('lang_' +  i).focus();
						<?php print we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['please_insert_language'], WE_MESSAGE_ERROR); ?>
						return false;
					}
					break;
				case 'foreignword':
					if(lang == '') {
						document.getElementById('lang_' +  i).focus();
						<?php print we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['please_insert_language'], WE_MESSAGE_ERROR); ?>
						return false;
					}
					break;
				case 'ignore':
				case 'exception':
				case 'dictionary':
					break;
				case 'correct':
					document.getElementById('title_' +  i).value = document.getElementById('suggest_' +  i).value;
					title = document.getElementById('title_' +  i).value;
					if(title == '') {
						document.getElementById('title_' +  i).focus();
						<?php print we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['please_insert_correct_word'], WE_MESSAGE_ERROR); ?>
						return false;
					}
					break;
				default:
					document.getElementById('type_' +  i).focus();
					<?php print we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['please_choose_action'], WE_MESSAGE_ERROR); ?>
					return false;
					break;
			}
		}
		document.forms[0].submit();
	}

	</script>

</head>

<body class="weDialogBody" onload="init();">

	<div id="spinner">
		<div id="statusImage"><img src="<?php echo IMAGE_DIR; ?>/spinner.gif"/></div>
		<div id="statusText" class="small" style="color: black;"><?php echo $GLOBALS['l_glossary']['download']; ?></div>
	</div>


	<form name="we_form" action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post" target="glossarycheck">
	<input type="hidden" name="ItemsToPublish" id="ItemsToPublish" value="">
	<input type="hidden" name="we_cmd[0]" value="<?php echo $_REQUEST["we_cmd"][0]; ?>">
	<input type="hidden" name="we_cmd[1]" value="finish">
	<input type="hidden" name="we_cmd[2]" value="<?php echo $Transaction; ?>">
<?php
	if(isset($_REQUEST['we_cmd'][3])) {
		echo "	<input type=\"hidden\" name=\"we_cmd[3]\" value=\"" . $_REQUEST["we_cmd"][3] . "\">";
	}


	$Content = '
	<table width="650" border="0" cellpadding="0" cellspacing="0" class="defaultfont">
	<tr>
		<td>'.getPixel(150,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(140,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(200,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(100,1).'</td>
	</tr>
	<tr>
		<td colspan="7">' . $GLOBALS['l_glossary']['not_identified_words'] . '</td>
	</tr>
	<tr>
		<td colspan="7">'.getPixel(2,5).'</td>
	</tr>
	<tr>
		<td><b>' . $GLOBALS['l_glossary']['not_known_word'] . '</b></td>
		<td>'.getPixel(20,1).'</td>
		<td><b>' . $GLOBALS['l_glossary']['action'] . '</b></td>
		<td>'.getPixel(20,1).'</td>
		<td><b>' . $GLOBALS['l_glossary']['announced_word'] . ' / ' . $GLOBALS['l_glossary']['suggestion'] . '</b></td>
		<td>'.getPixel(20,1).'</td>
		<td><b>' . $GLOBALS['l_glossary']['language'] . '</b></td>
		<td>'.getPixel(20,1).'</td>
	</tr>
	<tr>
		<td colspan="7">'.getPixel(2,5).'</td>
	</tr>
	</table>
	<div style="height: 248px; width: 675px; overflow: auto;">
	<table width="650" border="0" cellpadding="0" cellspacing="0" class="defaultfont">
	<tbody id="unknown">
	<tr>
		<td>'.getPixel(150,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(140,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(200,1).'</td>
		<td>'.getPixel(20,1).'</td>
		<td>'.getPixel(100,1).'</td>
	</tr>
	</tbody>
	</table>';


	// Only glossary check
	if(isset($_REQUEST['we_cmd'][3]) && $_REQUEST['we_cmd'][3] == "checkOnly") {
		$CancelButton = $we_button->create_button("close", "javascript:top.close();", true, 120, 22, "", "", false, false);
		$PublishButton = "";
		
	// glossary check and publishing
	} else {
		$CancelButton = $we_button->create_button("cancel", "javascript:top.close();", true, 120, 22, "", "", false, false);
		$PublishButton = $we_button->create_button("publish", "javascript:top.we_save_document();", true, 120, 22, "", "", true, false);
		
	}
	$ExecuteButton = $we_button->create_button("execute", "javascript:checkForm();", true, 120, 22, "", "", true, false);


	$Buttons = $we_button->position_yes_no_cancel($PublishButton . $ExecuteButton, "", $CancelButton);
	if(!isset($_REQUEST['we_cmd'][3]) || $_REQUEST['we_cmd'][3] != "checkOnly") {
		$Buttons .= we_htmlElement::jsElement("weButton.hide('publish');");
		
	}

	$Parts = array();
	$Part = array(
		"headline" => "",
		"html" => $Content,
		"space" => 0
	);
	array_push($Parts, $Part);

	echo we_multiIconBox::getHTML('weMultibox',"100%",$Parts,30,$Buttons,-1,'','',false,$GLOBALS['l_glossary']['glossary_check']);

//
// --> Finish Step
//

} else if($_REQUEST["we_cmd"][1] == 'finish') {


	$ClassName = $_SESSION['we_data'][$Transaction][0]['ClassName'];

	if($ClassName == "we_objectFile") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$ClassName.".inc.php");

	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$ClassName.".inc.php");

	}

	$we_doc = new $ClassName();
	$we_doc->we_initSessDat($_SESSION['we_data'][$Transaction]);

	$Language = $we_doc->Language;

	//
	// --> Insert or correct needed items
	//

	$AddJs = "";
	if(isset($_REQUEST['item']) && sizeof($_REQUEST['item']) > 0) {

		foreach($_REQUEST['item'] as $Key => $Entry) {

			if($Entry['type'] == "exception") {
				weGlossary::addToException($Language, $Key);

			} elseif($Entry['type'] == "ignore") {

			} elseif($Entry['type'] == "correct") {

				foreach($we_doc->elements as $idx => $val) {
					if(		isset($we_doc->elements[$idx]['type'])
						&&	(
									$we_doc->elements[$idx]['type'] == "txt"
								||	$we_doc->elements[$idx]['type'] == "input"
							)
						) {
						$temp = " " . $we_doc->elements[$idx]['dat'] . " ";
						$RegExp = "/((<[^>]*)|([^[:alnum:]]){$Key}([^[:alnum:]]))/e";
						$Replacement = "\3" . $Entry . "\4";
						$temp = preg_replace("/((<[^>]*)|([^[:alnum:]]){$Key}([^[:alnum:]]))/e", '"\2"=="\1"?"\1":"\3'.$Entry['title'].'\4"', $temp);
						$temp = ereg_replace("^ ", "", $temp);
						$temp = ereg_replace(" $", "", $temp);
						$we_doc->elements[$idx]['dat'] = $temp;

					}

				}


			} elseif($Entry['type'] == "dictionary") {
				$AddJs .= "AddWords += '" . addslashes($Key) . ",'\n" ;

			} elseif($Entry['type'] != "") {
				$Glossary = new weGlossary();
				$Glossary->Path = "/" . $Language . "/" . $Entry['type'] . "/" . $Key;
				$Glossary->IsFolder = 0;
				$Glossary->Icon = "";
				$Glossary->Text = $Key;
				$Glossary->Type = $Entry['type'];
				$Glossary->Language = $Language;
				$Glossary->Title = isset($Entry['title']) ? $Entry['title'] : '';
				$Glossary->setAttribute('lang', isset($Entry['lang']) ? $Entry['lang'] : '');
				$Glossary->Published = time();

				if($Glossary->pathExists($Glossary->Path)) {
					$ID = $Glossary->getIDByPath($Glossary->Path);
					$Glossary->ID = $ID;

				}

				$Glossary->save();
				unset($Glossary);

			}

		}

	}

	$we_doc->saveinSession($_SESSION['we_data'][$Transaction]);

	//
	// --> Actualize to Cache
	//

	$Cache = new weGlossaryCache($Language);
	$Cache->write();
	unset($Cache);

	$Js = '
top.we_reloadEditPage();
var AddWords = "";
' . $AddJs . '
top.add();
';

	if(!isset($_REQUEST['we_cmd'][3]) || $_REQUEST['we_cmd'][3] != "checkOnly") {
		$Js .= "top.we_save_document();
		";
	}

	// Only glossary check
	if(isset($_REQUEST['we_cmd'][3]) && $_REQUEST['we_cmd'][3] == "checkOnly") {
		$Message = $GLOBALS['l_glossary']['check_successful'];
		
	// glossary check with publishing
	} else {
		$Message = $GLOBALS['l_glossary']['check_successful_and_publish'];
		
	}
	
	$Js .= we_message_reporting::getShowMessageCall($Message, WE_MESSAGE_NOTICE, false, true);
	$Js .= "top.close();";
	
	$Js = we_htmlElement::jsElement($Js);
	print $Js;
?>

</head>

<body class="weDialogBody">

	<form name="we_form" action="<?php print WEBEDITION_DIR; ?>we_cmd.php" method="post">

<?php

}

?>

		</form>
	</center>
</body>

</html>