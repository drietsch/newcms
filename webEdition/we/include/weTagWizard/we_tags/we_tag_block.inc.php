<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id51_name'] = new weTagData_textAttribute('51', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id52_showselect'] = new weTagData_selectAttribute('52', 'showselect', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id646_start'] = new weTagData_textAttribute('646', 'start', false, '');
$GLOBALS['weTagWizard']['attribute']['id648_limit'] = new weTagData_textAttribute('648', 'limit', false, '');
?>