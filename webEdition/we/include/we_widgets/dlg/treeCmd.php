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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

if (isset($_REQUEST["cmd"])) {
	switch ($_REQUEST["cmd"]) {
		case "load" :
			if (isset($_REQUEST["pid"])) {
				print 
						we_htmlElement::jsElement(
								"self.location='/webEdition/we/include/we_export/exportLoadTree.php?we_cmd[1]=" . $_REQUEST["tab"] . "&we_cmd[2]=" . $_REQUEST["pid"] . "&we_cmd[3]=" . (isset(
										$_REQUEST["openFolders"]) ? $_REQUEST["openFolders"] : "") . "&we_cmd[4]=top'");
			}
			break;
	}
}

?>