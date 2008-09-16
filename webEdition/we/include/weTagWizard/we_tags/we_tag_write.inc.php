<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlRowAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_multiSelectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id604_type'] = new weTagData_typeAttribute('604', 'type', array(new weTagDataOption('document', false, '', array('id604_type','id605_formname','id606_publish','id607_doctype','id608_categories','id610_userid','id611_admin','id612_forceedit','id613_mail','id614_mailfrom','id615_charset','id755_protected'), array()), new weTagDataOption('object', false, '', array('id604_type','id605_formname','id606_publish','id608_categories','id609_classid','id610_userid','id611_admin','id612_forceedit','id613_mail','id614_mailfrom','id615_charset','id616_triggerid','id755_protected'), array())), false, '');
$GLOBALS['weTagWizard']['attribute']['id605_formname'] = new weTagData_textAttribute('605', 'formname', false, '');
$GLOBALS['weTagWizard']['attribute']['id606_publish'] = new weTagData_selectAttribute('606', 'publish', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id607_doctype'] = new weTagData_sqlRowAttribute('607', 'doctype',DOC_TYPES_TABLE, false, 'DocType', '', '', '');
$GLOBALS['weTagWizard']['attribute']['id608_categories'] = new weTagData_multiSelectorAttribute('608','categories',CATEGORY_TABLE, '', 'Path', false, '');
if(defined("OBJECT_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id609_classid'] = new weTagData_selectorAttribute('609', 'classid',OBJECT_TABLE, 'object', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id755_protected'] = new weTagData_selectAttribute('755', 'protected', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id611_admin'] = new weTagData_textAttribute('611', 'admin', false, '');
$GLOBALS['weTagWizard']['attribute']['id612_forceedit'] = new weTagData_selectAttribute('612', 'forceedit', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id613_mail'] = new weTagData_textAttribute('613', 'mail', false, '');
$GLOBALS['weTagWizard']['attribute']['id614_mailfrom'] = new weTagData_textAttribute('614', 'mailfrom', false, '');
$GLOBALS['weTagWizard']['attribute']['id615_charset'] = new weTagData_textAttribute('615', 'charset', false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id616_triggerid'] = new weTagData_selectorAttribute('616', 'triggerid',FILE_TABLE, 'text/webedition', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id617_workspaces'] = new weTagData_textAttribute('617', 'workspaces', false, '');
if(defined("OBJECT_FILES_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id640_parentid'] = new weTagData_selectorAttribute('640', 'parentid',OBJECT_FILES_TABLE, 'folder', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id610_userid'] = new weTagData_textAttribute('610', 'userid', false, '');
?>