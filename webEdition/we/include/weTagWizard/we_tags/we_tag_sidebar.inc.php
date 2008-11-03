<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id737_id'] = new weTagData_selectorAttribute('737', 'id',FILE_TABLE, '', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id738_file'] = new weTagData_textAttribute('738', 'file', false, '');
$GLOBALS['weTagWizard']['attribute']['id740_url'] = new weTagData_textAttribute('740', 'url', false, '');
$GLOBALS['weTagWizard']['attribute']['id739_width'] = new weTagData_choiceAttribute('739', 'width', array(new weTagDataOption('100', false, ''), new weTagDataOption('150', false, ''), new weTagDataOption('200', false, ''), new weTagDataOption('250', false, ''), new weTagDataOption('300', false, ''), new weTagDataOption('350', false, ''), new weTagDataOption('400', false, '')), false,true, '');
?>