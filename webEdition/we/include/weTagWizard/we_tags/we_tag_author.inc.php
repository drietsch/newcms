<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id27_type'] = new weTagData_selectAttribute('27', 'type', array(new weTagDataOption('name', false, ''), new weTagDataOption('initials', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id28_doc'] = new weTagData_selectAttribute('28', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id29_creator'] = new weTagData_selectAttribute('29', 'creator', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>