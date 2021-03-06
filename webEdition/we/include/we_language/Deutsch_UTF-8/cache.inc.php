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
 * Language: Deutsch
 */

$l_we_cache["cache"] = "Caching";
$l_we_cache["cache_lifetime"] = "Cache Gültigkeit in Sekunden";
$l_we_cache["cache_type"] = "Art des Caches";
$l_we_cache["cache_type_none"] = "kein Cache (Cache deaktiviert)";
$l_we_cache["cache_type_wetag"] = "we:Tag Cache (we:Tags werden gecached)";
$l_we_cache["cache_type_document"] = "Dokument Cache (Inkludierte Dokumente übernehmen Caching selbst)";
$l_we_cache["cache_type_full"] = "Full Cache (komplettes Dokument wird gecached)";

$l_we_cache["delete_cache"] = "Soll der komplette Cacheinhalt jetzt gelöscht werden?";
$l_we_cache["cache_deleted"] = "Der Cache wurde gelöscht!";
$l_we_cache["cache_not_deleted"] = "Der Cache konnte nicht gelöscht werden.";

$l_we_cache['cacheLifeTimes'] = array();
$l_we_cache['cacheLifeTimes'][0] = "";
$l_we_cache['cacheLifeTimes'][60] = "1 Minute";
$l_we_cache['cacheLifeTimes'][300] = "5 Minuten";
$l_we_cache['cacheLifeTimes'][600] = "10 Minuten";
$l_we_cache['cacheLifeTimes'][1800] = "30 Minuten";
$l_we_cache['cacheLifeTimes'][3600] = "1 Stunde";
$l_we_cache['cacheLifeTimes'][21600] = "6 Stunden";
$l_we_cache['cacheLifeTimes'][43200] = "12 Stunden";
$l_we_cache['cacheLifeTimes'][86400] = "1 Tag";

?>