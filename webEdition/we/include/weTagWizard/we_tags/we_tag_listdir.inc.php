<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id812_id'] = new weTagData_selectorAttribute('812', 'id',FILE_TABLE, 'folder', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id348_index'] = new weTagData_textAttribute('348', 'index', false, '');
$GLOBALS['weTagWizard']['attribute']['id349_field'] = new weTagData_textAttribute('349', 'field', false, '');
$GLOBALS['weTagWizard']['attribute']['id350_dirfield'] = new weTagData_textAttribute('350', 'dirfield', false, '');
$GLOBALS['weTagWizard']['attribute']['id351_order'] = new weTagData_textAttribute('351', 'order', false, '');
$GLOBALS['weTagWizard']['attribute']['id352_desc'] = new weTagData_selectAttribute('352', 'desc', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>