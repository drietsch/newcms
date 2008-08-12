<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


define("OBJECT_TABLE", TBL_PREFIX . "tblObject");
define("OBJECT_FILES_TABLE", TBL_PREFIX . "tblObjectFiles");
define("OBJECT_X_TABLE", TBL_PREFIX . "tblObject_");

define("WE_OBJECT_MODULE_DIR", $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/");
define("WE_OBJECT_MODULE_PATH","/webEdition/we/include/we_modules/object/");

// Number of displayed objects in the left navigation
define("OBJECT_FILES_TREE_COUNT", 20);

?>