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

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

	protect();

	if(isset($_REQUEST["we_cmd"][0])){

		$out = '';

		switch($_REQUEST["we_cmd"][0]){

			case "editSource" :

				$_session = session_id();
				$_we_transaction = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : '';

				if(isset($_SESSION['we_data'][$_we_transaction][0]['Path']) && !empty($_SESSION['we_data'][$_we_transaction][0]['Path'])) {
					$_filename = $_SESSION['we_data'][$_we_transaction][0]['Path'];
				} else {
					$_filename = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : '';
				}

				$_ct = isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : '';
				$_source = isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : '###EDITORPLUGIN:EMPTYSTRING###';

				if($_source=='###EDITORPLUGIN:EMPTYSTRING###') {
					$_source=$_SESSION["we_data"][$_we_transaction][0]['elements']['data']['dat'];
				}

				// charset is necessary when encoding=true
				if(isset($_SESSION['we_data'][$_we_transaction][0]['elements']['Charset']['dat']) && !empty($_SESSION['we_data'][$_we_transaction][0]['elements']['Charset']['dat'])) {
					$charset = $_SESSION['we_data'][$_we_transaction][0]['elements']['Charset']['dat'];
				} else {
					$charset = $GLOBALS["_language"]["charset"];
				}

				$out = we_htmlElement::jsElement('
					session = "'.session_id().'";
					transaction = "'.$_we_transaction.'";
					filename = "' . addslashes($_filename) . '";
					ct = "' . $_ct . '";
					source = "' . base64_encode($_source) . '";
					if (top.plugin.isLoaded) {
						top.plugin.document.WePlugin.editSource(session,transaction,filename,source,ct,"true","' . $charset . '");
					}
				');

				break;

			case "editFile":

					$_session = session_id();
					$_we_transaction = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : '';

					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");

					$we_dt = isset($_SESSION["we_data"][$_we_transaction]) ? $_SESSION["we_data"][$_we_transaction] : "";
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_init_doc.inc.php");

					$we_doc->we_initSessDat($we_dt);

					$_filename = $we_doc->Path;
					$we_ContentType = $we_doc->ContentType;


					$_tmp_file = '/webEdition/we/tmp/' . basename($_filename);

					if (file_exists($we_doc->getElement('data'))) {
						copy($we_doc->getElement('data'), $_SERVER['DOCUMENT_ROOT']. $_tmp_file);
					} else {
						error_log("$_tmp_file not exists in " . __FILE__ . " on line " . __LINE__);
					}



					$out = we_htmlElement::jsElement('
						session = "'.session_id().'";
						transaction = "'.$_we_transaction.'";
						siteurl="http://'.$SERVER_NAME.(isset($SERVER_PORT) ? ":".$SERVER_PORT : ""). $_tmp_file . '";
						top.plugin.document.WePlugin.editFile(session,transaction,"'.addslashes($_filename).'",siteurl,"'.$we_ContentType.'");
					');

				break;
			case "setSource":

				if(isset($_SESSION["we_data"][$_REQUEST["we_cmd"][1]][0]["elements"]["data"]["dat"])){

					$_SESSION["we_data"][$_REQUEST["we_cmd"][1]][0]["elements"]["data"]["dat"]=$_REQUEST["we_cmd"][2];
					$_SESSION["we_data"][$_REQUEST["we_cmd"][1]][1]["data"]["dat"]=$_REQUEST["we_cmd"][2];

				}

			break;
			case "reloadContentFrame":

				$_we_transaction = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : '';

				$out = we_htmlElement::jsElement('
					var _EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction("'.$_we_transaction.'");
					_EditorFrame.setEditorIsHot(true);
					if (
						_EditorFrame.getEditorEditPageNr() == ' . WE_EDITPAGE_CONTENT . ' ||
						_EditorFrame.getEditorEditPageNr() == ' . WE_EDITPAGE_PREVIEW . ' ||
						_EditorFrame.getEditorEditPageNr() == ' . WE_EDITPAGE_PREVIEW_TEMPLATE . '
					) {
						if ( _EditorFrame.getEditorIsActive() ) { // reload active editor
							_EditorFrame.setEditorReloadNeeded(true);
							_EditorFrame.setEditorIsActive(true);
						} else {
							_EditorFrame.setEditorReloadNeeded(true);
						}
					}

				');

			break;
			case "setBinary":

				if(isset($_FILES['uploadfile']) && isset($_REQUEST['we_transaction'])){
					$_we_transaction = $_REQUEST['we_transaction'];
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
					$we_ContentType = $_REQUEST['contenttype'];

					$we_dt = isset($_SESSION["we_data"][$_we_transaction]) ? $_SESSION["we_data"][$_we_transaction] : "";
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_init_doc.inc.php");

					$tempName = TMP_DIR."/".md5(uniqid(rand(),1));
					move_uploaded_file($_FILES['uploadfile']["tmp_name"],$tempName);


					$we_doc->we_initSessDat($we_dt);

					if($we_ContentType == 'image/*') {
						$we_doc->setElement('data',$tempName,'image');
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
						$_dim = we_thumbnail::getimagesize($tempName);
						if(is_array($_dim) && count($_dim)>0) {
							$we_doc->setElement('width',$_dim[0],'dat');
							$we_doc->setElement('height',$_dim[1],'dat');
						}
					} else {
						$we_doc->setElement('data',$tempName,'dat');
					}

					$we_doc->saveInSession($_SESSION["we_data"][$_we_transaction]);
				}
			break;

			default:
				exit("command '" . $_REQUEST["we_cmd"][0] . "' not known!");
		}


		$charset = '';

		if(isset($_we_transaction)){
			if(isset($_SESSION['we_data'][$_we_transaction][0]['elements']['Charset']['dat'])) {
				$charset = $_SESSION['we_data'][$_we_transaction][0]['elements']['Charset']['dat'];
				header("Content-Type: text/html; charset=" . $charset);
			}
		}

		print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				$_meta_content_type = we_htmlElement::htmlMeta(array("http-equiv" => "content-type", "content" => "text/html; charset=" . ($charset ? $charset : $GLOBALS["_language"]["charset"])))
			).
			we_htmlElement::htmlBody(array("bgcolor"=>"white","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0"),
				$out
			)
		);

	}



?>