<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Online valideren van dit document';

//  variables for checking html files.
$l_validation['description'] = 'U kunt een internet-dienst kiezen om dit document te testen op geldigheid/toegankelijkheid.';
$l_validation['available_services'] = 'Bestaande diensten';
$l_validation['category'] = 'Categorie';
$l_validation['service_name'] = 'Naam van de dienst';
$l_validation['service'] = 'Dienst';
$l_validation['host'] = 'Host';
$l_validation['path'] = 'Pad';
$l_validation['ctype'] = 'Soort inhoud';
$l_validation['desc']['ctype'] = 'Kenmerk voor de doel server bij het bepalen van het soort aangeboden bestand (tekst/html of tekst/css)';
$l_validation['fileEndings'] = 'Extensies';
$l_validation['desc']['fileEndings'] = 'Voeg alle extensies toe die beschikbaar zijn voor deze dienst. (.html,.css)';
$l_validation['method'] = 'Methode';
$l_validation['checkvia']  = 'Aanbieden via';
$l_validation['checkvia_upload'] = 'Bestandsupload';
$l_validation['checkvia_url'] = 'URL overdracht';
$l_validation['varname'] = 'Variable naam';
$l_validation['desc']['varname']  = 'Voer de veldnaam in van het bestand/url';
$l_validation['additionalVars'] = 'Bijkomende Parameters';
$l_validation['desc']['additionalVars']  = 'optioneel: var1=wert1&var2=wert2&...';
$l_validation['result']  = 'Resultaat';
$l_validation['active'] = 'Actief';
$l_validation['desc']['active']  = 'Hier kunt u een dienst tijdelijk verbergen.';
$l_validation['no_services_available'] = 'Er zijn nog geen diensten beschikbaar voor dit bestandstype.';

//  the different predefined services
$l_validation['adjust_service'] = 'Stel validatie dienst in';

$l_validation['art_custom'] = 'Vrije diensten';
$l_validation['art_default'] = 'Vooraf gedefinieerde diensten';

$l_validation['category_xhtml'] = '(X)HTML';
$l_validation['category_links'] = 'Koppelingen';
$l_validation['category_css'] = 'Cascading Style Sheets';
$l_validation['category_accessibility'] = 'Toegankelijkheid';


$l_validation['edit_service']['new'] = 'Nieuwe dienst';
$l_validation['edit_service']['saved_success'] = 'De dienst is bewaard.';
$l_validation['edit_service']['saved_failure'] = 'De dienst kon niet bewaard worden.';
$l_validation['edit_service']['delete_success'] = 'De dienst is verwijderd.';
$l_validation['edit_service']['delete_failure'] = 'De dienst kon niet verwijderd worden.';
$l_validation['edit_service']['servicename_already_exists'] = 'Er bestaat al een dienst met deze naam.';

//  services for html
$l_validation['service_xhtml_upload'] = '(X)HTML W3C valideren via bestandsupload';
$l_validation['service_xhtml_url'] = '(X)HTML W3C valideren via url overdracht';

//  services for css
$l_validation['service_css_upload'] = 'CSS valideren via bestandsupload';
$l_validation['service_css_url'] = 'CSS valideren via url overdracht';

$l_validation['connection_problems'] = '<strong>Er is een fout opgetreden tijdens het verbinden met deze dienst</strong><br /><br />Let op: De optie "url overdracht" is alleen beschikbaar als uw webEdition installatie ook bereikbaar is via het internet (buiten uw lokale netwerk). Dit is niet mogelijk wanneer webEdition lokaal is geïnstalleerd (localhost).<br /><br />Ook kunnen er problemen optreden wanneer u Firewalls en proxy-servers gebruikt. Controleer uw configuratie als dit het geval is.<br /><br />HTTP-Reactie: %s';
?>