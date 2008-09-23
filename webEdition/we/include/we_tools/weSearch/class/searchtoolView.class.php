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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/searchtool.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/versions.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtool.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolView.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolSearch.class.inc.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolExp.class.inc.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/contenttypes.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/" . "weSuggest.class.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_ContentTypes.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/weMetaData/weMetaData.class.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weContentProvider.class.php');

class searchtoolView extends weToolView
{

	var $searchclass;

	var $searchclassExp;

	function searchtoolView($frameset = '', $topframe = 'top')
	{
		$this->toolName = 'weSearch';
		$this->db = new DB_WE();
		$this->setFramesetName($frameset);
		$this->setTopFrame($topframe);
		$this->Model = new searchtool();
		$this->item_pattern = '<img style=\"vertical-align: bottom\" src=\"' . IMAGE_DIR . 'tree/icons/link.gif\">&nbsp;';
		$this->group_pattern = '<img style=\"vertical-align: bottom\" src=\"' . IMAGE_DIR . 'tree/icons/folder.gif\">&nbsp;';
		$this->yuiSuggest = & weSuggest::getInstance();
		$this->searchclass = new searchtoolsearch();
		$this->searchclassExp = new searchtoolExp();
	}

	function getJSTop()
	{
		$js = '

   var activ_tab = "1";
   var hot = 0;
     
   function we_cmd() {
    var args = "";
    var url = "' . WEBEDITION_DIR . 'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
    if(' . $this->topFrame . '.hot && (arguments[0]=="tool_' . $this->toolName . '_edit" || arguments[0]=="tool_' . $this->toolName . '_new" || arguments[0]=="tool_' . $this->toolName . '_new_group" || arguments[0]=="tool_' . $this->toolName . '_exit")){
     ' . $this->editorBodyFrame . '.document.we_form.delayCmd.value = arguments[0];
     ' . $this->editorBodyFrame . '.document.we_form.delayParam.value = arguments[1];
     arguments[0] = "exit_doc_question";
    }
    switch (arguments[0]) {
     case "tool_' . $this->toolName . '_edit":
      if(' . $this->editorBodyFrame . '.loaded) {
       ' . $this->editorBodyFrame . '.document.we_form.cmd.value = arguments[0];
       ' . $this->editorBodyFrame . '.document.we_form.cmdid.value=arguments[1];
       ' . $this->editorBodyFrame . '.document.we_form.tabnr.value=' . $this->topFrame . '.activ_tab;
       ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
       ' . $this->editorBodyFrame . '.submitForm();
      } else {
       setTimeout(\'we_cmd("tool_' . $this->toolName . '_edit",\'+arguments[1]+\');\', 10);
      }
     break;
     case "tool_' . $this->toolName . '_new":
     case "tool_' . $this->toolName . '_new_group":
      if(' . $this->editorBodyFrame . '.loaded) {
       ' . $this->topFrame . '.hot = 0;
       ' . $this->editorBodyFrame . '.document.we_form.cmd.value = arguments[0];
       ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
       ' . $this->editorBodyFrame . '.document.we_form.tabnr.value = 1;
       ' . $this->editorBodyFrame . '.submitForm();
      } else {
       setTimeout(\'we_cmd("tool_' . $this->toolName . '_new");\', 10);
      }
      if(treeData){
       treeData.unselectnode();
      }
     break;
 
     case "tool_' . $this->toolName . '_exit":
      top.close();
     break;
     case "exit_doc_question":
      url = "' . $this->frameset . '?pnt=exit_doc_question&delayCmd="+' . $this->editorBodyFrame . '.document.we_form.delayCmd.value+"&delayParam="+' . $this->editorBodyFrame . '.document.we_form.delayParam.value;
      new jsWindow(url,"we_exit_doc_question",-1,-1,380,130,true,false,true);
     break;
     ' . $this->getTopJSAdditional() . '
     default:
      for (var i = 0; i < arguments.length; i++) {
       args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
      }
      eval("top.opener.top.we_cmd(" + args + ")");
    }
   }
 
   function mark() {
    hot=1;
    ' . $this->editorHeaderFrame . '.mark();
   }
 
  ';
		
		return we_htmlElement::jsElement("", array(
			"src" => JS_DIR . "windows.js"
		)) . we_htmlElement::jsElement($js);
	}

	function processCommands()
	{
		global $l_tools;
		
		if (isset($_REQUEST["cmd"])) {
			switch ($_REQUEST['cmd']) {
				case 'tool_weSearch_new' :
				case 'tool_weSearch_new_forDocuments' :
				case 'tool_weSearch_new_forTemplates' :
				case 'tool_weSearch_new_forObjects' :
				case 'tool_weSearch_new_advSearch' :
				case 'tool_weSearch_new_group' :
					$this->Model = new searchtool();
					$this->Model->setIsFolder($_REQUEST['cmd'] == 'tool_weSearch_new_group' ? 1 : 0);
					
					print 
							we_htmlElement::jsElement(
									'
        ' . $this->editorHeaderFrame . '.location="' . $this->frameset . '?pnt=edheader' . (isset(
											$_REQUEST['tabnr']) ? '&tab=' . $_REQUEST['tabnr'] : '') . '&text=' . urlencode(
											$this->Model->Text) . '";
        ' . $this->topFrame . '.resize.right.editor.edfooter.location="' . $this->frameset . '?pnt=edfooter";
     ');
					break;
				
				case 'tool_weSearch_edit' :
					$this->Model = new searchtool($_REQUEST['cmdid']);

					if (!$this->Model->isAllowedForUser()) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS["l_tools"]["no_perms"], 
												WE_MESSAGE_ERROR));
						$this->Model = new searchtool();
						$_REQUEST['home'] = true;
						break;
					}
					print 
							we_htmlElement::jsElement(
									'
        ' . $this->editorHeaderFrame . '.location="' . $this->frameset . '?pnt=edheader' . (isset(
											$_REQUEST['cmdid']) ? '&cmdid=' . $_REQUEST['cmdid'] : '') . '&text=' . urlencode(
											$this->Model->Text) . '";
        ' . $this->topFrame . '.resize.right.editor.edfooter.location="' . $this->frameset . '?pnt=edfooter";       
        if(' . $this->topFrame . '.treeData){
         ' . $this->topFrame . '.treeData.unselectnode();
         ' . $this->topFrame . '.treeData.selectnode("' . $this->Model->ID . '");
        }
     ');
					break;
				
