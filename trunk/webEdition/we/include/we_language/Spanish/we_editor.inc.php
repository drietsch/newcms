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
 * Language file: we_editor.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_editor["doubble_field_alert"] = "El campo '%s' ya existe! El nombre de campo debe ser �nico!";

$l_we_editor["folder_save_nok_parent_same"] = "El directorio primario seleccionado est� dentro del directorio actual! Por favor, escoja otro directorio e intentelo nuevamente!";
$l_we_editor["pfolder_notsave"] = "El directorio no puede ser salvado en el directorio seleccionado!";
$l_we_editor["required_field_alert"] = "El campo '%s' es requerido y debe ser llenado!";

$l_we_editor["category"]["response_save_ok"] = "La categor�a '%s' ha sido exitosamente salvada!";
$l_we_editor["category"]["response_save_notok"] = "Error mientras se salvaba la categor�a '%s'!";
$l_we_editor["category"]["response_path_exists"] = "La categor�a '%s' no pudo ser salvada porque otra categor�a est� situada en la misma ubicaci�n!";
$l_we_editor["category"]["we_filename_notValid"] = "Nombre no v�lido!\\n\", \\' < > y / no est�n permitidos!";
$l_we_editor["category"]["filename_empty"]       = "El nombre del archivo no puede estar vac�o.";
$l_we_editor["category"]["name_komma"] = "Nombre no v�lido! La coma no est� permitida!";

$l_we_editor["text/webedition"]["response_save_ok"] = "La p�gina webEdition '%s' ha sido exitosamente salvada!";
$l_we_editor["text/webedition"]["response_publish_ok"] = "La p�gina webEdition '%s' ha sido exitosamente publicada!";
$l_we_editor["text/webedition"]["response_publish_notok"] = "Error mientras publicaba la p�gina webEdition '%s'!";
$l_we_editor["text/webedition"]["response_unpublish_ok"] = "La p�gina webEdition '%s' ha sido exitosamente des-publicada!";
$l_we_editor["text/webedition"]["response_unpublish_notok"] = "Error mientras se despublicaba la p�gina webEdition '%s'!";
$l_we_editor["text/webedition"]["response_not_published"] = "La p�gina webEdition '%s' no est� publicada!";
$l_we_editor["text/webedition"]["response_save_notok"] = "Error mientras se salvaba la p�gina webEdition '%s'!";
$l_we_editor["text/webedition"]["response_path_exists"] = "La p�gina webEdition '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/webedition"]["filename_empty"] = "Ning�n nombre ha sido entrado para este documento!";
$l_we_editor["text/webedition"]["we_filename_notValid"] = "Nombre de archivo no v�lido\\nLos car�cteres v�lidos son alpha-n�mericos, may�sculas y min�sculas, as� como tambi�n subrayados, gui�n y punto (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["text/webedition"]["we_filename_notAllowed"] = "El nombre de archivo entrado no es permitido!";
$l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"] = "El documento no pudo ser salvado porque Ud no tiene los derechos necesarios para crear carpetas (%s)!";
$l_we_editor["text/webedition"]["autoschedule"] = "La p�gina webEdition ser� publicada autom�ticamente en %s.";

$l_we_editor["text/html"]["response_save_ok"] = "La p�gina HTML '%s' ha sido exitosamente salvada!";
$l_we_editor["text/html"]["response_publish_ok"] = "La p�gina HTML '%s' ha sido exitosamente publicada!";
$l_we_editor["text/html"]["response_publish_notok"] = "Error mientras se publicaba la p�gina HTML '%s'!";
$l_we_editor["text/html"]["response_unpublish_ok"] = "La p�gina HTML '%s' ha sido exitosamente des-publicada!";
$l_we_editor["text/html"]["response_unpublish_notok"] = "Error mientras se des-publicaba la p�gina HTML '%s'!";
$l_we_editor["text/html"]["response_not_published"] = "La p�gina HTML '%s' no est� publicada!";
$l_we_editor["text/html"]["response_save_notok"] = "Error mientras se salvaba la p�gina HTML '%s'!";
$l_we_editor["text/html"]["response_path_exists"] = "La p�gina HTML '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/html"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/html"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/html"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/html"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/html"]["autoschedule"] = "The HTML page will be published automatically on %s.";

