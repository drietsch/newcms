<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id339_name'] = new weTagData_textAttribute('339', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id649_limit'] = new weTagData_textAttribute('649', 'limit', false, '');
?>