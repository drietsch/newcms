<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id488_sum'] = new weTagData_textAttribute('488', 'sum', true, '');
$GLOBALS['weTagWizard']['attribute']['id489_num_format'] = new weTagData_choiceAttribute('489', 'num_format', array(new weTagDataOption('german', false, ''), new weTagDataOption('french', false, ''), new weTagDataOption('english', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id490_type'] = new weTagData_choiceAttribute('490', 'type', array(new weTagDataOption('net', false, ''), new weTagDataOption('gros', false, ''), new weTagDataOption('vat', false, '')), false,false, '');
?>