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

	if(isset($_REQUEST["code"])) {
		print $_REQUEST["code"];
		exit();
	}

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMainTree.inc.php");

	$Tree =  new weMainTree("webEdition.php","top","top.resize.left.tree","top.load");

	print $Tree->getHTMLContruct("if(top.treeResized){top.treeResized();}");
?>