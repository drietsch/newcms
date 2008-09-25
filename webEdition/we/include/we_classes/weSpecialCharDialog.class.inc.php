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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");

class weSpecialCharDialog extends weDialog{

##################################################################################################

	var $dialogWidth = 270;
	var $JsOnly = true;

	var $changeableArgs = array("char");

	var $charset = "iso-88591";

##################################################################################################

	function weSpecialCharDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["insertspecialchar"];
		$this->defaultInit();
	}

##################################################################################################

	function defaultInit(){
		$this->args["char"] = "";
	}


##################################################################################################

	function getDialogContentHTML(){

		$chars=array("&lsquo;",
"&rsquo;",
"&sbquo;",
"&ldquo;",
"&rdquo;",
"&bdquo;",
"&dagger;",
"&Dagger;",
"&permil;",
"&lsaquo;",
"&rsaquo;",
"&spades;",
"&clubs;",
"&hearts;",
"&diams;",
"&oline;",
"&larr;",
"&uarr;",
"&rarr;",
"&darr;",
"&trade;",
"&frasl;",
"&ndash;",
"&mdash;",
"&iexcl;",
"&cent;",
"&pound;",
"&euro;",
"&yen;",
"&brvbar;",
"&uml;",
"&copy;",
"&ordf;",
"&laquo;",
"&not;",
"&reg;",
"&macr;",
"&deg;",
"&plusmn;",
"&acute;",
"&micro;",
"&para;",
"&middot;",
"&raquo;",
"&frac14;",
"&frac12;",
"&frac34;",
"&iquest;",
"&Agrave;",
"&Aacute;",
"&Acirc;",
"&Atilde;",
"&Auml;",
"&Aring;",
"&AElig;",
"&Ccedil;",
"&Egrave;",
"&Eacute;",
"&Ecirc;",
"&Euml;",
"&Igrave;",
"&Iacute;",
"&Icirc;",
"&Iuml;",
"&ETH;",
"&Ntilde;",
"&Ograve;",
"&Oacute;",
"&Ocirc;",
"&Otilde;",
"&Ouml;",
"&times;",
"&Oslash;",
"&Ugrave;",
"&Uacute;",
"&Ucirc;",
"&Uuml;",
"&Yacute;",
"&THORN;",
"&szlig;",
"&agrave;",
"&aacute;",
"&acirc;",
"&atilde;",
"&auml;",
"&aring;",
"&aelig;",
"&ccedil;",
"&egrave;",
"&eacute;",
"&ecirc;",
"&euml;",
"&igrave;",
"&iacute;",
"&icirc;",
"&iuml;",
"&eth;",
"&ntilde;",
"&ograve;",
"&oacute;",
"&ocirc;",
"&otilde;",
"&ouml;",
"&divide;",
"&oslash;",
"&ugrave;",
"&uacute;",
"&ucirc;",
"&uuml;",
"&yacute;",
"&thorn;",
"&yuml;");


		$field = '<input type="hidden" name="we_dialog_args[char]" value="">';

		$table = '<table border="1" cellpadding="0" cellspacing="0" id="wechartb" style="border:black solid 1px;cursor:pointer;" width="340">
';

		for($i=0;$i<count($chars);$i++){

				if($i==0){
					$table .= '<tr>';
				}else if((($i % 16) == 0)  && ($i != 0)){
					$table .= "</tr><tr>";
				}
				$table .= '<td align="center" style="font-size:14px;border:black solid 1px;width:30px;height:25px;" class="defaultfont" title="'.htmlspecialchars($chars[$i]).'" onclick="fillField(\''.htmlspecialchars($chars[$i]).'\')">'.$chars[$i].'</td>';

				if($i == (count($chars)-1)){
					$table .= '</tr>';
				}
		}
		$table .= '</table>
';

		$script = '<script language="JavaScript" type="text/javascript">
	function fillField(ch){
		var table = document.getElementById("wechartb");
		var tds = table.getElementsByTagName("TD");
		for(var i=0;i<tds.length;i++){
			if(tds[i].title == ch){
				tds[i].style.backgroundColor="#AAD6FF";
			}else{
				tds[i].style.backgroundColor="";
			}
		}
		document.forms[0].elements["we_dialog_args[char]"].value = ch;
	}

</script>';

		return $script.$table.$field;

	}


##################################################################################################

}