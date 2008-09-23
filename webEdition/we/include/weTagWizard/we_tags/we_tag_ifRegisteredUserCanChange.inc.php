<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id804_protected'] = new weTagData_selectAttribute('804', 'protected', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id264_admin'] = new weTagData_textAttribute('264', 'admin', false, '');
$GLOBALS['weTagWizard']['attribute']['id263_userid'] = new weTagData_textAttribute('263', 'userid', true, '');
?>