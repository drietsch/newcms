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

class rpcGetCategoryView extends rpcView {
	
	function getResponse($response) {

		$_elems = ""; 
		$_i=0;

		foreach ($response->getData("elementsById") as $_element => $_property) {
			$_elems .=($_i>0?", ":"")."
		".$_i.':{ 
			elemId: "'.$_element.'", 
			props: {';
				$_loop = 0;
				foreach ($_property as $_propertyName => $_propertyValue) {
					$_elems .= ($_loop>0?", ":"") . "
				".$_loop .':{
					prop:"' . $_propertyName.'", 
					val: "'.$_propertyValue.'"
				}';
					$_loop++; 
				}
				$_elems .= '
			}
		}';
			$_i++;
		}				
		
		$json = <<<HTS1
{ 
	elemsById: { $_elems
	} 
}
HTS1;

		return $json;		
	}
}
?>