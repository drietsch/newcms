<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id441_type'] = new weTagData_selectAttribute('441', 'type', array(new weTagDataOption('textinput', false, ''), new weTagDataOption('textarea', false, ''), new weTagDataOption('print', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id442_name'] = new weTagData_textAttribute('442', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id443_value'] = new weTagData_textAttribute('443', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id444_size'] = new weTagData_textAttribute('444', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id445_maxlength'] = new weTagData_textAttribute('445', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id446_cols'] = new weTagData_textAttribute('446', 'cols', false, '');
$GLOBALS['weTagWizard']['attribute']['id447_rows'] = new weTagData_textAttribute('447', 'rows', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>