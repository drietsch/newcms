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

class weGlossarySettingControl {
	
	function weGlossarySettingControl() {
		
	}
	
	function processCommands() {
		
		$js = '';
		$html = '';
		
		if (isset($_REQUEST['cmd'])) {
			
			switch ($_REQUEST['cmd']) {
				
				case "save_glossary_setting":
					if($this->saveSettings()) {
						$html .= "<script type=\"text/javascript\">top.close();" . we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['preferences_saved'], WE_MESSAGE_NOTICE) . "</script>";
					} else {
						$html .= "<script type=\"text/javascript\">" . we_message_reporting::getShowMessageCall($GLOBALS['l_glossary']['preferences_not_saved'], WE_MESSAGE_ERROR) . "</script>";
					}
				break;
			}
			
			print htmlTop();
			print we_htmlElement::jsElement($js);
			print "</head>
			<body>
				$html
			</body>
			</html>";
			exit;
		}
	}
	
	function processVariables() {
		
	}
	
	function saveSettings($default = false) {
		
		if($default) {
			$GlossaryAutomaticReplacement = 'false';
			
		} else {
			
			$GlossaryAutomaticReplacement = 'false';
			if(isset($_REQUEST['GlossaryAutomaticReplacement']) && $_REQUEST['GlossaryAutomaticReplacement'] == 1) {
				$GlossaryAutomaticReplacement = 'true';
			}
			
		}
		
		$code = <<<EOF
<?php

\$GLOBALS['weGlossaryAutomaticReplacement'] = {$GlossaryAutomaticReplacement};

?>
EOF;

		$configFile = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/glossary/we_conf_glossary_settings.inc.php";
		$fh = fopen($configFile, "w+");
		if(!$fh) {
			return false;
		}
		fputs($fh, $code);
		return fclose($fh);
	
	}
	
}

?>