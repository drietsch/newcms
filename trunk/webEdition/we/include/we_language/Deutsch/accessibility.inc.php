<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Online-Validierung dieses Dokuments.';

//  variables for checking html files.
$l_validation['description'] = 'Sie k�nnen hier einige Dienste des Webs nutzen, um Ihre Seiten nach Validit�t, bzw. Zug�nglichkeit zu testen.';
$l_validation['available_services'] = 'Eingetragene Dienste';
$l_validation['category'] = 'Kategorie';
$l_validation['service_name'] = 'Name des Diensts';
$l_validation['service'] = 'Dienst';
$l_validation['host'] = 'Host';
$l_validation['path'] = 'Pfad';
$l_validation['ctype'] = 'Datei-Typ';
$l_validation['desc']['ctype'] = 'Erkennungsmerkmal f�r den Zielserver, um was f�r eine Datei es sich handelt. (text/html oder text/css)';
$l_validation['fileEndings'] = 'Datei-Endungen';
$l_validation['desc']['fileEndings'] = 'Dateiendungen f�r den dieser Service benutzt werden soll, k�nnen hier eingetragen werden. (.html,.css)';
$l_validation['method'] = 'Methode';
$l_validation['checkvia']  = 'Verschicken per';
$l_validation['checkvia_upload'] = 'Datei-Upload';
$l_validation['checkvia_url'] = 'URL-�bergabe';
$l_validation['varname'] = 'Variablenname';
$l_validation['desc']['varname']  = '(Name des HTML-Eingabefelds der Datei/ URL eintragen)';
$l_validation['additionalVars'] = 'Zusatz-Parameter';
$l_validation['desc']['additionalVars']  = 'optional: var1=wert1&var2=wert2&...';
$l_validation['active'] = 'Aktiv';
$l_validation['desc']['active']  = 'Sie k�nnen Dienste zeitweise ausblenden.';
$l_validation['result']  = 'Ergebnis';
$l_validation['no_services_available'] = 'F�r diesen Dateityp sind noch keine Dienste eingetragen.';


//  the different predefined services
$l_validation['adjust_service'] = 'Validierungsdienste bearbeiten';

$l_validation['art_custom'] = 'Benutzerdefinierte Dienste';
$l_validation['art_default'] = 'Voreingestellte Dienste';

$l_validation['category_xhtml'] = '(X)HTML';
$l_validation['category_links'] = 'Links';
$l_validation['category_css'] = 'Cascading Style Sheets';
$l_validation['category_accessibility'] = 'Zug�nglichkeit';


$l_validation['edit_service']['new'] = 'Neuer Dienst';
$l_validation['edit_service']['saved_success'] = 'Der Dienst wurde gespeichert.';
$l_validation['edit_service']['saved_failure'] = 'Der Dienst konnte nicht gespeichert werden.';
$l_validation['edit_service']['servicename_already_exists'] = 'Ein Dienst mit diesem Namen existiert bereits.';
$l_validation['edit_service']['delete_success'] = 'Der Dienst wurde erfolgreich gel�scht.';
$l_validation['edit_service']['delete_failure'] = 'Der Dienst konnte nicht gel�scht werden.';


//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML Validierung des W3C per Datei-Upload';
$l_validation['service_xhtml_url'] = '(X)HTML Validierung des W3C per URL-�bergabe';

//  services for css
$l_validation['service_css_upload'] = 'CSS Validierung per Datei-Upload';
$l_validation['service_css_url'] = 'CSS Validierung per URL-�bergabe';

$l_validation['connection_problems'] = '<strong>Bei der Verbindung zu dem gew�hlten Dienst ist ein Fehler aufgetreten.</strong><br /><br />Bitte beachten Sie: Die Option "URL-�bergabe" kann nur verwendet werden, wenn Ihre webEdition-Installation vom Internet (also auch ausserhalb ihres lokalen Netzwerks) aus zu erreichen ist. Dies ist nicht der Fall bei einer lokalen Installation (Localhost).<br /><br />Ebenso k�nnen Probleme mit Firewalls und Proxy-Servern auftreten. �berpr�fen Sie in diesen F�llen bitte Ihre Konfiguration.<br /><br />HTTP-Antwort: %s';
?>