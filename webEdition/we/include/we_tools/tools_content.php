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


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_REQUEST['tool'] . '/index.php')) {
	
		header('Location: /webEdition/apps/' . $_REQUEST['tool'] . '/index.php/frameset/index' .
			(isset($REQUEST['modelid']) ? '/modelId/' . $REQUEST['modelid'] : '') . 
			(isset($REQUEST['tab']) ? '/tab/' . $REQUEST['tab'] : ''));
		exit();
}
if($_REQUEST['tool']=='weSearch' || $_REQUEST['tool']=='navigation') {
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $_REQUEST['tool'] . '/edit_' . $_REQUEST['tool'] . '_frameset.php');
}
else {
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_REQUEST['tool'] . '/edit_' . $_REQUEST['tool'] . '_frameset.php');
}
?>