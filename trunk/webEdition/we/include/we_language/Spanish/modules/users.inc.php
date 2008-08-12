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
 * Language file: users.inc.php
 * Provides language strings.
 * Language: English
 */
$l_users["user_same"] = "The owner cannot be deleted!"; // TRANSLATE
$l_users["grant_owners_ok"] = "Los dueños fueron cambiados éxitosamente!";
$l_users["grant_owners_notok"] = "¡Error al cambiar los dueños!";
$l_users["grant_owners"] = "Cambiar dueños";
$l_users["grant_owners_expl"] = "Cambiar los dueños de todos los archivos y directorios que residen en el directorio actual al dueño ajustado arriba";
$l_users["make_def_ws"] = "Predeterminado";
$l_users["user_saved_ok"] = "El usuario '%s' fue salvado exitosamente";
$l_users["group_saved_ok"] = "El grupo '%s' fue salvado exitosamente";
$l_users["alias_saved_ok"] = "El alias '%s' fue salvado exitosamente";
$l_users["user_saved_nok"] = "El usuario '%s' no se puede salvar!";
$l_users["nothing_to_save"] = "Nada para salvar!";
$l_users["username_exists"] = "El nombre de usuario '%s' ya existe!";
$l_users["username_empty"] = "¡El nombre de usuario está vacío!";
$l_users["user_deleted"] = "El usuario '%s' fue borrado!";
$l_users["nothing_to_delete"] = "Nada para borrar!";
$l_users["delete_last_user"] = "Ud está tratando de borrar el último usuario con derechos de administrador. Borrarlo haría el sistema inmanejable! Por lo tanto, no es posible borrarlo.";
$l_users["modify_last_admin"] = "Debe haber al menos un administrador.\\n Ud no puede cambiar los derechos del último administrador.";
$l_users["user_path_nok"] = "La ruta de acceso no es correcta!";
$l_users["user_data"] = "Data del usuario";
$l_users["first_name"] = "Nombre";
$l_users["second_name"] = "Apellido";
$l_users["username"] = "Nombre de usuario";
$l_users["password"] = "Contraseña";
$l_users["workspace_specify"] = "Especificar área de trabajo";
$l_users["permissions"] = "Permisos";
$l_users["user_permissions"] = "Permisos del usuario";
$l_users["admin_permissions"] = "Permisos del administrador";
$l_users["password_alert"] = "La contraseña debe tener por lo menos 4 carácteres"; 
$l_users["delete_alert_user"] = "Toda el data del usuario para el nombre de usuario ' %s ' será borrado.\\n ¿Está UD seguro que desea continuar?";
$l_users["delete_alert_alias"] = "Toda el data del alias para el alias ' %s ' será borrado.\\n ¿Está UD seguro que desea continuar?";
$l_users["delete_alert_group"] = "Toda el data del grupo y grupo de usuarios para el grupo ' %s ' será borrado.\\n ¿Está UD seguro que desea continuar?";
$l_users["created_by"] = "Creado por";
$l_users["changed_by"] = "Cambiado por";
$l_users["no_perms"] = "UD no tiene ningún permiso para usar esta opción!";
$l_users["publish_specify"] = "El usuario puede publicar"; 
$l_users["work_permissions"] = "Permisos de trabajo";
$l_users["control_permissions"] = "Permisos de control";
$l_users["log_permissions"] = "Permisos de conexión";
$l_users["file_locked"][FILE_TABLE] = "El archivo '%s' es actualmente usado por '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "La plantilla '%s' es actualmente usada por '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "La clase '%s' es actualmente usada por '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "El objeto '%s' es actualmente usado por '%s'!";
}
$l_users["acces_temp_denied"] = "Acceso denegado temporalmente";  
$l_users["description"] = "Descripción";
$l_users["group_data"] = "Data de grupo";
$l_users["group_name"] = "Nombre de grupo";
$l_users["group_member"] = "Membresía de grupo";
$l_users["group"] = "Grupo";
$l_users["address"] = "Dirección";
$l_users["houseno"] = "Número de casa/apartamento";
$l_users["state"] = "Estado";
$l_users["PLZ"] = "Código Postal";
$l_users["city"] = "Ciudad";
$l_users["country"] = "Pais";
$l_users["tel_pre"] = "Código telefónico del área";
$l_users["fax_pre"] = "Código de fax del área";
$l_users["telephone"] = "Teléfono";
$l_users["fax"] = "Fax"; // TRANSLATE
$l_users["mobile"] = "Celular";
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "Data general";
$l_users["workspace_documents"] = "Documentos del área de trabajo";
$l_users["workspace_templates"] = "Plantillas del área de trabajo";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "El usuario fue cambiado.\\nDesea UD salvar sus cambios?";
$l_users["not_able_to_save"] = " El data no ha sido salvado por la invalidez del data!";
$l_users["cannot_save_used"] = " El status no puede ser cambiado porque está en proceso!";
$l_users["geaendert_von"] = "Cambiado por";
$l_users["geaendert_am"] = "Cambiado en";
$l_users["angelegt_am"] = " Establecido en";
$l_users["angelegt_von"] = "Establecido por";
$l_users["status"] = "Estatus";
$l_users["value"] = " Valor ";
$l_users["gesperrt"] = "restringido";
$l_users["freigegeben"] = "abrir";
$l_users["gelöscht"] = "borrado";
$l_users["ohne"] = "sin";
$l_users["user"] = "Usuario";
$l_users["usertyp"] = "Tipo de usuario";
$l_users["serach_results"] = "Resultados de la búsqueda";
$l_users["inherit"] = "Heredar permisos desde el grupo primario";
$l_users["inherit_ws"] = "Heredar área de trabajo de documentos desde el grupo primario";
$l_users["inherit_wst"] = "Heredar área de trabajo de plantillas desde el grupo primario";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organización";
$l_users["give_org_name"] = "Nombre de la organización";
$l_users["can_not_create_org"] = "La organización no puede ser creada";
$l_users["org_name_empty"] = "El nombre de la organización está vacío";
$l_users["salutation"] = "Saludo";
$l_users["sucheleer"] = "La palabra de búsqueda está vacía.";
$l_users["alias_data"] = "Data del alias";
$l_users["rights_and_workspaces"] = "Permisos y<br>áreas de trabajo";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>