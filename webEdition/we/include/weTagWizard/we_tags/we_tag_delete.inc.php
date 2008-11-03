<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlRowAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id103_type'] = new weTagData_typeAttribute('103', 'type', array(new weTagDataOption('document', false, '', array('id103_type','id104_doctype','id106_pid','id107_userid','id108_admin','id109_forceedit','id110_mail','id111_mailfrom','id112_charset','id757_protected'), array()), new weTagDataOption('object', false, '', array('id103_type','id105_classid','id107_userid','id108_admin','id109_forceedit','id110_mail','id111_mailfrom','id112_charset','id652_pid','id757_protected'), array())), false, '');
$GLOBALS['weTagWizard']['attribute']['id104_doctype'] = new weTagData_sqlRowAttribute('104', 'doctype',DOC_TYPES_TABLE, false, 'DocType', 'DocType', 'DocType', '');
if(defined("OBJECT_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id105_classid'] = new weTagData_selectorAttribute('105', 'classid',OBJECT_TABLE, 'object', false, ''); }
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id106_pid'] = new weTagData_selectorAttribute('106', 'pid',FILE_TABLE, 'folder', false, ''); }
if(defined("OBJECT_FILES_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id652_pid'] = new weTagData_selectorAttribute('652', 'pid',OBJECT_FILES_TABLE, 'folder', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id757_protected'] = new weTagData_selectAttribute('757', 'protected', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id108_admin'] = new weTagData_textAttribute('108', 'admin', false, '');
$GLOBALS['weTagWizard']['attribute']['id109_forceedit'] = new weTagData_selectAttribute('109', 'forceedit', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id110_mail'] = new weTagData_textAttribute('110', 'mail', false, '');
$GLOBALS['weTagWizard']['attribute']['id111_mailfrom'] = new weTagData_textAttribute('111', 'mailfrom', false, '');
$GLOBALS['weTagWizard']['attribute']['id112_charset'] = new weTagData_textAttribute('112', 'charset', false, '');
$GLOBALS['weTagWizard']['attribute']['id107_userid'] = new weTagData_textAttribute('107', 'userid', false, '');
?>