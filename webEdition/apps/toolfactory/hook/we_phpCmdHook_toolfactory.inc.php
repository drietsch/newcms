<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

switch($_REQUEST["we_cmd"][0]){
	case 'tool_toolfactory_edit':
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/tools_frameset.php');
	break;
}
