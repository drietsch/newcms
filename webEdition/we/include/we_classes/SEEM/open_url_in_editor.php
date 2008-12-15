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
?><script language="JavaScript" type="text/javascript">
<?php
	
	// $_REQUEST["we_cmd"][1] is the url
	
    //	The following will translate a given URL to a we_cmd.
    //	When pressing a link in edit-mode this functionality
    //	is needed to reopen the document (if possible) with webEdition
    
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");
	protect();
	print we_SEEM::getJavaScriptCommandForOneLink("<a href=\"" . $_REQUEST["we_cmd"][1] . "\">");
?>
</script>