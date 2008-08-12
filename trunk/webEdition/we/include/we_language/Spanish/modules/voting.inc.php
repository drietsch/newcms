<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2005 living-e AG                   |
// +----------------------------------------------------------------------+
//

$l_voting = array();
$l_voting['no_perms'] = 'You do not have permission to use this option.';
$l_voting['delete_alert'] = 'Eliminar la actual votaci�n/grupo.\\n Esta seguro?';
$l_voting['nothing_to_delete'] = 'No hay nada que eliminar!';
$l_voting['nothing_to_save'] = 'No hay nada que guardar';
$l_voting['we_filename_notValid'] = 'Nombre de usuario inv�lido!\\nLos Caracteres v�lidos son: alfanum�ricos, may�sculas y min�sculas, as� como subrayado, gui�n, punto y espacio en blanco (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nuevo';
$l_voting['menu_save'] = 'Guardar';
$l_voting['menu_delete'] = 'Eliminar';
$l_voting['menu_exit'] = 'Cerrar';
$l_voting['menu_info'] = 'Informaci�n';
$l_voting['menu_help'] = 'Ayuda';
$l_voting['headline'] = 'Nombres y Apellidos';


$l_voting['headline_name'] = 'Nombre';
$l_voting['headline_publish_date'] = 'Crear Fecha';
$l_voting['headline_data'] = 'Solicitar Datos';

$l_voting['publish_date'] = 'Fecha';
$l_voting['publish_format'] = 'Formato';

$l_voting['published_on'] = 'Publicado en';
$l_voting['total_voting'] = 'Votacion Total';
$l_voting['reset_scores'] = 'Restaurar resultado';

$l_voting['inquiry_question'] = 'Pregunta';
$l_voting['inquiry_answers'] = 'Respuestas';

$l_voting['question_empty'] = 'No se ha entrado pregunta, por favor entre una!';
$l_voting['answer_empty'] = 'Una o mas respuestas no se han entrado, por favor, entre respuesta(s)';

$l_voting['invalid_score'] = 'El valor para el resultado debe ser un n�mero, por favor, trate de nuevo!';

$l_voting['headline_revote'] = 'Control de Revoto';
$l_voting['headline_help'] = 'Ayuda';

$l_voting['inquiry'] = 'Pregunta';

$l_voting['browser_vote'] = 'Un navegador no puede votar otra vez antes de';
$l_voting['one_hour'] = '1 hora';
$l_voting['feethteen_minutes'] = '15 min.'; // TRANSLATE
$l_voting['thirthty_minutes'] = '30 min.'; // TRANSLATE
$l_voting['one_day'] = '1 d�a';
$l_voting['never'] = '--nunca--';
$l_voting['always'] = '--siempre--';
$l_voting['cookie_method'] = 'Por M�todo de Coookie';
$l_voting['ip_method'] = 'Por M�todo de IP';
$l_voting['time_after_voting_again'] = 'Tiempo antes de votar otra vez';
$l_voting['cookie_method_help'] = 'Si no puede usar el m�todo de IP seleccione este. Recuerde, algunos usuarios pueden tener las cookies deshabilitadas en sus navegadores.';
$l_voting['ip_method_help'] = 'Si su sitio web tiene solo acceso a Intranet y sus usuarios no se conectan a trav�s de un proxy, seleccione este m�todo. Considere que algunos servidores asignan direcciones IP din�micamente.';
$l_voting['time_after_voting_again_help'] = 'Para evitar que un mismo navegador/IP vote m�s de una vez en forma r�pida y sucesiva, seleccione una intervalo de tiempo apropiado antes del cual no se puede votar desde ese navegador. Si desea que se pueda votar desde un mismo navegador solo una vez, seleccione \"nunca\".';

$l_voting['property'] = 'Propiedades';
$l_voting['variant'] = 'Versi�n';
$l_voting['voting'] = 'Votaci�n';
$l_voting['result'] = 'Resultado';
$l_voting['group'] = 'Grupo';
$l_voting['name'] = 'Nombre';
$l_voting['newFolder'] = 'Nuevo Grupo';
$l_voting['save_group_ok'] = 'El grupo ha sido salvado.';
$l_voting['save_ok'] = 'La votaci�n ha sido salvada.';

