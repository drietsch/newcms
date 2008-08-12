<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

function we_loadDefaultMasterTemplateConfig() {

	$file = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/first_steps_wizard/conf/defaultMasterTemplate.inc.php";
	if(!file_exists($file) || !is_file($file)) {
		we_writeDefaultMasterTemplateConfig(0);

	}
	include_once($file);

}

function we_writeDefaultMasterTemplateConfig($default) {

	$code = <<<EOF
<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

// Default Master Template for the First Steps Wizard
define("FSW_DEFAULT_MASTER_TEMPLATE", {$default});

?>
EOF;

	$file = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/first_steps_wizard/conf/defaultMasterTemplate.inc.php";
	$fh = fopen($file, "w+");
	if(!$fh) {
		return false;
		
	}
	fputs($fh, $code);
	return fclose($fh);

}


?>