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


class htmlBox {
	var $width = 400;
	var $height = 50;
	var $title ="htmlBox (c) 2000 by Holger Meyer";
	var $leftMargin = 10;
	var $topMargin = 10;
	var $rightMargin = 10;
	var $bottomMargin = 10;
	var $content = "Test";
	var $borderColor = "#666666";
	var $textColor = "#000000";
	var $titleColor = "#ffffff";
	var $bgColor = "#ffffff";
	var $pixelGif = "pixel.gif";
	var $borderWidth = 1;
	var $titleMargin = 10;
	var $titleHeight = 20;
	var $titleAlign = "center";
	var $titleClass = "htmlBoxTitle";
	var $contentClass = "defaultfont";
	
	function getCode(){
		$html = '<table border="0" cellpadding="0" cellspacing="0" width="'.$this->width.'">
	<tr>
		<td colspan="'.$this->colspan().'"'.$this->bColor().' align="'.$this->titleAlign.'"><table cellpadding="0" cellspacing="0" border="0"><tr><td>'.$this->tMargin().'</td><td class="'.$this->titleClass.'">'.$this->title.'</td></tr></table></td>
	</tr>
'.$this->mTop().'
	<tr>
		<td'.$this->bColor().'>'.$this->cHeight().'</td>
'.($this->leftMargin ? "<td></td>" : "").'
		<td align="left" valign="top" class="'.$this->contentClass.'">'.$this->content.'</td>
'.($this->rightMargin ? "<td></td>" : "").'
		<td'.$this->bColor().'>'.$this->cHeight().'</td>
	</tr>
'.$this->mBottom().'
	<tr>
		<td'.$this->bColor().'><img'.$this->bHeight().$this->bWidth().' src="'.$this->pixelGif.'"></td>
'.($this->leftMargin ? '		<td'.$this->bColor().'><img'.$this->bHeight().' width="'.$this->leftMargin.'" src="'.$this->pixelGif.'"></td>
' : "").'<td'.$this->bColor().'><img'.$this->bHeight().' width="'.$this->cWidth().'" src="'.$this->pixelGif.'"></td>
'.($this->rightMargin ? '		<td'.$this->bColor().'><img'.$this->bHeight().' width="'.$this->rightMargin.'" src="'.$this->pixelGif.'"></td>
' : "").'<td'.$this->bColor().'><img'.$this->bHeight().$this->bWidth().' src="'.$this->pixelGif.'"></td>
	</tr>
</table>
';
	return $html;
	}
	function colspan(){
		$cs = 3;
		if($this->leftMargin) $cs++;
		if($this->rightMargin) $cs++;
		return $cs;
	}
	function bColor(){
		return $this->borderColor ? ' bgcolor="'.$this->borderColor.'"' : '';
	}
	function bWidth(){
		return $this->borderWidth ? ' width="'.$this->borderWidth.'"' : ' width="1"';
	}
	function bHeight(){
		return $this->borderWidth ? ' height="'.$this->borderWidth.'"' : ' height="1"';
	}
	function tMargin(){
		return $this->titleMargin ? '<img height="'.$this->titleHeight.'" width="'.$this->titleMargin.'" src="'.$this->pixelGif.'">' : '<img height="'.$this->titleHeight.'" width="1">';
	}
	function cHeight(){
		return '<img height="'.($this->height ? $this->height : "1").'"'.$this->bWidth().' src="'.$this->pixelGif.'">';
	}
	function cWidth(){
		return $this->width - ($this->leftMargin + $this->rightMargin + $this->borderWidth*2);
	}
	function mBottom(){
		return $this->bottomMargin ? '	<tr>
		<td'.$this->bColor().'><img height="'.$this->bottomMargin.'"'.$this->bWidth().' src="'.$this->pixelGif.'"></td>
		'.($this->leftMargin ? "<td></td>" : "").'
		<td></td>
		'.($this->rightMargin ? "<td></td>" : "").'
		<td'.$this->bColor().'><img height="10"'.$this->bWidth().' src="'.$this->pixelGif.'"></td>
	</tr>
' : "";
	}
	function mTop(){
		return $this->topMargin ? '	<tr>
		<td'.$this->bColor().'><img height="'.$this->topMargin.'"'.$this->bWidth().' src="'.$this->pixelGif.'"></td>
		'.($this->leftMargin ? "<td></td>" : "").'
		<td></td>
		'.($this->rightMargin ? "<td></td>" : "").'
		<td'.$this->bColor().'><img height="10"'.$this->bWidth().' src="'.$this->pixelGif.'"></td>
	</tr>
' : "";
	}
}
