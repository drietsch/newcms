<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
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