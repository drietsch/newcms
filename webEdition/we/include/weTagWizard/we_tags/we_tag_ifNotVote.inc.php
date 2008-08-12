<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id254_type'] = new weTagData_selectAttribute('254', 'type', array(new weTagDataOption('error', false, ''), new weTagDataOption('revote', false, ''), new weTagDataOption('active', false, ''), new weTagDataOption('forbidden', false, '')), false, '');
?>