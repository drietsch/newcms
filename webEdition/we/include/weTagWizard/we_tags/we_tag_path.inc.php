<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id399_index'] = new weTagData_textAttribute('399', 'index', false, '');
$GLOBALS['weTagWizard']['attribute']['id400_separator'] = new weTagData_textAttribute('400', 'separator', false, '');
$GLOBALS['weTagWizard']['attribute']['id401_home'] = new weTagData_textAttribute('401', 'home', false, '');
$GLOBALS['weTagWizard']['attribute']['id643_hidehome'] = new weTagData_selectAttribute('643', 'hidehome', array(new weTagDataOption('false', false, ''), new weTagDataOption('true', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id402_field'] = new weTagData_textAttribute('402', 'field', false, '');
$GLOBALS['weTagWizard']['attribute']['id403_dirfield'] = new weTagData_textAttribute('403', 'dirfield', false, '');
$GLOBALS['weTagWizard']['attribute']['id404_doc'] = new weTagData_selectAttribute('404', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>