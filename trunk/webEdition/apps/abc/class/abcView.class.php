<?php
					

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/language/language_' . $GLOBALS['WE_LANGUAGE'] . '.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/apps/abc/class/abc.class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolView.class.php');

class abcView extends  weToolView {


	function abcView($frameset='',$topframe='top') {
		$this->toolName = 'abc';
		$this->db = new DB_WE();
		$this->setFramesetName($frameset);
		$this->setTopFrame($topframe);
		$this->Model=new abc();
		$this->item_pattern = '<img style=\"vertical-align: bottom\" src=\"'.IMAGE_DIR.'tree/icons/link.gif\">&nbsp;';
		$this->group_pattern = '<img style=\"vertical-align: bottom\" src=\"'.IMAGE_DIR.'tree/icons/folder.gif\">&nbsp;';
		
		
	}

	function processCommands() {

		global $l_tools,$l_abc;
		$_header_sent = false;

		if (isset($_REQUEST["cmd"])) {
		
			switch ($_REQUEST['cmd']) {
				case 'tool_abc_new':
				case 'tool_abc_new_group':
										if(!we_hasPerm('EDIT_ABC')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}
										$this->Model = new abc();
					$this->Model->setIsFolder($_REQUEST['cmd'] =='tool_abc_new_group' ? 1 : 0);
					
					print we_htmlElement::jsElement('
								'.$this->editorHeaderFrame.'.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->Model->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
					');
					break;
				case 'tool_abc_edit':
										if(!we_hasPerm('EDIT_ABC')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}
					
					$this->Model = new abc($_REQUEST['cmdid']);

					if(!$this->Model->isAllowedForUser()) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["no_perms"], WE_MESSAGE_ERROR)
						);
						$this->Model = new abc();
						$_REQUEST['home'] = true;
						break;
					}
					print we_htmlElement::jsElement('
								'.$this->editorHeaderFrame.'.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->Model->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
								if('.$this->topFrame.'.treeData){
									'.$this->topFrame.'.treeData.unselectnode();
									'.$this->topFrame.'.treeData.selectnode("'.$this->Model->ID.'");
								}
					');
					break;
				case 'tool_abc_save':
										if(!we_hasPerm('EDIT_ABC')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}
										$js='';
					if($this->Model->filenameNotValid($this->Model->Text)){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["wrongtext"], WE_MESSAGE_ERROR)
						);
						break;
					}

					if(trim($this->Model->Text) == ''){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["name_empty"], WE_MESSAGE_ERROR)
						);
						break;
					}
					$oldpath = $this->Model->Path;
					// set the path and check it
					$this->Model->setPath();
					if($this->Model->pathExists($this->Model->Path)){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["name_exists"], WE_MESSAGE_ERROR)
						);
						break;
					}
					if($this->Model->isSelf()){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_tools"]["path_nok"], WE_MESSAGE_ERROR)
						);
						break;
					}

                	$js='';

                	$newone = $this->Model->ID=='0' ? true : false;

                	if($this->Model->save()) {

	                	$this->Model->updateChildPaths($oldpath);
	                	
						if ($newone) {
							$js='
								'.$this->topFrame.'.makeNewEntry(\''.$this->Model->Icon.'\',\''.$this->Model->ID.'\',\''.$this->Model->ParentID.'\',\''.addslashes($this->Model->Text).'\',0,\''.($this->Model->IsFolder ? 'folder' : 'item').'\',\''. '' .'\',0,0);
								';
						} else {
							$js=$this->topFrame.'.updateEntry(\''.$this->Model->ID.'\',\''.$this->Model->Text.'\',\''.$this->Model->ParentID.'\',0,0,\''.($this->Model->IsFolder ? 'folder' : 'item').'\',\''. '' .'\',0,0);';
						}
	
						$js = we_htmlElement::jsElement($js . '
							'.$this->editorHeaderFrame.'.location.reload();
							' . we_message_reporting::getShowMessageCall( ($this->Model->IsFolder==1 ? $l_abc["save_group_ok"] : $l_abc["save_ok"]), WE_MESSAGE_NOTICE ) . '
							'.$this->topFrame.'.hot=0;
						');
	
						if(isset($_REQUEST['delayCmd']) && !empty($_REQUEST['delayCmd'])) {
							$js .= we_htmlElement::jsElement(
								$this->topFrame.'.we_cmd("'.$_REQUEST['delayCmd'].'"' . ((isset($_REQUEST['delayParam']) && !empty($_REQUEST['delayParam'])) ? ',"' .$_REQUEST['delayParam'].'"' : '' ) . ');
								'
							);
							$_REQUEST['delayCmd'] = '';
							if(isset($_REQUEST['delayParam'])){
								$_REQUEST['delayParam'] = '';
							}
						}

					} else {
						$js = we_htmlElement::jsElement($js . '
							'.$this->editorHeaderFrame.'.location.reload();
							' . we_message_reporting::getShowMessageCall( ($this->Model->IsFolder==1 ? $l_abc["save_group_failed"] : $l_abc["save_failed"]), WE_MESSAGE_ERROR ) . '
							'.$this->topFrame.'.hot=0;
						');
					}

					print $js;

					break;
				case 'tool_abc_delete':

					print we_htmlElement::jsElement('',array('src'=>JS_DIR . 'we_showMessage.js'));
										if ($this->Model->delete()) {
						print we_htmlElement::jsElement('
								'.$this->topFrame.'.deleteEntry("'.$this->Model->ID.'");
								setTimeout(\'' . we_message_reporting::getShowMessageCall( ($this->Model->IsFolder==1 ? $l_tools['group_deleted'] : $l_tools['item_deleted']), WE_MESSAGE_NOTICE) . '\',500);

						');
						$this->Model = new abc();
						$_REQUEST['home'] = '1';
						$_REQUEST['pnt'] = 'edbody';
					} else {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($l_tools['nothing_to_delete'], WE_MESSAGE_ERROR)
						);
					}

				break;

				default:
			}
		}

		$_SESSION["abc_session"]=serialize($this->Model);
		
		
	}


}
		?>