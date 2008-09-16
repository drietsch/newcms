<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id622_name'] = new weTagData_textAttribute('622', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id623_url'] = new weTagData_textAttribute('623', 'url', true, '');
$GLOBALS['weTagWizard']['attribute']['id624_refresh'] = new weTagData_textAttribute('624', 'refresh', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>