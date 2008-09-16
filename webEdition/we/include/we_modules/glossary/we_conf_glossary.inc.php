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

define("GLOSSARY_TABLE",TBL_PREFIX . "tblglossary");
define("WE_GLOSSARY_MODULE_PATH","/webEdition/we/include/we_modules/glossary/");
define("WE_GLOSSARY_MODULE_DIR",$_SERVER["DOCUMENT_ROOT"].WE_GLOSSARY_MODULE_PATH);
		
we_loadLanguageConfig();

?>