				case 'tool_weSearch_save' :
					if (isset($_REQUEST['savedSearchName'])) {
						$this->Model->Text = $_REQUEST['savedSearchName'];
					}
					if (strlen($this->Model->Text) > 30) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS['l_weSearch']["nameTooLong"], 
												WE_MESSAGE_ERROR));
						break;
					}
					if (stristr($this->Model->Text, "'") || stristr($this->Model->Text, '"')) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS['l_weSearch']["no_hochkomma"], 
												WE_MESSAGE_ERROR));
						break;
					}
					
					if ($this->Model->filenameNotValid($this->Model->Text)) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS["l_tools"]["wrongtext"], 
												WE_MESSAGE_ERROR));
						break;
					}
					
					$this->Model->activTab = isset($_REQUEST['tabnr']) ? $_REQUEST['tabnr'] : 1;
									
					if (trim($this->Model->Text) == '') {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS["l_tools"]["name_empty"], 
												WE_MESSAGE_ERROR));
						break;
					}
					$oldpath = $this->Model->Path;
					// set the path and check it
					$this->Model->setPath();
					if ($this->Model->pathExists($this->Model->Path)) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS["l_tools"]["name_exists"], 
												WE_MESSAGE_ERROR));
						break;
					}
					if ($this->Model->isSelf()) {
						print 
								we_htmlElement::jsElement(
										we_message_reporting::getShowMessageCall(
												$GLOBALS["l_tools"]["path_nok"], 
												WE_MESSAGE_ERROR));
						break;
					}
					
					$js = '';
					
					$newone = $this->Model->ID == '0' ? true : false;
					
					$this->Model->searchDocSearch = serialize($this->Model->searchDocSearch);
					$this->Model->searchTmplSearch = serialize($this->Model->searchTmplSearch);
					$this->Model->searchAdvSearch = serialize($this->Model->searchAdvSearch);
					$this->Model->locationDocSearch = serialize($this->Model->locationDocSearch);
					$this->Model->locationTmplSearch = serialize($this->Model->locationTmplSearch);
					$this->Model->locationAdvSearch = serialize($this->Model->locationAdvSearch);
					if (isset($_REQUEST['searchFieldsAdvSearch'])) {
						$this->Model->searchFieldsAdvSearch = serialize($this->Model->searchFieldsAdvSearch);
					} else {
						$this->Model->searchFieldsAdvSearch = "";
					}
					$this->Model->search_tables_advSearch = serialize($this->Model->search_tables_advSearch);

					if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
						$this->Model->Text = utf8_decode($this->Model->Text);
						$this->Model->Path = utf8_decode($this->Model->Path);
					}

					if ($this->Model->save()) {
						$this->Model->updateChildPaths($oldpath);
				
						if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
							$this->Model->Text = utf8_encode($this->Model->Text);
							$this->Model->Path = utf8_encode($this->Model->Path);
						}
						
						if ($newone) {
							$js = '
        ' . $this->topFrame . '.makeNewEntry(\'' . $this->Model->Icon . '\',\'' . $this->Model->ID . '\',\'' . $this->Model->ParentID . '\',\'' . addslashes(
									$this->Model->Text) . '\',0,\'' . ($this->Model->IsFolder ? 'folder' : 'item') . '\',\'' . SUCHE_TABLE . '\',0,0);
        ';
						} else {
							$js = $this->topFrame . '.updateEntry(\'' . $this->Model->ID . '\',\'' . $this->Model->Text . '\',\'' . $this->Model->ParentID . '\',0,0,\'' . ($this->Model->IsFolder ? 'folder' : 'item') . '\',\'' . SUCHE_TABLE . '\',0,0);';
						}
						
						$js = we_htmlElement::jsElement(
								$js . '
       ' . $this->editorHeaderFrame . '.location.reload();
       ' . we_message_reporting::getShowMessageCall(
										($this->Model->IsFolder == 1 ? $GLOBALS['l_weSearch']["save_group_ok"] : $GLOBALS['l_weSearch']["save_ok"]), 
										WE_MESSAGE_NOTICE) . '
       ' . $this->topFrame . '.hot=0;
      ');
						
						if (isset($_REQUEST['delayCmd']) && !empty($_REQUEST['delayCmd'])) {
							$js .= we_htmlElement::jsElement(
									$this->topFrame . '.we_cmd("' . $_REQUEST['delayCmd'] . '"' . ((isset(
											$_REQUEST['delayParam']) && !empty($_REQUEST['delayParam'])) ? ',"' . $_REQUEST['delayParam'] . '"' : '') . ');
        ');
							$_REQUEST['delayCmd'] = '';
							if (isset($_REQUEST['delayParam'])) {
								$_REQUEST['delayParam'] = '';
							}
						}
					} else {
						$js = we_htmlElement::jsElement(
								$js . '
       ' . $this->editorHeaderFrame . '.location.reload();
       ' . we_message_reporting::getShowMessageCall(
										($this->Model->IsFolder == 1 ? $GLOBALS['l_weSearch']["save_group_failed"] : $GLOBALS['l_weSearch']["save_failed"]), 
										WE_MESSAGE_ERROR) . '
       ' . $this->topFrame . '.hot=0;
      ');
					}
					
					if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
						$this->Model->Text = utf8_decode($this->Model->Text);
						$this->Model->Path = utf8_decode($this->Model->Path);
					}
					
					print $js;
					$this->Model->searchDocSearch = unserialize($this->Model->searchDocSearch);
					$this->Model->searchTmplSearch = unserialize($this->Model->searchTmplSearch);
					$this->Model->searchAdvSearch = unserialize($this->Model->searchAdvSearch);
					$this->Model->locationDocSearch = unserialize($this->Model->locationDocSearch);
					$this->Model->locationTmplSearch = unserialize($this->Model->locationTmplSearch);
					$this->Model->locationAdvSearch = unserialize($this->Model->locationAdvSearch);
					if (!is_array($this->Model->searchFieldsAdvSearch) && $this->Model->searchFieldsAdvSearch != "") {
						$this->Model->searchFieldsAdvSearch = unserialize($this->Model->searchFieldsAdvSearch);
					} else {
						$this->Model->searchFieldsAdvSearch = array();
					}
					$this->Model->search_tables_advSearch = unserialize($this->Model->search_tables_advSearch);
					
					break;
				
				case 'tool_weSearch_delete' :
					print we_htmlElement::jsElement('', array(
						'src' => JS_DIR . 'we_showMessage.js'
					));
					if ($this->Model->delete()) {
						print 
								we_htmlElement::jsElement(
										'
        ' . $this->topFrame . '.deleteEntry("' . $this->Model->ID . '");
        setTimeout(\'' . we_message_reporting::getShowMessageCall(
												($this->Model->IsFolder == 1 ? $l_tools['group_deleted'] : $l_tools['item_deleted']), 
												WE_MESSAGE_NOTICE) . '\',500);
 
      ');
						$this->Model = new searchtool();
						//$_REQUEST['home'] = '0';
						$_REQUEST['pnt'] = 'edbody';
						
						print we_htmlElement::jsElement($this->topFrame . '.we_cmd("tool_weSearch_edit");
      ');
					}
					break;
				
				default :
			}
		}
		$_SESSION["weSearch_session"] = serialize($this->Model);
	}

	function getTopJSAdditional()
	{
		
		return '
   
   case "tool_weSearch_save":
    if(' . $this->editorBodyFrame . '.document.we_form.predefined.value==1) {
     ' . we_message_reporting::getShowMessageCall(
				$GLOBALS['l_weSearch']['predefinedSearchmodify'], 
				WE_MESSAGE_ERROR) . '
     break;
    }
    else if (' . $this->editorBodyFrame . '.loaded) {
     if(' . $this->editorBodyFrame . '.document.we_form.newone.value==1) {
      var name = prompt("' . $GLOBALS['l_weSearch']['nameForSearch'] . '", "");
      if (name == null) {
       break;
      } else {        
       ' . $this->editorBodyFrame . '.document.we_form.savedSearchName.value=name; 
      }
     } 
     ' . $this->editorBodyFrame . '.document.we_form.cmd.value=arguments[0];
	 //' . $this->editorBodyFrame . '.document.we_form.tabnr.value=' . $this->topFrame . '.activ_tab;
     ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
     ' . $this->editorBodyFrame . '.submitForm();
    } 
    else {
     ' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_tools"]["nothing_to_save"], 
				WE_MESSAGE_ERROR) . '
    }
    
    break;
   
   case "tool_weSearch_delete":
    if(' . $this->editorBodyFrame . '.document.we_form.predefined.value==1) {
     ' . we_message_reporting::getShowMessageCall(
				$GLOBALS['l_weSearch']['predefinedSearchdelete'], 
				WE_MESSAGE_ERROR) . '
     return;
    }   
    if(' . $this->topFrame . '.resize.right.editor.edbody.document.we_form.newone.value==1){
     ' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_tools"]["nothing_to_delete"], 
				WE_MESSAGE_ERROR) . '
     return;
    }
    ' . (!we_hasPerm(
				"DELETE_" . strtoupper($this->toolName)) ? (we_message_reporting::getShowMessageCall(
				$GLOBALS["l_tools"]["no_perms"], 
				WE_MESSAGE_ERROR)) : ('
        if (' . $this->topFrame . '.resize.right.editor.edbody.loaded) {
        
         if (confirm("' . $GLOBALS['l_weSearch']['confirmDel'] . '")) {
         
          ' . $this->topFrame . '.resize.right.editor.edbody.document.we_form.cmd.value=arguments[0];
          ' . $this->topFrame . '.resize.right.editor.edbody.document.we_form.tabnr.value=' . $this->topFrame . '.activ_tab;
          ' . $this->editorHeaderFrame . '.location="' . $this->frameset . '?home=0&pnt=edheader";
          ' . $this->topFrame . '.resize.right.editor.edfooter.location="' . $this->frameset . '?home=0&pnt=edfooter";
          ' . $this->topFrame . '.resize.right.editor.edbody.submitForm();
          
         }
         
        } else {
         ' . we_message_reporting::getShowMessageCall(
				$GLOBALS["l_tools"]["nothing_to_delete"], 
				WE_MESSAGE_ERROR) . '
        }
 
      ')) . '
          break;
         
         case "tool_weSearch_new_forDocuments":
    if (' . $this->editorBodyFrame . '.loaded) {
     ' . $this->topFrame . '.hot = 0;
        ' . $this->editorBodyFrame . '.document.we_form.cmd.value=arguments[0];
        ' . $this->topFrame . '.activ_tab=1;
           ' . $this->editorBodyFrame . '.document.we_form.tabnr.value=1;
           ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
           ' . $this->editorBodyFrame . '.submitForm();
           
       } else {
     setTimeout(\'we_cmd("tool_' . $this->toolName . '_new_forDocuments");\', 10);
    }
       if(treeData){
     treeData.unselectnode();
    }
       break;
       ' . '
   
         case "tool_weSearch_new_forTemplates":
    if (' . $this->editorBodyFrame . '.loaded) {
     ' . $this->topFrame . '.hot = 0;
     ' . $this->topFrame . '.activ_tab=2;
        ' . $this->editorBodyFrame . '.document.we_form.cmd.value=arguments[0];
           ' . $this->editorBodyFrame . '.document.we_form.tabnr.value=2;
           ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
           ' . $this->editorBodyFrame . '.submitForm();
       } else {
     setTimeout(\'we_cmd("tool_' . $this->toolName . '_new_forTemplates");\', 10);
    }
       if(treeData){
     treeData.unselectnode();
    }
       break;
       ' . '
         case "tool_weSearch_new_forObjects":       
    if (' . $this->editorBodyFrame . '.loaded) {
     ' . $this->topFrame . '.hot = 0;
     ' . $this->topFrame . '.activ_tab=3;
        ' . $this->editorBodyFrame . '.document.we_form.cmd.value=arguments[0];
           ' . $this->editorBodyFrame . '.document.we_form.tabnr.value=3;
           ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
           ' . $this->editorBodyFrame . '.submitForm();
       } else {
     setTimeout(\'we_cmd("tool_' . $this->toolName . '_new_forObjects");\', 10);
    }
       if(treeData){
     treeData.unselectnode();
    }
       break;
       ' . '
   
         case "tool_weSearch_new_advSearch":
    if (' . $this->editorBodyFrame . '.loaded) {
     ' . $this->topFrame . '.hot = 0;
     ' . $this->topFrame . '.activ_tab=3;
        ' . $this->editorBodyFrame . '.document.we_form.cmd.value=arguments[0];
           ' . $this->editorBodyFrame . '.document.we_form.tabnr.value=3;
           ' . $this->editorBodyFrame . '.document.we_form.pnt.value="edbody";
           ' . $this->editorBodyFrame . '.submitForm();
       } else {
     setTimeout(\'we_cmd("tool_' . $this->toolName . '_new_advSearch");\', 10);
    }
       if(treeData){
     treeData.unselectnode();
    }
       break;
       ';
	}

	function getSearchJS($whichSearch)
	{
		
		$h = ($GLOBALS['BROWSER'] == "IE" ? 150 : 160);
		if ($whichSearch == "AdvSearch") {
			
			$h = ($GLOBALS['BROWSER'] == "IE" ? 90 : 110);
		}
		
		$addinputRows = "";
		
		//add height of each input row to calculate the scrollContent-height
		if ($whichSearch == "AdvSearch") {
			$addinputRows = 'for(i=1;i<newID;i++) {
        scrollheight = scrollheight + 28;
       }';
		}
		
		if ($this->Model->IsFolder == 0) {
			$scrollContentFunction = '
    if (' . $this->editorBodyFrame . '.loaded) {
     var elem = document.getElementById("filterTableAdvSearch");
     newID = elem.rows.length-1;
     
     scrollheight = ' . $h . ';
     
     ' . $addinputRows . '
    
     var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
     var scrollContent = document.getElementById("scrollContent_' . $whichSearch . '");
     
     var heightDiv = ' . ($GLOBALS['BROWSER'] == "IE" ? 200 : 180) . ';
     
     if((h - heightDiv)>0){
      scrollContent.style.height = h - heightDiv;
     }
     
     if((scrollContent.offsetHeight - scrollheight)>0){
      scrollContent.style.height = (scrollContent.offsetHeight - scrollheight) +"px";
     }
    }
    else {
     setTimeout(\'sizeScrollContent();\', 1000);
    }';
		} else
			$scrollContentFunction = "";
		
		$we_button = new we_button();
		
		$anzahl = 0;
		
		switch ($whichSearch) {
			case "DocSearch" :
				$anzahl = $this->Model->anzahlDocSearch;
				break;
			case "TmplSearch" :
				$anzahl = $this->Model->anzahlTmplSearch;
				break;
			case "AdvSearch" :
				$anzahl = $this->Model->anzahlAdvSearch;
				break;
		}
		
		$objectFilesTable = defined("OBJECT_FILES_TABLE") ? OBJECT_FILES_TABLE : "";
		
		$tab = 1;
		if (isset($_REQUEST['tab'])) {
			$tab = $_REQUEST['tab'];
		} elseif (isset($_REQUEST['tabnr'])) {
			$tab = $_REQUEST['tabnr'];
		}
		
		$IE6 = false;
		//workaround for z-index ans selects in ie6
		if (($GLOBALS['BROWSER'] == "IE")) {
			$foo = explode(";", $_SERVER["HTTP_USER_AGENT"]);
			$version = abs(eregi_replace("[^0-9\\.]", "", $foo[1]));
			if ($version < 7) {
				$IE6 = true;
			}
		}
		if ($IE6) {
			$showHideSelects = 'var AnzahlSelects = ' . $this->editorBodyFrame . '.document.getElementsByTagName("select");
              for (var k = 0; k <= AnzahlSelects.length; k++ ) {
                var selectAnzahl = AnzahlSelects[k];
                var sATop = absTop(selectAnzahl);
                var sAHeight = selectAnzahl.offsetHeight;
                var sABottom = eval(sATop+sAHeight);
                var sALeft = absLeft(selectAnzahl);
                var sAWidth = selectAnzahl.offsetWidth;
                var sARight = eval(sALeft+sAWidth);
                
                if(elem.offsetTop-20<sATop && eval(elem.offsetTop+elemHeight+50)>sABottom && elem.offsetLeft<sARight && eval(elem.offsetLeft+elemWidth)>sALeft) {
                  selectAnzahl.style.visibility = "hidden";
                }
                else {
                  selectAnzahl.style.visibility = "visible";
                }
              }';
			
			$showSelects = 'var AnzahlSelects = ' . $this->editorBodyFrame . '.document.getElementsByTagName("select");
            for (var k = 0; k <= AnzahlSelects.length; k++ ) {
              var selectAnzahl = AnzahlSelects[k];
              if(selectAnzahl.style.visibility == "hidden") {
                selectAnzahl.style.visibility = "visible";
              }
            }';
		} else {
			$showHideSelects = '';
			$showSelects = '';
		}
		
		$_js = we_htmlElement::jsElement(
				'
 
  
   
   var ajaxURL = "/webEdition/rpc/rpc.php";
   var ajaxCallbackResultList = {
    success: function(o) {
     if(typeof(o.responseText) != "undefined" && o.responseText != "") {
      ' . $this->editorBodyFrame . '.document.getElementById("scrollContent_' . $whichSearch . '").innerHTML = o.responseText;
      makeAjaxRequestParametersTop();
      makeAjaxRequestParametersBottom();
      
     }
    },
    failure: function(o) {
     //alert("Failure");
    }
   }
   var ajaxCallbackParametersTop = {
    success: function(o) {
     if(typeof(o.responseText) != "undefined" && o.responseText != "") {
      ' . $this->editorBodyFrame . '.document.getElementById("parametersTop_' . $whichSearch . '").innerHTML = o.responseText;
     }
    },
    failure: function(o) {
     //alert("Failure");
    }
   }
   var ajaxCallbackParametersBottom = {
    success: function(o) {
     if(typeof(o.responseText) != "undefined" && o.responseText != "") {
      ' . $this->editorBodyFrame . '.document.getElementById("parametersBottom_' . $whichSearch . '").innerHTML = o.responseText;
     }
    },
    failure: function(o) {
     //alert("Failure");
    }
   }
   var ajaxCallbackgetMouseOverDivs = {
    success: function(o) {
     if(typeof(o.responseText) != "undefined" && o.responseText != "") {
      ' . $this->editorBodyFrame . '.document.getElementById("mouseOverDivs_' . $whichSearch . '").innerHTML = o.responseText;
     }
    },
    failure: function(o) {
     //alert("Failure");
    }
   }
   
   
   function search(newSearch) {
   
   		if(' . searchtoolsearch::checkRightTempTable() . ' && ' . searchtoolsearch::checkRightDropTable() . ') {
   			' . we_message_reporting::getShowMessageCall(
						$GLOBALS["l_weSearch"]["noTempTableRightsSearch"], 
						WE_MESSAGE_NOTICE) . '
      	}
   		else {
		    var Checks = new Array();
		 
		    if("' . $whichSearch . '"=="AdvSearch") {
		      var m = 0;
		       for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
		         var table = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
		         if(table.substring(0,23)=="search_tables_advSearch") {
		           if(escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value) == 1) {
		             Checks[m] = escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
		             m++;
		           }
		         }
		      }  
		      if(Checks.length==0) {
		     ' . we_message_reporting::getShowMessageCall(
						$GLOBALS["l_weSearch"]["nothingCheckedAdv"], 
						WE_MESSAGE_ERROR) . '      
		    }  
		     }
		     if("' . $whichSearch . '"=="DocSearch") {
		      var m = 0;
		       for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
		         var table = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
		         if(table=="searchForTextDocSearch" || table=="searchForTitleDocSearch" || table=="searchForContentDocSearch") {
		           if(escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value) == 1) {
		             Checks[m] = escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
		             m++;
		           }
		         }
		      }
		       if(Checks.length==0) {
		     ' . we_message_reporting::getShowMessageCall(
						$GLOBALS["l_weSearch"]["nothingCheckedTmplDoc"], 
						WE_MESSAGE_ERROR) . '      
		    }     
		     }
		     if("' . $whichSearch . '"=="TmplSearch") {
		      var m = 0;
		       for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
		         var table = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
		         if(table=="searchForTextTmplSearch" || table=="searchForContentTmplSearch") {
		           if(escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value) == 1) {
		             Checks[m] = escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
		             m++;
		           }
		         }
		      }
		       if(Checks.length==0) {
		     ' . we_message_reporting::getShowMessageCall(
						$GLOBALS["l_weSearch"]["nothingCheckedTmplDoc"], 
						WE_MESSAGE_ERROR) . '      
		    }     
		     }
		     
		    if(Checks.length!=0) {
		      if(newSearch) {
		       ' . $this->editorBodyFrame . '.document.we_form.searchstart' . $whichSearch . '.value=0;
		      }
		      makeAjaxRequestDoclist();
		  }
		}
   
   }
   
   function makeAjaxRequestDoclist() {
    getMouseOverDivs();
    var args = "";
    var newString = "";
    for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
     newString = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
     args += "&we_cmd["+escape(newString)+"]="+escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
    }
    ' . $this->editorBodyFrame . '.document.getElementById("scrollContent_' . $whichSearch . '").innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /><div id=\'scrollActive\'></div></td></tr></table>"; 
    YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackResultList, "protocol=json&cns=tools/weSearch&tab=' . $tab . '&cmd=GetSearchResult&whichsearch=' . $whichSearch . '&classname=' . $this->Model->ModelClassName . '&id=' . $this->Model->ID . '&we_transaction=' . $GLOBALS['we_transaction'] . '"+args+"");
   }
 
   function makeAjaxRequestParametersTop() {
    var args = "";
    var newString = "";
    for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
     newString = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
     args += "&we_cmd["+escape(newString)+"]="+escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
    }
     YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackParametersTop, "protocol=json&cns=tools/weSearch&tab=' . $tab . '&cmd=GetSearchParameters&position=top&whichsearch=' . $whichSearch . '&classname' . $this->Model->ModelClassName . '=&id=' . $this->Model->ID . '&we_transaction=' . $GLOBALS['we_transaction'] . '"+args+"");
   }
   
   function makeAjaxRequestParametersBottom() {
    var args = "";
    var newString = "";
    for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
     newString = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
     args += "&we_cmd["+escape(newString)+"]="+escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
    }
     YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackParametersBottom, "protocol=json&cns=tools/weSearch&tab=' . $tab . '&cmd=GetSearchParameters&position=bottom&whichsearch=' . $whichSearch . '&classname=' . $this->Model->ModelClassName . '&id=' . $this->Model->ID . '&we_transaction=' . $GLOBALS['we_transaction'] . '"+args+"");
   }
   
   function getMouseOverDivs() {
    var args = "";
    var newString = "";
    for(var i = 0; i < ' . $this->editorBodyFrame . '.document.we_form.elements.length; i++) {
     newString = ' . $this->editorBodyFrame . '.document.we_form.elements[i].name;
     args += "&we_cmd["+escape(newString)+"]="+escape(' . $this->editorBodyFrame . '.document.we_form.elements[i].value);
    } 
    YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackgetMouseOverDivs, "protocol=json&cns=tools/weSearch&tab=' . $tab . '&cmd=GetMouseOverDivs&whichsearch=' . $whichSearch . '&classname=' . $this->Model->ModelClassName . '&id=' . $this->Model->ID . '&we_transaction=' . $GLOBALS['we_transaction'] . '"+args+"");
   }
   
   function setView(value){
   
    ' . $this->editorBodyFrame . '.document.we_form.setView' . $whichSearch . '.value=value;
    
    search(false);
    
   }
   
   
   elem = null;
   
   function showImageDetails(picID){
    elem = document.getElementById(picID);
    elem.style.visibility = "visible";
      
   }
   
   function hideImageDetails(picID){
    elem = document.getElementById(picID);
    elem.style.visibility = "hidden";
    elem.style.left = "-9999px"; 
    
    ' . $showSelects . '
   }
 
   
   document.onmousemove = updateElem;
 
   function updateElem(e) {
    
    var h = window.innerHeight ? window.innerHeight : document.body.offsetHeight;
    var w = window.innerWidth ? window.innerWidth : document.body.offsetWidth;
    x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX;
    y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY;
    
    if (elem != null && elem.style.visibility == "visible") {
       
       elemWidth = elem.offsetWidth;
       elemHeight = elem.offsetHeight;
       elem.style.left = (x + 10) + "px"; 
       elem.style.top = (y - 120) + "px";
   
       if((w-x)<400 && (h-y)<250) { 
        elem.style.left = (x - elemWidth - 10) + "px"; 
        elem.style.top = (y - elemHeight - 10) + "px";
       }
       else if((w-x)<400) { 
        elem.style.left = (x - elemWidth - 10) + "px"; 
       }
       else if((h-y)<250) { 
        elem.style.top = (y - elemHeight - 10) + "px";
       }
       
       ' . $showHideSelects . '
    }
   }
   
   function absLeft(el) {
       return (el.offsetParent)? 
      el.offsetLeft+absLeft(el.offsetParent) : el.offsetLeft;
    }

   function absTop(el) {
      return (el.offsetParent)? 
      el.offsetTop+absTop(el.offsetParent) : el.offsetTop;
    }
   
   
   function next(anzahl){
   var scrollActive = document.getElementById("scrollActive");
   if(scrollActive==null) {
  
     ' . $this->editorBodyFrame . '.document.we_form.elements[\'searchstart' . $whichSearch . '\'].value = parseInt(' . $this->editorBodyFrame . '.document.we_form.elements[\'searchstart' . $whichSearch . '\'].value) + anzahl;
    
     search(false);
    
    }
   }
 
   function back(anzahl){
	   var scrollActive = document.getElementById("scrollActive");
	   if(scrollActive==null) {
	   
	     ' . $this->editorBodyFrame . '.document.we_form.elements[\'searchstart' . $whichSearch . '\'].value = parseInt(' . $this->editorBodyFrame . '.document.we_form.elements[\'searchstart' . $whichSearch . '\'].value) - anzahl;
	   
	     search(false);
	    
	   
	   } 
   }
 
   function openToEdit(tab,id,contentType){
    if(top.opener && top.opener.top.weEditorFrameController) {
     top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);
    } else if(top.opener.top.opener && top.opener.top.opener.top.weEditorFrameController) {
     top.opener.top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);    
    } else if(top.opener.top.opener.top.opener && top.opener.top.opener.top.opener.top.weEditorFrameController) {
     top.opener.top.opener.top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);    
    }
   }
   
   
   function setOrder(order, whichSearch){

     columns = new Array("Text", "SiteTitle", "CreationDate", "ModDate");
     for(var i=0;i<columns.length;i++) {
      if(order!=columns[i]) {
       deleteArrow = document.getElementById(""+columns[i]+"_"+whichSearch);
       deleteArrow.innerHTML = "";
      }
     }
     arrow = document.getElementById(order+"_"+whichSearch);
     foo = document.we_form.elements["Order"+whichSearch].value;
 
     if(order+" DESC"==foo){
      document.we_form.elements["Order"+whichSearch].value=order;
      arrow.innerHTML = "<img border=\"0\" width=\"11\" height=\"8\" src=\"' . IMAGE_DIR . 'arrow_sort_asc.gif\" />";
     }else{
      document.we_form.elements["Order"+whichSearch].value=order+" DESC";
      arrow.innerHTML = "<img border=\"0\" width=\"11\" height=\"8\" src=\"' . IMAGE_DIR . 'arrow_sort_desc.gif\" />";
     }
     search(false);
   }
   
   function sizeScrollContent() {
   
    ' . $scrollContentFunction . '
    
   }
 
   function init() {
    if (' . $this->editorBodyFrame . '.loaded) {
     sizeScrollContent();           
       } else {
     setTimeout(\'init());\', 10);
    }
   }
 
   var rows = ' . (isset(
						$_REQUEST["searchFieldsAdvSearch"]) ? count($_REQUEST["searchFieldsAdvSearch"]) - 1 : 0) . ';
   
   function newinputAdvSearch() {
   
    var searchFields = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchFieldsAdvSearch[__we_new_id__]', 
										$this->searchclass->getFields("__we_new_id__", ""), 
										1, 
										"", 
										false, 
										'class="defaultfont" id="searchFieldsAdvSearch[__we_new_id__]" onChange="changeit(this.value, __we_new_id__);" '))) . '";
    var locationFields = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'locationAdvSearch[__we_new_id__]', 
										$this->searchclass->getLocation(), 
										1, 
										"", 
										false, 
										'class="defaultfont" id="locationAdvSearch[__we_new_id__]"  '))) . '";
    var search = "' . addslashes(
						htmlTextInput(
								'searchAdvSearch[__we_new_id__]', 
								24, 
								"", 
								"", 
								" class=\"wetextinput\" id=\"searchAdvSearch[__we_new_id__]\" ", 
								"text", 
								170)) . '";
    
    var elem = document.getElementById("filterTableAdvSearch");
    newID = elem.rows.length-1;
    rows++;
    
    var scrollContent = document.getElementById("scrollContent_' . $whichSearch . '");
    scrollContent.style.height = scrollContent.offsetHeight - 28 +"px";
    
    if(elem){
     var newRow = document.createElement("TR");
        newRow.setAttribute("id", "filterRow_" + rows);
 
        var cell = document.createElement("TD");
        cell.innerHTML=searchFields.replace(/__we_new_id__/g,rows)+"<input type=\"hidden\" value=\"\" name=\"hidden_searchFieldsAdvSearch["+rows+"]\"";;
     newRow.appendChild(cell);
 
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_locationAdvSearch["+rows+"]");
        cell.innerHTML=locationFields.replace(/__we_new_id__/g,rows);
        newRow.appendChild(cell);
 
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rows+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rows);
        newRow.appendChild(cell);
 
        cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rows+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rows+')") . '\';
        newRow.appendChild(cell);
        
     elem.appendChild(newRow);
    }
   }
 
   function delRow(id) {
    var scrollContent = document.getElementById("scrollContent_' . $whichSearch . '");
    scrollContent.style.height = scrollContent.offsetHeight + 28 +"px";
    
    var elem = document.getElementById("filterTableAdvSearch");
    if(elem){
     trows = elem.rows;
     rowID = "filterRow_" + id;
           for (i=0;i<trows.length;i++) {
            if(rowID == trows[i].id) {
             elem.deleteRow(i);
            }
           }
    }
   }
   
   function changeit(value, rowNr){
   	var setValue = document.getElementsByName("searchAdvSearch["+rowNr+"]")[0].value;
    var from = document.getElementsByName("hidden_searchFieldsAdvSearch["+rowNr+"]")[0].value;
   	
    var searchFields = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchFieldsAdvSearch[__we_new_id__]', 
										$this->searchclass->getFields("__we_new_id__", ""), 
										1, 
										"", 
										false, 
										'class="defaultfont" id="searchFieldsAdvSearch[__we_new_id__]" onChange="changeit(this.value, __we_new_id__);" '))) . '";
    var locationFields = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'locationAdvSearch[__we_new_id__]', 
										$this->searchclass->getLocation(), 
										1, 
										"", 
										false, 
										'class="defaultfont" id="locationAdvSearch[__we_new_id__]"  '))) . '";
    var search = "' . addslashes(
						htmlTextInput(
								'searchAdvSearch[__we_new_id__]', 
								24, 
								"", 
								"", 
								" class=\"wetextinput\" id=\"searchAdvSearch[__we_new_id__]\" ", 
								"text", 
								170)) . '";
    
    var row = document.getElementById("filterRow_"+rowNr);
    var locationTD = document.getElementById("td_locationAdvSearch["+rowNr+"]");  
    var searchTD = document.getElementById("td_searchAdvSearch["+rowNr+"]"); 
    var delButtonTD = document.getElementById("td_delButton["+rowNr+"]"); 
    var location = document.getElementById("locationAdvSearch["+rowNr+"]"); 
 
    if(value=="Content") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
        row.appendChild(cell);
        
        cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
        document.getElementById("searchAdvSearch["+rowNr+"]").value = setValue;
        
    }
    else if(value=="temp_category") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
               
     var innerhtml= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td>\n"
       + "<input class=\"wetextinput\" name=\"searchAdvSearch["+rowNr+"]\" size=\"58\" value=\"\"  id=\"searchAdvSearch["+rowNr+"]\" readonly=\"1\" style=\"width: 170px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
       + "</td><td><input value=\"\" name=\"searchAdvSearchParentID["+rowNr+"]\" type=\"hidden\"></td><td><img src=\"/webEdition/images/pixel.gif\" border=\"0\" height=\"4\" width=\"5\"></td><td>\n"
       + "<table title=\"' . $GLOBALS['l_button']['select']['value'] . '\" class=\"weBtn\" style=\"width: 70px\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){we_cmd(\'openCatselector\',document.we_form.elements[\'searchAdvSearchParentID["+rowNr+"]\'].value,\'' . CATEGORY_TABLE . '\',\'document.we_form.elements[\\\\\'searchAdvSearchParentID["+rowNr+"]\\\\\'].value\',\'document.we_form.elements[\\\\\'searchAdvSearch["+rowNr+"]\\\\\'].value\',\'\',\'\',\'0\',\'\',\'\');}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
       + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" style=\"width: 58px\" unselectable=\"on\">\n"
       + "' . $GLOBALS['l_button']['select']['value'] . '\n"
       + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></td></tr></tbody></table>\n";
       
       
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=innerhtml;
        row.appendChild(cell);  
        
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
          
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    }
    else if(value=="temp_template_id" || value=="MasterTemplateID") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
          
     var innerhtml= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td>\n"
       + "<input class=\"wetextinput\" name=\"searchAdvSearch["+rowNr+"]\" size=\"58\" value=\"\"  id=\"searchAdvSearch["+rowNr+"]\" readonly=\"1\" style=\"width: 170px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
       + "</td><td><input value=\"\" name=\"searchAdvSearchParentID["+rowNr+"]\" type=\"hidden\"></td><td><img src=\"/webEdition/images/pixel.gif\" border=\"0\" height=\"4\" width=\"5\"></td><td>\n"
       + "<table title=\"' . $GLOBALS['l_button']['select']['value'] . '\" class=\"weBtn\" style=\"width: 70px\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){we_cmd(\'openDocselector\',document.we_form.elements[\'searchAdvSearchParentID["+rowNr+"]\'].value,\'' . TEMPLATES_TABLE . '\',\'document.we_form.elements[\\\\\'searchAdvSearchParentID["+rowNr+"]\\\\\'].value\',\'document.we_form.elements[\\\\\'searchAdvSearch["+rowNr+"]\\\\\'].value\',\'\',\'\',\'0\',\'\',\'\');}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
       + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" style=\"width: 58px\" unselectable=\"on\">\n"
       + "' . $GLOBALS['l_button']['select']['value'] . '\n"
       + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></td></tr></tbody></table>\n";
       
       
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=innerhtml;
        row.appendChild(cell);  
        
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
          
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    }
    else if(value=="ParentIDDoc" || value=="ParentIDObj" || value=="ParentIDTmpl") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     
     var table;
     
     if (value=="ParentIDDoc") {
      table = "' . FILE_TABLE . '";
     }
     else if (value=="ParentIDObj") {
      table = "' . $objectFilesTable . '";
     }
     else if (value=="ParentIDTmpl") {
      table = "' . TEMPLATES_TABLE . '";
     }
     
     var innerhtml= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td>\n"
       + "<input class=\"wetextinput\" name=\"searchAdvSearch["+rowNr+"]\" size=\"58\" value=\"\"  id=\"searchAdvSearch["+rowNr+"]\" readonly=\"1\" style=\"width: 170px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
       + "</td><td><input value=\"\" name=\"searchAdvSearchParentID["+rowNr+"]\" type=\"hidden\"></td><td><img src=\"/webEdition/images/pixel.gif\" border=\"0\" height=\"4\" width=\"5\"></td><td>\n"
       + "<table title=\"' . $GLOBALS['l_button']['select']['value'] . '\" class=\"weBtn\" style=\"width: 70px\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){we_cmd(\'openDirselector\',document.we_form.elements[\'searchAdvSearchParentID["+rowNr+"]\'].value,\'"+table+"\',\'document.we_form.elements[\\\\\'searchAdvSearchParentID["+rowNr+"]\\\\\'].value\',\'document.we_form.elements[\\\\\'searchAdvSearch["+rowNr+"]\\\\\'].value\',\'\',\'\',\'0\',\'\',\'\');}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
       + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" style=\"width: 58px\" unselectable=\"on\">\n"
       + "' . $GLOBALS['l_button']['select']['value'] . '\n"
       + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></td></tr></tbody></table>\n";
       
       
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=innerhtml;
        row.appendChild(cell);  
        
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
          
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    }
    else if(value=="temp_doc_type") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     search = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchAdvSearch[__we_new_id__]', 
										$this->searchclass->getDoctypes(), 
										1, 
										"", 
										false, 
										'class="defaultfont" style="width:170px;" id="searchAdvSearch[__we_new_id__]" '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
     
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
     
    }
    else if(value=="Status") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     search = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchAdvSearch[__we_new_id__]', 
										$this->searchclass->getFieldsStatus(), 
										1, 
										"", 
										false, 
										'class="defaultfont" style="width:170px;" id="searchAdvSearch[__we_new_id__]" '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
     
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
     
    }
    else if(value=="Speicherart") {
     if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     search = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchAdvSearch[__we_new_id__]', 
										$this->searchclass->getFieldsSpeicherart(), 
										1, 
										"", 
										false, 
										'class="defaultfont" style="width:170px;" id="searchAdvSearch[__we_new_id__]" '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
    
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    
    }
    else if(value=="Published" || value=="CreationDate" || value=="ModDate") {
 
     row.removeChild(locationTD);
     
     locationFields = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'locationAdvSearch[__we_new_id__]', 
										$this->searchclass->getLocation("date"), 
										1, 
										"", 
										false, 
										'class="defaultfont" id="locationAdvSearch[__we_new_id__]"  '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_locationAdvSearch["+rowNr+"]");
        cell.innerHTML=locationFields.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
     
     row.removeChild(searchTD);
     
     var innerhtml= "<table id=\"searchAdvSearch["+rowNr+"]_cell\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td></td><td></td><td>\n"
       + "<input class=\"wetextinput\" name=\"searchAdvSearch["+rowNr+"]\" size=\"55\" value=\"\" maxlength=\"10\" id=\"searchAdvSearch["+rowNr+"]\" readonly=\"1\" style=\"width: 100px;\" onblur=\"this.className=\'wetextinput\';\" onfocus=\"this.className=\'wetextinputselected\'\" type=\"text\">\n"
       + "</td><td>&nbsp;</td><td><a href=\"#\">\n"
       + "<table id=\"date_picker_from"+rowNr+"\" class=\"weBtn\" onmouseout=\"weButton.out(this);\" onmousedown=\"weButton.down(this);\" onmouseup=\"if(weButton.up(this)){;}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n" 
       + "<tbody><tr><td class=\"weBtnLeft\"></td><td class=\"weBtnMiddle\" unselectable=\"on\">\n"
       + "<img src=\"/webEdition/images/button/icons/date_picker.gif\" class=\"weBtnImage\">\n"
       + "</td><td class=\"weBtnRight\"></td></tr></tbody></table></a></td></tr></tbody></table>\n";
       
       
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=innerhtml;
        row.appendChild(cell);  
        
        Calendar.setup({inputField:"searchAdvSearch["+rowNr+"]",ifFormat:"%d.%m.%Y",button:"date_picker_from"+rowNr+"",align:"Tl",singleClick:true});
     
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
          
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
     
    }
    else if(value=="allModsIn") {
		if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     search = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchAdvSearch[__we_new_id__]', 
										$this->searchclass->getModFields(), 
										1, 
										"", 
										false, 
										'class="defaultfont" style="width:170px;" id="searchAdvSearch[__we_new_id__]" '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
     
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    }
				
	else if(value=="modifierID") {
		if (locationTD!=null) {
      location.disabled = true;
     }
     row.removeChild(searchTD);
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     search = "' . str_replace(
						"\n", 
						"\\n", 
						addslashes(
								htmlSelect(
										'searchAdvSearch[__we_new_id__]', 
										$this->searchclass->getUsers(), 
										1, 
										"", 
										false, 
										'class="defaultfont" style="width:170px;" id="searchAdvSearch[__we_new_id__]" '))) . '";
     
     var cell = document.createElement("TD");
        cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
     row.appendChild(cell);
     
     cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
    
	}
    else {
     row.removeChild(searchTD);
     
     if (locationTD!=null) {
      row.removeChild(locationTD);
     }
     if (delButtonTD!=null) {
      row.removeChild(delButtonTD);
     }
     
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_locationAdvSearch["+rowNr+"]");
        cell.innerHTML=locationFields.replace(/__we_new_id__/g,rowNr);
        row.appendChild(cell);
 
     cell = document.createElement("TD");
     cell.setAttribute("id", "td_searchAdvSearch["+rowNr+"]");
        cell.innerHTML=search.replace(/__we_new_id__/g,rowNr);
        row.appendChild(cell);
        
        cell = document.createElement("TD");
        cell.setAttribute("id", "td_delButton["+rowNr+"]");
        cell.innerHTML=\'' . $we_button->create_button(
						"image:btn_function_trash", 
						"javascript:delRow('+rowNr+')") . '\';
        row.appendChild(cell);
        
        document.getElementById("searchAdvSearch["+rowNr+"]").value = setValue;
        
    }

    if(from=="allModsIn" || from=="MasterTemplateID" || from=="ParentIDTmpl" || from=="ParentIDObj" || from=="ParentIDDoc" || from=="temp_template_id" || from=="ContentType" || from=="temp_doc_type" || from=="temp_category" || from=="Status" || from=="Speicherart" || from=="Published" || from=="CreationDate" || from=="ModDate" 
        || value =="allModsIn" || value =="MasterTemplateID" || value=="ParentIDTmpl" || value=="ParentIDObj" || value=="ParentIDDoc" || value=="temp_template_id" || value=="ContentType" || value=="temp_doc_type" || value=="temp_category" || value=="Status" || value=="Speicherart" || value=="Published" || value=="CreationDate" || value=="ModDate") {
        document.getElementById("searchAdvSearch["+rowNr+"]").value = "";
	}
	else {
	    document.getElementById("searchAdvSearch["+rowNr+"]").value = setValue;
	}
       
    document.getElementsByName("hidden_searchFieldsAdvSearch["+rowNr+"]")[0].value = value;

   }
   
   var ajaxCallbackResetVersion = {
		success: function(o) {
			//top.we_cmd("save_document","' . $GLOBALS['we_transaction'] . '","0","1","0", "","");
			' . we_message_reporting::getShowMessageCall(
						$GLOBALS['l_versions']['resetAllVersionsOK'], 
						WE_MESSAGE_NOTICE) . '
			// reload current document => reload all open Editors on demand
						
			var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
			for (frameId in _usedEditors) {

				if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
					_usedEditors[frameId].setEditorIsActive(true);

				} else {
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
				}
			}
			_multiEditorreload = true;

			//reload tree
			if(top.opener.treeData) {
				top.opener.we_cmd("load", top.opener.treeData.table ,0);
			}
			document.getElementById("resetBusyAdvSearch").innerHTML = "";
		},
		failure: function(o) {
		}
	}

	function resetVersionAjax(id, documentID, version, table) {
		document.getElementById("resetBusyAdvSearch").innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /><div id=\'scrollActive\'></div></td></tr></table>"; 
    
		YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackResetVersion, "protocol=json&cns=versionlist&cmd=ResetVersion&id="+id+"&documentID="+documentID+"&version="+version+"&documentTable="+table+"&we_transaction=' . $GLOBALS['we_transaction'] . '");
	
	}
      
	function resetVersions() {
		
		var checkboxes = new Array();
		check = false;
		var m = 0;
	       for(var i = 0; i < document.we_form.elements.length; i++) {
	         var table = document.we_form.elements[i].name;
	         if(table.substring(0,12)=="resetVersion") {
	           if(document.we_form.elements[i].checked == true) {
	             checkboxes[m] = document.we_form.elements[i].value;
	             check = true;
	             m++;
	           }
	         }
	      }  
		
		
		if(check==false) {
			' . we_message_reporting::getShowMessageCall(
						$GLOBALS['l_versions']['notChecked'], 
						WE_MESSAGE_NOTICE) . '
		}
		else {
			Check = confirm("' . $GLOBALS['l_versions']['resetVersionsSearchtool'] . '");
			if (Check == true) {
				var vals = "";
				for(var i = 0; i < checkboxes.length; i++) {
					if(vals!="") vals += ",";
					vals += checkboxes[i];
					if(document.getElementById("publishVersion_"+checkboxes[i])!=null) {
						if(document.getElementById("publishVersion_"+checkboxes[i]).checked) {
							vals += "___1";
						}
						else {
							vals += "___0";
						}
					}
				}
				resetVersionAjax(vals, 0, 0, 0);

			}
			
		}
		
	}
	
	function checkAllPubChecks(whichSearch) {
			
		var checkAll = document.getElementsByName("publish_all_"+whichSearch);
		var checkboxes = document.getElementsByName("publish_docs_"+whichSearch);
		var check = false;

		if(checkAll[0].checked) {
			check = true;
		}
		for(var i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = check;
		}
		
	}
	
	function publishDocs(whichSearch) {
	
		var checkAll = document.getElementsByName("publish_all_"+whichSearch);
		var checkboxes = document.getElementsByName("publish_docs_"+whichSearch);
		var check = false;
		
		for(var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {
				check = true;
				break;
			}
		}
		
		if(checkboxes.length==0) {
			check = false;
		}
		
		if(check==false) {
			' . we_message_reporting::getShowMessageCall(
						$GLOBALS['l_weSearch']['notChecked'], 
						WE_MESSAGE_NOTICE) . '
		}
		else {
	
			Check = confirm("' . $GLOBALS['l_weSearch']['publish_docs'] . '");
				if (Check == true) {	
					publishDocsAjax(whichSearch);
				}
		}
	}
	
	 var ajaxCallbackPublishDocs = {
	    success: function(o) {
	    
	     	// reload current document => reload all open Editors on demand
						
			var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
			for (frameId in _usedEditors) {

				if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
					_usedEditors[frameId].setEditorIsActive(true);

				} else {
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
				}
			}
			_multiEditorreload = true;

			//reload tree
			if(top.opener.treeData) {
				top.opener.we_cmd("load", top.opener.treeData.table ,0);
			}
			document.getElementById("resetBusyAdvSearch").innerHTML = "";
	     	document.getElementById("resetBusyDocSearch").innerHTML = "";
	     	' . we_message_reporting::getShowMessageCall(
						$GLOBALS['l_weSearch']['publishOK'], 
						WE_MESSAGE_NOTICE) . '
	     
	    },
	    failure: function(o) {
	     //alert("Failure");
	    }
	 }
	
	function publishDocsAjax(whichSearch) {
				
		var args = "";
		var check = "";
		var checkboxes = document.getElementsByName("publish_docs_"+whichSearch);
		for(var i = 0; i < checkboxes.length; i++) {
			if(checkboxes[i].checked) {
		    	if(check!="") check += ",";
		    	check += checkboxes[i].value;
			}
		}
		args += "&we_cmd[0]="+escape(check);
		var scroll = document.getElementById("resetBusy"+whichSearch);
		scroll.innerHTML = "<table border=\'0\' width=\'100%\' height=\'100%\'><tr><td align=\'center\'><img src=' . IMAGE_DIR . 'logo-busy.gif /></td></tr></table>";  

		YAHOO.util.Connect.asyncRequest("POST", ajaxURL, ajaxCallbackPublishDocs, "protocol=json&cns=tools/weSearch&cmd=PublishDocs&"+args+"");
		
	}
   
   function previewVersion(ID) {
		top.we_cmd("versions_preview", ID, 0);	
		//new jsWindow("' . WEBEDITION_DIR . 'we/include/we_versions/weVersionsPreview.php?ID="+ID+"", "version_preview",-1,-1,1000,750,true,true,true,true);
				
	}
   
   function calendarSetup(x){
    for(i=0;i<x;i++) {
     if(document.getElementById("date_picker_from"+i+"") != null) {
      Calendar.setup({inputField:"searchAdvSearch["+i+"]",ifFormat:"%d.%m.%Y",button:"date_picker_from"+i+"",align:"Tl",singleClick:true});
     }
    }
   }

  ');
		
		return $_js;
	}

	function getNextPrev($we_search_anzahl, $whichSearch)
	{
		$we_button = new we_button();
		$anzahl = 1;
		$searchstart = 0;
		
		if (isset($_REQUEST["we_cmd"]['obj'])) {
			$anzahl = $_SESSION['weSearch']['anzahl' . $whichSearch . ''];
			$searchstart = $_SESSION['weSearch']['searchstart' . $whichSearch . ''];
		} else {
			switch ($whichSearch) {
				case "DocSearch" :
					$anzahl = $this->Model->anzahlDocSearch;
					$searchstart = $this->Model->searchstartDocSearch;
					break;
				case "TmplSearch" :
					$anzahl = $this->Model->anzahlTmplSearch;
					$searchstart = $this->Model->searchstartTmplSearch;
					break;
				case "AdvSearch" :
					$anzahl = $this->Model->anzahlAdvSearch;
					$searchstart = $this->Model->searchstartAdvSearch;
					break;
			}
			if ($this->Model->IsFolder) {
				$anzahl = 1;
			}
		}
		
		$out = '<table cellpadding="0" cellspacing="0" border="0">' . '<tr>' . '<td>';
		if ($searchstart) {
			$out .= $we_button->create_button("back", "javascript:back(" . $anzahl . ");");
		} else {
			
			$out .= $we_button->create_button("back", "", true, 100, 22, "", "", true);
		}
		
		$out .= '</td>' . '<td>' . getPixel(10, 2) . '</td>' . '<td class="defaultfont"><b>' . (($we_search_anzahl) ? $searchstart + 1 : 0) . '-';
		
		if (($we_search_anzahl - $searchstart) < $anzahl) {
			$out .= $we_search_anzahl;
		} else {
			
			$out .= $searchstart + $anzahl;
		}
		
		$out .= ' ' . $GLOBALS["l_global"]["from"] . ' ' . $we_search_anzahl . '</b></td>' . '<td>' . getPixel(10, 2) . '</td>' . '<td>';
		
		if (($searchstart + $anzahl) < $we_search_anzahl) {
			//bt_back
			$out .= $we_button->create_button("next", "javascript:next(" . $anzahl . ");");
		} else {
			
			$out .= $we_button->create_button("next", "", true, 100, 22, "", "", true);
		}
		$out .= '</td>' . '<td>' . getPixel(10, 2) . '</td>' . '<td>';
		
		$pages = array();
		for ($i = 0; $i < ceil($we_search_anzahl / $anzahl); $i++) {
			$pages[($i * $anzahl)] = ($i + 1);
		}
		
		$page = ceil($searchstart / $anzahl) * $anzahl;
		
		$select = htmlSelect(
				"page", 
				$pages, 
				1, 
				$page, 
				false, 
				"onChange=\"this.form.elements['searchstart" . $whichSearch . "'].value = this.value;search(false);\"");
		if (!isset($_REQUEST['we_cmd']['setInputSearchstart'])) {
			if (!defined("searchstart" . $whichSearch . "")) {
				define("searchstart" . $whichSearch . "", true);
				$out .= hidden("searchstart" . $whichSearch . "", $searchstart);
			}
		}
		$out .= $select;
		$out .= '</td>' . '</tr>' . '</table>';
		return $out;
	}

	function getSortImage($for, $whichSearch)
	{
		if (isset($_REQUEST['Order' . $whichSearch . ''])) {
			if (strpos($_REQUEST['Order' . $whichSearch . ''], $for) === 0) {
				if (strpos($_REQUEST['Order' . $whichSearch . ''], 'DESC')) {
					return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_desc.gif" />';
				}
				return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_asc.gif" />';
			}
		}
		return getPixel(11, 8);
	}

	function getSearchDialogCheckboxes($whichSearch)
	{
		$we_button = new we_button();
		
		$_table = new we_htmlTable(
				array(
					
						'border' => '0', 
						'cellpadding' => '2', 
						'cellspacing' => '0', 
						'width' => '500', 
						'height' => '50'
				), 
				4, 
				2);
		
		switch ($whichSearch) {
			case "DocSearch" :
				$_table->setCol(
						0, 
						0, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->searchForTextDocSearch ? true : false, 
								"searchForTextDocSearch", 
								$GLOBALS['l_weSearch']['onlyFilename'], 
								false, 
								'defaultfont', 
								''));
				
				$_table->setCol(
						1, 
						0, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->searchForTitleDocSearch ? true : false, 
								"searchForTitleDocSearch", 
								$GLOBALS['l_weSearch']['onlyTitle'], 
								false, 
								'defaultfont', 
								''));
				
				$_table->setCol(
						2, 
						0, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->searchForContentDocSearch ? true : false, 
								"searchForContentDocSearch", 
								$GLOBALS['l_weSearch']['Content'], 
								false, 
								'defaultfont', 
								''));
				
				break;
			case "TmplSearch" :
				$_table->setCol(
						0, 
						0, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->searchForTextTmplSearch ? true : false, 
								"searchForTextTmplSearch", 
								$GLOBALS['l_weSearch']['onlyFilename'], 
								false, 
								'defaultfont', 
								''));
				
				$_table->setCol(
						1, 
						0, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->searchForContentTmplSearch ? true : false, 
								"searchForContentTmplSearch", 
								$GLOBALS['l_weSearch']['Content'], 
								false, 
								'defaultfont', 
								''));
				
				break;
		}
		$_table->setCol(2, 1, array(
			'align' => 'right'
		), $we_button->create_button("search", "javascript:search(true);"));
		
		return $_table->getHtmlCode();
	}

	function getSearchDialogCheckboxesAdvSearch()
	{
		$we_button = new we_button();
		
		if (!is_array($this->Model->search_tables_advSearch)) {
			$this->Model->search_tables_advSearch = unserialize($this->Model->search_tables_advSearch);
			if (is_array($this->Model->search_tables_advSearch)) {
				//tablenames are hardcoded in the tblsearchtool, get the real tablenames if they have a prefix
				foreach ($this->Model->search_tables_advSearch as $k => $v) {
					if ($k == "tblFile") {
						unset($this->Model->search_tables_advSearch[$k]);
						$this->Model->search_tables_advSearch[FILE_TABLE] = $v;
					}
					if ($k == "tblTemplates") {
						unset($this->Model->search_tables_advSearch[$k]);
						$this->Model->search_tables_advSearch[TEMPLATES_TABLE] = $v;
					}
					if ($k == "tblObjectFiles") {
						if (defined("OBJECT_FILES_TABLE")) {
							unset($this->Model->search_tables_advSearch[$k]);
							$this->Model->search_tables_advSearch[OBJECT_FILES_TABLE] = $v;
						}
					}
					if ($k == "tblObject") {
						if (defined("OBJECT_TABLE")) {
							unset($this->Model->search_tables_advSearch[$k]);
							$this->Model->search_tables_advSearch[OBJECT_TABLE] = $v;
						}
					}
					if ($k == "tblversions") {
						unset($this->Model->search_tables_advSearch[$k]);
						$this->Model->search_tables_advSearch[VERSIONS_TABLE] = $v;
					}
				}
			}
		}
		
		if (isset($_REQUEST['table'])) {
			$search_tables_advSearch = $_REQUEST['table'];
			$this->Model->search_tables_advSearch[$search_tables_advSearch] = 1;
		}
		
		if (!isset($this->Model->search_tables_advSearch[FILE_TABLE])) {
			$this->Model->search_tables_advSearch[FILE_TABLE] = 1;
		}
		
		if (!isset($this->Model->search_tables_advSearch[VERSIONS_TABLE])) {
			$this->Model->search_tables_advSearch[VERSIONS_TABLE] = 0;
		}
		
		if ($_SESSION["we_mode"] == "seem") {
			$this->Model->search_tables_advSearch[TEMPLATES_TABLE] = 0;
		} elseif (!isset($this->Model->search_tables_advSearch[TEMPLATES_TABLE])) {
			$this->Model->search_tables_advSearch[TEMPLATES_TABLE] = 0;
		}
		
		if (defined('OBJECT_FILES_TABLE') && !isset($this->Model->search_tables_advSearch[OBJECT_FILES_TABLE])) {
			$this->Model->search_tables_advSearch[OBJECT_FILES_TABLE] = 1;
		}
		
		if ($_SESSION["we_mode"] == "seem") {
			$this->Model->search_tables_advSearch[OBJECT_TABLE] = 0;
		} elseif (defined('OBJECT_TABLE') && !isset($this->Model->search_tables_advSearch[OBJECT_TABLE])) {
			$this->Model->search_tables_advSearch[OBJECT_TABLE] = 0;
		}
		
		if (!we_hasPerm('CAN_SEE_DOCUMENTS')) {
			$this->Model->search_tables_advSearch[FILE_TABLE] = 0;
		}
		
		if (!we_hasPerm('SEE_VERSIONS')) {
			$this->Model->search_tables_advSearch[VERSIONS_TABLE] = 0;
		}
		
		if (!we_hasPerm('CAN_SEE_TEMPLATES')) {
			$this->Model->search_tables_advSearch[TEMPLATES_TABLE] = 0;
		}
		
		if (!we_hasPerm('CAN_SEE_OBJECTFILES') && defined("OBJECT_FILES_TABLE")) {
			$this->Model->search_tables_advSearch[OBJECT_FILES_TABLE] = 0;
		}
		
		if (!we_hasPerm('CAN_SEE_OBJECTS') && defined("OBJECT_TABLE")) {
			$this->Model->search_tables_advSearch[OBJECT_TABLE] = 0;
		}
		
		if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == "tool_weSearch_new_forObjects") {
			$this->Model->search_tables_advSearch[FILE_TABLE] = 0;
			$this->Model->search_tables_advSearch[VERSIONS_TABLE] = 0;
		}
		
		if (isset($_SESSION["weSearch"]["checkWhich"])) {
			if ($_SESSION["weSearch"]["checkWhich"] == 3) {
				$this->Model->search_tables_advSearch[FILE_TABLE] = 0;
				$this->Model->search_tables_advSearch[VERSIONS_TABLE] = 0;
			} elseif ($_SESSION["weSearch"]["checkWhich"] == 4) {
				$this->Model->search_tables_advSearch[FILE_TABLE] = 0;
				$this->Model->search_tables_advSearch[VERSIONS_TABLE] = 0;
				$this->Model->search_tables_advSearch[OBJECT_FILES_TABLE] = 0;
				$this->Model->search_tables_advSearch[TEMPLATES_TABLE] = 0;
				$this->Model->search_tables_advSearch[OBJECT_TABLE] = 1;
			}
			unset($_SESSION["weSearch"]["checkWhich"]);
		}
		
		$_table = new we_htmlTable(
				array(
					
						'border' => '0', 
						'cellpadding' => '2', 
						'cellspacing' => '0', 
						'width' => '550', 
						'height' => '50'
				), 
				4, 
				3);
		
		if (we_hasPerm('CAN_SEE_DOCUMENTS')) {
			$_table->setCol(
					0, 
					0, 
					array(), 
					we_forms::checkboxWithHidden(
							$this->Model->search_tables_advSearch[FILE_TABLE] ? true : false, 
							'search_tables_advSearch[' . FILE_TABLE . ']', 
							$GLOBALS['l_weSearch']['documents'], 
							false, 
							'defaultfont', 
							''));
		}
		
		if (we_hasPerm('CAN_SEE_TEMPLATES') && $_SESSION["we_mode"] != "seem") {
			$_table->setCol(
					1, 
					0, 
					array(), 
					we_forms::checkboxWithHidden(
							$this->Model->search_tables_advSearch[TEMPLATES_TABLE] ? true : false, 
							'search_tables_advSearch[' . TEMPLATES_TABLE . ']', 
							$GLOBALS['l_weSearch']['templates'], 
							false, 
							'defaultfont', 
							''));
		}
		
		if (defined('OBJECT_TABLE')) {
			if (we_hasPerm('CAN_SEE_OBJECTFILES')) {
				$_table->setCol(
						0, 
						1, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->search_tables_advSearch[OBJECT_FILES_TABLE] ? true : false, 
								'search_tables_advSearch[' . OBJECT_FILES_TABLE . ']', 
								$GLOBALS['l_weSearch']['objects'], 
								false, 
								'defaultfont', 
								''));
			}
			if (we_hasPerm('CAN_SEE_OBJECTS') && $_SESSION["we_mode"] != "seem") {
				$_table->setCol(
						1, 
						1, 
						array(), 
						we_forms::checkboxWithHidden(
								$this->Model->search_tables_advSearch[OBJECT_TABLE] ? true : false, 
								'search_tables_advSearch[' . OBJECT_TABLE . ']', 
								$GLOBALS['l_weSearch']['classes'], 
								false, 
								'defaultfont', 
								''));
			}
		}
		
		if (we_hasPerm('SEE_VERSIONS')) {
			$_table->setCol(
					0, 
					2, 
					array(), 
					we_forms::checkboxWithHidden(
							$this->Model->search_tables_advSearch[VERSIONS_TABLE] ? true : false, 
							'search_tables_advSearch[' . VERSIONS_TABLE . ']', 
							$GLOBALS['l_versions']['versions'], 
							false, 
							'defaultfont', 
							''));
		}
		
		$_table->setCol(1, 2, array(
			'align' => 'right'
		), $we_button->create_button("search", "javascript:search(true);"));
		
		return $_table->getHtmlCode();
	}

	function getSearchDialog($whichSearch)
	{
		
		switch ($whichSearch) {
			case "DocSearch" :
				if (isset($_REQUEST["locationDocSearch"])) {
					$this->Model->locationDocSearch = $_REQUEST["locationDocSearch"];
				} else {
					$this->Model->locationDocSearch[0] = "CONTAIN";
				}
				$this->Model->searchFieldsDocSearch = array();
				$locationName = "locationDocSearch[0]";
				$searchTextName = "searchDocSearch[0]";
				$searchTables = "search_tables_docSearch[" . FILE_TABLE . "]";
				
				if ($this->Model->searchForTextDocSearch) {
					$this->Model->searchFieldsDocSearch[] = "Text";
				}
				
				if ($this->Model->searchForTitleDocSearch) {
					$this->Model->searchFieldsDocSearch[] = "Title";
				}
				
				if ($this->Model->searchForContentDocSearch) {
					$this->Model->searchFieldsDocSearch[] = "Content";
				}
				
				if ((isset($_SESSION["weSearch"]["keyword"]) && $_SESSION["weSearch"]["keyword"] != "") && (isset(
						$_REQUEST["tab"]) && $_REQUEST["tab"] == 1)) {
					$this->Model->searchDocSearch[0] = ($_SESSION["weSearch"]["keyword"]);
					if (isset($GLOBALS["_language"]["charset"]) && $GLOBALS["_language"]["charset"] == "UTF-8") {
						$this->Model->searchDocSearch[0] = utf8_encode($this->Model->searchDocSearch[0]);
					}
					
					unset($_SESSION["weSearch"]["keyword"]);
				}
				
				if (!is_array($this->Model->searchDocSearch)) {
					$this->Model->searchDocSearch = unserialize($this->Model->searchDocSearch);
				}
				
				$searchInput = htmlTextInput(
						$searchTextName, 
						30, 
						(isset($this->Model->searchDocSearch) && is_array($this->Model->searchDocSearch) && isset(
								$this->Model->searchDocSearch[0]) ? $this->Model->searchDocSearch[0] : ''), 
						"", 
						"", 
						"text", 
						380);
				
				break;
			case "TmplSearch" :
				if (isset($_REQUEST["locationTmplSearch"])) {
					$this->Model->locationTmplSearch = $_REQUEST["locationTmplSearch"];
				} else {
					$this->Model->locationTmplSearch[0] = "CONTAIN";
				}
				
				$this->Model->searchFieldsTmplSearch = array();
				$locationName = "locationTmplSearch[0]";
				$searchTextName = "searchTmplSearch[0]";
				$searchTables = "search_tables_TmplSearch[" . TEMPLATES_TABLE . "]";
				
				if ($this->Model->searchForTextTmplSearch) {
					$this->Model->searchFieldsTmplSearch[] = "Text";
				}
				
				if ($this->Model->searchForContentTmplSearch) {
					$this->Model->searchFieldsTmplSearch[] = "Content";
				}
				
				if ((isset($_SESSION["weSearch"]["keyword"]) && $_SESSION["weSearch"]["keyword"] != "") && (isset(
						$_REQUEST["tab"]) && $_REQUEST["tab"] == 2)) {
					$this->Model->searchTmplSearch[0] = $_SESSION["weSearch"]["keyword"];
					if (isset($GLOBALS["_language"]["charset"]) && $GLOBALS["_language"]["charset"] == "UTF-8") {
						$this->Model->searchTmplSearch[0] = utf8_encode($this->Model->searchTmplSearch[0]);
					}
					unset($_SESSION["weSearch"]["keyword"]);
				}
				
				if (!is_array($this->Model->searchTmplSearch)) {
					$this->Model->searchTmplSearch = unserialize($this->Model->searchTmplSearch);
				}
				
				$searchInput = htmlTextInput(
						$searchTextName, 
						30, 
						(isset($this->Model->searchTmplSearch) && is_array($this->Model->searchTmplSearch) && isset(
								$this->Model->searchTmplSearch[0]) ? $this->Model->searchTmplSearch[0] : ''), 
						"", 
						"", 
						"text", 
						380);
				
				break;
		}
		
		$out = '<div id="mouseOverDivs_' . $whichSearch . '"></div><table cellpadding="0" cellspacing="0" border="0">

    <tbody>
    <tr>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
    </tr>
    <tr>
     <td>' . $searchInput . '</td>
     <td>' . hidden($locationName, 'CONTAIN') . '</td>
     <td>' . hidden($searchTables, 1) . '</td>
    </tr></tbody></table>';
		
		return $out;
	}

	function searchProperties($whichSearch)
	{
		$DB_WE = new DB_WE();
		$content = array();
		$foundItems = 0;
		$workspaces = array();
		$_result = array();
		$versionsFound = array();
		$saveArrayIds = array();
		$_tables = array();
		$searchText = array();
		$_SESSION['weSearch']['foundItems' . $whichSearch . ''] = 0;
		
		if (isset($_REQUEST["we_cmd"]['obj'])) {
			$thisObj = new searchtoolView();
			$obj = $_REQUEST["we_cmd"]['obj'];
			
			$searchFields = array();
			$location = array();
			
			foreach ($_REQUEST['we_cmd'] as $k => $v) {
				if (stristr($k, 'searchFields' . $whichSearch . '[') && !stristr($k, 'hidden_')) {
					$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = $v;
				}
				if (stristr($k, 'location' . $whichSearch . '[')) {
					$_REQUEST['we_cmd']['location' . $whichSearch . ''][] = $v;
				}
				if (stristr($k, 'search' . $whichSearch . '[')) {
					$_REQUEST['we_cmd']['search' . $whichSearch . ''][] = $v;
				}
			}
			
			if ($whichSearch == "DocSearch") {
				$_tables[0] = FILE_TABLE;
				$folderID = $_REQUEST["we_cmd"]['folderIDDoc'];
				foreach ($_REQUEST['we_cmd'] as $k => $v) {
					if (stristr($k, 'searchForTextDocSearch') && $k{0} != "_") {
						if ($v == 1) {
							$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = "Text";
						}
					}
					if (stristr($k, 'searchForTitleDocSearch') && $k{0} != "_") {
						if ($v == 1) {
							$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = "Title";
						}
					}
					if (stristr($k, 'searchForContentDocSearch') && $k{0} != "_") {
						if ($v == 1) {
							$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = "Content";
						}
					}
				}
			} elseif ($whichSearch == "TmplSearch") {
				$_tables[0] = TEMPLATES_TABLE;
				$folderID = $_REQUEST["we_cmd"]['folderIDTmpl'];
				foreach ($_REQUEST['we_cmd'] as $k => $v) {
					if (stristr($k, 'searchForTextTmplSearch') && $k{0} != "_") {
						if ($v == 1) {
							$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = "Text";
						}
					}
					if (stristr($k, 'searchForContentTmplSearch') && $k{0} != "_") {
						if ($v == 1) {
							$_REQUEST['we_cmd']['searchFields' . $whichSearch . ''][] = "Content";
						}
					}
				}
			} else {
				$objectFilesTable = defined("OBJECT_FILES_TABLE") ? OBJECT_FILES_TABLE : "--";
				$objectTable = defined("OBJECT_TABLE") ? OBJECT_TABLE : "--";
				
				foreach ($_REQUEST['we_cmd'] as $k => $v) {
					if (stristr($k, 'search_tables_advSearch[' . FILE_TABLE . '') && $k{0} != "_") {
						if ($v == 1) {
							$_tables[] = FILE_TABLE;
						}
					} elseif (stristr($k, 'search_tables_advSearch[' . VERSIONS_TABLE . '') && $k{0} != "_") {
						if ($v == 1) {
							$_tables[] = VERSIONS_TABLE;
						}
					} elseif (stristr($k, 'search_tables_advSearch[' . TEMPLATES_TABLE . '') && $k{0} != "_") {
						if ($v == 1) {
							$_tables[] = TEMPLATES_TABLE;
						}
					} elseif (stristr($k, 'search_tables_advSearch[' . $objectFilesTable . '') && $k{0} != "_") {
						if ($v == 1) {
							$_tables[] = $objectFilesTable;
						}
					} elseif (stristr($k, 'search_tables_advSearch[' . $objectTable . '') && $k{0} != "_") {
						if ($v == 1) {
							$_tables[] = $objectTable;
						}
					}
				}
			}
			
			if (isset($_REQUEST["we_cmd"]['searchFields' . $whichSearch . ''])) {
				$searchFields = $_REQUEST["we_cmd"]['searchFields' . $whichSearch . ''];
			}
			if (isset($_REQUEST["we_cmd"]['location' . $whichSearch . ''])) {
				$location = $_REQUEST["we_cmd"]['location' . $whichSearch . ''];
			}
			if (isset($_REQUEST["we_cmd"]['search' . $whichSearch . ''])) {
				$searchText = $_REQUEST["we_cmd"]['search' . $whichSearch . ''];
			}
			
			$_order = $_REQUEST["we_cmd"]['Order' . $whichSearch . ''];
			$_view = $_REQUEST["we_cmd"]['setView' . $whichSearch . ''];
			
			$_searchstart = $_REQUEST["we_cmd"]['searchstart' . $whichSearch . ''];
			$_anzahl = $_REQUEST["we_cmd"]['anzahl' . $whichSearch . ''];
		} else {
			$obj = $this->Model;
			$thisObj = $this;
			
			switch ($whichSearch) {
				case "DocSearch" :
					if (isset($_REQUEST["searchstartDocSearch"])) {
						$obj->searchstartDocSearch = $_REQUEST["searchstartDocSearch"];
					}
					$_table = FILE_TABLE;
					$_tables[0] = $_table;
					$searchFields = $obj->searchFieldsDocSearch;
					$searchText = $obj->searchDocSearch;
					$location = $obj->locationDocSearch;
					$folderID = $obj->folderIDDoc;
					$_order = $obj->OrderDocSearch;
					$_view = $obj->setViewDocSearch;
					$_searchstart = $obj->searchstartDocSearch;
					$_anzahl = $obj->anzahlDocSearch;
					
					break;
				case "TmplSearch" :
					if (isset($_REQUEST["searchstartTmplSearch"])) {
						$obj->searchstartTmplSearch = $_REQUEST["searchstartTmplSearch"];
					}
					
					$_table = TEMPLATES_TABLE;
					$_tables[0] = $_table;
					
					$searchFields = $obj->searchFieldsTmplSearch;
					$searchText = $obj->searchTmplSearch;
					$location = $obj->locationTmplSearch;
					$folderID = $obj->folderIDTmpl;
					$_order = $obj->OrderTmplSearch;
					$_view = $obj->setViewTmplSearch;
					$_searchstart = $obj->searchstartTmplSearch;
					$_anzahl = $obj->anzahlTmplSearch;
					
					break;
				case "AdvSearch" :
					if (isset($_REQUEST["searchstartAdvSearch"])) {
						$obj->searchstartAdvSearch = $_REQUEST["searchstartAdvSearch"];
					}
					if (empty($obj->searchFieldsAdvSearch)) {
						$obj->searchFieldsAdvSearch[0] = "ID";
					}
					if (empty($obj->locationAdvSearch)) {
						$obj->locationAdvSearch[0] = "CONTAIN";
					}
					$searchFields = $obj->searchFieldsAdvSearch;
					$searchText = $obj->searchAdvSearch;
					$location = $obj->locationAdvSearch;
					$folderID = 0;
					$_order = $obj->OrderAdvSearch;
					$_view = $obj->setViewAdvSearch;
					$_searchstart = $obj->searchstartAdvSearch;
					$_anzahl = $obj->anzahlAdvSearch;
					
					$_tables = array();
					foreach ($obj->search_tables_advSearch as $_tablename => $value) {
						if ($value == 1) {
							$_tables[] = $_tablename;
						}
					}
					
					break;
			}
			for ($i = 0; $i < count($searchText); $i++) {
				if (isset($searchText[$i])) {
					if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
										$searchText[$i] = utf8_decode($searchText[$i]);
					}
				}
			}
		}
		
		for ($i = 0; $i < count($searchText); $i++) {
			if (isset($searchText[$i])) {
				$searchText[$i] = trim($searchText[$i]);
			}
		}
		$tab = 1;
		if (isset($_REQUEST['tab'])) {
			$tab = $_REQUEST['tab'];
		} elseif (isset($_REQUEST['tabnr'])) {
			$tab = $_REQUEST['tabnr'];
		}
		
		if (isset($searchText[0]) && substr($searchText[0], 0, 4) == 'exp:') {
			
			$_result = $thisObj->searchclassExp->getSearchResults($searchText[0], $_tables);
			if (!empty($_result)) {
				foreach ($_result as $k => $v) {
					foreach ($v as $key => $val) {
						if ($key == "Table") {
							unset($_result[$k][$key]);
							$_result[$k]['docTable'] = $val;
						}
						if ($key == "ID") {
							unset($_result[$k][$key]);
							$_result[$k]['docID'] = $val;
						}
					}
					$_result[$k]['SiteTitle'] = "";
				}
			}
			$_SESSION['weSearch']['foundItems' . $whichSearch . ''] = count($_result);
		
		} elseif (($obj->IsFolder != 1 && (($whichSearch == "DocSearch" && $tab == 1) || ($whichSearch == "TmplSearch" && $tab == 2) || ($whichSearch == "AdvSearch" && $tab == 3))) || (isset(
				$_REQUEST['cmdid']) && $_REQUEST['cmdid'] != "") || (isset($_REQUEST['view']) && ($_REQUEST['view'] == "GetSearchResult" || $_REQUEST['view'] == "GetMouseOverDivs"))) {
			
			if (searchtoolsearch::checkRightTempTable() == "1" && searchtoolsearch::checkRightDropTable() == "1") {
				print 
						we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall(
										$GLOBALS["l_weSearch"]["noTempTableRightsSearch"], 
										WE_MESSAGE_NOTICE));
			} else {
				$thisObj->searchclass->createTempTable();
				
				if ($whichSearch == "AdvSearch") {
					$op = " AND ";
				} else {
					$op = " OR ";
				}
				
				foreach ($_tables as $_table) {
					$where = "";
					$thisObj->searchclass->settable($_table);
					
					if (!defined('OBJECT_TABLE') || (defined('OBJECT_TABLE') && $_table != OBJECT_TABLE)) {
						$workspaces = makeArrayFromCSV(get_ws($_table, true));
					}
					
					for ($i = 0; $i < count($searchFields); $i++) {
						
						$w = "";
						if (isset($searchText[0])) {
							if ($whichSearch == "AdvSearch" && isset($searchText[$i])) {
								$searchString = $searchText[$i];
							} else {
								$searchString = $searchText[0];
							}
						}
						if (isset($searchString) && $searchString != "") {
							
							
							
							$searchString = str_replace("_", "\_", $searchString);
							$searchString = str_replace("%", "\%", $searchString);
							
							if (($searchFields[$i] == "Text" || ($whichSearch == "AdvSearch" && $searchFields[$i] != "Content" && $searchFields[$i] != "Status" && $searchFields[$i] != "Speicherart" && $searchFields[$i] != "CreatorName" && $searchFields[$i] != "WebUserName" && $searchFields[$i] != "temp_category"))) {
								if (isset($searchFields[$i]) && isset($location[$i])) {
									$where .= $thisObj->searchclass->searchfor(
											$searchString, 
											$searchFields[$i], 
											$location[$i], 
											$_table);
								}
							}
							
							if ($searchFields[$i] == "Content") {
								$objectTable = defined('OBJECT_TABLE') ? OBJECT_TABLE : "";
								if ($objectTable != "" && $_table == $objectTable) {
								
								} else {
									$w = $thisObj->searchclass->searchContent($searchString, $_table);
									if ($where == "" && $w == "") {
										$where .= " AND 0";
									} elseif ($where == "" && $w != "") {
										$where .= " AND " . $w;
									} elseif ($w != "") {
										$where .= $op . " " . $w;
									}
								}
							}
							
							if ($searchFields[$i] == "modifierID") {
								if ($_table == VERSIONS_TABLE) {
									$w .= $thisObj->searchclass->searchModifier($searchString, $_table);
									$where .= $w;
								}
							}
							
							if ($searchFields[$i] == "allModsIn") {
								if ($_table == VERSIONS_TABLE) {
									$w .= $thisObj->searchclass->searchModFields($searchString, $_table);
									$where .= $w;
								}
							}
							
							if ($searchFields[$i] == "Title") {
								
								$w = $thisObj->searchclass->searchInTitle($searchString, $_table);
								
								if ($where == "" && $w == "") {
									$where .= " AND 0";
								} elseif ($where == "" && $w != "") {
									$where .= " AND " . $w;
								} elseif ($w != "") {
									$where .= $op . " " . $w;
								}
							
							}
							
							if ($searchString != "" && ($searchFields[$i] == "Status" || $searchFields[$i] == "Speicherart")) {
								if ($_table == FILE_TABLE || $_table == VERSIONS_TABLE || $_table == OBJECT_FILES_TABLE) {
									$w = $thisObj->searchclass->getStatusFiles($searchString, $_table);
									if ($_table == VERSIONS_TABLE) {
										$docTableChecked = (in_array(FILE_TABLE, $_tables)) ? 1 : 0;
										$objTableChecked = 0;
										if (defined("OBJECT_FILES_TABLE")) {
											$objTableChecked = (in_array(OBJECT_FILES_TABLE, $_tables)) ? 1 : 0;
										}
										if ($objTableChecked && $docTableChecked) {
											$w .= " AND " . $_table . ".documentTable= '" . FILE_TABLE . "' OR documentTable= '" . OBJECT_FILES_TABLE . "' ";
										} elseif ($docTableChecked) {
											$w .= " AND " . $_table . ".documentTable= '" . FILE_TABLE . "' ";
										} elseif ($objTableChecked) {
											$w .= " AND " . $_table . ".documentTable= '" . OBJECT_FILES_TABLE . "' ";
										}
									}
									$where .= $w;
								}
							}
							
							if ($searchString != "" && ($searchFields[$i] == "CreatorName" || $searchFields[$i] == "WebUserName")) {
								if (isset($searchFields[$i]) && isset($location[$i])) {
									$w = $thisObj->searchclass->searchSpecial(
											$searchString, 
											$searchFields[$i], 
											$location[$i]);
									$where .= " AND " . $w;
								}
							}
							
							if ($searchFields[$i] == "temp_category") {
								$w = $thisObj->searchclass->searchCategory(
										$searchString, 
										$_table, 
										$searchFields[$i]);
								$where .= $w;
							}
						}
					}
					
					if ($where != "") {
						
						if (isset($folderID) && ($folderID != "" && $folderID != 0)) {
							$where = " AND (1 " . $where . ")" . $thisObj->searchclass->ofFolderAndChildsOnly(
									$folderID, 
									$_table);
						}
						
						if ($_table == VERSIONS_TABLE) {
							$workspacesTblFile = makeArrayFromCSV(get_ws(FILE_TABLE, true));
							if (defined("OBJECT_FILES_TABLE")) {
								$workspacesObjFile = makeArrayFromCSV(get_ws(OBJECT_FILES_TABLE, true));
							}
						}
						
						if (!empty($workspaces)) {
							$where = " AND (1 " . $where . ")" . $thisObj->searchclass->ofFolderAndChildsOnly(
									$workspaces, 
									$_table);
						}
						
						$whereQuery = "1 " . $where . "";
						
						//query for restrict users for FILE_TABLE, VERSIONS_TABLE AND OBJECT_FILES_TABLE
						$restrictUserQuery = " AND ((" . $_table . ".RestrictOwners='0' OR " . $_table . ".RestrictOwners= '" . $_SESSION["user"]["ID"] . "') OR (" . $_table . ".Owners LIKE '%," . $_SESSION["user"]["ID"] . ",%'))";
						
						if ($_table == FILE_TABLE) {
							$whereQuery .= $restrictUserQuery;
						}
						
						if (defined("OBJECT_FILES_TABLE")) {
							if ($_table == OBJECT_FILES_TABLE) {
								$whereQuery .= $restrictUserQuery;
							}
						}
						
						if (defined("OBJECT_TABLE")) {
							if ($_table == OBJECT_TABLE) {
								$whereQuery .= "AND ((" . $_table . ".RestrictUsers='0' OR " . $_table . ".RestrictUsers= '" . $_SESSION["user"]["ID"] . "') OR (" . $_table . ".Users LIKE '%," . $_SESSION["user"]["ID"] . ",%')) ";
							}
						}
						
						if ($_table == VERSIONS_TABLE) {
							if (isset($_REQUEST["we_cmd"]['obj'])) {
								$isCheckedFileTable = $_REQUEST["we_cmd"]['search_tables_advSearch[' . FILE_TABLE . ''];
								$isCheckedObjFileTable = (defined("OBJECT_FILES_TABLE")) ? $_REQUEST["we_cmd"]['search_tables_advSearch[' . OBJECT_FILES_TABLE . ''] : 1;
							} else {
								$isCheckedFileTable = $thisObj->Model->search_tables_advSearch[FILE_TABLE];
								$isCheckedObjFileTable = (defined("OBJECT_FILES_TABLE")) ? $thisObj->Model->search_tables_advSearch[OBJECT_FILES_TABLE] : 1;
							}
							$_SESSION['weSearch']['onlyObjects'] = true;
							$_SESSION['weSearch']['onlyDocs'] = true;
							$_SESSION['weSearch']['ObjectsAndDocs'] = true;
							$_SESSION['weSearch']['onlyObjectsRestrUsersWhere'] = " AND ((" . OBJECT_FILES_TABLE . ".RestrictOwners='0' OR " . OBJECT_FILES_TABLE . ".RestrictOwners= '" . $_SESSION["user"]["ID"] . "') OR (" . OBJECT_FILES_TABLE . ".Owners LIKE '%," . $_SESSION["user"]["ID"] . ",%'))";
							$_SESSION['weSearch']['onlyDocsRestrUsersWhere'] = " AND ((" . FILE_TABLE . ".RestrictOwners='0' OR " . FILE_TABLE . ".RestrictOwners= '" . $_SESSION["user"]["ID"] . "') OR (" . FILE_TABLE . ".Owners LIKE '%," . $_SESSION["user"]["ID"] . ",%'))";
							if (!empty($workspacesTblFile)) {
								$_SESSION['weSearch']['onlyDocsRestrUsersWhere'] .= $where = " " . $thisObj->searchclass->ofFolderAndChildsOnly(
										$workspacesTblFile[0], 
										$_table);
							}
							if (isset($workspacesObjFile) && !empty($workspacesObjFile)) {
								$_SESSION['weSearch']['onlyObjectsRestrUsersWhere'] .= $where = " " . $thisObj->searchclass->ofFolderAndChildsOnly(
										$workspacesObjFile[0], 
										$_table);
							}
							
							if (!$isCheckedFileTable && $isCheckedObjFileTable) {
								$_SESSION['weSearch']['onlyDocs'] = false;
								$whereQuery .= " AND " . $_table . ".documentTable='" . OBJECT_FILES_TABLE . "' ";
								$_SESSION['weSearch']['ObjectsAndDocs'] = false;
							}
							if ($isCheckedFileTable && !$isCheckedObjFileTable) {
								$_SESSION['weSearch']['onlyObjects'] = false;
								$whereQuery .= " AND " . $_table . ".documentTable='" . FILE_TABLE . "' ";
								$_SESSION['weSearch']['ObjectsAndDocs'] = false;
							}
						}
						
						$thisObj->searchclass->setwhere($whereQuery);
						
						$thisObj->searchclass->insertInTempTable($whereQuery, $_table);
					}
				}
				
				$thisObj->searchclass->selectFromTempTable($_searchstart, $_anzahl, $_order);
				while ($thisObj->searchclass->next_record()) {
					
					if (isset($thisObj->searchclass->Record['VersionID']) && $thisObj->searchclass->Record['VersionID'] != 0) {
						
						$versionsFound[] = array(
							
								$thisObj->searchclass->Record['ContentType'], 
								$thisObj->searchclass->Record['docID'], 
								$thisObj->searchclass->Record['VersionID']
						);
					
					}
					if (!isset(
							$saveArrayIds[$thisObj->searchclass->Record['ContentType']][$thisObj->searchclass->Record['docID']])) {
						$saveArrayIds[$thisObj->searchclass->Record['ContentType']][$thisObj->searchclass->Record['docID']] = $thisObj->searchclass->Record['docID'];
						
						$_result[] = array_merge(array(
							'Table' => $_table
						), array(
							'foundInVersions' => ""
						), $thisObj->searchclass->Record);
					}
				}
				
				foreach ($versionsFound as $k => $v) {
					foreach ($_result as $key => $val) {
						if (isset($_result[$key]['docID']) && $_result[$key]['docID'] == $v[1] && isset(
								$_result[$key]['ContentType']) && $_result[$key]['ContentType'] == $v[0]) {
							if ($_result[$key]['foundInVersions'] != "") {
								$_result[$key]['foundInVersions'] .= ",";
							}
							$_result[$key]['foundInVersions'] .= $v[2];
						}
					}
					
					$thisObj->searchclass->selectFromTempTable($_searchstart, $_anzahl, $_order);
					while ($thisObj->searchclass->next_record()) {
						if (!isset(
								$saveArrayIds[$thisObj->searchclass->Record['ContentType']][$thisObj->searchclass->Record['docID']])) {
							$saveArrayIds[$thisObj->searchclass->Record['ContentType']][$thisObj->searchclass->Record['docID']] = $thisObj->searchclass->Record['docID'];
							$_result[] = array_merge(array(
								'Table' => $_table
							), $thisObj->searchclass->Record);
						}
					}
				}
				
				$db = new DB_WE();
				$query = "SELECT *  FROM `" . SEARCH_TEMP_TABLE . "` ";
				$db->query($query);
				
				$_SESSION['weSearch']['foundItems' . $whichSearch . ''] = $db->num_rows();
				
				$q = "DROP TABLE IF EXISTS `" . SEARCH_TEMP_TABLE . "`";
				$db->query($q);
			
			}
		
		}
		
		if ($_SESSION['weSearch']['foundItems' . $whichSearch . ''] > 0) {
			
			$_db2 = new DB_WE();
			
			foreach ($_result as $k => $v) {
				$_result[$k]["Description"] = "";
				if ($_result[$k]["docTable"] == FILE_TABLE && $_result[$k]['Published'] >= $_result[$k]['ModDate'] && $_result[$k]['Published'] != 0) {
					$DB_WE->query(
							"SELECT a.ID, c.Dat FROM (" . FILE_TABLE . " a LEFT JOIN " . LINK_TABLE . " b ON (a.ID=b.DID)) LEFT JOIN " . CONTENT_TABLE . " c ON (b.CID=c.ID) WHERE a.ID='" . $_result[$k]["docID"] . "' AND b.Name='Description' AND b.DocumentTable='" . FILE_TABLE . "'");
					while ($DB_WE->next_record()) {
						$_result[$k]["Description"] = $DB_WE->f('Dat');
					}
				} elseif ($_result[$k]["docTable"] == FILE_TABLE) {
					$query2 = "SELECT DocumentObject  FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID = '" . $_result[$k]["docID"] . "' AND DocTable = '" . FILE_TABLE . "' AND Active = '1'";
					$_db2->query($query2);
					while ($_db2->next_record()) {
						$tempDoc = unserialize($_db2->f('DocumentObject'));
						if (isset($tempDoc[0]['elements']['Description']) && $tempDoc[0]['elements']['Description']['dat'] != "") {
							$_result[$k]["Description"] = $tempDoc[0]['elements']['Description']['dat'];
						}
					}
				} else {
					$_result[$k]["Description"] = "";
				}
			}
			
			$content = $thisObj->makeContent($_result, $_view, $whichSearch);
		}
		
		return $content;
	}

	function makeHeadLines($whichSearch)
	{
		$headline[0]["dat"] = '<a href="javascript:setOrder(\'Text\',\'' . $whichSearch . '\');">' . $GLOBALS['l_weSearch']['dateiname'] . '</a> <span id="Text_' . $whichSearch . '" >' . $this->getSortImage(
				'Text', 
				$whichSearch) . '</span>';
		$headline[1]["dat"] = '<a href="javascript:setOrder(\'SiteTitle\',\'' . $whichSearch . '\');">' . $GLOBALS['l_weSearch']['seitentitel'] . '</a> <span id="SiteTitle_' . $whichSearch . '" >' . $this->getSortImage(
				'SiteTitle', 
				$whichSearch) . '</span>';
		$headline[2]["dat"] = '<a href="javascript:setOrder(\'CreationDate\',\'' . $whichSearch . '\');">' . $GLOBALS['l_weSearch']['created'] . '</a> <span id="CreationDate_' . $whichSearch . '" >' . $this->getSortImage(
				'CreationDate', 
				$whichSearch) . '</span>';
		$headline[3]["dat"] = '<a href="javascript:setOrder(\'ModDate\',\'' . $whichSearch . '\');">' . $GLOBALS['l_weSearch']['modified'] . '</a> <span id="ModDate_' . $whichSearch . '" >' . $this->getSortImage(
				'ModDate', 
				$whichSearch) . '</span>';
		
		return $headline;
	}

	function makeContent($_result, $view, $whichSearch)
	{
		$DB_WE = new DB_WE();
		
		$we_PathLength = 30;
		
		$content = array();
		$we_button = new we_button();
		
		$resultCount = count($_result);
		
		for ($f = 0; $f < $resultCount; $f++) {
			$fontColor = "black";
			$showPubCheckbox = true;
			if (isset($_result[$f]["Published"]) && isset($_result[$f]["VersionID"]) && !$_result[$f]["VersionID"]) {
				$published = ((($_result[$f]["Published"] != 0) && ($_result[$f]["Published"] < $_result[$f]["ModDate"]) && ($_result[$f]["ContentType"] == "text/html" || $_result[$f]["ContentType"] == "text/webedition" || $_result[$f]["ContentType"] == "objectFile")) ? -1 : $_result[$f]["Published"]);
				if ($_result[$f]["ContentType"] == "text/html" || $_result[$f]["ContentType"] == "objectFile" || $_result[$f]["ContentType"] == "text/webedition") {
					if ($published == 0) {
						$fontColor = "red";
						$showPubCheckbox = false;
					} elseif ($published == -1) {
						$fontColor = "#3366CC";
						$showPubCheckbox = false;
					}
				}
			}
			$ext = isset($_result[$f]["Extension"]) ? $_result[$f]["Extension"] : "";
			$Icon = isset($GLOBALS["WE_CONTENT_TYPES"][$_result[$f]["ContentType"]]) ? we_getIcon(
					$_result[$f]["ContentType"], 
					$ext) : "link.gif";
			
			$foundInVersions = isset($_result[$f]["foundInVersions"]) ? makeArrayFromCSV(
					$_result[$f]["foundInVersions"]) : "";
			
			if ($view == 0) {
				
				if (is_array($foundInVersions) && !empty($foundInVersions)) {
					
					rsort($foundInVersions);
					
					foreach ($foundInVersions as $k) {
						
						$resetDisabled = false;
						if (!we_hasPerm('RESET_VERSIONS')) {
							$resetDisabled = true;
						}
						
						$query = "SELECT ID,timestamp, version, active FROM " . VERSIONS_TABLE . " WHERE ID='" . $k . "'";
						
						$DB_WE->query($query);
						while ($DB_WE->next_record()) {
							$timestamp = $DB_WE->f('timestamp');
							$version = $DB_WE->f('version');
							$ID = $DB_WE->f('ID');
							$active = $DB_WE->f('active');
						}
						$previewButton = $we_button->create_button(
								"preview", 
								"javascript:previewVersion('" . $ID . "');");
						
						$fileExists = f(
								"SELECT ID FROM " . $_result[$f]["docTable"] . " WHERE ID= '" . $_result[$f]["docID"] . "' ", 
								"ID", 
								$DB_WE);
						
						if ($active && $fileExists != "") {
							$resetDisabled = true;
						}
						
						$classNotExistsText = "";
						//if class doesn't exists it's not possible to reset object-version!
						if ($_result[$f]['ContentType'] == "objectFile") {
							
							$classExists = f(
									"SELECT ID FROM " . OBJECT_TABLE . " WHERE ID= '" . $_result[$f]["TableID"] . "' ", 
									"ID", 
									$DB_WE);
							if ($classExists == "") {
								$resetDisabled = true;
								$classNotExistsText = "(" . $GLOBALS['l_versions']["objClassNotExists"] . ")";
							}
						}
						
						$content[$f][0]["version"][$k] = "";
						$content[$f][1]["version"][$k] = $GLOBALS['l_versions']["version"] . " " . $version . " <br/><span style='font-weight:100;color:red;'>" . $classNotExistsText . "</span>";
						$content[$f][2]["version"][$k] = "<div style='margin-bottom:5px;float:left;'>" . we_forms::radiobutton(
								$ID, 
								0, 
								"resetVersion[" . $_result[$f]["ID"] . "_" . $_result[$f]["Table"] . "]", 
								"", 
								false, 
								"defaultfont", 
								"", 
								$resetDisabled) . "</div><div style='float:left;margin-left:30px;'>" . $previewButton . "</div>";
						$content[$f][3]["version"][$k] = date("d.m.Y", $timestamp);
						$content[$f][4]["version"][$k] = "";
						$content[$f][5]["version"][$k] = ($_result[$f]["ContentType"] == "text/webedition" || $_result[$f]["ContentType"] == "text/html" || $_result[$f]["ContentType"] == "objectFile") ? we_forms::checkbox(
								$ID, 
								0, 
								"publishVersion_" . $ID, 
								$GLOBALS['l_versions']['publishIfReset'], 
								false, 
								"middlefont", 
								"") : "";
					
					}
				}
				$docExists = f(
						"SELECT ID FROM " . $_result[$f]["docTable"] . " WHERE ID= '" . $_result[$f]["docID"] . "' ", 
						"ID", 
						$DB_WE);
				
				$publishCheckbox = (!$showPubCheckbox) ? (($_result[$f]["ContentType"] == "text/webedition" || $_result[$f]["ContentType"] == "text/html" || $_result[$f]["ContentType"] == "objectFile") && we_hasPerm(
						'PUBLISH') && $docExists != "") ? we_forms::checkbox(
						$_result[$f]["docID"] . "_" . $_result[$f]["docTable"], 
						0, 
						"publish_docs_" . $whichSearch, 
						"", 
						false, 
						"middlefont", 
						"") : getPixel(20, 10) : '';
						
				if (eregi('_UTF-8', $GLOBALS['WE_LANGUAGE'])) {
					$_result[$f]["SiteTitle"] = utf8_encode($_result[$f]["SiteTitle"]);
				}
				
				$content[$f][0]["dat"] = $publishCheckbox;
				$content[$f][1]["dat"] = '<img src="' . ICON_DIR . $Icon . '" border="0" width="16" height="18" />';
				$content[$f][2]["dat"] = '<a href="javascript:openToEdit(\'' . $_result[$f]["docTable"] . '\',\'' . $_result[$f]["docID"] . '\',\'' . $_result[$f]["ContentType"] . '\')" style="text-decoration:none;color:' . $fontColor . ';"  title="' . $_result[$f]["Text"] . '"><u>' . shortenPath(
						$_result[$f]["Text"], 
						17);
				//$content[$f][2]["dat"] = '<nobr>'. $GLOBALS['l_contentTypes'][$_result[$f]['ContentType']] .'</nobr>';
				$content[$f][3]["dat"] = '<nobr>' . shortenPath(
						$_result[$f]["SiteTitle"], 
						$we_PathLength) . '</nobr>';
				$content[$f][4]["dat"] = '<nobr>' . $checkTable = isset($_result[$f]["VersionID"]) && $_result[$f]["VersionID"] ? "-" : ($_result[$f]["CreationDate"] ? date(
						$GLOBALS['l_weSearch']["date_format"], 
						$_result[$f]["CreationDate"]) : "-");
				$content[$f][5]["dat"] = '<nobr>' . ($_result[$f]["ModDate"] ? date(
						$GLOBALS['l_weSearch']["date_format"], 
						$_result[$f]["ModDate"]) : "-") . '</nobr>';
			} else 

			{
				$fs = file_exists($_SERVER["DOCUMENT_ROOT"] . $_result[$f]["Path"]) ? filesize(
						$_SERVER["DOCUMENT_ROOT"] . $_result[$f]["Path"]) : 0;
				$filesize = $fs < 1000 ? $fs . ' byte' : ($fs < 1024000 ? round(($fs / 1024), 2) . ' kb' : round(
						($fs / (1024 * 1024)), 
						2) . ' mb');
				
				if ($_result[$f]["ContentType"] == "image/*") {
					$smallSize = 64;
					$bigSize = 140;
					
					if ($fs > 0) {
						$imagesize = getimagesize($_SERVER["DOCUMENT_ROOT"] . $_result[$f]["Path"]);
						if (file_exists(
								$_SERVER["DOCUMENT_ROOT"] . '/webEdition/preview/' . $_result[$f]["docID"] . "_'.$smallSize.'_'.$smallSize.'" . strtolower(
										$_result[$f]["Extension"]))) {
							$thumbpath = '/webEdition/preview/' . $_result[$f]["docID"] . "_'.$smallSize.'_'.$smallSize.'" . strtolower(
									$_result[$f]["Extension"]);
							$imageView = "<img src='$thumbpath' border='0'></a>";
						} else {
							$imageView = "<img src='/webEdition/thumbnail.php?id=" . $_result[$f]["docID"] . "&size=" . $smallSize . "&path=" . $_result[$f]["Path"] . "&extension=" . $_result[$f]["Extension"] . "' border='0'></a>";
						}
						if (file_exists(
								$_SERVER["DOCUMENT_ROOT"] . '/webEdition/preview/' . $_result[$f]["docID"] . "_'.$bigSize.'_'.$bigSize.'" . strtolower(
										$_result[$f]["Extension"]))) {
							$thumbpathPopup = '/webEdition/preview/' . $_result[$f]["docID"] . "_'.$bigSize.'_'.$bigSize.'" . strtolower(
									$_result[$f]["Extension"]);
							$imageViewPopup = "<img src='$thumbpathPopup' border='0'></a>";
						} else {
							$imageViewPopup = "<img src='/webEdition/thumbnail.php?id=" . $_result[$f]["docID"] . "&size=" . $bigSize . "&path=" . $_result[$f]["Path"] . "&extension=" . $_result[$f]["Extension"] . "' border='0'></a>";
						}
					} else {
						$imagesize = array(
							0, 0
						);
						$thumbpath = '/webEdition/images/icons/doclist/image.gif';
						$imageView = "<img src='$thumbpath' border='0' />";
						$imageViewPopup = "<img src='$thumbpath' border='0' />";
					}
				} else {
					$imagesize = array(
						0, 0
					);
					$imageView = '<img src="' . IMAGE_DIR . "/icons/doclist/" . $Icon . '" border="0" width="64" height="64" />';
					$imageViewPopup = '<img src="' . IMAGE_DIR . "/icons/doclist/" . $Icon . '" border="0" width="64" height="64" />';
				}
				
				$content[$f][0]["dat"] = '<a href="javascript:openToEdit(\'' . $_result[$f]["docTable"] . '\',\'' . $_result[$f]["docID"] . '\',\'' . $_result[$f]["ContentType"] . '\')" style="text-decoration:none" class="middlefont" title="' . $_result[$f]["Text"] . '">' . $imageView . '</a>';
				
				$creator = $_result[$f]["CreatorID"] ? id_to_path($_result[$f]["CreatorID"], USER_TABLE, $DB_WE) : $GLOBALS['l_weSearch']["nobody"];
				
				if ($_result[$f]["ContentType"] == "text/webedition" && $_result[$f]["Table"] != VERSIONS_TABLE) {
					if ($_result[$f]["Published"] >= $_result[$f]["ModDate"] && $_result[$f]["Published"] != 0) {
						$templateID = $_result[$f]["TemplateID"];
					} else {
						$templateID = $_result[$f]["temp_template_id"];
					}
					$templateText = $GLOBALS['l_weSearch']["no_template"];
					if ($templateID != "") {
						$sql = "SELECT ID, Text FROM " . TEMPLATES_TABLE . " WHERE ID = $templateID";
						$DB_WE->query($sql);
						while ($DB_WE->next_record()) {
							$templateText = shortenPath($DB_WE->f('Text'), 20) . " (ID=" . $DB_WE->f('ID') . ")";
						}
					}
				} else {
					$templateText = "";
				}
				
				$_defined_fields = weMetaData::getDefinedMetaDataFields();
				$metafields = array();
				$_fieldcount = sizeof($_defined_fields);
				if ($_fieldcount > 6)
					$_fieldcount = 6;
				for ($i = 0; $i < $_fieldcount; $i++) {
					$_tagName = $_defined_fields[$i]["tag"];
					
					if (weContentProvider::IsBinary($_result[$f]["docID"])) {
						$DB_WE->query(
								"SELECT a.ID, c.Dat FROM (" . FILE_TABLE . " a LEFT JOIN " . LINK_TABLE . " b ON (a.ID=b.DID)) LEFT JOIN " . CONTENT_TABLE . " c ON (b.CID=c.ID) WHERE b.DID='" . $_result[$f]["docID"] . "' AND b.Name='" . $_tagName . "' AND b.DocumentTable='" . FILE_TABLE . "'");
						$metafields[$_tagName] = "";
						while ($DB_WE->next_record()) {
							$metafields[$_tagName] = shortenPath($DB_WE->f('Dat'), 45);
						}
					}
				}
				
				$content[$f][1]["dat"] = shortenPath($_result[$f]["SiteTitle"], 17);
				$content[$f][2]["dat"] = '<a href="javascript:openToEdit(\'' . $_result[$f]["docTable"] . '\',\'' . $_result[$f]["docID"] . '\',\'' . $_result[$f]["ContentType"] . '\')" style="text-decoration:none;color:' . $fontColor . ';" class="middlefont" title="' . $_result[$f]["Text"] . '"><u>' . shortenPath(
						$_result[$f]["Text"], 
						20) . '</u></a>';
				$content[$f][3]["dat"] = '<nobr>' . ($_result[$f]["CreationDate"] ? date(
						$GLOBALS['l_weSearch']["date_format"], 
						$_result[$f]["CreationDate"]) : "-") . '</nobr>';
				$content[$f][4]["dat"] = '<nobr>' . ($_result[$f]["ModDate"] ? date(
						$GLOBALS['l_weSearch']["date_format"], 
						$_result[$f]["ModDate"]) : "-") . '</nobr>';
				$content[$f][5]["dat"] = '<a href="javascript:openToEdit(\'' . $_result[$f]["docTable"] . '\',\'' . $_result[$f]["docID"] . '\',\'' . $_result[$f]["ContentType"] . '\')" style="text-decoration:none;" class="middlefont" title="' . $_result[$f]["Text"] . '">' . $imageViewPopup . '</a>';
				$content[$f][6]["dat"] = $filesize;
				$content[$f][7]["dat"] = $imagesize[0] . " x " . $imagesize[1];
				$content[$f][8]["dat"] = shortenPath($GLOBALS['l_contentTypes'][$_result[$f]['ContentType']], 22);
				$content[$f][9]["dat"] = '<span style="color:' . $fontColor . ';">' . shortenPath(
						$_result[$f]["Text"], 
						30) . '</span>';
				$content[$f][10]["dat"] = shortenPath($_result[$f]["SiteTitle"], 45);
				$content[$f][11]["dat"] = shortenPath($_result[$f]["Description"], 100);
				$content[$f][12]["dat"] = $_result[$f]['ContentType'];
				$content[$f][13]["dat"] = shortenPath($creator, 22);
				$content[$f][14]["dat"] = $templateText;
				$content[$f][15]["dat"] = $metafields;
				$content[$f][16]["dat"] = $_result[$f]["docID"];
			}
		}
		
		return $content;
	}

	function getSearchParameterTop($foundItems, $whichSearch)
	{		
		
		$we_button = new we_button();

		if (isset($_REQUEST["we_cmd"]['obj'])) {
			$thisObj = new searchtoolView();
			
			$_view = $_REQUEST['we_cmd']['setView' . $whichSearch . ''];
			$view = "setView" . $whichSearch . "";
			$_order = $_REQUEST['we_cmd']['Order' . $whichSearch . ''];
			$order = "Order" . $whichSearch . "";
			$_anzahl = $_REQUEST['we_cmd']['anzahl' . $whichSearch . ''];
			$anzahl = "anzahl" . $whichSearch . "";
			$searchstart = "searchstart" . $whichSearch . "";
		} else {
			$thisObj = $this;
			
			switch ($whichSearch) {
				case "DocSearch" :
					$_view = $this->Model->setViewDocSearch;
					$view = "setViewDocSearch";
					$_order = $this->Model->OrderDocSearch;
					$order = "OrderDocSearch";
					$_anzahl = $this->Model->anzahlDocSearch;
					$anzahl = "anzahlDocSearch";
					$searchstart = "searchstartDocSearch";
					break;
				case "TmplSearch" :
					$_view = $this->Model->setViewTmplSearch;
					$view = "setViewTmplSearch";
					$_order = $this->Model->OrderTmplSearch;
					$order = "OrderTmplSearch";
					$_anzahl = $this->Model->anzahlTmplSearch;
					$anzahl = "anzahlTmplSearch";
					$searchstart = "searchstartTmplSearch";
					break;
				case "AdvSearch" :
					$_view = $this->Model->setViewAdvSearch;
					$view = "setViewAdvSearch";
					$_order = $this->Model->OrderAdvSearch;
					$order = "OrderAdvSearch";
					$_anzahl = $this->Model->anzahlAdvSearch;
					$anzahl = "anzahlAdvSearch";
					$searchstart = "searchstartAdvSearch";
					break;
			}
		}
		$out = "";
		
		$values = array(
			10 => 10, 25 => 25, 50 => 50, 100 => 100
		);
		
		$out .= '
		
   <input type="hidden" name="' . $view . '" value="' . $_view . '">
   <input type="hidden" name="position">
   <input type="hidden" name="' . $order . '" value="' . $_order . '">
   <input type="hidden" name="do">
   <table border="0" cellpadding="0" cellspacing="0">
   <tr>
   <td>' . getPixel(30, 12) . '</td>
   <td style="font-size:12px;width:125px;">' . $GLOBALS['l_weSearch']["eintraege_pro_seite"] . ':</td>
   <td class="defaultgray" style="width:60px;">
   ' . htmlSelect(
				$anzahl, 
				$values, 
				1, 
				$_anzahl, 
				"", 
				'onChange=\'this.form.elements["' . $searchstart . '"].value=0;search(false);\'');
		
		$out .= '</td>
   <td style="width:400px;">' . $thisObj->getNextPrev(
				$foundItems, 
				$whichSearch) . '</td>
   <td style="width:35px;">
   ' . $we_button->create_button(
				"image:iconview", 
				"javascript:setView(1);", 
				true, 
				"", 
				"", 
				"", 
				"", 
				false) . '
   </td>
   <td>
   ' . $we_button->create_button(
				"image:listview", 
				"javascript:setView(0);", 
				true, 
				"", 
				"", 
				"", 
				"", 
				false) . '
   </td>
   </tr>
   <tr>
    <td colspan="12">' . getPixel(1, 12) . '</td>
   </tr>
   </table>';
		
		return $out;
	}

	function getSearchParameterBottom($foundItems, $whichSearch)
	{
		$we_button = new we_button();
		
		if (isset($_REQUEST["we_cmd"]['obj'])) {
			$thisObj = new searchtoolView();
		} else {
			$thisObj = $this;
		}
		
		$resetButton = "";
		$publishButton = "";
		$publishButtonCheckboxAll = "";
		if (we_hasPerm('RESET_VERSIONS') && $whichSearch == "AdvSearch") {
			$resetButton = $we_button->create_button("reset", "javascript:resetVersions();", true, 100, 22, "", "");
			;
		}
		if (we_hasPerm('PUBLISH') && ($whichSearch == "AdvSearch" || $whichSearch == "DocSearch")) {
			$publishButtonCheckboxAll = we_forms::checkbox(
					"1", 
					0, 
					"publish_all_" . $whichSearch, 
					"", 
					false, 
					"middlefont", 
					"checkAllPubChecks('" . $whichSearch . "')");
			$publishButton = $we_button->create_button(
					"publish", 
					"javascript:publishDocs('" . $whichSearch . "');", 
					true, 
					100, 
					22, 
					"", 
					"");
		}
		
		$out = '<table border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
              			<tr>
              			
			             <td>' . $publishButtonCheckboxAll . '</td>
					     <td style="font-size:12px;width:140px;">' . $publishButton . '</td>
					     <td style="width:60px;" id="resetBusy' . $whichSearch . '"></td>
					     <td style="width:400px;">' . $resetButton . '</td>
             			</tr>
              
     <tr> <td>' . getPixel(10, 12) . '</td>
     </tr>
     <tr>
     <td>' . getPixel(19, 12) . '</td>
     <td style="font-size:12px;width:140px;">' . getPixel(30, 12) . '</td>
     <td class="defaultgray" style="width:60px;">' . getPixel(30, 12) . '</td>
     <td style="width:400px;">' . $thisObj->getNextPrev(
				$foundItems, 
				$whichSearch) . '</td>
    </tr>
    </table>';
		
		return $out;
	}

	function getSearchDialogAdvSearch()
	{
		$we_button = new we_button();
		
		if (!is_array($this->Model->searchFieldsAdvSearch)) {
			$this->Model->searchFieldsAdvSearch = unserialize($this->Model->searchFieldsAdvSearch);
		}
		
		if (!is_array($this->Model->locationAdvSearch)) {
			$this->Model->locationAdvSearch = unserialize($this->Model->locationAdvSearch);
		}
		
		if (!is_array($this->Model->searchAdvSearch)) {
			$this->Model->searchAdvSearch = unserialize($this->Model->searchAdvSearch);
		}
		
		if ((isset($_SESSION["weSearch"]["keyword"]) && $_SESSION["weSearch"]["keyword"] != "") && (isset(
				$_REQUEST["tab"]) && $_REQUEST["tab"] == 3)) {
			$this->Model->searchAdvSearch[0] = $_SESSION["weSearch"]["keyword"];
			if (isset($GLOBALS["_language"]["charset"]) && $GLOBALS["_language"]["charset"] == "UTF-8") {
				$this->Model->searchAdvSearch[0] = utf8_encode($this->Model->searchAdvSearch[0]);
			}
			unset($_SESSION["weSearch"]["keyword"]);
		}
		
		$this->searchclass->height = count($this->Model->searchFieldsAdvSearch);
		
		if (isset($_REQUEST["searchFieldsAdvSearch"])) {
			$this->searchclass->height = count($_REQUEST["searchFieldsAdvSearch"]);
		}
		if (isset($_REQUEST["searchFieldsAdvSearch"]) && isset($_REQUEST["cmdid"]) && $_REQUEST["cmdid"] != "") {
			$this->searchclass->height = count($this->Model->searchFieldsAdvSearch);
		}
		if (isset($_REQUEST["searchFieldsAdvSearch"]) && isset($_REQUEST["cmdid"]) && $_REQUEST["cmdid"] == "" && $_REQUEST["cmd"] != "" && $_REQUEST["cmd"] != "tool_weSearch_save") {
			$this->searchclass->height = 1;
		}
		
		if (!isset($_REQUEST["searchFieldsAdvSearch"]) && isset($_REQUEST["cmdid"]) && $_REQUEST["cmdid"] != "") {
			$this->searchclass->height = count($this->Model->searchFieldsAdvSearch);
		}
		if (!isset($_REQUEST["searchFieldsAdvSearch"]) && isset($_REQUEST["cmdid"]) && $_REQUEST["cmdid"] == "" && $_REQUEST["cmd"] == "") {
			$this->searchclass->height = 0;
		}
		if (!isset($_REQUEST["searchFieldsAdvSearch"]) && isset($_REQUEST["cmdid"]) && $_REQUEST["cmdid"] == "" && $_REQUEST["cmd"] != "" && $_REQUEST["cmd"] != "tool_weSearch_save") {
			$this->searchclass->height = 1;
		}
		
		if (!isset($_REQUEST["searchFieldsAdvSearch"]) && !isset($_REQUEST["cmdid"]) && !isset(
				$this->Model->searchFieldsAdvSearch[0])) {
			$this->searchclass->height = 1;
		}
		if (!isset($_REQUEST["searchFieldsAdvSearch"]) && !isset($_REQUEST["cmdid"]) && isset(
				$this->Model->searchFieldsAdvSearch[0])) {
			$this->searchclass->height = count($this->Model->searchFieldsAdvSearch);
		}
		
		//if own search was saved without fields
		if ($this->Model->searchFieldsAdvSearch == "" && !$this->Model->predefined) {
			$this->searchclass->height = 0;
		}
		
		$out = '<div style="margin-left:123px;"><div id="mouseOverDivs_AdvSearch"></div><table cellpadding="3" cellspacing="0" border="0">
    <tbody id="filterTableAdvSearch">
    <tr>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
 
     </tr>';
		
		$r = array();
		$r2 = array();
		$r3 = array();
		if (isset($this->Model->searchAdvSearch) && is_array($this->Model->searchAdvSearch)) {
			foreach ($this->Model->searchAdvSearch as $k => $v) {
				$r[] = $this->Model->searchAdvSearch[$k];
			}
		}
		
		if (isset($this->Model->searchFieldsAdvSearch) && is_array($this->Model->searchFieldsAdvSearch)) {
			foreach ($this->Model->searchFieldsAdvSearch as $k => $v) {
				$r2[] = $this->Model->searchFieldsAdvSearch[$k];
			}
		}
		
		if (isset($_REQUEST['locationAdvSearch']) && is_array($_REQUEST['locationAdvSearch'])) {
			$m = 0;
			foreach ($_REQUEST['locationAdvSearch'] as $k => $v) {
				if (isset($_REQUEST['locationAdvSearch'][$k])) {
					$r3[$m] = $_REQUEST['locationAdvSearch'][$k];
				} else {
					$r3[$m] = "disabled";
				}
				$m++;
			}
		} else {
			if (isset($this->Model->locationAdvSearch) && is_array($this->Model->locationAdvSearch)) {
				foreach ($this->Model->locationAdvSearch as $k => $v) {
					$r3[] = $this->Model->locationAdvSearch[$k];
				}
			}
		}
		$this->Model->searchAdvSearch = $r;
		$this->Model->searchFieldsAdvSearch = $r2;
		$this->Model->locationAdvSearch = $r3;
		
		for ($i = 0; $i < $this->searchclass->height; $i++) {
			$button = $we_button->create_button(
					"image:btn_function_trash", 
					"javascript:delRow(" . $i . ");", 
					true, 
					"", 
					"", 
					"", 
					"", 
					false);
			
			$locationDisabled = "";
			$handle = "";
			
			$searchInput = htmlTextInput(
					"searchAdvSearch[" . $i . "]", 
					30, 
					(isset($this->Model->searchAdvSearch) && is_array($this->Model->searchAdvSearch) && isset(
							$this->Model->searchAdvSearch[$i]) ? $this->Model->searchAdvSearch[$i] : ''), 
					"", 
					" class=\"wetextinput\"  id=\"searchAdvSearch['.$i.']\" ", 
					"text", 
					170);
			
			if (isset($this->Model->searchFieldsAdvSearch[$i])) {
				if ($this->Model->searchFieldsAdvSearch[$i] == "ParentIDDoc" || $this->Model->searchFieldsAdvSearch[$i] == "ParentIDObj" || $this->Model->searchFieldsAdvSearch[$i] == "ParentIDTmpl" || $this->Model->searchFieldsAdvSearch[$i] == "Content" || $this->Model->searchFieldsAdvSearch[$i] == "Status" || $this->Model->searchFieldsAdvSearch[$i] == "Speicherart" || $this->Model->searchFieldsAdvSearch[$i] == "MasterTemplateID" || $this->Model->searchFieldsAdvSearch[$i] == "temp_template_id" || $this->Model->searchFieldsAdvSearch[$i] == "temp_doc_type" || $this->Model->searchFieldsAdvSearch[$i] == "temp_category") {
					$locationDisabled = "disabled";
				}
				
				if ($this->Model->searchFieldsAdvSearch[$i] == "Status") {
					$searchInput = htmlSelect(
							"searchAdvSearch[" . $i . "]", 
							$this->searchclass->getFieldsStatus(), 
							1, 
							(isset($this->Model->searchAdvSearch) && is_array($this->Model->searchAdvSearch) && isset(
									$this->Model->searchAdvSearch[$i]) ? $this->Model->searchAdvSearch[$i] : ""), 
							false, 
							'class="defaultfont" style="width:170px;" id="searchAdvSearch[' . $i . ']" ');
				}
				
				if ($this->Model->searchFieldsAdvSearch[$i] == "Speicherart") {
					$searchInput = htmlSelect(
							"searchAdvSearch[" . $i . "]", 
							$this->searchclass->getFieldsSpeicherart(), 
							1, 
							(isset($this->Model->searchAdvSearch) && is_array($this->Model->searchAdvSearch) && isset(
									$this->Model->searchAdvSearch[$i]) ? $this->Model->searchAdvSearch[$i] : ""), 
							false, 
							'class="defaultfont" style="width:170px;" id="searchAdvSearch[' . $i . ']" ');
				}
				
				if ($this->Model->searchFieldsAdvSearch[$i] == "Published" || $this->Model->searchFieldsAdvSearch[$i] == "CreationDate" || $this->Model->searchFieldsAdvSearch[$i] == "ModDate") {
					$handle = "date";
					$searchInput = $this->getDateSelector(
							"", 
							"searchAdvSearch[" . $i . "]", 
							"_from" . $i, 
							$this->Model->searchAdvSearch[$i]);
				}
				
				if ($this->Model->searchFieldsAdvSearch[$i] == "temp_doc_type") {
					$searchInput = htmlSelect(
							"searchAdvSearch[" . $i . "]", 
							$this->searchclass->getDocTypes(), 
							1, 
							(isset($this->Model->searchAdvSearch) && is_array($this->Model->searchAdvSearch) && isset(
									$this->Model->searchAdvSearch[$i]) ? $this->Model->searchAdvSearch[$i] : ""), 
							false, 
							'class="defaultfont" style="width:170px;" id="searchAdvSearch[' . $i . ']" ');
				}
				
				if ($this->Model->searchFieldsAdvSearch[$i] == "ParentIDDoc" || $this->Model->searchFieldsAdvSearch[$i] == "ParentIDObj" || $this->Model->searchFieldsAdvSearch[$i] == "ParentIDTmpl") {
					$_linkPath = $this->Model->searchAdvSearch[$i];
					
					$_rootDirID = 0;
					$_cmd = "javascript:we_cmd('openDirselector',document.we_form.elements['searchAdvSearchParentID[" . $i . "]'].value,'" . FILE_TABLE . "','document.we_form.elements[\\'searchAdvSearchParentID[" . $i . "]\\'].value','document.we_form.elements[\\'searchAdvSearch[" . $i . "]\\'].value','','" . session_id() . "','$_rootDirID','','')";
					$_button = $we_button->create_button('select', $_cmd, true, 70, 22, '', '', false);
					$selector = htmlFormElementTable(
							htmlTextInput(
									'searchAdvSearch[' . $i . ']', 
									58, 
									$_linkPath, 
									'', 
									'readonly', 
									'text', 
									170, 
									0), 
							'', 
							'left', 
							'defaultfont', 
							we_htmlElement::htmlHidden(
									array(
										'name' => 'searchAdvSearchParentID[' . $i . ']', "value" => ""
									)), 
							getPixel(5, 4), 
							$_button);
					
					$searchInput = $selector;
				}
				if ($this->Model->searchFieldsAdvSearch[$i] == "MasterTemplateID" || $this->Model->searchFieldsAdvSearch[$i] == "temp_template_id") {
					$_linkPath = $this->Model->searchAdvSearch[$i];
					
					$_rootDirID = 0;
					$_cmd = "javascript:we_cmd('openDocselector',document.we_form.elements['searchAdvSearchParentID[" . $i . "]'].value,'" . TEMPLATES_TABLE . "','document.we_form.elements[\\'searchAdvSearchParentID[" . $i . "]\\'].value','document.we_form.elements[\\'searchAdvSearch[" . $i . "]\\'].value','','" . session_id() . "','$_rootDirID','','text/weTmpl')";
					$_button = $we_button->create_button('select', $_cmd, true, 70, 22, '', '', false);
					$selector = htmlFormElementTable(
							htmlTextInput(
									'searchAdvSearch[' . $i . ']', 
									58, 
									$_linkPath, 
									'', 
									'readonly', 
									'text', 
									170, 
									0), 
							'', 
							'left', 
							'defaultfont', 
							we_htmlElement::htmlHidden(
									array(
										'name' => 'searchAdvSearchParentID[' . $i . ']', "value" => ""
									)), 
							getPixel(5, 4), 
							$_button);
					
					$searchInput = $selector;
				}
				if ($this->Model->searchFieldsAdvSearch[$i] == "temp_category") {
					$_linkPath = $this->Model->searchAdvSearch[$i];
					
					$_rootDirID = 0;
					
					$_cmd = "javascript:we_cmd('openCatselector',document.we_form.elements['searchAdvSearchParentID[" . $i . "]'].value,'" . CATEGORY_TABLE . "','document.we_form.elements[\\'searchAdvSearchParentID[" . $i . "]\\'].value','document.we_form.elements[\\'searchAdvSearch[" . $i . "]\\'].value','','" . session_id() . "','$_rootDirID','','')";
					$_button = $we_button->create_button('select', $_cmd, true, 70, 22, '', '', false);
					$selector = htmlFormElementTable(
							htmlTextInput(
									'searchAdvSearch[' . $i . ']', 
									58, 
									$_linkPath, 
									'', 
									'readonly', 
									'text', 
									170, 
									0), 
							'', 
							'left', 
							'defaultfont', 
							we_htmlElement::htmlHidden(
									array(
										'name' => 'searchAdvSearchParentID[' . $i . ']', "value" => ""
									)), 
							getPixel(5, 4), 
							$_button);
					
					$searchInput = $selector;
				}
			}
			
			$out .= '
			
    <tr id="filterRow_' . $i . '">
     <td>' . hidden(
					"hidden_searchFieldsAdvSearch[" . $i . "]", 
					isset($this->Model->searchFieldsAdvSearch[$i]) ? $this->Model->searchFieldsAdvSearch[$i] : "") . '' . htmlSelect(
					"searchFieldsAdvSearch[" . $i . "]", 
					$this->searchclass->getFields($i, ""), 
					1, 
					(isset($this->Model->searchFieldsAdvSearch) && is_array($this->Model->searchFieldsAdvSearch) && isset(
							$this->Model->searchFieldsAdvSearch[$i]) ? $this->Model->searchFieldsAdvSearch[$i] : ""), 
					false, 
					'class="defaultfont" id="searchFieldsAdvSearch[' . $i . ']" onChange="changeit(this.value, ' . $i . ');" ') . '</td>
     <td id="td_locationAdvSearch[' . $i . ']">' . htmlSelect(
					"locationAdvSearch[" . $i . "]", 
					$this->searchclass->getLocation($handle), 
					1, 
					(isset($this->Model->locationAdvSearch) && is_array($this->Model->locationAdvSearch) && isset(
							$this->Model->locationAdvSearch[$i]) ? $this->Model->locationAdvSearch[$i] : ""), 
					false, 
					'class="defaultfont" ' . $locationDisabled . ' id="locationAdvSearch[' . $i . ']" ') . '</td>
     <td id="td_searchAdvSearch[' . $i . ']">' . $searchInput . '</td>
     <td id="td_delButton[' . $i . ']">' . $button . '</td>
    </tr>
    ';
		}
		
		$out .= '</tbody></table>';
		
		$out .= '<table>
     <tr>
      <td>' . $we_button->create_button(
				"add", 
				"javascript:newinputAdvSearch();") . '</td>
      <td>' . getPixel(10, 10) . '</td>
      <td colspan="7" align="right"></td>
     </tr>
    </table></div>';
		
		$out .= we_htmlElement::jsElement("calendarSetup(" . $this->searchclass->height . ");");
		
		return $out;
	}

	function getDateSelector($_label, $_name, $_btn, $value)
	{
		$we_button = new we_button();
		$btnDatePicker = $we_button->create_button(
				"image:date_picker", 
				"javascript:", 
				null, 
				null, 
				null, 
				null, 
				null, 
				null, 
				false, 
				$_btn);
		$oSelector = new we_htmlTable(
				array(
					"cellpadding" => "0", "cellspacing" => "0", "border" => "0", "id" => $_name . "_cell"
				), 
				1, 
				5);
		$oSelector->setCol(
				0, 
				2, 
				null, 
				htmlTextInput(
						$name = $_name, 
						$size = 55, 
						$value, 
						$maxlength = 10, 
						$attribs = 'id="' . $_name . '" class="wetextinput" readonly="1"', 
						$type = "text", 
						$width = 100));
		$oSelector->setCol(0, 3, null, "&nbsp;");
		$oSelector->setCol(0, 4, null, we_htmlElement::htmlA(array(
			"href" => "#"
		), $btnDatePicker));
		
		return $oSelector->getHTMLCode();
	}

	function tblList($content, $headline, $whichSearch)
	{
		
		$class = "middlefont";
		$view = 0;
		
		switch ($whichSearch) {
			case "DocSearch" :
				$view = $this->Model->setViewDocSearch;
				break;
			case "TmplSearch" :
				$view = $this->Model->setViewTmplSearch;
				break;
			case "AdvSearch" :
				$view = $this->Model->setViewAdvSearch;
				break;
			// for doclistsearch
			case "doclist" :
				$view = $GLOBALS['we_doc']->searchclassFolder->setView;
		}
		
		$anz = sizeof($headline);
		$out = '<table border="0" style="background-color:#fff;" cellpadding="0" cellspacing="0" width="100%">
       <tr style="height:20px;">
     <td style="border-bottom:1px solid #D1D1D1;">' . getPixel(56, 10) . '</td>
     <td style="border-bottom:1px solid #D1D1D1;">' . getPixel(1, 10) . '</td>';
		
		// widths of columns in headline in %
		$columnWidths = array(
			31, 36, 14, 19
		);
		for ($f = 0; $f < $anz; $f++) {
			$out .= '<td style="border-bottom:1px solid #D1D1D1;width:' . $columnWidths[$f] . '%;" class="' . $class . '">' . $headline[$f]["dat"] . '</td>';
		}
		
		$out .= '</tr></table>';
		$out .= '<div id="scrollContent_' . $whichSearch . '" style="overflow:auto;background-color:#fff;width:100%">';
		
		$out .= searchtoolView::tabListContent($view, $content, $class, $whichSearch);
		
		$out .= '</div>';
		
		return $out;
	}

	function tabListContent($view = "", $content = "", $class = "", $whichSearch = "")
	{
		if (isset($_REQUEST["we_cmd"]['obj']) || $whichSearch == "doclist") {
			$thisObj = new searchtoolView();
		} else {
			$thisObj = $this;
		}
		$x = count($content);
		if ($view == 0) {
			$out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
			
			for ($m = 0; $m < $x; $m++) {
				if ($whichSearch != "doclist") {
					$out .= '<tr>' . $thisObj->tblListRow($content[$m]) . '</tr>';
				} else {
					$out .= '<tr>' . searchtoolView::tblListRow($content[$m]) . '</tr>';
				}
			}
			$out .= '</tbody></table>';
		} else {
			$out = '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td align="center">';
			
			for ($m = 0; $m < $x; $m++) {
				$out .= '<div style="float:left;width:180px;height:100px;margin:20px 0px 0px 20px;z-index:1;">';
				if ($whichSearch != "doclist") {
					$out .= $thisObj->tblListRowIconView($content[$m], $class, $m, $whichSearch);
				} else {
					$out .= searchtoolView::tblListRowIconView($content[$m], $class, $m, $whichSearch);
				}
				
				$out .= '</div>';
			}
			
			$out .= '</td></tr></table>';
			
			if ($whichSearch != "doclist") {
				$allDivs = $thisObj->makeMouseOverDivs($x, $content, $whichSearch);
			} else {
				$allDivs = searchtoolView::makeMouseOverDivs($x, $content, $whichSearch);
			}
			
			$out .= "<script type='text/javascript'>document.getElementById('mouseOverDivs_" . $whichSearch . "').innerHTML = '" . addslashes(
					$allDivs) . "';</script>";
		}
		return $out;
	}

	function makeMouseOverDivs($x, $content, $whichSearch)
	{
		$allDivs = "";
		$outDivs = "";
		
		$width = ($GLOBALS['BROWSER'] == "IE" ? "400px" : "398px");
		
		for ($n = 0; $n < $x; $n++) {
			$outDivs = '<div style="position:absolute;left:-9999px;width:400px;text-align:left;z-index:10000;visibility:visible;" class="middlefont" id="ImgDetails_' . $n . '_' . $whichSearch . '">';
			$outDivs .= '<div style="width:17px;height:22px;position:absolute;top:0px;left:0px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/loDoclistDiv.gif);"></div>';
			$outDivs .= '<div style="width:365px;height:22px;position:absolute;top:0px;left:17px;padding-top:3px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/moDoclistDiv.gif);" class="weDocListSearchHeadlineDivs">' . $content[$n][10]["dat"] . '</div>';
			$outDivs .= '<div style="width:18px;height:22px;position:absolute;top:0px;left:382px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/roDoclistDiv.gif);"></div>';
			$outDivs .= '<div style="width:' . $width . ';position:relative;top:22px;left:0px;border-right:1px solid #A8A7A8;border-left:1px solid #A8A7A8;">';
			$outDivs .= '<div style="width:100%;height:1px;overflow:hidden;background-color:#DDDDDD;">';
			$outDivs .= '</div>';
			$outDivs .= '<div style="width:100%;background-color:#EDEDED;position:relative;">';
			$outDivs .= '<div style="padding:15px;position:absolute;">';
			$outDivs .= $content[$n][5]["dat"];
			$outDivs .= '</div>';
			$outDivs .= '<div style="padding:15px;position:relative;top:0px;left:160px;width:200px;">';
			
			$outDivs .= '<table style="font-size:10px;" border="0" cellspacing="0" cellpadding="3">';
			$outDivs .= '<tr>';
			$outDivs .= '<td colspan="2" style="font-size:12px;">';
			$outDivs .= $content[$n][9]["dat"];
			$outDivs .= '<br/><br/></td></tr>';
			$outDivs .= '<tr><td valign="top">';
			$outDivs .= $GLOBALS['l_weSearch']["idDiv"] . ': ';
			$outDivs .= '</td>';
			$outDivs .= '<td>';
			$outDivs .= $content[$n][16]["dat"];
			$outDivs .= '</td></tr>';
			$outDivs .= '<tr><td valign="top">';
			$outDivs .= $GLOBALS['l_weSearch']["dateityp"] . ': ';
			$outDivs .= '</td>';
			$outDivs .= '<td>';
			$outDivs .= $content[$n][8]["dat"];
			$outDivs .= '</td></tr>';
			if ($content[$n][12]["dat"] == "image/*" || $content[$n][12]["dat"] == "application/*") {
				$outDivs .= '<tr><td valign="top">';
				$outDivs .= $GLOBALS['l_weSearch']["groesse"] . ': ';
				$outDivs .= '</td>';
				$outDivs .= '<td>';
				$outDivs .= $content[$n][6]["dat"];
				$outDivs .= '</td></tr>';
				if ($content[$n][12]["dat"] == "image/*") {
					$outDivs .= '<tr><td valign="top">';
					$outDivs .= $GLOBALS['l_weSearch']["aufloesung"] . ': ';
					$outDivs .= '</td>';
					$outDivs .= '<td>';
					$outDivs .= $content[$n][7]["dat"];
					$outDivs .= '</td></tr>';
				}
			}
			if ($content[$n][12]["dat"] == "text/webedition") {
				$outDivs .= '<tr><td valign="top">';
				$outDivs .= $GLOBALS['l_weSearch']["template"] . ': ';
				$outDivs .= '</td>';
				$outDivs .= '<td>';
				$outDivs .= $content[$n][14]["dat"];
				$outDivs .= '</td>';
				$outDivs .= '<td></tr>';
			}
			$outDivs .= '<tr><td valign="top">';
			$outDivs .= $GLOBALS['l_weSearch']["creator"] . ': ';
			$outDivs .= '</td>';
			$outDivs .= '<td>';
			$outDivs .= $content[$n][13]["dat"];
			$outDivs .= '</td></tr>';
			$outDivs .= '<tr><td valign="top">';
			$outDivs .= $GLOBALS['l_weSearch']["created"] . ': ';
			$outDivs .= '</td>';
			$outDivs .= '<td>';
			$outDivs .= $content[$n][3]["dat"];
			$outDivs .= '</td></tr>';
			$outDivs .= '<tr><td valign="top">';
			$outDivs .= $GLOBALS['l_weSearch']["modified"] . ': ';
			$outDivs .= '</td>';
			$outDivs .= '<td>';
			$outDivs .= $content[$n][4]["dat"];
			$outDivs .= '</td></tr></table>';
			$outDivs .= '</div>';
			
			$outDivs .= '<div style="padding:0px 0px 6px 15px;position:relative;top:0px;left:0px;width:360px;">';
			if ($content[$n][11]["dat"] != "") {
				$outDivs .= '<table cellpadding="0" cellspacing="0" border="0" style="font-size:10px;"><tr><td valign="top">' . $GLOBALS['l_weSearch']["beschreibung"] . ':</td><td>' . getPixel(
						15, 
						5) . '</td><td>';
				$outDivs .= shortenPath($content[$n][11]["dat"], 150);
				$outDivs .= '</td></tr></table>';
			}
			$outDivs .= '</div>';
			$outDivs .= '</div>';
			if (!empty($content[$n][15]["dat"])) {
				$outDivs .= '<div style="width:100%;position:relative;top:0px;height:1px;overflow:hidden;background-color:#DDDDDD;">';
				$outDivs .= '</div>';
				$outDivs .= '<div style="width:100%;position:relative;top:0px;height:1px;overflow:hidden;background-color:#FFF;">';
				$outDivs .= '</div>';
				$outDivs .= '<div style="width:100%;position:relative;top:0px;height:20px;overflow:hidden;background-color:#DDDDDD;">';
				$outDivs .= '<div style="margin:5px 0px 0px 15px">' . $GLOBALS['l_weSearch']["metafelder"] . ':</div>';
				$outDivs .= '</div>';
				$outDivs .= '<div style="width:100%;position:relative;top:0px;background-color:#FFF;">';
				$outDivs .= '<div style="padding:10px 0px 10px 15px;">';
				$outDivs .= '<table style="font-size:10px;" border="0" cellspacing="0" cellpadding="3">';
				foreach ($content[$n][15]["dat"] as $k => $v) {
					$outDivs .= '<tr><td>';
					$outDivs .= shortenPath($k, 90) . ':';
					$outDivs .= '</td><td>';
					$outDivs .= shortenPath($v, 90);
					$outDivs .= '</td></tr>';
				}
				$outDivs .= '</table>';
				$outDivs .= '</div>';
				$outDivs .= '</div>';
			}
			
			$outDivs .= '<div style="width:100%;position:relative;top:0px;height:1px;overflow:hidden;background-color:#DDDDDD;">';
			$outDivs .= '</div>';
			$outDivs .= '</div>';
			
			$outDivs .= '<div style="position:relative;">';
			
			$outDivs .= '<div style="width:15px;height:20px;position:absolute;top:20px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/luDoclistDiv.gif);"></div>';
			$outDivs .= '<div style="width:371px;height:20px;position:absolute;top:20px;left:15px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/muDoclistDiv.gif);"></div>';
			$outDivs .= '<div style="width:14px;height:20px;position:absolute;top:20px;left:386px;background-image:url(' . IMAGE_DIR . 'backgrounds/doclistBg/ruDoclistDiv.gif);"></div>';
			$outDivs .= '</div>';
			$outDivs .= '</div>';
			$allDivs = $allDivs . $outDivs;
		}
		
		return $allDivs;
	}

	function tblListRow($content, $class = "middlefont", $bgColor = "")
	{
		$anz = sizeof($content);
		if (isset($content[0]["version"])) {
			$anz = sizeof($content) - 1;
		}
		
		$out = '';
		$columnWidths = array(
			0, 2, 28, 36, 15, 19
		);
		for ($f = 0; $f < $anz; $f++) {
			if ($f == 0) {
				$width = "width:30px;";
				$plcholder = "";
				$align = "center";
			} else {
				$width = "width:" . $columnWidths[$f] . "%;";
				$plcholder = getPixel(10, 1);
				$align = "left";
			}
			$out .= '<td align="' . $align . '" style="font-weight:bold;height:30px;font-size:11px;' . $width . '">' . $plcholder . ((isset(
					$content[$f]["dat"]) && $content[$f]["dat"]) ? $content[$f]["dat"] : "&nbsp;") . '</td>';
		
		}
		
		if (isset($content[0]["version"])) {
			$anzahlVersions = sizeof($content[0]["version"]);
			
			foreach ($content[0]["version"] as $k => $v) {
				$out .= '</tr><tr>';
				$out .= '<td style="width:20px;">' . getPixel(20, 10) . '</td>';
				for ($y = 0; $y < $anz; $y++) {
					
					if ($f == 0) {
						$width = "width:30px;";
					} else {
						$width = "";
					}
					$out .= '<td style="font-weight:bold;font-size:11px;' . $width . '">' . getPixel(5, 10) . $content[$y]["version"][$k] . '</td>';
				
				}
				
				$out .= '</tr><tr>';
				$out .= '<td style="width:20px;">' . getPixel(20, 10) . '</td>';
				for ($y = 0; $y < $anz; $y++) {
					
					if ($f == 0) {
						$width = "width:30px;";
					} else {
						$width = "";
					}
					if ($y == 2) {
						$out .= '<td style="font-weight:bold;font-size:11px;' . $width . '">' . $content[5]["version"][$k] . '<br/></td>';
					} else {
						$out .= '<td style="font-weight:bold;font-size:11px;' . $width . '">' . getPixel(1, 1) . '</td>';
					}
				
				}
			
			}
		
		}
		
		return $out;
	}

	function tblListRowIconView($content, $class = "defaultfont", $i, $whichSearch)
	{
		$out = '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="' . $class . '"><tr>';
		$out .= '<td width="75" valign="top" align="center" onmouseover="showImageDetails(\'ImgDetails_' . $i . '_' . $whichSearch . '\',1)" onmouseout="hideImageDetails(\'ImgDetails_' . $i . '_' . $whichSearch . '\')">' . ((isset(
				$content[0]["dat"]) && $content[0]["dat"]) ? $content[0]["dat"] : "&nbsp;") . '</td>';
		$out .= '<td width="105" valign="top" style="line-height:20px;">';
		$out .= '<span>' . ((isset($content[2]["dat"]) && $content[2]["dat"]) ? $content[2]["dat"] : "&nbsp;") . '</span><br/><br/>';
		$out .= '<span>' . ((isset($content[1]["dat"]) && $content[1]["dat"]) ? $content[1]["dat"] : "&nbsp;") . '</span></td>';
		$out .= '</tr></table>';
		
		return $out;
	}

	function getDirSelector($whichSearch)
	{
		$we_button = new we_button();
		
		switch ($whichSearch) {
			case "DocSearch" :
				$folderID = "folderIDDoc";
				$folderPath = "folderPathDoc";
				$table = FILE_TABLE;
				$pathID = $this->Model->folderIDDoc;
				$ACname = "docu";
				break;
			case "TmplSearch" :
				$folderID = "folderIDTmpl";
				$folderPath = "folderPathTmpl";
				$table = TEMPLATES_TABLE;
				$pathID = $this->Model->folderIDTmpl;
				$ACname = "Tmpl";
				break;
		}
		
		$_path = id_to_path($pathID, $table, $this->db);
		
		$yuiSuggest = & weSuggest::getInstance();
		$yuiSuggest->setAcId($ACname);
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($folderPath, $_path);
		$yuiSuggest->setLabel("");
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($folderID, $pathID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable($table);
		$yuiSuggest->setWidth(380);
		$yuiSuggest->setSelectButton(
				$we_button->create_button(
						"select", 
						"javascript:we_cmd('openDirselector',document.we_form.elements['$folderID'].value,'" . $table . "','document.we_form.elements[\\'$folderID\\'].value','document.we_form.elements[\\'$folderPath\\'].value')"));
		
		$weAutoCompleter = $yuiSuggest->getYuiFiles();
		$weAutoCompleter .= $yuiSuggest->getHTML();
		$weAutoCompleter .= $yuiSuggest->getYuiCode();
		
		return $weAutoCompleter;
	}
}
?>