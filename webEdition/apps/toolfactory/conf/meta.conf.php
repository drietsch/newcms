<?php
// include autoload function
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

Zend_Loader::loadClass('we_core_Local');

$translate = we_core_Local::addTranslation('apps.xml');
we_core_Local::addTranslation('default.xml', 'toolfactory');

include_once('define.conf.php');

$metaInfo = array(
	'name' => 'toolfactory',
	'realname' => $translate->_('toolfactory'),
	'classname'=>'toolfactory',
	'maintable'=>'',
	'datasource'=>'custom:',
	'startpermission'=>'EDIT_APP_TOOLFACTORY'
);