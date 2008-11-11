<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlSelect.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/customer.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import.inc.php");

include_once(WE_CUSTOMER_MODULE_DIR."weCustomerEI.php");

define("CSV_DELIMITER",";");
define("CSV_ENCLOSE","");
define("CSV_LINEEND","windows");
define("CSV_FIELDS","0");

class weCustomerEIWizard{

	var $frameset;
	var $db;

	var $topFrame="top";
	var $headerFrame="top.header";
	var $loadFrame="top.load";
	var $bodyFrame="top.body";
	var $footerFrame="top.footer";

	var $exim_number=5;

	function weCustomerEIWizard(){
		$this->setFrameset(WE_CUSTOMER_MODULE_PATH."edit_customer_frameset.php");
		$this->db=new DB_WE();
	}

 	function setFrameset($frameset){
 		$this->frameset=$frameset;
 	}


 	function  getHTMLFrameset($mode){

		$js=we_htmlElement::jsElement('

			var table="'.FILE_TABLE.'";

			self.focus();

		');

		$frameset=new we_htmlFrameset(array("framespacing"=>"0","border"=>"0","frameborder"=>"no"));
		$noframeset=new we_baseElement("noframes");

		$frameset->setAttributes(array("rows"=>(($_SESSION["prefs"]["debug_normal"] != 0) ? "*,45,160" : "*,45,0" )));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=eibody&art=".$mode."&step=1","name"=>"body","scrolling"=>"auto","noresize"=>null));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=eifooter&art=".$mode."&step=1","name"=>"footer","scrolling"=>"no"));
		$frameset->addFrame(array("src"=>$this->frameset."?pnt=eiload&step=1","name"=>"load","scrolling"=>"no","noresize"=>null));

