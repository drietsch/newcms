<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id581_name'] = new weTagData_textAttribute('581', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id582_type'] = new weTagData_typeAttribute('582', 'type', array(new weTagDataOption('document', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('property', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('global', false, '', array('id582_type','id581_name','id720_htmlspecialchars'), array('id581_name')), new weTagDataOption('img', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('href', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('date', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('link', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('multiobject', false, '', array('id582_type'), array()), new weTagDataOption('request', false, '', array('id582_type','id581_name','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('select', false, '', array('id582_type','id581_name','id583_doc','id720_htmlspecialchars','id734_cachelifetime'), array('id581_name')), new weTagDataOption('session', false, '', array('id582_type','id581_name'), array('id581_name')), new weTagDataOption('shopVat', false, '', array('id582_type'), array())), true, '');
$GLOBALS['weTagWizard']['attribute']['id583_doc'] = new weTagData_selectAttribute('583', 'doc', array(new weTagDataOption('self', false, ''), new weTagDataOption('top', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id584_win2iso'] = new weTagData_selectAttribute('584', 'win2iso', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id720_htmlspecialchars'] = new weTagData_selectAttribute('720', 'htmlspecialchars', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>