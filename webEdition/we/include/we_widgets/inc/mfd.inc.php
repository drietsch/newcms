<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

$oTblCont = new we_htmlTable(array("border"=>"0","cellpadding" =>"0","cellspacing"=>"0"),1,1);
$oTblCont->setCol(0,0,null,we_htmlElement::htmlDiv(array("id"=>"m_".$iCurrId."_inline","style"=>"width:".$iWidth."px;height:".($aPrefs[$aProps[0]]["height"]-25)."px;overflow:auto;"),$lastModified));
$aLang = array($l_cockpit["last_modified"],"");

?>
