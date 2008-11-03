<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_multiSelectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id687_id'] = new weTagData_multiSelectorAttribute('687','id',FILE_TABLE, 'text/webedition', 'ID', false, '');
$GLOBALS['weTagWizard']['attribute']['id268_doc'] = new weTagData_selectAttribute('268', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, ''), new weTagDataOption('listview', false, '')), false, '');
?>