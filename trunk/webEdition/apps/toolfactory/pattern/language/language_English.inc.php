
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/tools.inc.php');

$l_<?php print $TOOLNAME; ?>['save_group_ok'] = $l_tools['save_group_ok'];
$l_<?php print $TOOLNAME; ?>['save_ok'] = $l_tools['save_ok'];
$l_<?php print $TOOLNAME; ?>['save_group_failed'] = $l_tools['save_group_failed'];
$l_<?php print $TOOLNAME; ?>['save_failed'] = $l_tools['save_failed'];

$l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] = '<?php print $TOOLREALNAME; ?>';
$l_<?php print $TOOLNAME; ?>['perm_group_title'] = $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'];


$l_<?php print $TOOLNAME; ?>["permission_titles"]["NEW_APP_<?php print strtoupper($TOOLNAME); ?>"] = "The user is allowed to create new items in <?php print $TOOLNAME; ?>";
$l_<?php print $TOOLNAME; ?>["permission_titles"]["DELETE_APP_<?php print strtoupper($TOOLNAME); ?>"] = "The user is allowed to delete items from <?php print $TOOLNAME; ?>";
$l_<?php print $TOOLNAME; ?>["permission_titles"]["EDIT_APP_<?php print strtoupper($TOOLNAME); ?>"] = "The user is allowed to edit items <?php print $TOOLNAME; ?>";


$l_<?php print $TOOLNAME; ?>["import_tool_<?php print $TOOLNAME; ?>_data"] = "Restore " . $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] . " data";
$l_<?php print $TOOLNAME; ?>["export_tool_<?php print $TOOLNAME; ?>_data"] = "Save " . $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] . " data";
