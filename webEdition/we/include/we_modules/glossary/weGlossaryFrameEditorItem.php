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


	class weGlossaryFrameEditorItem extends weGlossaryFrameEditor {


		function Header(&$weGlossaryFrames) {

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

			$we_tabs = new we_tabs();

			$title = "";

			switch($weGlossaryFrames->View->Glossary->Type) {
				case 'abbreviation':
					$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['property'],'TAB_ACTIVE',"setTab('1');"));

					$title .= $GLOBALS['l_glossary']['abbreviation'];
					break;

				case 'acronym':
					$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['property'],'TAB_ACTIVE',"setTab('1');"));

					$title .= $GLOBALS['l_glossary']['acronym'];
					break;

				case 'foreignword':
					$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['property'],'TAB_ACTIVE',"setTab('1');"));

					$title .= $GLOBALS['l_glossary']['foreignword'];
					break;

				case 'link':
					$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['property'],'TAB_ACTIVE',"setTab('1');"));

					$title .= $GLOBALS['l_glossary']['link'];
					break;
			}

			//$title .= ":&nbsp;" . ($weGlossaryFrames->View->Glossary->ID != 0 ? $weGlossaryFrames->View->Glossary->Text : $GLOBALS['l_glossary']['menu_new']).'<div id="mark" style="display: none;">*</div>';

			return weGlossaryFrameEditorItem::buildHeader($weGlossaryFrames, $we_tabs, $title,($weGlossaryFrames->View->Glossary->ID != 0 ? htmlspecialchars($weGlossaryFrames->View->Glossary->Text) : $GLOBALS['l_glossary']['menu_new']).'<div id="mark" style="display: none;">*</div>');

		}


		function Body(&$weGlossaryFrames) {

			$tabNr = isset($_REQUEST["tabnr"]) ? (($weGlossaryFrames->View->Glossary->IsFolder && $_REQUEST["tabnr"]!=1) ? 1 : $_REQUEST["tabnr"]) : 1;

			include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

			$out = we_htmlElement::jsElement('
				var table = "'.GLOSSARY_TABLE.'";

				function toggle(id){
					var elem = document.getElementById(id);
					if(elem.style.display == "none") elem.style.display = "block";
					else elem.style.display = "none";
				}

				function setVisible(id,visible){
					var elem = document.getElementById(id);
					if(visible==true) elem.style.display = "block";
					else elem.style.display = "none";
				}

				function showType(type) {
					document.getElementById("type_abbreviation").style.display = "none";
					document.getElementById("type_acronym").style.display = "none";
					document.getElementById("type_foreignword").style.display = "none";
					document.getElementById("type_link").style.display = "none";
					document.getElementById("type_" + type).style.display = "block";
					document.we_form.cmd.value = "edit_" + type;
					if(type == "link") {
						document.getElementById("btn_direction_weMultibox_table").style.display = "block";
						document.getElementById("text_weMultibox").style.display = "block";
						document.getElementById("weMultibox_div_2").style.display = "block";
						document.getElementById("weMultibox_div_3").style.display = "block";
						document.getElementById("weMultibox_div_4").style.display = "block";
						document.getElementById("weMultibox_div_5").style.display = "block";
						document.getElementById("weMultibox_div_6").style.display = "block";
						document.getElementById("weMultibox_div_7").style.display = "block";
						showLinkMode("intern");
					} else {
						document.getElementById("btn_direction_weMultibox_table").style.display = "none";
						document.getElementById("text_weMultibox").style.display = "none";
						document.getElementById("weMultibox_div_2").style.display = "none";
						document.getElementById("weMultibox_div_3").style.display = "none";
						document.getElementById("weMultibox_div_4").style.display = "none";
						document.getElementById("weMultibox_div_5").style.display = "none";
						document.getElementById("weMultibox_div_6").style.display = "none";
						document.getElementById("weMultibox_div_7").style.display = "none";
					}
				}

				function showLinkMode(mode) {
					document.getElementById("mode_intern").style.display = "none";
					document.getElementById("mode_extern").style.display = "none";
					document.getElementById("mode_object").style.display = "none";
					document.getElementById("mode_category").style.display = "none";
					document.getElementById("mode_" + mode).style.display = "block";
					if(mode == "category") {
						showLinkModeCategory("intern");
					}
				}

				function showLinkModeCategory(mode) {
					document.getElementById("mode_category_intern").style.display = "none";
					document.getElementById("mode_category_extern").style.display = "none";
					document.getElementById("mode_category_" + mode).style.display = "block";
				}

				function setHot() {
					//' . $weGlossaryFrames->topFrame.'.resize.right.editor.edheader.document.getElementById("mark").style.display = "inline";
					top.hot=1;
				}

				function setDisplay(id, display) {
					document.getElementById(id).style.display = display;
				}

				function doUnload() {
					if (!!jsWindow_count) {
						for (i = 0; i < jsWindow_count; i++) {
							eval("jsWindow" + i + "Object.close()");
						}
					}
				}
				
				function we_cmd() {
					var args = "";
					var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
					switch (arguments[0]) {
						case "populateWorkspaces":
							document.we_form.cmd.value=arguments[0];
							document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
							document.we_form.pnt.value="cmd";
							submitForm("cmd");
							break;
						case "openDocselector":
							new jsWindow(url,"we_docselector",-1,-1,'.WINDOW_DOCSELECTOR_WIDTH.','.WINDOW_DOCSELECTOR_HEIGHT.',true,true,true,true);
							break;
						case "openSelector":
							new jsWindow(url,"we_selector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
							break;
						case "openDirselector":
							new jsWindow(url,"we_selector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,true,true,true);
							break;
						case "openCatselector":
							new jsWindow(url,"we_catselector",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);
							break;
						default:
							for (var i = 0; i < arguments.length; i++) {
								args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
							}
							eval("' . $this->topFrame . '.we_cmd("+args+")");
					}
				}

				function submitForm() {

					var f = self.document.we_form;

					if (arguments[0]) {
						f.target = arguments[0];
					} else {
						f.target = "edbody";
					}

					if (arguments[1]) {
						f.action = arguments[1];
					} else {
						f.action = "'.$weGlossaryFrames->frameset.'";
					}

					if (arguments[2]) {
						f.method = arguments[2];
					} else {
						f.method = "post";
					}

					f.submit();
				}

				' . $weGlossaryFrames->topFrame.'.resize.right.editor.edheader.location="'.$weGlossaryFrames->frameset.'?pnt=edheader";'
				  .	$weGlossaryFrames->topFrame.'.resize.right.editor.edfooter.location="'.$weGlossaryFrames->frameset.'?pnt=edfooter"')
				  . we_multiIconBox::getJs();


			$out .= we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>($tabNr==1 ? '' : 'display: none')), we_multiIconBox::getHTML('weMultibox',"100%",weGlossaryFrameEditorItem::getHTMLTabProperties($weGlossaryFrames),30,'',2,$GLOBALS['l_glossary']['show_extended_linkoptions'],$GLOBALS['l_glossary']['hide_extended_linkoptions'],false));

			$js = '
				showType("'. $weGlossaryFrames->View->Glossary->Type .'");
			';
			if($weGlossaryFrames->View->Glossary->Type=="link") {
				$js .= '
				showLinkMode("'. ($weGlossaryFrames->View->Glossary->getAttribute('mode')!=""?$weGlossaryFrames->View->Glossary->getAttribute('mode'):"intern") .'");
				';
			}
			if($weGlossaryFrames->View->Glossary->getAttribute('mode')=="category") {
				$js .= '
				showLinkModeCategory("'. ($weGlossaryFrames->View->Glossary->getAttribute('modeCategory')!=""?$weGlossaryFrames->View->Glossary->getAttribute('modeCategory'):"intern") .'");
				';
			}

			$out .= we_htmlElement::jsElement($js);

	        return weGlossaryFrameEditorItem::buildBody($weGlossaryFrames, $out);

		}


		function Footer(&$weGlossaryFrames) {

			$we_button = new we_button();

			$_table = array(
				'border'		=> '0',
				'cellpadding'	=> '0',
				'cellspacing'	=> '0',
				'width'			=> '3000',
			);

			$table1 = new we_htmlTable($_table, 1, 1);
			$table1->setCol(0, 0, array("nowrap"=>null,"valign"=>"top"), getPixel(1600, 10));


			$_table = array(
				'border'		=> '0',
				'cellpadding'	=> '0',
				'cellspacing'	=> '0',
			);

			$SaveButton = $we_button->create_button("save", "javascript:if(top.publishWhenSave==1){" . $weGlossaryFrames->View->EditorBodyFrame . ".document.getElementById('Published').value=1;};we_save();",true,100,22,'','',(!we_hasPerm('NEW_GLOSSARY') && !we_hasPerm('EDIT_GLOSSARY')));
			$UnpublishButton = $we_button->create_button("deactivate", "javascript:" . $weGlossaryFrames->View->EditorBodyFrame . ".document.getElementById('Published').value=0;top.opener.top.we_cmd('save_glossary')",true,100,22,'','',(!we_hasPerm('NEW_GLOSSARY') && !we_hasPerm('EDIT_GLOSSARY')));

			$NewEntry = we_forms::checkbox("1", false, "makeNewEntry", $GLOBALS['l_glossary']['new_item_after_saving'], false, "defaultfont", "top.makeNewEntry = (this.checked) ? 1 : 0", false);
			$PublishWhenSaved = we_forms::checkbox("1", false, "publishWhenSave", $GLOBALS['l_glossary']['publish_when_saved'], false, "defaultfont", "top.publishWhenSave = (this.checked) ? 1 : 0", false);

			$ShowUnpublish = $weGlossaryFrames->View->Glossary->ID==0?true:($weGlossaryFrames->View->Glossary->Published>0 ? true : false);

			$col = 0;
			$table2 = new we_htmlTable($_table, 1, 6);
			$table2->setRow(0, array("valign"=>"middle"));
			if($ShowUnpublish) {
				$table2->setCol(0, $col++, array("nowrap"=>null), getPixel(10, 20));
				$table2->setCol(0, $col++, array("nowrap"=>null), $UnpublishButton);
			}
			$table2->setCol(0, $col++, array("nowrap"=>null), getPixel(10, 20));
			$table2->setCol(0, $col++, array("nowrap"=>null), $SaveButton);
			if(!$ShowUnpublish) {
				$table2->setCol(0, $col++, array("nowrap"=>null), getPixel(10, 20));
				$table2->setCol(0, $col++, array("nowrap"=>null), $PublishWhenSaved);
			}
			$table2->setCol(0, $col++, array("nowrap"=>null), getPixel(10, 20));
			$table2->setCol(0, $col++, array("nowrap"=>null), $NewEntry);

			$js = 		"if(top.makeNewEntry==1) {\n"
					.	"	document.getElementById('makeNewEntry').checked = true;\n"
					.	"}"
					.	"if(top.publishWhenSave==1 && document.getElementById('publishWhenSave')) {\n"
					.	"	document.getElementById('publishWhenSave').checked = true;\n"
					.	"}";
			$js = we_htmlElement::jsElement(
				$js . 
				"function we_save() {
					top.content.we_cmd('save_glossary');
					
				}
				");

			$form = we_htmlElement::htmlForm(array(),$table1->getHtmlCode().$table2->getHtmlCode().$js);

	        return weGlossaryFrameEditorItem::buildFooter($weGlossaryFrames, $form);

		}



		function getHTMLTabProperties(&$weGlossaryFrames) {

			$parts = array();

			$_types = array(
				'acronym' => $GLOBALS['l_glossary']['acronym'],
				'abbreviation' => $GLOBALS['l_glossary']['abbreviation'],
				'foreignword' => $GLOBALS['l_glossary']['foreignword'],
				'link' => $GLOBALS['l_glossary']['link'],
			);

			$hidden =	 	we_htmlElement::htmlHidden(array('name'=>'newone','value'=>($weGlossaryFrames->View->Glossary->ID==0 ? 1 : 0)))
						.	we_htmlElement::htmlHidden(array('name'=>'Published','id'=>'Published','value'=>$weGlossaryFrames->View->Glossary->ID==0?1:($weGlossaryFrames->View->Glossary->Published>0 ? 1 : 0)));

			$_languages = $GLOBALS['weFrontendLanguages'];

			$language = ($weGlossaryFrames->View->Glossary->Language!=""?$weGlossaryFrames->View->Glossary->Language:$GLOBALS['weDefaultFrontendLanguage']);

			$content = $hidden . '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $GLOBALS['l_glossary']['folder'] . '</td>
					</tr>
					<tr>
						<td>
							' . htmlSelect("Language", $_languages, 1, $language, false, " onchange=\"top.content.setHot();\"", "value", 520) . '</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $GLOBALS['l_glossary']['type'] . '</td>
					</tr>
					<tr>
						<td>
							' . htmlSelect("Type", $_types, 1, $weGlossaryFrames->View->Glossary->Type, false, " onchange=\"top.content.setHot();showType(this.value);\"", "value", 520) . '</td>
					</tr>
				</table>';

			$item = array(
				"headline" => $GLOBALS['l_glossary']['path'],
				"html" => $content,
				"space" => 120
			);
			array_push($parts, $item);


			$html = weGlossaryFrameEditorItem::getHTMLAbbreviation($weGlossaryFrames) .
					weGlossaryFrameEditorItem::getHTMLAcronym($weGlossaryFrames) .
					weGlossaryFrameEditorItem::getHTMLForeignWord($weGlossaryFrames) .
					weGlossaryFrameEditorItem::getHTMLLink($weGlossaryFrames);

			$item = array(
				"headline" => $GLOBALS['l_glossary']['selection'],
				"html" => $html,
				"space" => 120,
				'noline' => 1,
			);
			array_push($parts, $item);

			$items = weGlossaryFrameEditorItem::getHTMLLinkAttributes($weGlossaryFrames);
			$parts = array_merge($parts, $items);

			return $parts;

		}


		function getHTMLAbbreviation(&$weGlossaryFrames) {

			$text = $GLOBALS['l_glossary']['abbreviation'];
			$title = $GLOBALS['l_glossary']['announced_word'];
			$language = $GLOBALS['l_glossary']['language'];

			$_text = "";
			$_title = "";
			$_language = "";

			if($weGlossaryFrames->View->Glossary->Type == "abbreviation") {
				$_text = unhtmlentities($weGlossaryFrames->View->Glossary->Text);
				$_title = unhtmlentities($weGlossaryFrames->View->Glossary->Title);
				$_language = $weGlossaryFrames->View->Glossary->getAttribute('lang');

			}

			$pre = '<div id="type_abbreviation" style="display: block;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $text . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("abbreviation[Text]", 24, $_text, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $title . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("abbreviation[Title]", 24, $_title, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							' . weGlossaryFrameEditorItem::getLangField("abbreviation[Attributes][lang]", $_language, $language, 520) . '</td>
					</tr>
				</table>
				</div>';

			return $pre . $content . $post;

		}


		function getHTMLAcronym(&$weGlossaryFrames) {

			$text = $GLOBALS['l_glossary']['acronym'];
			$title = $GLOBALS['l_glossary']['announced_word'];
			$language = $GLOBALS['l_glossary']['language'];

			$_text = "";
			$_title = "";
			$_language = "";

			if($weGlossaryFrames->View->Glossary->Type == "acronym") {
				$_text = unhtmlentities($weGlossaryFrames->View->Glossary->Text);
				$_title = unhtmlentities($weGlossaryFrames->View->Glossary->Title);
				$_language = $weGlossaryFrames->View->Glossary->getAttribute('lang');

			}

			$pre = '<div id="type_acronym" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $text . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("acronym[Text]", 24, $_text, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $title . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("acronym[Title]", 24, $_title, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							' . weGlossaryFrameEditorItem::getLangField("acronym[Attributes][lang]", $_language, $language, 520) . '</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		function getHTMLForeignWord(&$weGlossaryFrames) {

			$text = $GLOBALS['l_glossary']['foreignword'];
			$language = $GLOBALS['l_glossary']['language'];

			$_text = "";
			$_language = "";

			if($weGlossaryFrames->View->Glossary->Type == "foreignword") {
				$_text = unhtmlentities($weGlossaryFrames->View->Glossary->Text);
				$_language = $weGlossaryFrames->View->Glossary->getAttribute('lang');

			}

			$pre = '<div id="type_foreignword" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $text . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("foreignword[Text]", 24, $_text, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							' . weGlossaryFrameEditorItem::getLangField("foreignword[Attributes][lang]", $_language, $language, 520) . '</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		function getHTMLLink(&$weGlossaryFrames) {

			$text = $GLOBALS['l_glossary']['link'];

			$_text = "";
			$_mode = "";

			if($weGlossaryFrames->View->Glossary->Type == "link") {
				$_text = unhtmlentities($weGlossaryFrames->View->Glossary->Text);
				$_mode = $weGlossaryFrames->View->Glossary->getAttribute('mode');

			}

			$_modes = array(
				'intern' => $GLOBALS['l_glossary']['link_intern'],
				'extern' => $GLOBALS['l_glossary']['link_extern'],
				'object' => $GLOBALS['l_glossary']['link_object'],
				'category' => $GLOBALS['l_glossary']['link_category'],
			);

			$pre = '<div id="type_link" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $text . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput("link[Text]", 24, $_text, 255, 'onChange="setHot();"', "text", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							'.htmlSelect("link[Attributes][mode]", $_modes, 1, $_mode, false, " onchange=\"setHot();showLinkMode(this.value);\"", "value", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
				</table>';

			$content .= weGlossaryFrameEditorItem::getHTMLIntern($weGlossaryFrames);
			$content .= weGlossaryFrameEditorItem::getHTMLExtern($weGlossaryFrames);
			$content .= weGlossaryFrameEditorItem::getHTMLObject($weGlossaryFrames);
			$content .= weGlossaryFrameEditorItem::getHTMLCategory($weGlossaryFrames);

			return $pre . $content . $post;

		}


		function getHTMLIntern(&$weGlossaryFrames) {

			$parameter = $GLOBALS['l_glossary']['parameter'];

			$we_button = new we_button();

			$_rootDirID = 0;
			$_cmd = "javascript:we_cmd('openDocselector',document.we_form.elements['link[Attributes][InternLinkID]'].value,'".FILE_TABLE."','document.we_form.elements[\\'link[Attributes][InternLinkID]\\'].value','document.we_form.elements[\\'link[Attributes][InternLinkPath]\\'].value','','".session_id()."','$_rootDirID')";
			$_button = $we_button->create_button('select', $_cmd,true,100,22,'','',false);

			$_linkPath = "";
			$_linkID = "";
			$_internParameter = "";
			if($weGlossaryFrames->View->Glossary->Type == "link" && $weGlossaryFrames->View->Glossary->getAttribute('mode') == "intern") {
				//$_linkPath = $weGlossaryFrames->View->Glossary->getAttribute('InternLinkPath');
				$_linkID = $weGlossaryFrames->View->Glossary->getAttribute('InternLinkID');
				$_linkPath = id_to_path($_linkID);
				$weGlossaryFrames->View->Glossary->setAttribute('InternLinkPath',$_linkPath);
				$_internParameter = $weGlossaryFrames->View->Glossary->getAttribute('InternParameter');
			}

			$selector = htmlFormElementTable(htmlTextInput('link[Attributes][InternLinkPath]',58,$_linkPath,'','onchange="setHot();" readonly','text',400,0),
				'',
				'left',
				'defaultfont',
				we_htmlElement::htmlHidden(array('name'=>'link[Attributes][InternLinkID]',"value"=>$_linkID)),
				getPixel(20,4),
				$_button
			);

			$pre = '<div id="mode_intern" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							'.$selector.'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $parameter . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][InternParameter]',58,$_internParameter,'','onchange="setHot();"','text',520,0).'</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		function getHTMLExtern(&$weGlossaryFrames) {

			$parameter = $GLOBALS['l_glossary']['parameter'];

			$_url = "http://";
			$_parameter = "";
			if($weGlossaryFrames->View->Glossary->Type == "link" && $weGlossaryFrames->View->Glossary->getAttribute('mode') == "extern") {
				$_url = $weGlossaryFrames->View->Glossary->getAttribute('ExternUrl');
				$_parameter = $weGlossaryFrames->View->Glossary->getAttribute('ExternParameter');

			}

			$pre = '<div id="mode_extern" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][ExternUrl]',58,$_url,'','onchange="setHot();"','text',520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $parameter . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][ExternParameter]',58,$_parameter,'','onchange="setHot();"','text',520,0).'</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		function getHTMLObject(&$weGlossaryFrames) {

			include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weDynList.class.php');

			$workspace = $GLOBALS['l_glossary']['workspace'];
			$parameter = $GLOBALS['l_glossary']['parameter'];

			$_linkPath = "";
			$_linkID = "";
			$_workspaceID = "";
			$_parameter = "";
			if($weGlossaryFrames->View->Glossary->Type == "link" && $weGlossaryFrames->View->Glossary->getAttribute('mode') == "object") {
				$_linkPath = $weGlossaryFrames->View->Glossary->getAttribute('ObjectLinkPath');
				$_linkID = $weGlossaryFrames->View->Glossary->getAttribute('ObjectLinkID');
				$_workspaceID = $weGlossaryFrames->View->Glossary->getAttribute('ObjectWorkspaceID');
				$_parameter = $weGlossaryFrames->View->Glossary->getAttribute('ObjectParameter');

			}

			$we_button = new we_button();

			$_rootDirID = 0;
			$_cmd = defined('OBJECT_TABLE') ? "javascript:we_cmd('openDocselector',document.we_form.elements['link[Attributes][ObjectLinkID]'].value,'".OBJECT_FILES_TABLE."','document.we_form.elements[\\'link[Attributes][ObjectLinkID]\\'].value','document.we_form.elements[\\'link[Attributes][ObjectLinkPath]\\'].value','opener.we_cmd(\\'populateWorkspaces\\');','".session_id()."','$_rootDirID','objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).")" : '';
			$_button = $we_button->create_button('select', $_cmd,true,100,22,'','',false);

			$selector = htmlFormElementTable(htmlTextInput('link[Attributes][ObjectLinkPath]',58,$_linkPath,'','onchange="setHot();" readonly','text',400,0),
				'',
				'left',
				'defaultfont',
				we_htmlElement::htmlHidden(array('name'=>'link[Attributes][ObjectLinkID]',"value"=>$_linkID)),
				getPixel(20,4),
				$_button
			);


			if($this->View->Glossary->getAttribute('ObjectLinkID')!='') {
				$_wsid = weDynList::getWorkspacesForObject($this->View->Glossary->getAttribute('ObjectLinkID'));
			} else {
				$_wsid = array();
			}

			$pre = '<div id="mode_object" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							'.$selector.'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					</table>
					<div id="ObjectWorkspaceID" style="display: block;">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="defaultfont">' . $workspace . '</td>
					</tr>
					<tr>
						<td>
							'.htmlSelect('link[Attributes][ObjectWorkspaceID]',$_wsid,0,$_workspaceID,false,'style="width: ' . 520 . 'px; border: #AAAAAA solid 1px;" onChange="setHot();"','value').'</td>
					</tr>
					</table>
					</div>
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $parameter . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][ObjectParameter]',58,$_parameter,'','onchange="setHot();"','text',520,0).'</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		function getHTMLCategory(&$weGlossaryFrames) {

			$mode = $GLOBALS['l_glossary']['link_selection'];
			$catParameter = $GLOBALS['l_glossary']['parameter_name'];
			$parameter = $GLOBALS['l_glossary']['parameter'];

			$_modes = array(
				'intern' => $GLOBALS['l_glossary']['link_intern'],
				'extern' => $GLOBALS['l_glossary']['link_extern'],
			);

			$_linkPath = "/";
			$_linkID = 0;
			$_internLinkPath = "";
			$_internLinkID = "";
			$_modeCategory = 0;
			$_url = "http://";
			$_catParameter = "";
			$_parameter = "";
			if($weGlossaryFrames->View->Glossary->Type == "link" && $weGlossaryFrames->View->Glossary->getAttribute('mode') == "category") {
				$_linkPath = $weGlossaryFrames->View->Glossary->getAttribute('CategoryLinkPath');
				$_linkID = $weGlossaryFrames->View->Glossary->getAttribute('CategoryLinkID');
				$_internLinkPath = $weGlossaryFrames->View->Glossary->getAttribute('CategoryInternLinkPath');
				$_internLinkID = $weGlossaryFrames->View->Glossary->getAttribute('CategoryInternLinkID');
				$_modeCategory = $weGlossaryFrames->View->Glossary->getAttribute('modeCategory');
				$_url = $weGlossaryFrames->View->Glossary->getAttribute('CategoryUrl');
				$_catParameter = $weGlossaryFrames->View->Glossary->getAttribute('CategoryCatParameter');
				$_parameter = $weGlossaryFrames->View->Glossary->getAttribute('CategoryParameter');

			}

			$we_button = new we_button();

			$_rootDirID = 0;
			$_cmd = "javascript:we_cmd('openCatselector',document.we_form.elements['link[Attributes][CategoryLinkID]'].value,'".CATEGORY_TABLE."','document.we_form.elements[\\'link[Attributes][CategoryLinkID]\\'].value','document.we_form.elements[\\'link[Attributes][CategoryLinkPath]\\'].value','opener.setHot();','".session_id()."','$_rootDirID')";
			$_button = $we_button->create_button('select', $_cmd,true,100,22,'','',false);

			$selector1 = htmlFormElementTable(htmlTextInput('link[Attributes][CategoryLinkPath]',58,$_linkPath,'','onchange="setHot();" readonly','text',400,0),
				'',
				'left',
				'defaultfont',
				we_htmlElement::htmlHidden(array('name'=>'link[Attributes][CategoryLinkID]',"value"=>$_linkID)),
				getPixel(20,4),
				$_button
			);

			$_rootDirID = 0;
			$_cmd = "javascript:we_cmd('openDocselector',document.we_form.elements['link[Attributes][CategoryInternLinkID]'].value,'".FILE_TABLE."','document.we_form.elements[\\'link[Attributes][CategoryInternLinkID]\\'].value','document.we_form.elements[\\'link[Attributes][CategoryInternLinkPath]\\'].value','','".session_id()."','$_rootDirID')";
			$_button = $we_button->create_button('select', $_cmd,true,100,22,'','',false);

			$selector2 = htmlFormElementTable(htmlTextInput('link[Attributes][CategoryInternLinkPath]',58,$_internLinkPath,'','onchange="setHot();" readonly','text',400,0),
				'',
				'left',
				'defaultfont',
				we_htmlElement::htmlHidden(array('name'=>'link[Attributes][CategoryInternLinkID]',"value"=>$_internLinkID)),
				getPixel(20,4),
				$_button
			);

			$pre = '<div id="mode_category" style="display: none;">';
			$post = '</div>';

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							'.$selector1.'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $mode . '</td>
					</tr>
					<tr>
						<td>
							'.htmlSelect("link[Attributes][modeCategory]", $_modes, 1, $_modeCategory, false, " onchange=\"setHot();showLinkModeCategory(this.value);\"", "value", 520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					</table>
					<div id="mode_category_intern" style="display: none;">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.$selector2.'</td>
					</tr>
					</table>
					</div>
					<div id="mode_category_extern" style="display: none;">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][CategoryUrl]',58,$_url,'','onchange="setHot();"','text',520).'</td>
					</tr>
					</table>
					</div>
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $catParameter . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][CategoryCatParameter]',58,$_catParameter,'','onchange="setHot();"','text',520).'</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td class="defaultfont">' . $parameter . '</td>
					</tr>
					<tr>
						<td>
							'.htmlTextInput('link[Attributes][CategoryParameter]',58,$_parameter,'','onchange="setHot();"','text',520,0).'</td>
					</tr>
				</table>';

			return $pre . $content . $post;

		}


		// ---> Helper Methods



		function getLangField($name, $value, $title, $width) {

			$_name = md5($name);
			$_options = array(
				'' => '',
				'de' => 'de',
				'en' => 'en',
				'es' => 'es',
				'fi' => 'fi',
				'ru' => 'ru',
				'nl' => 'nl',
				'pl' => 'pl',
			);
			$_size = 1;
			$_multiple = false;
			$_attributes = "onchange=\"setHot();this.form.elements['".$name."'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;\"";
			$_compare =  "value";
			$_width = 100;

			$input = htmlTextInput($name, 15, $value, "", '', "text" , ($width-$_width));

			$select = htmlSelect($_name, $_options, $_size, "", $_multiple, $_attributes, $_compare, $_width);

			return htmlFormElementTable($input, $title, "left", "defaultfont", $select);

		}


		function getRevRel($name, $value, $title, $width) {

			$_name = md5($name);
			$_options = array(
				'' => '',
				'contents' => 'contents',
				'chapter' => 'chapter',
				'section' => 'section',
				'subsection' => 'subsection',
				'index' => 'index',
				'glossary' => 'glossary',
				'appendix' => 'appendix',
				'copyright' => 'copyright',
				'next' => 'next',
				'appendix' => 'appendix',
				'prev' => 'prev',
				'start' => 'start',
				'help' => 'help',
				'bookmark' => 'bookmark',
				'alternate' => 'alternate',
				'nofollow' => 'nofollow',
			);
			$_size = 1;
			$_multiple = false;
			$_attributes = "onchange=\"setHot();this.form.elements['".$name."'].value=this.options[this.selectedIndex].value;this.selectedIndex=-1;\"";
			$_compare =  "value";
			$_width = 100;

			$input = htmlTextInput($name, 15, $value, "", '', "text" , ($width-$_width));

			$select = htmlSelect($_name, $_options, $_size, "", $_multiple, $_attributes, $_compare, $_width);

			return htmlFormElementTable($input, $title, "left", "defaultfont", $select);

		}


		function getHTMLLinkAttributes(&$weGlossaryFrames) {


			$_parts = array();

			$_parts[] = array(
				'headline'=> '',
				'html' =>htmlAlertAttentionBox($GLOBALS['l_glossary']['linkprops_desc'],2,520),
				'space' => 120,
				'noline' => 1
			);

			$_title =  htmlFormElementTable(
				htmlTextInput('link[Title]',30,$weGlossaryFrames->View->Glossary->Title,'','onchange="setHot();"','text',520),
				$GLOBALS['l_glossary']['title']
			);

			$_anchor = htmlFormElementTable(
				htmlTextInput('link[Attributes][anchor]',30,$weGlossaryFrames->View->Glossary->getAttribute('anchor'),'','onchange="setHot();"','text',520),
				$GLOBALS['l_glossary']['anchor']
			);

			$_target = htmlFormElementTable(
				targetBox('link[Attributes][target]',30,(520-100),'',$weGlossaryFrames->View->Glossary->getAttribute('target'),'"setHot();"','text',100),
				$GLOBALS['l_glossary']['target']
			);

			$_link = htmlFormElementTable(
				htmlTextInput('link[Attributes][attribute]',30,$weGlossaryFrames->View->Glossary->getAttribute('attribute'),'','onchange="setHot();"','text',520),
				$GLOBALS['l_glossary']['link_attribute']
			);

			$_parts[] = array(
				'headline'=>$GLOBALS['l_glossary']['attributes'],
				'html'=>$_title . $_anchor . $_link . $_target,
				'space' => 120,
				'noline' => 1
			);

			$_lang = weGlossaryFrameEditorItem::getLangField('link[Attributes][lang]',$weGlossaryFrames->View->Glossary->getAttribute('lang'),$GLOBALS['l_glossary']['link_language'],520);
			$_hreflang = weGlossaryFrameEditorItem::getLangField('link[Attributes][hreflang]',$weGlossaryFrames->View->Glossary->getAttribute('hreflang'),$GLOBALS['l_glossary']['href_language'],520);

			$_parts[] = array(
				'headline'=>$GLOBALS['l_glossary']['language'],
				'html'=>	$_lang .
							$_hreflang,
				'space' => 120,
				'noline' => 1
			);

			$_accesskey = 	htmlFormElementTable(
								htmlTextInput('link[Attributes][accesskey]',30,$weGlossaryFrames->View->Glossary->getAttribute('accesskey'),'','onchange="setHot();"','text',520),
								$GLOBALS['l_glossary']['accesskey']
							);

			$_tabindex = 	htmlFormElementTable(
								htmlTextInput('link[Attributes][tabindex]',30,$weGlossaryFrames->View->Glossary->getAttribute('tabindex'),'','onchange="setHot();"','text',520),
								$GLOBALS['l_glossary']['tabindex']
							);

			$_parts[] = array(
				'headline'=> $GLOBALS['l_glossary']['keyboard'],
				'html'=>	$_accesskey . $_tabindex,
				'space' => 120,
				'noline' => 1
			);

			$_relfield = weGlossaryFrameEditorItem::getRevRel('link[Attributes][rel]',$weGlossaryFrames->View->Glossary->getAttribute('rel'),'rel',520);
			$_revfield = weGlossaryFrameEditorItem::getRevRel('link[Attributes][rev]',$weGlossaryFrames->View->Glossary->getAttribute('rev'),'rev',520);

			$_parts[] = array(
				'headline'=> $GLOBALS['l_glossary']['relation'],
				'html'=>	$_relfield . $_revfield,
				'space' => 120,
				'noline' => 1
			);

			$_input_width = 70;

			$_popup = new we_htmlTable(array('cellpadding'=>'5','cellspacing'=>'0'),4,4);

			$_popup->setCol(0,0,array('colspan'=>'2'),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_open'), 'link[Attributes][popup_open]', $GLOBALS['l_glossary']['popup_open'])
			);
			$_popup->setCol(0,2,array('colspan'=>'2'),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_center'), 'link[Attributes][popup_center]', $GLOBALS['l_glossary']['popup_center'])
			);

			$_popup->setCol(1,0,array(),
				htmlFormElementTable(
					htmlTextInput('link[Attributes][popup_xposition]',5,$weGlossaryFrames->View->Glossary->getAttribute('popup_xposition'),'','onchange="setHot();"','text',$_input_width),
					$GLOBALS['l_glossary']['popup_x']
				)
			);
			$_popup->setCol(1,1,array(),
				htmlFormElementTable(
					htmlTextInput('link[Attributes][popup_yposition]',5,$weGlossaryFrames->View->Glossary->getAttribute('popup_yposition'),'','onchange="setHot();"','text',$_input_width),
					$GLOBALS['l_glossary']['popup_y']
				)
			);
			$_popup->setCol(1,2,array(),
				htmlFormElementTable(
					htmlTextInput('link[Attributes][popup_width]',5,$weGlossaryFrames->View->Glossary->getAttribute('popup_width'),'','onchange="setHot();"','text',$_input_width),
					$GLOBALS['l_glossary']['popup_width']
				)
			);

			$_popup->setCol(1,3,array(),
				htmlFormElementTable(
					htmlTextInput('link[Attributes][popup_height]',5,$weGlossaryFrames->View->Glossary->getAttribute('popup_height'),'','onchange="setHot();"','text',$_input_width),
					$GLOBALS['l_glossary']['popup_height']
				)
			);


			$_popup->setCol(2,0,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_status'), 'link[Attributes][popup_status]', $GLOBALS['l_glossary']['popup_status'])
			);
			$_popup->setCol(2,1,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_scrollbars'), 'link[Attributes][popup_scrollbars]', $GLOBALS['l_glossary']['popup_scrollbars'])
			);
			$_popup->setCol(2,2,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_menubar'), 'link[Attributes][popup_menubar]', $GLOBALS['l_glossary']['popup_menubar'])
			);

			$_popup->setCol(3,0,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_resizable'), 'link[Attributes][popup_resizable]', $GLOBALS['l_glossary']['popup_resizable'])
			);
			$_popup->setCol(3,1,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_location'), 'link[Attributes][popup_location]', $GLOBALS['l_glossary']['popup_location'])
			);
			$_popup->setCol(3,2,array(),
				we_forms::checkboxWithHidden($weGlossaryFrames->View->Glossary->getAttribute('popup_toolbar'), 'link[Attributes][popup_toolbar]', $GLOBALS['l_glossary']['popup_toolbar'])
			);


			$_parts[] = array(
				'headline'=> $GLOBALS['l_glossary']['popup'],
				'html'=>	$_popup->getHTMLCode(),
				'space' => 120,
				'noline' => 1
			);

			return $_parts;

		}


	}

?>