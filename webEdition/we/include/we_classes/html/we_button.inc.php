<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Class we_button
 *
 * Provides functions for creating webEdition buttons.
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
$langDir = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"];
include_once($langDir."/css/css.inc.php");
include_once($langDir."/buttons/global.inc.php");
include_once($langDir."/buttons/buttons.inc.php");

if (is_dir($langDir."/buttons/modules")) {

	// Include language files of buttons used in modules
	$d = dir($langDir."/buttons/modules");
	while (false !== ($entry = $d->read())) {
		if ($entry[0] != "." && substr($entry,(-1 * strlen(".php"))) == ".php") {
			include_once($langDir."/buttons/modules/".$entry);
		}
	}
	$d->close();
}

define('WE_BUTTON_LEFT_WIDTH',5);
define('WE_BUTTON_RIGHT_WIDTH',7);
define('WE_BUTTON_HEIGHT',20);
define('WE_BUTTONTYPE_OK',1);
define('WE_BUTTONTYPE_CANCEL',2);
define('WE_BUTTONTYPE_NOTYPE',0);
define('WE_IMAGE_BUTTON_IDENTIFY','image:');
define('WE_FORM_BUTTON_IDENTIFY','form:');
define('WE_SUBMIT_BUTTON_IDENTIFY','submit:');
define('WE_JS_BUTTON_IDENTIFY','javascript:');

class we_button {

	 function we_button() {}



	/**
	* Gets the HTML Code for the button.
	* @return string
	* @param string $value
	* @param string $id
	* @param string $cmd
	* @param integer $width
	* @param string $title
	* @param boolean $disabled
	* @param string $margin
	* @param string $padding
	* @param string $key
	* @param string $float
	* @param string $display
	* @param boolean $important
	* @static
	*/
	function getButton($value, $id, $cmd='', $width=100, $title='',
						$disabled=false, $margin='', $padding='', $key='',$float='', $display='', $important=true, $isFormButton=false, $cssInline=false){
		return 	'<table cellpadding="0" cellspacing="0" border="0"'.($title ? ' title="'.htmlspecialchars($title).'"' : '').
					' id="'.$id.'" class="weBtn'.($disabled ? 'Disabled' : '').
					'"'.we_button::getInlineStyleByParam($width,'',$float,$margin,$padding,$display,'',$important).
					' onmouseout="weButton.out(this);" onmousedown="weButton.down(this);" onmouseup="if(weButton.up(this)){'.htmlspecialchars($cmd). ';}">'.
					'<tr><td class="weBtnLeft'.($disabled ? 'Disabled' : '').'"></td>'.
					'<td class="weBtnMiddle'.($disabled ? 'Disabled' : '').($width ? ('" style="width:'.
					($width - (WE_BUTTON_LEFT_WIDTH+WE_BUTTON_RIGHT_WIDTH)).'px;') : '').'" unselectable="on">'.$value.'</td>'.
					'<td class="weBtnRight'.($disabled ? 'Disabled' : '').'">'.($isFormButton ? '<input border="0" type="image" src="'.IMAGE_DIR.'pixel.gif">' : '').'</td>'.
				'</tr></table>';

	}

	/**
	* Gets the style attribut for using in the elements HTML.
	*
	* @return string
	* @param integer $width
	* @param integer $height
	* @param string $margin
	* @param string $padding
	* @param string $display
	* @param string $extrastyle
	* @param boolean $important
	*/
	function getInlineStyleByParam($width='', $height='', $float='',
											$margin='', $padding='', $display='',
											$extrastyle='', $important=true, $clear=''){

		$_imp = $important ? ' ! important' : '';

		$_style = ($width ? "width:$width".'px'.$_imp.';' : '').
					($height ? "height:$height".'px'.$_imp.';' : '').
					($float ? "float:$float$_imp;" :'').
					($clear ? "clear:$clear$_imp;" :'').
					($margin ? "margin:$margin$_imp;" : '').
					($display ? "display:$display$_imp;" : '').
					($padding ? "padding:$padding$_imp;" : '').$extrastyle;

		return $_style ? ' style="'.$_style.'"' : '';
	}
	/*************************************************************************
	 * FUNCTIONS
	 *************************************************************************/


