<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id33_name'] = new weTagData_textAttribute('33', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id34_width'] = new weTagData_textAttribute('34', 'width', false, '');
$GLOBALS['weTagWizard']['attribute']['id35_height'] = new weTagData_textAttribute('35', 'height', false, '');
$GLOBALS['weTagWizard']['attribute']['id36_paths'] = new weTagData_textAttribute('36', 'paths', false, '');
$GLOBALS['weTagWizard']['attribute']['id37_type'] = new weTagData_selectAttribute('37', 'type', array(new weTagDataOption('js', false, ''), new weTagDataOption('iframe', false, ''), new weTagDataOption('cookie', false, ''), new weTagDataOption('pixel', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id38_target'] = new weTagData_choiceAttribute('38', 'target', array(new weTagDataOption('_top', false, ''), new weTagDataOption('_parent', false, ''), new weTagDataOption('_self', false, ''), new weTagDataOption('_blank', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id39_link'] = new weTagData_selectAttribute('39', 'link', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id40_clickscript'] = new weTagData_textAttribute('40', 'clickscript', false, '');
$GLOBALS['weTagWizard']['attribute']['id41_getscript'] = new weTagData_textAttribute('41', 'getscript', false, '');
$GLOBALS['weTagWizard']['attribute']['id42_page'] = new weTagData_textAttribute('42', 'page', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>