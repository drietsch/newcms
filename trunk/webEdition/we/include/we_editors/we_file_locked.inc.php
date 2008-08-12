<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

$foo = getHash("SELECT * FROM " . USER_TABLE . " WHERE ID=$we_user_locked",$DB_WE);
?>
<script language="JavaScript" type="text/javascript"><!--
<?php print we_message_reporting::getShowMessageCall(sprintf( $l_alert["file_locked"], $foo["Vorname"], $foo["Nachname"] ), WE_MESSAGE_NOTICE); ?>
//-->
</script>