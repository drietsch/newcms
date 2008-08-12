<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id145_name'] = new weTagData_textAttribute('145', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id146_width'] = new weTagData_textAttribute('146', 'width', false, '');
$GLOBALS['weTagWizard']['attribute']['id147_height'] = new weTagData_textAttribute('147', 'height', false, '');
$GLOBALS['weTagWizard']['attribute']['id148_alt'] = new weTagData_textAttribute('148', 'alt', false, '');
$GLOBALS['weTagWizard']['attribute']['id633_showcontrol'] = new weTagData_textAttribute('633', 'showcontrol', false, '');
$GLOBALS['weTagWizard']['attribute']['id150_showflash'] = new weTagData_selectAttribute('150', 'showflash', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>