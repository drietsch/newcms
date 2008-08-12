<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id100_name'] = new weTagData_textAttribute('100', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id101_class'] = new weTagData_textAttribute('101', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id102_submitonchange'] = new weTagData_selectAttribute('102', 'submitonchange', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id709_start'] = new weTagData_textAttribute('709', 'start', false, '');
$GLOBALS['weTagWizard']['attribute']['id710_end'] = new weTagData_textAttribute('710', 'end', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>