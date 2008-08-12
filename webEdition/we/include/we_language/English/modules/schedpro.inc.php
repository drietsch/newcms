<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//
// $Id: schedpro.inc.php,v 1.8 2007/05/23 15:39:35 holger.meyer Exp $

/**
 * Language file: schedpro.inc.php
 * Provides language strings.
 * Language: English
 */

$GLOBALS["l_schedpro"] = array();
$GLOBALS["l_schedpro"]["task"] = array();

$GLOBALS["l_schedpro"]["task"]["headline"] = "Task";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_FROM] = "Publish";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_TO] = "Unpublish";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DELETE] = "Delete";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DOCTYPE] = "Change document type";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_CATEGORY] = "Change categories";
$GLOBALS["l_schedpro"]["task"][SCHEDULE_DIR] = "Change directory";

$GLOBALS["l_schedpro"]["type"] = array();

$GLOBALS["l_schedpro"]["type"]["headline"] = "Frequency";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_ONCE] = "Once";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_HOUR] = "Hourly";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_DAY] = "Daily";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_WEEK] = "Weekly";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_MONTH] = "Monthly";
$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_YEAR] = "Yearly";

$GLOBALS["l_schedpro"]["time"] = "Time";
$GLOBALS["l_schedpro"]["months"] = "Months";
$GLOBALS["l_schedpro"]["days"] = "Days";
$GLOBALS["l_schedpro"]["weekdays"] = "Weekdays";
$GLOBALS["l_schedpro"]["minutes"] = "Minutes";
$GLOBALS["l_schedpro"]["datetime"] = "Date/Time";

$GLOBALS["l_schedpro"]["categories"] = "Categories";
$GLOBALS["l_schedpro"]["doctype"] = "Document type";
$GLOBALS["l_schedpro"]["dirctory"] = "Directory";

$GLOBALS["l_schedpro"]["active"] = "Active";
$GLOBALS["l_schedpro"]["doctypeAll"] = "Use default values";

$GLOBALS["l_schedpro"]["descriptiontext"] = "To add a task to the Scheduler, please click the plus button.";
?>