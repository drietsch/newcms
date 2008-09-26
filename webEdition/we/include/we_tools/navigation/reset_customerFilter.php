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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php');
protect();
if ($_SESSION["perms"]["ADMINISTRATOR"]) {
	$GLOBALS['DB_WE']->query("UPDATE " . NAVIGATION_TABLE . " SET  LimitAccess=0, ApplyFilter=0");
	
	print 
			'<script type="text/javascript">
	top.openWindow(\'' . WEBEDITION_DIR . 'we_cmd.php?we_cmd[0]=rebuild&step=2&type=rebuild_navigation&responseText=' . rawurlencode(
					$l_navigation['reset_customerfilter_done_message']) . '\',\'resave\',-1,-1,600,130,0,true);
</script>
';
}

?>