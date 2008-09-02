<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


$l_validation['headline'] = 'Validación en línea de este documento';

//  variables for checking html files.
$l_validation['description'] = 'Puedes seleccionar un servicio de la web para chequear la validez/accesibilidad de este documento';
$l_validation['available_services'] = 'Servicios Existentes';
$l_validation['category'] = 'Categoría';
$l_validation['service_name'] = 'Nombre del servicio';
$l_validation['service'] = 'Servicio';
$l_validation['host'] = 'Host'; // TRANSLATE
$l_validation['path'] = 'Path'; // TRANSLATE
$l_validation['ctype'] = 'Tipo del Contenido';
$l_validation['desc']['ctype'] = 'Característica para el servidor destino para determinar el tipo del archivo enviado (texto/html o texto/css)';
$l_validation['fileEndings'] = 'Extensiones';
$l_validation['desc']['fileEndings'] = 'Insertar todas las extensiones que deben estar disponibles para este servicio. (.html,.css)';
$l_validation['method'] = 'Método';
$l_validation['checkvia']  = 'Vía del envío';
$l_validation['checkvia_upload'] = 'Subir archivo';
$l_validation['checkvia_url'] = 'Transferir URL';
$l_validation['varname'] = 'Nombre de la variable';
$l_validation['desc']['varname']  = 'Insertar nombre del identificador de campo del archivo/URL';
$l_validation['additionalVars'] = 'Parámetros adicionales';
$l_validation['desc']['additionalVars']  = 'Opcional: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Resultado';
$l_validation['active'] = 'Activo';
$l_validation['desc']['active']  = 'Aquí puedes ocultar un servicio temporalmente';
$l_validation['no_services_available'] = 'No existen servicios disponibles para este tipo de archivo aún.';

//  the different predefined services
$l_validation['adjust_service'] = 'Ajustar el servicio de validación';

$l_validation['art_custom'] = 'Servicios personalizados';
$l_validation['art_default'] = 'Servicios predefinidos';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Vínculo';
$l_validation['category_css'] = 'Hojas en Estilo de Cascada';
$l_validation['category_accessibility'] = 'Accessibilidad';


$l_validation['edit_service']['new'] = 'Nuevo servicio';
$l_validation['edit_service']['saved_success'] = 'El servicio fue guardado.';
$l_validation['edit_service']['saved_failure'] = 'El servicio no pudo ser guardado.';
$l_validation['edit_service']['delete_success'] = 'El servicio fue eliminado.';
$l_validation['edit_service']['delete_failure'] = 'El servicio no pudo ser eliminado.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Validación (X)HTML de W3C por la vía de subida de archivos';
$l_validation['service_xhtml_url'] = 'Validación (X)HTML de W3C por la vía de transferencia URL';

//  services for css
$l_validation['service_css_upload'] = 'Validación del CSS por la vía de subida de archivos';
$l_validation['service_css_url'] = 'Validación del CSS por la vía de transferencia URL';

$l_validation['connection_problems'] = '<strong>Ha ocurrido un error mientras se conectaba a este servicio</strong><br /><br />Por favor notar: La opción "transferencia URL" está solamente disponible si su instalación de WebEdition está también accesible desde internet (fuera de su red local). Esto no es posible si WebEdition esta instalado localmente (servidor local).<br /><br />También, algunos problemas pueden ocurrir cuando se usan firewalls y servidores proxy. Por favor chequee su configuración en estos casos.<br /><br />HTTP responso: %s';
?>