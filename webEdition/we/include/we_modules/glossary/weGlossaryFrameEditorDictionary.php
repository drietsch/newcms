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

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");


	class weGlossaryFrameEditorDictionary extends weGlossaryFrameEditor {


		function Header(&$weGlossaryFrames) {

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

			$we_tabs = new we_tabs();

			$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['dictionary'],'TAB_ACTIVE',"setTab('1');"));

			$title = $GLOBALS['l_glossary']['dictionary'] . ":&nbsp;".$GLOBALS['weFrontendLanguages'][substr($_REQUEST['cmdid'], 0, 5)];

			return weGlossaryFrameEditorDictionary::buildHeader($weGlossaryFrames, $we_tabs, $GLOBALS['l_glossary']['dictionary'],$GLOBALS['weFrontendLanguages'][substr($_REQUEST['cmdid'], 0, 5)]);

		}


		function Body(&$weGlossaryFrames) {

			$tabNr = isset($_REQUEST["tabnr"]) ? (($weGlossaryFrames->View->Glossary->IsFolder && $_REQUEST["tabnr"]!=1) ? 1 : $_REQUEST["tabnr"]) : 1;

			include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


			$_js =		$weGlossaryFrames->topFrame.'.resize.right.editor.edheader.location="'.$weGlossaryFrames->frameset.'?pnt=edheader&cmd=view_dictionary&cmdid=' . $_REQUEST['cmdid'] . '";'
					.	$weGlossaryFrames->topFrame.'.resize.right.editor.edfooter.location="'.$weGlossaryFrames->frameset.'?pnt=edfooter&cmd=view_dictionary&cmdid=' . $_REQUEST['cmdid'] . '"';

	        $js = we_htmlElement::jsElement($_js);

	        $out = $js . we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>($tabNr==1 ? '' : 'display: none')), we_multiIconBox::getHTML('weMultibox',"100%",weGlossaryFrameEditorDictionary::getHTMLTabProperties($weGlossaryFrames),30,'',-1,'','',false));

	        return weGlossaryFrameEditorDictionary::buildBody($weGlossaryFrames, $out);

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

			$_we_button = $we_button->create_button("save", "javascript:top.opener.top.we_cmd('save_dictionary')",true,100,22,'','',(!we_hasPerm('NEW_GLOSSARY') && !we_hasPerm('EDIT_GLOSSARY')));

			$table2 = new we_htmlTable($_table, 1, 2);
			$table2->setRow(0, array("valign"=>"middle"));
			$table2->setCol(0, 0, array("nowrap"=>null), getPixel(10, 20));
			$table2->setCol(0, 1, array("nowrap"=>null), $_we_button);

			$form = we_htmlElement::htmlForm(array(),$table1->getHtmlCode().$table2->getHtmlCode());

	        return weGlossaryFrameEditorDictionary::buildFooter($weGlossaryFrames, $form);

		}





		function getHTMLTabProperties(&$weGlossaryFrames) {

			$parts = array();

			$language = substr($_REQUEST['cmdid'], 0, 5);

			$content = '<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							' . htmlAlertAttentionBox($GLOBALS['l_glossary']['hint_dictionary'], 2, 520, true, 0) . '</td>
					</tr>
					<tr>
						<td>
							'.getPixel(2,4).'</td>
					</tr>
					<tr>
						<td>
							' . we_htmlElement::htmlTextarea(array('name'=>'Dictionary', 'cols'=>60, 'rows'=>20, 'style'=>'width:520px;'),implode("\n", weGlossary::getDictionary($language))) . '</td>
					</tr>
				</table>';

			$item = array(
				"headline" => $GLOBALS['l_glossary']['dictionary'],
				"html" => $content,
				"space" => 120
			);
			array_push($parts, $item);

			return $parts;

		}


	}

?>