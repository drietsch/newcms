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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/"."listviewBase.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/shop/weShopVariants.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_webEditionDocument.inc.php');
/**
* class    we_listview_object
* @desc    class for tag <we:listview type="shopVariants">
*
*/
class we_listview_shopVariants extends listviewBase {
	
	var $Record = array();
	var $ClassName = "we_listview_shopVariants";
	var $VariantData = array();
	var $Position = 0;
	var $Id = 0;
	var $ObjectId = 0;
	var $DefaultName = 'default';
	var $Model = null;
	var $IsObjectFile = false;

	function we_listview_shopVariants($name="0", $rows, $defaultname='default', $documentid='', $objectid='', $offset=0) {

		listviewBase::listviewBase($name, $rows, $offset);
		
		// we have to init a new document and look for the given field
		// get id of given document and check if it is a document or an objectfile
		if ($documentid || ($objectid && defined('OBJECT_TABLE')) ) {
			
			if ($documentid) {
				
				$this->Id = $documentid;
				
				$doc = new we_webEditionDocument();
				$doc->initByID($this->Id);
				
			} else if ($objectid) {
				
				include_once(WE_OBJECT_MODULE_DIR . 'we_objectFile.inc.php');
				
				$this->IsObjectFile = true;
				
				$this->Id = $objectid;
				
				$doc = new we_objectFile();
				$doc->initByID($this->Id, OBJECT_FILES_TABLE);
			}
			
		} else {
			
			// check if its a document or a objectFile
			if (isset($GLOBALS['we_doc']->ObjectID)) { // is an objectFile
				
				$this->Id = isset($GLOBALS['we_doc']->OF_ID) ? $GLOBALS['we_doc']->OF_ID : $GLOBALS['we_doc']->ID;
				$this->IsObjectFile = true;
				
				$doc = new we_objectFile();
				$doc->initByID($this->Id, OBJECT_FILES_TABLE);
				
			} else {
				
				$this->Id = $GLOBALS['we_doc']->ID;
			
				$doc = new we_webEditionDocument();
				$doc->initByID($this->Id);
			}
		}
		
		// store model in listview object
		$this->Model = $doc;
		
		$this->DefaultName = $defaultname;
		
		$variantData = weShopVariants::getVariantData($this->Model, $this->DefaultName);
		
		$this->VariantData['Record'] = $variantData;
		
		$this->anz_all = sizeof($this->VariantData['Record']);
		$this->anz = $this->rows;
	}
	
	
	function next_record() {
		
		$this->Position = ($this->count + $this->start);
		
		if (isset($this->VariantData['Record'][$this->Position])) {
			
			$ret = $this->VariantData['Record'][$this->Position];
			
			list($key, $vardata) = each($ret);
			foreach ($vardata as $name => $value) {
				
				if ($value['type'] == 'img') {
					// there is a difference between objects and webEdition Documents
					$ret[$name] = isset($value['bdid']) ? $value['bdid'] : $value['dat'];
				} else {
					if ($key == $this->DefaultName) {
						$ret[$name] = $this->Model->getElement($name);
					} else {
						$ret[$name] = $this->Model->getElement(WE_SHOP_VARIANTS_PREFIX . $this->Position . '_' . $name);
					}
				}
			}
			
			$varUrl = '';
			$ret['WE_VARIANT_NAME'] = $key;
			$ret['WE_VARIANT'] = '';
			
			if ($key != $this->DefaultName) {
				$varUrl = WE_SHOP_VARIANT_REQUEST . '=' . $key;
				$ret['WE_VARIANT'] = $key;
			}

			$ret['WE_ID'] = $this->Id;
			if ($this->IsObjectFile) { // objectFile
				$ret['WE_PATH'] = $GLOBALS['we_doc']->Path."?we_objectID=".$this->Id . ($varUrl ? "&amp;$varUrl" : '');
			} else { // webEdition Document
				$ret['WE_PATH'] = $this->Model->Path . ($varUrl ? "?$varUrl" : '');
			}

			$this->Record = $ret;
			$this->count++;
			return true;
		}
		return false;
	}
	
	function f($key){
		
		if ( isset( $this->Record[$key] ) ) {
			return $this->Record[$key];
		} else {
		 	return '';
		}
	}
}

?>
