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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cache.inc.php");

?>
<script type="text/javascript">
<?php

$cacheDir = weCacheHelper::getCacheDir();
if (weCacheHelper::clearCache($cacheDir)) {
	print we_message_reporting::getShowMessageCall($l_we_cache["cache_deleted"], WE_MESSAGE_NOTICE);

} else {
	print we_message_reporting::getShowMessageCall($l_we_cache["cache_not_deleted"], WE_MESSAGE_ERROR);

}
?>
</script>