	/**
	 * This function creates the JavaScript that switches the state of a button.
	 *
	 * @param      $standalone                             bool                (optional)
	 *
	 * @return     string
	 */

	function create_state_changer($standalone = true) {
		// Define start of JavaScript
		$_JavaScript_start = '
			<script language="JavaScript" type="text/javascript">
			<!--';

		// Define end of JavaScript
		$_JavaScript_end = '
			//-->
			</script>';

		// Initialize JavaScript functions variable
		$_JavaScript_functions = "";

		// Build the main preload function
		$_JavaScript_functions .= "
			/**
			 * This functions switches the state of a text(!!!) button.
			 *
			 * @param      element                                 string
			 * @param      button                                  string
			 * @param      state                                   string
			 * @param      type                                    bool                (optional)
			 *
			 * @return     button                                  bool
			 */

			function switch_button_state(element, button, state, type) {
				if (state == \"enabled\") {
					weButton.enable(element);
					return true;
				} else if (state == \"disabled\") {
					weButton.disable(element);
					return false;
				}

				return false;
			}";

		// Build string to be returned by the function
		if ($standalone) {
			$_JavaScript = $_JavaScript_start . $_JavaScript_functions . $_JavaScript_end;
		} else {
			$_JavaScript = $_JavaScript_functions;
		}

		return $_JavaScript;
	}

	/**
	 * This functions creates the button.
	 *
	 * @param      $name                                   string
	 * @param      $href                                   string
	 * @param      $alt                                    bool                (optional)
	 * @param      $width                                  int                 (optional)
	 * @param      $height                                 int                 (optional)
	 * @param      $on_click                               string              (optional)
	 * @param      $target                                 string              (optional)
	 * @param      $disabled                               bool                (optional)
	 * @param      $uniqid                                 bool                (optional)
	 * @param      $suffix                                 string              (optional)
	 *
	 * @return     string
	 */

