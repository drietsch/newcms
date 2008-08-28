<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * LiveUpdateTemplates is a helper function taking care of the view of the 
 * update process. The functions here are only called from templates!
 *
 */
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
	function getContainer($headline, $content, $buttons='', $width=550, $height=400) {
		
		$buttonDiv = '';
		
		$headlineHeight = 30;
		$contentHeight = $height - $headlineHeight;
		
		$gapHeight = 15;
		$buttonHeight = 20;
		
		if ($buttons) {
			
			$buttonDiv = "
			<div style=\"height: $gapHeight; background: none\"></div>
			<div id=\"buttonDiv\" style=\"height: $buttonHeight\">
				$buttons
			</div>";
			
			$contentHeight -= $buttonHeight - $gapHeight;
		}
		
		return "
		<div id=\"contentDiv\" class=\"defaultfont\" style=\"width: $width; height: $height;\">
			<div id=\"contentHeadlineDiv\" style=\"height: " . ($headlineHeight) . "\">
			<b>$headline<hr /></b>
			</div>
			<div id=\"contentTextDiv\" class=\"defaultfont\" style=\"height: " . ($contentHeight). "\">
				$content
			</div>
			$buttonDiv
		</div>";
	}
	
	/**
	 * returns header of template
	 *
	 * @return string
	 */
	function getHtmlHead() {
		
		return
			STYLESHEET . "\n" .
			LIVEUPDATE_CSS;
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
	function getHtml($headline, $content, $header='', $buttons='', $contentWidth=550, $contentHeight=400) {
		
		return '<html>
<head>
	' . liveUpdateTemplates::getHtmlHead() . '
	' . $header . '
</head>
<body>
	' . liveUpdateTemplates::getContainer($headline, $content, $buttons, $contentWidth, $contentHeight) . '
</body>
</html>
';
	}
}


?>