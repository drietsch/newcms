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
?><html>
<head>
</head>
<body>
<script language="JavaScript" type="text/javascript">
<?php
	
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");
	protect();

	// build url from REQUEST ...
	$paraStr = we_SEEM::arrayToParameters($_REQUEST, "", array("we_cmd", "original_action") );
	$action = $_REQUEST['original_action'] . "?1" . $paraStr;

    //	The following will translate a given URL to a we_cmd.
    //	When pressing a link in edit-mode this functionality
    //	is needed to reopen the document (if possible) with webEdition
	
	print we_SEEM::getJavaScriptCommandForOneLink("<a href=\"" . str_replace(" ", "+", $action) . "\">");
?>
</script>
</body>
</html>