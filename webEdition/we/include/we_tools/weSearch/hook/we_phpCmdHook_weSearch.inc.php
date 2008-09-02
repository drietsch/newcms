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

include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/meta.conf.php');

switch ($_REQUEST["we_cmd"][0]) {
	case 'tool_weSearch_edit' :
		$toolInclude = 'tools_frameset.php';
		break;
}

if (isset($toolInclude)) {
	include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $toolInclude);
}

?>