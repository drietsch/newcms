<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id183_pages'] = new weTagData_choiceAttribute('183', 'pages', array(new weTagDataOption('all', false, ''), new weTagDataOption('properties', false, ''), new weTagDataOption('edit', false, ''), new weTagDataOption('information', false, ''), new weTagDataOption('preview', false, ''), new weTagDataOption('validation', false, ''), new weTagDataOption('schedpro', false, ''), new weTagDataOption('variants', false, '')), true,false, '');
?>