<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id692_name'] = new weTagData_textAttribute('692', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id693_type'] = new weTagData_selectAttribute('693', 'type', array(new weTagDataOption('text', false, ''), new weTagDataOption('date', false, ''), new weTagDataOption('img', false, ''), new weTagDataOption('flashmovie', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('link', false, ''), new weTagDataOption('day', false, ''), new weTagDataOption('dayname', false, ''), new weTagDataOption('month', false, ''), new weTagDataOption('monthname', false, ''), new weTagDataOption('year', false, ''), new weTagDataOption('select', false, ''), new weTagDataOption('binary', false, ''), new weTagDataOption('float', false, ''), new weTagDataOption('int', false, ''), new weTagDataOption('shopVat', false, ''), new weTagDataOption('checkbox', false, '')), true, '');
$GLOBALS['weTagWizard']['attribute']['id694_match'] = new weTagData_textAttribute('694', 'match', true, '');
?>