<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id204_match'] = new weTagData_textAttribute('204', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id205_type'] = new weTagData_selectAttribute('205', 'type', array(new weTagDataOption('img', false, ''), new weTagDataOption('flashmovie', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('object', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id206_doc'] = new weTagData_selectAttribute('206', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
?>