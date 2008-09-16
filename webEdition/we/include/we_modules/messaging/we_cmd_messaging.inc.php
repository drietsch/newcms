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

	switch($_REQUEST["we_cmd"][0]) {
		case 'messaging_start':
		case 'edit_messaging_ifthere':
			$mod="messaging";
			$INCLUDE = 'we_modules/show_frameset.php';
			break;
	}
?>
