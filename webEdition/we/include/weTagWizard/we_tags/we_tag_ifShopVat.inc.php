<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/weTagWizard/classes/weTagData_sqlRowAttribute.class.php');

$GLOBALS['weTagWizard']['weTagData']['needsEndtag'] = true;

$GLOBALS['weTagWizard']['attribute']['id271_id'] = new weTagData_sqlRowAttribute('271', 'id',WE_SHOP_VAT_TABLE, true, 'id', 'text', 'text', '');
?>