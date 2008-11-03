<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id178_name'] = new weTagData_textAttribute('178', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id179_type'] = new weTagData_choiceAttribute('179', 'type', array(new weTagDataOption('textinput', false, ''), new weTagDataOption('textarea', false, ''), new weTagDataOption('select', false, ''), new weTagDataOption('radio', false, ''), new weTagDataOption('checkbox', false, ''), new weTagDataOption('file', false, '')), false,true, '');
$GLOBALS['weTagWizard']['attribute']['id180_attribs'] = new weTagData_textAttribute('180', 'attribs', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>