
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$isUTF8 = substr($GLOBALS['WE_LANGUAGE'], -5) == 'UTF-8';

$translate = we_core_Local::addTranslation('default.xml', '<?php print $TOOLNAME; ?>');

$perm_group_name = "<?php print $TOOLNAME; ?>";
$perm_group_title[$perm_group_name] = $isUTF8 ? $translate->_('<?php print $TOOLNAME; ?>') : utf8_decode($translate->_('<?php print $TOOLNAME; ?>'));

$perm_values[$perm_group_name] = array(
	"NEW_APP_<?php print strtoupper($TOOLNAME); ?>", "DELETE_APP_<?php print strtoupper($TOOLNAME); ?>", "EDIT_APP_<?php print strtoupper($TOOLNAME); ?>"
);

$perm_titles[$perm_group_name] = array();

$translated = array(
	
		$translate->_('The user is allowed to create new items in <?php print $TOOLNAME; ?>'), 
		$translate->_('The user is allowed to delete items from <?php print $TOOLNAME; ?>'), 
		$translate->_('The user is allowed to edit items <?php print $TOOLNAME; ?>')
);

foreach ($translated as $i => $value) {
	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $isUTF8 ? $value : utf8_decode($value);
}

$perm_defaults[$perm_group_name] = array(
	"NEW_APP_<?php print strtoupper($TOOLNAME); ?>" => 1, "DELETE_APP_<?php print strtoupper($TOOLNAME); ?>" => 0, "EDIT_APP_<?php print strtoupper($TOOLNAME); ?>" => 0
);
