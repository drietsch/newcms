<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id98_type'] = new weTagData_selectAttribute('98', 'type', array(new weTagDataOption('js', false, ''), new weTagDataOption('php', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id99_format'] = new weTagData_textAttribute('99', 'format', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>