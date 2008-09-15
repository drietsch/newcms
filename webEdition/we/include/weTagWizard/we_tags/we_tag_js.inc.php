<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id332_id'] = new weTagData_selectorAttribute('332', 'id',FILE_TABLE, 'text/js', true, ''); }
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>