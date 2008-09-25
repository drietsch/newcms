<?php
error_log("22");
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

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