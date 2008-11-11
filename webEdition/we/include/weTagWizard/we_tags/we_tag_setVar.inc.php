<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id478_to'] = new weTagData_selectAttribute('478', 'to', array(new weTagDataOption('request', false, ''), new weTagDataOption('global', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('top', false, ''), new weTagDataOption('self', false, ''), new weTagDataOption('object', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('sessionfield', false, '')), true, '');
$GLOBALS['weTagWizard']['attribute']['id479_nameto'] = new weTagData_textAttribute('479', 'nameto', true, '');
$GLOBALS['weTagWizard']['attribute']['id480_value'] = new weTagData_textAttribute('480', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id481_from'] = new weTagData_selectAttribute('481', 'from', array(new weTagDataOption('request', false, ''), new weTagDataOption('global', false, ''), new weTagDataOption('session', false, ''), new weTagDataOption('top', false, ''), new weTagDataOption('self', false, ''), new weTagDataOption('object', false, ''), new weTagDataOption('document', false, ''), new weTagDataOption('sessionfield', false, ''), new weTagDataOption('calendar', false, ''), new weTagDataOption('listview', false, ''), new weTagDataOption('block', false, ''), new weTagDataOption('listdir', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id482_namefrom'] = new weTagData_textAttribute('482', 'namefrom', false, '');
$GLOBALS['weTagWizard']['attribute']['id483_typefrom'] = new weTagData_selectAttribute('483', 'typefrom', array(new weTagDataOption('text', false, ''), new weTagDataOption('date', false, ''), new weTagDataOption('img', false, ''), new weTagDataOption('flashmovie', false, ''), new weTagDataOption('href', false, ''), new weTagDataOption('link', false, ''), new weTagDataOption('select', false, ''), new weTagDataOption('binary', false, ''), new weTagDataOption('float', false, ''), new weTagDataOption('int', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id484_propertyto'] = new weTagData_selectAttribute('484', 'propertyto', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id485_propertyfrom'] = new weTagData_selectAttribute('485', 'propertyfrom', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id486_formnameto'] = new weTagData_textAttribute('486', 'formnameto', false, '');
$GLOBALS['weTagWizard']['attribute']['id487_formnamefrom'] = new weTagData_textAttribute('487', 'formnamefrom', false, '');
?>