<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id44_name'] = new weTagData_textAttribute('44', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id45_showpath'] = new weTagData_selectAttribute('45', 'showpath', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id46_rootdir'] = new weTagData_textAttribute('46', 'rootdir', false, '');
$GLOBALS['weTagWizard']['attribute']['id47_firstentry'] = new weTagData_textAttribute('47', 'firstentry', false, '');
$GLOBALS['weTagWizard']['attribute']['id48_submitonchange'] = new weTagData_selectAttribute('48', 'submitonchange', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id49_customer'] = new weTagData_selectAttribute('49', 'customer', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>