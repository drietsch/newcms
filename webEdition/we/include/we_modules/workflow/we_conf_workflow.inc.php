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