<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id334_name'] = new weTagData_textAttribute('334', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id810_only'] = new weTagData_selectAttribute('810', 'only', array(new weTagDataOption('href', false, ''), new weTagDataOption('jsstatus', false, ''), new weTagDataOption('jsscrollbars', false, ''), new weTagDataOption('jsmenubar', false, ''), new weTagDataOption('jstoolbar', false, ''), new weTagDataOption('jsresizable', false, ''), new weTagDataOption('jslocation', false, ''), new weTagDataOption('img_id', false, ''), new weTagDataOption('type', false, ''), new weTagDataOption('ctype', false, ''), new weTagDataOption('border', false, ''), new weTagDataOption('hspace', false, ''), new weTagDataOption('vspace', false, ''), new weTagDataOption('align', false, ''), new weTagDataOption('alt', false, ''), new weTagDataOption('jsheight', false, ''), new weTagDataOption('jswidth', false, ''), new weTagDataOption('jsposx', false, ''), new weTagDataOption('id', false, ''), new weTagDataOption('text', false, ''), new weTagDataOption('title', false, ''), new weTagDataOption('accesskey', false, ''), new weTagDataOption('tabindex', false, ''), new weTagDataOption('lang', false, ''), new weTagDataOption('rel', false, ''), new weTagDataOption('obj_id', false, ''), new weTagDataOption('anchor', false, ''), new weTagDataOption('params', false, ''), new weTagDataOption('target', false, ''), new weTagDataOption('jswin', false, ''), new weTagDataOption('jscenter', false, ''), new weTagDataOption('jsposy', false, ''), new weTagDataOption('img_title', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id335_class'] = new weTagData_textAttribute('335', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id336_style'] = new weTagData_textAttribute('336', 'style', false, '');
$GLOBALS['weTagWizard']['attribute']['id683_text'] = new weTagData_textAttribute('683', 'text', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id712_id'] = new weTagData_selectorAttribute('712', 'id',FILE_TABLE, 'text/webedition', false, ''); }
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id713_imageid'] = new weTagData_selectorAttribute('713', 'imageid',FILE_TABLE, 'image/*', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>