<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id69_match'] = new weTagData_textAttribute('69', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id70_type'] = new weTagData_selectAttribute('70', 'type', array(new weTagDataOption('id', false, ''), new weTagDataOption('name', false, '')), true, '');
$GLOBALS['weTagWizard']['attribute']['id71_mandatory'] = new weTagData_textAttribute('71', 'mandatory', false, '');
$GLOBALS['weTagWizard']['attribute']['id72_email'] = new weTagData_textAttribute('72', 'email', false, '');
$GLOBALS['weTagWizard']['attribute']['id73_password'] = new weTagData_textAttribute('73', 'password', false, '');
$GLOBALS['weTagWizard']['attribute']['id74_onError'] = new weTagData_textAttribute('74', 'onError', false, '');
$GLOBALS['weTagWizard']['attribute']['id75_jsIncludePath'] = new weTagData_textAttribute('75', 'jsIncludePath', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>