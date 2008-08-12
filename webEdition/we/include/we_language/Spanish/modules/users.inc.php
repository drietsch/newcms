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
$l_users["grant_owners_ok"] = "Los due�os fueron cambiados �xitosamente!";
$l_users["grant_owners_notok"] = "�Error al cambiar los due�os!";
$l_users["grant_owners"] = "Cambiar due�os";
$l_users["grant_owners_expl"] = "Cambiar los due�os de todos los archivos y directorios que residen en el directorio actual al due�o ajustado arriba";
$l_users["make_def_ws"] = "Predeterminado";
$l_users["user_saved_ok"] = "El usuario '%s' fue salvado exitosamente";
$l_users["group_saved_ok"] = "El grupo '%s' fue salvado exitosamente";
$l_users["alias_saved_ok"] = "El alias '%s' fue salvado exitosamente";
$l_users["user_saved_nok"] = "El usuario '%s' no se puede salvar!";
$l_users["nothing_to_save"] = "Nada para salvar!";
$l_users["username_exists"] = "El nombre de usuario '%s' ya existe!";
$l_users["username_empty"] = "�El nombre de usuario est� vac�o!";
$l_users["user_deleted"] = "El usuario '%s' fue borrado!";
$l_users["nothing_to_delete"] = "Nada para borrar!";
$l_users["delete_last_user"] = "Ud est� tratando de borrar el �ltimo usuario con derechos de administrador. Borrarlo har�a el sistema inmanejable! Por lo tanto, no es posible borrarlo.";
$l_users["modify_last_admin"] = "Debe haber al menos un administrador.\\n Ud no puede cambiar los derechos del �ltimo administrador.";
$l_users["user_path_nok"] = "La ruta de acceso no es correcta!";
$l_users["user_data"] = "Data del usuario";
$l_users["first_name"] = "Nombre";
$l_users["second_name"] = "Apellido";
$l_users["username"] = "Nombre de usuario";
$l_users["password"] = "Contrase�a";
$l_users["workspace_specify"] = "Especificar �rea de trabajo";
$l_users["permissions"] = "Permisos";
$l_users["user_permissions"] = "Permisos del usuario";
$l_users["admin_permissions"] = "Permisos del administrador";
$l_users["password_alert"] = "La contrase�a debe tener por lo menos 4 car�cteres"; 
$l_users["delete_alert_user"] = "Toda el data del usuario para el nombre de usuario ' %s ' ser� borrado.\\n �Est� UD seguro que desea continuar?";
$l_users["delete_alert_alias"] = "Toda el data del alias para el alias ' %s ' ser� borrado.\\n �Est� UD seguro que desea continuar?";
$l_users["delete_alert_group"] = "Toda el data del grupo y grupo de usuarios para el grupo ' %s ' ser� borrado.\\n �Est� UD seguro que desea continuar?";
$l_users["created_by"] = "Creado por";
$l_users["changed_by"] = "Cambiado por";
$l_users["no_perms"] = "UD no tiene ning�n permiso para usar esta opci�n!";
$l_users["publish_specify"] = "El usuario puede publicar"; 
$l_users["work_permissions"] = "Permisos de trabajo";
$l_users["control_permissions"] = "Permisos de control";
$l_users["log_permissions"] = "Permisos de conexi�n";
$l_users["file_locked"][FILE_TABLE] = "El archivo '%s' es actualmente usado por '%s'!";
$l_users["file_locked"][TEMPLATES_TABLE] = "La plantilla '%s' es actualmente usada por '%s'!";
if(defined("OBJECT_TABLE")){
	$l_users["file_locked"][OBJECT_TABLE] = "La clase '%s' es actualmente usada por '%s'!";
	$l_users["file_locked"][OBJECT_FILES_TABLE] = "El objeto '%s' es actualmente usado por '%s'!";
}
$l_users["acces_temp_denied"] = "Acceso denegado temporalmente";  
$l_users["description"] = "Descripci�n";
$l_users["group_data"] = "Data de grupo";
$l_users["group_name"] = "Nombre de grupo";
$l_users["group_member"] = "Membres�a de grupo";
$l_users["group"] = "Grupo";
$l_users["address"] = "Direcci�n";
$l_users["houseno"] = "N�mero de casa/apartamento";
$l_users["state"] = "Estado";
$l_users["PLZ"] = "C�digo Postal";
$l_users["city"] = "Ciudad";
$l_users["country"] = "Pais";
$l_users["tel_pre"] = "C�digo telef�nico del �rea";
$l_users["fax_pre"] = "C�digo de fax del �rea";
$l_users["telephone"] = "Tel�fono";
$l_users["fax"] = "Fax"; // TRANSLATE
$l_users["mobile"] = "Celular";
$l_users["email"] = "E-Mail"; // TRANSLATE
$l_users["general_data"] = "Data general";
$l_users["workspace_documents"] = "Documentos del �rea de trabajo";
$l_users["workspace_templates"] = "Plantillas del �rea de trabajo";
$l_users["workspace_objects"] = "Workspace Objects"; // TRANSLATE
$l_users["save_changed_user"] = "El usuario fue cambiado.\\nDesea UD salvar sus cambios?";
$l_users["not_able_to_save"] = " El data no ha sido salvado por la invalidez del data!";
$l_users["cannot_save_used"] = " El status no puede ser cambiado porque est� en proceso!";
$l_users["geaendert_von"] = "Cambiado por";
$l_users["geaendert_am"] = "Cambiado en";
$l_users["angelegt_am"] = " Establecido en";
$l_users["angelegt_von"] = "Establecido por";
$l_users["status"] = "Estatus";
$l_users["value"] = " Valor ";
$l_users["gesperrt"] = "restringido";
$l_users["freigegeben"] = "abrir";
$l_users["gel�scht"] = "borrado";
$l_users["ohne"] = "sin";
$l_users["user"] = "Usuario";
$l_users["usertyp"] = "Tipo de usuario";
$l_users["serach_results"] = "Resultados de la b�squeda";
$l_users["inherit"] = "Heredar permisos desde el grupo primario";
$l_users["inherit_ws"] = "Heredar �rea de trabajo de documentos desde el grupo primario";
$l_users["inherit_wst"] = "Heredar �rea de trabajo de plantillas desde el grupo primario";
$l_users["inherit_wso"] = "Inherit objects workspace from parent group"; // TRANSLATE
$l_users["organization"] = "Organizaci�n";
$l_users["give_org_name"] = "Nombre de la organizaci�n";
$l_users["can_not_create_org"] = "La organizaci�n no puede ser creada";
$l_users["org_name_empty"] = "El nombre de la organizaci�n est� vac�o";
$l_users["salutation"] = "Saludo";
$l_users["sucheleer"] = "La palabra de b�squeda est� vac�a.";
$l_users["alias_data"] = "Data del alias";
$l_users["rights_and_workspaces"] = "Permisos y<br>�reas de trabajo";
$l_users["workspace_navigations"] = "Workspave Navigation"; // TRANSLATE
$l_users["inherit_wsn"] = "Inherit navigation workspaces from parent group"; // TRANSLATE
$l_users["workspaceFieldError"] = "ERROR: Invalid workspace entry!";
$l_users["noGroupError"] = "Error: Invalid entry in field group!";

?>