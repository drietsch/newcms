<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id405_shopname'] = new weTagData_textAttribute('405', 'shopname', true, '');
$GLOBALS['weTagWizard']['attribute']['id406_pricename'] = new weTagData_textAttribute('406', 'pricename', true, '');
$GLOBALS['weTagWizard']['attribute']['id407_usevat'] = new weTagData_selectAttribute('407', 'usevat', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id408_netprices'] = new weTagData_selectAttribute('408', 'netprices', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>