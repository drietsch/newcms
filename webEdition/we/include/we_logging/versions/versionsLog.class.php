<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

define("WE_LOGGING_VERSIONS_DELETE", 1);
define("WE_LOGGING_VERSIONS_RESET", 2);
define("WE_LOGGING_VERSIONS_PREFS", 3);

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/logging.class.php");


class versionsLog extends logging{
	
	
	public $action;
	public $data;
	
	
	function __construct() {
		
		$this->table = VERSIONS_TABLE_LOG;
		parent::__construct();
		
	}
	
	function saveVersionsLog($logArray, $action=""){
		
		$this->action = $action;
		$this->data = serialize($logArray);
		
		$this->saveLog();

	}
	
	function __destruct() {
		
		parent::__destruct();
		
	}
	
}

?>