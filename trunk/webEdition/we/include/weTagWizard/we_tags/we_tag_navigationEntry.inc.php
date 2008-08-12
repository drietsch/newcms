<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id697_navigationname'] = new weTagData_textAttribute('697', 'navigationname', false, '');
$GLOBALS['weTagWizard']['attribute']['id698_type'] = new weTagData_selectAttribute('698', 'type', array(new weTagDataOption('folder', false, ''), new weTagDataOption('item', false, '')), true, '');
$GLOBALS['weTagWizard']['attribute']['id699_level'] = new weTagData_textAttribute('699', 'level', false, '');
$GLOBALS['weTagWizard']['attribute']['id700_current'] = new weTagData_selectAttribute('700', 'current', array(new weTagDataOption('true', false, ''), new weTagDataOption('false', false, '')), false, '');
$GLOBALS['weTagWizard']['attribute']['id701_position'] = new weTagData_choiceAttribute('701', 'position', array(new weTagDataOption('1', false, ''), new weTagDataOption('odd', false, ''), new weTagDataOption('even', false, ''), new weTagDataOption('last', false, '')), false,false, '');
?>