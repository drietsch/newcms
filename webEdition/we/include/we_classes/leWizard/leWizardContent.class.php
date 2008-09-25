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


class leWizardContent {

	var $id = "";
	var $headlineId = "";
	var $descriptionId = "";

	function __construct($id = "leWizardContent", $headlineId = "leWizardHeadline", $descriptionId = "leWizardDescription") {

		$this->leWizardContent($id, $headlineId, $descriptionId);

	}


	function leWizardContent($id = "leWizardContent", $headlineId = "leWizardHeadline", $descriptionId = "leWizardDescription") {

		$this->id = $id;
		$this->headlineId = $headlineId;
		$this->descriptionId = $descriptionId;

	}

	function getCSS() {


		if(eregi("X11",$_SERVER["HTTP_USER_AGENT"])) {

			$System = "X11";
		} else if(eregi("Win",$_SERVER["HTTP_USER_AGENT"])) {
			$System = "WIN";

		} else if(eregi("Mac",$_SERVER["HTTP_USER_AGENT"])) {
			$System = "MAC";

		} else {
			$System = "UNKNOWN";

		}

		$FontSizeH1 = ($System == "MAC") ? "11px" : (($System == "X11") ? "13px" : "12px");
		$LineHeightH1 = ($System == "MAC") ? "17px" : (($System == "X11") ? "19px" : "18px");

		$FontSize = ($System == "MAC") ? "9px" : (($System == "X11") ? "11px" : "10px");
		$LineHeight = ($System == "MAC") ? "15px" : (($System == "X11") ? "17px" : "16px");

		$IMAGE_DIR = IMAGE_DIR;

		$CSS = <<<EOF
<style type="text/css">
#{$this->id} h1 {
	font-size			: {$FontSizeH1};
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	font-weight			: bold;
	line-height			: {$LineHeightH1};
	margin-top			: 4px;
}

#{$this->id} h1.error {
	font-size			: {$FontSize};
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	color				: #ff0000;
	font-weight			: normal;
	line-height			: {$LineHeight};
	margin-top			: 4px;
}

#{$this->id} label, p {
	font-size			: {$FontSize};
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	line-height			: {$LineHeight};
	margin-top			: 0px;
}

#{$this->id} p.message {
	font-size			: {$FontSize};
	font-family			: Verdana, Arial, Helvetica, sans-serif;
	line-height			: {$LineHeight};
	color				: #ff0000;
	margin-top			: 0px;
}
</style>

EOF;

		return $CSS;

	}


	function getJSCode() {

		$JS = <<<EOF
<script type="text/javascript">
function leWizardContent() {}

leWizardContent.appendElement = function(element) {
	var messageLog = document.getElementById("{$this->id}");
	var messageLogHeight = document.getElementById("{$this->id}");
	messageLog.innerHTML += "\\n" + element.innerHTML;
	messageLogHeight.scrollTop = 100000;

}


leWizardContent.appendText = function(text) {
	var messageLog = document.getElementById("{$this->id}");
	var messageLogHeight = document.getElementById("{$this->id}");
	messageLog.innerHTML += "\\n" + text + "\\n";
	messageLogHeight.scrollTop = 100000;

}


leWizardContent.replaceElement = function(element) {
	var messageLog = document.getElementById("{$this->id}");
	messageLog.innerHTML = "\\n" + element.innerHTML;
}


leWizardContent.replaceText = function(text) {
	var messageLog = document.getElementById("{$this->id}");
	var messageLogHeight = document.getElementById("{$this->id}");
	messageLog.innerHTML = text + "\\n";
	messageLogHeight.scrollTop = 100000;
}


leWizardContent.replaceDescription = function(text) {
	var messageLog = document.getElementById("{$this->descriptionId}");
	messageLog.innerHTML = text + "\\n";
}


leWizardContent.replaceHeadline = function(text) {
	var messageLog = document.getElementById("{$this->headlineId}");
	messageLog.innerHTML = text + "\\n";
}


leWizardContent.scrollDown = function() {
	document.getElementById("{$this->id}").scrollTop = 100000;

}
</script>

EOF;

		return $JS;

	}


	function get() {

		$Html = <<<EOF
<div id="{$this->id}">

</div>
EOF;

		return $Html;

	}


	function getDescription() {

		$Html = <<<EOF
<div id="{$this->descriptionId}">

</div>
EOF;

		return $Html;

	}
}


