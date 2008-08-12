<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id419_name'] = new weTagData_textAttribute('419', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id420_width'] = new weTagData_textAttribute('420', 'width', false, '');
$GLOBALS['weTagWizard']['attribute']['id421_height'] = new weTagData_textAttribute('421', 'height', false, '');
$GLOBALS['weTagWizard']['attribute']['id422_showcontrol'] = new weTagData_selectAttribute('422', 'showcontrol', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id423_showquicktime'] = new weTagData_selectAttribute('423', 'showquicktime', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>