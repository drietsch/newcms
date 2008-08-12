<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


$oTblCont = new we_htmlTable(array("id"=>"m_".$iCurrId."_inline","style"=>"width:".$iWidth."px;","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,1);
$oTblCont->setCol(0,0,null,$inline);
$aLang = array($l_cockpit["users_online"],' ([[span id="num_users"]]' . $UO->getNumUsers()."[[/span]])");

?>
