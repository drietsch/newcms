<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


$splitMdc = explode(';',$aProps[3]);
$oTblCont = new we_htmlTable(array("border"=>"0","cellpadding" =>"0","cellspacing"=>"0"),1,1);
$oTblCont->setCol(0,0,null,we_htmlElement::htmlDiv(array("id"=>"m_".$iCurrId."_inline","style"=>"width:".$iWidth."px;height:".($aPrefs[$aProps[0]]["height"]-25)."px;overflow:auto;"),$mdc));
$aLang = array(($splitMdc[0] != "")? base64_decode($splitMdc[0]) : (!$splitMdc[1][1]? $l_cockpit["my_documents"] : $l_cockpit["my_objects"]),"");

?>
