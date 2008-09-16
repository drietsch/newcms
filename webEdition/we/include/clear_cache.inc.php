<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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