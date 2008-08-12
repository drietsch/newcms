<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/glossary/weGlossarySettingFrames.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/glossary/weGlossarySettingControl.class.php');

protect();

$what = isset($_REQUEST["pnt"]) ? $_REQUEST["pnt"] : "frameset";

$weFrame = new weGlossarySettingFrames();

$weFrame->Controller->processVariables();
$weFrame->Controller->processCommands();

$weFrame->getHTML($what);

?>