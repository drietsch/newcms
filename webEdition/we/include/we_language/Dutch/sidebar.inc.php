<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


/**
 * Language file: sidebar.inc.php
 * Provides language strings for the sidebar.
 * Language: Dutch
 */

$l_sidebar["headline"] = "Zijbalk";
$l_sidebar["confirm_to_close_sidebar"] = "Wilt u de zijbalk echt sluiten?"; 

// shown on the default sidebar page
$l_sidebar["default"] = array();

$l_sidebar["default"][0] = array();
$l_sidebar["default"][0]["headline"] = 'Welkom!';
$l_sidebar["default"][0]["text"] = 'webEdition is succesvol geïnstalleerd, maar bevat nog geen content.'; 

$l_sidebar["default"][1] = array();
$l_sidebar["default"][1]["headline"] = 'Handleidingen';
$l_sidebar["default"][1]["text"] = 'hier vind u algemene informatie over de werking en structuur van webEdition';
$l_sidebar["default"][1]["link"] = 'http://www.living-e.com/webEdition/manual/'; 
$l_sidebar["default"][1]["icon"] = 'documentation.gif'; 

$l_sidebar["default"][2] = array();
$l_sidebar["default"][2]["headline"] = 'Andere help bronnen';
$l_sidebar["default"][2]["text"] = 'Overzicht van verdere instructies en referenties'; 
$l_sidebar["default"][2]["link"] = 'javascript:top.we_cmd(\'help\');'; 
$l_sidebar["default"][2]["icon"] = 'help.gif';

$l_sidebar["default"][3] = array();
$l_sidebar["default"][3]["headline"] = 'Hoe nu verder?';
$l_sidebar["default"][3]["text"] = 'U kunt uw website van de grond af opbouwen of gebruik maken van beschikbare elementen en standaard layouts.'; 

$l_sidebar["default"][4] = array();
$l_sidebar["default"][4]["headline"] = 'Eerste-Stappen-Hulp';
$l_sidebar["default"][4]["text"] = 'Gebruik deze hulp om kant en klare standaard layouts te installeren. Met "webEdition Online" kunt u op elk moment sjablonen installeren voor speciale doeleinden.';
$l_sidebar["default"][4]["link"] = 'javascript:top.we_cmd(\'openFirstStepsWizardMasterTemplate\');';
$l_sidebar["default"][4]["icon"] = 'firststepswizard.gif'; 

$l_sidebar["default"][5] = array();
$l_sidebar["default"][5]["headline"] = 'Demo website';
$l_sidebar["default"][5]["text"] = 'Dit zijn complete websites met voorbeeld inhoud. Deze kunt u importeren en wijzigen naar uw smaak.';
$l_sidebar["default"][5]["link"] = 'http://demo.en.webedition.info/';
$l_sidebar["default"][5]["icon"] = 'demopages.gif';

// Only shown on the default sidebar page if user has administrator perms
$l_sidebar["admin"] = array();

$l_sidebar["admin"][0] = array();
$l_sidebar["admin"][0]["headline"] = 'Zijbalk voorkeuren';
$l_sidebar["admin"][0]["text"] = 'U vind de instellingen voor de zijbalk, zoals individuele start documenten, breedte of deactivatie van de zijbalk onder extras> voorkeuren > algemeen ... onder de "Gebruikers interface" tab'; 
$l_sidebar["admin"][0]["link"] = 'javascript:top.we_cmd(\'openPreferences\');'; 

?>