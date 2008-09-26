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


define("SCHEDULE_TABLE",TBL_PREFIX . "tblSchedule");
define("SCHEDULE_FROM","1");
define("SCHEDULE_TO","2");

define("WE_SCHEDULE_MODULE_PATH","/webEdition/we/include/we_modules/schedule/");
define("WE_SCHEDULE_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"].WE_SCHEDULE_MODULE_PATH);

@include_once(WE_SCHEDULE_MODULE_DIR."we_schedpro_defines.inc.php");
@include_once(WE_SCHEDULE_MODULE_DIR."we_schedpro.inc.php");

function trigger_schedule() {

	we_schedpro::trigger_schedule();
	return;

}

function check_and_convert_to_sched_pro() {
	we_schedpro::check_and_convert_to_sched_pro();
}
?>
