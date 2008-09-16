<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id546_size'] = new weTagData_textAttribute('546', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id547_maxlength'] = new weTagData_textAttribute('547', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id548_value'] = new weTagData_textAttribute('548', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id549_class'] = new weTagData_textAttribute('549', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id550_style'] = new weTagData_textAttribute('550', 'style', false, '');
$GLOBALS['weTagWizard']['attribute']['id551_onchange'] = new weTagData_textAttribute('551', 'onchange', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>