<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id505_type'] = new weTagData_typeAttribute('505', 'type', array(new weTagDataOption('email', false, 'newsletter', array('id505_type','id506_size','id507_maxlength','id508_value','id510_class','id511_style','id512_onchange'), array()), new weTagDataOption('htmlCheckbox', false, 'newsletter', array('id505_type','id510_class','id511_style','id513_checked'), array()), new weTagDataOption('htmlSelect', false, 'newsletter', array('id505_type','id508_value','id509_values','id510_class','id511_style'), array()), new weTagDataOption('firstname', false, 'newsletter', array('id505_type','id506_size','id507_maxlength','id508_value','id510_class','id511_style','id512_onchange'), array()), new weTagDataOption('lastname', false, 'newsletter', array('id505_type','id506_size','id507_maxlength','id508_value','id510_class','id511_style','id512_onchange'), array()), new weTagDataOption('salutation', false, 'newsletter', array('id505_type','id506_size','id507_maxlength','id508_value','id509_values','id510_class','id511_style','id512_onchange'), array()), new weTagDataOption('title', false, 'newsletter', array('id505_type','id506_size','id507_maxlength','id508_value','id509_values','id510_class','id511_style','id512_onchange'), array()), new weTagDataOption('listCheckbox', false, 'newsletter', array('id505_type','id510_class','id511_style','id513_checked'), array()), new weTagDataOption('listSelect', false, 'newsletter', array('id505_type','id506_size','id509_values','id510_class','id511_style'), array())), false, '');
$GLOBALS['weTagWizard']['attribute']['id506_size'] = new weTagData_textAttribute('506', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id507_maxlength'] = new weTagData_textAttribute('507', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id508_value'] = new weTagData_textAttribute('508', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id509_values'] = new weTagData_textAttribute('509', 'values', false, '');
$GLOBALS['weTagWizard']['attribute']['id510_class'] = new weTagData_textAttribute('510', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id511_style'] = new weTagData_textAttribute('511', 'style', false, '');
$GLOBALS['weTagWizard']['attribute']['id512_onchange'] = new weTagData_textAttribute('512', 'onchange', false, '');
$GLOBALS['weTagWizard']['attribute']['id513_checked'] = new weTagData_selectAttribute('513', 'checked', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>