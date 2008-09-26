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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");

protect();
$ok = false;

if($_SESSION["perms"]["ADMINISTRATOR"]){
	$we_transaction = $_REQUEST["we_cmd"][1];
	// init document
	$we_dt = $_SESSION["we_data"][$we_transaction];

	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

	$childs = array();
	pushChilds($childs,$we_doc->ID,$we_doc->Table);
	$childlist = makeCSVFromArray($childs);
	if($childlist) {
		$q = "
			UPDATE ".$we_doc->Table."
			SET CreatorID='".$we_doc->CreatorID."',Owners='".$we_doc->Owners."',RestrictOwners='".$we_doc->RestrictOwners."',OwnersReadOnly='".$we_doc->OwnersReadOnly."'
			WHERE ID IN(".$childlist.")";
		$ok = $DB_WE->query($q);
	}
}

htmlTop();
?>
<script language="JavaScript" type="text/javascript"><!--
	<?php if($ok): ?>
		<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_users"]["grant_owners_ok"], WE_MESSAGE_NOTICE); ?>
	<?php else: ?>
		<?php print we_message_reporting::getShowMessageCall($GLOBALS["l_users"]["grant_owners_notok"], WE_MESSAGE_ERROR); ?>
	<?php endif ?>
//-->
</script>
</head>

<body>
</body>

</html>