<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/weSearch/conf/define.conf.php");

$metaInfo = array(
	
		'name' => 'weSearch', 
		'realname' => 'weSearch', 
		'classname' => 'searchtool', 
		'maintable' => SUCHE_TABLE, 
		'datasource' => 'table:' . SUCHE_TABLE, 
		'startpermission' => ''
);

?>