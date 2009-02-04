<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_textAttribute.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_selectorAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = false;

$GLOBALS['weTagWizard']['attribute']['id695_navigationname'] = new weTagData_textAttribute('695', 'navigationname', false, '');
if(defined("NAVIGATION_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id696_parentid'] = new weTagData_selectorAttribute('696', 'parentid',NAVIGATION_TABLE, 'weNavigation', false, ''); }
if(defined("NAVIGATION_TABLE")) { $GLOBALS['weTagWizard']['attribute']['id716_id'] = new weTagData_selectorAttribute('716', 'id',NAVIGATION_TABLE, 'weNavigation', false, ''); }
$GLOBALS['weTagWizard']['attribute']['id734_cachelifetime'] = new weTagData_textAttribute('734', 'cachelifetime', false, '');
?>