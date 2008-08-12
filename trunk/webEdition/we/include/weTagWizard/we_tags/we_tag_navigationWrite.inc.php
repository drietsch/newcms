<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id702_navigationname'] = new weTagData_textAttribute('702', 'navigationname', false, '');
$GLOBALS['weTagWizard']['attribute']['id722_depth'] = new weTagData_textAttribute('722', 'depth', false, '');
?>