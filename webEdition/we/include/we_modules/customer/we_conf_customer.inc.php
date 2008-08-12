<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//





define("CUSTOMER_TABLE",TBL_PREFIX . "tblWebUser");
define("CUSTOMER_ADMIN_TABLE",TBL_PREFIX . "tblWebAdmin");
define("CUSTOMER_FILTER_TABLE",TBL_PREFIX . "tblcustomerfilter");

define("WE_CUSTOMER_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/");
define("WE_CUSTOMER_MODULE_PATH","/webEdition/we/include/we_modules/customer/");

@include(WE_CUSTOMER_MODULE_DIR."we_conf_customerpro.inc.php");

?>
