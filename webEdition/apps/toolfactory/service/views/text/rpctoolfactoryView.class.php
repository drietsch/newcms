<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpctoolfactoryView extends rpcView {
	
	
	function getResponse($response) {
		
		$html = '
			Hallo World! My name is toolfactory and I am a webEdition-Tool	
		';
		
		return $html;
	}
}
