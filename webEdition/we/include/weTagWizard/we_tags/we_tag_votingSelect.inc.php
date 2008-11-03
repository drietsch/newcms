<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id602_firstentry'] = new weTagData_textAttribute('602', 'firstentry', false, '');
$GLOBALS['weTagWizard']['attribute']['id603_submitonchange'] = new weTagData_selectAttribute('603', 'submitonchange', array(new weTagDataOption('false', false, ''), new weTagDataOption('true', false, '')), false, '');
?>