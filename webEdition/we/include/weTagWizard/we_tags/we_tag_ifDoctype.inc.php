<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id201_doctypes'] = new weTagData_textAttribute('201', 'doctypes', true, '');
$GLOBALS['weTagWizard']['attribute']['id202_doc'] = new weTagData_selectAttribute('202', 'doc', array(new weTagDataOption('top', false, ''), new weTagDataOption('self', false, ''), new weTagDataOption('listview', false, '')), false, '');
?>