<?php
					
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$isUTF8 = substr($GLOBALS['WE_LANGUAGE'], -5) == 'UTF-8';

$translate = we_core_Local::addTranslation('default.xml', 'leer');

$perm_group_name = "leer";
$perm_group_title[$perm_group_name] = $isUTF8 ? $translate->_('leer') : utf8_decode($translate->_('leer'));

$perm_values[$perm_group_name] = array(
	"NEW_APP_LEER", "DELETE_APP_LEER", "EDIT_APP_LEER"
);

$perm_titles[$perm_group_name] = array();

$translated = array(
	
		$translate->_('The user is allowed to create new items in leer'), 
		$translate->_('The user is allowed to delete items from leer'), 
		$translate->_('The user is allowed to edit items leer')
);

foreach ($translated as $i => $value) {
	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $isUTF8 ? $value : utf8_decode($value);
}

$perm_defaults[$perm_group_name] = array(
	"NEW_APP_LEER" => 1, "DELETE_APP_LEER" => 0, "EDIT_APP_LEER" => 0
);

		?>