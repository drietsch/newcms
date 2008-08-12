<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

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