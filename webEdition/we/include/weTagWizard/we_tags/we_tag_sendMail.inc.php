<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id452_id'] = new weTagData_textAttribute('452', 'id', false, '');
$GLOBALS['weTagWizard']['attribute']['id453_subject'] = new weTagData_textAttribute('453', 'subject', false, '');
$GLOBALS['weTagWizard']['attribute']['id454_recipient'] = new weTagData_textAttribute('454', 'recipient', true, '');
$GLOBALS['weTagWizard']['attribute']['id455_from'] = new weTagData_textAttribute('455', 'from', true, '');
$GLOBALS['weTagWizard']['attribute']['id456_reply'] = new weTagData_textAttribute('456', 'reply', false, '');
$GLOBALS['weTagWizard']['attribute']['id457_mimetype'] = new weTagData_selectAttribute('457', 'mimetype', array(new weTagDataOption('text/plain', false, ''), new weTagDataOption('text/html', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id458_charset'] = new weTagData_textAttribute('458', 'charset', false, '');
?>