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

// this file is not needed any more, was from normal scheduler

if(defined("SCHEDULE_TABLE")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/schedule.inc.php");
}
function we_schedule_props(){
	global $DB_WE,$l_schedule;
	$id = $GLOBALS["we_doc"]->ID;
	
	$fromOk = $GLOBALS["we_doc"]->FromOk;
	$toOk = $GLOBALS["we_doc"]->ToOk;

	$from = $fromOk ? $GLOBALS["we_doc"]->From : time();
	$to = $toOk ? $GLOBALS["we_doc"]->To : time();
	
	$n = $GLOBALS["we_doc"]->Name;
	
	$content = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input type="checkbox" name="we_from" value="1"'.($fromOk ? " checked" : "").' onClick="_EditorFrame.setEditorIsHot(true);this.form.elements[\'we_'.$n.'_FromOk\'].value=((this.checked) ? 1 : 0);"><input type="hidden" name="we_'.$n.'_FromOk" value="'.$fromOk.'"></td>
				<td class="defaultfont">&nbsp;'.$l_schedule["from"].'</td>
			</tr></table></td>
		<td></td>
		<td><table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input type="checkbox" name="we_to" value="1"'.($toOk ? " checked" : "").' onClick="_EditorFrame.setEditorIsHot(true);this.form.elements[\'we_'.$n.'_ToOk\'].value=((this.checked) ? 1 : 0);"><input type="hidden" name="we_'.$n.'_ToOk" value="'.$toOk.'"></td>
				<td class="defaultfont">&nbsp;'.$l_schedule["to"].'</td>
			</tr></table></td>
	</tr>
	<tr>
		<td></td>
		<td>'.getPixel(20,2).'</td>
		<td></td>
	</tr>
	<tr>
		<td>'.getDateInput2("we_".$n."_From%s",$from,true).'</td>
		<td></td>
		<td>'.getDateInput2("we_".$n."_To%s",$to,true).'</td>
	</tr>
</table>
';
	return $content;
}

?>