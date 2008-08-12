<?php


	class weGlossaryFrameEditor {

		function buildHeader(&$weGlossaryFrames, $we_tabs, $titlePre,$titlePost) {
			$we_tabs->onResize();
			$tabsHead = $we_tabs->getHeader();
			//$bodyContent = '<div id="main" >' . getPixel(100,3) . '<div style="margin:0 0 0 5px;" id="headrow">' .we_htmlElement::htmlB($title) . "</div>" . getPixel(100,3) . $we_tabs->getHTML() . '</div>';
			$bodyContent = '<div id="main" >' . getPixel(100,3).'<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",$titlePre).':&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$titlePost).'</b></span></nobr></div>'.getPixel(100,3).$we_tabs->getHTML() . '</div>';

			$body=we_htmlElement::htmlBody(array("bgcolor"=>"white","background"=>IMAGE_DIR."backgrounds/header_with_black_line.gif","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0", "onload"=>"setFrameSize()", "onresize"=>"setFrameSize()"),
				$bodyContent
				//$table->getHtmlCode() .
				//$tabsBody
			);
			$_js =	"
			function setTab(tab) {
				".$this->topFrame.".activ_tab=tab;
				//top.content.resize.right.editor.edbody.we_cmd('switchPage',0);
			}
			top.content.hloaded = 1;\n";

	        $js = we_htmlElement::jsElement($_js);

			return $weGlossaryFrames->getHTMLDocument($body,$tabsHead.$js);

		}


		function buildBody(&$weGlossaryFrames, $content = "") {

			$_hidden = array(
				'cmd'	=> isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '',
				'cmdid'	=> isset($_REQUEST['cmdid']) ? $_REQUEST['cmdid'] : '',
				'pnt'	=> 'edbody',
			);

			$_form = array(
				'name'			=> 'we_form',
				'onsubmit'		=> 'return false',
			);

			$hidden = $weGlossaryFrames->View->getCommonHiddens($_hidden);

			$form = we_htmlElement::htmlForm($_form, $hidden . $content);

			$_body = array(
				'class' => 'weEditorBody',
				'onLoad'		=> 'loaded=1;',
				'onunload'		=>"doUnload()"
			);

			$body = we_htmlElement::htmlBody($_body, $form);

			return $weGlossaryFrames->getHTMLDocument($body,$weGlossaryFrames->View->getJSProperty());

		}


		function buildFooter(&$weGlossaryFrames, $content = "") {

			$_body = array(
				'bgcolor'		=> 'white',
				'background'	=> '/webEdition/images/edit/editfooterback.gif',
				'marginwidth'	=> '0',
				'marginheight'	=> '0',
				'leftmargin'	=> '0',
				'topmargin'		=> '0',
			);

			$body = we_htmlElement::htmlBody($_body, $content);

			return $weGlossaryFrames->getHTMLDocument($body);

		}


	}

?>