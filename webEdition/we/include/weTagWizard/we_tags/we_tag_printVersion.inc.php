<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

if(defined("TEMPLATES_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id412_tid'] = new weTagData_selectorAttribute('412', 'tid',TEMPLATES_TABLE, 'text/weTmpl', true, ''); }
$GLOBALS['weTagWizard']['attribute']['id413_target'] = new weTagData_choiceAttribute('413', 'target', array(new weTagDataOption('_top', false, ''), new weTagDataOption('_parent', false, ''), new weTagDataOption('_self', false, ''), new weTagDataOption('_blank', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id414_link'] = new weTagData_selectAttribute('414', 'link', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id415_doc'] = new weTagData_selectAttribute('415', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, '')), false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id416_triggerid'] = new weTagData_selectorAttribute('416', 'triggerid',FILE_TABLE, 'text/webedition', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>