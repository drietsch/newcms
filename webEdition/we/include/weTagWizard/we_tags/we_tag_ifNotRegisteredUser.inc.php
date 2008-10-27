<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlColAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id239_permission'] = new weTagData_sqlColAttribute('239', 'permission', CUSTOMER_TABLE, false, array(), '');
$GLOBALS['weTagWizard']['attribute']['id240_match'] = new weTagData_textAttribute('240', 'match', false, '');
$GLOBALS['weTagWizard']['attribute']['id745_cfilter'] = new weTagData_selectAttribute('745', 'cfilter', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>