<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Validaci�n en l�nea de este documento';

//  variables for checking html files.
$l_validation['description'] = 'Puedes seleccionar un servicio de la web para chequear la validez/accesibilidad de este documento';
$l_validation['available_services'] = 'Servicios Existentes';
$l_validation['category'] = 'Categor�a';
$l_validation['service_name'] = 'Nombre del servicio';
$l_validation['service'] = 'Servicio';
$l_validation['host'] = 'Host'; // TRANSLATE
$l_validation['path'] = 'Path'; // TRANSLATE
$l_validation['ctype'] = 'Tipo del Contenido';
$l_validation['desc']['ctype'] = 'Caracter�stica para el servidor destino para determinar el tipo del archivo enviado (texto/html o texto/css)';
$l_validation['fileEndings'] = 'Extensiones';
$l_validation['desc']['fileEndings'] = 'Insertar todas las extensiones que deben estar disponibles para este servicio. (.html,.css)';
$l_validation['method'] = 'M�todo';
$l_validation['checkvia']  = 'V�a del env�o';
$l_validation['checkvia_upload'] = 'Subir archivo';
$l_validation['checkvia_url'] = 'Transferir URL';
$l_validation['varname'] = 'Nombre de la variable';
$l_validation['desc']['varname']  = 'Insertar nombre del identificador de campo del archivo/URL';
$l_validation['additionalVars'] = 'Par�metros adicionales';
$l_validation['desc']['additionalVars']  = 'Opcional: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Resultado';
$l_validation['active'] = 'Activo';
$l_validation['desc']['active']  = 'Aqu� puedes ocultar un servicio temporalmente';
$l_validation['no_services_available'] = 'No existen servicios disponibles para este tipo de archivo a�n.';

//  the different predefined services
$l_validation['adjust_service'] = 'Ajustar el servicio de validaci�n';

$l_validation['art_custom'] = 'Servicios personalizados';
$l_validation['art_default'] = 'Servicios predefinidos';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'V�nculo';
$l_validation['category_css'] = 'Hojas en Estilo de Cascada';
$l_validation['category_accessibility'] = 'Accessibilidad';


$l_validation['edit_service']['new'] = 'Nuevo servicio';
$l_validation['edit_service']['saved_success'] = 'El servicio fue guardado.';
$l_validation['edit_service']['saved_failure'] = 'El servicio no pudo ser guardado.';
$l_validation['edit_service']['delete_success'] = 'El servicio fue eliminado.';
$l_validation['edit_service']['delete_failure'] = 'El servicio no pudo ser eliminado.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Validaci�n (X)HTML de W3C por la v�a de subida de archivos';
$l_validation['service_xhtml_url'] = 'Validaci�n (X)HTML de W3C por la v�a de transferencia URL';

//  services for css
$l_validation['service_css_upload'] = 'Validaci�n del CSS por la v�a de subida de archivos';
$l_validation['service_css_url'] = 'Validaci�n del CSS por la v�a de transferencia URL';

$l_validation['connection_problems'] = '<strong>Ha ocurrido un error mientras se conectaba a este servicio</strong><br /><br />Por favor notar: La opci�n "transferencia URL" est� solamente disponible si su instalaci�n de WebEdition est� tambi�n accesible desde internet (fuera de su red local). Esto no es posible si WebEdition esta instalado localmente (servidor local).<br /><br />Tambi�n, algunos problemas pueden ocurrir cuando se usan firewalls y servidores proxy. Por favor chequee su configuraci�n en estos casos.<br /><br />HTTP responso: %s';
?>