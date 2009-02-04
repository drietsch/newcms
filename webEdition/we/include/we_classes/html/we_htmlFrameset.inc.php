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

/**
 * Filename:    we_htmlTable.inc.php
 * Directory:   /webEdition/we/include/we_classes/html
 *
 * Function:    Utility class that implements operations on tables
 *
 * Description: Provides functions for creating html tags used in forms.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_baseCollection.inc.php");

class we_htmlFrameset extends we_baseCollection {
	
	/**
	 * Constructor
	 *
	 * @param		$attribs								array			(optional)
	 * @param		$frames_num								int				(optional)
	 *
	 * @return		we_htmlFrameset
	 */ 	 	 

	function we_htmlFrameset($attribs=array(),$frames_num=0) {
		$this->we_baseCollection("frameset",true,$attribs);
		for($i=0;$i<$frames_num;$i++) $this->addFrame();
	}

	/**
	 * Function adds new frame to frameset
	 *
	 * Description: Constructor
	 *
	 * @param		$attribs								array			(optional)
	 *
	 * @return		void
	 */
	function addFrame($attribs=array()){
		$this->childs[]=new we_baseElement("frame",false,$attribs);		
	}
	
	/**
	 * Function adds new frameset to frameset
	 *
	 * @param		$attribs								array			(optional)
	 *
	 * @return		void
	 */	
	function addFrameset($attribs=array()){
		$this->childs[]=new we_htmlFrameset($attribs);
	}
	
	/**
	 * Function sets frame's attributes
	 *
	 * @param		$attribs								array			(optional)
	 *
	 * @return		void
	 */	
	function setFrameAttributes($childid,$attribs=array()){
		
		$frame=& $this->getChild($childid);
		$frame->setAttributes($attribs);
					
	}
	
	/**
	 * Function returns genereted html code.
	 *
	 * @return		string
	 */	
	function getHtmlCode(){
		return we_baseCollection::getHtmlCode($this);
	}

}

?>