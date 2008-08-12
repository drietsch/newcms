<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id381_type'] = new weTagData_selectAttribute('381', 'type', array(new weTagDataOption('email', false, ''), new weTagDataOption('salutation', false, 'newsletter'), new weTagDataOption('title', false, 'newsletter'), new weTagDataOption('firstname', false, 'newsletter'), new weTagDataOption('lastname', false, 'newsletter')), false, '');
?>