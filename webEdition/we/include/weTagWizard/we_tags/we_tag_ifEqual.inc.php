<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id207_name'] = new weTagData_textAttribute('207', 'name', true, '');
$GLOBALS['weTagWizard']['attribute']['id208_eqname'] = new weTagData_textAttribute('208', 'eqname', false, '');
$GLOBALS['weTagWizard']['attribute']['id209_value'] = new weTagData_textAttribute('209', 'value', false, '');
?>