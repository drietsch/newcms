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

sel_color = "#697ace";
default_color = "#000000";

	// Highlighting-Stuff start
	function selectEntryHandler(id, NN4) {
		var i, j;

//		var id = parseInt(elem.match(/\d+/));

		if (parent.multi_select == 0) {
			//unselect all selected entries
			if (NN4 == false) {
			    for (j = 0; j < parent.entries_selected.length; j++) {
				    highlight_Elem(parent.entries_selected[j], default_color);
			    }
			}


			parent.entries_selected = new Array();
			doSelectMessage(id, 'elem', '', NN4);
		} else {
			if (array_search(id, parent.entries_selected) != -1) {
				unSelectMessage(id, 'elem', '', NN4);
			} else {
				doSelectMessage(id, 'elem', '', NN4);
			}
		}
	}

	function doSelectMessage(id, mode, doc, NN4) {
	    var i = 0;
	    var highlight_color = sel_color;

	    if (id == -1)
		return;

	    if (mode == "fv") {
		showContent(id);
		//IE Mac 5.01 doesnt support Array.push()
		parent.entries_selected = parent.entries_selected.concat(new Array(String(id)));
		parent.last_entry_selected = id;
	    } else {
		entries_selected = entries_selected.concat(new Array(String(id)));
	    }

	    
	    if (NN4 == false) {
		if (mode == "fv")
		    highlight_TR(id, highlight_color, '');
		else
		    highlight_Elem(id, highlight_color, doc);
	    }
	}

	function highlight_Elem(id, color, fr) {
	    if (fr == '') {
		document.getElementById(id).style.color = color;
	    } else {
		if (fr.document.getElementById(id))
		    fr.document.getElementById(id).style.color = color;
	    }
	}

	function highlight_TR(id, color) {
	    var i;

	    for (i = 0; i <= 3; i++) {
		document.getElementById("td_" + id + "_" + i).style.backgroundColor = color;
	    }
	}

	function unSelectMessage(id, show_cont, doc, NN4) {
	    var index = -1;
	    var arr1, arr2;


	    if (show_cont == 'fv') {
		parent.entries_selected = array_rm_elem(parent.entries_selected, id, -1);
	    } else {
		entries_selected = array_rm_elem(entries_selected, id, -1);
	    }

	    if (show_cont == 'fv') {
		if (NN4 == false)
		    highlight_TR(id, default_color);

		top.messaging_main.messaging_right.messaging_message_view.location = "<?php echo HTML_DIR?>gray.html";
	    } else {
		if (NN4 == false)
		    highlight_Elem(id, default_color, messaging_usel_main);
	    }
	
	}

	//Highlighting-Stuff end 

