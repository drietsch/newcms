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

protect();

?><html>

<head>
	<title>webEdition (c) living-e AG</title>
	<meta http-equiv="expires" content="0">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	
	<link href="/webEdition/css/global.php?WE_LANGUAGE=<?php echo $GLOBALS["WE_LANGUAGE"]; ?>" rel="styleSheet" type="text/css">

</head>
<body class="weSidebarBody">

<table>
<?php

	function showSidebarText(&$textArray) {
		for($i = 0; $i < sizeof($textArray); $i++) {
			$text = &$textArray[$i];
			
			$link = "%s";
			if(isset($text['link']) && $text['link'] != "") {
				if(eregi("^javascript:", $text['link'])) {
					$link = "<a href=\"" . $text['link'] . "\">%s</a>";
					
				} else {
					$link = "<a href=\"" . $text['link'] . "\" target=\"_blank\">%s</a>";
					
				}
				
			}
			
			$icon = "";
			if(isset($text['icon']) && $text['icon'] != "") {
				$icon = sprintf($link, "<img src=\"/webEdition/sidebar/img/" . $text['icon'] . "\" width=\"42\" height=\"42\" border=\"0\" />");
				
			}
			
			$headline = "";
			if(isset($text['headline']) && $text['headline'] != "") {
				$headline = sprintf($link, $text['headline']);
				
			}
?>
	<tr>
		<td colspan="2"><img src="/webEdition/images/pixel.gif" width="1" height="5" /></td>
	</tr>
	<tr>
<?php
		if($icon == "") {
?>
		<td class="defaultfont" valign="top" colspan="2">
			<strong><?php echo $headline; ?></strong><br />
			<img src="/webEdition/images/pixel.gif" width="1" height="4" /><br />
			<?php echo $text['text']; ?>
		</td>
<?php
		} else {
?>
		<td class="defaultfont" valign="top" width="52"><?php echo $icon; ?></td>
		<td class="defaultfont" valign="top">
			<strong><?php echo $headline; ?></strong><br />
			<img src="/webEdition/images/pixel.gif" width="1" height="4" /><br />
			<?php echo $text['text']; ?>
		</td>
<?php
		}
?>
	</tr>
<tr>
<?php
		}
		
	}
	
	showSidebarText($GLOBALS['l_sidebar']['default']);
	
	if(we_hasPerm("ADMINISTRATOR")) {
		showSidebarText($GLOBALS['l_sidebar']['admin']);
		
	}
	
?>
</table>

</body>
</html>