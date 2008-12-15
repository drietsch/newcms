<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id212_match'] = new weTagData_textAttribute('212', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id213_type'] = new weTagData_selectAttribute('213', 'type', array(new weTagDataOption('img', false, ''), new weTagDataOption('flashmovie', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('object', false, ''), new weTagDataOption('multiobject', false, ''), new weTagDataOption('calendar', false, '')), false, '');
?>