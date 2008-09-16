<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id67_defined'] = new weTagData_choiceAttribute('67', 'defined', array(new weTagDataOption('ISO-8859-1', false, ''), new weTagDataOption('ISO-8859-2', false, ''), new weTagDataOption('ISO-8859-3', false, ''), new weTagDataOption('ISO-8859-4', false, ''), new weTagDataOption('ISO-8859-5', false, ''), new weTagDataOption('ISO-8859-6', false, ''), new weTagDataOption('ISO-8859-7', false, ''), new weTagDataOption('ISO-8859-8', false, ''), new weTagDataOption('ISO-8859-9', false, ''), new weTagDataOption('ISO-8859-10', false, ''), new weTagDataOption('ISO-8859-11', false, ''), new weTagDataOption('ISO-8859-13', false, ''), new weTagDataOption('ISO-8859-14', false, ''), new weTagDataOption('ISO-8859-15', false, ''), new weTagDataOption('UTF-8', false, ''), new weTagDataOption('Windows-1251', false, ''), new weTagDataOption('Windows-1252', false, '')), false,true, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>