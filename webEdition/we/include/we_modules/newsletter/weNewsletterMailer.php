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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_mailer_class.inc.php");

class weNewsletterMailer extends we_mailer{

	var $related=array();

	/**
	 * default contructor
	 *
	 * @param string $recipient
	 * @param string $subject
	 * @param string $txt
	 * @param string $from
	 * @param string $reply
	 * @param string $sendHTML
	 * @param string $charset
	 * @param string $basehref
	 * @param string $alttext
	 * @param string $additional
	 * @return weNewsletterMailer
	 */
	function weNewsletterMailer($recipient,$subject,$txt,$from="",$reply="",$sendHTML=0,$charset = "iso-8859-1",$basehref="",$alttext="",$additional=''){
		parent::we_mailer($recipient,$subject,$txt,$from,$reply,$sendHTML,$charset,$basehref,$alttext,$additional);
	}

	/**
	 * embed binery data
	 *
	 * @param string $data
	 * @param string $name
	 */
	function embed($data,$name){
		$ext = ereg_replace(".*(\.[^\.]+)$",'\1',$name);
		$ct = $this->getMimeType($ext);
		$inline = (substr($ct,0,5) == "image");

		$_namesplit = split("/",$name);
		$_name = $_namesplit[count($_namesplit)-1];
		unset($_namesplit);
		$foo = "Content-Disposition: inline; filename=$_name\n";		
		$foo .= "Content-Transfer-Encoding: base64\n";
		$foo .= "Content-Type: $ct;name=\"$_name\"\n";

		$foo .= "Content-Location: $name\n";
		$foo .= "\n";
		$foo .= $data;
		$foo .= "\n";			
		
		array_push($this->attachments,$foo);
	}

}


?>