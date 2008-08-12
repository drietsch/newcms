<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlRowAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_multiSelectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id152_type'] = new weTagData_typeAttribute('152', 'type', array(new weTagDataOption('-', false, '', array('id152_type','id153_id','id154_name','id155_method','id156_target'), array()), new weTagDataOption('document', false, '', array('id152_type','id153_id','id154_name','id155_method','id156_target','id173_doctype','id175_tid'), array('id173_doctype')), new weTagDataOption('formmail', false, '', array('id152_type','id154_name','id155_method','id156_target','id157_recipient','id158_onsuccess','id159_onerror','id160_onmailerror','id161_onrecipienterror','id162_from','id163_subject','id164_charset','id165_order','id166_required','id167_remove','id168_mimetype','id169_confirmmail','id170_forcefrom','id171_preconfirm','id172_postconfirm'), array('id157_recipient')), new weTagDataOption('object', false, 'object', array('id152_type','id153_id','id154_name','id155_method','id156_target','id174_categories','id177_classid','id639_parentid'), array('id177_classid')), new weTagDataOption('search', false, '', array('id152_type','id153_id','id154_name','id155_method','id156_target'), array()), new weTagDataOption('shopliste', false, '', array('id152_type','id153_id','id155_method','id156_target'), array())), false, '');
$GLOBALS['weTagWizard']['attribute']['id798_enctype'] = new weTagData_textAttribute('798', 'enctype', false, '');
$GLOBALS['weTagWizard']['attribute']['id153_id'] = new weTagData_selectorAttribute('153', 'id',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id154_name'] = new weTagData_textAttribute('154', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id155_method'] = new weTagData_selectAttribute('155', 'method', array(new weTagDataOption('get', false, ''), new weTagDataOption('post', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id156_target'] = new weTagData_choiceAttribute('156', 'target', array(new weTagDataOption('_top', false, ''), new weTagDataOption('_parent', false, ''), new weTagDataOption('_self', false, ''), new weTagDataOption('_blank', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id157_recipient'] = new weTagData_textAttribute('157', 'recipient', true, '');
$GLOBALS['weTagWizard']['attribute']['id158_onsuccess'] = new weTagData_selectorAttribute('158', 'onsuccess',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id159_onerror'] = new weTagData_selectorAttribute('159', 'onerror',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id160_onmailerror'] = new weTagData_selectorAttribute('160', 'onmailerror',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id161_onrecipienterror'] = new weTagData_selectorAttribute('161', 'onrecipienterror',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id162_from'] = new weTagData_textAttribute('162', 'from', false, '');
$GLOBALS['weTagWizard']['attribute']['id163_subject'] = new weTagData_textAttribute('163', 'subject', false, '');
$GLOBALS['weTagWizard']['attribute']['id164_charset'] = new weTagData_textAttribute('164', 'charset', false, '');
$GLOBALS['weTagWizard']['attribute']['id165_order'] = new weTagData_textAttribute('165', 'order', false, '');
$GLOBALS['weTagWizard']['attribute']['id166_required'] = new weTagData_textAttribute('166', 'required', false, '');
$GLOBALS['weTagWizard']['attribute']['id167_remove'] = new weTagData_textAttribute('167', 'remove', false, '');
$GLOBALS['weTagWizard']['attribute']['id168_mimetype'] = new weTagData_selectAttribute('168', 'mimetype', array(new weTagDataOption('text/plain', false, ''), new weTagDataOption('text/html', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id169_confirmmail'] = new weTagData_selectAttribute('169', 'confirmmail', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id170_forcefrom'] = new weTagData_selectAttribute('170', 'forcefrom', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id171_preconfirm'] = new weTagData_textAttribute('171', 'preconfirm', false, '');
$GLOBALS['weTagWizard']['attribute']['id172_postconfirm'] = new weTagData_textAttribute('172', 'postconfirm', false, '');
$GLOBALS['weTagWizard']['attribute']['id173_doctype'] = new weTagData_sqlRowAttribute('173', 'doctype',DOC_TYPES_TABLE, true, 'DocType', '', '', '');
$GLOBALS['weTagWizard']['attribute']['id174_categories'] = new weTagData_multiSelectorAttribute('174','categories',CATEGORY_TABLE, '', 'Path', false, '');
$GLOBALS['weTagWizard']['attribute']['id175_tid'] = new weTagData_selectorAttribute('175', 'tid',TEMPLATES_TABLE, 'text/weTmpl', false, '');
$GLOBALS['weTagWizard']['attribute']['id177_classid'] = new weTagData_selectorAttribute('177', 'classid',OBJECT_TABLE, 'object', false, 'object');
$GLOBALS['weTagWizard']['attribute']['id639_parentid'] = new weTagData_selectorAttribute('639', 'parentid',OBJECT_FILES_TABLE, 'folder', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>