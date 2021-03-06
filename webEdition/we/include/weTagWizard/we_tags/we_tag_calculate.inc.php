<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id53_sum'] = new weTagData_textAttribute('53', 'sum', false, '');
$GLOBALS['weTagWizard']['attribute']['id54_num_format'] = new weTagData_choiceAttribute('54', 'num_format', array(new weTagDataOption('german', false, ''), new weTagDataOption('french', false, ''), new weTagDataOption('english', false, ''), new weTagDataOption('swiss', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id55_print'] = new weTagData_choiceAttribute('55', 'print', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>