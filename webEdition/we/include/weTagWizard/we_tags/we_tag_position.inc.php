<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id409_type'] = new weTagData_choiceAttribute('409', 'type', array(new weTagDataOption('block', false, ''), new weTagDataOption('linklist', false, ''), new weTagDataOption('listdir', false, ''), new weTagDataOption('listview', false, '')), true,false, '');
$GLOBALS['weTagWizard']['attribute']['id410_format'] = new weTagData_choiceAttribute('410', 'format', array(new weTagDataOption('1', false, ''), new weTagDataOption('a', false, ''), new weTagDataOption('A', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id411_reference'] = new weTagData_textAttribute('411', 'reference', false, '');
?>