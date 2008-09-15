<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id554_name'] = new weTagData_textAttribute('554', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id555_type'] = new weTagData_typeAttribute('555', 'type', array(new weTagDataOption('textinput', false, '', array('id555_type','id554_name','id556_property','id558_editable','id561_size','id562_maxlength','id564_value','id575_class','id576_style'), array('id554_name')), new weTagDataOption('textarea', false, '', array('id555_type','id554_name','id556_property','id558_editable','id564_value','id568_cols','id569_rows','id571_autobr','id572_width','id573_height','id574_bgcolor','id575_class','id576_style','id577_hideautobr','id578_wysiwyg','id579_commands','id580_fontnames','id735_classes'), array('id554_name')), new weTagDataOption('checkbox', false, '', array('id555_type','id554_name','id556_property','id557_checked','id558_editable'), array('id554_name')), new weTagDataOption('radio', false, '', array('id555_type','id554_name','id556_property','id557_checked','id558_editable','id564_value'), array('id554_name')), new weTagDataOption('choice', false, '', array('id555_type','id554_name','id556_property','id558_editable','id561_size','id562_maxlength','id564_value','id565_values','id575_class','id576_style'), array('id554_name')), new weTagDataOption('select', false, '', array('id555_type','id554_name','id556_property','id558_editable','id561_size','id564_value','id565_values','id575_class','id576_style'), array('id554_name')), new weTagDataOption('hidden', false, '', array('id555_type','id554_name','id556_property'), array('id554_name')), new weTagDataOption('date', false, '', array('id555_type','id554_name','id556_property','id558_editable','id563_format','id564_value','id566_hidden'), array('id554_name')), new weTagDataOption('password', false, '', array('id555_type'), array()), new weTagDataOption('img', false, 'customer', array('id555_type','id554_name','id558_editable','id561_size','id564_value','id572_width','id573_height','id734_cachelifetime','id768_parentid','id769_quality','id770_keepratio','id771_maximize','id773_bordercolor','id774_checkboxstyle','id775_checkboxclass','id776_inputstyle','id777_inputclass','id778_checkboxtext'), array('id554_name','id768_parentid'))), true, '');
$GLOBALS['weTagWizard']['attribute']['id556_property'] = new weTagData_selectAttribute('556', 'property', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id557_checked'] = new weTagData_selectAttribute('557', 'checked', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id558_editable'] = new weTagData_selectAttribute('558', 'editable', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id560_removefirstparagraph'] = new weTagData_selectAttribute('560', 'removefirstparagraph', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id561_size'] = new weTagData_textAttribute('561', 'size', false, '');
$GLOBALS['weTagWizard']['attribute']['id562_maxlength'] = new weTagData_textAttribute('562', 'maxlength', false, '');
$GLOBALS['weTagWizard']['attribute']['id563_format'] = new weTagData_textAttribute('563', 'format', false, '');
$GLOBALS['weTagWizard']['attribute']['id564_value'] = new weTagData_textAttribute('564', 'value', false, '');
$GLOBALS['weTagWizard']['attribute']['id565_values'] = new weTagData_textAttribute('565', 'values', false, '');
$GLOBALS['weTagWizard']['attribute']['id566_hidden'] = new weTagData_selectAttribute('566', 'hidden', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id567_currentdate'] = new weTagData_selectAttribute('567', 'currentdate', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id568_cols'] = new weTagData_textAttribute('568', 'cols', false, '');
$GLOBALS['weTagWizard']['attribute']['id569_rows'] = new weTagData_textAttribute('569', 'rows', false, '');
$GLOBALS['weTagWizard']['attribute']['id570_pure'] = new weTagData_selectAttribute('570', 'pure', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id571_autobr'] = new weTagData_selectAttribute('571', 'autobr', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id572_width'] = new weTagData_textAttribute('572', 'width', false, '');
$GLOBALS['weTagWizard']['attribute']['id573_height'] = new weTagData_textAttribute('573', 'height', false, '');
$GLOBALS['weTagWizard']['attribute']['id574_bgcolor'] = new weTagData_textAttribute('574', 'bgcolor', false, '');
$GLOBALS['weTagWizard']['attribute']['id575_class'] = new weTagData_textAttribute('575', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id576_style'] = new weTagData_textAttribute('576', 'style', false, '');
$GLOBALS['weTagWizard']['attribute']['id735_classes'] = new weTagData_textAttribute('735', 'classes', false, '');
$GLOBALS['weTagWizard']['attribute']['id577_hideautobr'] = new weTagData_selectAttribute('577', 'hideautobr', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id578_wysiwyg'] = new weTagData_selectAttribute('578', 'wysiwyg', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id579_commands'] = new weTagData_textAttribute('579', 'commands', false, '');
$GLOBALS['weTagWizard']['attribute']['id580_fontnames'] = new weTagData_textAttribute('580', 'fontnames', false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id768_parentid'] = new weTagData_selectorAttribute('768', 'parentid',FILE_TABLE, 'folder', true, 'customer'); }
$GLOBALS['weTagWizard']['attribute']['id769_quality'] = new weTagData_selectAttribute('769', 'quality', array(new weTagDataOption('0', false, ''), new weTagDataOption('1', false, ''), new weTagDataOption('2', false, ''), new weTagDataOption('3', false, ''), new weTagDataOption('4', false, ''), new weTagDataOption('5', false, ''), new weTagDataOption('6', false, ''), new weTagDataOption('7', false, ''), new weTagDataOption('8', false, ''), new weTagDataOption('9', false, ''), new weTagDataOption('10', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id770_keepratio'] = new weTagData_selectAttribute('770', 'keepratio', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id771_maximize'] = new weTagData_selectAttribute('771', 'maximize', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id773_bordercolor'] = new weTagData_textAttribute('773', 'bordercolor', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id774_checkboxstyle'] = new weTagData_textAttribute('774', 'checkboxstyle', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id775_checkboxclass'] = new weTagData_textAttribute('775', 'checkboxclass', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id776_inputstyle'] = new weTagData_textAttribute('776', 'inputstyle', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id777_inputclass'] = new weTagData_textAttribute('777', 'inputclass', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id778_checkboxtext'] = new weTagData_textAttribute('778', 'checkboxtext', false, 'customer');
?>