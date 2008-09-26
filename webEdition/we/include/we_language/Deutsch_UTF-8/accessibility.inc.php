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


$l_validation['headline'] = 'Online-Validierung dieses Dokuments.';

//  variables for checking html files.
$l_validation['description'] = 'Sie können hier einige Dienste des Webs nutzen, um Ihre Seiten nach Validität, bzw. Zugänglichkeit zu testen.';
$l_validation['available_services'] = 'Eingetragene Dienste';
$l_validation['category'] = 'Kategorie';
$l_validation['service_name'] = 'Name des Diensts';
$l_validation['service'] = 'Dienst';
$l_validation['host'] = 'Host';
$l_validation['path'] = 'Pfad';
$l_validation['ctype'] = 'Datei-Typ';
$l_validation['desc']['ctype'] = 'Erkennungsmerkmal für den Zielserver, um was für eine Datei es sich handelt. (text/html oder text/css)';
$l_validation['fileEndings'] = 'Datei-Endungen';
$l_validation['desc']['fileEndings'] = 'Dateiendungen für den dieser Service benutzt werden soll, können hier eingetragen werden. (.html,.css)';
$l_validation['method'] = 'Methode';
$l_validation['checkvia']  = 'Verschicken per';
$l_validation['checkvia_upload'] = 'Datei-Upload';
$l_validation['checkvia_url'] = 'URL-Übergabe';
$l_validation['varname'] = 'Variablenname';
$l_validation['desc']['varname']  = '(Name des HTML-Eingabefelds der Datei/ URL eintragen)';
$l_validation['additionalVars'] = 'Zusatz-Parameter';
$l_validation['desc']['additionalVars']  = 'optional: var1=wert1&var2=wert2&...';
$l_validation['active'] = 'Aktiv';
$l_validation['desc']['active']  = 'Sie können Dienste zeitweise ausblenden.';
$l_validation['result']  = 'Ergebnis';
$l_validation['no_services_available'] = 'Für diesen Dateityp sind noch keine Dienste eingetragen.';


//  the different predefined services
$l_validation['adjust_service'] = 'Validierungsdienste bearbeiten';

$l_validation['art_custom'] = 'Benutzerdefinierte Dienste';
$l_validation['art_default'] = 'Voreingestellte Dienste';

$l_validation['category_xhtml'] = '(X)HTML';
$l_validation['category_links'] = 'Links';
$l_validation['category_css'] = 'Cascading Style Sheets';
$l_validation['category_accessibility'] = 'Zugänglichkeit';


$l_validation['edit_service']['new'] = 'Neuer Dienst';
$l_validation['edit_service']['saved_success'] = 'Der Dienst wurde gespeichert.';
$l_validation['edit_service']['saved_failure'] = 'Der Dienst konnte nicht gespeichert werden.';
$l_validation['edit_service']['servicename_already_exists'] = 'Ein Dienst mit diesem Namen existiert bereits.';
$l_validation['edit_service']['delete_success'] = 'Der Dienst wurde erfolgreich gelöscht.';
$l_validation['edit_service']['delete_failure'] = 'Der Dienst konnte nicht gelöscht werden.';


//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML Validierung des W3C per Datei-Upload';
$l_validation['service_xhtml_url'] = '(X)HTML Validierung des W3C per URL-Übergabe';

//  services for css
$l_validation['service_css_upload'] = 'CSS Validierung per Datei-Upload';
$l_validation['service_css_url'] = 'CSS Validierung per URL-Übergabe';

$l_validation['connection_problems'] = '<strong>Bei der Verbindung zu dem gewählten Dienst ist ein Fehler aufgetreten.</strong><br /><br />Bitte beachten Sie: Die Option "URL-Übergabe" kann nur verwendet werden, wenn Ihre webEdition-Installation vom Internet (also auch ausserhalb ihres lokalen Netzwerks) aus zu erreichen ist. Dies ist nicht der Fall bei einer lokalen Installation (Localhost).<br /><br />Ebenso können Probleme mit Firewalls und Proxy-Servern auftreten. Überprüfen Sie in diesen Fällen bitte Ihre Konfiguration.<br /><br />HTTP-Antwort: %s';
?>