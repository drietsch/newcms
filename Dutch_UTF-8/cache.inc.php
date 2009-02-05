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
 * Language file: enc_we_class.inc.php
 * Provides language strings.
 * Language: English
 */

$l_we_cache["cache"] = "Caching"; // TRANSLATE
$l_we_cache["cache_lifetime"] = "Cache lifetime in seconden";
$l_we_cache["cache_type"] = "Caching type"; // TRANSLATE
$l_we_cache["cache_type_none"] = "Geen caching (Caching gedeactiveerd)";
$l_we_cache["cache_type_wetag"] = "we:Tag cache (we:Tags worde gecached)";
$l_we_cache["cache_type_document"] = "Document cache (ingevoegde documenten hebben eigen cache instellingen)";
$l_we_cache["cache_type_full"] = "Volledige cache (het gehele document wordt gecached)";

$l_we_cache["delete_cache"] = "Gehele cache nu legen?";
$l_we_cache["cache_deleted"] = "De cache is succesvol geleegd!";
$l_we_cache["cache_not_deleted"] = "De cache kon niet geleegd worden.";

$l_we_cache['cacheLifeTimes'] = array();
$l_we_cache['cacheLifeTimes'][0] = "";
$l_we_cache['cacheLifeTimes'][60] = "1 minuut";
$l_we_cache['cacheLifeTimes'][300] = "5 minuten";
$l_we_cache['cacheLifeTimes'][600] = "10 minuten";
$l_we_cache['cacheLifeTimes'][1800] = "30 minuten";
$l_we_cache['cacheLifeTimes'][3600] = "1 uur";
$l_we_cache['cacheLifeTimes'][21600] = "6 uur";
$l_we_cache['cacheLifeTimes'][43200] = "12 uur";
$l_we_cache['cacheLifeTimes'][86400] = "1 dag";

?>