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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/alert.inc.php");

	$parts=array();
	$out="";

	if(isset($_SESSION["delete_files_nok"]) && is_array($_SESSION["delete_files_nok"])){
		$i=0;

		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0, "class" => "defaultfont"), 1, 4);
		$i=0;
		$table->setCol(0,0,null,getPixel(10,10));
		foreach($_SESSION["delete_files_nok"] as $data){
			$table->addRow();
			$i++;
			$table->setCol($i,0,null,getPixel(10,2));
			$table->setCol($i,1,null,(isset($data["icon"]) ? we_htmlElement::htmlImg(array("src"=>ICON_DIR.$data["icon"])) : ""));
			$table->setCol($i,2,null,getPixel(10,2));
			$table->setCol($i,3,null,str_replace($_SERVER["DOCUMENT_ROOT"],"",$data["path"]));
		}
		$table->addRow();
		$i++;
		$table->setCol($i,0,null,getPixel(10,10));
	}



	array_push($parts,array(
				"headline"=>htmlAlertAttentionBox($_SESSION["delete_files_info"],1,500),
				"html"=>"",
				"space"=>10,
				"noline"=>1)
	);
	array_push($parts,array(
				"headline"=>"",
				"html"=>we_htmlElement::htmlDiv(array("class"=>"blockwrapper","style"=>"width: 475px; height: 350px; border:1px #dce6f2 solid;"),$table->getHtmlCode()),
				"space"=>10)
	);

	$we_button = new we_button();
	$buttons = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0, "class" => "defaultfont", "align"=>"right"), 1, 1);
	$buttons->setCol(0,0,null,$we_button->create_button("close","javascript:self.close();"));
	print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				//we_htmlElement::htmlTitle("")
				WE_DEFAULT_HEAD
			).
			STYLESHEET.
			we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
					we_htmlElement::htmlCenter(
						we_multiIconBox::getHTML("","100%",$parts,30,$buttons->getHtmlCode())

					)
			)
	);

?>