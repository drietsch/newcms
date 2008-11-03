<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id748_name'] = new weTagData_textAttribute('748', 'name', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id750_id'] = new weTagData_textAttribute('750', 'id', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id751_size'] = new weTagData_textAttribute('751', 'size', false, 'customer');
$GLOBALS['weTagWizard']['attribute']['id752_condition'] = new weTagData_textAttribute('752', 'condition', false, 'customer');
?>