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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");

/* clipboard object class */
class we_msg_update extends we_class {

	/*****************************************************************/
	/* Class Properties **********************************************/
	/*****************************************************************/

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName = 'we_msg_class';
	/* In this array are all storagable class variables */
	var $persistent_slots = array();
	/* Name of the Object that was createt from this class */
	var $Name='';

	/* ID from the database record */
	var $ID=0;
	
	/* Flag which is set when the file is not new */
	var $wasUpdate=0;
	
	var $userid = -1;

	var $username = '';

	/*****************************************************************/
	/* Class Methods *************************************************/
	/*****************************************************************/
	
	/* Constructor */
	function we_clipboard() {
		$this->Name = 'msg_clipboard_' . md5(uniqid(rand()));
		array_push($this->persistent_slots, 'ClassName','Name','ID', 'Folder_ID', 'selected_message', 'selected_set', 'sort_order', 'last_sortfield', 'search_ids', 'available_folders', 'search_folders', 'search_fields');
	}

}
	
?>
