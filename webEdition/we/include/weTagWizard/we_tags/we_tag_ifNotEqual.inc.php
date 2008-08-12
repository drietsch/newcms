<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id228_name'] = new weTagData_textAttribute('228', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id229_eqname'] = new weTagData_textAttribute('229', 'eqname', false, '');
$GLOBALS['weTagWizard']['attribute']['id230_value'] = new weTagData_textAttribute('230', 'value', false, '');
?>