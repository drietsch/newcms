<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifLoginFailed($attribs,$content) {
	$foo = isset($_SESSION["webuser"]["loginfailed"]) ? $_SESSION["webuser"]["loginfailed"] : "";
	$_SESSION["webuser"]["loginfailed"]="";
	return $foo;
}
?>