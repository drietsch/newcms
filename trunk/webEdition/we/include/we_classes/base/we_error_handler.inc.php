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
 * Class we_error_handler
 *
 * Provides a error handler for webEdition.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php");

/*************************************************************************
 * VARIABLES
 *************************************************************************/

$_error_notice = false;
$_error_warning = false;
$_error_error = true;

$_display_error = true;
$_log_error = false;

$_send_error = false;
$_send_address = "";

/*************************************************************************
 * FUNCTIONS
 *************************************************************************/

function we_error_handler($in_webEdition = true) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	// Get error types to be handled
	$_error_notice = defined("WE_ERROR_NOTICES") ? (WE_ERROR_NOTICES == 1 ? true : false) : false;
	$_error_warning = defined("WE_ERROR_WARNINGS") ? (WE_ERROR_WARNINGS == 1 ? true : false) : false;
	$_error_error = defined("WE_ERROR_ERRORS") ? (WE_ERROR_ERRORS == 1 ? true : false) : true;

	// Get way of how to show errors
	if ($in_webEdition) {
		$_display_error = false;
	} else {
		$_display_error = defined("WE_ERROR_SHOW") ? (WE_ERROR_SHOW == 1 ? true : false) : true;
	}
	$_log_error = defined("WE_ERROR_LOG") ? (WE_ERROR_LOG == 1 ? true : false) : true;

	$_send_error = (defined("WE_ERROR_MAIL") && defined("WE_ERROR_MAIL_ADDRESS")) ? (WE_ERROR_MAIL == 1 ? true : false) : false;
	$_send_address = (defined("WE_ERROR_MAIL") && defined("WE_ERROR_MAIL_ADDRESS")) ? WE_ERROR_MAIL_ADDRESS : "";

	// Check PHP version
	if (strcmp('4.1.0', phpversion()) > 0) {
		display_error_message(E_ERROR, 'Unable to launch webEdition - PHP 4.1.0 or higher required!', "/webEdition/we/we_classes/base/we_error_handler.inc.php", 69);
		exit();
	}

	if (defined("WE_ERROR_HANDLER") && (WE_ERROR_HANDLER == 1)) {
		$_error_level = 0 + ($_error_notice ? 8 : 0) + ($_error_warning ? 2 : 0) + ($_error_error ? 1 : 0);

		error_reporting($_error_level);
		ini_set('display_errors', $_display_error);
		set_error_handler("error_handler");
	}
}

function translate_error_type($type) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	$_error = "";

	if (($type & E_ERROR) == E_ERROR) {
		$_error .= " Error ";
	}

	if (($type & E_WARNING) == E_WARNING) {
		$_error .= " Warning ";
	}

	if (($type & E_PARSE) == E_PARSE) {
		$_error .= " Parse error ";
	}

	if (($type & E_NOTICE) == E_NOTICE) {
		$_error .= " Notice ";
	}

	if (($type & E_CORE_ERROR) == E_CORE_ERROR) {
		$_error .= " Core error ";
	}

	if (($type & E_CORE_WARNING) == E_CORE_WARNING) {
		$_error .= " Core warning ";
	}

	if (($type & E_COMPILE_ERROR) == E_COMPILE_ERROR) {
		$_error .= " Compile error ";
	}

	if (($type & E_COMPILE_WARNING) == E_COMPILE_WARNING) {
		$_error .= " Compile warning ";
	}

	if (($type & E_USER_ERROR) == E_USER_ERROR) {
		$_error .= " User error ";
	}

	if (($type & E_USER_WARNING) == E_USER_WARNING) {
		$_error .= " User warning ";
	}

	if (($type & E_USER_NOTICE) == E_USER_NOTICE) {
		$_error .= " User notice ";
	}

	if (($type & E_ALL) == E_ALL) {
		$_error .=" Error ";
	}

	return $_error;
}

/**
 * This function checks the syntax of an email address.
 *
 * @param          string                                  $email
 * *
 * @return         bool
 */

function display_error_message($type, $message, $file, $line) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	// Build the error table
	$_detailedError  = '<br /><table align="center" bgcolor="#FFFFFF" cellpadding="4" cellspacing="0" style="border: 1px solid #265da6;" width="95%">';
	$_detailedError .= '	<tr bgcolor="#f7f7f7" valign="top">';
	$_detailedError .= '		<td colspan="2" style="border-bottom: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">An error occurred while executing this script.</font></td>';
	$_detailedError .= '	</tr>';

	// Error type
	$_detailedError .= '	<tr valign="top">';
	$_detailedError .= '		<td width="10%" nowrap="nowrap" style="border-bottom: 1px solid #265da6; border-right: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Error type:</b></font></td>';
	$_detailedError .= '		<td width="90%" style="border-bottom: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><i>' . translate_error_type($type) . '</i></font></td>';
	$_detailedError .= '	</tr>';

	// Error message
	$_detailedError .= '	<tr valign="top">';
	$_detailedError .= '		<td width="10%" nowrap="nowrap" style="border-bottom: 1px solid #265da6; border-right: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Error message:</b></font></td>';
	$_detailedError .= '		<td width="90%" style="border-bottom: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><i>' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $message) . '</i></font></td>';
	$_detailedError .= '	</tr>';

	// Script name
	$_detailedError .= '	<tr valign="top">';
	$_detailedError .= '		<td width="10%" nowrap="nowrap" style="border-bottom: 1px solid #265da6; border-right: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Script name:</b></font></td>';
	$_detailedError .= '		<td width="90%" style="border-bottom: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><i>' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $file) . '</i></font></td>';
	$_detailedError .= '	</tr>';

	// Line
	$_detailedError .= '	<tr valign="top">';
	$_detailedError .= '		<td width="10%" nowrap="nowrap" style="border-right: 1px solid #265da6;"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Line number:</b></font></td>';
	$_detailedError .= '		<td width="90%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><i>' . $line . '</i></font></td>';
	$_detailedError .= '	</tr>';

	// Finalize table
	$_detailedError .= '</table><br />';

	// Display the error
	print $_detailedError;
}

