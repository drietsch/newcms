<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id50_type'] = new weTagData_selectAttribute('50', 'type', array(new weTagDataOption('views', false, ''), new weTagDataOption('clicks', false, ''), new weTagDataOption('rate', false, '')), true, '');
?>