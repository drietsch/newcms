<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_cli
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/*
 * The script makes a rebuild like in the rebuild dialog of webEdition
 * webEdition must be installed
 */

include_once("cliConfig.php");

// CONFIGURATION BEGINS ---------------------------------------------------------

/**
 * Type of Rebuild. Possible Options are:
 *
 * all 			: rebuild all documents and templates
 * templates 	: rebuild all templates
 * static 		: rebuild static documents.
 * objects 		: rebuild all objects
 * navigation 	: rebuild the navigation
 * index		: rebuild the index table
 * thumbnails	: rebuild all thumbnails
 *
 * @var string
 */
$_REQUEST['type'] = 'all';

/**
 * When rebuild type is set to "all", it rewrites
 * the maintable (tblFile) also.
 * Only use this if the maintable is broken!!!
 *
 *  @var boolean
 */
$_REQUEST['rewriteMaintable'] = false;

/**
 * When rebuild type is set to "all", it rewrites the
 * temporary table (tblTemporaryDocs) also.
 * Only use this if the temporary table is broken!!!
 *
 * @var boolean
 */
$_REQUEST['rewriteTmptable'] = false;


/**
 * String with comma separated category ids.
 * If this is set, only documents with the specified
 * categories will be rebuilt
 * This is only working when rebuild type is
 * set to "static"
 *
 * @var string
 */
$_REQUEST['categories'] = "";

/**
 * Flag if should be an AND instead an OR operation
 * between the categories.
 * This is only working when rebuild type is
 * set to "static"
 *
 * @var boolean
 */
$_REQUEST['catAnd'] = false;

/**
 * comma separated string with document type ids
 * If this is set, only documents with the specified
 * document types will be rebuilt
 * This is only working when rebuild type is
 * set to "static"
 *
 * @var string
 */
$_REQUEST['doctypes'] = "";

/**
 * comma separated string with directory ids.
 * If this is set, only documents within the specified
 * directories will be rebuilt
 * This is only working when rebuild type is
 * set to "static"
 *
 * @var string
 */
$_REQUEST['directories'] = "";

/**
 * comma separated string with thumb names to rebuild.
 *
 * This needs to be set when rebuild type is
 * set to "thumbnails"
 *
 * @var string
 */
$_REQUEST['thumbnails'] = "";


/**
 * If you want to see the output of the script
 * set this to true;
 *
 * @var boolean
 */
$_REQUEST['verbose'] = true;

//  END OF OPTIONS


/*#################################### Don't change anything below ############################*/




// we want to see errors
ini_set("display_errors", 1);
error_reporting(E_ALL);

// knock out time limit if possible
@set_time_limit(0);

// set memory limit to an equitable value if possible
@ini_set("memory_limit", "128M");

// knock out identifiation and permissions
$_SESSION["perms"] = array();
$_SESSION["perms"]["ADMINISTRATOR"] = true;
$_SESSION["user"]["Username"] = 1;


if (!isset($_SERVER['SERVER_NAME'])) {
	$_SERVER['SERVER_NAME'] = $SERVER_NAME;
}

// include needed libraries
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/rebuild/we_rebuild.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/PEAR.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Getopt.php");

// Define exit codes for errors
define('NO_ARGS',10);
define('INVALID_OPTION',11);

// Reading the incoming arguments - same as $argv
$args = Console_Getopt::readPHPArgv();


$_cliHelp = 'Usage: rebuild.php [options]
Options:
  -t TYPE, --type=TYPE       Type of rebuild. Possible TYPE values are:
                                * all         : rebuild all documents and templates
                                * templates   : rebuild all templates
                                * static      : rebuild static documents.
                                * objects     : rebuild all objects
                                * navigation  : rebuild the navigation
                                * thumbnails  : rebuild all thumbnails

  -v, --verbose              Verbosely list files processed
  --help                     Prints out this help

 Options to use when type is set to "all":

  --rewriteMaintable         When type is set to "all", it rewrites
                             the maintable (tblFile) also.
                             Only use this if the maintable is broken!!!

  --rewriteTmptable          When type is set to "all", it rewrites the
                             temporary table (tblTemporaryDocs) also.
                             Only use this if the temporary table is broken!!!

