<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id241_name'] = new weTagData_textAttribute('241', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id242_set'] = new weTagData_selectAttribute('242', 'set', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>