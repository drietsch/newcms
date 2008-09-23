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

function we_loadDefaultMasterTemplateConfig()
{
	
	$file = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/first_steps_wizard/conf/defaultMasterTemplate.inc.php";
	if (!file_exists($file) || !is_file($file)) {
		we_writeDefaultMasterTemplateConfig(0);
	
	}
	include_once ($file);

}

function we_writeDefaultMasterTemplateConfig($default)
{
	
	$code = <<<EOF
<?php

// Default Master Template for the First Steps Wizard
define("FSW_DEFAULT_MASTER_TEMPLATE", {$default});

?>
EOF;
	
	$file = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/first_steps_wizard/conf/defaultMasterTemplate.inc.php";
	$fh = fopen($file, "w+");
	if (!$fh) {
		return false;
	
	}
	fputs($fh, $code);
	return fclose($fh);

}

?>