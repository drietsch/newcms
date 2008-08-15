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
 * Language file: import_files.inc.php
 * Provides language strings.
 * Language: English
 */
$GLOBALS["l_import_files"]["destination_dir"] = "Destination directory"; // TRANSLATE
$GLOBALS["l_import_files"]["file"] = "Archivo";
$GLOBALS["l_import_files"]["sameName_expl"] = "Si el nombre del archivo ya existe, qué le gustaría que webEdition hiciese?.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Sobrescribir el archivo existente";
$GLOBALS["l_import_files"]["sameName_rename"] = "Renombrar el nuevo archivo";
$GLOBALS["l_import_files"]["sameName_nothing"] = "No importar el archivo";
$GLOBALS["l_import_files"]["sameName_headline"] = "Qué hacer<br>si un archivo existe?";
$GLOBALS["l_import_files"]["step1"] = "Importar archivos locales - Paso 1 de 2";
$GLOBALS["l_import_files"]["step2"] = "Importar archivos locales - Paso 2 de 2";
$GLOBALS["l_import_files"]["step3"] = "Import local files - Step 3 of 3"; // TRANSLATE
$GLOBALS["l_import_files"]["import_expl"] = "Clic en el botón proximo al campo de entrada para seleccionar un archivo en su disco duro. Después de la selección aparece un nuevo campo de entrada y Ud puede seleccionar otro archivo. Por favor, note que el tamaño maximo del archivo de  %s no debe ser excedido por las restricciones de PHP y MySQL!<br><br>Clic en \"Siguiente\", para iniciar la importación.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Un error ocurre durante el proceso de importación!\\n\\nLos siguientes archivos no pudieron ser importados:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "La importación fue exitosa!";
$GLOBALS["l_import_files"]["import_file"] = "Importando archivos %s";

$GLOBALS["l_import_files"]["no_perms"] = "Error: sin permiso";
$GLOBALS["l_import_files"]["move_file_error"] = "Error: move_uploaded_file()"; // TRANSLATE
$GLOBALS["l_import_files"]["read_file_error"] = "Error: fread()"; // TRANSLATE
$GLOBALS["l_import_files"]["php_error"] = "Error: upload_max_filesize()"; // TRANSLATE
$GLOBALS["l_import_files"]["same_name"] = "Error: el archivo ya existe";
$GLOBALS["l_import_files"]["save_error"] = "Error mientras salvando";
$GLOBALS["l_import_files"]["publish_error"] = "Error mientras publicando";

$GLOBALS["l_import_files"]["root_dir_1"] = "Ud especificó el directorio raíz del servidor Web como el directorio original. Desea Ud realmente importar todo el contenido del directorio raíz?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Ud especificó el directorio raíz del servidor Web como el directorio objetivo. Desea Ud realmente importar directamente al directorio raíz?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Ud especificó el directorio raíz del servidor Web como ambos el directorio original y  el directorio objetivo. Desea Ud realmente importar todo el contenido del directorio raíz directamente al directorio raíz?";

$GLOBALS["l_import_files"]["thumbnails"] = "Imagenes en miniatura";
$GLOBALS["l_import_files"]["make_thumbs"] = "Crear<br>Imagenes en miniatura";
$GLOBALS["l_import_files"]["image_options_open"] = "Mostrar opciones de imagen";
$GLOBALS["l_import_files"]["image_options_close"] = "Ocultar opciones de imagen";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Para tener las funciónes gráficas a su disposición tiene que instalar la 'GD Library' en el servidor!";

$GLOBALS["l_import_files"]["noFiles"] = "No files exist in the specified source directory which correspond with the given import settings!"; // TRANSLATE
$GLOBALS["l_import_files"]["emptyDir"] = "The source directory is empty!"; // TRANSLATE

$GLOBALS["l_import_files"]["metadata"] = "Meta data"; // TRANSLATE
$GLOBALS["l_import_files"]["import_metadata"] = "Import meta data from file"; // TRANSLATE

?>