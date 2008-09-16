<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id585_name'] = new weTagData_textAttribute('585', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id586_id'] = new weTagData_textAttribute('586', 'id', false, '');
$GLOBALS['weTagWizard']['attribute']['id587_version'] = new weTagData_textAttribute('587', 'version', false, '');
?>