<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id430_shopname'] = new weTagData_textAttribute('430', 'shopname', true, '');
$GLOBALS['weTagWizard']['attribute']['id431_pricename'] = new weTagData_textAttribute('431', 'pricename', true, '');
$GLOBALS['weTagWizard']['attribute']['id432_netprices'] = new weTagData_selectAttribute('432', 'netprices', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id433_usevat'] = new weTagData_selectAttribute('433', 'usevat', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id434_onsuccess'] = new weTagData_selectorAttribute('434', 'onsuccess',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id435_onfailure'] = new weTagData_selectorAttribute('435', 'onfailure',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id436_onabortion'] = new weTagData_selectorAttribute('436', 'onabortion',FILE_TABLE, 'text/webedition', false, '');
?>