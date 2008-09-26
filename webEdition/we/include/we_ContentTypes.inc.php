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

$GLOBALS["WE_CONTENT_TYPES"] = array();

// Content Type for Images


$GLOBALS["WE_CONTENT_TYPES"]["image/*"] = array(
	
		"Extension" => ".gif,.jpg,.jpeg,.png", 
		"Permission" => 'NEW_GRAFIK', 
		"DefaultCode" => "", 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "image.gif"
);

$GLOBALS["WE_CONTENT_TYPES"]["text/html"] = array(
	
		"Extension" => ".html,.htm,.shtm,.shtml,.stm,.php,.jsp,.asp,.pl,.cgi,.xml,.xsl", 
		"Permission" => 'NEW_HTML', 
		"DefaultCode" => '<html>
        <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; ' . (isset(
				$GLOBALS["_language"]["charset"]) ? $GLOBALS["_language"]["charset"] : "") . '">
        </head>
        <body>
        </body>
</html>', 
		"IsWebEditionFile" => "1", 
		"IsRealFile" => "1", 
		"Icon" => "html.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["text/webedition"] = array(
	
		"Extension" => ".html,.htm,.shtm,.shtml,.stm,.php,.jsp,.asp,.pl,.cgi,.xml", 
		"Permission" => 'NEW_WEBEDITIONSITE', 
		"DefaultCode" => '', 
		"IsWebEditionFile" => "1", 
		"IsRealFile" => "0", 
		"Icon" => "we_dokument.gif"
);

$GLOBALS["WE_CONTENT_TYPES"]["text/weTmpl"] = array(
	
		"Extension" => ".tmpl", 
		"Permission" => 'NEW_TEMPLATE', 
		"DefaultCode" => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <we:title></we:title>
  <we:description/>
  <we:keywords/>
  <we:charset defined="ISO-8859-1">ISO-8859-1</we:charset>
</head>
<body>
  <table cellpadding="0" cellspacing="0" border="0" width="400">
    <tr>
      <td>
        <p>
          <font face="verdana" size="2"><b><we:input type="date" name="Date" format="d.m.Y"/></b></font>
        </p>
        <p>
          <font face="verdana" size="2"><b><we:input type="text" name="Headline" size="60"/></b></font>
        </p>
        <p>
          <we:ifNotEmpty match="Image">
            <we:img name="Image"/>
            <we:ifEditmode>
              <br><br>
            </we:ifEditmode>
          </we:ifNotEmpty>
          <we:textarea name="Content" width="250" height="100" autobr="true" wysiwyg="true"/>
        </p>
      </td>
    </tr>
  </table>
</body>
</html>', 
		"IsRealFile" => "0", 
		"Icon" => "we_template.gif"
);

$GLOBALS["WE_CONTENT_TYPES"]["text/js"] = array(
	
		"Extension" => ".js", 
		"Permission" => 'NEW_JS', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "javascript.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["text/css"] = array(
	
		"Extension" => ".css", 
		"Permission" => 'NEW_CSS', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "css.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["text/plain"] = array(
	
		"Extension" => ".txt", 
		"Permission" => 'NEW_TEXT', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "link.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["folder"] = array(
	
		"Extension" => "", 
		"Permission" => '', 
		"DefaultCode" => '', 
		"IsRealFile" => "0", 
		"IsWebEditionFile" => "0", 
		"Icon" => "folder.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["application/x-shockwave-flash"] = array(
	
		"Extension" => ".swf", 
		"Permission" => 'NEW_FLASH', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "flashmovie.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["video/quicktime"] = array(
	
		"Extension" => ".mov,.moov,.qt", 
		"Permission" => 'NEW_QUICKTIME', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "quicktime.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["application/*"] = array(
	
		"Extension" => ".doc,.xls,.ppt,.zip,.sit,.bin,.hqx,.exe", 
		"Permission" => 'NEW_SONSTIGE', 
		"DefaultCode" => '', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "link.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["text/xml"] = array(
	
		"Extension" => ".xml", 
		"Permission" => 'NEW_TEXT', 
		"DefaultCode" => '<?xml version="1.0" encoding="ISO-8859-1" ?>', 
		"IsRealFile" => "1", 
		"IsWebEditionFile" => "1", 
		"Icon" => "link.gif"
);

$GLOBALS["WE_CONTENT_TYPES"]["object"] = array(
	
		"Extension" => "", 
		"Permission" => '', 
		"DefaultCode" => '', 
		"IsRealFile" => "0", 
		"IsWebEditionFile" => "0", 
		"Icon" => "object.gif"
);
$GLOBALS["WE_CONTENT_TYPES"]["objectFile"] = array(
	
		"Extension" => "", 
		"Permission" => '', 
		"DefaultCode" => '', 
		"IsRealFile" => "0", 
		"IsWebEditionFile" => "0", 
		"Icon" => "objectFile.gif"
);
?>