Options to use when type is set to "static":

  --categories=CATEGORIES    CATEGORIES is a string with comma separated
                             category ids.
                             If this is set, only documents with the specified
                             categories will be rebuilt

  --catAnd                   comma separated string with document type ids
                             If this is set, only documents with the specified
                             document types will be rebuilt

  --doctypes=DOCTYPES        DOCTYPES is a string with comma separated document type ids
                             If this is set, only documents with the specified
                             document types will be rebuilt

  --directories=DIRECTORIES  DIRECTORIES is a string with comma separated directory ids.
                             If this is set, only documents within the specified
                             directories will be rebuilt

Options to use when type is set to "thumbnails":

  --thumbnails=THUMBNAILS    THUMBNAILS is a comma separated string with
                             thumb names to rebuild.
';

// Make sure we got them (for non CLI binaries)
if (PEAR::isError($args)) {
   fwrite(STDERR,$args->getMessage()."\n");
   exit(NO_ARGS);
}

// Short options
$short_opts = 'vt:';

// Long options
$long_opts = array(
   'type=',
   'rewriteMaintable=',
   'rewriteTmptable=',
   'categories=',
   'catAnd',
   'doctypes=',
   'directories=',
   'thumbnails=',
   'verbose',
   'help'
   );

// Convert the arguments to options - check for the first argument
if ( count($_SERVER['argv']) && realpath($_SERVER['argv'][0]) == __FILE__ ) {
   $options = Console_Getopt::getOpt($args,$short_opts,$long_opts);
} else {
   $options = Console_Getopt::getOpt2($args,$short_opts,$long_opts);
}

// Check the options are valid
if (PEAR::isError($options)) {
   fwrite(STDERR,$options->getMessage()."\n");
   fwrite(STDERR,$_cliHelp."\n");
   exit(INVALID_OPTION);
}

if (count($args) ) {
	$_REQUEST['verbose'] = false;
	$_REQUEST['catAnd'] = false;
	$_REQUEST['rewriteMaintable'] = false;
	$_REQUEST['rewriteTmptable'] = false;
}

foreach ($options[0] as $opt) {
	switch ($opt[0]) {
		case '--type':
		case 't':
			$_REQUEST['type'] = $opt[1];
		break;

		case 'v':
		case '--verbose':
			$_REQUEST['verbose'] = true;
		break;

		case '--catAnd':
			$_REQUEST['catAnd'] = true;
		break;

		case '--rewriteMaintable':
			$_REQUEST['rewriteMaintable'] = true;
		break;

		case '--rewriteTmptable':
			$_REQUEST['rewriteTmptable'] = true;
		break;

		case '--help':
			print $_cliHelp;
			exit(0);
		break;

		default:
			$_REQUEST[preg_replace('/^--/', '', $opt[0])] = $opt[1];
	}

}

switch ($_REQUEST['type']) {

	case 'static':
		$_REQUEST['type'] = "filter";
	case 'all':
	case 'templates':
		$data = we_rebuild::getDocuments(
			"rebuild_" . $_REQUEST['type'],
			$_REQUEST['categories'],
			$_REQUEST['catAnd'],
			$_REQUEST['doctypes'],
			$_REQUEST['directories'],
			$_REQUEST['rewriteMaintable'],
			$_REQUEST['rewriteTmptable']
		);
	break;

	case 'objects':
		$data = we_rebuild::getObjects();
	break;

	case 'navigation':
		$data = we_rebuild::getNavigation();
	break;

	case 'index':
		$data = we_rebuild::getIndex();
	break;

	case 'thumbnails':
		$_thumbNames = makeArrayFromCSV($_REQUEST['thumbnails']);
		$_thumbIds = array();
		foreach ($_thumbNames as $_thumbName) {
			$_thumbIds[] = f("SELECT ID FROM " . THUMBNAILS_TABLE . " WHERE NAME='$_thumbName'", "ID", new DB_WE());
		}
		$_thumbIds = makeCSVFromArray($_thumbIds);
		$data = we_rebuild::getThumbnails($_thumbIds);
	break;

	default:
		print "ERROR: rebuild type is not set!";
}


// start rebuild

foreach($data as $d) {
	we_rebuild::rebuild($d, $_REQUEST['verbose']);
}


?>