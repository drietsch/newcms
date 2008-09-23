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





define("CUSTOMER_TABLE",TBL_PREFIX . "tblWebUser");
define("CUSTOMER_ADMIN_TABLE",TBL_PREFIX . "tblWebAdmin");
define("CUSTOMER_FILTER_TABLE",TBL_PREFIX . "tblcustomerfilter");

define("WE_CUSTOMER_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/");
define("WE_CUSTOMER_MODULE_PATH","/webEdition/we/include/we_modules/customer/");

@include(WE_CUSTOMER_MODULE_DIR."we_conf_customerpro.inc.php");

?>
