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