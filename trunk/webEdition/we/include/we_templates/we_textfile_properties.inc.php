<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//



include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/charsetHandler.class.php");

$parts = array();
array_push($parts,array("icon"=>"path.gif", "headline"=>$GLOBALS["l_we_class"]["path"],"html"=>$GLOBALS['we_doc']->formPath(),"space"=>120));
array_push($parts,array("icon"=>"charset.gif", "headline"=>$GLOBALS["l_we_class"]["Charset"],"html"=>$GLOBALS['we_doc']->formCharset(),"space"=>120));
array_push($parts,array("icon"=>"user.gif", "headline"=>$GLOBALS["l_we_class"]["owners"],"html"=>$GLOBALS['we_doc']->formCreatorOwners(),"space"=>120));
array_push($parts,array("icon"=>"copy.gif", "headline"=>$GLOBALS["l_we_class"]["copy".$GLOBALS['we_doc']->ContentType],"html"=>$GLOBALS['we_doc']->formCopyDocument(),"space"=>120));

print we_multiIconBox::getHTML("","100%",$parts,30);
?>
