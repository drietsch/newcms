<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlColAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id340_value'] = new weTagData_textAttribute('340', 'value', true, '');
$GLOBALS['weTagWizard']['attribute']['id341_doc'] = new weTagData_selectAttribute('341', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id342_id'] = new weTagData_selectorAttribute('342', 'id',FILE_TABLE, 'text/webedition', false, '');
$GLOBALS['weTagWizard']['attribute']['id343_oid'] = new weTagData_selectorAttribute('343', 'oid',OBJECT_FILES_TABLE, 'objectFile', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id345_permission'] = new weTagData_sqlColAttribute('345', 'permission', CUSTOMER_TABLE, false, array(), '');
?>