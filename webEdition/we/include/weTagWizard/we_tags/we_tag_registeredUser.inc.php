<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id425_id'] = new weTagData_textAttribute('425', 'id', true, '');
$GLOBALS['weTagWizard']['attribute']['id426_show'] = new weTagData_textAttribute('426', 'show', false, '');
$GLOBALS['weTagWizard']['attribute']['id427_doc'] = new weTagData_selectAttribute('427', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>