<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_typeAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id17_path'] = new weTagData_textAttribute('17', 'path', false, '');
$GLOBALS['weTagWizard']['attribute']['id806_type'] = new weTagData_typeAttribute('806', 'type', array(new weTagDataOption('CVS', false, '', array('id806_type','id17_path','id18_doubleoptin','id19_expiredoubleoptin','id20_mailid','id21_subject','id22_from','id23_id'), array('id17_path')), new weTagDataOption('customer', false, 'customer', array('id806_type','id18_doubleoptin','id19_expiredoubleoptin','id20_mailid','id21_subject','id22_from','id23_id','id807_fieldGroup','id808_mailingList'), array())), false, 'newsletter');
$GLOBALS['weTagWizard']['attribute']['id808_mailingList'] = new weTagData_textAttribute('808', 'mailingList', false, '');
$GLOBALS['weTagWizard']['attribute']['id18_doubleoptin'] = new weTagData_selectAttribute('18', 'doubleoptin', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id19_expiredoubleoptin'] = new weTagData_textAttribute('19', 'expiredoubleoptin', false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id20_mailid'] = new weTagData_selectorAttribute('20', 'mailid',FILE_TABLE, 'text/webedition', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id21_subject'] = new weTagData_textAttribute('21', 'subject', false, '');
$GLOBALS['weTagWizard']['attribute']['id22_from'] = new weTagData_textAttribute('22', 'from', false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id23_id'] = new weTagData_selectorAttribute('23', 'id',FILE_TABLE, 'text/webedition', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id807_fieldGroup'] = new weTagData_textAttribute('807', 'fieldGroup', false, '');
?>