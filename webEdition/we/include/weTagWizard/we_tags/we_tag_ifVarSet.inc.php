<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id290_name'] = new weTagData_textAttribute('290', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id291_type'] = new weTagData_selectAttribute('291', 'type', array(new weTagDataOption('href', false, ''), new weTagDataOption('request', false, ''), new weTagDataOption('global', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('sessionfield', false, ''), new weTagDataOption('sum', false, ''), new weTagDataOption('shopField', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id292_doc'] = new weTagData_selectAttribute('292', 'doc', array(new weTagDataOption('object', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('top', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id293_property'] = new weTagData_selectAttribute('293', 'property', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id294_formname'] = new weTagData_textAttribute('294', 'formname', false, '');
$GLOBALS['weTagWizard']['attribute']['id295_shopname'] = new weTagData_textAttribute('295', 'shopname', false, 'shop');
?>