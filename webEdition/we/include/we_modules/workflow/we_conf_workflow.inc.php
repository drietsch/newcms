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