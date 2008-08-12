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
$GLOBALS["l_import_files"]["sameName_expl"] = "Si el nombre del archivo ya existe, qu� le gustar�a que webEdition hiciese?.";
$GLOBALS["l_import_files"]["sameName_overwrite"] = "Sobrescribir el archivo existente";
$GLOBALS["l_import_files"]["sameName_rename"] = "Renombrar el nuevo archivo";
$GLOBALS["l_import_files"]["sameName_nothing"] = "No importar el archivo";
$GLOBALS["l_import_files"]["sameName_headline"] = "Qu� hacer<br>si un archivo existe?";
$GLOBALS["l_import_files"]["step1"] = "Importar archivos locales - Paso 1 de 2";
$GLOBALS["l_import_files"]["step2"] = "Importar archivos locales - Paso 2 de 2";
$GLOBALS["l_import_files"]["import_expl"] = "Clic en el bot�n proximo al campo de entrada para seleccionar un archivo en su disco duro. Despu�s de la selecci�n aparece un nuevo campo de entrada y Ud puede seleccionar otro archivo. Por favor, note que el tama�o maximo del archivo de  %s no debe ser excedido por las restricciones de PHP y MySQL!<br><br>Clic en \"Siguiente\", para iniciar la importaci�n.";
$GLOBALS["l_import_files"]["import_expl_jupload"] = "With the click on the button you can select more then one file from your harddrive. Alternatively the files can be selected per 'Drag and Drop' from the file manager.  Please note that the maximum filesize of  %s is not to be exceeded because of restrictions by PHP and MySQL!<br><br>Click on \"Next\", to start the import.";

$GLOBALS["l_import_files"]["error"] = "Un error ocurre durante el proceso de importaci�n!\\n\\nLos siguientes archivos no pudieron ser importados:\\n%s";
$GLOBALS["l_import_files"]["finished"] = "La importaci�n fue exitosa!";
$GLOBALS["l_import_files"]["import_file"] = "Importando archivos %s";

$GLOBALS["l_import_files"]["no_perms"] = "Error: sin permiso";
$GLOBALS["l_import_files"]["move_file_error"] = "Error: move_uploaded_file()"; // TRANSLATE
$GLOBALS["l_import_files"]["read_file_error"] = "Error: fread()"; // TRANSLATE
$GLOBALS["l_import_files"]["php_error"] = "Error: upload_max_filesize()"; // TRANSLATE
$GLOBALS["l_import_files"]["same_name"] = "Error: el archivo ya existe";
$GLOBALS["l_import_files"]["save_error"] = "Error mientras salvando";
$GLOBALS["l_import_files"]["publish_error"] = "Error mientras publicando";

$GLOBALS["l_import_files"]["root_dir_1"] = "Ud especific� el directorio ra�z del servidor Web como el directorio original. Desea Ud realmente importar todo el contenido del directorio ra�z?";
$GLOBALS["l_import_files"]["root_dir_2"] = "Ud especific� el directorio ra�z del servidor Web como el directorio objetivo. Desea Ud realmente importar directamente al directorio ra�z?";
$GLOBALS["l_import_files"]["root_dir_3"] = "Ud especific� el directorio ra�z del servidor Web como ambos el directorio original y  el directorio objetivo. Desea Ud realmente importar todo el contenido del directorio ra�z directamente al directorio ra�z?";

$GLOBALS["l_import_files"]["thumbnails"] = "Imagenes en miniatura";
$GLOBALS["l_import_files"]["make_thumbs"] = "Crear<br>Imagenes en miniatura";
$GLOBALS["l_import_files"]["image_options_open"] = "Mostrar opciones de imagen";
$GLOBALS["l_import_files"]["image_options_close"] = "Ocultar opciones de imagen";
$GLOBALS["l_import_files"]["add_description_nogdlib"] = "Para tener las funci�nes gr�ficas a su disposici�n tiene que instalar la 'GD Library' en el servidor!";
?>