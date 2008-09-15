<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_choiceAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id474_id'] = new weTagData_selectorAttribute('474', 'id',FILE_TABLE, 'text/webedition', true, ''); }
$GLOBALS['weTagWizard']['attribute']['id475_target'] = new weTagData_choiceAttribute('475', 'target', array(new weTagDataOption('_top', false, ''), new weTagDataOption('_parent', false, ''), new weTagDataOption('_self', false, ''), new weTagDataOption('_blank', false, '')), false,false, '');
$GLOBALS['weTagWizard']['attribute']['id476_class'] = new weTagData_textAttribute('476', 'class', false, '');
$GLOBALS['weTagWizard']['attribute']['id477_style'] = new weTagData_textAttribute('477', 'style', false, '');
?>