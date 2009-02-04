<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlColAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id261_permission'] = new weTagData_sqlColAttribute('261', 'permission', CUSTOMER_TABLE, false, array(), '');
$GLOBALS['weTagWizard']['attribute']['id262_match'] = new weTagData_textAttribute('262', 'match', false, '');
$GLOBALS['weTagWizard']['attribute']['id705_userid'] = new weTagData_textAttribute('705', 'userid', false, '');
$GLOBALS['weTagWizard']['attribute']['id744_cfilter'] = new weTagData_selectAttribute('744', 'cfilter', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>