<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id200_type'] = new weTagData_selectAttribute('200', 'type', array(new weTagDataOption('document', false, ''), new weTagDataOption('object', false, '')), false, '');
?>