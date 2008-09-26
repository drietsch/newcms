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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

$parts = array();
array_push($parts,array("icon"=>"upload.gif", "headline"=>"","html"=>$GLOBALS['we_doc']->formUpload(),"space"=>140));
array_push($parts,array("icon"=>"attrib.gif", "headline"=>$GLOBALS["l_we_class"]["attribs"],"html"=>$GLOBALS['we_doc']->formProperties(),"space"=>140));
//array_push($parts,array("icon"=>"meta.gif", "headline"=>$GLOBALS["l_we_class"]["metainfo"],"html"=>$GLOBALS['we_doc']->formMetaInfos(),"space"=>140));
array_push($parts,array("icon"=>"meta.gif", "headline"=>$GLOBALS["l_we_class"]["metadata"],"html"=>$GLOBALS['we_doc']->formMetaInfos().$GLOBALS['we_doc']->formMetaData(),"space"=>140));
print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("weImgProp","100%",$parts,20);

?>