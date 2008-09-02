<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

	class weOrderContainer {
		
		// DEBUG
		var $debug = false;
		
		// private Target Frame
		var $targetFrame = "";
		
		// private containerId
		var $containerId = "";
		
		// private containerType
		var $containerType = "";
		
		
		function weOrderContainer($targetFrame, $id, $type = "div") {
			$this->__construct($targetFrame, $id, $type);
		} // end: PHP4 Constructor
		
		
		function __construct($targetFrame, $id, $type = "div") {
			$this->targetFrame = $targetFrame;
			$this->containerId = $id;
			$this->containerType = $type;
		} // end: PHP5 Constructor
		
		
		function __destruct() {
			
		} // end: Destructor
		
		
		function getJS($jsPath) {
			
			$src =		'';
			if(!defined("weOrderContainer_JS_loaded")) {
				$src =		'<script src="'.$jsPath.'/weOrderContainer.js?t='.time().'" type="text/javascript"></script>'."\n";
				define("weOrderContainer_JS_loaded", true);
			}
			$src .=		'<script type="text/javascript">'."\n"
					.	'<!--'."\n"
					.	'var '.$this->containerId.' = new weOrderContainer("'.$this->containerId.'");'."\n"
					.	'-->'."\n"
					.	'</script>'."\n";
					
			return $src;

		} // end: getJs
		
		
		function getContainer($attribs = array()) {
			
			if($this->debug) {
				$style = ' style="display: block; border: 1px #ff0000 solid;"';
			} else {
				$style = '';
			}
			
			$attrib = "";
			foreach ($attribs as $name => $value) {
				$attrib .= " ".$name."=\"".$value."\"";
			}
			
			$src =		'<'.$this->containerType.' id="'.$this->containerId.'"'.$style.$attrib.'>'
					.	'</'.$this->containerType.'>';
					
			return $src;
			
		} // end: getContainer
		
		
		function getCmd($mode, $uniqueid = false, $afterid = false) {
			
			$prefix = $this->targetFrame.".".$this->containerId;
			
			if($afterid) {
				$afterid = "'".$afterid."'";
			} else {
				$afterid = "null";
			}
			
			switch(strtolower($mode)) {
				case 'add':
					$cmd = $prefix.".add(document, '".$uniqueid."', $afterid);";
					break;
				case 'reload':
					$cmd = $prefix.".reload(document, '".$uniqueid."');";
					break;
				case 'delete':
				case 'del':
					$cmd = $prefix.".del('".$uniqueid."');";
					break;
				case 'moveup':
				case 'up':
					$cmd = $prefix.".up('".$uniqueid."');";
					break;
				case 'movedown':
				case 'down':
					$cmd = $prefix.".down('".$uniqueid."');";
					break;
				default:
					$cmd = "";
					break;
			}
			
			return $cmd;
			
		} // end: getCmd
		
		
		function getResponse($mode, $uniqueid, $string = "", $afterid = false) {
			
			$cmd = $this->getCmd($mode, $uniqueid, $afterid);
			if($cmd == "") {
				return "";
			}
			
			if($this->debug) {
				$style = ' style="display: block; width: 90%; height: 90%; overflow: auto; border: 1px #ff0000 solid; font-family: verdana, arial; font-size: 11px; color: #000000; padding: 5px;"';
			} else {
				$style = ' style="display: none;"';
			}
			
			$src = "";
			if($string != "" || $this->debug) {
				$src .=		'<'.$this->containerType.' id="'.$this->containerId.'"'.$style.'>'
						.	$string
						.	'</'.$this->containerType.'>'."\n";
			}
			
			$src .=		'<script type="text/javascript">'."\n"
					.	'<!--'."\n"
					.	$cmd."\n"
					.	'-->'."\n"
					.	'</script>';
					
			$src	.=	$this->getDisableButtonJS();
			return $src;
			
		} // end: getResponse
		
		
		function getDisableButtonJS() {
			
			$src	=	'<script type="text/javascript">'."\n"
					.	'<!--'."\n"
					.	'for(i = 0; i < '.$this->targetFrame.'.'.$this->containerId.'.position.length; i++) {'."\n"
					.	'	id = '.$this->targetFrame.'.'.$this->containerId.'.position[i];'."\n"
					.	'	id = id.replace(/entry_/, "");'."\n"
					.	'	'.$this->targetFrame.'.weButton.enable("btn_direction_up_" + id);'."\n"
					.	'	'.$this->targetFrame.'.weButton.enable("btn_direction_down_" + id);'."\n"
					.	'	if(i == 0) {'."\n"
					.	'		'.$this->targetFrame.'.weButton.disable("btn_direction_up_" + id);'."\n"
					.	'	}'."\n"
					.	'	if(i+1 == '.$this->targetFrame.'.'.$this->containerId.'.position.length) {'."\n"
					.	'		'.$this->targetFrame.'.weButton.disable("btn_direction_down_" + id);'."\n"
					.	'	}'."\n"
					.	'}'."\n"
					.	'-->'."\n"
					.	'</script>';
					
			return $src;
			
		}
		
	
	}

?>