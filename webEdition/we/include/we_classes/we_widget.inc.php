<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
* Class we_widget()
*
* Use this class to add a widget to the Cockpit.
*/
class we_widget {

	/**
	 * To add a widget give a unique id ($iId). Currently supported widget types ($sType) are Shortcuts (sct), RSS Reader (rss),
	 * Last modified (mfd), ToDo/Messaging (msg), Users Online (usr), and Unpublished docs and objs (ubp).
	 *
	 * @param      int $iId
	 * @param      string $sType
	 * @param      object $oContent
	 * @param      array $aLabel
	 * @param      string $sCls
	 * @param      int $iRes
	 * @param      string $sCsv
	 * @param      int $w
	 * @param      int $h
	 * @param      bool $resize
	 * @return     object Returns the we_htmlTable object
	 */
	function create($iId,$sType,$oContent,$aLabel=array("",""),$sCls="white",$iRes=0,$sCsv="",$w=0,$h=0,$resize=true){
		global $l_cockpit;
		$w_i0 = 10;
		$w_i1 = 5;
		$w_icon = (3*$w_i0)+(2*$w_i1);
		$h_i0 = 10;
		$show_seizer = false;
		$w_seizer = 30;
		$h_tb = 16;
		$h_title = 32;
		$wh_edge = 11;
		$gap = 10;

		$oDrag = new we_htmlTable(array("id"=>$iId."_h","style"=>"width:".($w-$w_icon)."px;height:".$h_tb."px;","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,2);
		$oDrag->setCol(0,0,array("width"=>$w_icon,"height"=>$h_tb,"style"=>"background-image:url(".IMAGE_DIR."pd/tb_pixel.gif);background-repeat:repeat-x;"),$show_seizer? we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_seizer.gif","width"=>$w_seizer,"height"=>$h_tb)) : getpixel($w_seizer,$h_tb));
		$oDrag->setCol(0,1,array("id"=>$iId."_lbl_old","align"=>"center","class"=>"label","style"=>"width:".($w-(2*$w_icon))."px;height:".$h_tb."px;background-image:url(".IMAGE_DIR."pd/tb_pixel.gif);background-repeat:repeat-x;"),"");

		$oIco_prc = new we_htmlTable(array("width"=>$w_icon,"height"=>$h_tb,"cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,5);
		$oIco_prc->setCol(0,0,array("width"=>$w_i0,"height"=>$h_tb,"valign"=>"middle"),
			we_htmlElement::htmlA(array("id"=>$iId."_props","href"=>"#","onclick"=>"propsWidget('".$sType."','".$iId."',gel('".$iId."_csv').value);this.blur();"),
				we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_props.gif","width"=>$w_i0,"height"=>$h_i0,"border"=>0,"title"=>$l_cockpit['properties']))));
		$oIco_prc->setCol(0,1,array("width"=>$w_i1,"height"=>$h_tb),getpixel($w_i1,1));
		$oIco_prc->setCol(0,2,array("width"=>$w_i0,"height"=>$h_tb,"valign"=>"middle"),
			we_htmlElement::htmlA(array("id"=>$iId."_resize","href"=>"#","onclick"=>"resizeWidget('".$iId."');this.blur();"),
				we_htmlElement::htmlImg(array("id"=>$iId."_icon_resize","src"=>IMAGE_DIR."pd/tb_resize.gif","width"=>$w_i0,"height"=>$h_i0,"border"=>0,"title"=>(($iRes==0)? $l_cockpit['increase_size']:$l_cockpit['reduce_size'])))));
		$oIco_prc->setCol(0,3,array("width"=>$w_i1,"height"=>$h_tb),getpixel($w_i1,1));
		$oIco_prc->setCol(0,4,array("width"=>$w_i0,"height"=>$h_tb,"valign"=>"middle"),
			we_htmlElement::htmlA(array("id"=>$iId."_remove","href"=>"#","onclick"=>"removeWidget('".$iId."');this.blur();"),
				we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_close.gif","width"=>$w_i0,"height"=>$h_i0,"border"=>0,"title"=>$l_cockpit['close']))));

		$oIco_pc = new we_htmlTable(array("width"=>$w_icon,"height"=>$h_tb,"cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,4);
		$oIco_pc->setCol(0,0,array("width"=>($w_i0+$w_i1),"height"=>$h_tb),getpixel(($w_i0+$w_i1),1));
		$oIco_pc->setCol(0,1,array("width"=>$w_i0,"height"=>$h_tb,"valign"=>"middle"),
			we_htmlElement::htmlA(array("id"=>$iId."_props","href"=>"#","onclick"=>"propsWidget('".$sType."','".$iId."',gel('".$iId."_csv').value);this.blur();"),
				we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_props.gif","width"=>$w_i0,"height"=>$h_i0,"border"=>0,"title"=>$l_cockpit['properties']))));
		$oIco_pc->setCol(0,2,array("width"=>$w_i1,"height"=>$h_tb),getpixel($w_i1,1));
		$oIco_pc->setCol(0,3,array("width"=>$w_i0,"height"=>$h_tb,"valign"=>"middle"),
			we_htmlElement::htmlA(array("id"=>$iId."_remove","href"=>"#","onclick"=>"removeWidget('".$iId."');this.blur();"),
				we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_close.gif","width"=>$w_i0,"height"=>$h_i0,"border"=>0,"title"=>$l_cockpit['close']))));

		$ico_obj = ($resize)? 'oIco_prc' : 'oIco_pc';
		$sIco = ($sType != "_reCloneType_")? we_htmlElement::htmlDiv(null,$$ico_obj->getHtmlCode()) :
			we_htmlElement::htmlDiv(array("id"=>$iId."_ico_prc","style"=>"display:block;"),$oIco_prc->getHtmlCode()).
			we_htmlElement::htmlDiv(array("id"=>$iId."_ico_pc","style"=>"display:none;"),$oIco_pc->getHtmlCode());

		$oTb = new we_htmlTable(array("id"=>$iId."_tb","style"=>"width:".($w+(2*$wh_edge))."px;height:".$h_tb."px;","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),1,4);
		$oTb->setCol(0,0,array("width"=>$wh_edge,"height"=>$h_tb),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_corner_left.gif","width"=>$wh_edge,"height"=>$h_tb)));
		$oTb->setCol(0,1,array("width"=>$w-$w_icon,"height"=>$h_tb,"style"=>"background-image:url(".IMAGE_DIR."pd/tb_pixel.gif);background-repeat:repeat-x;"),$oDrag->getHtmlCode());
		$oTb->setCol(0,2,array("width"=>$w_icon,"height"=>$h_tb,"style"=>"background-image:url(".IMAGE_DIR."pd/tb_pixel.gif);background-repeat:repeat-x;"),$sIco);
		$oTb->setCol(0,3,array("width"=>$wh_edge,"height"=>$wh_edge),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/tb_corner_right.gif","width"=>$wh_edge,"height"=>$h_tb)));

		$oBox = new we_htmlTable(array("id"=>$iId."_bx","style"=>"width:".($w+(2*$wh_edge))."px;height:".($h+(2*$wh_edge))."px;","cellpadding"=>"0","cellspacing"=>"0","border"=>"0"),4,3);
		$oBox->setCol(0,0,array("colspan"=>3,"width"=>$wh_edge,"height"=>$h_tb),$oTb->getHtmlCode());
		$oBox->setCol(1,0,array("id"=>$iId."_lbl_mgnl","align"=>"left","width"=>$wh_edge,"height"=>$h_title,"style"=>"background-image:url(".IMAGE_DIR."pd/header_".$sCls.".gif);background-repeat:repeat-x;"),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/line_v.gif","style"=>"width:1px;height:".$h_title."px;")));
		$oBox->setCol(1,1,array("id"=>$iId."_lbl","class"=>"label","style"=>"width:".$w."px;background-image:url(".IMAGE_DIR."pd/header_".$sCls.".gif);background-repeat:repeat-x;"),we_htmlElement::jsElement("setLabel('".$iId."','".str_replace("'","\'",$aLabel[0])."','".str_replace("'","\'",$aLabel[1])."');"));
		$oBox->setCol(1,2,array("id"=>$iId."_lbl_mgnr","align"=>"right","width"=>$wh_edge,"height"=>$h_title,"style"=>"background-image:url(".IMAGE_DIR."pd/header_".$sCls.".gif);background-repeat:repeat-x;"),we_htmlElement::htmlNobr(getPixel(10,1).we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/line_v.gif","style"=>"width:1px;height:".$h_title."px;"))));
		$oBox->setCol(2,0,array("id"=>$iId."_vll","align"=>"left","width"=>$wh_edge,"height"=>$h,"class"=>"bgc_".$sCls),we_htmlElement::htmlImg(array("id"=>$iId."_vline_l","src"=>IMAGE_DIR."pd/line_v.gif","style"=>"width:1px;height:".$h."px;")));
		$oBox->setCol(2,1,array("id"=>$iId."_wrapper","style"=>"text-align:left;vertical-align:top;","width"=>$w,"height"=>$h,"class"=>"bgc_".$sCls),
			getPixel(1,$gap).we_htmlElement::htmlBr().we_htmlElement::htmlDiv(array("id"=>$iId."_content"),((isset($oContent))? $oContent->getHtmlCode() : "")).
			we_htmlElement::htmlHidden(array("id"=>$iId."_prefix","value"=>$aLabel[0])).
			we_htmlElement::htmlHidden(array("id"=>$iId."_postfix","value"=>$aLabel[1])).
			we_htmlElement::htmlHidden(array("id"=>$iId."_res","value"=>$iRes)).
			we_htmlElement::htmlHidden(array("id"=>$iId."_type","value"=>$sType)).
			we_htmlElement::htmlHidden(array("id"=>$iId."_cls","value"=>$sCls)).
			we_htmlElement::htmlHidden(array("id"=>$iId."_csv","value"=>$sCsv))
		);
		$oBox->setCol(2,2,array("id"=>$iId."_vlr","align"=>"right","width"=>$wh_edge,"height"=>$h,"class"=>"bgc_".$sCls),we_htmlElement::htmlNobr(getPixel(10,1).we_htmlElement::htmlImg(array("id"=>$iId."_vline_r","src"=>IMAGE_DIR."pd/line_v.gif","style"=>"width:1px;height:".$h."px;"))));
		$oBox->setCol(3,0,array("width"=>$wh_edge,"height"=>$wh_edge),we_htmlElement::htmlImg(array("id"=>$iId."_img_cl","src"=>IMAGE_DIR."pd/bx_corner_left_".$sCls.".gif","width"=>$wh_edge,"height"=>$wh_edge)));
		$oBox->setCol(3,1,array("id"=>$iId."_bottom","valign"=>"bottom","width"=>"100%","height"=>$wh_edge,"class"=>"bgc_".$sCls),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR."pd/line_h.gif","width"=>"100%","height"=>1)));
		$oBox->setCol(3,2,array("width"=>$wh_edge,"height"=>$wh_edge),we_htmlElement::htmlImg(array("id"=>$iId."_img_cr","src"=>IMAGE_DIR."pd/bx_corner_right_".$sCls.".gif","width"=>$wh_edge,"height"=>$wh_edge)));

		return $oBox;
	}

}

?>