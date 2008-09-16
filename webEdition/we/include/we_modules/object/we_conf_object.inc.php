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


define("OBJECT_TABLE", TBL_PREFIX . "tblObject");
define("OBJECT_FILES_TABLE", TBL_PREFIX . "tblObjectFiles");
define("OBJECT_X_TABLE", TBL_PREFIX . "tblObject_");

define("WE_OBJECT_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/");
define("WE_OBJECT_MODULE_PATH","/webEdition/we/include/we_modules/object/");

// Number of displayed objects in the left navigation
define("OBJECT_FILES_TREE_COUNT", 20);

?>