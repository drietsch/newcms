<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id678_name'] = new weTagData_textAttribute('678', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id727_formname'] = new weTagData_textAttribute('727', 'formname', false, '');
?>