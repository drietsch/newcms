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



include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/charsetHandler.class.php");

$parts = array();
array_push($parts,array("icon"=>"path.gif", "headline"=>$GLOBALS["l_we_class"]["path"],"html"=>$GLOBALS['we_doc']->formPath(),"space"=>120));
array_push($parts,array("icon"=>"charset.gif", "headline"=>$GLOBALS["l_we_class"]["Charset"],"html"=>$GLOBALS['we_doc']->formCharset(),"space"=>120));
array_push($parts,array("icon"=>"user.gif", "headline"=>$GLOBALS["l_we_class"]["owners"],"html"=>$GLOBALS['we_doc']->formCreatorOwners(),"space"=>120));
array_push($parts,array("icon"=>"copy.gif", "headline"=>$GLOBALS["l_we_class"]["copy".$GLOBALS['we_doc']->ContentType],"html"=>$GLOBALS['we_doc']->formCopyDocument(),"space"=>120));

print we_multiIconBox::getHTML("","100%",$parts,30);
?>
