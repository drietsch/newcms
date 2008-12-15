<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id736_plain'] = new weTagData_selectAttribute('736', 'plain', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, 'newsletter');
?>