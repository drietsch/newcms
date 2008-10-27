<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id249_name'] = new weTagData_textAttribute('249', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id250_type'] = new weTagData_selectAttribute('250', 'type', array(new weTagDataOption('href', false, ''), new weTagDataOption('request', false, ''), new weTagDataOption('global', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('sessionfield', false, ''), new weTagDataOption('sum', false, ''), new weTagDataOption('shopField', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id251_doc'] = new weTagData_selectAttribute('251', 'doc', array(new weTagDataOption('object', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('top', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id252_property'] = new weTagData_selectAttribute('252', 'property', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id253_formname'] = new weTagData_textAttribute('253', 'formname', false, '');
?>