$l_we_editor["text/weTmpl"]["response_save_ok"] = "La plantilla '%s' ha sido exitosamente salvada!";
$l_we_editor["text/weTmpl"]["response_publish_ok"] = "La plantilla '%s' ha sido exitosamente publicada!";
$l_we_editor["text/weTmpl"]["response_unpublish_ok"] = "La plantilla '%s' ha sido exitosamente des-publicada!";
$l_we_editor["text/weTmpl"]["response_save_notok"] = "Error mientras se salvaba la plantilla '%s'!";
$l_we_editor["text/weTmpl"]["response_path_exists"] = "La plantilla '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/weTmpl"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/weTmpl"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/weTmpl"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/weTmpl"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["text/weTmpl"]["no_template_save"] = "Templates " . "can " . "not " . "saved " . "in the " . "de" . "mo" . " of" . " webEdition.";

$l_we_editor["text/css"]["response_save_ok"] = "La hoja de estilo '%s' ha sido exitosamente salvada!";
$l_we_editor["text/css"]["response_publish_ok"] = "La hoja de estilo '%s' ha sido exitosamente publicada!";
$l_we_editor["text/css"]["response_unpublish_ok"] = "La hoja de estilo '%s' ha sido exitosamente des-publicada!";
$l_we_editor["text/css"]["response_save_notok"] = "Error mientras se salvaba la hoja de estilo '%s'!";
$l_we_editor["text/css"]["response_path_exists"] = "La hoja de estilo '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/css"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/css"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/css"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/css"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/js"]["response_save_ok"] = "The JavaScript '%s' has been successfully saved!";
$l_we_editor["text/js"]["response_publish_ok"] = "El JavaScript '%s' ha sido exitosamente publicado!";
$l_we_editor["text/js"]["response_unpublish_ok"] = "El JavaScript '%s' ha sido exitosamente des-publicado!";
$l_we_editor["text/js"]["response_save_notok"] = "Error mientras se salvaba JavaScript '%s'!";
$l_we_editor["text/js"]["response_path_exists"] = "El JavaScript '%s' no pudo ser salvado porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/js"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/js"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/js"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/js"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["text/plain"]["response_save_ok"] = "The text file '%s' has been successfully saved!";
$l_we_editor["text/plain"]["response_publish_ok"] = "El archivo de texto '%s' ha sido exitosamente publicado!";
$l_we_editor["text/plain"]["response_unpublish_ok"] = "El archivo de texto '%s' ha sido exitosamente des-publicado!";
$l_we_editor["text/plain"]["response_save_notok"] = "Error mientras se salvaba el archivo de texto '%s'!";
$l_we_editor["text/plain"]["response_path_exists"] = "El archivo de texto '%s' no pudo ser salvado porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["text/plain"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["text/plain"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["text/plain"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["text/plain"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["folder"]["response_save_ok"] = "The directory '%s' has been successfully saved!";
$l_we_editor["folder"]["response_publish_ok"] = "El directorio '%s' ha sido exitosamente publicado!";
$l_we_editor["folder"]["response_unpublish_ok"] = "El directorio '%s' ha sido exitosamente des-publicado!";
$l_we_editor["folder"]["response_save_notok"] = "Error mientras se salvaba el directorio '%s'!";
$l_we_editor["folder"]["response_path_exists"] = "El directorio '%s' no pudo ser salvado porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["folder"]["filename_empty"] = "Ning�n nombre entrado para este directorio!";
$l_we_editor["folder"]["we_filename_notValid"] = "Nombre de carpeta no v�lido\\nLos car�cteres v�lidos son alpha-n�mericos, may�sculas y min�sculas, as� como tambi�n subrayados, gui�n y punto (a-z, A-Z, 0-9, _, -, .)";
$l_we_editor["folder"]["we_filename_notAllowed"] = "El nombre entrado para el drectorio no est� permitido!";
$l_we_editor["folder"]["response_save_noperms_to_create_folders"] = "El directorio no pudo ser salvado porque Ud no tiene los derechos necesarios para crear carpetas (%s)!";

