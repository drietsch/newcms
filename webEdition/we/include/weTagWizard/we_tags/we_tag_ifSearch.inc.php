<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id265_name'] = new weTagData_textAttribute('265', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id266_set'] = new weTagData_selectAttribute('266', 'set', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>