<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_model
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Class we_category
 *
 * Provides functions for handling webEdition category.
 */

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."modules/weModelBase.php");

	class we_category extends weModelBase{
		
		var $ClassName="we_category";
		var $ContentType="category";
		
		function we_category(){			
			weModelBase::weModelBase(CATEGORY_TABLE);		
		}
		
		function we_save(){
			if(isset($this->Catfields) && is_array($this->Catfields)){
				$this->Catfields = serialize($this->Catfields);
			}
			
			weModelBase::save();
			
		}
		
		
		
	} 
		

?>