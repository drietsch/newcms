<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id87_type'] = new weTagData_choiceAttribute('87', 'type', array(new weTagDataOption('button', false, ''), new weTagDataOption('checkbox', false, '')), true,false, '');
$GLOBALS['weTagWizard']['attribute']['id88_name'] = new weTagData_choiceAttribute('88', 'name', array(new weTagDataOption('delete', false, ''), new weTagDataOption('makeSameDoc', false, ''), new weTagDataOption('publish', false, ''), new weTagDataOption('save', false, ''), new weTagDataOption('unpublish', false, ''), new weTagDataOption('workflow', false, 'workflow')), true,false, '');
$GLOBALS['weTagWizard']['attribute']['id89_hide'] = new weTagData_choiceAttribute('89', 'hide', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id90_readonly'] = new weTagData_choiceAttribute('90', 'readonly', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id91_checked'] = new weTagData_choiceAttribute('91', 'checked', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
?>