<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id594_name'] = new weTagData_textAttribute('594', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id595_groupid'] = new weTagData_textAttribute('595', 'groupid', false, '');
$GLOBALS['weTagWizard']['attribute']['id596_version'] = new weTagData_textAttribute('596', 'version', false, '');
$GLOBALS['weTagWizard']['attribute']['id597_rows'] = new weTagData_textAttribute('597', 'rows', false, '');
$GLOBALS['weTagWizard']['attribute']['id598_offset'] = new weTagData_textAttribute('598', 'offset', false, '');
$GLOBALS['weTagWizard']['attribute']['id599_desc'] = new weTagData_selectAttribute('599', 'desc', array(new weTagDataOption('true', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id600_order'] = new weTagData_textAttribute('600', 'order', false, '');
$GLOBALS['weTagWizard']['attribute']['id601_subgroup'] = new weTagData_selectAttribute('601', 'subgroup', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
?>