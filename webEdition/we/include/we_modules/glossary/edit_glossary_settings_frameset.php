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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/glossary/weGlossarySettingFrames.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/glossary/weGlossarySettingControl.class.php');

protect();

$what = isset($_REQUEST["pnt"]) ? $_REQUEST["pnt"] : "frameset";

$weFrame = new weGlossarySettingFrames();

$weFrame->Controller->processVariables();
$weFrame->Controller->processCommands();

$weFrame->getHTML($what);

?>