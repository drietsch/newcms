<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id631_xpath'] = new weTagData_textAttribute('631', 'xpath', true, '');
$GLOBALS['weTagWizard']['attribute']['id629_url'] = new weTagData_textAttribute('629', 'url', false, '');
$GLOBALS['weTagWizard']['attribute']['id630_feed'] = new weTagData_textAttribute('630', 'feed', false, '');
?>