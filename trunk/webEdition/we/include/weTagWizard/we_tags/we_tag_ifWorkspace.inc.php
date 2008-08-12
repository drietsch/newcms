<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id296_path'] = new weTagData_textAttribute('296', 'path', false, '');
$GLOBALS['weTagWizard']['attribute']['id742_id'] = new weTagData_selectorAttribute('742', 'id',FILE_TABLE, 'folder', false, '');
$GLOBALS['weTagWizard']['attribute']['id297_doc'] = new weTagData_selectAttribute('297', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, '')), false, '');
?>