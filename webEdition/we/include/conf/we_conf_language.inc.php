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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/countries.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/languages.inc.php");

$GLOBALS["weFrontendLanguages"] = array(
	'de_DE' => $GLOBALS['l_languages']['de'] . " (" . $GLOBALS['l_countries']['DE'] . ")",
	'en_GB' => $GLOBALS['l_languages']['en'] . " (" . $GLOBALS['l_countries']['GB'] . ")",

);

$GLOBALS["weDefaultFrontendLanguage"] = "de_DE";

?>