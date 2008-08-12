<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id56_delimiter'] = new weTagData_textAttribute('56', 'delimiter', false, '');
$GLOBALS['weTagWizard']['attribute']['id57_doc'] = new weTagData_selectAttribute('57', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id58_showpath'] = new weTagData_selectAttribute('58', 'showpath', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id59_rootdir'] = new weTagData_textAttribute('59', 'rootdir', false, '');
$GLOBALS['weTagWizard']['attribute']['id60_field'] = new weTagData_selectAttribute('60', 'field', array(new weTagDataOption('ID', false, ''), new weTagDataOption('Path', false, ''), new weTagDataOption('Title', false, ''), new weTagDataOption('Description', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id61_id'] = new weTagData_selectorAttribute('61', 'id',CATEGORY_TABLE, '', false, '');
$GLOBALS['weTagWizard']['attribute']['id688_separator'] = new weTagData_textAttribute('688', 'separator', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>