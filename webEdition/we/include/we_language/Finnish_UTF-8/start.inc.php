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
 * Language file: start.inc.php
 * Provides language strings.
 * Language: English
 */
$l_start["we_homepage"] = 'http://www.ip-finland.com/';

$l_start["phpini_problems"] = 'Virhe session -asetuksissa php.ini-tiedostossa%s!';
$l_start["tmp_path"] = "Muuttuja <b>session.save_path</b> on asetettu arvoon '%s'. Hakemistoa ei ole palvelimella!";
$l_start["use_cookies"] = "Muuttujaa <b>session.use_cookies</b> ei ole asetettu. Varmista että muuttuja on asetettu arvoon 1!";
$l_start["cookie_path"] = "Muuttujan <b>session.cookie_path</b> arvo on '%s'. Tämä arvo on oletuksena '/'!";
$l_start["solution_one"] = "Jos webEdition -järjestelmä on käytössä omalla palvelimella, muuta tätä arvoa. Jos webEdition -järjestelmä pyörii ulkopuolisella palvelimella informoi palvelimen ylläpitoa että arvo on asetettu väärin.";
$l_start["solution_more"] = "Jos webEdition -järjestelmä on käytössä omalla palvelimella, muuta arvoja. Jos webEdition -järjestelmä on käytössä ulkopuolisella palvelimella informoi ylläpitoa että arvo on asetettu väärin.";

$l_start["cannot_start_we"] = "webEdition -järjestelmää ei voida käynnistää.";
$l_start["browser_not_supported"] = "Selainversiosi ei ole tuettu webEdition -järjestelmässä!";
$l_start["browser_supported"] = "webEdition -järjestelmä on tuettu seuraavissa selaimissa:";
$l_start["browser_ie"] = "Internet Explorer"; // TRANSLATE
$l_start["browser_ie_version"] = "alkaen versiosta 5.5";
$l_start["browser_firefox"] = "Firefox"; // TRANSLATE
$l_start["browser_firefox_version"] = "alkaen versiosta 1.0";
$l_start["browser_safari"] = "Safari"; // TRANSLATE
$l_start["browser_safari_version"] = "alkaen versiosta 1.1";
$l_start["ignore_browser"] = "Jos haluat kirjautua webEdition -järjestelmään siitä huolimatta, paina tästä ...";
$l_start["no_db_connection"] = "The database connection can not be established."; //TRANSLATE
?>