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


	class weGlossaryFrameEditorFolder extends weGlossaryFrameEditor {


		function Header(&$weGlossaryFrames) {

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

			$we_tabs = new we_tabs();

			$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['overview'],'TAB_ACTIVE',"setTab('1');"));

			$title = $GLOBALS['l_glossary']['folder'] . ":&nbsp;";

			$title .= $GLOBALS['weFrontendLanguages'][substr($_REQUEST['cmdid'], 0, 5)];

			return weGlossaryFrameEditorFolder::buildHeader($weGlossaryFrames, $we_tabs, $GLOBALS['l_glossary']['folder'], $GLOBALS['weFrontendLanguages'][substr($_REQUEST['cmdid'], 0, 5)]);

		}


		function Body(&$weGlossaryFrames) {

			include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

			$_js =		$weGlossaryFrames->topFrame.'.resize.right.editor.edheader.location="'.$weGlossaryFrames->frameset.'?pnt=edheader&cmd=view_folder&cmdid=' . $_REQUEST['cmdid'] . '";'
					.	$weGlossaryFrames->topFrame.'.resize.right.editor.edfooter.location="'.$weGlossaryFrames->frameset.'?pnt=edfooter&cmd=view_folder&cmdid=' . $_REQUEST['cmdid'] . '"';

	        $js = we_htmlElement::jsElement($_js);

	        $out = we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>''), we_multiIconBox::getHTML('',"100%",weGlossaryFrameEditorFolder::getHTMLOverview($weGlossaryFrames),30,'',-1,'','',false));

	        $content = $js . $out;

	        return weGlossaryFrameEditorFolder::buildBody($weGlossaryFrames, $content);

		}


		function Footer(&$weGlossaryFrames) {

	        return weGlossaryFrameEditorFolder::buildFooter($weGlossaryFrames, "");

		}


		function getHTMLOverview(&$weGlossaryFrames) {

			$_list = array(
				'abbreviation' => $GLOBALS['l_glossary']['abbreviation'],
				'acronym' => $GLOBALS['l_glossary']['acronym'],
				'foreignword' => $GLOBALS['l_glossary']['foreignword'],
				'link' => $GLOBALS['l_glossary']['link'],
			);

			$language = substr($_REQUEST['cmdid'], 0, 5);

			$parts = array();

			$we_button = new we_button();

			foreach($_list as $key => $value) {

				$query = "SELECT count(*) as items FROM " . GLOSSARY_TABLE . " WHERE Language = '" . mysql_real_escape_string($language) . "' AND Type = '" . $key . "'";
				$items = f($query, "items", $GLOBALS['DB_WE']);

				$button = $we_button->create_button("new_glossary_" . $key, "javascript:top.opener.top.we_cmd('new_glossary_" . $key . "', '" . $_REQUEST['cmdid'] . "');", true, -1, -1, "", "", !we_hasPerm("NEW_GLOSSARY"));

				$content = '<table width="550" border="0" cellpadding="0" cellspacing="0" class="defaultfont">
						<tr>
							<td>
								' . $GLOBALS['l_glossary'][$key . '_description'] . '</td>
						</tr>
						<tr>
							<td>
								'.getPixel(2,4).'</td>
						<tr>
							<td>
								' . $GLOBALS['l_glossary']['number_of_entries'] . ': ' . $items . '</td>
						</tr>
						<tr>
							<td>
								'.getPixel(2,4).'</td>
						</tr>
						<tr>
							<td align="right">
								'.$button.'</td>
						</tr>
						</table>';

				$headline = '<a href="javascript://" onclick="'.$this->topFrame.'.resize.right.editor.edbody.location=\''.$weGlossaryFrames->frameset.'?pnt=edbody&cmd=view_type&cmdid=' . $_REQUEST['cmdid'] . '_' . $key . '&tabnr=\'+'.$weGlossaryFrames->topFrame.'.activ_tab;">' . $GLOBALS['l_glossary'][$key] . '</a>';

				array_push($parts,array("headline"=>$headline,"html"=>$content,"space"=>120));

			}

			return $parts;

		}


	}

?>