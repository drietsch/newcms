<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2008 living-e AG                                |
// +----------------------------------------------------------------------+
//

/**
* @author Thomas Kneip
* @copyright living-e AG
*/					
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolFrames.class.php');

protect();

$what = isset($_REQUEST["pnt"]) ? $_REQUEST["pnt"] : "frameset";

$weFrame=new searchtoolFrames();

$weFrame->View->processVariables();
$weFrame->View->processCommands();
$weFrame->getHTML($what);

?>