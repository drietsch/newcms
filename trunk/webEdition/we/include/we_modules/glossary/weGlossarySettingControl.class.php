<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

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

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

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