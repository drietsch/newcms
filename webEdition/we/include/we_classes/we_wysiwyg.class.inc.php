<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/css/css.inc.php");

class we_wysiwyg{

	var $name = "";
	var $width = "";
	var $height = "";
	var $ref = "";
	var $propstring = "";
	var $elements = array();
	var $value = "";
	var $filteredElements = array();
	var $bgcol = "white";
	var $fullscreen = "";
	var $className = "";
	var $fontnames = array();
	var $maxGroupWidth = 0;
	var $outsideWE =false;
	var $xml = false;
	var $removeFirstParagraph = true;
	var $charset = "";
	var $inlineedit = true;
	var $cssClasses = "";
	var $Language = "";

	var $_imagePath;
	var $_image_languagePath;
	var $baseHref = "";
	var $showSpell = true;
	var $isFrontendEdit = false;

	function we_wysiwyg($name,$width,$height,$value="",$propstring="",$bgcol="",$fullscreen="",$className="",$fontnames="",$outsideWE=false,$xml=false,$removeFirstParagraph=true,$inlineedit=true,$baseHref="",$charset="",$cssClasses="", $Language="", $test="",$spell=true, $isFrontendEdit=false){

		$this->propstring = $propstring ? ",".$propstring."," : "";
		$this->name = $name;
		$this->bgcol = $bgcol;
		$this->xml = $xml;
		$this->removeFirstParagraph = $removeFirstParagraph;
		$this->inlineedit = $inlineedit;
		$this->fullscreen = $fullscreen;
		$this->className = $className;
		$this->outsideWE = $outsideWE;
		$fn = $fontnames ? explode(",",$fontnames) : array("Arial, Helvetica, sans-serif","Courier New, Courier, mono","Geneva, Arial, Helvetica, sans-serif", "Georgia, Times New Roman, Times, serif", "Tahoma", "Times New Roman, Times, serif","Verdana, Arial, Helvetica, sans-serif","Wingdings");
		$this->cssClasses = $cssClasses;
		$this->Language = $Language;
		$this->showSpell = $spell;
		$this->isFrontendEdit = $isFrontendEdit;
		foreach($fn as $i=>$font){
			$fn[$i] = strtolower(str_replace(";",",",$font));
		}

		$this->_imagePath = IMAGE_DIR . "wysiwyg/";
		$this->_image_languagePath = WEBEDITION_DIR . "we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg/";

		$this->fontnames = array();


		$this->baseHref = $baseHref ? $baseHref : we_getGlobalPath();
		$this->charset = $charset;


		foreach($fn as $font){
			$this->fontnames[$font] = $font;
		}

		$this->width = $width;
		$this->height = $height;
		$this->ref = eregi_replace('[^0-9a-zA-Z_]','',$this->name);
		$this->hiddenValue = $value;

		if($inlineedit){
			if($value){
				$value = str_replace("\\","\\\\",$value);
				$value = str_replace("\n","\\n",$value);
				$value = str_replace("\r","\\r",$value);
				$value = ereg_replace("script","##scr#ipt##",$value);
				$value = ereg_replace("Script","##Scr#ipt##",$value);
				$value = ereg_replace("SCRIPT","##SCR#IPT##",$value);
				$value = eregi_replace('<\?xml[^>]*>',"",$value);
				$value = eregi_replace("<\?","||##?##||",$value);
				$value = eregi_replace("\?>","##||?||##",$value);
			}
		}

		$this->setToolbarElements();
		$this->setFilteredElements();
		$this->getMaxGroupWidth();
		$this->value = $value;

	}

	function getMaxGroupWidth(){
		$w = 0;
		foreach($this->filteredElements as $i=>$v){
			if($v->classname == "we_wysiwygToolbarSeparator"){
				$this->maxGroupWidth = max($w,$this->maxGroupWidth);
				$w = 0;
			}else{
				$w += $v->width;
			}
		}
		$this->maxGroupWidth = max($w,$this->maxGroupWidth);
	}

