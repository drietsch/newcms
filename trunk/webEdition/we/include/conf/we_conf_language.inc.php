<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/countries.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/languages.inc.php");

$GLOBALS["weFrontendLanguages"] = array(
	'de_DE' => $GLOBALS['l_languages']['de'] . " (" . $GLOBALS['l_countries']['DE'] . ")",
	'en_GB' => $GLOBALS['l_languages']['en'] . " (" . $GLOBALS['l_countries']['GB'] . ")",

);

$GLOBALS["weDefaultFrontendLanguage"] = "de_DE";

?>