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


/**
 * Class we_dynamicControls
 *
 * Provides functions for creating layers that can hide and unhide.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/dynamic_controls.inc.php");

class we_dynamicControls {

	/*************************************************************************
	 * VARIABLES
	 *************************************************************************/

	var $_arrow_image_closed;
	var $_arrow_image_opened;

	var $_arrow_hint_closed;
	var $_arrow_hint_opened;

	/*************************************************************************
	 * CONSTRUCTOR
	 *************************************************************************/

	/**
	 * Constructor of class.
	 *
	 * @return     we_dynamicControls
	 */

	function we_dynamicControls() {
		// Get global variables
		global $l_dynamic_controls;

		// Set path to images for the groups arrows
		$this->_arrow_image_closed = IMAGE_DIR . "modules/users/arrow_open.gif";
		$this->_arrow_image_opened = IMAGE_DIR . "modules/users/arrow_close.gif";

		// Set hint text for the groups arrows
		$this->_arrow_hint_closed = $l_dynamic_controls["expand_group"];
		$this->_arrow_hint_opened = $l_dynamic_controls["fold_group"];
	}

	/*************************************************************************
	 * FUNCTIONS
	 *************************************************************************/

	/**
	 * This function creates the JavaScript needed to fold or unfold groups
	 *
	 * @param      $groups                                 array
	 * @param      $filter                                 array
	 * @param      $use_with_user_module                   bool
	 *
	 * @see        fold_checkbox_groups()
	 *
	 * @return     string
	 */

	function js_fold_checkbox_groups($groups, $filter, $use_with_user_module) {
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


		// Build regular JavaScript functions
		$_JavaScript_functions .= '
				/**
				 * This function opens or closes one group
				 *
				 * @param      image_name                              string
				 * @param      display_style                           string
				 *
				 * @see        toggle()
				 * @see        toggle_all()
				 *
				 * @return     void
				 */

				function toggle_arrow(image_name, display_style) {
					// Check if the browser supports changing properties of images
					if (document.images) {
						// Check state of arrow
						if (display_style == "closed") {
							// Group is folded
							document.images[image_name].src = "' . $this->_arrow_image_closed . '";
							document.images[image_name].alt = "' . $this->_arrow_hint_closed . '";
						} else {
							// Group is expanded
							document.images[image_name].src = "' . $this->_arrow_image_opened . '";
							document.images[image_name].alt = "' . $this->_arrow_hint_opened . '";
						}
					}
				}';

		// Initialize string representing the array of all groups
		$_groups_array = "";

		// Initialize iterative counter
		$i = 0;

		// Build array of all groups
		foreach ($groups as $_groups_key=>$_groups_value) {
			// Filter out groups not to be shown
			$_count_filters = count($filter);
			$_show_group = true;

			// Check, if current group is in groups not to be shown
			for ($count = 0; $count < $_count_filters; $count++) {
				if(isset($filter[$count])) {
					if ($_groups_key == $filter[$count]) {
						$_show_group = false;
					}
				}
			}

			// Now build string representing the array of all groups if this group is visible
			if ($_show_group) {
				$_groups_array .= "_all_groups[" . $i . "] = \"" . $_groups_key . "\";\n";

			// Increase counter
			$i++;
			}
		}

		// Set counter for next "for" loop
		$i--;

		// Continue building JavaScript functions
		$_JavaScript_functions .= '
				/**
				 * This function closes all groups
				 *
				 * @see        toggle()
				 * @see        toggle_arrow()
				 *
				 * @return     void
				 */

				function toggle_all() {
					// Define all groups
					_all_groups = new Array(2);

					' . $_groups_array . '

					// Hide all groups
					for (i = 0; i <= ' . $i . '; i++) {
						// Check if that group is open
						if (document.getElementById("group_" + _all_groups[i]).style.display == "block") {
							// Hide the group
							toggle(_all_groups[i], "close");
						}
					}
				}';

		$_JavaScript_functions .= '
				var opened_group = "";

				/**
				 * This function opens or closes one group
				 *
				 * @param      group_id                                string
				 * @param      display_style                           string
				 * @param      use_form                                bool
				 * @param      form_name                               string
				 * @param      form_group_name                         string
				 *
				 * @see        toggle_arrow()
				 * @see        toggle_all()
				 *
				 * @return     void
				 */

				function toggle(group_id, display_style, use_form, form_name, form_group_name) {
					// Check if to close all other groups
					if (display_style == "show_single") {
						// Remember old group state
						_old_display_style = document.getElementById("group_" + group_id).style.display;
						// Close all other groups an show only the requested one
						toggle_all();

						// Check, if we need to open the current group
						if (_old_display_style == "none"
							&& document.getElementById("group_" + group_id).style.display == "none") {
							// Show the group
							toggle(group_id, "open", use_form, form_name, form_group_name);
						} else {
							// Reset the arrow
							toggle_arrow("arrow_" + group_id, "closed");
						}
					} else {
						// Check if to hide or to unhide the group
						if (document.getElementById("group_" + group_id).style.display == "none"
							|| display_style == "open") {
							// Show the group
							document.getElementById("group_" + group_id).style.display = "block";

							// set the var to locate which group is opened
							opened_group = group_id;

							// Set value for arrow
							display_style = "opened";

							// Check if forms should be used
							if (use_form) {
								// Tell the form which group is open
								_document_form = eval(\'document.\' + form_name + \'.\' + form_group_name);
								_document_form.value = group_id;
							}
						} else {
							// Hide the group
							document.getElementById("group_" + group_id).style.display = "none";

							// Set value for arrow
							display_style = "closed";
						}

						// Change the arrow
						toggle_arrow("arrow_" + group_id, display_style);
					}
				}';

		// Build string to be returned by the function
		$_JavaScript = $_JavaScript_start . $_JavaScript_functions . $_JavaScript_end;

		return $_JavaScript;
	}

	/**
	 * This function creates a menu with different groups that contain checkboxes.
	 * These groups can be folded and unfolded.
	 *
	 * @param      $groups                                 array
	 * @param      $main_titles                            array
	 * @param      $titles                                 array
	 * @param      $item_names                             array
	 * @param      $open_group                             string
	 * @param      $filter                                 array
	 * @param      $check_permissions                      bool
	 * @param      $use_form                               bool
	 * @param      $form_name                              string
	 * @param      $form_group_name                        string
	 * @param      $display_check_all                      bool
	 * @param      $use_with_user_module                   bool
	 * @param      $width                                  int
	 * @param      $bgcolor                                string
	 * @param      $seperator_color                        string
	 *
	 * @see        js_fold_checkbox_groups()
	 *
	 * @return     string
	 */

	function fold_checkbox_groups($groups, $main_titles, $titles, $item_names, $open_group = "", $filter = "", $check_permissions = false, $use_form = false, $form_name = "", $form_group_name = "", $display_check_all = false, $use_with_user_module = false, $width = "500", $bgcolor = "#DDDDDD", $seperator_color = "#EEEEEE") {
		// Get global variables
		global $l_dynamic_controls;

		// Include the needed JavaScript
		$_content = $this->js_fold_checkbox_groups($groups, $filter, $use_with_user_module);

		// Count the number of groups to be displayed
		$_visible_groups = count($groups) - count($filter);

		// Initialize the counter for number of seperators being painted later
		$_seperator_counter = 0;

		// Go through all groups to be displayed
		foreach ($groups as $_groups_key=>$_groups_value) {
			// Filter out groups not to be shown
			$_count_filters = count($filter);
			$_show_group = true;

			// Check, if current group is in groups not to be shown
			for ($i = 0; $i < $_count_filters; $i++) {
				if ($_groups_key == $filter[$i]) {
					$_show_group = false;
				}
			}

			// Now only show the group if it was not found in the groups not to be shown
			if ($_show_group) {

				// Set variable for painting of seperator
				$_seperator_counter++;

				// Set title of group
				$_checkbox_title = $main_titles[$_groups_key];

				//	the different permission-groups shall be sorted alphabetically
				//	therefore the content is first saved in an array.

				// Build header of group
				$_contentTable[$main_titles[$_groups_key]] = '
					<table cellpadding="0" cellspacing="0" border="0" width="'. $width . '">';

				$_seperator_color = $seperator_color;

				// Output the seperator
				$_contentTable[$main_titles[$_groups_key]] .= '
					<tr valign="middle" bgcolor="' . $_seperator_color . '">
						<td>
							' . getPixel(10, 1) . '</td>
						<td>
							' . getPixel($width, 1) . '</td>
					</tr>';

				// Continue building header of group
				$_contentTable[$main_titles[$_groups_key]] .= '
					<tr valign="middle" bgcolor="' . $bgcolor . '">
						<td width="30" nowrap>
							' . getPixel(5, 24) . '
							<a href="javascript:toggle(\'' . $_groups_key . '\', \'show_single\', \'' . $use_form . '\', \'' . $form_name . '\', \'' . $form_group_name . '\');" name="arrow_link' . $_groups_key . '">';

				// If a group is open display it unfolded
				$_show_open = false;

				// Check, if current group is in groups to be shown opened
				if ($_groups_key == $open_group) {
					$_show_open = true;
				}

				if ($_show_open) {
					// Define various values for expanded groups
					$_arrow_image = $this->_arrow_image_opened;
					$_arrow_hint = $this->_arrow_hint_opened;
					$_style_display = "block";
				} else {
					// Define various values for folded groups
					$_arrow_image = $this->_arrow_image_closed;
					$_arrow_hint = $this->_arrow_hint_closed;
					$_style_display = "none";
				}

				// Build header for open group
				$_contentTable[$main_titles[$_groups_key]] .= '
								<img src="' . $_arrow_image . '" width="19" height="18" border="0" alt="' . $_arrow_hint . '" name="arrow_' . $_groups_key . '"></a></td>
							<td class="defaultfont" colspan="3">
								<label for="arrow_link_' . $_groups_key . '" style="cursor: pointer;" onclick="toggle(\'' . $_groups_key . '\', \'show_single\', \'' . $use_form . '\', \'' . $form_name . '\', \'' . $form_group_name . '\');"><b>' . $_checkbox_title . '</b></label></td>
						</tr>
						<tr valign="middle" bgcolor="' . $bgcolor . '">
							<td>
								' . getPixel(10, 1) . '</td>
							<td>
								' . getPixel($width, 1) . '</td>
						</tr>
					</table>';

				// Now fill the group with content
				$_contentTable[$main_titles[$_groups_key]] .= '<table cellpadding="0" cellspacing="0" border="0" width="' . $width . '" style="display: ' . $_style_display . '" id="group_' . $_groups_key . '">';
				
				// first of all order all the entries
				$_groups = array();
				foreach ( $groups[$_groups_key] as $_group_item_key=>$_group_item_value ) {
					
					$_groups[$_groups_key][$titles[$_groups_key][$_group_item_key]] = array(
						'perm' => $_group_item_key,
						'value' => $_group_item_value
					);
					
				}
				
				foreach ( $_groups as $_groups_key => $_group_item ) {
					
					ksort($_group_item);
					
					foreach ( $_group_item as $_group_item_text => $_group_item_values ) {
						
						$_group_item_key = $_group_item_values['perm'];
						$_group_item_value = $_group_item_values['value'];
						
						if (($check_permissions && we_hasPerm($_group_item_key)) || !$check_permissions) {
							// Display the items of the group
							$_contentTable[$main_titles[$_groups_key]] .= '
								<tr>
									<td></td>
									<td style="padding:5px 0;">
										' . we_forms::checkbox(($_group_item_value ? $_group_item_value : "0"), ($_group_item_value ? true : false), $item_names . "_Permission_" . $_group_item_key, $titles[$_groups_key][$_group_item_key]) . '</td>
								<tr>
									<td>
										' . getPixel(15, 3) . '</td>
								</tr>';
						}
					}
					
				}
				
				// Finish output of table
				$_contentTable[$main_titles[$_groups_key]] .= '</table>';
			}
		}
		//	sort the permission-groups alphabetically (perm_group_name)
		ksort($_contentTable);
		foreach($_contentTable as $key => $value){

			$_content .= $value;
		}
		return $_content;
	}

	/**
	 * This function creates a menu with different groups that contain checkboxes.
	 * These groups can be folded and unfolded.
	 *
	 * @param      $groups                                 array
	 * @param      $main_titles                            array
	 * @param      $titles                                 array
	 * @param      $open_group                             string
	 * @param      $filter                                 array
	 * @param      $use_form                               bool
	 * @param      $form_name                              string
	 * @param      $form_group_name                        string
	 * @param      $use_with_user_module                   bool
	 * @param      $width                                  int
	 * @param      $bgcolor                                string
	 * @param      $seperator_color                        string
	 *
	 * @see        js_fold_checkbox_groups()
	 *
	 * @return     string
	 */

	function fold_multibox_groups($groups, $main_titles, $multiboxes, $open_group = "", $filter = "", $use_form = false, $form_name = "", $form_group_name = "", $use_with_user_module = false, $width = "500", $bgcolor = "#DDDDDD", $seperator_color = "#EEEEEE") {

		// Get global variables
		global $l_dynamic_controls;

		// Include the needed JavaScript
		$_content = $this->js_fold_checkbox_groups($groups, $filter, $use_with_user_module);

		// Count the number of groups to be displayed
		$_visible_groups = count($groups) - count($filter);

		// Initialize the counter for number of seperators being painted later
		$_seperator_counter = 0;

		// Go through all groups to be displayed
		foreach ($groups as $_groups_key=>$_groups_value) {
			// Filter out groups not to be shown
			$_count_filters = count($filter);
			$_show_group = true;

			// Check, if current group is in groups not to be shown
			for ($i = 0; $i < $_count_filters; $i++) {
				if(isset($filter[$i])) {
					if ($_groups_key == $filter[$i]) {
						$_show_group = false;
					}
				}
			}

			// Now only show the group if it was not found in the groups not to be shown
			if ($_show_group) {

				// Set variable for painting of seperator
				$_seperator_counter++;

				// Set title of group
				$_checkbox_title = $main_titles[$_groups_key];

				//	the different permission-groups shall be sorted alphabetically
				//	therefore the content is first saved in an array.

				// Build header of group
				$_contentTable[$main_titles[$_groups_key]] = '
					<table cellpadding="0" cellspacing="0" border="0" width="'. $width . '">';

				$_seperator_color = $seperator_color;

				// Output the seperator
				$_contentTable[$main_titles[$_groups_key]] .= '
					<tr valign="middle" bgcolor="' . $_seperator_color . '">
						<td>
							' . getPixel(10, 1) . '</td>
						<td>
							' . getPixel($width, 1) . '</td>
					</tr>';

				// Continue building header of group
				$_contentTable[$main_titles[$_groups_key]] .= '
					<tr valign="middle" bgcolor="' . $bgcolor . '">
						<td width="30" nowrap>
							' . getPixel(5, 24) . '
							<a href="javascript:toggle(\'' . $_groups_key . '\', \'show_single\', \'' . $use_form . '\', \'' . $form_name . '\', \'' . $form_group_name . '\');" name="arrow_link' . $_groups_key . '">';

				// If a group is open display it unfolded
				$_show_open = false;

				// Check, if current group is in groups to be shown opened
				if ($_groups_key == $open_group) {
					$_show_open = true;
				}

				if ($_show_open) {
					// Define various values for expanded groups
					$_arrow_image = $this->_arrow_image_opened;
					$_arrow_hint = $this->_arrow_hint_opened;
					$_style_display = "block";
				} else {
					// Define various values for folded groups
					$_arrow_image = $this->_arrow_image_closed;
					$_arrow_hint = $this->_arrow_hint_closed;
					$_style_display = "none";
				}

				// Build header for open group
				$_contentTable[$main_titles[$_groups_key]] .= '
								<img src="' . $_arrow_image . '" width="19" height="18" border="0" alt="' . $_arrow_hint . '" name="arrow_' . $_groups_key . '"></a></td>
							<td class="defaultfont" colspan="3">
								<label for="arrow_link_' . $_groups_key . '" style="cursor: pointer;" onclick="toggle(\'' . $_groups_key . '\', \'show_single\', \'' . $use_form . '\', \'' . $form_name . '\', \'' . $form_group_name . '\');"><b>' . $_checkbox_title . '</b></label></td>
						</tr>
						<tr valign="middle" bgcolor="' . $bgcolor . '">
							<td>
								' . getPixel(10, 1) . '</td>
							<td>
								' . getPixel($width, 1) . '</td>
						</tr>
					</table>';

				// Now fill the group with content
				$_contentTable[$main_titles[$_groups_key]] .= '<table cellpadding="0" cellspacing="0" border="0" width="' . $width . '" style="display: ' . $_style_display . '" id="group_' . $_groups_key . '"><tr><td>' . getPixel(30,10) . '</td><td colspan="2">' . getPixel($width,10) . '</td></tr>';

				// Go through all items of the group
				foreach($multiboxes[$_groups_key] as $i => $c){

						if (!isset($c["headline"])) $c["headline"] = '';
							$_contentTable[$main_titles[$_groups_key]] .= '
								<tr>
									<td></td>
									<td valign="top" align="left"><span  id="headline_'.$i.'" class="weMultiIconBoxHeadline">'.$c["headline"].'</span></td>
									<td class="defaultfont">'.$c["html"].'</td>
								</tr>
								<tr>
									<td></td>
									<td>'.getPixel($c["space"],15).'</td>
									<td></td>
								</tr>';
						if($i < (count($multiboxes[$_groups_key]) - 1) && (!isset($c["noline"]))){
							$_contentTable[$main_titles[$_groups_key]] .= '<tr><td></td><td colspan="2"><div style="border-top: 1px solid #AFB0AF;margin:10px 0 10px 0;clear:both;"></div></td></tr>';
						}


				}
				$_contentTable[$main_titles[$_groups_key]] .= '</table>';

			}
		}
		//	sort the permission-groups alphabetically (perm_group_name)
		ksort($_contentTable);
		foreach($_contentTable as $key => $value){
			$_content .= $value;
		}
		return $_content;
	}

}

?>