	function getHeaderHTML(){
		if(!defined("WE_WYSIWG_HEADER")){
			define("WE_WYSIWG_HEADER",1);
			return '<iframe id="we_wysiwyg_lng_frame" src="/webEdition/wysiwyg/weWysiwygLang.php" style="display:none;"></iframe>
				<style type="text/css">
					.tbButton {
						border: 1px solid #F4F4F4;
						padding: 0px;
						margin: 0px;
						text-align: left;
						text-decoration: none;
						position: relative;
						-moz-user-select: none;
					}

					.tbButtonMouseOverUp {
    					border-bottom: 1px solid #000000;
    					border-left: 1px solid #CCCCCC;
    					border-right: 1px solid #000000;
    					border-top: 1px solid #CCCCCC;
    					cursor:pointer;
						margin: 0px;
						padding:0px;
						text-align: left;
						text-decoration: none;
						position: relative;
						-moz-user-select: none;
					}
					.tbButtonMouseOverDown {
    					border-bottom: 1px solid #CCCCCC;
    					border-left: 1px solid #000000;
    					border-right: 1px solid #CCCCCC;
    					border-top: 1px solid #000000;
    					cursor: pointer;
						margin: 0px;
						padding: 0px;
						text-align: left;
						text-decoration: none;
						position: relative;
						-moz-user-select: none;
					}
					.tbButtonDown {
    					background-image: url(' . IMAGE_DIR . 'java_menu/background_dark.gif);
    					border-bottom: #CCCCCC solid 1px;
    					border-left: #000000 solid 1px;
    					border-right: #CCCCCC solid 1px;
    					border-top:  #000000 solid 1px;
						margin: 0px;
						padding:0px;
						text-align: left;
						text-decoration: none;
						position: relative;
						-moz-user-select: none;
					}
					.tbButtonsHR {
    					border-top:  #000000 solid 1px;
    					border-bottom:  #CCCCCC solid 1px;
						margin: 0px;
						padding:0px;
						text-align: left;
						text-decoration: none;
						position: relative;
						-moz-user-select: none;
					}
					.tbButtonWysiwygBorder
					{
						border: 1px solid #006DB8;
					    background-image: url(/webEdition/images/pixel.gif);
						margin: 0px;
						padding:4px;
						text-align: left;
						text-decoration: none;
						position: relative;
					}
					.tbButtonWysiwygBackground{
						background-image: url(/webEdition/images/backgrounds/aquaBackground.gif) ! important;
					}
					.tbButtonWysiwygDefaultStyle{
						background: transparent;
						background-color: transparent;
						background-image: url(/webEdition/images/pixel.gif);
						border: 0px;
						color: #000000;
						cursor: default;
						font-size: '.(($GLOBALS["SYSTEM"] == "MAC") ? "11px" : (($GLOBALS["SYSTEM"] == "X11") ? "13px" : "12px")).';
						font-family: '.$GLOBALS["l_css"]["font_family"].';
						font-weight: normal;
						margin: 0px;
						padding:0px;
						text-align: left;
						text-decoration: none;
						-moz-user-select: text;
						left: auto ! important;
						right: auto ! important;
						width: auto ! important;
						height: auto ! important;
					}

				</style>

				<script language="JavaScript" type="text/javascript"><!--

					var we_wysiwygs = new Array();
					var we_wysiwyg_lng = new Array();
					var isGecko = false;
					var weWysiwygLoaded = false;
					var weNodeList = new Array();
					var weWysiwygFolderPath = "/webEdition/wysiwyg/";
					var weWysiwygImagesFolderPath = "/webEdition/images/wysiwyg/";
					var weWysiwygBgGifPath = "' . IMAGE_DIR .'backgrounds/aquaBackground.gif";
					var weWysiwygIsIntialized = false;

					var wePopupMenuArray = new Array();

                    //  Bugfix do not overwrite body.onload !!!
                    function weEvent(){}
                    weEvent.addEvent = function(e, name, f) {
                        if (e.addEventListener) {
                            e.addEventListener(
                                name,
                                f,
                                true);
                        }
                        if(e.attachEvent){
                            e.attachEvent("on" + name, f);
                        }
                    }

					//window.onerror = weNothing;
                    //  Bugfix do not overwrite body.onload !!!
                    weEvent.addEvent(window,"load", weWysiwygInitializeIt);
					//window.onload = weWysiwygInitializeIt + window.onload;

					function weNothing() {
						return true;
					}

					if (navigator.product == \'Gecko\') {
						isGecko = true;
					}

					function weWysiwygInitializeIt() {
						for (var i=0;i<we_wysiwygs.length;i++) {
							we_wysiwygs[i].start();
						}
						for (var i=0;i<we_wysiwygs.length;i++) {
							we_wysiwygs[i].finalize();
 							we_wysiwygs[i].windowFocus();
							we_wysiwygs[i].setButtonsState();
						}
						self.focus();
						weWysiwygIsIntialized = true;
					}

					function weWysiwygSetHiddenText() {
    					try {
    						if (weWysiwygIsIntialized) {
    							for (var i = 0; i < we_wysiwygs.length; i++) {
    								we_wysiwygs[i].setHiddenText();
    							}
    						}
    					} catch(e) {
							// Nothing
    					}
					}


				-->
				</script>' .
				'<script language="JavaScript" type="text/javascript" src="' . JS_DIR . '/we_showMessage.js"></script>'
				.
					($GLOBALS["SAFARI_WYSIWYG"]
						? '<script language="JavaScript" type="text/javascript" src="/webEdition/wysiwyg/weWysiwygSafari.js?'.WE_VERSION.'"></script>' .
						  '<script language="JavaScript" type="text/javascript" src="/webEdition/js/weDOM_Safari.js?'.WE_VERSION.'"></script>'
						: '<script language="JavaScript" type="text/javascript" src="/webEdition/wysiwyg/weWysiwyg.js?'.WE_VERSION.'"></script>') . "\n";
		} else {
			return "";
		}
	}

