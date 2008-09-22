<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlColAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id459_name'] = new weTagData_sqlColAttribute('459', 'name', CUSTOMER_TABLE, true, array(), '');
$GLOBALS['weTagWizard']['attribute']['id460_type'] = new weTagData_typeAttribute('460', 'type', array(new weTagDataOption('textinput', false, '', array('id460_type','id459_name','id461_size','id462_maxlength','id468_value'), array('id459_name')), new weTagDataOption('textarea', false, '', array('id460_type','id459_name','id463_rows','id464_cols','id468_value'), array('id459_name')), new weTagDataOption('checkbox', false, '', array('id460_type','id459_name','id467_checked'), array('id459_name')), new weTagDataOption('radio', false, '', array('id460_type','id459_name','id467_checked','id468_value'), array('id459_name')), new weTagDataOption('password', false, '', array('id460_type','id459_name','id461_size','id462_maxlength','id468_value'), array('id459_name')), new weTagDataOption('hidden', false, 'customer', array('id460_type','id459_name','id468_value','id473_autofill'), array('id459_name')), new weTagDataOption('print', false, '', array('id460_type','id459_name','id741_dateformat'), array('id459_name')), new weTagDataOption('select', false, '', array('id460_type','id459_name','id461_size','id468_value','id469_values'), array('id459_name')), new weTagDataOption('choice', false, '', array('id460_type','id459_name','id461_size','id462_maxlength','id468_value','id469_values'), array('id459_name')), new weTagDataOption('img', false, 'customer', array('id460_type','id459_name','id468_value','id471_id','id628_xml','id779_parentid','id780_width','id781_height','id782_quality','id783_keepratio','id784_maximize','id785_bordercolor','id786_checkboxstyle','id787_inputstyle','id788_checkboxclass','id789_inputclass','id790_checkboxtext','id813_showcontrol'), array('id459_name','id779_parentid'))), true, '');
$GLOBALS['weTagWizard']['attribute']['id461_size'] = new weTagData_textAttribute('461', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id462_maxlength'] = new weTagData_textAttribute('462', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id463_rows'] = new weTagData_textAttribute('463', 'rows', false, '');
$GLOBALS['weTagWizard']['attribute']['id464_cols'] = new weTagData_textAttribute('464', 'cols', false, '');
$GLOBALS['weTagWizard']['attribute']['id465_onchange'] = new weTagData_textAttribute('465', 'onchange', false, '');
$GLOBALS['weTagWizard']['attribute']['id466_choice'] = new weTagData_choiceAttribute('466', 'choice', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id467_checked'] = new weTagData_choiceAttribute('467', 'checked', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id468_value'] = new weTagData_textAttribute('468', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id469_values'] = new weTagData_textAttribute('469', 'values', false, '');
$GLOBALS['weTagWizard']['attribute']['id741_dateformat'] = new weTagData_textAttribute('741', 'dateformat', false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id471_id'] = new weTagData_textAttribute('471', 'id', false, '');
$GLOBALS['weTagWizard']['attribute']['id472_removefirstparagraph'] = new weTagData_selectAttribute('472', 'removefirstparagraph', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id473_autofill'] = new weTagData_selectAttribute('473', 'autofill', array(new weTagDataOption('true', false, '')), false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id779_parentid'] = new weTagData_selectorAttribute('779', 'parentid',FILE_TABLE, 'folder', false, 'customer'); }
$GLOBALS['weTagWizard']['attribute']['id780_width'] = new weTagData_textAttribute('780', 'width', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id781_height'] = new weTagData_textAttribute('781', 'height', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id782_quality'] = new weTagData_selectAttribute('782', 'quality', array(new weTagDataOption('0', false, ''), new weTagDataOption('1', false, ''), new weTagDataOption('2', false, ''), new weTagDataOption('3', false, ''), new weTagDataOption('4', false, ''), new weTagDataOption('5', false, ''), new weTagDataOption('6', false, ''), new weTagDataOption('7', false, ''), new weTagDataOption('8', false, ''), new weTagDataOption('9', false, ''), new weTagDataOption('10', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id783_keepratio'] = new weTagData_selectAttribute('783', 'keepratio', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id784_maximize'] = new weTagData_selectAttribute('784', 'maximize', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id785_bordercolor'] = new weTagData_textAttribute('785', 'bordercolor', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id786_checkboxstyle'] = new weTagData_textAttribute('786', 'checkboxstyle', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id787_inputstyle'] = new weTagData_textAttribute('787', 'inputstyle', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id788_checkboxclass'] = new weTagData_textAttribute('788', 'checkboxclass', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id789_inputclass'] = new weTagData_textAttribute('789', 'inputclass', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id790_checkboxtext'] = new weTagData_textAttribute('790', 'checkboxtext', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id813_showcontrol'] = new weTagData_selectAttribute('813', 'showcontrol', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
?>