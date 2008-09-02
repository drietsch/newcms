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