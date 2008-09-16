<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id245_name'] = new weTagData_textAttribute('245', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id246_match'] = new weTagData_textAttribute('246', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id247_type'] = new weTagData_selectAttribute('247', 'type', array(new weTagDataOption('global', false, ''), new weTagDataOption('request', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('property', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('sessionfield', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id248_doc'] = new weTagData_selectAttribute('248', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
?>