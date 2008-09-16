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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/banner/weBanner.php");

function we_tag_banner($attribs, $content){
 	global $DB_WE;
	$foo = attributFehltError($attribs,"name","banner");if($foo) return $foo;
 	
	$bannername = we_getTagAttribute("name",$attribs);
	$paths = we_getTagAttribute("paths",$attribs);
	$type = we_getTagAttribute("type",$attribs,"js");
	$target = we_getTagAttribute("target",$attribs);
	$width = we_getTagAttribute("width",$attribs,($type == "pixel") ? "1" : "");
	$height = we_getTagAttribute("height",$attribs,($type == "pixel") ? "1" : "");
	$link = we_getTagAttribute("link",$attribs,"",true,true);
	$page = we_getTagAttribute("page",$attribs);	$pixel = we_getTagAttribute("page",$attribs,"",true);
	$bannerclick = we_getTagAttribute("clickscript",$attribs,"/webEdition/bannerclick.php");
	$getbanner = we_getTagAttribute("getscript",$attribs,"/webEdition/getBanner.php");
    $xml = we_getTagAttribute('xml', $attribs,'',true);
	
	$nocount = $GLOBALS["WE_MAIN_DOC"]->InWebEdition;
	
	if($type=="pixel"){
	    
	    $newAttribs['src']    = $getbanner.'?'.($nocount ? 'nocount='.$nocount.'&amp;' : '').'type=pixel&amp;paths='.rawurlencode($paths).'&amp;bannername='.rawurlencode($bannername).'&amp;cats='.rawurlencode($GLOBALS["WE_MAIN_DOC"]->Category).'&amp;dt='.(isset($GLOBALS["WE_MAIN_DOC"]->DocType) ? rawurlencode($GLOBALS["WE_MAIN_DOC"]->DocType) : "").($page ? ('&amp;page='.rawurlencode($page)) : ('&amp;did='.$GLOBALS["WE_MAIN_DOC"]->ID)).'&amp;xml='.($xml ? "1" : "0");
	    $newAttribs['border'] = 0;
	    $newAttribs['alt']    = '';
	    $newAttribs['width']  = 1;
	    $newAttribs['height'] = 1;
	    
	    return getHtmlTag('img', $newAttribs);
	}
	
	$uniq = md5 (uniqid (rand()));
	
	// building noscript ...
	// here build image with link(opt)
	$imgAtts['src'] = $getbanner.'?c=1&amp;bannername='.rawurlencode($bannername).'&amp;cats='.rawurlencode(isset($GLOBALS["WE_MAIN_DOC"]->Category) ? $GLOBALS["WE_MAIN_DOC"]->Category : "").'&amp;dt='.rawurlencode(isset($GLOBALS["WE_MAIN_DOC"]->DocType) ? $GLOBALS["WE_MAIN_DOC"]->DocType : "").'&amp;paths='.rawurlencode($paths).($page ? ('&amp;page='.rawurlencode($page)) : ('&amp;did='.$GLOBALS["WE_MAIN_DOC"]->ID)).'&amp;bannerclick='.rawurlencode($bannerclick).'&amp;xml='.($xml ? "1" : "0");
	$imgAtts['alt'] = '';
	$imgAtts['border'] = 0;
	if($width){
	   $imgAtts['width'] = $width;
	}
	if($height){
	   $imgAtts['height'] = $height;
	}
	$img = getHtmlTag('img',$imgAtts);
	
	if($link){ //  with link
	    $linkAtts['href'] = $bannerclick.'?'.($nocount ? 'nocount='.$nocount.'&amp;' : '').'u='.$uniq.'&amp;bannername='.rawurlencode($bannername).($page ? ('&amp;page='.rawurlencode($page)) : ('&amp;did='.$GLOBALS["WE_MAIN_DOC"]->ID));
	    if($target){
	        $linkAtts['target'] = $target;
	    }
	    $noscript = getHtmlTag('a',$linkAtts,$img);
	} else {   //  only img
	    $noscript = $img;
	}


	if($type=="iframe"){
	    
	    // stuff for iframe ... and ilayer ...
        $newAttribs = removeAttribs($attribs, array('name','paths','type','target','link','clickscript','getscript','page'));
	    $newAttribs['xml'] = $xml ? "true" : "false";
	    $newAttribs['width'] = $width ?  $width : 468;
	    $newAttribs['height'] = $height ?  $height : 60;
	    $newAttribs['src'] = $getbanner.'?'.($nocount ? 'nocount='.$nocount.'&amp;' : '').'bannername='.rawurlencode($bannername).'&amp;cats='.rawurlencode($GLOBALS["WE_MAIN_DOC"]->Category).'&amp;link='.($link ? 1 : 0).'&amp;type=iframe'.($page ? ('&amp;page='.rawurlencode($page)) : ('&amp;did='.$GLOBALS["WE_MAIN_DOC"]->ID.'&amp;paths='.rawurlencode($paths))).'&amp;target='.rawurlencode($target).'&amp;bannerclick='.rawurlencode($bannerclick).'&amp;width='.rawurlencode($width).'&amp;height='.rawurlencode($height).'&amp;xml='.($xml ? "1" : "0");
		
		// content
		//$content = getHtmlTag('ilayer',$newAttribs, '',true) . getHtmlTag('nolayer', array(),$noscript);    // WITH ilayer not conform !!!
		//$content = getHtmlTag('nolayer', array(),$noscript);    //  nolayer does not exist
		$content = $noscript;
		
		//    some more attribs for the iframe
		$newAttribs['marginwidth'] = 0;
		$newAttribs['marginheight'] = 0;
		//$newAttribs['vspace'] = 0;
		//$newAttribs['hspace'] = 0;
		$newAttribs['frameborder'] = 0;
		$newAttribs['scrolling'] = 'no';
		
		return getHtmlTag('iframe',$newAttribs, $content);
		
	}else{
		if($GLOBALS["WE_MAIN_DOC"]->IsDynamic){
			return weBanner::getBannerCode($GLOBALS["WE_MAIN_DOC"]->ID,$paths,$target,$width,$height,$GLOBALS["WE_MAIN_DOC"]->DocType,$GLOBALS["WE_MAIN_DOC"]->Category,$bannername,$link,"",$bannerclick,$getbanner,"",$page, $GLOBALS["WE_MAIN_DOC"]->InWebEdition,$xml);
		}else{
			if($type ==  "cookie"){
				return $noscript;
			}else{
				return 	'<script language="JavaScript" type="text/javascript">
<!--
	r = Math.random();
   document.write ("<" + "script language=\"JavaScript\" type=\"text/javascript\" src=\"'.$getbanner.'?'.($nocount ? 'nocount='.$nocount.'&amp;' : '').'r="+r+"&amp;link='.($link ? 1 : 0).'&amp;bannername='.rawurlencode($bannername).'&amp;type=js'.($page ? ('&amp;page='.rawurlencode($page)) : ('&amp;did='.$GLOBALS["WE_MAIN_DOC"]->ID.'&amp;paths='.rawurlencode($paths))).'&amp;target='.rawurlencode($target).'&amp;bannerclick='.rawurlencode($bannerclick).'&amp;height='.rawurlencode($height).'&amp;width='.rawurlencode($width).'"+(document.referer ? ("&amp;referer="+escape(document.referer)) : "")+"\"><" + "/script>");
//-->
</script><noscript>'.$noscript.'</noscript>
';

			}
		}
	}
	
}
?>