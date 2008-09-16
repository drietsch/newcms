<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


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
