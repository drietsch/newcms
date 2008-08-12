<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class liveUpdateTemplates {

	/**
	 * returns standard html container for output
	 *
	 * @param string $headline
	 * @param string $content
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	function getContainer($headline, $content) {


		return "
		<div id=\"leWizardContent\" class=\"defaultfont\">
			<h1>{$headline}</h1>
			<p>
				{$content}
			</p>
			{$buttonDiv}
		</div>";

	}

	/**
	 * returns header of template
	 *
	 * @return string
	 */
	function getHtmlHead() {

		return "";
	}

	/**
	 * Returns a html page as response
	 *
	 * @param string $headline
	 * @param string $content
	 * @param string $header
	 * @param string $buttons
	 * @param integer $contentWidth
	 * @param integer $contentHeight
	 * @return string
	 */
	function getHtml($headline, $content, $header='', $append = false) {

		if($appendContent) {
			$PushJs = 'parent.leWizardContent.appendElement(document.getElementById("leWizardContent"));';

		} else {
			$PushJs = 'parent.leWizardContent.replaceElement(document.getElementById("leWizardContent"));';

		}

		return '<html>
	<head>
	' . liveUpdateTemplates::getHtmlHead() . '
	' . $header . '
	</head>
	<body>
	' . liveUpdateTemplates::getContainer($headline, $content) . '
	<script type="text/javascript">
	' . $PushJs . '
	</script>
	</body>
</html>';
	}
}


?>