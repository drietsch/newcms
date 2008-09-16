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

include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLFileReader.class.php');

class weBackupFileReader extends weXMLFileReader{
	
	function preParse(&$content) {

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');		

		$match = array();

		if(eregi('<we:table(item)?([^>]*)',$content,$match)) {
			
			$attributes = explode('=',$match[2]);
			$attributes[0] = trim($attributes[0]);
			
			if($attributes[0]=='name' || $attributes[0]=='table') {
				$attributes[1] = trim(eregi_replace('["|\']','',$attributes[1]));
				
				// if the table should't be imported
				if(weBackupUtil::getRealTableName($attributes[1])===false){

					return true;
				}
			}
			
		}
		
		if(eregi('<we:binary><ID>([^<]*)</ID>(.*)<Path>([^<]*)</Path>',$content,$match)){
			
			if(!weBackupUtil::canImportBinary($match[1],$match[3])){

				return true;
			}
			
		}	
		
		if(eregi('<we:version><ID>([^<]*)</ID>(.*)<Path>([^<]*)</Path>',$content,$match)){
			
			if(!weBackupUtil::canImportVersion($match[1],$match[3])){

				return true;
			}
			
		}	
		
		return false;
	}
	
}


?>