$l_we_editor["image/*"]["response_save_ok"] = "La imagen '%s' ha sido exitosamente salvada!";
$l_we_editor["image/*"]["response_publish_ok"] = "La imagen '%s' ha sido exitosamente publicada!";
$l_we_editor["image/*"]["response_unpublish_ok"] = "La imagen '%s' ha sido exitosamente des-publicada!";
$l_we_editor["image/*"]["response_save_notok"] = "Error mientras se salvaba la imagen '%s'!";
$l_we_editor["image/*"]["response_path_exists"] = "La image '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["image/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["image/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["image/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["image/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["application/*"]["response_save_ok"] = "The document '%s' has been successfully saved!";
$l_we_editor["application/*"]["response_publish_ok"] = "El documento '%s' ha sido exitosamente publicado!";
$l_we_editor["application/*"]["response_unpublish_ok"] = "El documento '%s' ha sido exitosamente des-publicado!";
$l_we_editor["application/*"]["response_save_notok"] = "Error mientras se salvaba el documento '%s'!";
$l_we_editor["application/*"]["response_path_exists"] = "El documento '%s' no pudo ser salvado porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["application/*"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/*"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/*"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/*"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];
$l_we_editor["application/*"]["we_description_missing"] = "Please enter a desription in the 'Desription' field!";
$l_we_editor["application/*"]["response_save_wrongExtension"] =  "Error tratando de guardar '%s' \\nLa extensi�n de fichero '%s' no es valida para otros ficheros!\\nPor favor, cree una pagina HTML para ese prop�sito!";

$l_we_editor["application/x-shockwave-flash"]["response_save_ok"] = "La pel�cula Flash '%s' ha sido exitosamente salvada!";
$l_we_editor["application/x-shockwave-flash"]["response_publish_ok"] = "La pel�cula Flash '%s' ha sido exitosamente publicada!";
$l_we_editor["application/x-shockwave-flash"]["response_unpublish_ok"] = "La pel�cula Flash '%s' ha sido exitosamente des-publicada!";
$l_we_editor["application/x-shockwave-flash"]["response_save_notok"] = "Error mientras se salvaba la pel�cula Flash '%s'!";
$l_we_editor["application/x-shockwave-flash"]["response_path_exists"] = "La pel�cula Flash '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!";
$l_we_editor["application/x-shockwave-flash"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["application/x-shockwave-flash"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["application/x-shockwave-flash"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

$l_we_editor["video/quicktime"]["response_save_ok"] = "The Quicktime movie '%s' has been successfully saved!";
$l_we_editor["video/quicktime"]["response_publish_ok"] = "La pel�cula Quicktime '%s' ha sido exitosamente publicada!";
$l_we_editor["video/quicktime"]["response_unpublish_ok"] = "La pel�cula Quicktime '%s' ha sido exitosamente des-publicad!";
$l_we_editor["video/quicktime"]["response_save_notok"] = "Error mientras se salvaba la pel�cula Quicktime '%s'!";
$l_we_editor["video/quicktime"]["response_path_exists"] = "La pel�cula Quicktime '%s' no pudo ser salvada porque otro documento o directorio est� situado en la misma ubicaci�n!!";
$l_we_editor["video/quicktime"]["filename_empty"] = $l_we_editor["text/webedition"]["filename_empty"];
$l_we_editor["video/quicktime"]["we_filename_notValid"] = $l_we_editor["text/webedition"]["we_filename_notValid"];
$l_we_editor["video/quicktime"]["we_filename_notAllowed"] = $l_we_editor["text/webedition"]["we_filename_notAllowed"];
$l_we_editor["video/quicktime"]["response_save_noperms_to_create_folders"] = $l_we_editor["text/webedition"]["response_save_noperms_to_create_folders"];

/*****************************************************************************
 * PLEASE DON'T TOUCH THE NEXT LINES
 * UNLESS YOU KNOW EXACTLY WHAT YOU ARE DOING!
 *****************************************************************************/

$_language_directory = $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules";
$_directory = dir($_language_directory);

while (false !== ($entry = $_directory->read())) {
	if (ereg('_we_editor', $entry)) {
		include_once($_language_directory."/".$entry);
	}
}
?>