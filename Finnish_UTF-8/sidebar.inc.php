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
 * Language: English
 */

$l_sidebar["headline"] = "Sivupalkki";
$l_sidebar["confirm_to_close_sidebar"] = "Haluatko varmasti sulkea sivupalkin?";

// shown on the default sidebar page
$l_sidebar["default"] = array();

$l_sidebar["default"][0] = array();
$l_sidebar["default"][0]["headline"] = 'Welcome!';
$l_sidebar["default"][0]["text"] = 'webEdition on nyt asennettu mutta toistaiseksi se on vielä ilman sisältöä.';

$l_sidebar["default"][1] = array();
$l_sidebar["default"][1]["headline"] = 'Manuals';
$l_sidebar["default"][1]["text"] = 'täältä löydät tietoa webEditionin toiminnasta ja rakenteesta';
$l_sidebar["default"][1]["link"] = 'http://www.webedition.de/en/Dokumentation/index.php';
$l_sidebar["default"][1]["icon"] = 'documentation.gif'; // TRANSLATE

$l_sidebar["default"][2] = array();
$l_sidebar["default"][2]["headline"] = 'Other help resources';
$l_sidebar["default"][2]["text"] = 'Katsaus muista tiedonlähteistä';
$l_sidebar["default"][2]["link"] = 'javascript:top.we_cmd(\'help\');'; // TRANSLATE
$l_sidebar["default"][2]["icon"] = 'help.gif'; // TRANSLATE

$l_sidebar["default"][3] = array();
$l_sidebar["default"][3]["headline"] = 'How to proceed';
$l_sidebar["default"][3]["text"] = 'Voit luoda yksilöllisen web-sivuston alusta alkaen tai käyttää tarjottuja asetteluelementtejä.';

$l_sidebar["default"][4] = array();
$l_sidebar["default"][4]["headline"] = 'First-Steps-Wizard';
$l_sidebar["default"][4]["text"] = 'Käytä tätä velhoa asentaaksesi käyttövalmiita perussivupohjia. "webEdition Onlinen" avulla voit asentaa sivupohjia erikoistarkoituksiin milloin vain.';
$l_sidebar["default"][4]["link"] = 'javascript:top.we_cmd(\'openFirstStepsWizardMasterTemplate\');'; // TRANSLATE
$l_sidebar["default"][4]["icon"] = 'firststepswizard.gif'; // TRANSLATE

$l_sidebar["default"][5] = array();
$l_sidebar["default"][5]["headline"] = 'Demo web site';
$l_sidebar["default"][5]["text"] = 'Nämä esimerkkisivut sisältävät täydellisen esimerkin perussivuista. Voi täysin vapaasti tuoda täältä osia omiin sivustoihisi ja muokata niitä haluamallasi tavalla.';
$l_sidebar["default"][5]["link"] = 'http://demo.en.webedition.info/'; // TRANSLATE
$l_sidebar["default"][5]["icon"] = 'demopages.gif'; // TRANSLATE

$l_sidebar["default"][6] = array();
$l_sidebar["default"][6]["headline"] = 'Econda';
$l_sidebar["default"][6]["text"] = '<a href="http://webedition.de/en/econda" target="_blank">econda</a> is the leading provider for web controlling solutions and webEdition technology partner.  The econda Shop Monitor makes online-shop analytics accessible, comprehensible and indispensable for optimally informed marketing and business decisions. <a href="http://webedition.de/en/econda-form" target="_blank">Register now</a> for a free 14-day trial! More information regarding the installation can be found in the <a href="http://documentation.webedition.de/200810241003219195" target="_blank">webEdition online documentation</a>.'; // TRANSLATE

// Only shown on the default sidebar page if user has administrator perms
$l_sidebar["admin"] = array();

$l_sidebar["admin"][0] = array();
$l_sidebar["admin"][0]["headline"] = 'Preferences Sidebar';
$l_sidebar["admin"][0]["text"] = 'Löydät sivupalkin asetukset, kuten yksilöllisen aloitussivun ja mitta-asetukset valikosta extrat> asetukset > yleiset ... "Käyttöliittymä" välilehdeltä';
$l_sidebar["admin"][0]["link"] = 'javascript:top.we_cmd(\'openPreferences\');'; // TRANSLATE

?>