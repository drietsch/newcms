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


class leWizardProgress {

	var $id = "";

	var $width = 0;

	function __construct($id = "leWizardProgress", $width = 500) {

		$this->leWizardProgress($id, $width);

	}


	function leWizardProgress($id = "leWizardProgress", $width = 500) {

		$this->id = $id;
		$this->width = $width;

	}


	function getCSS() {

		$BackgroundWidth = $this->width - 40;

		$IMAGE_DIR = IMAGE_DIR;

		$CSS = <<<EOF
<style type="text/css">
#{$this->id}Background {
	width				: {$BackgroundWidth};
	background			: url("{$IMAGE_DIR}leWizardProgress/background.gif");
	background-repeat	: repeat-x;
}

#{$this->id}Bar {
	margin-top			: 2px;
	background			: url("{$IMAGE_DIR}leWizardProgress/bar.gif");
	background-repeat	: repeat-x;
	width				: 0px;
	overflow			: hidden;
}

#{$this->id}Percent {
	width				: 40px;
	text-align			: right;
	font-size			: 9px;
	font-family			: verdana, arial, helvetica, sans-serif;
	font-weight			: bold;
}
</style>

EOF;

		return $CSS;

	}


	function getJSCode() {

		$JS = <<<EOF
<script type="text/javascript">
function leWizardProgress() {}


leWizardProgress.hide = function() {
	if(document.getElementById("{$this->id}") != undefined) {
		weButton.disable("function_reload");
		weButton.hide("function_reload");
		document.getElementById("{$this->id}").style.display = "none";
	}

}


leWizardProgress.show = function() {
	if(document.getElementById("{$this->id}") != undefined) {
		document.getElementById("{$this->id}").style.display = "block";
		weButton.enable("function_reload");
		weButton.show("function_reload");
	}

}


leWizardProgress.set = function(width) {
	if(document.getElementById("{$this->id}") != undefined) {
		var progressPercent = document.getElementById("{$this->id}Percent");
		var progressBar = document.getElementById("{$this->id}Bar");

		if (progressPercent) {
			progressPercent.innerHTML = width + "%";

		}

		if (progressBar) {
			progressBar.style.width = width + "%";

		}

	}

}


leWizardProgress.enable = function(status) {
	if(document.getElementById("{$this->id}") != undefined) {
		if (status) {
			leWizardProgress.show();

		} else {
			leWizardProgress.hide();

		}

	}

}
</script>

EOF;

		return $JS;

	}


	function get() {

		return '<div id="' . $this->id . '"><table align="left" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td id="' . $this->id . 'Background">
		<div id="' . $this->id . 'Bar">&nbsp;</div>
	</td>
	<td valign="top" align="right" id="' . $this->id . 'Percent">0%</td>
</tr>
</table></div>';

	}

}

?>