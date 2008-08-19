include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/tools.inc.php');

$l_<?php print $TOOLNAME; ?>['save_group_ok'] = $l_tools['save_group_ok'];
$l_<?php print $TOOLNAME; ?>['save_ok'] = $l_tools['save_ok'];
$l_<?php print $TOOLNAME; ?>['save_group_failed'] = $l_tools['save_group_failed'];
$l_<?php print $TOOLNAME; ?>['save_failed'] = $l_tools['save_failed'];

$l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] = '<?php print $TOOLREALNAME; ?>';
$l_<?php print $TOOLNAME; ?>['perm_group_title'] = $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'];


$l_<?php print $TOOLNAME; ?>["permission_titles"]["NEW_APP_<?php print strtoupper($TOOLNAME); ?>"] = "Der Benutzer darf <?php print $TOOLNAME; ?> erstellen";
$l_<?php print $TOOLNAME; ?>["permission_titles"]["DELETE_APP_<?php print strtoupper($TOOLNAME); ?>"] = "Der Benutzer darf <?php print $TOOLNAME; ?> löschen";
$l_<?php print $TOOLNAME; ?>["permission_titles"]["EDIT_APP_<?php print strtoupper($TOOLNAME); ?>"] = "Der Benutzer darf <?php print $TOOLNAME; ?> bearbeiten";


$l_<?php print $TOOLNAME; ?>["import_tool_<?php print $TOOLNAME; ?>_data"] = "Die Daten des Tools " . $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] . " wiederherstellen";
$l_<?php print $TOOLNAME; ?>["export_tool_<?php print $TOOLNAME; ?>_data"] = "Die Daten des Tools " . $l_<?php print $TOOLNAME; ?>['<?php print $TOOLNAME; ?>'] . " sichern";