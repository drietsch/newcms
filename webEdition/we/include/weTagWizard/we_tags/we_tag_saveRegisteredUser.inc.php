<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id438_userexists'] = new weTagData_textAttribute('438', 'userexists', false, '');
$GLOBALS['weTagWizard']['attribute']['id439_userempty'] = new weTagData_textAttribute('439', 'userempty', false, '');
$GLOBALS['weTagWizard']['attribute']['id440_passempty'] = new weTagData_textAttribute('440', 'passempty', false, '');
$GLOBALS['weTagWizard']['attribute']['id437_register'] = new weTagData_selectAttribute('437', 'register', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id651_protected'] = new weTagData_textAttribute('651', 'protected', false, '');
?>