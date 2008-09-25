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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/modules/weModelBase.php');


	class we_thumbnail extends weModelBase  {
		
		var $table = THUMBNAILS_TABLE;
		var $ClassName = 'we_thumbnail';
		var $Table = THUMBNAILS_TABLE;
		var $ContentType = 'weThumbnail';
	
	

		function we_thumbnail() {
			parent::weModelBase(THUMBNAILS_TABLE);
		}
		
		function we_load($id) {
			parent::load($id);
			$this->ContentType = 'weThumbnail';
		}
	
		function we_save() {
			parent::save($this->ID ? false : true);
		}

	}




?>