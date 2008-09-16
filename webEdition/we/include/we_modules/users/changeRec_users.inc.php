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