$l_voting['path_nok'] = 'El camino es incorrecto!';
$l_voting['name_empty'] = '�El nombre no debe estar vac�o!';
$l_voting['name_exists'] = '�El nombre existe!';
$l_voting['wrongtext'] = '�El nombre no es v�lido!';
$l_voting['voting_deleted'] = 'La votaci�n ha sido exitosamente eliminada.';
$l_voting['group_deleted'] = 'El grupo ha sido exitosamente eliminado.';

$l_voting['access'] = 'Acceso';
$l_voting['limit_access'] = 'Limitar acceso';
$l_voting['limit_access_text'] = 'Permitir acceso a los siguientes grupos';

$l_voting['variant_limit'] = 'Al menos una versi�n debe existir en la encuesta!';
$l_voting['answer_limit'] = 'La encuesta debe consistir de al menos dos respuestas!';

$l_voting['valid_txt'] = 'El checkbox "active" ha de ser activado, as� que la votaci�n en su p�gina es guardada y "parked" al final de su validez. Determine con los men�s desplegables la fecha y la hora a las cuales la votaci�n debe ejecutarse. Ninguna otra votaci�n es aceptada a partir de este momento.';
$l_voting['active_till'] = 'Activo hasta';
$l_voting['valid'] = 'Validez';

$l_voting['export'] = 'Exportar';
$l_voting['export_txt'] = 'Exportar datos de las votaciones a un fichero CSV (valores separados por coma).';
$l_voting["csv_download"] = "Descargar archivo CSV";
$l_voting["csv_export"] = "El archivo '%s' ha sido guardado.";

$l_voting['fallback'] = 'M�todo IP para recuperaci�n de informaci�n perdida';
$l_voting['save_user_agent'] = 'Guardar/Comparar datos del agente-usuario';
$l_voting['voting_log'] = 'Voto de Protocolo';
$l_voting['forbid_ip'] = 'Suspender la siguiente direcci�n de IP';
$l_voting['until'] = 'hasta';
$l_voting['options'] = 'Opciones';
$l_voting['control'] = 'Control'; // TRANSLATE
$l_voting['data_deleted_info'] = '�El dato ha sido eliminado!';
$l_voting['time'] = 'Tiempo';
$l_voting['ip'] = 'IP'; // TRANSLATE
$l_voting['user_agent'] = 'Agente-Usuario';
$l_voting['cookie'] = 'Cookie'; // TRANSLATE
$l_voting['delete_ipdata_question'] = 'Usted quiere eliminar todos los datos de IP guardados. �Est� usted seguro?';
$l_voting['delete_log_question'] = 'Usted quiere eliminar todos los registros de votos entrados. �Est� usted seguro?';
$l_voting['delete_ipdata_text'] = 'Los datos de IP guardados ocupan %s Bytes de la memoria. Elim�nelos usando el bot�n \Borrar\'. Por favor considere que toda la informaci�n de IP guardada ser� eliminada y por consiguiente los votos iterativos ser�n posibles.';
$l_voting['status'] = 'Estado';
$l_voting['log_success'] = '�xito';
$l_voting['log_error'] = 'Error'; // TRANSLATE
$l_voting['log_error_active'] = 'Error: no activar';
$l_voting['log_error_revote'] = 'Error: nuevo voto';
$l_voting['log_error_blackip'] = 'Error: IP suspendido';
$l_voting['log_is_empty'] = '�El diario est� vac�o!';
$l_voting['enabled'] = 'Activado';
$l_voting['disabled'] = 'Desactivado';
$l_voting['log_fallback'] = 'Recuperar';

$l_voting['new_ip_add'] = '�Por favor introduzca la nuev direcci�n de IP!';
$l_voting['not_valid_ip'] = 'La direcci�n de IP no es v�lida';
?>