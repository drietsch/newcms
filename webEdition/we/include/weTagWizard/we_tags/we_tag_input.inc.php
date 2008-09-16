<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_multiSelectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id319_type'] = new weTagData_typeAttribute('319', 'type', array(new weTagDataOption('text', false, '', array('id319_type','id318_name','id320_size','id321_maxlength','id324_value','id326_html','id328_php','id329_num_format','id330_precision','id637_user','id720_htmlspecialchars','id731_spellcheck','id734_cachelifetime'), array('id318_name')), new weTagDataOption('checkbox', false, '', array('id319_type','id318_name','id324_value','id635_reload','id637_user','id720_htmlspecialchars','id734_cachelifetime'), array('id318_name')), new weTagDataOption('date', false, '', array('id319_type','id318_name','id322_format','id637_user','id720_htmlspecialchars','id734_cachelifetime'), array('id318_name')), new weTagDataOption('choice', false, '', array('id319_type','id318_name','id320_size','id321_maxlength','id323_mode','id325_values','id635_reload','id636_seperator','id637_user','id720_htmlspecialchars','id734_cachelifetime'), array('id318_name')), new weTagDataOption('select', false, '', array('id319_type','id318_name','id325_values','id720_htmlspecialchars','id734_cachelifetime'), array('id318_name'))), true, '');
$GLOBALS['weTagWizard']['attribute']['id318_name'] = new weTagData_textAttribute('318', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id320_size'] = new weTagData_textAttribute('320', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id321_maxlength'] = new weTagData_textAttribute('321', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id322_format'] = new weTagData_textAttribute('322', 'format', false, '');
$GLOBALS['weTagWizard']['attribute']['id323_mode'] = new weTagData_selectAttribute('323', 'mode', array(new weTagDataOption('add', false, ''), new weTagDataOption('replace', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id324_value'] = new weTagData_textAttribute('324', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id325_values'] = new weTagData_textAttribute('325', 'values', false, '');
$GLOBALS['weTagWizard']['attribute']['id326_html'] = new weTagData_selectAttribute('326', 'html', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id720_htmlspecialchars'] = new weTagData_selectAttribute('720', 'htmlspecialchars', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id328_php'] = new weTagData_selectAttribute('328', 'php', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id329_num_format'] = new weTagData_selectAttribute('329', 'num_format', array(new weTagDataOption('german', false, ''), new weTagDataOption('english', false, ''), new weTagDataOption('french', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id330_precision'] = new weTagData_textAttribute('330', 'precision', false, '');
$GLOBALS['weTagWizard']['attribute']['id331_win2iso'] = new weTagData_selectAttribute('331', 'win2iso', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id635_reload'] = new weTagData_selectAttribute('635', 'reload', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id636_seperator'] = new weTagData_textAttribute('636', 'seperator', false, '');
$GLOBALS['weTagWizard']['attribute']['id637_user'] = new weTagData_multiSelectorAttribute('637','user',USER_TABLE, 'user,folder', 'Text', false, 'users');
$GLOBALS['weTagWizard']['attribute']['id731_spellcheck'] = new weTagData_selectAttribute('731', 'spellcheck', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'spellchecker');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>