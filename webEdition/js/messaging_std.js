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

function array_search(needle, haystack) {
    var i;

    for (i = 0; i < haystack.length; i++) {
	if (needle == haystack[i]) 
	    return i;
    }

    return -1;
}

function array_two_dim_search(needle, haystack, offset) {
    var i;

    for (i = 0; i < haystack.length; i++) {
	if (needle == haystack[i][offset]) 
	    return i;
    }

    return -1;
}

function user_array_search(needle, haystack, offset, type) {
    var i;

    for (i = 0; i < haystack.length; i++) {
	if (haystack[i][0] != type) {
	    continue;
	}

	if (needle == haystack[i][offset]) 
	    return i;
    }

    return -1;
}

function array_rm_elem(arr, elem, tdim_off) {
    var i;
    var arr1, arr2;
    var index = -1;

    // Locate elem in arr
    if (tdim_off < 0) {
	index = array_search(elem, arr);
    } else {
	index = array_two_dim_search(elem, arr, tdim_off);
    }

    // Delete entry from entries_selected 
    if (index != -1) {
	arr1 = arr.slice(0, index);
	arr2 = arr.slice(index + 1, arr.length);
	return arr1.concat(arr2);
    }

    return arr;
}

function get_sel_elems(sel_box) {
    var i;
    var arr_sel = new Array();

    for (i = 0; i < sel_box.length; i++) {
	if (sel_box.options[i].selected == true) {
	    arr_sel = arr_sel.concat(new Array(String(sel_box.options[i].value)));
	}
    }

    return arr_sel;
}

function close_win(name) {
    var i;
    for (i = 0; i <= top.jsWindow_count; i++) {
	if (eval("topjsWindow" + i + "Object.ref") == name) {
	    eval("topjsWindow" + i + "Object.close()");
	}
    }
}

