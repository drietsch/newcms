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

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_multibox.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_button.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/html/we_forms.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/modules/glossary.inc.php');

class weGlossarySettingFrames {

	var $Frameset = '/webEdition/we/include/we_modules/glossary/edit_glossary_settings_frameset.php';
	var $Controller;
	var $db;

	function weGlossarySettingFrames() {
		$this->Controller = new weGlossarySettingControl();
		$this->db = new DB_WE();
	}

	function getHTML($what){
		switch($what){
			case 'frameset': print $this->getHTMLFrameset(); break;
			case 'content': print $this->getHTMLContent(); break;
			default:
				error_log(__FILE__ . " unknown reference: $what");
		}
	}

	function getHTMLFrameset(){
		return htmlTop() . '
   <frameset rows="*,' . (($_SESSION["prefs"]["debug_normal"] != 0) ? 100 : 0) . '" framespacing="0" border="1" frameborder="Yes">
   <frame src="' . $this->Frameset . '?pnt=content" name="content" scrolling=no>
   <frame src="' . HTML_DIR . 'white.html" name="cmdFrame" scrolling=no noresize>
  </frameset>
</head>
 <body background="' .IMAGE_DIR . 'backgrounds/aquaBackground.gif" bgcolor="#bfbfbf" leftmargin=0 topmargin=0 marginheight=0 marginwidth=0>
 </body>
</html>';
	}

	function getHTMLContent() {

		$configFile = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/glossary/we_conf_glossary_settings.inc.php";
		if(!file_exists($configFile) || !is_file($configFile)) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/glossary/weGlossarySettingControl.class.php");
			weGlossarySettingControl::saveSettings(true);
		}
		include($configFile);

		$we_button = new we_button();

		$parts = array();

		// Automatic Replacement
		$content = 		we_forms::checkboxWithHidden($GLOBALS['weGlossaryAutomaticReplacement'], 'GlossaryAutomaticReplacement', $GLOBALS['l_glossary']['enable_replacement']);

		array_push($parts, array(
							'headline' => "",
							'space' => 0,
							'html' => $content,
							'noline' => 1)
		);

		$saveButton = $we_button->create_button('save', 'javascript:document.we_form.submit();');
		$closeButton = $we_button->create_button('close', 'javascript:top.window.close();');

		return htmlTop() .
		STYLESHEET . '

' . we_htmlElement::jsElement('', array('src' => JS_DIR . 'formFunctions.js')) . '

</head>
<body class="weDialogBody">
	<form name="we_form" target="cmdFrame" action="' . $this->Frameset . '">
	' . hidden('cmd', 'save_glossary_setting') . '
	' . we_multiIconBox::getHTML('GlossaryPreferences', "100%", $parts, 30, $we_button->position_yes_no_cancel($saveButton, null, $closeButton), -1, '', '', false, $GLOBALS['l_glossary']['menu_settings'] ) . '
	</form>
</body>
</html>';
	}

}
?>