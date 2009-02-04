<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id491_name'] = new weTagData_textAttribute('491', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id492_reference'] = new weTagData_selectAttribute('492', 'reference', array(new weTagDataOption('article', false, ''), new weTagDataOption('cart', false, '')), true, '');
$GLOBALS['weTagWizard']['attribute']['id493_shopname'] = new weTagData_textAttribute('493', 'shopname', true, '');
$GLOBALS['weTagWizard']['attribute']['id494_type'] = new weTagData_selectAttribute('494', 'type', array(new weTagDataOption('checkbox', false, ''), new weTagDataOption('choice', false, ''), new weTagDataOption('hidden', false, ''), new weTagDataOption('print', false, ''), new weTagDataOption('select', false, ''), new weTagDataOption('textarea', false, ''), new weTagDataOption('textinput', false, ''), new weTagDataOption('radio', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id495_value'] = new weTagData_textAttribute('495', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id496_values'] = new weTagData_textAttribute('496', 'values', false, '');
$GLOBALS['weTagWizard']['attribute']['id497_checked'] = new weTagData_choiceAttribute('497', 'checked', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id498_mode'] = new weTagData_choiceAttribute('498', 'mode', array(new weTagDataOption('add', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>