function log_error_message($type, $message, $file, $line) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	// Build the error table
	$_detailedError  = 'An error occurred while executing a script. ';

	// Error type
	$_detailedError .= 'Error type: ' . translate_error_type($type) . ', ';

	// Error message
	$_detailedError .= 'Error message: ' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $message) . ', ';

	// Script name
	$_detailedError .= 'Script name: ' . str_replace($_SERVER["DOCUMENT_ROOT"], "", $file) . ', ';

	// Line
	$_detailedError .= 'Line number: ' . $line;

	// Log the error
	if (defined("DB_HOST") && defined("DB_USER") && defined("DB_PASSWORD") && defined("DB_DATABASE")) {
		$_link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
			or die("Cannot log error! Could not connect: " . mysql_error());

		mysql_select_db(DB_DATABASE) or die("Cannot log error! Could not select database.");

		$_query = "INSERT INTO " . (defined("TBL_PREFIX") ? TBL_PREFIX : "") . "tblErrorLog (Text, Date) VALUES ('" . addslashes($_detailedError) . "', '" . time() . "');";

		mysql_query($_query);

		if (mysql_affected_rows() != 1) {
			die("Cannot log error! Query failed: " . mysql_error());
		}
	} else {
		die("Cannot log error! Database connection not known.");
	}
}

function mail_error_message($type, $message, $file, $line) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	// Build the error table
	$_detailedError  = "An error occurred while executing a script in webEdition.\n\n\n";

	// Domain
	if (defined("SERVER_NAME")) {
		$_detailedError .= "webEdition address: " . SERVER_NAME . ",\n\n";
	}

	// Error type
	$_detailedError .= "Error type: " . translate_error_type($type) . ",\n";

	// Error message
	$_detailedError .= "Error message: " . str_replace($_SERVER["DOCUMENT_ROOT"], "", $message) . ",\n";

	// Script name
	$_detailedError .= "Script name: " . str_replace($_SERVER["DOCUMENT_ROOT"], "", $file) . ",\n";

	// Line
	$_detailedError .= "Line number: " . $line;

	// Log the error
	if (defined("WE_ERROR_MAIL_ADDRESS")) {
		if (!mail(WE_ERROR_MAIL_ADDRESS, "[webEdition] PHP Error", $_detailedError)) {
			die("Cannot log error! Could not send e-mail.");
		}
	} else {
		die("Cannot log error! Could not send e-mail due to no know recipient.");
	}
}

function error_handler($type, $message, $file, $line, $context) {
	global $_error_notice, $_error_warning, $_error_error, $_display_error, $_log_error, $_send_error, $_send_address;

	// Don't respond to the error if it was suppressed with a '@'
	if (error_reporting() == 0) {
		return;
	}

	switch($type) {
		case E_NOTICE:
			if ($_error_notice) {
				// Display error?
				if ($_display_error) {
					display_error_message($type, $message, $file, $line);
				}

				// Log error?
				if ($_log_error) {
					log_error_message($type, $message, $file, $line);
				}

				// Mail error?
				if (isset($_send_error) && $_send_error) {
					mail_error_message($type, $message, $file, $line);
				}
			}

			// Stop execution
			break;

		case E_WARNING:
			if ($_error_warning) {
				// Display error?
				if ($_display_error) {
					display_error_message($type, $message, $file, $line);
				}

				// Log error?
				if ($_log_error) {
					log_error_message($type, $message, $file, $line);
				}

				// Mail error?
				if (isset($_send_error) && $_send_error) {
					mail_error_message($type, $message, $file, $line);
				}
			}

			// Stop execution
			break;

		case E_ERROR:
			if ($_error_error) {
				// Display error?
				if ($_display_error) {
					display_error_message($type, $message, $file, $line);
				}

				// Log error?
				if ($_log_error) {
					log_error_message($type, $message, $file, $line);
				}

				// Mail error?
				if (isset($_send_error) && $_send_error) {
					mail_error_message($type, $message, $file, $line);
				}
			}

			// Stop execution
			break;
	}
}

?>