<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id382_id'] = new weTagData_selectorAttribute('382', 'id',FILE_TABLE, 'text/webedition', true, ''); }
?>