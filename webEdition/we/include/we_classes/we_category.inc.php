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
 * @package    webEdition_model
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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