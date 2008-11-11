<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id449_name'] = new weTagData_textAttribute('449', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id450_size'] = new weTagData_textAttribute('450', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id451_reload'] = new weTagData_selectAttribute('451', 'reload', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>