<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id703_type'] = new weTagData_typeAttribute('703', 'type', array(new weTagDataOption('document', false, '', array('id703_type','id314_id','id315_path','id316_gethttp','id317_seeMode','id632_name'), array()), new weTagDataOption('template', false, '', array('id703_type','id315_path','id704_id'), array())), false, '');
$GLOBALS['weTagWizard']['attribute']['id797_included'] = new weTagData_selectAttribute('797', 'included', array(), false, '');
$GLOBALS['weTagWizard']['attribute']['id314_id'] = new weTagData_selectorAttribute('314', 'id',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id315_path'] = new weTagData_textAttribute('315', 'path', false, '');
$GLOBALS['weTagWizard']['attribute']['id316_gethttp'] = new weTagData_selectAttribute('316', 'gethttp', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id317_seeMode'] = new weTagData_selectAttribute('317', 'seeMode', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id632_name'] = new weTagData_textAttribute('632', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id704_id'] = new weTagData_selectorAttribute('704', 'id',TEMPLATES_TABLE, 'text/weTmpl', false, '');
?>