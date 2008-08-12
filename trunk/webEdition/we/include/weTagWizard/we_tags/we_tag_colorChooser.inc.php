<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id76_name'] = new weTagData_textAttribute('76', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id77_width'] = new weTagData_textAttribute('77', 'width', false, '');
$GLOBALS['weTagWizard']['attribute']['id78_height'] = new weTagData_textAttribute('78', 'height', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>