<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Language file: sidebar.inc.php
 * Provides language strings for the sidebar.
 * Language: English
 */

$l_sidebar["headline"] = "Sidebar"; // TRANSLATE
$l_sidebar["confirm_to_close_sidebar"] = "Would you really like to close the sidebar?"; // TRANSLATE

// shown on the default sidebar page
$l_sidebar["default"] = array();

$l_sidebar["default"][0] = array();
$l_sidebar["default"][0]["headline"] = 'Welcome!';
$l_sidebar["default"][0]["text"] = 'webEdition is installed successfully, but contains no contents yet.'; // TRANSLATE

$l_sidebar["default"][1] = array();
$l_sidebar["default"][1]["headline"] = 'Manuals';
$l_sidebar["default"][1]["text"] = 'here you find basic information about the operation and structure of webEdition'; // TRANSLATE
$l_sidebar["default"][1]["link"] = 'http://www.living-e.com/webEdition/manual/'; // TRANSLATE
$l_sidebar["default"][1]["icon"] = 'documentation.gif'; // TRANSLATE

$l_sidebar["default"][2] = array();
$l_sidebar["default"][2]["headline"] = 'Other help resources';
$l_sidebar["default"][2]["text"] = 'Overview of farther instructions and references'; // TRANSLATE
$l_sidebar["default"][2]["link"] = 'javascript:top.we_cmd(\'help\');'; // TRANSLATE
$l_sidebar["default"][2]["icon"] = 'help.gif'; // TRANSLATE

$l_sidebar["default"][3] = array();
$l_sidebar["default"][3]["headline"] = 'How to proceed';
$l_sidebar["default"][3]["text"] = 'You can create your individual web site entirely from the scratch or access available elements and base layouts.'; // TRANSLATE

$l_sidebar["default"][4] = array();
$l_sidebar["default"][4]["headline"] = 'First-Steps-Wizard';
$l_sidebar["default"][4]["text"] = 'Use this wizard to install a ready-to-use base layouts. With "webEdition Online" you can install templates for special purposes at any time.'; // TRANSLATE
$l_sidebar["default"][4]["link"] = 'javascript:top.we_cmd(\'openFirstStepsWizardMasterTemplate\');'; // TRANSLATE
$l_sidebar["default"][4]["icon"] = 'firststepswizard.gif'; // TRANSLATE

$l_sidebar["default"][5] = array();
$l_sidebar["default"][5]["headline"] = 'Demo web site';
$l_sidebar["default"][5]["text"] = 'These are entire web sites including example contents. You can import and freely edit these to fit your needs.'; // TRANSLATE
$l_sidebar["default"][5]["link"] = 'http://demo.en.webedition.info/'; // TRANSLATE
$l_sidebar["default"][5]["icon"] = 'demopages.gif'; // TRANSLATE

// Only shown on the default sidebar page if user has administrator perms
$l_sidebar["admin"] = array();

$l_sidebar["admin"][0] = array();
$l_sidebar["admin"][0]["headline"] = 'Preferences Sidebar';
$l_sidebar["admin"][0]["text"] = 'You find the settings for the Sidebar, like individual start documents, width or deactivation of the sidebar under extras> preferences > common ... on the "User interface" tab'; // TRANSLATE
$l_sidebar["admin"][0]["link"] = 'javascript:top.we_cmd(\'openPreferences\');'; // TRANSLATE

?>