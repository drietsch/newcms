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





define("CUSTOMER_TABLE",TBL_PREFIX . "tblWebUser");
define("CUSTOMER_ADMIN_TABLE",TBL_PREFIX . "tblWebAdmin");
define("CUSTOMER_FILTER_TABLE",TBL_PREFIX . "tblcustomerfilter");

define("WE_CUSTOMER_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/");
define("WE_CUSTOMER_MODULE_PATH","/webEdition/we/include/we_modules/customer/");

@include(WE_CUSTOMER_MODULE_DIR."we_conf_customerpro.inc.php");

?>
