<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id417_name'] = new weTagData_textAttribute('417', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id418_endofday'] = new weTagData_selectAttribute('418', 'endofday', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>