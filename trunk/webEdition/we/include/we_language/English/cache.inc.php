<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: cache.inc.php,v 1.4 2007/05/23 15:39:35 holger.meyer Exp $

/**
 * Language file: enc_we_class.inc.php
 * Provides language strings.
 * Language: English
 */

$l_we_cache["cache"] = "Caching";
$l_we_cache["cache_lifetime"] = "Cache lifetime in seconds";
$l_we_cache["cache_type"] = "Caching type";
$l_we_cache["cache_type_none"] = "no caching (Caching deactivated)";
$l_we_cache["cache_type_wetag"] = "we:Tag cache (we:Tags will be cached)";
$l_we_cache["cache_type_document"] = "Document cache (included documents have their own cache settings)";
$l_we_cache["cache_type_full"] = "Full cache (whole document will be cached)";

$l_we_cache["delete_cache"] = "Should the whole cache now deleted?";
$l_we_cache["cache_deleted"] = "The cache was successfully deleted!";
$l_we_cache["cache_not_deleted"] = "The cache could not be deleted.";

$l_we_cache['cacheLifeTimes'] = array();
$l_we_cache['cacheLifeTimes'][0] = "";
$l_we_cache['cacheLifeTimes'][60] = "1 minute";
$l_we_cache['cacheLifeTimes'][300] = "5 minutes";
$l_we_cache['cacheLifeTimes'][600] = "10 minutes";
$l_we_cache['cacheLifeTimes'][1800] = "30 minutes";
$l_we_cache['cacheLifeTimes'][3600] = "1 hour";
$l_we_cache['cacheLifeTimes'][21600] = "6 hours";
$l_we_cache['cacheLifeTimes'][43200] = "12 hours";
$l_we_cache['cacheLifeTimes'][86400] = "1 day";

?>