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

class liveUpdateHttpWizard extends liveUpdateHttp {
	
	/**
	 * returns html page with formular to init session on the server
	 *
	 * @return unknown
	 */
	function getServerSessionForm() {
		
		$params = '';
		foreach ($GLOBALS['LU_Variables'] as $LU_name => $LU_value) {
					
			if (is_array($LU_value)) {
				$params .= "\t<input type=\"hidden\" name=\"$LU_name\" value=\"" . urlencode( serialize($LU_value) ) . "\" />\n";
			} else {
				$params .= "\t<input type=\"hidden\" name=\"$LU_name\" value=\"" . urlencode( $LU_value ) . "\" />\n";
			}
		}
		
		$html = '<html>
<head>
	' . LIVEUPDATE_CSS . '
<head>
<body onload="document.getElementById(\'liveUpdateForm\').submit();">
<form id="liveUpdateForm" action="' . 'http://' . LIVEUPDATE_SERVER . LIVEUPDATE_SERVER_SCRIPT . '" method="post">
	<input type="hidden" name="we_cmd[0]" value="' . $_REQUEST['we_cmd'][0] . '" /><br />
	<input type="hidden" name="update_cmd" value="startSession" /><br />
	<input type="hidden" name="next_cmd" value="' . $_REQUEST['update_cmd'] . '" />
	<input type="hidden" name="detail" value="' . $_REQUEST['detail'] . '" />
	' . $params . '
</form>
</body>
</html>';
		return $html;
	}
}

?>