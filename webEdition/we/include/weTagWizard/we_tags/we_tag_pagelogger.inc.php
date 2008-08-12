<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id391_type'] = new weTagData_selectAttribute('391', 'type', array(new weTagDataOption('standard', false, ''), new weTagDataOption('robot', false, ''), new weTagDataOption('fileserver', false, ''), new weTagDataOption('downloads', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id392_ssl'] = new weTagData_selectAttribute('392', 'ssl', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id393_websitename'] = new weTagData_textAttribute('393', 'websitename', false, '');
$GLOBALS['weTagWizard']['attribute']['id394_trackname'] = new weTagData_selectAttribute('394', 'trackname', array(new weTagDataOption('WE_PATH', false, ''), new weTagDataOption('WE_TITLE', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id395_category'] = new weTagData_textAttribute('395', 'category', false, '');
$GLOBALS['weTagWizard']['attribute']['id396_order'] = new weTagData_selectAttribute('396', 'order', array(new weTagDataOption('FILENAME', false, ''), new weTagDataOption('FILETITLE', false, ''), new weTagDataOption('FILESIZE', false, ''), new weTagDataOption('DOWNLOADS', false, ''), new weTagDataOption('LASTDOWNLOAD', false, ''), new weTagDataOption('SHORTDESC', false, ''), new weTagDataOption('LONGDESC', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id397_desc'] = new weTagData_selectAttribute('397', 'desc', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id398_rows'] = new weTagData_textAttribute('398', 'rows', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>