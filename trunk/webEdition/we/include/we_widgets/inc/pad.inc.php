<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


list($pad_header_enc,$pad_csv) = explode(',',$aProps[3]);

$_iFrmPadAtts['src'] = WEBEDITION_DIR.'we/include/we_widgets/mod/pad.inc.php'.
	'?we_cmd[0]='.$pad_csv.
	'&amp;we_cmd[1]='.
	'&amp;we_cmd[2]=home'.
	'&amp;we_cmd[3]='.$aProps[1].
	'&amp;we_cmd[4]='.rawurlencode($pad_header_enc).
	'&amp;we_cmd[5]='.$iCurrId.
	'&amp;we_cmd[6]='.$aProps[1].
	'&amp;we_cmd[7]=home';
$_iFrmPadAtts['id'] = 'm_'.$iCurrId.'_inline';
$_iFrmPadAtts['style'] = 'width:'.$iWidth.'px;height:287px';
$_iFrmPadAtts['scrolling'] = 'no';
$_iFrmPadAtts['marginheight'] = '0';
$_iFrmPadAtts['marginwidth'] = '0';
$_iFrmPadAtts['frameborder'] = '0';

$_iFrmPad = str_replace('>',' allowtransparency="true">',getHtmlTag('iframe',$_iFrmPadAtts,'',true));

$oTblCont = new we_htmlTable(array("cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,1);
$oTblCont->setCol(0,0,null,$_iFrmPad);
$aLang = array($l_cockpit['notes']." - ".base64_decode($pad_header_enc),"");

?>
