<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id210_match'] = new weTagData_textAttribute('210', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id211_type'] = new weTagData_selectAttribute('211', 'type', array(new weTagDataOption('img', false, ''), new weTagDataOption('flashmovie', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('object', false, ''), new weTagDataOption('multiobject', false, ''), new weTagDataOption('calendar', false, '')), false, '');
?>