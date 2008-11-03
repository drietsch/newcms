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
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Destination directory";
$GLOBALS["l_import_files"]["file"] = "File";
$GLOBALS["l_import_files"]["sameName_expl"] = "If the filename already exists, what would you like webEdition to do?";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Overwrite the existing file";
$GLOBALS["l_import_files"]["sameName_rename"] = "Rename the new file";
$GLOBALS["l_import_files"]["sameName_nothing"] = "Do not import the file";
$GLOBALS["l_import_files"]["sameName_headline"] = "What to do<br>if a file exists?";
$GLOBALS["l_import_files"]["step1"] = "Import local files - Step 1 of 2";
$GLOBALS["l_import_files"]["step2"] = "Import local files - Step 2 of 3";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3";
$GLOBALS["l_import_files"]["import_expl"] = "Click on the button next to the input field to select a file from your harddrive. After the selection a new input field appears and you can select another file. Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Upload Files\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "An error occured during the import process!\\n\\nThe following files could not be imported:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "The import was successful!";
$GLOBALS["l_import_files"]["import_file"] = "Importing file %s";

$GLOBALS["l_import_files"]["no_perms"] = "Error: no permission";
$GLOBALS["l_import_files"]["move_file_error"] = "Error: move_uploaded_file()";
$GLOBALS["l_import_files"]["read_file_error"] = "Error: fread()";
$GLOBALS["l_import_files"]["php_error"] = "Error: upload_max_filesize()";
$GLOBALS["l_import_files"]["same_name"] = "Error: file exists";
$GLOBALS["l_import_files"]["save_error"] = "Error while saving";
$GLOBALS["l_import_files"]["publish_error"] = "Error while publishing";

$GLOBALS["l_import_files"]["root_dir_1"] = "You specified the root directory of the Web server as the source directory. Do you really want to import all contents of the root directory?";
$GLOBALS["l_import_files"]["root_dir_2"] = "You specified the root directory of the Web server as the target directory. Do you really want to import directly into the root directory?";
$GLOBALS["l_import_files"]["root_dir_3"] = "You specified the root directory of the Web server as both the source and the target directory. Do you really want to import the contents of the root directory directly into the root directory?";

$GLOBALS["l_import_files"]["thumbnails"] = "Thumbnails";
$GLOBALS["l_import_files"]["make_thumbs"] = "Create<br>Thumbnails";
$GLOBALS["l_import_files"]["image_options_open"] = "Show image functions";
$GLOBALS["l_import_files"]["image_options_close"] = "Hide image functions";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "The GD Library has to be installed on your server for the graphic functions to work properly!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!";
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!";

$GLOBALS["l_import_files"]["metadata"] = "Meta data";
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file";

?>