	function create_button($name, $href, $alt = true, $width = 100, $height = 22, $on_click = "", $target = "", $disabled = false, $uniqid = true, $suffix = "", $opensDialog=false) {

		$cmd = "";
		// Initialize variable for Form:Submit behaviour
		$_add_form_submit_dummy = false;

		/**
		 * CHECK DEFAULTS
		 */

		// Check width
		if ($width == -1) {
			$width = 100;
		}

		// Check height
		if ($height == -1) {
			$height = 22;
		}

		/**
		 * DEFINE THE NAME OF THE BUTTON
		 */

		// Check if the button is a text button or an image button
		if (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) === false) { // Button is NOT an image
			$_button_name = ($uniqid ? uniqid($name . "_") : $name);
			$_button_name .= $suffix;
		} else { // Button is an image - create a unique name
			$_button_pure_name = substr($name, (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) + strlen(WE_IMAGE_BUTTON_IDENTIFY)));
			$_button_name = ($uniqid ? uniqid(substr($name, (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) + strlen(WE_IMAGE_BUTTON_IDENTIFY))) . "_") : substr($name, (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) + strlen(WE_IMAGE_BUTTON_IDENTIFY))) . $suffix);
		}
		/**
		 * CHECK IF THE LANGUAGE FILE DEFINES ANOTHER WIDTH FOR THE BUTTON
		 */

		// Check if the button will a text button or a image button
		if (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) === false) { // Button will NOT be an image
			if (($GLOBALS["l_button"][$name]["width"] != "") && ($width == 100)) {
				$width = $GLOBALS["l_button"][$name]["width"];
			}
		} else {
			//quickfix for image button width;
			//set width for image button if given width has not default value
			if($width==100) {
				$width = 0;
			}
		}

		// Check if the button will be used in a form or not
		if (strpos($href, WE_FORM_BUTTON_IDENTIFY) === false) { // Button will NOT be used in a form

			// Check if the buttons target will be a JavaScript
			if (strpos($href, WE_JS_BUTTON_IDENTIFY) === false) { // Buttons target will NOT be a JavaScript

				// Check if the link has to be opened in a different frame or in a new window
				if ($target) { // The link will be opened in a different frame or in a new window

					// Check if the link has to be opend in a frame or a window
					if ($target == "_blank") { // The link will be opened in a new window
						$_button_link = "window.open('" . $href . "', '" . $target . "');";
					} else { // The link will be opened in a different frame
						$_button_link = "target_frame = eval('parent.' + ". $target . ");target_frame.location.href='" . $href . "';";
					}
				} else { // The link will be opened in the current frame or window
					$_button_link = "window.location.href='" . $href . "';";
				}

				// Now assign the link string
				$cmd .= $_button_link;
			} else { // Buttons target will be a JavaScript

				// Get content of JavaScript
				$_javascript_content = substr($href, (strpos($href, WE_JS_BUTTON_IDENTIFY) + strlen(WE_JS_BUTTON_IDENTIFY)));

				// Render link
				$cmd .= $_javascript_content;
			}
		} else { // Button will be used in a form

			// Check if the button shall call the onSubmit event
			if (strpos($href, WE_SUBMIT_BUTTON_IDENTIFY) === false) { // Button shall not call the onSubmit event

				// Get name of form
				$_form_name = substr($href, (strpos($href, WE_FORM_BUTTON_IDENTIFY) + strlen(WE_FORM_BUTTON_IDENTIFY)));

				// Render link
				$cmd .= "document." . $_form_name . ".submit();return false;";
			} else { // Button must call the onSubmit event

				// Set variable for Form:Submit behaviour
				$_add_form_submit_dummy = true;

				// Get name of form
				$_form_name = substr($href, (strpos($href, WE_SUBMIT_BUTTON_IDENTIFY) + strlen(WE_SUBMIT_BUTTON_IDENTIFY)));

				// Render link
				$cmd .= "if (document." . $_form_name . ".onsubmit()) { document." . $_form_name . ".submit(); } return false;";
			}
		}

		$value = (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) === false) ? $GLOBALS["l_button"][$name]["value"].($opensDialog ? "..." : "") :
						'<img src="/webEdition/images/button/icons/'.str_replace("btn_","",$_button_pure_name).'.gif" class="weBtnImage" />';

		$title = "";
		// Check if the button will a text button or an image button
		if (strpos($name, WE_IMAGE_BUTTON_IDENTIFY) === false) { // Button will NOT be an image
			if (isset($GLOBALS["l_button"][$name]["alt"]) && ($GLOBALS["l_button"][$name]["alt"] != "") && $alt) {
				$title = $GLOBALS["l_button"][$name]["alt"];
			}
		} else {
			if (isset($GLOBALS["l_button"][$_button_pure_name]["alt"]) && ($GLOBALS["l_button"][$_button_pure_name]["alt"] != "") && $alt) {
				$title = $GLOBALS["l_button"][$_button_pure_name]["alt"];
			}
		}
		return we_button::getButton($value, $_button_name, $cmd, $width, $title, $disabled,'','','','','',true,(strpos($href, WE_FORM_BUTTON_IDENTIFY) !== false));

	}

	/**
	 * This function creates a table with a bunch of buttons.
	 *
	 * @param      $buttons                                array
	 * @param      $gap                                    int                 (optional)
	 * @param      $attribs                                array               (optional)
	 *
	 * @see        create_button()
	 * @see        we_htmlTable::we_htmlTable()
	 * @see        we_htmlTable::setCol()
	 * @see        we_htmlTable::getHtmlCode()
	 *
	 * @return     string
	 */

	function create_button_table($buttons, $gap = 10, $attribs = "") {
		// Get number of buttons
		$_count_button = count($buttons);

		// Get number of columns to create
		$_cols_to_create = ($_count_button > 1) ? (($_count_button * 2) - 1) : $_count_button;

		// Create array for table attributes
		$attr = array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0");

		// Check for attribute parameters
		if ($attribs && is_array($attribs)) {
			foreach($attribs as $k=>$v){
				$attr[$k] = $v;
			}
		}

		// Create table
		$_button_table = new we_htmlTable($attr, 1, $_cols_to_create);

		// Build cols for every button
		for ($i = 0; $i < $_count_button; $i++) {
			$_button_table->setCol(0, ($i * 2), array("class"=>"weEditmodeStyle"), $buttons[$i]);

			// Check if we have to create a gap
			if (($i > 0) && ($i < $_count_button)) {
				$_button_table->setCol(0, (($i * 2) - 1), array("class"=>"weEditmodeStyle"), getPixel($gap, 1));
			}
		}

		// Get created HTML
		return $_button_table->getHtmlCode();
	}


	/**
	 * This function displays ok, no, cancel - buttons matching to the OS
	 * and places them at the right ($align) side
	 *
	 * For Mac OS         : NO, CANCEL, YES
	 * For Windows & Linux: OK, NO, CANVCEL
	 *
	 * @param      $yes_button                             string
	 * @param      $no_button                              string              (optional)
	 * @param      $cancel_button                          string              (optional)
	 * @param      $gap                                    int                 (optional)
	 * @param      $align                                  string              (optional)
	 * @param      $attribs                                array               (optional)
	 * @param	   $aligngap                               int                 (optional)
	 *
	 * @see        we_htmlTable::we_htmlTable()
	 * @see        we_htmlTable::setCol()
	 * @see        we_htmlTable::getHtmlCode()
	 *
	 * @return     string
	 */

	function position_yes_no_cancel($yes_button, $no_button = null, $cancel_button = null, $gap = 10, $align = "", $attribs = array(), $aligngap = 0) {
		//	Create default attributes for table
		$attr = array("border" => "0", "cellpadding" => "0", "cellspacing" => "0", "align" => $align);

		// Check for attribute parameters
		if ($attribs && is_array($attribs)) {
			foreach($attribs as $k=>$v) {
				$attr[$k] = $v;
			}
		}

		//	Create button array
		$_buttons = array();
		if($align=="") $attr["align"]="right";
		//	button order depends on OS
		if($GLOBALS['SYSTEM'] == "MAC"){
			$_order = array("no_button", "cancel_button", "yes_button");
		} else {
			$_order = array("yes_button", "no_button", "cancel_button");
		}

		//	Existing buttons are added to array
		for ($_i = 0; $_i < sizeof($_order); $_i++) {
			if (isset($$_order[$_i]) && $$_order[$_i] != "") {
				array_push($_buttons, $$_order[$_i]);
			}
		}

		$_cols = (sizeof($_buttons) * 2) - 1;

		//	Create_table
		$_button_table = new we_htmlTable($attr, 1, ((($aligngap > 0) && ($attr["align"] == "left")) ? $_cols + 1 : $_cols));

		//	Extra gap at left side?
		if (($aligngap > 0) && ($attr["align"] == "left")) {
			$_button_table->addCol(1);
			$_button_table->setCol(0, 0,  array("class"=>"weEditmodeStyle"), getPixel($aligngap, 1));
		}

		//	Write buttons
		for ($i = 0, $j = 0; $i < ((($aligngap > 0) && ($attr["align"] == "left")) ? $_cols + 1 : $_cols); $i++) {
			if ($i % 2 == 0){ // Set button
				$_button_table->setCol(0, ((($aligngap > 0) && ($attr["align"] == "left")) ? $i + 1 : $i), array("class"=>"weEditmodeStyle"), $_buttons[$j++]);
			} else { // Set gap
				$_button_table->setCol(0, ((($aligngap > 0) && ($attr["align"] == "left")) ? $i + 1 : $i), array("class"=>"weEditmodeStyle"), getPixel($gap, 1));
			}
		}

		//	Extra gap at left or right side?
		if (($aligngap > 0) && ($attr["align"] == "right")) {
			$_button_table->addCol(1);
			$_button_table->setCol(0, $_cols, array("class"=>"weEditmodeStyle"), getPixel($aligngap, 1));
		}

		// Return created HTML
		return $_button_table->getHtmlCode();
	}
}