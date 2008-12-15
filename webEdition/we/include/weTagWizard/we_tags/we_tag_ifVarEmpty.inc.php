<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id280_match'] = new weTagData_textAttribute('280', 'match', true, '');
$GLOBALS['weTagWizard']['attribute']['id281_doc'] = new weTagData_selectAttribute('281', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('object', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id282_type'] = new weTagData_selectAttribute('282', 'type', array(new weTagDataOption('request', false, ''), new weTagDataOption('global', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('sessionfield', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('multiobject', false, 'object')), false, '');
$GLOBALS['weTagWizard']['attribute']['id283_property'] = new weTagData_selectAttribute('283', 'property', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id284_formname'] = new weTagData_textAttribute('284', 'formname', false, '');
?>