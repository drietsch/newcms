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

// Live Update Server
define("LIVEUPDATE_SERVER", "update.webedition.de");

// Live Update Server Script
define("LIVEUPDATE_SERVER_SCRIPT", "/we5/snippets.p" . "hp");

// Css
define("LIVEUPDATE_CSS", "");

// Temp Dir for downloaded files
define("LIVEUPDATE_CLIENT_DOCUMENT_DIR", $_SERVER["DOCUMENT_ROOT"] . WEBEDITION_DIR . "/liveUpdate");

?>