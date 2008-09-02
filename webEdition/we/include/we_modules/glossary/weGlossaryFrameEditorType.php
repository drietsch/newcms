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


	class weGlossaryFrameEditorType extends weGlossaryFrameEditor {


		function Header(&$weGlossaryFrames) {

			require_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

			$we_tabs = new we_tabs();

			$we_tabs->addTab(new we_tab("#",$GLOBALS['l_glossary']['overview'],'TAB_ACTIVE',"setTab('1');"));

			$title = $GLOBALS['l_glossary']['type'] . ":&nbsp;";

			$title .= $GLOBALS['l_glossary'][array_pop(explode("_", $_REQUEST['cmdid']))];

			return weGlossaryFrameEditorType::buildHeader($weGlossaryFrames, $we_tabs, $GLOBALS['l_glossary']['type'],$GLOBALS['l_glossary'][array_pop(explode("_", $_REQUEST['cmdid']))]);

		}


		function Body(&$weGlossaryFrames) {

			include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

			$_js = "";

			$Temp = explode("_", $_REQUEST['cmdid']);
			$Type = array_pop($Temp);
			$Language = implode("_", $Temp);

			$Cache = new weGlossaryCache($Language);

			if(isset($_REQUEST['do']) && isset($_REQUEST['ID']) && sizeof($_REQUEST['ID'])>0) {

				switch($_REQUEST['do']) {

					case 'delete':
						$query = "DELETE FROM " . GLOSSARY_TABLE . " WHERE ID IN (" . implode(",", $_REQUEST['ID']) .")";
						if($GLOBALS['DB_WE']->query($query)) {
							foreach($_REQUEST['ID'] as $_id) {
								$_js .= $weGlossaryFrames->View->TopFrame.'.deleteEntry('.$_id.');';
							}
						} else {
							$_js .= '';
						}
						$Cache->write();
						break;

					case 'publish':
						$query = "UPDATE " . GLOSSARY_TABLE . " SET Published = '" . time() . "' WHERE ID IN (" . implode(",", $_REQUEST['ID']) .")";
						if($GLOBALS['DB_WE']->query($query)) {
							$_js .= '';
						} else {
							$_js .= '';
						}
						$Cache->write();
						break;

					case 'unpublish':
						$query = "UPDATE " . GLOSSARY_TABLE . " SET Published = '0' WHERE ID IN (" . implode(",", $_REQUEST['ID']) .")";
						if($GLOBALS['DB_WE']->query($query)) {
							$_js .= '';
						} else {
							$_js .= '';
						}
						$Cache->write();
						break;

					default:
						break;

				}

			}
			unset($Cache);

	        // ---> Search Start

			include_once(WE_GLOSSARY_MODULE_DIR . 'weGlossarySearch.php');

			$temp = explode("_", $_REQUEST['cmdid']);
			$Language = $temp[0] . "_" . $temp[1];
			$Type = $temp[2];

			$Rows = isset($_REQUEST['Rows']) ? $_REQUEST['Rows'] : 10;
			$Offset = isset($_REQUEST['Offset']) ? $_REQUEST['Offset']>=0?$_REQUEST['Offset']:0 : 0;
			$Order = isset($_REQUEST['Order']) ? $_REQUEST['Order'] : 'Text';
			$Sort = isset($_REQUEST['Sort']) ? $_REQUEST['Sort'] : 'ASC';
			$Where = "Language = '" . $Language. "' AND Type = '" . $Type . "'";
			if(isset($_REQUEST['Keyword'])) {
				$Where .= 	" AND ("
						.	"lcase(Text) LIKE '%" . strtolower($_REQUEST['Keyword']) . "%' OR "
						.	"lcase(Title) LIKE '%" . strtolower($_REQUEST['Keyword']) . "%' OR "
						.	"lcase(Description) LIKE '%" . strtolower($_REQUEST['Keyword']) . "%')";
			}
			if(isset($_REQUEST['GreenOnly']) && $_REQUEST['GreenOnly'] == 1) {
				$Where .=	" AND Published > 0";

			}

			$Search = new weGlossarySearch(GLOSSARY_TABLE);
			$Search->setFields(array("*"));
			$Search->setLimit($Offset, $Rows);
			$Search->setOrder($Order, $Sort);
			$Search->setWhere($Where);

			// ---> Search End


			// ---> some javascript code

			$_js .=		$weGlossaryFrames->topFrame.'.resize.right.editor.edheader.location="'.$weGlossaryFrames->frameset.'?pnt=edheader&cmd=view_type&cmdid=' . $_REQUEST['cmdid'] . '";
						' . $weGlossaryFrames->topFrame.'.resize.right.editor.edfooter.location="'.$weGlossaryFrames->frameset.'?pnt=edfooter&cmd=view_type&cmdid=' . $_REQUEST['cmdid'] . '";
		function AllItems()
		{
			if(document.we_form.selectAll.value == 0) {
				temp = true;
				document.we_form.selectAll.value = 1;
			} else {
				temp = false;
				document.we_form.selectAll.value = 0;
			}
			for (var x = 0; x< document.we_form.elements.length; x++) {
				var y = document.we_form.elements[x];
				if(y.name == \'ID[]\') {
					y.checked = temp;
				}
			}
		}
		function SubmitForm() {
			document.we_form.submit();
		}
		function next() {
			document.we_form.Offset.value = parseInt(document.we_form.Offset.value) + ' . $Rows . ';
			SubmitForm();
		}
		function prev() {
			document.we_form.Offset.value = parseInt(document.we_form.Offset.value) - ' . $Rows . ';
			SubmitForm();
		}
		function jump(val) {
			document.we_form.Offset.value = val;
			SubmitForm();
		}
		';

	        $js = we_htmlElement::jsElement($_js);

	        // ---> end of javascript

			// ---> build content

	        $content = weGlossaryFrameEditorType::getHTMLPreferences($weGlossaryFrames, $Search, $Type, $Language);

	        if($Search->countItems()) {
		        $content .= weGlossaryFrameEditorType::getHTMLPrevNext($weGlossaryFrames, $Search);
		        $content .= weGlossaryFrameEditorType::getHTMLSearchResult($weGlossaryFrames, $Search, $Language, $Type);
		        $content .= weGlossaryFrameEditorType::getHTMLPrevNext($weGlossaryFrames, $Search, true);

	        } else {
	        	$content .= '
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(632,12) . '</td>
		</tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td class="defaultfont">' . $GLOBALS['l_glossary']['no_entries_found'] . '</td>
		</tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(632,12) . '</td>
		</tr>
		</table>';

	        }

	        // ---> end of uilding content

	        $parts = array(
	        	0 => array(
		        	'headline' => '',
		        	'html' => $content,
		        	'space' => 0,
		        ),
	        );

	        $out = we_htmlElement::htmlDiv(array('id' => 'tab1','style'=>''), we_multiIconBox::getHTML('',"100%",$parts,30,'',-1,'','',false));

	        $content = $js . $out;

	        return weGlossaryFrameEditorType::buildBody($weGlossaryFrames, $content);

		}


		function Footer(&$weGlossaryFrames) {

	        return weGlossaryFrameEditorType::buildFooter($weGlossaryFrames, "");

		}


		function getHTMLSearchResult(&$weGlossaryFrames, &$Search, $Language, $Type) {

			$Search->execute();

			$retVal = "";

			$headline = array();
			$headline[0] = array(
				'dat' => '',
			);
			$headline[1] = array(
				'dat' => $GLOBALS['l_glossary']['show'],
			);
			$headline[2] = array(
				'dat' => $GLOBALS['l_glossary'][$Type],
			);

			switch($Type) {

				case 'abbreviation':
				case 'acronym':
					$headline[3] = array(
						'dat' => $GLOBALS['l_glossary']['announced_word'],
					);
					break;

				case 'foreignword':
					break;

				case 'link':
					$headline[3] = array(
						'dat' => $GLOBALS['l_glossary']['link_mode'],
					);
					$headline[4] = array(
						'dat' => $GLOBALS['l_glossary']['link_url'],
					);
					break;

			}
			$headline[] = array(
				'dat' => $GLOBALS['l_glossary']['date_published'],
			);
			$headline[] = array(
				'dat' => $GLOBALS['l_glossary']['date_modified'],
			);

			$content = array();
			while($Search->next()) {

				$show = '<img src="'.IMAGE_DIR.'we_boebbel_blau.gif" width="16" height="18">';
				if($Search->getField('Published')) {
					$show = '<img src="'.IMAGE_DIR.'we_boebbel_grau.gif" width="16" height="18">';

				}

				$temp = array();
				$temp[0] = array(
					'dat' => '<input type="checkbox" name="ID[]" value="' . $Search->getField('ID') . '" />',
					'height' => 25,
					'align' => 'center',
					'bgcolor' => '#ffffff',
				);
				$temp[1] = array(
					'dat' => $show,
					'height' => 25,
					'align' => 'center',
					'bgcolor' => '#ffffff',
				);

				$link = '<a href="javascript://" onclick="'.$weGlossaryFrames->topFrame.'.resize.right.editor.edbody.location=\''.$weGlossaryFrames->frameset.'?pnt=edbody&cmd=edit_glossary_' . $Type . '&cmdid=' . $Search->getField('ID') . '&tabnr=\'+'.$weGlossaryFrames->topFrame.'.activ_tab;">' . $Search->getField('Text') . '</a>';
				$temp[2] = array(
					'dat' => $link,
					'height' => 25,
					'align' => 'left',
					'bgcolor' => '#ffffff',
				);

				$values = unserialize($Search->getField('Attributes'));
				switch($Type) {

					case 'abbreviation':
					case 'acronym':
						$temp[3] = array(
							'dat' => ($Search->getField('Title')!="" ? $Search->getField('Title') : "-"),
							'height' => 25,
							'align' => 'left',
							'bgcolor' => '#ffffff',
						);
						break;

					case 'foreignword':
						break;

					case 'link':
						$url = "";
						switch($values['mode']) {
							case 'intern':
								$url = $values['InternLinkPath'];
								$mode = $GLOBALS['l_glossary']['link_intern'];
								break;
							case 'extern':
								$url = $values['ExternUrl'];
								$mode = $GLOBALS['l_glossary']['link_extern'];
								break;
							case 'object':
								$url = $values['ObjectLinkPath'];
								$mode = $GLOBALS['l_glossary']['link_object'];
								break;
							case 'category':
								if($values['modeCategory'] == "extern") {
									$url = $values['CategoryUrl'];
								} else {
									$url = $values['CategoryInternLinkPath'];
								}
								$mode = $GLOBALS['l_glossary']['link_category'];
								break;

						}
						$temp[3] = array(
							'dat' => $mode,
							'height' => 25,
							'align' => 'left',
							'bgcolor' => '#ffffff',
						);
						$temp[4] = array(
							'dat' => $url,
							'height' => 25,
							'align' => 'left',
							'bgcolor' => '#ffffff',
						);
						break;

				}
				$temp[] = array(
					'dat' => $Search->getField('Published')>0?str_replace(" - ", "<br />", date($GLOBALS['l_global']["date_format"],$Search->getField('Published'))):"-",
					'height' => 25,
					'align' => 'center',
					'bgcolor' => '#ffffff',
				);
				$temp[] = array(
					'dat' => $Search->getField('ModDate')>0?str_replace(" - ", "<br />", date($GLOBALS['l_global']["date_format"],$Search->getField('ModDate'))):"-",
					'height' => 25,
					'align' => 'center',
					'bgcolor' => '#ffffff',
				);
				$content[] = $temp;

			}

			$retVal .= htmlDialogBorder3(636,0, $content ,$headline);

			return $retVal;

		}


		function getHTMLPreferences(&$weGlossaryFrames, &$Search, $Type, $Language) {
			global $we_transaction;

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

			$we_button = new we_button();
			$button = $we_button->create_button("search", "javascript:SubmitForm();");
			$newButton = $we_button->create_button("new_entry", "javascript:we_cmd('new_glossary_".$Type."','".$Language."');", true, 100, 22, "", "", !we_hasPerm("NEW_GLOSSARY"));

			$_rows = array(10=>10, 25=>25, 50=>50, 100=>100);


			$out = '
		<input type="hidden" name="we_transaction" value="'.$we_transaction.'">
		<input type="hidden" name="Order" value="'.$Search->Order.'">
		<input type="hidden" name="Offset" value="'.$Search->Offset.'">
		<input type="hidden" name="Sort" value="'.$Search->Sort.'">
		<input type="hidden" name="selectAll" value="0">
		<input type="hidden" name="do" value="">
		<table width="637" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="80"></td>
			<td width="157"></td>
			<td width="280"></td>
			<td width="20"></td>
			<td width="100"></td>
		</tr>
		<tr>
			<td class="defaultgray">' . $GLOBALS['l_glossary']['search'] . '</td>
			<td colspan="2">'.htmlTextInput('Keyword', 24, isset($_REQUEST['Keyword'])?$_REQUEST['Keyword']:'', "", "style=\"width: 430px\"").'</td>
			<td>'.getPixel(18,2).'</td>
			<td>' . $button . '</td>
		</tr>
		<tr>
			<td colspan="5">'.getPixel(18,12).'</td>
		</tr>
		<tr>
			<td class="defaultgray">' . $GLOBALS['l_glossary']['view'] . '</td>
			<td>'.htmlSelect("Rows",$_rows,1,$Search->Rows,"",'onchange="SubmitForm();"').'</td>
			<td>'.we_forms::checkboxWithHidden(isset($_REQUEST['GreenOnly'])&&$_REQUEST['GreenOnly']==1?true:false, "GreenOnly", $GLOBALS['l_glossary']['show_only_visible_items'],false,"defaultfont","jump(0);").'</td>
			<td>'.getPixel(18,2).'</td>
			<td>' . $newButton . '</td>
		</tr>
		<tr>
			<td colspan="5">'.getPixel(18,12).'</td>
		</tr>
		</table>';

			return $out;

		}


		function getHTMLPrevNext(&$weGlossaryFrames, &$Search, $extended = false) {

			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

			$we_button = new we_button();

			$sum = $Search->countItems();
			$min = ($Search->Offset) + 1;
			$max = min($Search->Offset + $Search->Rows, $sum);

			if($Search->Offset > 0) {
				$prev = $we_button->create_button("back", "javascript:prev();"); //bt_back

			} else {
				$prev = $we_button->create_button("back", "",true, 100, 22, "", "", true);

			}

			if($Search->Offset + $Search->Rows >= $sum) {
				$next = $we_button->create_button("next", "", true, 100, 22, "", "", true);

			} else {
				$next = $we_button->create_button("next", "javascript:next();"); //bt_next

			}

			$pages = $Search->getPages();

			$select = htmlSelect("TmpOffset", $pages, 1, $Search->Offset, false, "onchange=\"jump(this.value);\"");

			$out = '
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(195,12) . '</td>
			<td>' . getPixel(437,12) . '</td>
		</tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . ($extended && (we_hasPerm("DELETE_GLOSSARY") || we_hasPerm("NEW_GLOSSARY")) ? $we_button->create_button("selectAll", "javascript: AllItems();") : "") . '</td>
			<td align="right"><table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td></td>
					<td>' . $prev . '</td>
					<td>' . getPixel(10,2) . '</td>
					<td class="defaultfont"><b>' . ($Search->Rows == 1 ? $min : $min . '-' . $max) . ' ' . $GLOBALS["l_global"]["from"] . ' ' . $sum . '</b></td>
					<td>' . getPixel(10,2) . '</td>
					<td>' . $next . '</td>
					<td>' . getPixel(10,2) . '</td>
					<td>' . $select . '</td>
				</tr>
				</table></td>
		</tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(195,12) . '</td>
			<td>' . getPixel(437,12) . '</td>
		</tr>
		';

			if($extended) {
				$out .= '<tr>
			<td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("DELETE_GLOSSARY") ? $we_button->create_button("image:btn_function_trash", "javascript: if(confirm('".$GLOBALS['l_glossary']["confirm_delete"]."')) { document.we_form.elements['do'].value='delete'; SubmitForm(); }") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_glossary']['delete_selected_items'] : "").'</td>
				</tr>
				</table>
			</td>
		<tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(195,12) . '</td>
			<td>' . getPixel(437,12) . '</td>
		</tr>
		<tr>
			<td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("NEW_GLOSSARY") ? $we_button->create_button("image:btn_function_publish", "javascript: if(confirm('".$GLOBALS['l_glossary']["confirm_publish"]."')) { document.we_form.elements['do'].value='publish'; SubmitForm(); }") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_glossary']['publish_selected_items'] : "").'</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>' . getPixel(5,1) . '</td>
			<td>' . getPixel(195,12) . '</td>
			<td>' . getPixel(437,12) . '</td>
		</tr>
		<tr>
			<td colspan="3">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("NEW_GLOSSARY") ? $we_button->create_button("image:btn_function_unpublish", "javascript: if(confirm('".$GLOBALS['l_glossary']["confirm_unpublish"]."')) { document.we_form.elements['do'].value='unpublish'; SubmitForm(); }") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_glossary']['unpublish_selected_items'] : "").'</td>
				</tr>
				</table>
			</td>
		</tr>';

			}

		$out .= '
		</table>';

			return $out;

		}


	}

?>