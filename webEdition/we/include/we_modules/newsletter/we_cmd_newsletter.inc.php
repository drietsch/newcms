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


switch ($_REQUEST["we_cmd"][0]) {
	case "edit_newsletter":
	case "edit_newsletter_ifthere":
		$mod="newsletter";
		$INCLUDE = "we_modules/show_frameset.php";
		break;
}

?>