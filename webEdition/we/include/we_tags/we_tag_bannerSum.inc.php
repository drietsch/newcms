<?php

function we_tag_bannerSum($attribs,$content){
	if(!isset($GLOBALS["lv"])){
			return false;
	}
	$foo = attributFehltError($attribs,"type","bannerSum");if($foo) return $foo;
	$type = we_getTagAttribute("type",$attribs);
	switch ($type){
		case "clicks":
			return $GLOBALS["lv"]->getAllclicks();
			break;
		case "views":
			return $GLOBALS["lv"]->getAllviews();
			break;
		case "rate":
			return $GLOBALS["lv"]->getAllrate();
			break;
	}
			
}

?>