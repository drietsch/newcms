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
 * Language: Deutsch
 */

$l_sidebar["headline"] = "Sidebar";
$l_sidebar["confirm_to_close_sidebar"] = "Möchten Sie die Sidebar wirklich schließen?";

// shown on the default sidebar page
$l_sidebar["default"] = array();

$l_sidebar["default"][0] = array();
$l_sidebar["default"][0]["headline"] = 'Herzlich Willkommen!';
$l_sidebar["default"][0]["text"] = 'webEdition ist nun erfolgreich installiert, enthält jedoch noch keine Inhalte.';

$l_sidebar["default"][1] = array();
$l_sidebar["default"][1]["headline"] = 'Handbücher';
$l_sidebar["default"][1]["text"] = 'Hier finden Sie grundlegende Informationen zu Bedienung und Aufbau von webEdition.';
$l_sidebar["default"][1]["link"] = 'http://www.living-e.com/webEdition/manual/';
$l_sidebar["default"][1]["icon"] = 'documentation.gif';

$l_sidebar["default"][2] = array();
$l_sidebar["default"][2]["headline"] = 'Weitere Hilfe-Ressourcen';
$l_sidebar["default"][2]["text"] = 'Übersicht weiterer Anleitungen und Referenzen.';
$l_sidebar["default"][2]["link"] = 'javascript:top.we_cmd(\'help\');';
$l_sidebar["default"][2]["icon"] = 'help.gif';

$l_sidebar["default"][3] = array();
$l_sidebar["default"][3]["headline"] = 'So geht\'s weiter';
$l_sidebar["default"][3]["text"] = 'Ihre individuelle Website können Sie von Grund auf neu erstellen oder auf vorhandene Elemente und Basislayouts zugreifen.';

$l_sidebar["default"][4] = array();
$l_sidebar["default"][4]["headline"] = 'Tutorial';
$l_sidebar["default"][4]["text"] = 'Das "Beginner-Tutorial" eignet sich besonders, wenn Sie zum ersten Mal eine individuelle Website erstellen.';
$l_sidebar["default"][4]["link"] = 'http://de7.demo.webedition.de/tutorial/de/tutorial_layout/';
$l_sidebar["default"][4]["icon"] = 'tutorial.gif';

$l_sidebar["default"][5] = array();
$l_sidebar["default"][5]["headline"] = 'First-Steps-Wizard';
$l_sidebar["default"][5]["text"] = 'Nutzen Sie diesen um eines unserer fertigen Basislayouts zu installieren. Über "webEdition Online" können Sie jederzeit Vorlagen für spezielle Dokumente nachinstallieren.';
$l_sidebar["default"][5]["link"] = 'javascript:top.we_cmd(\'openFirstStepsWizardMasterTemplate\');';
$l_sidebar["default"][5]["icon"] = 'firststepswizard.gif';

$l_sidebar["default"][6] = array();
$l_sidebar["default"][6]["headline"] = 'Demoseiten';
$l_sidebar["default"][6]["text"] = 'Hierbei handelt es sich um vollständige Websites inkl. Beispielinhalte. Sie können diese importieren und anschließend beliebig verändern.';
$l_sidebar["default"][6]["link"] = 'http://demo.webedition.de/';
$l_sidebar["default"][6]["icon"] = 'demopages.gif';

$l_sidebar["default"][7] = array();
$l_sidebar["default"][7]["headline"] = 'Econda';
$l_sidebar["default"][7]["text"] = '<a href="http://webedition.de/de/econda" target="_blank">econda</a> ist der führende Anbieter  für erfolgreiches Web Controlling und Technologiepartner von webEdition. econda Lösungen sind auf die Bedürfnisse und Ziele von Online-Versandhändlern zugeschnitten und liefern in Echtzeit Entscheidungsgrundlagen für dauerhafte Umsatzsteigerung. Dabei steht das econda Team seinen Kunden mit Web-Analytics-Expertise aus hunderten Projekten beratend zur Seite. Testen Sie econda Monitor <a href="http://webedition.de/de/econda-formular" target="_blank">14 Tage kostenlos</a> und unverbindlich! Weitere informationen zur Installation finden Sie in der <a href="http://documentation.webedition.de/200810150921145860" target="_blank">webEdition Online-Dokumentation</a>.';

// Only shown on the default sidebar page if user has administrator perms
$l_sidebar["admin"] = array();

$l_sidebar["admin"][0] = array();
$l_sidebar["admin"][0]["headline"] = 'Einstellungen Sidebar';
$l_sidebar["admin"][0]["text"] = 'Einstellungen zur Sidebar, wie individuelle Startdokumente, Breite oder Deaktivierung der Sidebar, finden Sie unter Extras > Einstellungen > Allgemein... auf dem Karteireiter "Oberfläche".';
$l_sidebar["admin"][0]["link"] = 'javascript:top.we_cmd(\'openPreferences\');';

?>