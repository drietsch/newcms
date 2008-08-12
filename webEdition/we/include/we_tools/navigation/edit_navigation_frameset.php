<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationFrames.class.php');

protect();

$what = isset($_REQUEST["pnt"]) ? $_REQUEST["pnt"] : "frameset";

$weFrame=new weNavigationFrames();
$weFrame->View->processVariables();
$weFrame->View->processCommands();
$weFrame->getHTML($what);

?>