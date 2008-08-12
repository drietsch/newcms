<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/cache.inc.php");

?>
<script type="text/javascript">
<?php

$cacheDir = weCacheHelper::getCacheDir();
if(weCacheHelper::clearCache($cacheDir)) {
	print we_message_reporting::getShowMessageCall($l_we_cache["cache_deleted"], WE_MESSAGE_NOTICE);
	
} else {
	print we_message_reporting::getShowMessageCall($l_we_cache["cache_not_deleted"], WE_MESSAGE_ERROR);
	
}
?>
</script>