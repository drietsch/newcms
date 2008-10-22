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
 * @package    webEdition_cms
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */
include_once ($GLOBALS['__WE_BASE_PATH__'] . DIRECTORY_SEPARATOR . 'we' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'we_conf_global.inc.php');

class EcondasettingsController extends Zend_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {  
    	$translate = we_core_Local::addTranslation('econda.xml');
	   	$this->view = new we_ui_view_DialogView();
		$this->view->setScriptPath('views/scripts');
		
		// assign variables for the view
		if (we_core_Permissions::hasPerm("ADMINISTRATOR")) {
			$this->view->assign("activateEconda",(defined("WE_ECONDA_STAT") ? WE_ECONDA_STAT : 1));
			$this->view->assign("econdaParentId",(defined("WE_ECONDA_PARENT_ID") ? WE_ECONDA_PARENT_ID : 0));
			$this->view->assign("econdaParentPath",(defined("WE_ECONDA_PARENT_PATH") ? WE_ECONDA_PARENT_PATH : "/"));
			$this->view->assign("econdaFileName",(defined("WE_ECONDA_FILE") ? WE_ECONDA_FILE : $translate->_("File not uploaded jet.")));
		} else {
			$this->view->assign("msg",$translate->_("EcondaDialogNoperm"));	
		}
		echo $this->view->render('econdasettings/index.php');
    } 
    
	/**
	 * Safe and upload action - show the home page with safe and upload infos
	 */
	public function safeuploadAction()
	{

		$this->view = new we_ui_view_DialogView();
		$this->view->setScriptPath('views/scripts');
		$translate = we_core_Local::addTranslation('econda.xml');
		
		if (we_core_Permissions::hasPerm("ADMINISTRATOR")) {
			// only admins may safe the settings and upload econda files
			
			include_once($GLOBALS['__WE_BASE_PATH__']."/we/include/we_classes/base/weConfParser.class.php");

			$activateEconda   = $this->getRequest()->getParam('activate');
			$econdaParentPath = $this->getRequest()->getParam('econdaParentPath');
			$econdaParentId   = $this->getRequest()->getParam('econdaParentId');
			$this->view->assign("activateEconda", $activateEconda);  
			$this->view->assign("econdaParentPath", $econdaParentPath);  

			if ((isset($_FILES['emosfile']) && $_FILES['emosfile']['size']) || defined('WE_ECONDA_ID')) {
				// do if file is uploaded or settings are changed 
				
   				include_once($GLOBALS['__WE_BASE_PATH__']."/we/include/we_classes/we_textContentDocument.inc.php");
			
				if (!defined('WE_ECONDA_STAT') || WE_ECONDA_STAT != $activateEconda) {
	   				// change econda status
					weConfParser::setGlobalPref('WE_ECONDA_STAT', $activateEconda); 
				}
				
				$msg = "";
				
		   		if (isset($_FILES['emosfile']) && $_FILES['emosfile']['size']) {
		   			// upload econda file
		   			
		   			if($_FILES['emosfile']['error']) {
		   				// error while uploading
		   				$this->view->assign("econdaFileName",(defined("WE_ECONDA_FILE") ? WE_ECONDA_FILE : $translate->_("File not uploaded jet.")));
		   				$this->view->assign("msg",$translate->_("EcondaFileUploadError"));
		   				$this->view->assign("prio",4);
		   			} elseif ($_FILES['emosfile']['type'] != "application/x-javascript"){
		   				// wrong data type
		   				$this->view->assign("econdaFileName",(defined("WE_ECONDA_FILE") ? WE_ECONDA_FILE : $translate->_("File not uploaded jet.")));
		   				$this->view->assign("msg",$translate->_("EcondaNoJsFile"));
		   				$this->view->assign("prio",4);
		   			} else {
		   				// file uploded
						$we_File = TMP_DIR."/".md5(uniqid(rand(),'-1'));
						move_uploaded_file($_FILES["emosfile"]["tmp_name"],$we_File);
		   				$we_doc = new we_textDocument();
		   				
						if (defined('WE_ECONDA_ID')) {	
							// overwrite webEdition file if exists						
							$we_doc->initByID(WE_ECONDA_ID,FILE_TABLE);
							if (!$we_doc->ID) {
								$we_doc->we_new();
							}							
						} else {
							// create new webEdition file
							$we_doc->we_new();
							
						}
						
						// overwrite allways filename
						$we_doc->Filename = preg_replace("/[^A-Za-z0-9._-]/", "", $_FILES["emosfile"]["name"]);
						$we_doc->Filename = eregi_replace('^(.+)\..+$',"\\1",$we_doc->Filename);
						
						// make changes and save
						$we_doc->ContentType = "text/js";
						$we_doc->Table       = FILE_TABLE;
						$we_doc->setParentID($econdaParentId);						
						$we_doc->Extension = '.js';
						$we_doc->Text = $we_doc->Filename.$we_doc->Extension;
						$we_doc->Path = $we_doc->getPath();
						$we_doc->DocChanged = true;						
						$we_doc->setElement("dat", file_get_contents($we_File));
						@unlink($we_File);						
						$we_doc->we_save();
						
						// set econda conf_global
						weConfParser::setGlobalPref('WE_ECONDA_ID',$we_doc->ID);
						weConfParser::setGlobalPref('WE_ECONDA_PATH',$we_doc->Path);
						weConfParser::setGlobalPref('WE_ECONDA_FILE',$we_doc->Filename.$we_doc->Extension);
						weConfParser::setGlobalPref('WE_ECONDA_PARENT_ID',$econdaParentId);
						weConfParser::setGlobalPref('WE_ECONDA_PARENT_PATH',$econdaParentPath);
						
						// assign variables for the view
		   				$msg .= $translate->_("The file upload was successfull.");
		   				$msg .= $translate->_("ECONDA settings safed.");
		   				$this->view->assign("msg",$msg);
		   				$this->view->assign("prio",'-1');						   				
		   				$this->view->assign("econdaFileName",$we_doc->Filename.$we_doc->Extension);						   				
		   			}
		   		} else {
		   			// change path
   					if (WE_ECONDA_PARENT_PATH != $econdaParentPath || WE_ECONDA_PARENT_ID !=$econdaParentId) {
						$we_doc = new we_textDocument();
						$we_doc->initByID(WE_ECONDA_ID,FILE_TABLE);
						if (!$we_doc->ID) {
							// webEdition econda-js file not found
				   			$this->view->assign("econdaFileName",$translate->_("File not uploaded jet."));
				   			$this->view->assign("msg",$translate->_("Please select the ECONDA JS file for upload."));
		   					$this->view->assign("prio",4);
						} else {
							// change path for webEdition econda-js file
							$we_doc->setParentID($econdaParentId);
							$we_doc->Path = $we_doc->getPath();
							$we_doc->DocChanged = true;
							$we_doc->we_save();
							
							// set econda conf_global
							weConfParser::setGlobalPref('WE_ECONDA_PARENT_ID',$econdaParentId);
							weConfParser::setGlobalPref('WE_ECONDA_PARENT_PATH',$econdaParentPath);
							weConfParser::setGlobalPref('WE_ECONDA_PATH',$we_doc->Path);
							
							// assign variables for the view
							$this->view->assign("econdaFileName",(defined("WE_ECONDA_FILE") ? WE_ECONDA_FILE : $translate->_("File not uploaded jet.")));
			   				$this->view->assign("msg",$translate->_("ECONDA settings safed."));
		   					$this->view->assign("prio","-1");
						}
					}
		   		}
		   	} else {
		   		// assign variables for the view
		   		$this->view->assign("econdaFileName",$translate->_("File not uploaded jet."));
		   		$this->view->assign("msg",$translate->_("Please select the ECONDA JS file for upload."));
		   		$this->view->assign("prio",4);
		   	}
	   	} else {
	   		// show message for none admins
			$this->view->assign("msg",$translate->_("EcondaDialogNoperm"));			
	   	}
	   	
		echo $this->view->render('econdasettings/index.php');
	}
}