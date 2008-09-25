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

require_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/messageConsole.inc.php");

/**
 * creates a new messageConsole
 *
 * @param string $consoleName
 * @return string
 */
function createMessageConsole($consoleName="NoName") {

	return "
<script type=\"text/javascript\" src=\"" . JS_DIR . "messageConsoleImages.js\"></script>
<script type=\"text/javascript\" src=\"" . JS_DIR . "messageConsoleView.js\"></script>
<script type=\"text/javascript\">

var _msgNotice  = \"" . $GLOBALS["l_messageConsole"]["iconBar"]["notice"] . "\";
var _msgWarning = \"" . $GLOBALS["l_messageConsole"]["iconBar"]["warning"] . "\";
var _msgError   = \"" . $GLOBALS["l_messageConsole"]["iconBar"]["error"] . "\";


var _console_$consoleName = new messageConsoleView( '$consoleName', window );
_console_$consoleName.register();

onunload=function() {
	_console_$consoleName.unregister();
}

</script>
<div>
	<table>
	<tr>
		<td valign=\"middle\">
		<span class=\"small\" id=\"messageConsoleMessage$consoleName\" style=\"display: none; background-color: white; border: 1px solid #cdcdcd; padding: 2px 4px 2px 4px; margin: 3px 10px 0 0;\">
			--
		</span>
		</td>
		<td>
			<div onclick=\"_console_$consoleName.openMessageConsole();\" class=\"navigation_normal\" onmouseover=\"this.className='navigation_hover'\" onmouseout=\"this.className='navigation_normal'\"><img id=\"messageConsoleImage$consoleName\" src=\"" . IMAGE_DIR . "messageConsole/notice.gif\" style=\"border: none; padding: 1px;\" /></div>
		</td>
	</tr>
	</table>
</div>
";
}

?>