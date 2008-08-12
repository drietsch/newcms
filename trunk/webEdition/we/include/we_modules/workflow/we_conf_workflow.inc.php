<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


define("WE_WORKFLOW_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/");
define("WE_WORKFLOW_MODULE_PATH","/webEdition/we/include/we_modules/workflow/");

define("WORKFLOW_TABLE",TBL_PREFIX .  "tblWorkflowDef");
define("WORKFLOW_DOC_TABLE",TBL_PREFIX .  "tblWorkflowDoc");
define("WORKFLOW_DOC_STEP_TABLE",TBL_PREFIX .  "tblWorkflowDocStep");
define("WORKFLOW_DOC_TASK_TABLE",TBL_PREFIX .  "tblWorkflowDocTask");
define("WORKFLOW_LOG_TABLE",TBL_PREFIX .  "tblWorkflowLog");
define("WORKFLOW_STEP_TABLE",TBL_PREFIX .  "tblWorkflowStep");
define("WORKFLOW_TASK_TABLE",TBL_PREFIX .  "tblWorkflowTask");

?>