<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id14_edit'] = new weTagData_typeAttribute('14', 'edit', array(new weTagDataOption('-', false, '', array('id14_edit','id1_id','id2_target','id3_confirm','id4_button','id5_hrefonly','id6_class','id7_style','id734_cachelifetime'), array('id1_id')), new weTagDataOption('document', false, '', array('id14_edit','id1_id','id2_target','id3_confirm','id4_button','id5_hrefonly','id6_class','id7_style','id15_editself','id16_delete','id734_cachelifetime'), array('id1_id')), new weTagDataOption('object', false, 'object', array('id14_edit','id1_id','id2_target','id3_confirm','id4_button','id5_hrefonly','id6_class','id7_style','id15_editself','id16_delete','id734_cachelifetime'), array('id1_id')), new weTagDataOption('shop', false, 'shop', array('id14_edit','id1_id','id2_target','id3_confirm','id4_button','id5_hrefonly','id6_class','id7_style','id10_amount','id11_delarticle','id12_delshop','id13_shopname','id734_cachelifetime'), array('id1_id'))), false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id1_id'] = new weTagData_selectorAttribute('1', 'id',FILE_TABLE, 'text/webedition', true, ''); }
$GLOBALS['weTagWizard']['attribute']['id2_target'] = new weTagData_choiceAttribute('2', 'target', array(new weTagDataOption('_top', false, ''), new weTagDataOption('_parent', false, ''), new weTagDataOption('_self', false, ''), new weTagDataOption('_blank', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id3_confirm'] = new weTagData_textAttribute('3', 'confirm', false, '');
$GLOBALS['weTagWizard']['attribute']['id4_button'] = new weTagData_selectAttribute('4', 'button', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id5_hrefonly'] = new weTagData_selectAttribute('5', 'hrefonly', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id6_class'] = new weTagData_textAttribute('6', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id7_style'] = new weTagData_textAttribute('7', 'style', false, '');
$GLOBALS['weTagWizard']['attribute']['id10_amount'] = new weTagData_textAttribute('10', 'amount', false, 'shop');
$GLOBALS['weTagWizard']['attribute']['id11_delarticle'] = new weTagData_selectAttribute('11', 'delarticle', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id12_delshop'] = new weTagData_selectAttribute('12', 'delshop', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'shop');
$GLOBALS['weTagWizard']['attribute']['id13_shopname'] = new weTagData_textAttribute('13', 'shopname', false, 'shop');
$GLOBALS['weTagWizard']['attribute']['id15_editself'] = new weTagData_selectAttribute('15', 'editself', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id16_delete'] = new weTagData_selectAttribute('16', 'delete', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id628_xml'] = new weTagData_selectAttribute('628', 'xml', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>