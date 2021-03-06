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
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


class rpcSelectorSuggestView extends rpcView {
	
	
	function getResponse($response) {

		header('Content-type: text/plain');
		$suggests = $response->getData("data");	
		$html = "";
		if (is_array($suggests)) {
			foreach ($suggests as $sug) {
				$html .= $sug['Path'] . "	" . $sug['ID'];
				$html .= "	".(isset($sug['ContentType']) ? $sug['ContentType'] : (isset($sug['IsFolder']) && $sug['IsFolder'] ? "folder" : "")) . "\n";
			}
		}
		return $html;
	}
}



?>