		$head=WE_DEFAULT_HEAD."\n" . STYLESHEET . $js ."\n";
		$body=$frameset->getHtmlCode()."\n".we_baseElement::getHtmlCode($noframeset);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead($head).
					$body
		);

 	}


 	function getHTMLStep($mode,$step=0){

 	 	if($mode=="export"){
 	 		if($step==0) return $this->getHTMLExportStep0();
		 	else if($step==1) return $this->getHTMLExportStep1();
 			else if($step==2) return $this->getHTMLExportStep2();
 			else if($step==3) return $this->getHTMLExportStep3();
 			else if($step==4) return $this->getHTMLExportStep4();
 			else if($step==5) return $this->getHTMLExportStep5();
 		}
 	 	else if($mode=="import"){
 	 		if($step==0) return $this->getHTMLStep0();
		 	else if($step==1) return $this->getHTMLImportStep1();
 			else if($step==2) return $this->getHTMLImportStep2();
 			else if($step==3) return $this->getHTMLImportStep3();
 			else if($step==4) return $this->getHTMLImportStep4();
 			else if($step==5) return $this->getHTMLImportStep5();
 		}
 		else{
			return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD).
					we_htmlElement::htmlBody(array("bgcolor"=>"white","marginwidth"=>"10","marginheight"=>"10","leftmargin"=>"10","topmargin"=>"10"),"aba")
			);
 		}
 	}

	function getHTMLExportStep1() {
		global $l_customer;

		$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";

		$generic = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 3, 1);
		$generic->setCol(0, 0, array(), we_forms::radiobutton("gxml",($type=="gxml"), "type", $l_customer["gxml_export"], true, "defaultfont", "if(document.we_form.type[0].checked) ".$this->topFrame.".type='gxml';",  false, $l_customer["txt_gxml_export"], 0, 430));
		$generic->setCol(1, 0, array(), getPixel(0, 4));
		$generic->setCol(2, 0, array(), we_forms::radiobutton("csv", ($type=="csv"), "type", $l_customer["csv_export"], true, "defaultfont", "if(document.we_form.type[1].checked) ".$this->topFrame.".type='csv';", false, $l_customer["txt_csv_export"], 0, 430));

		$parts = array();

		array_push($parts, array(
			"headline"	=> $l_customer["generic_export"],
			"html"		=> $generic->getHTMLCode(),
			"space"		=> 120,
			"noline"	=> 1)
		);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body"),
								//we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
								//we_htmlElement::htmlHidden(array("name"=>"step","value"=>"1")).
								$this->getHiddens(array("art"=>"export","step"=>"1")).
								we_multiIconBox::getHTML("", "100%", $parts, 30, "", -1, "", "", false, $l_customer["export_step1"])
							)
						)
					)
		);
	}


	function getHTMLExportStep2() {
		global $l_customer;

		$selection=isset($_REQUEST["selection"]) ? $_REQUEST["selection"] : "filter";

		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 1, 2);
		$table->setColContent(0, 0, getPixel(25, 5));
		$table->setColContent(0, 1,
			$this->getHTMLCustomerFilter()
        );

		$generic = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 8, 1);
		$generic->setColContent(0, 0, getPixel(5, 10));
		$generic->setColContent(1, 0, we_forms::radiobutton("filter",($selection=="filter"), "selection", $l_customer["filter_selection"], true, "defaultfont", "if(document.we_form.selection[0].checked) ".$this->topFrame.".selection='filter';"));
		$generic->setColContent(2, 0, getPixel(5, 10));
		$generic->setColContent(3, 0, $table->getHtmlCode());
		$generic->setColContent(4, 0, getPixel(5, 10));

		$table->setColContent(0, 1,
			htmlFormElementTable(
				$this->getHTMLCustomer(),
				$l_customer["customer"]
			)
        );
		$generic->setColContent(5, 0, we_forms::radiobutton("manual", ($selection=="manual"), "selection", $l_customer["manual_selection"], true, "defaultfont", "if(document.we_form.selection[1].checked) ".$this->topFrame.".selection='manual';"));
		$generic->setColContent(6, 0, getPixel(5, 10));
		$generic->setColContent(7, 0, $table->getHtmlCode());

		$parts = array();

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $generic->getHTMLCode(),
			"space"		=> 30,
			"noline"	=> 1)
		);

		$js=we_htmlElement::jsElement('

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}

			function we_cmd(){
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]){
					case "del_customer":
						selector_cmd(arguments[0],arguments[1],arguments[2]);
					break;
				}
			}

			//'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&step="+'.$this->topFrame.'.step;

		');
		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".$js).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body"),
								$this->getHiddens(array("art"=>"export","step"=>"2")).
								we_multiIconBox::getHTML("", "100%", $parts, 30, "", -1, "", "", false, $l_customer["export_step2"])
							)
						)
					)
		);
	}



	function getHTMLExportStep3(){
		global $l_customer;
		//	define different parts of the export wizard
		$_space      = 150;
		$_input_size = 42;

		$parts = array();
		$we_button = new we_button();

		//set defaults
		$type= isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";
		$filename= (isset($_REQUEST["filename"]) && $_REQUEST["filename"]!="") ? $_REQUEST["filename"] : "weExport_".time().($type=="csv" ? ".csv" : ".xml");
		$export_to= isset($_REQUEST["export_to"]) ? $_REQUEST["export_to"] : "server";
		$path= isset($_REQUEST["path"]) ? $_REQUEST["path"] : "/";
		$cdata= (isset($_REQUEST["cdata"])) ? $_REQUEST["cdata"] : 1;

		$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
		$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
		$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;
		$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? $_REQUEST["csv_fieldnames"] : CSV_FIELDS;

		//set variables in top frame
		$js="";
		array_push($parts,array("headline"=>$l_customer["filename"],"html"=>htmlTextInput("filename",$_input_size,$filename),"space"=>$_space));

		if ($type=="gxml") {
			$table = new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border" => 0), 3, 1);

			$table->setColContent(1, 0, getPixel(1, 10));
			$table->setColContent(0, 0, we_forms::radiobutton(1, $cdata, "cdata", $l_customer["export_xml_cdata"], true, "defaultfont", ""));
			$table->setColContent(2, 0, we_forms::radiobutton(0, !$cdata, "cdata", $l_customer["export_xml_entities"], true, "defaultfont", ""));

			array_push($parts,array("headline" => $l_customer["cdata"], "html" => $table->getHtmlCode(), "space" => $_space));
		}

		if ($type=="csv"){
			$csv_input_size = 3;
			$fileformattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 5, 1);

			$_file_encoding = new we_htmlSelect(array("name" => "csv_lineend", "size" => "1", "class" => "defaultfont", "style" => "width: 254px"));
			$_file_encoding->addOption("windows", $l_customer["windows"]);
			$_file_encoding->addOption("unix", $l_customer["unix"]);
			$_file_encoding->addOption("mac", $l_customer["mac"]);
			$_file_encoding->selectOption($csv_lineend);

			$fileformattable->setCol(0, 0, array("class" => "defaultfont"), getPixel(10,10));
			$fileformattable->setCol(1, 0, array("class" => "defaultfont"), $l_customer["csv_lineend"] . "<br>" . $_file_encoding->getHtmlCode());
			$fileformattable->setColContent(2,0,$this->getHTMLChooser("csv_delimiter",$csv_delimiter,array(","=>$l_customer["comma"],";"=>$l_customer["semicolon"],":"=>$l_customer["colon"],"\\t"=>$l_customer["tab"]," "=>$l_customer["space"]),$l_customer["csv_delimiter"]));
			$fileformattable->setColContent(3,0,$this->getHTMLChooser("csv_enclose",$csv_enclose,array("\""=>$l_customer["double_quote"],"'"=>$l_customer["single_quote"]),$l_customer["csv_enclose"]));

			$fileformattable->setColContent(4,0,we_forms::checkbox(0,$csv_fieldnames,"csv_fieldnames",$l_customer["csv_fieldnames"]));

			array_push($parts,array("headline" => $l_customer["csv_params"], "html" => $fileformattable->getHtmlCode(),"space" => $_space));
		}

		array_push($parts,array("headline"=>$l_customer["export_to"],"html" => "","space" => 0,"noline" =>1));

		$table=new we_htmlTable(array("cellpadding" => 0,"cellspacing" => 0,"border"=>0),1,2);
		$table->setColContent(0,0,getPixel(20,2));
		$table->setColContent(0,1,we_forms::radiobutton("server", ($export_to=="server" ? true : false), "export_to", $l_customer["export_to_server"],true,"defaultfont",$this->topFrame.".export_to='server'"));
		array_push($parts,array("space" => $_space,"noline" => 1,
										"headline" =>$table->getHtmlCode(),
										"html" =>
													we_htmlElement::htmlBr().
													htmlFormElementTable($this->formFileChooser(200,"path",$path,"","folder"),$l_customer["path"])

		));

		$table->setColContent(0,1,we_forms::radiobutton("local", ($export_to=="local" ? true : false), "export_to", $l_customer["export_to_local"],true,"defaultfont",$this->topFrame.".export_to='local'"));
		array_push($parts,array("headline"=>$table->getHtmlCode(),"space" => $_space,"noline" => 1,"html" =>""));

		$body = we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name" => "we_form","method"=>"post","target"=>"body"),
								//we_htmlElement::htmlHidden(array("name"=>"step",""=>"4")).
								$this->getHiddens(array("art"=>"export","step"=>"3")).
								we_multiIconBox::getHTML("weExportWizard","100%",$parts,30,"",-1,"","",false,$l_customer["export_step3"])
							)
						)
		);


		$head = STYLESHEET . "\n" .$js;
		return we_htmlElement::htmlHtml(we_htmlElement::htmlHead($head)."\n". $body);

	}


	function getHTMLExportStep4() {
		global $l_customer;

		$export_to=isset($_REQUEST["export_to"]) ? $_REQUEST["export_to"] : "server";
		$path = isset($_REQUEST["path"]) ? urldecode($_REQUEST["path"]) : "";
		$filename = isset($_REQUEST["filename"]) ? urldecode($_REQUEST["filename"]) : "";
		$js=we_htmlElement::jsElement('
			'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&step=5";
		');

		if($export_to=="local"){
				$message = we_htmlElement::htmlSpan(array("class" => "defaultfont"),
											$l_customer["export_finished"]."<br><br>" .
											$l_customer["download_starting"].
											we_htmlElement::htmlA(array("href" => $this->frameset . "?pnt=eibody&step=5&exportfile=" . $filename), $l_customer["download"])
				);
				return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".$js.
						we_htmlElement::htmlMeta(array("http-equiv" => "refresh", "content" => "2; URL=http://".SERVER_NAME.$this->frameset."?pnt=eibody&step=5&exportfile=".$filename))
					).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							htmlDialogLayout($message, $l_customer["export_step4"])
						)
					)
				);


		}
		else{
				$message = we_htmlElement::htmlSpan(array("class" => "defaultfont"),
											$l_customer["export_finished"]."<br><br>".
											$l_customer["server_finished"]."<br>".
											($path!="/" ? $path : "")."/".$filename
				);

				return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET)."\n".$js.
					we_htmlElement::htmlBody(array("class"=>"weDIalogBody"),
						we_htmlElement::htmlCenter(
							htmlDialogLayout($message, $l_customer["export_step4"])
						)
					)
				);
		}

	}

 	function  getHTMLExportStep5(){
 		@set_time_limit(0);
		$prot = getServerProtocol();
		$preurl = (isset($_SERVER["HTTP_HOST"]) && $_SERVER["HTTP_HOST"]) ? "$prot://".$_SERVER["HTTP_HOST"] : "";
		if (isset($_GET["exportfile"])) {
			$_filename = basename(urldecode($_GET["exportfile"]));

			if (file_exists(TMP_DIR."/".$_filename)								// Does file exist?
				&& !eregi("p?html?", $_filename) && !eregi("inc", $_filename) && !eregi("php3?", $_filename)) {		// Security check
				$_size = filesize(TMP_DIR."/".$_filename);

				if (we_isHttps()) {																		// Additional headers to make downloads work using IE in HTTPS mode.
					header("Pragma: ");
					header("Cache-Control: ");
					header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
					header("Cache-Control: no-store, no-cache, must-revalidate");									// HTTP 1.1
					header("Cache-Control: post-check=0, pre-check=0", false);
				} else {
					header("Cache-control: private");
				}

				header("Content-Type: application/force-download");
				header("Content-Disposition: attachment; filename=\"" . trim(htmlentities($_filename)) . "\"");
				header("Content-Description: " . trim(htmlentities($_filename)));
				header("Content-Length: " . $_size);

				$_filehandler = readfile(TMP_DIR."/".$_filename);

				exit;
			} else {
				header("Location: " . $preurl.$this->frameset . "?pnt=body&step=99&error=download_failed");
				exit;
			}
		} else {
			header("Location: " . $preurl.$this->frameset . "?pnt=body&step=99&error=download_failed");
			exit;
		}

 	}

	function getHiddens($options=array()){

		$hiddens="";
		if($options["art"]=="import"){
			$filename=isset($_REQUEST["filename"]) ? $_REQUEST["filename"] : "";
			$import_from=isset($_REQUEST["import_from"]) ? $_REQUEST["import_from"] : "server";
			$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";
			$xml_from=isset($_REQUEST["xml_from"]) ? $_REQUEST["xml_from"] : "0";
			$xml_to=isset($_REQUEST["xml_to"]) ? $_REQUEST["xml_to"] : "1";
			$dataset=isset($_REQUEST["dataset"]) ? $_REQUEST["dataset"] : "";
			$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
			$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
			$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;

			$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? 1 : 0;

			$source=isset($_REQUEST["source"]) ? $_REQUEST["source"] : "/";

			switch($options["step"]){
				case 1:
						$hiddens=	we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"source","value"=>$source)).
						we_htmlElement::htmlHidden(array("name"=>"import_from","value"=>$import_from)).
						we_htmlElement::htmlHidden(array("name"=>"xml_from","value"=>$xml_from)).
						we_htmlElement::htmlHidden(array("name"=>"xml_to","value"=>$xml_to)).
						we_htmlElement::htmlHidden(array("name"=>"dataset","value"=>$dataset)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose)).
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames));
				break;
				case 2:
						$hiddens=	we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"xml_from","value"=>$xml_from)).
						we_htmlElement::htmlHidden(array("name"=>"xml_to","value"=>$xml_to)).
						we_htmlElement::htmlHidden(array("name"=>"dataset","value"=>$dataset)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose)).
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames));
				break;
				case 3:
						$hiddens=	we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"source","value"=>$source)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"import_from","value"=>$import_from)).
						we_htmlElement::htmlHidden(array("name"=>"dataset","value"=>$dataset));
				break;
				case 4:
						$hiddens=	we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"source","value"=>$source)).
						we_htmlElement::htmlHidden(array("name"=>"import_from","value"=>$import_from)).
						we_htmlElement::htmlHidden(array("name"=>"dataset","value"=>$dataset)).
						we_htmlElement::htmlHidden(array("name"=>"xml_from","value"=>$xml_from)).
						we_htmlElement::htmlHidden(array("name"=>"xml_to","value"=>$xml_to)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						'<input type="hidden" name="csv_enclose" value=' . ($csv_enclose=='"' ? "'\"'" : "\"$csv_enclose\"") .'>' .
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames)).
						we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"import"));
				break;
			}
		}

		if($options["art"]=="export"){

			$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";
			$selection=isset($_REQUEST["selection"]) ? $_REQUEST["selection"] : "filter";
			$export_to=isset($_REQUEST["export_to"]) ? $_REQUEST["export_to"] : "server";
			$path = isset($_REQUEST["path"]) ? urldecode($_REQUEST["path"]) : "/";
			$filename= isset($_REQUEST["filename"]) ? $_REQUEST["filename"] : "";
			$cdata= (isset($_REQUEST["cdata"])) ? $_REQUEST["cdata"] : 1;

			$customers= isset($_REQUEST["customers"]) ? $_REQUEST["customers"] : "";

			$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
			$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
			$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;
			$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? 1 : 0;

			$filter_count=isset($_REQUEST["filter_count"]) ? $_REQUEST["filter_count"] : "0";
			$filter="";
			$fields_names = array("fieldname","operator","fieldvalue","logic");
			for ($i = 0; $i < $filter_count; $i++) {
				$new=array("fieldname"=>"","operator"=>"","fieldvalue"=>"","logic"=>"");
				foreach ($fields_names as $field) {
					$varname="filter_".$field."_".$i;
					if (isset($_REQUEST[$varname])) {
						$filter.=we_htmlElement::htmlHidden(array("name"=>$varname,"value"=>$_REQUEST[$varname]));
					}
				}

			}

			switch($options["step"]){
				case 1:
						$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"selection","value"=>$selection)).
						we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
						we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path)).
						we_htmlElement::htmlHidden(array("name"=>"cdata","value"=>$cdata)).
						we_htmlElement::htmlHidden(array("name"=>"customers","value"=>$customers)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose)).
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames)).
						we_htmlElement::htmlHidden(array("name"=>"filter_count","value"=>$filter_count)).
						$filter;
				break;
				case 2:
						$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"selection","value"=>$selection)).
						we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
						we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path)).
						we_htmlElement::htmlHidden(array("name"=>"cdata","value"=>$cdata)).
						we_htmlElement::htmlHidden(array("name"=>"customers","value"=>$customers)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose)).
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames)).
						we_htmlElement::htmlHidden(array("name"=>"filter_count","value"=>$filter_count));
				break;
				case 3:
						$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"selection","value"=>$selection)).
						we_htmlElement::htmlHidden(array("name"=>"customers","value"=>$customers)).
						we_htmlElement::htmlHidden(array("name"=>"filter_count","value"=>$filter_count)).
						we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"export")).
						$filter;
				break;
				case 4:
						$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
						we_htmlElement::htmlHidden(array("name"=>"step","value"=>$options["step"])).
						we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).
						we_htmlElement::htmlHidden(array("name"=>"type","value"=>$type)).
						we_htmlElement::htmlHidden(array("name"=>"selection","value"=>$selection)).
						we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
						we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path)).
						we_htmlElement::htmlHidden(array("name"=>"cdata","value"=>$cdata)).
						we_htmlElement::htmlHidden(array("name"=>"customers","value"=>$customers)).
						we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
						we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
						we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose)).
						we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
						we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames)).
						we_htmlElement::htmlHidden(array("name"=>"filter_count","value"=>$filter_count)).
						$filter;
						$hiddens="";
				break;
			}
		}


		return $hiddens;
	}

	function getHTMLImportStep1() {
		global $l_customer;

		$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";

		$generic = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 3, 1);
		$generic->setCol(0, 0, array(), we_forms::radiobutton("gxml",($type=="gxml"), "type", $l_customer["gxml_import"], true, "defaultfont", "if(document.we_form.type[0].checked) ".$this->topFrame.".type='gxml';",  false, $l_customer["txt_gxml_import"], 0, 430));
		$generic->setCol(1, 0, array(), getPixel(0, 4));
		$generic->setCol(2, 0, array(), we_forms::radiobutton("csv", ($type=="csv"), "type", $l_customer["csv_import"], true, "defaultfont", "if(document.we_form.type[1].checked) ".$this->topFrame.".type='csv';", false, $l_customer["txt_csv_import"], 0, 430));

		$parts = array();

		array_push($parts, array(
			"headline"	=> $l_customer["generic_import"],
			"html"		=> $generic->getHTMLCode(),
			"space"		=> 120,
			"noline"	=> 1)
		);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post"),
								$this->getHiddens(array("art"=>"import","step"=>"1")).
								we_multiIconBox::getHTML("", "100%", $parts, 30, "", -1, "", "", false, $l_customer["import_step1"])
							)
						)
					)
		);
	}

	function getHTMLImportStep2() {
		global $l_customer;

		$import_from=isset($_REQUEST["import_from"]) ? $_REQUEST["import_from"] : "server";
		$source=isset($_REQUEST["source"]) ? $_REQUEST["source"] : "/";
		$upload=isset($_REQUEST["upload"]) ? $_REQUEST["upload"] : "";
		$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

		$we_button=new we_button();
		$parts = array();

		$js=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
				we_htmlElement::jsElement('
					function callBack(){
						document.we_form.import_from[1].checked=true;
					}
				');

		$tmptable=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),4,1);
		$tmptable->setCol(0,0,array("valign"=>"middle"),$this->formFileChooser(250,"source",$source,"opener.".$this->bodyFrame.".document.we_form.import_from[0].checked=true;",($type=="gxml" ? "text/xml" : "")));
		$tmptable->setCol(1,0,array(),getPixel(2,5));

		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 4, 2);
		$table->setCol(0, 0,array("colspan"=>"2"),we_forms::radiobutton("server",($import_from=="server"), "import_from", $l_customer["server_import"], true, "defaultfont", ""));
		$table->setColContent(1, 0, getPixel(25, 5));
		$table->setColContent(2, 1,$tmptable->getHtmlCode());

		array_push($parts, array(
			"headline"	=> $l_customer["source_file"],
			"html"		=> $table->getHtmlCode(),
			"space"		=> 120,
			"noline"	=> 1)
		);

		//upload table
		include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/newfile.inc.php");
		$maxsize = getUploadMaxFilesize(true);
		if($maxsize){
			$tmptable->setCol(0,0,array(),htmlAlertAttentionBox(sprintf($l_newFile["max_possible_size"],round($maxsize / (1024*1024),3)."MB"),1,"430"));
			$tmptable->setCol(1,0,array(),getPixel(2,5));
		}else{
			$tmptable->setCol(0,0,array(),getPixel(2,5));
			$tmptable->setCol(1,0,array(),getPixel(2,5));
		}
		//$tmptable->setCol(2,0,array("valign"=>"middle"),we_htmlElement::htmlInput(array("name"=>"upload","type"=>"file","size"=>"35","value"=>$upload)));
		$tmptable->setCol(2,0,array("valign"=>"middle"),htmlTextInput("upload", 35, "", 255, "onClick=\"document.we_form.import_from[1].checked=true;\"", "file"));
		$tmptable->setCol(3,0,array(),getPixel(2,5));
		//

		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 3, 2);
		$table->setCol(0, 0,array("colspan"=>"2"),we_forms::radiobutton("local",($import_from=="local"), "import_from", $l_customer["upload_import"], true, "defaultfont", ""));
		$table->setColContent(1, 0, getPixel(25, 5));
		$table->setColContent(2, 1,$tmptable->getHtmlCode());

		array_push($parts, array(
			"headline"	=> "",
			"html"		=> $table->getHTMLCode(),
			"space"		=> 120,
			"noline"	=> 1)
		);


		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".$js).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","enctype"=>"multipart/form-data"),
								$this->getHiddens(array("art"=>"import","step"=>"2")).
								we_multiIconBox::getHTML("", "100%", $parts, 30, "", -1, "", "", false, $l_customer["import_step2"])
							)
						)
					)
		);
	}

	function getHTMLImportStep3() {
		global $l_customer;

		$js="";
		$hiddens="";
		$import_from=isset($_REQUEST["import_from"]) ? $_REQUEST["import_from"] : "server";
		$source=isset($_REQUEST["source"]) ? $_REQUEST["source"] : "/";
		$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";
		$dataset=isset($_REQUEST["dataset"]) ? $_REQUEST["dataset"] : "";
		$ext=$type=="csv" ? ".csv" : ".xml";

		$filename="";
		$filesource="";

		if($import_from=="local"){
			if(isset($_FILES['upload']) && $_FILES["upload"]["size"]){
				// creating a temp name and copy the file to the we tmp directory with the new temp name
				$filename="/webEdition/we/tmp/".md5(uniqid(rand(),1)).$ext;
				$filesource=$_SERVER["DOCUMENT_ROOT"].$filename;
				move_uploaded_file($_FILES['upload']["tmp_name"],$filesource);
			}
		}
		else{
			$filename=$source;
			$filesource=$_SERVER["DOCUMENT_ROOT"].$filename;
		}

		$parts=array();
		if(is_file($filesource) && is_readable($filesource)){
			if($type=="csv"){

				$csv_input_size = 3;

				$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
				$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
				$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;
				$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? $_REQUEST["csv_fieldnames"] : CSV_FIELDS;

				$fileformattable = new we_htmlTable(array("cellpadding" => 2,"cellspacing" => 2, "border" => 0), 5, 1);

				$_file_encoding = new we_htmlSelect(array("name" => "csv_lineend", "size" => "1", "class" => "defaultfont", "style" => "width: 254px"));
				$_file_encoding->addOption("windows", $l_customer["windows"]);
				$_file_encoding->addOption("unix", $l_customer["unix"]);
				$_file_encoding->addOption("mac", $l_customer["mac"]);
				$_file_encoding->selectOption($csv_lineend);

				$fileformattable->setCol(0, 0, array("class" => "defaultfont"), getPixel(10,10));
				$fileformattable->setCol(1, 0, array("class" => "defaultfont"), $l_customer["csv_lineend"] . we_htmlElement::htmlBr() . $_file_encoding->getHtmlCode());
				$fileformattable->setColContent(2,0,$this->getHTMLChooser("csv_delimiter",$csv_delimiter,array(";"=>$l_customer["semicolon"],","=>$l_customer["comma"],":"=>$l_customer["colon"],"\\t"=>$l_customer["tab"]," "=>$l_customer["space"]),$l_customer["csv_delimiter"]));
				$fileformattable->setColContent(3,0,$this->getHTMLChooser("csv_enclose",$csv_enclose,array("\""=>$l_customer["double_quote"],"'"=>$l_customer["single_quote"]),$l_customer["csv_enclose"]));

				$fileformattable->setColContent(4,0,we_forms::checkbox($csv_fieldnames,($csv_fieldnames==1),"csv_fieldnames",$l_customer["csv_fieldnames"]));

				array_push($parts,array("headline" => $l_customer["csv_params"], "html" => $fileformattable->getHtmlCode(),"space" => 150));

			}else{

				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/xml_parser.inc.php");

				//invoke parser
				$xp = new XML_Parser($filesource);
				$xmlWellFormed = ($xp->parseError == "")? true : false;

				if ($xmlWellFormed) {
					// Node-set with paths to the child nodes.
					$node_set = $xp->evaluate("*/child::*");
					$children = $xp->nodes[$xp->root]["children"];

					$recs = array();
					foreach ($children as $key=>$value) {
						$flag = true;
						for ($k=1; $k < ($value+1); $k++) if (!$xp->hasChildNodes($xp->root."/".$key."[".$k."]")) $flag = false;
						if ($flag) $recs[$key] = $value;
					}
					$isSingleNode = (count($recs) == 1)? true : false;
					$hasChildNode = (count($recs) > 0)? true : false;
				}
				if ($xmlWellFormed && $hasChildNode) {
					$rcdSelect = new we_htmlSelect(array(
						"name"		=> "we_select",
						"size"		=> "1",
						"class"		=> "defaultfont",
						(($isSingleNode)? "disabled":"style")=> "",
						"onChange"	=> "this.form.elements['xml_to'].value=this.options[this.selectedIndex].value; this.form.elements['xml_from'].value=1;this.form.elements['dataset'].value=this.options[this.selectedIndex].text;" .
							"if(this.options[this.selectedIndex].value==1) {this.form.elements['xml_from'].disabled=true;this.form.elements['xml_to'].disabled=true;} else {this.form.elements['xml_from'].disabled=false;this.form.elements['xml_to'].disabled=false;}")
					);
					$optid = 0;
					foreach($recs as $value=>$text){
						if ($optid == 0){
							$firstItem= $value;
							$firstOptVal = $text;
						}
						$rcdSelect->addOption($text, $value);
						if (isset($v["rcd"])) if ($text == $v["rcd"]) $rcdSelect->selectOption($value);
						$optid++;
					}

					$tblSelect = new we_htmlTable(array(), 1, 7);
					$tblSelect->setCol(0, 1, array(), $rcdSelect->getHtmlCode());
					$tblSelect->setCol(0, 2, array("width" => 20));
					$tblSelect->setCol(0, 3, array("class" => "defaultfont"), $l_customer["num_data_sets"]);
					$tblSelect->setCol(0, 4, array(), htmlTextInput("xml_from", 4, 1, 5, "align=right", "text", 30, "", "",($isSingleNode&&($firstOptVal==1))?1:0));
					$tblSelect->setCol(0, 5, array("class" => "defaultfont"), $l_customer["to"]);
					$tblSelect->setCol(0, 6, array(), htmlTextInput("xml_to", 4, $firstOptVal, 5, "align=right", "text", 30, "", "",($isSingleNode&&($firstOptVal==1))?1:0));

					$tblFrame = new we_htmlTable(array(), 3, 2);
					$tblFrame->setCol(0, 0, array("colspan" => "2", "class" => "defaultfont"),
						($isSingleNode)? htmlAlertAttentionBox($l_customer["well_formed"]." ".$l_customer["select_elements"],2,"570") :
							htmlAlertAttentionBox($l_customer["xml_valid_1"]." $optid ".$l_customer["xml_valid_m2"],2,"570"));
					$tblFrame->setCol(1, 0, array("colspan" => "2"));
					$tblFrame->setCol(2, 1, array(), $tblSelect->getHtmlCode());

					$_REQUEST["dataset"]=$firstItem;
					array_push($parts, array("html"=>$tblFrame->getHtmlCode(),"space"=>0,"noline"=>1));

				}
				else {
					array_push($parts,array("html"=>htmlAlertAttentionBox((!$xmlWellFormed)?$l_customer["not_well_formed"]:$l_customer["missing_child_node"],1,"570"),"space"=>0,"noline"=>1));
					$js=we_htmlElement::jsElement('
						'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=import&step=99";
					');
				}
			}
		}
		else{
			$js=we_htmlElement::jsElement('
					'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=import&step=99";
			');
			array_push($parts,array("html"=>htmlAlertAttentionBox($l_customer["missing_filesource"],1,"570"),"space"=>0,"noline"=>1));
		}

		$_REQUEST["filename"]=$filename;
		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".$js).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
								we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body"),
								$this->getHiddens(array("art"=>"import","step"=>"3")).
								we_multiIconBox::getHTML("", "100%", $parts, 30, "", -1, "", "", false, $l_customer["import_step3"])
							)
						)
					)
		);

	}

	function getHTMLImportStep4() {
		global $l_customer;

		$filename=isset($_REQUEST["filename"]) ? $_REQUEST["filename"] : "";
		$import_from=isset($_REQUEST["import_from"]) ? $_REQUEST["import_from"] : "";
		$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";
		$xml_from=isset($_REQUEST["xml_from"]) ? $_REQUEST["xml_from"] : "";
		$xml_to=isset($_REQUEST["xml_to"]) ? $_REQUEST["xml_to"] : "";
		$dataset=isset($_REQUEST["dataset"]) ? $_REQUEST["dataset"] : "";
		$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
		$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
		$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;
		$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? 1 : 0;
		$same=isset($_REQUEST["same"]) ? $_REQUEST["same"] : "rename";

		$field_mappings=isset($_REQUEST["field_mappings"]) ? $_REQUEST["field_mappings"] : "";
		$att_mappings=isset($_REQUEST["att_mappings"]) ? $_REQUEST["att_mappings"] : "";

		$arrgs=array();
		if($type=="csv"){
			$arrgs["delimiter"]=$csv_delimiter;
			$arrgs["enclose"]=$csv_enclose;
			$arrgs["lineend"]=$csv_lineend;
			$arrgs["fieldnames"]=$csv_fieldnames;

		}else{
			$arrgs["dataset"]=$dataset;
		}

		$nodes=weCustomerEI::getDataset($type,$filename,$arrgs);
		$records=weCustomerEI::getCustomersFieldset();

		if ($type=="gxml") {
        	$tableheader = array(array("dat" => $l_customer["we_flds"]), array("dat" => $l_customer["rcd_flds"]), array("dat" => $GLOBALS["l_import"]["attributes"]));
		} else {
			$tableheader = array(array("dat" => $l_customer["we_flds"]), array("dat" => $l_customer["rcd_flds"]));
		}

        $rows = array();
		$i = 0;

		foreach($records as $record){
			$we_fields = new we_htmlSelect(array(
				"name"		=> "field_mappings[$record]",
				"size"		=> "1",
				"class"		=> "defaultfont",
				"onClick"	=> "",
				"style"		=> "")
			);

			$we_fields->addOption("", $l_customer["any"]);

			foreach(array_keys($nodes) as $node){
				$we_fields->addOption(htmlspecialchars(str_replace(" ","",$node)),htmlspecialchars($node));
				if (isset($field_mappings[$record])){
					if ($node == $field_mappings[$record]) $we_fields->selectOption($node);
				}
				else{
					if ($node == $record) $we_fields->selectOption($node);
				}
			}
			if ($type=="gxml") {
				array_push($rows,
					array(
						array("dat" => $record),
						array("dat" => $we_fields->getHTMLCode()),
						array("dat" => htmlTextInput("att_mappings[$record]", 30,(isset($att_mappings[$record]) ? $att_mappings[$record] : ""), 255, "", "text", 100))
					)

				);
			} else {
				array_push($rows,
					array(
						array("dat" => $record),
						array("dat" => $we_fields->getHTMLCode())
					)

				);
			}
			$i++;
		}

		$parts = array();
		array_push($parts, array(
			"html"		=> getPixel(1,8)."<br>".htmlDialogBorder3(510, 255, $rows, $tableheader, "defaultfont"),
			"space"		=> 0)
		);

		$table = new we_htmlTable(array("cellpadding" => 0, "cellspacing" => 0, "border" => 0), 4, 1);
		$table->setColContent(0, 0,we_forms::radiobutton("rename",($same=="rename"), "same", $l_customer["same_rename"], true, "defaultfont", ""));
		$table->setColContent(1, 0,we_forms::radiobutton("overwrite",($same=="overwrite"), "same", $l_customer["same_overwrite"], true, "defaultfont", ""));
		$table->setColContent(2, 0,we_forms::radiobutton("skip",($same=="skip"), "same", $l_customer["same_skip"], true, "defaultfont", ""));

		array_push($parts,array(
								"headline" => $l_customer["same_names"],
								"html" => $table->getHtmlCode(),
								"space" => 150
						)
		);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".we_multiIconBox::getJS()).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body"),
								$this->getHiddens(array("art"=>"import","step"=>"4")).
								we_multiIconBox::getHTML("xml","100%",$parts, 30, "", -1, "", "", false,$l_customer["import_step4"])
							)
						)
					)
		);

	}

	function getHTMLImportStep5(){
				global $l_customer;

				$tmpdir=isset($_REQUEST["tmpdir"]) ? $_REQUEST["tmpdir"] : "";
				$impno=isset($_REQUEST["impno"]) ? $_REQUEST["impno"] : "0";

				$table = new we_htmlTable(array("cellpadding" => 2, "cellspacing" => 2, "border" => 0), 3, 1);
				$table->setCol(0, 0,array("class"=>"defaultfont"),sprintf($l_customer["import_finished_desc"],$impno));

				if($tmpdir!="" && is_file(TMP_DIR."/$tmpdir/$tmpdir.log") && is_readable(TMP_DIR."/$tmpdir/$tmpdir.log")){
					$log="";
					$fh=fopen(TMP_DIR."/$tmpdir/$tmpdir.log","rb");
					if($fh){
						while(!feof($fh)) $log.=fread($fh,4096);

						$table->setColContent(1, 0,htmlAlertAttentionBox($l_customer["show_log"],1,"550"));
						$table->setColContent(2, 0,we_htmlElement::htmlTextArea(array("name"=>"log","rows"=>"15","cols"=>"15","style"=>"width: 550; height: 200"),htmlspecialchars($log)));
						fclose($fh);
						unlink(TMP_DIR."/$tmpdir/$tmpdir.log");
					}
				}
				$parts=array();
				array_push($parts,array(
								"headline" => "",
								"html" => $table->getHtmlCode(),
								"space" => 20
						)
				);

				if(is_dir(TMP_DIR."/".$tmpdir)) rmdir(TMP_DIR."/".$tmpdir);

				return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(WE_DEFAULT_HEAD."\n".STYLESHEET."\n".we_multiIconBox::getJS()).
					we_htmlElement::htmlBody(array("class"=>"weDialogBody"),
						we_htmlElement::htmlCenter(
							we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"load"),
								we_multiIconBox::getHTML("","100%",$parts, 30, "", -1, "", "", false,$l_customer["import_step5"])
							)
						)
					)
		);

	}

	function getHTMLFooter($mode,$step){

		if($mode=="export") return $this->getHTMLExportFooter($step);
		else if($mode=="import") return $this->getHTMLImportFooter($step);
	}


	function getHTMLExportFooter($step=1){
		global $l_customer;

		$content = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "575", "align"=>"right"), 1, 2);

		$we_button = new we_button();

		if ($step == 1) {
			$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "", false, 100, 22, "", "", true),
															$we_button->create_button("next", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=export_next&step=".$step."';"))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
			);
		} else if ($step == 4) {
			$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "", false, 100, 22, "", "", true),
															$we_button->create_button("next", "", false, 100, 22, "", "", true))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
			);
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_progressBar.inc.php");
			$text = $l_customer["exporting"];
			$progress = 0;
			$progressbar = new we_progressBar($progress);
			$progressbar->setStudLen(200);
			$progressbar->addText($text, 0, "current_description");

			$content->setCol(0, 0, null, (isset($progressbar) ? $progressbar->getHtml() : ""));

		} else if ($step == 5) {
			$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "", false, 100, 22, "", "", true),
															$we_button->create_button("next", "", false, 100, 22, "", "", true))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
			);
		} else {
			$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=export_back&step=".$step."';"),
															$we_button->create_button("next", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=export_next&step=".$step."';"))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
			);
		}
		$content->setCol(0, 1, array("align" => "right"), $buttons);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(
						WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . (isset($progressbar) ? $progressbar->getJSCode() . "\n" : "")
					).
					we_htmlElement::htmlBody(array("class"=>"weDialogButtonsBody"),
						we_htmlElement::htmlForm(array(
								"name"    => "we_form",
								"method"  => "post",
								"target"  => "load",
								"action"  => $this->frameset
								),
								$content->getHtmlCode()
						)
					)
		);

	}

	function getHTMLImportFooter($step=1){
		global $l_customer;

		$content = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "width" => "575", "align"=>"right"), 1, 2);
		$we_button = new we_button();

		switch($step){
			case "1":
				$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "", false, 100, 22, "", "", true),
															$we_button->create_button("next", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=import_next&step=".$step."';"))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
				);
			break;
			case "5":
				$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "", false, 100, 22, "", "", true),
															$we_button->create_button("next", "", false, 100, 22, "", "", true))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
				);
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_progressBar.inc.php");
				$text = $l_customer["importing"];
				$progress = 0;
				$progressbar = new we_progressBar($progress);
				$progressbar->setStudLen(200);
				$progressbar->addText($text, 0, "current_description");

				$content->setCol(0, 0, null, (isset($progressbar) ? $progressbar->getHtml() : ""));
			break;
			case "6":
				$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button("close", "javascript:top.close();")
				);
			break;
			case "99":
				$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=import_back&step=2';"),
															$we_button->create_button("next", "", false, 100, 22, "", "", true))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
				);
			break;
			default:
				$buttons = $we_button->position_yes_no_cancel(
											$we_button->create_button_table(array(
															$we_button->create_button("back", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=import_back&step=".$step."';"),
															$we_button->create_button("next", "javascript:".$this->loadFrame.".location='".$this->frameset."?pnt=eiload&cmd=import_next&step=".$step."';"))
											),
											$we_button->create_button("cancel", "javascript:top.close();")
				);
		}
		$content->setCol(0, 1, array("align" => "right"), $buttons);

		return we_htmlElement::htmlHtml(
					we_htmlElement::htmlHead(
						WE_DEFAULT_HEAD . "\n" . STYLESHEET . "\n" . (isset($progressbar) ? $progressbar->getJSCode() . "\n" : "")
					).
					we_htmlElement::htmlBody(array("class"=>"weDialogButtonsBody"),
						we_htmlElement::htmlForm(array(
								"name"    => "we_form",
								"method"  => "post",
								"target"  => "load",
								"action"  => $this->frameset
								),
								$content->getHtmlCode()
						)
					)
		);

	}

	function  getHTMLLoad(){

 		$out="";
		if(isset($_REQUEST["cmd"])){
			switch($_REQUEST["cmd"]){
				//------------------------ Export commands --------------------------------------------------------------
				case "load":
					if(isset($_REQUEST["pid"])){
						$out=we_htmlElement::jsElement("self.location='".EXPORT_PATH."exportLoadTree.php?we_cmd[1]=".$_REQUEST["tab"]."&we_cmd[2]=".$_REQUEST["pid"]."&we_cmd[3]=".$_REQUEST["openFolders"]."'");
					}
				break;
				case "export_next":
					if(isset($_REQUEST["step"])){
						switch($_REQUEST["step"]){
							case 1:
							case 2:
							case 3:
							case 4:
								$js=we_htmlElement::jsElement('
									function doNext(){

										'.$this->bodyFrame.'.document.we_form.step.value++;

										'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=export&step="+'.$this->bodyFrame.'.document.we_form.step.value;
										if('.$this->bodyFrame.'.document.we_form.step.value>3){
											'.$this->bodyFrame.'.document.we_form.target="load";
											'.$this->bodyFrame.'.document.we_form.pnt.value="eiload";
											'.$this->bodyFrame.'.document.we_form.cmd.value="export";
										}
										'.$this->bodyFrame.'.document.we_form.submit();
									}

								');
								$head=WE_DEFAULT_HEAD."\n".$js;
								$out=we_htmlElement::htmlHtml(
										we_htmlElement::htmlHead($head).
										we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
											we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),"")
										)
								);
							break;
							default:
								$out="";
							break;
						}
					}
				break;
				case "export_back":
						$js=we_htmlElement::jsElement('
							function doNext(){
								'.$this->bodyFrame.'.document.we_form.step.value--;
								'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=export&step="+'.$this->bodyFrame.'.document.we_form.step.value;
								'.$this->bodyFrame.'.document.we_form.submit();
							}
						');

						$head=WE_DEFAULT_HEAD."\n".$js;
						$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead($head).
								we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),"")
								)
						);

				break;
				case "export":

					$file_format=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "gxml";
					$file_name=isset($_REQUEST["filename"]) ? $_REQUEST["filename"] : "";
					$export_to=isset($_REQUEST["export_to"]) ? $_REQUEST["export_to"] : "";

					if($export_to=="server") $path=isset($_REQUEST["path"]) ? $_REQUEST["path"] : "";
					else $path="/webEdition/we/tmp";

					$cdata=isset($_REQUEST["cdata"]) ? $_REQUEST["cdata"] : "0";
					$csv_delimiter=isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : "";
					$csv_enclose=isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : "";
					$csv_lineend=isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : "";
					$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? 1 : 0;

					$customers=array();

					if($_REQUEST["selection"]=="manual"){
						$customers=makeArrayFromCSV((isset($_REQUEST["customers"]) ? $_REQUEST["customers"] : ""));
					}
					else{

						$filterarr=array();
						$filtersql="";

						$filter_count=isset($_REQUEST["filter_count"]) ? $_REQUEST["filter_count"] : "0";
						$filter="";

						$filter_fieldname=array();
						$filter_operator=array();
						$filter_fieldvalue=array();
						$filter_logic=array();

						$fields_names = array("fieldname","operator","fieldvalue","logic");
						for ($i = 0; $i < $filter_count; $i++) {
							$new=array("fieldname"=>"","operator"=>"","fieldvalue"=>"","logic"=>"");
							foreach ($fields_names as $field) {
								$var="filter_".$field;
								$varname=$var."_".$i;
								if (isset($_REQUEST[$varname])) {
									eval('$'.$var.'[]=$_REQUEST["'.$varname.'"];');
								}
							}
						}

						foreach ($filter_fieldname as $k=>$v) {
								$op=$this->getOperator($filter_operator[$k]);
								$filterarr[]=($k!=0 ? (" ".$filter_logic[$k]." ") : "").$filter_fieldname[$k]." ".$op." '".(is_numeric($filter_fieldvalue[$k]) ? $filter_fieldvalue[$k] : mysql_real_escape_string($filter_fieldvalue[$k]))."'";
						}

						$filtersql=implode(" ",$filterarr);
						$this->db->query("SELECT ID FROM ".CUSTOMER_TABLE.($filtersql!="" ?  " WHERE ($filtersql)": ""));
						while($this->db->next_record()){
							$customers[]=$this->db->f("ID");
						}
					}

					$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eiload")).
									we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).

								 	we_htmlElement::htmlHidden(array("name"=>"customers","value"=>makeCSVFromArray($customers))).

								 	we_htmlElement::htmlHidden(array("name"=>"file_format","value"=>$file_format)).
								 	we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$file_name)).
								 	we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
								 	we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path)).

								 	we_htmlElement::htmlHidden(array("name"=>"all","value"=>count($customers))).

								 	we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"do_export")).
								 	we_htmlElement::htmlHidden(array("name"=>"step","value"=>"4"));

					if($file_format=="gxml") $hiddens.=we_htmlElement::htmlHidden(array("name"=>"cdata","value"=>$cdata));

					if($file_format=="csv") $hiddens.=we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
								 	($csv_enclose=='"' ?
								 	 	"<input type='hidden' name='csv_enclose' value='".$csv_enclose."'>"
								 	 	:
								 	 	we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose))
								 	 ).
								 	we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend)).
								 	we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames));

					$head=WE_DEFAULT_HEAD."\n" . STYLESHEET . "\n";
					$out=we_htmlElement::htmlHtml(
										we_htmlElement::htmlHead($head).
										we_htmlElement::htmlBody(array("onLoad"=>"document.we_form.submit()"),
															we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"load","action"=>$this->frameset),$hiddens)
										)
					);

				break;
				case "do_export":

					$customers = (isset($_REQUEST["customers"]) && $_REQUEST["customers"] != "") ? makeArrayFromCSV($_REQUEST["customers"]) : null;
					$file_format = (isset($_REQUEST["file_format"]) && $_REQUEST["file_format"] != "") ? $_REQUEST["file_format"] : null;
					$export_to = (isset($_REQUEST["export_to"]) && $_REQUEST["export_to"] != "") ? $_REQUEST["export_to"] : null;
					$path = (isset($_REQUEST["path"]) && $_REQUEST["path"] != "") ? $_REQUEST["path"] : null;
					$filename = (isset($_REQUEST["filename"]) && $_REQUEST["filename"] != "") ? $_REQUEST["filename"] : null;
					$firstexec= (isset($_REQUEST["firstexec"]) && $_REQUEST["firstexec"] != "") ? $_REQUEST["firstexec"] : -999;
					$all= (isset($_REQUEST["all"])) ? $_REQUEST["all"] : 0;
					$cdata=isset($_REQUEST["cdata"]) ? $_REQUEST["cdata"] : "0";

					$hiddens=we_htmlElement::htmlHidden(array("name"=>"file_format","value"=>$file_format)).
								 	we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
								 	we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
								 	we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path));

					if($file_format=="gxml") $hiddens.=we_htmlElement::htmlHidden(array("name"=>"cdata","value"=>$cdata));
					if($file_format=="csv"){
						$csv_delimiter = (isset($_REQUEST["csv_delimiter"]) && $_REQUEST["csv_delimiter"] != "") ? $_REQUEST["csv_delimiter"] : null;
						$csv_enclose = (isset($_REQUEST["csv_enclose"]) && $_REQUEST["csv_enclose"] != "") ? $_REQUEST["csv_enclose"] : null;
						$csv_lineend = (isset($_REQUEST["csv_lineend"]) && $_REQUEST["csv_lineend"] != "") ? $_REQUEST["csv_lineend"] : null;
						$csv_fieldnames = (isset($_REQUEST["csv_fieldnames"]) && $_REQUEST["csv_fieldnames"] != "") ? $_REQUEST["csv_fieldnames"] : null;

						$hiddens.=we_htmlElement::htmlHidden(array("name"=>"csv_delimiter","value"=>$csv_delimiter)).
								 		($csv_enclose=='"' ?
								 	 	"<input type='hidden' name='csv_enclose' value='".$csv_enclose."'>"
								 	 	:
								 	 	we_htmlElement::htmlHidden(array("name"=>"csv_enclose","value"=>$csv_enclose))
								 	 ).
								 	we_htmlElement::htmlHidden(array("name"=>"csv_lineend","value"=>$csv_lineend));
								 	//we_htmlElement::htmlHidden(array("name"=>"csv_fieldnames","value"=>$csv_fieldnames));
					}


					if(count($customers)){
						$options=array();
						$options["customers"]=array();
						$options["filename"]=$_SERVER["DOCUMENT_ROOT"].$path."/".$filename;
						$options["format"]=$file_format;
						$options["firstexec"]=$firstexec;

						$options["customers"]=array_splice($customers,0,$this->exim_number);

						if($file_format=="gxml") $options["cdata"]=$cdata;

						if($file_format=="csv"){
							$options["csv_delimiter"]=$csv_delimiter;
							$options["csv_enclose"]=$csv_enclose;
							$options["csv_lineend"]=$csv_lineend;
							$options["csv_fieldnames"]=$csv_fieldnames;
						}
						weCustomerEI::exportCustomers($options);
					}

					$hiddens.=we_htmlElement::htmlHidden(array("name"=>"art","value"=>"export")).
								 	(count($customers) ?
								 		(
								 		we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eiload")).
								 		we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"do_export")).
								 		we_htmlElement::htmlHidden(array("name"=>"firstexec","value"=>"0")).
								 		we_htmlElement::htmlHidden(array("name"=>"all","value"=>$all)).
								 		we_htmlElement::htmlHidden(array("name"=>"customers","value"=>makeCSVFromArray($customers)))
								 		)
								 		:
								 		(
								 		we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eiload")).
								 		we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"end_export"))
								 		)
								 	);


					$exports = count($customers);
					if($all!=0) $percent = (int)((($all - $exports + 2) / $all) * 100);
					else $percent=0;
					if ($percent < 0) {
						$percent = 0;
					} else if ($percent > 100) {
						$percent = 100;
					}

					$progressjs= "\n".
						we_htmlElement::jsElement('
							if (top.footer.setProgress) top.footer.setProgress(' . $percent . ');
						')."\n";


					$head=WE_DEFAULT_HEAD."\n".STYLESHEET."\n".$progressjs;
					$out=we_htmlElement::htmlHtml(
										we_htmlElement::htmlHead($head).
										we_htmlElement::htmlBody(array("onLoad"=>"document.we_form.submit()"),
															we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"load","action"=>$this->frameset),$hiddens)
										)
					);

				break;
				case "end_export":
					$export_to= (isset($_REQUEST["export_to"]) && $_REQUEST["export_to"] != "") ? $_REQUEST["export_to"] : "server";
					$file_format = (isset($_REQUEST["file_format"]) && $_REQUEST["file_format"] != "") ? $_REQUEST["file_format"] : null;
					$filename = (isset($_REQUEST["filename"]) && $_REQUEST["filename"] != "") ? $_REQUEST["filename"] : null;
					$path = (isset($_REQUEST["path"]) && $_REQUEST["path"] != "") ? $_REQUEST["path"] : null;

					if($file_format=="gxml"){

						$file_name=$_SERVER["DOCUMENT_ROOT"].$path."/".$filename;
						weCustomerEI::save2File($file_name,"</webEdition>");
					}

					$head=WE_DEFAULT_HEAD."\n".STYLESHEET;
					$out=we_htmlElement::htmlHtml(
										we_htmlElement::htmlHead($head).
										we_htmlElement::htmlBody(array("onLoad"=>"document.we_form.submit()"),
															we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),
								 								we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
								 								we_htmlElement::htmlHidden(array("name"=>"step","value"=>"4")).
								 								we_htmlElement::htmlHidden(array("name"=>"export_to","value"=>$export_to)).
								 								we_htmlElement::htmlHidden(array("name"=>"filename","value"=>$filename)).
								 								we_htmlElement::htmlHidden(array("name"=>"path","value"=>$path))
															)
										)
					);
				break;
				//------------------------ Import commands --------------------------------------------------------------
				case "import_next":
					if(isset($_REQUEST["step"])){
						$js=we_htmlElement::jsElement('
									function doNext(){
										'.$this->bodyFrame.'.document.we_form.step.value++;
										'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=import&step="+'.$this->bodyFrame.'.document.we_form.step.value;
										if('.$this->bodyFrame.'.document.we_form.step.value>4){
											'.$this->bodyFrame.'.document.we_form.target="load";
											'.$this->bodyFrame.'.document.we_form.pnt.value="eiload";
										}
										'.$this->bodyFrame.'.document.we_form.submit();
									}
						');
						$head=WE_DEFAULT_HEAD."\n".$js;
						$out=we_htmlElement::htmlHtml(
										we_htmlElement::htmlHead($head).
										we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
											we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),"")
										)
						);
					}
				break;
				case "import_back":
						$js=we_htmlElement::jsElement('
							function doNext(){
								'.$this->bodyFrame.'.document.we_form.step.value--;
								'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=import&step="+'.$this->bodyFrame.'.document.we_form.step.value;
								'.$this->bodyFrame.'.document.we_form.submit();
							}
						');

						$head=WE_DEFAULT_HEAD."\n".$js;
						$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead($head).
								we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),"")
								)
						);

				break;
				case "import":

					$filename=isset($_REQUEST["filename"]) ? $_REQUEST["filename"] : "";
					$import_from=isset($_REQUEST["import_from"]) ? $_REQUEST["import_from"] : "";
					$type=isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";
					$xml_from=isset($_REQUEST["xml_from"]) ? $_REQUEST["xml_from"] : "";
					$xml_to=isset($_REQUEST["xml_to"]) ? $_REQUEST["xml_to"] : "";
					$dataset=isset($_REQUEST["dataset"]) ? $_REQUEST["dataset"] : "";
					$csv_delimiter= isset($_REQUEST["csv_delimiter"]) ? $_REQUEST["csv_delimiter"] : CSV_DELIMITER;
					$csv_enclose= isset($_REQUEST["csv_enclose"]) ? $_REQUEST["csv_enclose"] : CSV_ENCLOSE;
					$csv_lineend= isset($_REQUEST["csv_lineend"]) ? $_REQUEST["csv_lineend"] : CSV_LINEEND;
					$csv_fieldnames= isset($_REQUEST["csv_fieldnames"]) ? $_REQUEST["csv_fieldnames"] : CSV_FIELDS;


					$same= isset($_REQUEST["same"]) ? $_REQUEST["same"] : "rename";

					$field_mappings=isset($_REQUEST["field_mappings"]) ? $_REQUEST["field_mappings"] : array();
					$att_mappings=isset($_REQUEST["att_mappings"]) ? $_REQUEST["att_mappings"] : array();

					$options=array();
					$options["type"]=$type;
					$options["filename"]=$filename;
					$options["exim"]=$this->exim_number;
					if($type=="csv"){
							$options["csv_delimiter"]=$csv_delimiter;
							$options["csv_enclose"]=$csv_enclose;
							$options["csv_lineend"]=$csv_lineend;
							$options["csv_fieldnames"]=$csv_fieldnames;
					}
					else{
							$options["dataset"]=$dataset;
							$options["xml_from"]=$xml_from;
							$options["xml_to"]=$xml_to;
					}

					$filesnum=weCustomerEI::prepareImport($options);

					$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eiload")).
										we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
										we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"do_import")).
									 	we_htmlElement::htmlHidden(array("name"=>"step","value"=>"5")).
									 	we_htmlElement::htmlHidden(array("name"=>"tmpdir","value"=>$filesnum["tmp_dir"])).
									 	we_htmlElement::htmlHidden(array("name"=>"fstart","value"=>"0")).
									 	we_htmlElement::htmlHidden(array("name"=>"fcount","value"=>$filesnum["file_count"])).
									 	we_htmlElement::htmlHidden(array("name"=>"same","value"=>$same));

					foreach($field_mappings as $key=>$field) $hiddens.=we_htmlElement::htmlHidden(array("name"=>"field_mappings[$key]","value"=>"$field"));
					foreach($att_mappings as $key=>$field) $hiddens.=we_htmlElement::htmlHidden(array("name"=>"att_mappings[$key]","value"=>"$field"));

					$js=we_htmlElement::jsElement('
							function doNext(){
								'.$this->topFrame.'.step++;
								document.we_form.submit();
							}
					');
					$head=WE_DEFAULT_HEAD."\n".$js;
					$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead($head).
								we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"load","action"=>$this->frameset),$hiddens)
								)
					);
				break;
				case "do_import":
					$tmpdir=isset($_REQUEST["tmpdir"]) ? $_REQUEST["tmpdir"] : "";
					$fstart=isset($_REQUEST["fstart"]) ? $_REQUEST["fstart"] : "";
					$fcount=isset($_REQUEST["fcount"]) ? $_REQUEST["fcount"] : "";
					$field_mappings=isset($_REQUEST["field_mappings"]) ? $_REQUEST["field_mappings"] : array();
					$att_mappings=isset($_REQUEST["att_mappings"]) ? $_REQUEST["att_mappings"] : array();
					$same= isset($_REQUEST["same"]) ? $_REQUEST["same"] : "rename";
					$impno=isset($_REQUEST["impno"]) ? $_REQUEST["impno"] : 0;

					if(weCustomerEI::importCustomers(array(
								"xmlfile"=>TMP_DIR."/$tmpdir/temp_$fstart.xml",
								"field_mappings"=>$field_mappings,
								"att_mappings"=>$att_mappings,
								"same"=>$same,
								"logfile"=>TMP_DIR."/$tmpdir/$tmpdir.log"
							)
					)) $impno++;
					$fstart++;

					$hiddens=we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eiload")).
										we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
										we_htmlElement::htmlHidden(array("name"=>"cmd","value"=>"do_import")).
										we_htmlElement::htmlHidden(array("name"=>"tmpdir","value"=>$tmpdir)).
										we_htmlElement::htmlHidden(array("name"=>"fstart","value"=>$fstart)).
										we_htmlElement::htmlHidden(array("name"=>"fcount","value"=>$fcount)).
										we_htmlElement::htmlHidden(array("name"=>"impno","value"=>$impno)).
										we_htmlElement::htmlHidden(array("name"=>"same","value"=>$same));

					foreach($field_mappings as $key=>$field) $hiddens.=we_htmlElement::htmlHidden(array("name"=>"field_mappings[$key]","value"=>"$field"));
					foreach($att_mappings as $key=>$field) $hiddens.=we_htmlElement::htmlHidden(array("name"=>"att_mappings[$key]","value"=>"$field"));

					if($fcount!=0 || $fcount!="0"){
						$percent = (int)(($fstart / $fcount) * 100);
						if ($percent < 0)  $percent = 0;
						else if ($percent > 100) $percent = 100;
					}

					$js=we_htmlElement::jsElement('
							function doNext(){
								'.(!($fstart<$fcount) ? 'document.we_form.cmd.value="import_end";' : 'document.we_form.cmd.value="do_import";').'
								if ('.$this->footerFrame.'.setProgress) '.$this->footerFrame.'.setProgress('.$percent.');
								document.we_form.submit();
							}
					');

					$head=WE_DEFAULT_HEAD."\n".$js;
					$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead($head).
								we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"load","action"=>$this->frameset),
										$hiddens
									)
								)
					);
				break;
				case "import_end":
					$tmpdir=isset($_REQUEST["tmpdir"]) ? $_REQUEST["tmpdir"] : "";
					$impno=isset($_REQUEST["impno"]) ? $_REQUEST["impno"] : "0";

					$js=we_htmlElement::jsElement('
							function doNext(){
									top.opener.top.content.resize.left.treeheader.applySort();
									'.$this->footerFrame.'.location="'.$this->frameset.'?pnt=eifooter&art=import&step=6";
									document.we_form.submit();
							}
					');
					$head=WE_DEFAULT_HEAD."\n".$js;
					$out=we_htmlElement::htmlHtml(
								we_htmlElement::htmlHead($head).
								we_htmlElement::htmlBody(array("bgcolor"=>"#ffffff","marginwidth"=>"5","marginheight"=>"5","leftmargin"=>"5","topmargin"=>"5","onLoad"=>"doNext()"),
									we_htmlElement::htmlForm(array("name"=>"we_form","method"=>"post","target"=>"body","action"=>$this->frameset),
										we_htmlElement::htmlHidden(array("name"=>"tmpdir","value"=>$tmpdir)).
										we_htmlElement::htmlHidden(array("name"=>"impno","value"=>$impno)).
										we_htmlElement::htmlHidden(array("name"=>"pnt","value"=>"eibody")).
										we_htmlElement::htmlHidden(array("name"=>"art","value"=>"import")).
										we_htmlElement::htmlHidden(array("name"=>"step","value"=>"5"))
									)
								)
					);
				break;
			}
		}

		return $out;

 	}

 	function getIDs($selIDs,$table){
		$ret=array();
		$tmp=array();
		foreach($selIDs as $v){
			if($v){
				$isfolder=f("SELECT IsFolder FROM ".mysql_real_escape_string($table)." WHERE ID=".abs($v),"IsFolder",$this->db);
				if($isfolder) we_readChilds($v,$tmp,$table,false);
				else	$tmp[]=$v;
			}
		}
		foreach($tmp as $v){
			$isfolder=f("SELECT IsFolder FROM ".$table." WHERE ID=".abs($v),"IsFolder",$this->db);
			if(!$isfolder) $ret[]=$v;
		}
		return $ret;
 	}

	/* creates the FileChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formFileChooser($width = "", $IDName = "ParentID", $IDValue = "/", $cmd = "", $filter = "") {

	  	$js=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
	  			we_htmlElement::jsElement('
				function formFileChooser() {
					var args = "";
					var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
					switch (arguments[0]) {
						case "browse_server":
							new jsWindow(url,"server_selector",-1,-1,700,400,true,false,true);
						break;
					}
				}
		');

		$we_button = new we_button();
	  	$button =  $we_button->create_button("select","javascript:formFileChooser('browse_server','document.we_form.elements[\\'$IDName\\'].value','$filter',document.we_form.elements['$IDName'].value,'$cmd');");

		return $js.htmlFormElementTable(htmlTextInput($IDName,30,$IDValue,"",' readonly',"text",$width,0),
			"",
			"left",
			"defaultfont",
			"",
			getPixel(20,4),
			we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $button : "");
	}

	/* creates the DirectoryChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formDirChooser($width="",$rootDirID=0,$table=FILE_TABLE,$Pathname="ParentPath",$Pathvalue="",$IDName="ParentID",$IDValue="",$cmd=""){
		$table = FILE_TABLE;

	  	$js=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).
	  			we_htmlElement::jsElement('
				function formDirChooser() {
					var args = "";
					var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
					switch (arguments[0]) {
						case "openDirselector":
							new jsWindow(url,"dir_selector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,false,true,true);
						break;
					}
				}
		');

		$we_button = new we_button();
		$button = $we_button->create_button("select", "javascript:formDirChooser('openDirselector',document.we_form.elements['$IDName'].value,'$table','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','".session_id()."','$rootDirID')");
		return $js.htmlFormElementTable(htmlTextInput($Pathname,30,$Pathvalue,"",' readonly',"text",$width,0),
			"",
			"left",
			"defaultfont",
			we_htmlElement::htmlHidden(array("name"=>$IDName,"value"=>$IDValue)),
			getPixel(20,4),
			$button);
	}




	function getHTMLCustomer() {
		global $l_customer;

		if(isset($_REQUEST["wcmd"])){
				switch($_REQUEST["wcmd"]){
					case "add_customer":
						$arr=makeArrayFromCSV($_REQUEST["customers"]);
						if(isset($_REQUEST["cus"])){
							$ids = makeArrayFromCSV($_REQUEST["cus"]);
							foreach($ids as $id){
								if(strlen($id) && (!in_array($id,$arr))) {
									array_push($arr,$id);
								}
							}
							$_REQUEST["customers"]=makeCSVFromArray($arr,true);
						}
				break;
				case "del_customer":
					$arr=makeArrayFromCSV($_REQUEST["customers"]);
					if(isset($_REQUEST["cus"])){
						foreach($arr as $k=>$v){
							if($v==$_REQUEST["cus"]) array_splice($arr,$k,1);
						}
						$_REQUEST["customers"]=makeCSVFromArray($arr,true);
					}
				break;
				case "del_all_customers":
					$_REQUEST["customers"]="";
				break;
				default:
			}
		}
		$js=we_htmlElement::jsElement('',array("src"=>JS_DIR."windows.js"));
		$js.=we_htmlElement::jsElement('
			function selector_cmd(){
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]){
					case "openSelector":
						new jsWindow(url,"we_selector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
					break;
					case "add_customer":
					case "del_customer":
					case "del_all_customers":
						document.we_form.wcmd.value=arguments[0];
						document.we_form.cus.value=arguments[1];
						document.we_form.submit();
					break;
				}
			}

			//'.$this->topFrame.'.customers="'.(isset($_REQUEST["customers"]) ? $_REQUEST["customers"] : "").'";

		');


		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

		$js.=we_htmlElement::jsElement($this->topFrame.'.customers="'.(isset($_REQUEST["customers"]) ? $_REQUEST["customers"] : "").'";');

		$hiddens=we_htmlElement::htmlHidden(array("name"=>"wcmd","value"=>"")).
						//we_htmlElement::htmlHidden(array("name"=>"customers","value"=>(isset($_REQUEST["customers"]) ? $_REQUEST["customers"] :""))).
						we_htmlElement::htmlHidden(array("name"=>"cus","value"=>(isset($_REQUEST["cus"]) ? $_REQUEST["cus"] :"")));

		$we_button = new we_button();

		$delallbut = $we_button->create_button("delete_all","javascript:selector_cmd('del_all_customers')",true,-1,-1,"","",(isset($_REQUEST["customers"]) ? false : true));
		$addbut    = $we_button->create_button("add", "javascript:selector_cmd('openSelector','','" . CUSTOMER_TABLE . "','','','fillIDs();opener.".$this->bodyFrame.".selector_cmd(\\'add_customer\\',top.allIDs);')");
		$custs = new MultiDirChooser(400,(isset($_REQUEST["customers"]) ? $_REQUEST["customers"] :""),"del_customer", $we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path", CUSTOMER_TABLE);

		if(!we_hasPerm("EDIT_KATEGORIE")) {
			$custs->isEditable=false;
		}
		return $js.$hiddens.$custs->get();
	}

	function formWeChooser($table = FILE_TABLE, $width = "", $rootDirID = 0, $IDName = "ID", $IDValue = "0",$Pathname="Path", $Pathvalue = "/", $cmd = "") {
		if ($Pathvalue == "") {
			$Pathvalue = f("SELECT Path FROM ".mysql_real_escape_string($table)." WHERE ID=" . abs($IDValue).";", "Path", $this->db);
		}

      $we_button = new we_button();
	  $button =  $we_button->create_button("select","javascript:selector_cmd('openSelector',document.we_form.elements['$IDName'].value,'$table','document.we_form.elements[\\'$IDName\\'].value','document.we_form.elements[\\'$Pathname\\'].value','".$cmd."','".session_id()."','$rootDirID')");

      return htmlFormElementTable(htmlTextInput($Pathname,30,$Pathvalue,"",'readonly',"text",$width,0),
			"",
			"left",
			"defaultfont",
			we_htmlElement::htmlHidden(array("name"=>$IDName,"value"=>$IDValue)),
			getPixel(20,4),
			$button);
	}

 	function getHTMLChooser($name,$value,$values,$title){

		$input_size=5;

		$select=new we_htmlSelect(array("name"=>$name."_select","onChange"=>"document.we_form.".$name.".value=this.options[this.selectedIndex].value;this.selectedIndex=0","style"=>"width:200;"));
		$select->addOption("","");
		foreach($values as $k=>$v) $select->addOption(htmlspecialchars($k),htmlspecialchars($v));

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0","width"=>"250"),1,3);

		$table->setColContent(0,0,htmlTextInput($name,$input_size,$value));
		$table->setColContent(0,1,getPixel(10,10));
		$table->setColContent(0,2,$select->getHtmlCode());

		 return htmlFormElementTable($table->getHtmlCode(),$title);

 	}


	function getHTMLCustomerFilter() {
		global $l_customer;

		$count=isset($_REQUEST["filter_count"]) ? $_REQUEST["filter_count"] :0;
		if(isset($_REQUEST["fcmd"])){
				switch($_REQUEST["fcmd"]){
					case "add_filter":
						$count++;
				break;
				case "del_filter":
					if($count) $count--;
					else $count=0;
				break;
				default:
			}
		}

		$js=we_htmlElement::jsElement('
			function filter_cmd(){
				switch (arguments[0]){
					case "add_filter":
					case "del_filter":
					case "del_all_filters":
						document.we_form.fcmd.value=arguments[0];
						document.we_form.submit();
						break;
				}
			}
			document.we_form.filter_count.value="'.$count.'";

		');

		$custfields=array();
		$customers_fields = array();
		$this->db->query("SHOW FIELDS FROM " . CUSTOMER_TABLE);
		while ($this->db->next_record()) {
			$customers_fields[] = $this->db->f("Field");
		}
		foreach ($customers_fields as $fk=>$fv) {
			if ($fv != "ParentID" && $fv != "IsFolder" && $fv != "Path" && $fv != "Text" && $fv != "Icon") {
				$custfields[$fv]=$fv;
			}
		}

		$operators=array("=","&lt;&gt;","&lt;","&lt;=","&gt;","&gt;=","LIKE");
		$logic=array("AND"=>"AND","OR"=>"OR");

		$table=new we_htmlTable(array("border"=>"0","cellpadding"=>"0","cellspacing"=>"0"),1,3);
		$colspan="3";

		$c=0;
		$fields_names = array("fieldname","operator","fieldvalue","logic");

		for ($i = 0; $i < $count; $i++) {
			$new=array("fieldname"=>"","operator"=>"","fieldvalue"=>"","logic"=>"");
			foreach ($fields_names as $field) {
				$varname="filter_".$field."_".$i;
				if (isset($_REQUEST[$varname])) {
					eval('$new["'.$field.'"]=$_REQUEST["'.$varname.'"];');
				}
			}
			if ($i!=0) {
				$table->addRow();
				$table->setCol($c,0,array("colspan"=>$colspan),htmlSelect("filter_logic_".$i,$logic,1,$new["logic"],false,'',"value","70"));
				$c++;
			}
			else{
				$table->addRow();
				$table->setCol($c,0,array("colspan"=>$colspan),we_htmlElement::htmlHidden(array("name"=>"filter_logic_0","value"=>"")));
				$c++;
			}

			$table->addRow();
			$table->setCol($c,0,array(),htmlSelect("filter_fieldname_".$i,$custfields,1,$new["fieldname"],false,'',"value","200"));
			$table->setCol($c,1,array(),htmlSelect("filter_operator_".$i,$operators,1,$new["operator"],false,'',"value","70"));
			$table->setCol($c,2,array(),htmlTextInput("filter_fieldvalue_".$i,16,$new["fieldvalue"]));
			$c++;
		}

		$table->addRow();
		$table->setCol($c,0,array("colspan"=>$colspan),getPixel(5,5));

		$we_button = new we_button();
		$plus = $we_button->create_button("image:btn_function_plus", "javascript:filter_cmd('add_filter')");
		$trash = $we_button->create_button("image:btn_function_trash","javascript:filter_cmd('del_filter')");

		$c++;
		$table->addRow();
		$table->setCol($c,0,array("colspan"=>$colspan),$we_button->create_button_table(array($plus,$trash)));

		return $js.
					//we_htmlElement::htmlHidden(array("name"=>"filter_count","value"=>$count)).
					we_htmlElement::htmlHidden(array("name"=>"fcmd","value"=>"")).
					$table->getHtmlCode();
	}

	function getOperator($num) {
		switch ($num) {
			case 0:
				return "=";
				break;

			case 1:
				return "<>";
				break;

			case 2:
				return "<";
				break;

			case 3:
				return "<=";
				break;

			case 4:
				return ">";
				break;

			case 5:
				return ">=";
				break;

			case 6:
				return "LIKE";
				break;
		}
	}

}

?>