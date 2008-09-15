<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id386_name'] = new weTagData_textAttribute('386', 'name', false, '');
$GLOBALS['weTagWizard']['attribute']['id733_text'] = new weTagData_textAttribute('733', 'text', false, '');
if(defined("OBJECT_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id387_classid'] = new weTagData_selectorAttribute('387', 'classid',OBJECT_TABLE, 'object', false, ''); }
if(defined("OBJECT_FILES_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id388_id'] = new weTagData_selectorAttribute('388', 'id',OBJECT_FILES_TABLE, 'objectFile', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id389_size'] = new weTagData_textAttribute('389', 'size', false, '');
if(defined("FILE_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id390_triggerid'] = new weTagData_selectorAttribute('390', 'triggerid',FILE_TABLE, 'text/webedition', false, ''); }
?>