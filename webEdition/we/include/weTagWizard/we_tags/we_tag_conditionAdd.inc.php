<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id80_field'] = new weTagData_textAttribute('80', 'field', true, '');
$GLOBALS['weTagWizard']['attribute']['id81_value'] = new weTagData_textAttribute('81', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id82_compare'] = new weTagData_choiceAttribute('82', 'compare', array(new weTagDataOption('=', false, ''), new weTagDataOption('!=', false, ''), new weTagDataOption('&lt;', false, ''), new weTagDataOption('&gt;', false, ''), new weTagDataOption('&lt;=', false, ''), new weTagDataOption('&gt;=', false, ''), new weTagDataOption('like', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id83_var'] = new weTagData_textAttribute('83', 'var', false, '');
$GLOBALS['weTagWizard']['attribute']['id84_type'] = new weTagData_selectAttribute('84', 'type', array(new weTagDataOption('global', false, ''), new weTagDataOption('request', false, ''), new weTagDataOption('sessionfield', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('now', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id85_property'] = new weTagData_selectAttribute('85', 'property', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id86_doc'] = new weTagData_selectAttribute('86', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
?>