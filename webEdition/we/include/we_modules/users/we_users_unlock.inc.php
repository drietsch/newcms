<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                  |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
protect();


// prepare the queries, 4 as maximum.
$_ids			= explode(",", $_REQUEST["we_cmd"][1]); // we_cmd[1] is commaseperated list of ids
$_tables		= explode(",", $_REQUEST["we_cmd"][3]); // we_cmd[3] is commaseperated list of tables
$_transaction	= isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : null; // we_cmd[4] is a single transaction, to delete data from session

$queries = array();

if ($_transaction) { // clean session
	if(isset($_SESSION["we_data"][$_transaction])){
		unset($_SESSION["we_data"][$_transaction]); // we_transaction is resetted here
		
	}
}

for ($i=0;$i<sizeof($_ids); $i++) {
	if ($_tables[$i]) {
		$queries[$_tables[$i]][] = $_ids[$i];
	}
}

foreach ($queries as $table => $ids) {
	$DB_WE->query("DELETE FROM ".LOCK_TABLE." WHERE  tbl ='" . $table . "' AND ID in (" . implode(", ", $ids) . ") AND UserID='".addslashes($_REQUEST["we_cmd"][2])."'");
}
?>UNLOCKED