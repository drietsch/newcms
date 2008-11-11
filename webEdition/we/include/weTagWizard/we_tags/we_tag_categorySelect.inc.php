<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id62_name'] = new weTagData_textAttribute('62', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id63_type'] = new weTagData_selectAttribute('63', 'type', array(new weTagDataOption('request', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id64_showpath'] = new weTagData_selectAttribute('64', 'showpath', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id65_rootdir'] = new weTagData_textAttribute('65', 'rootdir', false, '');
$GLOBALS['weTagWizard']['attribute']['id66_firstentry'] = new weTagData_textAttribute('66', 'firstentry', false, '');
$GLOBALS['weTagWizard']['attribute']['id641_multiple'] = new weTagData_selectAttribute('641', 'multiple', array(new weTagDataOption('false', false, ''), new weTagDataOption('true', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id708_indent'] = new weTagData_textAttribute('708', 'indent', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>