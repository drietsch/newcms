<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id193_useparent'] = new weTagData_selectAttribute('193', 'useparent', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>