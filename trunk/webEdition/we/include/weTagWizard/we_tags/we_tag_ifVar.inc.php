<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id276_name'] = new weTagData_textAttribute('276', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id277_match'] = new weTagData_textAttribute('277', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id278_type'] = new weTagData_selectAttribute('278', 'type', array(new weTagDataOption('global', false, ''), new weTagDataOption('request', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('property', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('sessionfield', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id279_doc'] = new weTagData_selectAttribute('279', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
?>