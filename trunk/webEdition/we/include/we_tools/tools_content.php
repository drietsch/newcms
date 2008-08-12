<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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