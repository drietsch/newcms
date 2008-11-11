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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


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