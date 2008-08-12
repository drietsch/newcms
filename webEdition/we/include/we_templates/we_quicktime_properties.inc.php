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

$parts = array();

array_push($parts,array("icon"=>"path.gif", "headline"=>$GLOBALS["l_we_class"]["path"],"html"=>$GLOBALS['we_doc']->formPath(),"space"=>120));
array_push($parts,array("icon"=>"default.gif", "headline"=>$GLOBALS["l_we_class"]["other"],"html"=>$GLOBALS['we_doc']->formOther(),"space"=>120));

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("weQuickProp","100%",$parts,20);


?>