	function getAllCmds(){
		$arr = array(	"formatblock",
						"fontname",
						"fontsize",
						"applystyle",
						"bold",
						"italic",
						"underline",
						"subscript",
						"superscript",
						"strikethrough",
						"removeformat",
						"forecolor",
						"backcolor",
						"justifyleft",
						"justifycenter",
						"justifyright",
						"justifyfull",
						"insertunorderedlist",
						"insertorderedlist",
						"indent",
						"outdent",
						"createlink",
						"unlink",
						"anchor",
						"insertimage",
						"inserthorizontalrule",
						"insertspecialchar",
						"inserttable",
						"edittable",
						"editcell",
						"insertcolumnright",
						"insertcolumnleft",
						"insertrowabove",
						"insertrowbelow",
						"deletecol",
						"deleterow",
						"increasecolspan",
						"decreasecolspan",
						"caption",
						"removecaption",
						"importrtf",
						"fullscreen",
						"cut",
						"copy",
						"paste",
						"undo",
						"redo",
						"visibleborders",
						"editsource",
						"insertbreak",
						"acronym",
						"abbr",
						"lang"
				);
		if(defined('SPELLCHECKER')) {
			$arr[] = "spellcheck";
		}
		return $arr;

	}

	function setToolbarElements(){

		global $SAFARI_WYSIWYG;


			array_push(
						$this->elements,
						new we_wysiwygToolbarSelect(
														$this,
														"formatblock",
														$GLOBALS["l_wysiwyg"]["format"],
														($GLOBALS["BROWSER"] == "IE") ? array(
															"normal"=>$GLOBALS["l_wysiwyg"]["normal"],
															"h1"=>$GLOBALS["l_wysiwyg"]["h1"],
															"h2"=>$GLOBALS["l_wysiwyg"]["h2"],
															"h3"=>$GLOBALS["l_wysiwyg"]["h3"],
															"h4"=>$GLOBALS["l_wysiwyg"]["h4"],
															"h5"=>$GLOBALS["l_wysiwyg"]["h5"],
															"h6"=>$GLOBALS["l_wysiwyg"]["h6"],
															"pre"=>$GLOBALS["l_wysiwyg"]["pre"],
															"address"=>$GLOBALS["l_wysiwyg"]["address"]
														) : ($SAFARI_WYSIWYG ? array(
															"div"=>$GLOBALS["l_wysiwyg"]["normal"],
															"p"=>$GLOBALS["l_wysiwyg"]["paragraph"],
															"h1"=>$GLOBALS["l_wysiwyg"]["h1"],
															"h2"=>$GLOBALS["l_wysiwyg"]["h2"],
															"h3"=>$GLOBALS["l_wysiwyg"]["h3"],
															"h4"=>$GLOBALS["l_wysiwyg"]["h4"],
															"h5"=>$GLOBALS["l_wysiwyg"]["h5"],
															"h6"=>$GLOBALS["l_wysiwyg"]["h6"],
															"pre"=>$GLOBALS["l_wysiwyg"]["pre"],
															"address"=>$GLOBALS["l_wysiwyg"]["address"],
															"blockquote"=>"blockquote"
														) : array(
															"normal"=>$GLOBALS["l_wysiwyg"]["normal"],
															"p"=>$GLOBALS["l_wysiwyg"]["paragraph"],
															"h1"=>$GLOBALS["l_wysiwyg"]["h1"],
															"h2"=>$GLOBALS["l_wysiwyg"]["h2"],
															"h3"=>$GLOBALS["l_wysiwyg"]["h3"],
															"h4"=>$GLOBALS["l_wysiwyg"]["h4"],
															"h5"=>$GLOBALS["l_wysiwyg"]["h5"],
															"h6"=>$GLOBALS["l_wysiwyg"]["h6"],
															"pre"=>$GLOBALS["l_wysiwyg"]["pre"],
															"address"=>$GLOBALS["l_wysiwyg"]["address"],
															"code"=>"Code",
															"cite"=>"Cite",
															"q"=>"q",
															"blockquote"=>"blockquote"
														)),
														120
													)
					);
			array_push(
						$this->elements,
						new we_wysiwygToolbarSelect(
														$this,
														"fontname",
														$GLOBALS["l_wysiwyg"]["fontname"],
														$this->fontnames,
														120
													)
					);
			array_push(
						$this->elements,
						new we_wysiwygToolbarSelect(
														$this,
														"fontsize",
														$GLOBALS["l_wysiwyg"]["fontsize"],
														$SAFARI_WYSIWYG ? array(
															"8px"=>"8px",
															"9px"=>"9px",
															"10px"=>"10px",
															"11px"=>"11px",
															"12px"=>"12px",
															"13px"=>"13px",
															"14px"=>"14px",
															"15px"=>"15px",
															"16px"=>"16px",
															"17px"=>"17px",
															"18px"=>"18px",
															"19px"=>"19px",
															"20px"=>"20px",
															"21px"=>"21px",
															"22px"=>"22px",
															"24px"=>"24px",
															"26px"=>"26px",
															"28px"=>"28px",
															"30px"=>"30px",
															"36px"=>"36px"
														) : array(
															"1"=>"1",
															"2"=>"2",
															"3"=>"3",
															"4"=>"4",
															"5"=>"5",
															"6"=>"6",
															"7"=>"7"
														),
														120
													)
					);
			array_push(
						$this->elements,
						new we_wysiwygToolbarSelect(
														$this,
														"applystyle",
														$GLOBALS["l_wysiwyg"]["css_style"],
														array(),
														120
													)
					);
			array_push(
						$this->elements,
						new we_wysiwygToolbarSeparator($this)
					);


		array_push(
					$this->elements,

					new we_wysiwygToolbarButton(
													$this,
													"bold",
													$this->_image_languagePath."bold.gif",
													$GLOBALS["l_wysiwyg"]["bold"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"italic",
													$this->_image_languagePath."italic.gif",
													$GLOBALS["l_wysiwyg"]["italic"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"underline",
													$this->_image_languagePath."underline.gif",
													$GLOBALS["l_wysiwyg"]["underline"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"subscript",
													$this->_imagePath."subscript.gif",
													$GLOBALS["l_wysiwyg"]["subscript"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"superscript",
													$this->_imagePath."superscript.gif",
													$GLOBALS["l_wysiwyg"]["superscript"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"strikethrough",
													$this->_imagePath."strikethrough.gif",
													$GLOBALS["l_wysiwyg"]["strikethrough"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"removeformat",
													$this->_imagePath."removeformat.gif",
													$GLOBALS["l_wysiwyg"]["removeformat"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"acronym",
													$this->_image_languagePath."acronym.gif",
													$GLOBALS["l_wysiwyg"]["acronym"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"abbr",
													$this->_image_languagePath."abbr.gif",
													$GLOBALS["l_wysiwyg"]["abbr"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"lang",
													$this->_imagePath."lang.gif",
													$GLOBALS["l_wysiwyg"]["language"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"forecolor",
													$this->_imagePath."setforecolor.gif",
													$GLOBALS["l_wysiwyg"]["fore_color"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"backcolor",
													$this->_imagePath."setbackcolor.gif",
													$GLOBALS["l_wysiwyg"]["back_color"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"justifyleft",
													$this->_imagePath."justifyleft.gif",
													$GLOBALS["l_wysiwyg"]["justify_left"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"justifycenter",
													$this->_imagePath."justifycenter.gif",
													$GLOBALS["l_wysiwyg"]["justify_center"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"justifyright",
													$this->_imagePath."justifyright.gif",
													$GLOBALS["l_wysiwyg"]["justify_right"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"justifyfull",
													$this->_imagePath."justifyfull.gif",
													$GLOBALS["l_wysiwyg"]["justify_full"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertunorderedlist",
													$this->_imagePath."unorderlist.gif",
													$GLOBALS["l_wysiwyg"]["unordered_list"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertorderedlist",
													$this->_imagePath."orderlist.gif",
													$GLOBALS["l_wysiwyg"]["ordered_list"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"indent",
													$this->_imagePath."indent.gif",
													$GLOBALS["l_wysiwyg"]["indent"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"outdent",
													$this->_imagePath."outdent.gif",
													$GLOBALS["l_wysiwyg"]["outdent"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"createlink",
													$this->_imagePath."hyperlink.gif",
													$GLOBALS["l_wysiwyg"]["hyperlink"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"unlink",
													$this->_imagePath."unlink.gif",
													$GLOBALS["l_wysiwyg"]["unlink"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"anchor",
													$this->_imagePath."anchor.gif",
													$GLOBALS["l_wysiwyg"]["insert_edit_anchor"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertimage",
													$this->_imagePath."image.gif",
													$GLOBALS["l_wysiwyg"]["insert_edit_image"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"inserthorizontalrule",
													$this->_imagePath."rule.gif",
													$GLOBALS["l_wysiwyg"]["inserthorizontalrule"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertspecialchar",
													$this->_imagePath."specialchar.gif",
													$GLOBALS["l_wysiwyg"]["insertspecialchar"]
												)
				);
			array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"inserttable",
													$this->_imagePath."inserttable.gif",
													$GLOBALS["l_wysiwyg"]["inserttable"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"edittable",
													$this->_imagePath."edittable.gif",
													$GLOBALS["l_wysiwyg"]["edittable"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"editcell",
													$this->_imagePath."editcell.gif",
													$GLOBALS["l_wysiwyg"]["editcell"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertcolumnleft",
													$this->_imagePath."insertcol_left.gif",
													$GLOBALS["l_wysiwyg"]["insertcolumnleft"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertcolumnright",
													$this->_imagePath."insertcol_right.gif",
													$GLOBALS["l_wysiwyg"]["insertcolumnright"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertrowabove",
													$this->_imagePath."insertrow_above.gif",
													$GLOBALS["l_wysiwyg"]["insertrowabove"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertrowbelow",
													$this->_imagePath."insertrow_below.gif",
													$GLOBALS["l_wysiwyg"]["insertrowbelow"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"deletecol",
													$this->_imagePath."deletecols.gif",
													$GLOBALS["l_wysiwyg"]["deletecol"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"deleterow",
													$this->_imagePath."deleterows.gif",
													$GLOBALS["l_wysiwyg"]["deleterow"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"increasecolspan",
													$this->_imagePath."inc_col.gif",
													$GLOBALS["l_wysiwyg"]["increasecolspan"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"decreasecolspan",
													$this->_imagePath."dec_col.gif",
													$GLOBALS["l_wysiwyg"]["decreasecolspan"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"caption",
													$this->_imagePath."caption.gif",
													$GLOBALS["l_wysiwyg"]["addcaption"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"removecaption",
													$this->_imagePath."removecaption.gif",
													$GLOBALS["l_wysiwyg"]["removecaption"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		if((isset($GLOBALS["IE55"]) && $GLOBALS["IE55"]) || (isset($GLOBALS["SAFARI_WYSIWYG"]) && $GLOBALS["SAFARI_WYSIWYG"])){
			array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"insertbreak",
													$this->_imagePath."br.gif",
													$GLOBALS["l_wysiwyg"]["insert_br"]
												)
				);
		}

		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
		);

		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"importrtf",
													$this->_imagePath."rtf.gif",
													$GLOBALS["l_wysiwyg"]["rtf_import"]
												)
				);
		if(!$this->fullscreen){
			array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"fullscreen",
													$this->_imagePath."fullscreen.gif",
													$GLOBALS["l_wysiwyg"]["fullscreen"]
												)
				);
		}
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);

		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"cut",
													$this->_imagePath."cut.gif",
													$GLOBALS["l_wysiwyg"]["cut"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"copy",
													$this->_imagePath."copy.gif",
													$GLOBALS["l_wysiwyg"]["copy"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"paste",
													$this->_imagePath."paste.gif",
													$GLOBALS["l_wysiwyg"]["paste"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"undo",
													$this->_imagePath."undo.gif",
													$GLOBALS["l_wysiwyg"]["undo"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"redo",
													$this->_imagePath."redo.gif",
													$GLOBALS["l_wysiwyg"]["redo"]
												)
				);

		array_push(
					$this->elements,
					new we_wysiwygToolbarSeparator($this)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"visibleborders",
													$this->_imagePath."visibleborders.gif",
													$GLOBALS["l_wysiwyg"]["visible_borders"]
												)
				);
		array_push(
					$this->elements,
					new we_wysiwygToolbarButton(
													$this,
													"editsource",
													$this->_imagePath."editsourcecode.gif",
													$GLOBALS["l_wysiwyg"]["edit_sourcecode"]
												)
				);
		if(defined('SPELLCHECKER') && $this->showSpell) {
			array_push(
						$this->elements,
						new we_wysiwygToolbarButton(
														$this,
														'spellcheck',
														$this->_imagePath . 'spellcheck.gif',
														$GLOBALS['l_wysiwyg']['spellcheck']
													)
					);
		}

	}

	function getWidthOfElem($startPos,$end){
		$w = 0;
		for($i=$startPos;$i<=$end;$i++){
			$w += $this->filteredElements[$i]->width;
		}
		return $w;
	}

	function setFilteredElements(){
		$lastSep = true;
		foreach($this->elements as $i=>$elem){
			if($elem->showMe){
				if((!$lastSep) || ($elem->classname != "we_wysiwygToolbarSeparator")){
					array_push($this->filteredElements,$elem);
				}
				$lastSep = ($elem->classname == "we_wysiwygToolbarSeparator");
			}
		}
		if(sizeof($this->filteredElements)){
			if($this->filteredElements[sizeof($this->filteredElements)-1]->classname == "we_wysiwygToolbarSeparator"){
				array_pop($this->filteredElements);
			}
		}
	}


	function hasSep($rowArr){
		foreach($rowArr as $i=>$elem){
			if($elem->classname == "we_wysiwygToolbarSeparator") return true;
		}
		return false;
	}

	function getEditButtonHTML(){

		list($tbwidth,$tbheight) = $this->getToolbarWidthAndHeight();

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
		$we_button = new we_button();
		$fns = "";
		foreach($this->fontnames as $fn){
			$fns .= str_replace(",",";",$fn).",";
		}
		$fns = ereg_replace('(.+),$','\1',$fns);
		return $we_button->create_button("image:btn_edit_edit", "javascript:we_cmd('open_wysiwyg_window', '".$this->name."', '".max(220,$this->width)."', '".$this->height."','".$GLOBALS["we_transaction"]."','".$this->propstring."','".$this->className."','".$fns."','".$this->outsideWE."','".$tbwidth."','".$tbheight."','".$this->xml."','".$this->removeFirstParagraph."','".$this->bgcol."','".$this->baseHref."','".$this->charset."','".$this->cssClasses."','".$this->Language."');",true,25);
	}

	function getHTML(){
		if($this->inlineedit){
			return $this->getInlineHTML();
		}else{
			return $this->getEditButtonHTML();
		}
	}


	function getToolbarRows(){
		$tmpElements = $this->filteredElements;
		$rows = array();
		$rownr = 0;
		$rows[$rownr] = array();
		$rowwidth = 0;
		while(sizeof($tmpElements)){
			if(!$this->hasSep($rows[$rownr]) || $rowwidth <= max($this->width,$this->maxGroupWidth)){
				array_push($rows[$rownr],array_shift($tmpElements));
				$rowwidth += $rows[$rownr][sizeof($rows[$rownr])-1]->width;
			}else{
				if(sizeof($rows[$rownr])){
					if($rows[$rownr][sizeof($rows[$rownr])-1]->classname == "we_wysiwygToolbarSeparator"){
						array_pop($rows[$rownr]);
						$rownr++;
						$rowwidth = 0;
						$rows[$rownr] = array();
					}else{
						while($tmpElements[0]->classname != "we_wysiwygToolbarSeparator"){
							array_unshift($tmpElements,array_pop($rows[$rownr]));
						}
						array_shift($tmpElements);
						$rownr++;
						$rowwidth = 0;
						$rows[$rownr] = array();
					}
				}
			}

		}
		return $rows;
	}

	function getToolbarWidthAndHeight(){

		$rows = $this->getToolbarRows();
		$toolbarheight = 0;
		$min_w = 0;
		$row_w = 0;
		for($r=0;$r<sizeof($rows);$r++){
			$rowheight = 0;
			for($s=0;$s<sizeof($rows[$r]);$s++){
				$rowheight = max($rowheight,$rows[$r][$s]->height);
				$row_w += $rows[$r][$s]->width;
			}
			$toolbarheight += ($rowheight + 2);
			$min_w = max($min_w,$row_w);
			$row_w = 0;
		}

		$realWidth = max($min_w,$this->width);
		return array($realWidth,$toolbarheight);

	}

	function getInlineHTML(){

		$rows = $this->getToolbarRows();
		$editValue = $this->value;

		if(preg_match_all('/src="document:([^" ]+)/i',$editValue,$regs,PREG_SET_ORDER)){
			for($i=0;$i<sizeof($regs);$i++){
				$foo = getHash("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".$regs[$i][1]."'",$GLOBALS["DB_WE"]);
				$editValue = eregi_replace('src="document:'.$regs[$i][1],'src="'.$foo["Path"]."?id=".$regs[$i][1],$editValue);
			}
		}
		if(preg_match_all('/src="thumbnail:([^" ]+)/i',$editValue,$regs,PREG_SET_ORDER)){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
			for($i=0;$i<sizeof($regs);$i++){
				list($imgID,$thumbID) = explode(",",$regs[$i][1]);
				$thumbObj = new we_thumbnail();
				$thumbObj->initByImageIDAndThumbID($imgID,$thumbID);
				$editValue = eregi_replace('src="thumbnail:'.$regs[$i][1],'src="'.$thumbObj->getOutputPath()."?thumb=".$regs[$i][1],$editValue);
				unset($thumbObj);
			}
		}

		//parseInternalLinks($editValue,0);

		$min_w = 0;
		$row_w = 0;
		$pixelrow = '<tr><td background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif" unselectable="on" class="tbButtonWysiwygDefaultStyle tbButtonWysiwygBackground"><img src="/webEdition/images/pixel.gif" width="'.$this->width.'" height="2"  unselectable="on"></td></tr>';
		$linerow = '<tr><td unselectable="on"><div class="tbButtonsHR" unselectable="on" class="tbButtonWysiwygDefaultStyle"></div></td></tr>';
		$out = '<script language="JavaScript" type="text/javascript">var weLastPopupMenu = null; var wefoo = "'.$this->ref.'edit"; wePopupMenuArray[wefoo] = new Array();</script><table id="'.$this->ref.'edit_table" unselectable="on" border="0" cellpadding="0" cellspacing="0" width="'.$this->width.'" class="tbButtonWysiwygDefaultStyle"><tr><td unselectable="on" background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif" class="tbButtonWysiwygDefaultStyle tbButtonWysiwygBackground">
';
		for($r=0;$r<sizeof($rows);$r++){
			$out .= '<table border="0" cellpadding="0" cellspacing="0" unselectable="on" class="tbButtonWysiwygDefaultStyle">
	<tr>
';
			for($s=0;$s<sizeof($rows[$r]);$s++){
				$out .= '		<td unselectable="on" class="tbButtonWysiwygDefaultStyle">'.$rows[$r][$s]->getHTML().'</td>
';
				$row_w += $rows[$r][$s]->width;
			}
			$min_w = max($min_w,$row_w);
			$row_w = 0;
			$out .= '	</tr>
</table></td></tr>'.(($r < sizeof($rows)-1) ? $linerow : $pixelrow).'<tr><td unselectable="on"'.(($r<(sizeof($rows)-1)) ? (' bgcolor="white"  background="' . IMAGE_DIR . 'backgrounds/aquaBackground.gif"') : '').' class="tbButtonWysiwygDefaultStyle'.(($r<(sizeof($rows)-1)) ? ' tbButtonWysiwygBackground' : '').'">
';
		}

		$realWidth = max($min_w,$this->width);
		$out .= '<table border="0" cellpadding="0" cellspacing="0"  unselectable="on" class="tbButtonWysiwygDefaultStyle">
	<tr>
';
if (isset($GLOBALS["SAFARI_WYSIWYG"]) && $GLOBALS["SAFARI_WYSIWYG"]) {
	$out .= '		<td unselectable="on" class="tbButtonWysiwygDefaultStyle"><textarea wrap="off" style="color:black; display: none;font-family: courier; font-size: 10pt; width:'.$realWidth.'px; height:'.$this->height.'px;" id="'.$this->ref.'edit_src" name="'.$this->ref.'edit_src"></textarea><iframe src="/webEdition/wysiwyg/empty.html" style="display: block;color: black;border: 1px solid #A5ACB2;-khtml-user-select:none;" contenteditable unselectable="off"  width="'.$realWidth.'" height="'.$this->height.'" name="'.$this->ref.'edit" id="'.$this->ref.'edit" allowTransparency="true"></iframe></td>
';
} else {
	$out .= '		<td unselectable="on" class="tbButtonWysiwygDefaultStyle"><textarea wrap="off" style="color:black; display: none;font-family: courier; font-size: 10pt; width:'.$realWidth.'px; height:'.$this->height.'px;" id="'.$this->ref.'edit_src" name="'.$this->ref.'edit_src"></textarea><iframe style="display: block;color: black;border: 1px solid #A5ACB2;" contenteditable unselectable="off"  width="'.$realWidth.'" height="'.$this->height.'" name="'.$this->ref.'edit" id="'.$this->ref.'edit" allowTransparency="true"></iframe></td>
';
}
$out .='	</tr>
</table></td></tr></table><input type="hidden" id="'.$this->name.'" name="'.$this->name.'" value="'.htmlspecialchars($this->hiddenValue).'"><div id="'.$this->ref.'edit_buffer" style="display: none;"></div>
<script language="JavaScript" type="text/javascript">
var '.$this->ref.'Obj = null;
'.$this->ref.'Obj = new weWysiwyg("'.$this->ref.'edit","'.$this->name.'","'.str_replace("\"","\\\"",$this->value).'","'.str_replace("\"","\\\"",$editValue).'",\''.$this->fullscreen.'\',\''.$this->className.'\',\''.$this->propstring.'\',\''.$this->bgcol.'\','.($this->outsideWE ? "true" : "false").',"'.$this->baseHref.'","'.$this->xml.'","'.$this->removeFirstParagraph.'","'.$this->charset.'","'.$this->cssClasses.'","'.$this->Language.'", "'.($this->isFrontendEdit ? 1 : 0).'");
we_wysiwygs[we_wysiwygs.length] = '.$this->ref.'Obj;

function '.$this->ref.'editShowContextMenu(event){
	return '.$this->ref.'Obj.showContextMenu(event);
}
function '.$this->ref.'editonkeydown(){
	return we_on_key_down('.$this->ref.'Obj);
}
function '.$this->ref.'editonkeyup(){
	return we_on_key_up('.$this->ref.'Obj);
}
function '.$this->ref.'editonmouseup(){
	return we_on_mouse_up('.$this->ref.'Obj);
}
function '.$this->ref.'editonfocus(){
	return we_on_focus('.$this->ref.'Obj);
}
function '.$this->ref.'editonblur(){
	return we_on_blur('.$this->ref.'Obj);
}
</script>
';
		return $out;
	}


}


class we_wysiwygToolbarElement{

	var $width;
	var $height;
	var $cmd;
	var $editor;
	var $classname = "we_wysiwygToolbarElement";
	var $showMe = false;

	function we_wysiwygToolbarElement($editor,$cmd,$width,$height=""){
		$this->editor = $editor;
		$this->width = $width;
		$this->height = $height;
		$this->cmd = $cmd;
		$this->showMe = $this->hasProp();
	}

	function getHTML(){
		return "";
	}

	function hasProp(){
		return eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
	}
}

class we_wysiwygToolbarSeparator extends we_wysiwygToolbarElement{

	var $classname = "we_wysiwygToolbarSeparator";

	function we_wysiwygToolbarSeparator($editor,$width=3,$height=22){
		$this->we_wysiwygToolbarElement($editor,"",$width,$height);
	}

	function getHTML(){
		return '<div unselectable="on" style="border-right: #999999 solid 1px; font-size: 0px; height: '.$this->height.'px ! important; width: '.($this->width-1).'px;position: relative;" class="tbButtonWysiwygDefaultStyle"></div>';
	}
	function hasProp(){
		return true;
	}
}

class we_wysiwygToolbarButton extends we_wysiwygToolbarElement{

	var $classname = "we_wysiwygToolbarButton";

	var $tooltiptext="";
	var $imgSrc = "";

	function we_wysiwygToolbarButton($editor,$cmd,$imgSrc,$tooltiptext="",$width=25,$height=22){
		$this->we_wysiwygToolbarElement($editor,$cmd,$width,$height);
		$this->tooltiptext = $tooltiptext;
		$this->imgSrc = $imgSrc;
	}

	function getHTML(){

		if($GLOBALS["SAFARI_WYSIWYG"]){
			return '<div unselectable="on" id="'.$this->editor->ref.'edit_'.$this->cmd.'Div" class="tbButton">
<img unselectable="on" width="'.($this->width-2).'" height="'.$this->height.'" id="'.$this->editor->ref.'edit_'.$this->cmd.'" src="'.$this->imgSrc.'" alt="'.$this->tooltiptext.'" title="'.$this->tooltiptext.'"
onmouseover="'.$this->editor->ref.'Obj.over(\''.$this->cmd.'\');"
onmouseout="'.$this->editor->ref.'Obj.out(\''.$this->cmd.'\');"
onmousedown="'.$this->editor->ref.'Obj.click(event,\''.$this->cmd.'\');"></div>';
		} else {

			return '<div unselectable="on" id="'.$this->editor->ref.'edit_'.$this->cmd.'Div" class="tbButton">
<img unselectable="on" width="'.($this->width-2).'" height="'.$this->height.'" id="'.$this->editor->ref.'edit_'.$this->cmd.'" src="'.$this->imgSrc.'" alt="'.$this->tooltiptext.'" title="'.$this->tooltiptext.'"
onmouseover="'.$this->editor->ref.'Obj.over(\''.$this->cmd.'\');"
onmouseout="'.$this->editor->ref.'Obj.out(\''.$this->cmd.'\');"
onmousedown="'.$this->editor->ref.'Obj.check(\''.$this->cmd.'\');"
onmouseup="'.$this->editor->ref.'Obj.uncheck(\''.$this->cmd.'\');"
onclick="'.$this->editor->ref.'Obj.click(\''.$this->cmd.'\');"></div>';
		}
	}


	function hasProp(){
		switch($this->cmd){
			case "inserttable":
			case "edittable":
			case "editcell":
			case "insertcolumnright":
			case "insertcolumnleft":
			case "insertrowabove":
			case "insertrowbelow":
			case "deleterow":
			case "deletecol":
			case "increasecolspan":
			case "decreasecolspan":
			case "caption":
			case "removecaption":
				return eregi(",table,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "cut":
			case "copy":
			case "paste":
				return eregi(",copypaste,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "forecolor":
			case "backcolor":
				return eregi(",color,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "createlink":
			case "unlink":
				return eregi(",link,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "insertunorderedlist":
			case "insertorderedlist":
			case "indent":
			case "outdent":
				return eregi(",list,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "justifyleft":
			case "justifycenter":
			case "justifyright":
			case "justifyfull":
				return eregi(",justify,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			case "bold":
			case "italic":
			case "underline":
			case "subscript":
			case "superscript":
			case "strikethrough":
			case "removeformat":
				return eregi(",prop,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			default:
				return eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
		}
	}
}

class we_wysiwygToolbarSelect extends we_wysiwygToolbarElement{

	var $classname = "we_wysiwygToolbarSelect";

	var $title = "";
	var $vals = array();

	function we_wysiwygToolbarSelect($editor,$cmd,$title,$vals,$width=0,$height=20){
		$this->we_wysiwygToolbarElement($editor,$cmd,$width,$height);
		$this->title = $title;
		$this->vals = $vals;
	}
	function hasProp(){
		switch($this->cmd){
			case "fontname":
			case "fontsize":
			case "formatblock":
				return eregi(",font,",$this->editor->propstring) || eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
			default:
				return eregi(",".$this->cmd.",",$this->editor->propstring) || ($this->editor->propstring=="");
		}
	}

	function getHTML(){
		if ($GLOBALS["SAFARI_WYSIWYG"]) {
			$out = '<select id="'.$this->editor->ref.'_sel_'.$this->cmd.'" style="width:'.$this->width.'px;margin-right:3px;" size="1" onmousedown="'.$this->editor->ref.'Obj.saveSelection();" onmouseup="'.$this->editor->ref.'Obj.restoreSelection();" onchange="'.$this->editor->ref.'Obj.restoreSelection();'.$this->editor->ref.'Obj.selectChanged(\''.$this->cmd.'\',this.value);this.selectedIndex=0">';
			$out .= '<option value="">'.htmlspecialchars($this->title).'</option>'."\n";
 			foreach($this->vals as $val=>$txt){
				$out .= '<option value="'.htmlspecialchars($val).'">'.htmlspecialchars($txt).'</option>'."\n";
			}
			$out .= '</select>';
		} else {
			$out = '<table id="'.$this->editor->ref.'_sel_'.$this->cmd.'" unselectable="on" onclick="if('.$this->editor->ref.'Obj.menus[\''.$this->cmd.'\'].disabled==false){'.$this->editor->ref.'Obj.showPopupmenu(\''.$this->cmd.'\');}" class="tbButtonWysiwygDefaultStyle" width="'.$this->width.'" height="'.$this->height.'" cellpadding="0" cellspacing="0" border="0" title="'.($this->title).'" style="cursor:pointer;position: relative;">
	<tr>
		<td width="'.($this->width-20).'" style="padding-left:10px;background-image: url(' . IMAGE_DIR . 'wysiwyg/menuback.gif);" unselectable="on" class="tbButtonWysiwygDefaultStyle"><input value="'.htmlspecialchars($this->title).'" type="text" name="'.$this->editor->ref.'_seli_'.$this->cmd.'" id="'.$this->editor->ref.'_seli_'.$this->cmd.'" readonly="readonly" style="-moz-user-select:none;cursor:pointer;height:16px;width:'.($this->width-30).'px;border:0px;background-color:transparent;color:black;font: 10px Verdana, Arial, Helvetica, sans-serif;" unselectable="on" /></td>
		<td width="20" class="tbButtonWysiwygDefaultStyle"><img src="'.IMAGE_DIR.'wysiwyg/menudown.gif" width="20" height="20" alt=""></td>
	</tr>
</table><iframe src="/webEdition/html/blank.html" unselectable="on" width="280" height="160" id="'.$this->editor->ref.'edit_'.$this->cmd.'" style=" z-index: 100000;position: absolute; display:none;"></iframe>';
			$out .= '<script language="JavaScript" type="text/javascript">wePopupMenuArray[wefoo]["'.$this->cmd.'"] = new Array();';
 			foreach($this->vals as $val=>$txt){
				$out .= 'wePopupMenuArray[wefoo]["'.$this->cmd.'"]["'.$val.'"]="'.$txt.'";	'."\n";
			}
			$out .= '</script>';
		}
		return $out;
	}
}

?>