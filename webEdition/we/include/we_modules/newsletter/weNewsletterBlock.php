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


// Document based Newsletter Block
define ("WENBLOCK_DOCUMENT", 0);
// Document field based Newsletter Block
define ("WENBLOCK_DOCUMENT_FIELD", 1);
// Object based Newsletter Block
define ("WENBLOCK_OBJECT", 2);
// Object field based Newsletter Block
define ("WENBLOCK_OBJECT_FIELD", 3);
// File based Newsletter Block
define ("WENBLOCK_FILE", 4);
//  Text based Newsletter Block
define ("WENBLOCK_TEXT", 5);
//  Newsletter attachment
define ("WENBLOCK_ATTACHMENT", 6);
//  URL based newsletter
define ("WENBLOCK_URL", 7);

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/newsletter/weNewsletterBase.php");

/**
* Definition of WebEdition Newsletter Block
*
*/
class weNewsletterBlock extends weNewsletterBase{

	//properties
	var $ID;
	var $NewsletterID;
	var $Groups;
	var $Type;
   var $LinkID;
	var $Field;
	var $Source;
	var $Html;

   /*******************************************************
	* Default Constructor
	* Can load or create new Newsletter depends of parameter
	********************************************************/
   function weNewsletterBlock($newsletterID = 0)
	{

		parent::weNewsletterBase();
		$this->table=NEWSLETTER_BLOCK_TABLE;

		//$this->persistents[]="ID";
		$this->persistents[]="NewsletterID";
		$this->persistents[]="Groups";
		$this->persistents[]="Type";
		$this->persistents[]="LinkID";
		$this->persistents[]="Field";
		$this->persistents[]="Source";
		$this->persistents[]="Html";
		$this->persistents[]="Pack";

		$this->ID = 0;
		$this->NewsletterID=0;
		$this->Groups="";
		$this->Type = WENBLOCK_DOCUMENT;
	  	$this->LinkID=0;
		$this->Field="";
		$this->Source="";
		$this->Html="";
		$this->Pack="";


		if ($newsletterID)
		{
			$this->ID=$newsletterID;
			$this->load($newsletterID);
		}
	}

	/****************************************
	* saves newsletter blocks in database
	*
	*****************************************/
	function save(){

		$this->Groups= makeCSVFromArray(makeArrayFromCSV($this->Groups),true);
	  parent::save();
		return true;
	}

	/****************************************
	* deletes newsletter blocks from database
	*
	*****************************************/
	function delete(){

		parent::delete();
		return true;
	}

	//---------------------------------- STATIC FUNCTIONS -------------------------------

	/******************************************************
	* return all newsletter blocks for given newsletter id
	*
	*******************************************************/
	function __getAllBlocks($newsletterID){

		$db = new DB_WE();

		$db->query("SELECT ID FROM ".NEWSLETTER_BLOCK_TABLE." WHERE NewsletterID=".abs($newsletterID)." ORDER BY ID");
		$ret = array();
		while ($db->next_record()){
			$ret[] = new weNewsletterBlock($db->f("ID"));
		}
		return $ret;
	}



}


?>
