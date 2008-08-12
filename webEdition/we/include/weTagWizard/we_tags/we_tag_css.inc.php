<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id93_id'] = new weTagData_selectorAttribute('93', 'id',FILE_TABLE, 'text/css', true, '');
$GLOBALS['weTagWizard']['attribute']['id94_rel'] = new weTagData_selectAttribute('94', 'rel', array(new weTagDataOption('stylesheet', false, ''), new weTagDataOption('alternate stylesheet', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id95_title'] = new weTagData_textAttribute('95', 'title', false, '');
$GLOBALS['weTagWizard']['attribute']['id96_media'] = new weTagData_choiceAttribute('96', 'media', array(new weTagDataOption('all', false, ''), new weTagDataOption('braille', false, ''), new weTagDataOption('embossed', false, ''), new weTagDataOption('handheld', false, ''), new weTagDataOption('print', false, ''), new weTagDataOption('projection', false, ''), new weTagDataOption('screen', false, ''), new weTagDataOption('speech', false, ''), new weTagDataOption('tty', false, ''), new weTagDataOption('tv', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>