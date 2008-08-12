<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_multiSelectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id194_categories'] = new weTagData_multiSelectorAttribute('194','categories',CATEGORY_TABLE, '', 'Path', true, '');
$GLOBALS['weTagWizard']['attribute']['id195_doc'] = new weTagData_selectAttribute('195', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, ''), new weTagDataOption('listview', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id196_parent'] = new weTagData_selectAttribute('196', 'parent', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>