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

include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");

$parts = array();

array_push($parts,array("icon"=>"path.gif", "headline"=>$GLOBALS["l_we_class"]["path"],"html"=>$GLOBALS['we_doc']->formPath(),"space"=>120));
array_push($parts,array("icon"=>"default.gif", "headline"=>$GLOBALS["l_we_class"]["other"],"html"=>$GLOBALS['we_doc']->formOther(),"space"=>120));

print we_multiIconBox::getJS();
print we_multiIconBox::getHTML("weQuickProp","100%",$parts,20);


?>
