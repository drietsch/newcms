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

protect();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/rebuild/we_rebuild_wizard.inc.php");


$fr = isset($_REQUEST["fr"]) ? $_REQUEST["fr"] : "";


switch($fr){

	case "body":
		print we_rebuild_wizard::getBody();
		break;
	case "busy":
		print we_rebuild_wizard::getBusy();
		break;
	case "cmd":
		print we_rebuild_wizard::getCmd();
		break;
	default:
		print we_rebuild_wizard::getFrameset();
}

?>