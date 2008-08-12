<?php

	if(isset($_REQUEST["code"])) {
		print $_REQUEST["code"];
		exit();
	}

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMainTree.inc.php");

	$Tree =  new weMainTree("webEdition.php","top","top.resize.left.tree","top.load");

	print $Tree->getHTMLContruct("if(top.treeResized){top.treeResized();}");
?>