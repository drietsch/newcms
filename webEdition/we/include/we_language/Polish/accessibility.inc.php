<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Sprawdzanie online poprawno�ci tego dokumentu.';

//  variables for checking html files.
$l_validation['description'] = 'Tutaj mo�na skorzysta� z kilku us�ug, dzi�ki kt�rym mo�na sprawdzi� swoj� stron� pod wzgl�dem poprawno�ci czy te� dost�pno�ci.';
$l_validation['available_services'] = 'Wprowadzone us�ugi';
$l_validation['category'] = 'Kategorie';
$l_validation['service_name'] = 'Nazwa us�ugi';
$l_validation['service'] = 'Us�uga';
$l_validation['host'] = 'Host'; // TRANSLATE
$l_validation['path'] = '�cie�ka';
$l_validation['ctype'] = 'Typ pliku';
$l_validation['desc']['ctype'] = 'Identyfikator dla serwera stwierdzaj�cy o jaki typ dokumentu chodzi. (tekst/html lub tekst/css)';
$l_validation['fileEndings'] = 'Zmiany pliku';
$l_validation['desc']['fileEndings'] = 'Tutaj mog� zosta� wprowadzone zmiany pliku dla tej us�ugi. (.html,.css)';
$l_validation['method'] = 'Metoda';
$l_validation['checkvia']  = 'Wys�a� przez';
$l_validation['checkvia_upload'] = 'Upload pliku';
$l_validation['checkvia_url'] = 'podanie linku URL';
$l_validation['varname'] = 'Nazwa zmiennej';
$l_validation['desc']['varname']  = '(Nazwa pliku HTML/ poda� URL)';
$l_validation['additionalVars'] = 'Parametr dodatkowy';
$l_validation['desc']['additionalVars']  = 'opcjonalnie: var1=wartosc1&var2=wartosc2&...';
$l_validation['result']  = 'Wynik';
$l_validation['active'] = 'Aktywny';
$l_validation['desc']['active']  = 'Mo�na wy�wietli� us�ugi.';
$l_validation['no_services_available'] = 'Dla tego typ pliku nie podano jeszcze �adnych us�ug.';

//  the different predefined services
$l_validation['adjust_service'] = 'Edycja walidacji strony';

$l_validation['art_custom'] = 'Us�ugi zdefiniowane przez u�ytkownika';
$l_validation['art_default'] = 'Domy�lnie ustawione us�ugi';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Linki';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Dost�pno��';


$l_validation['edit_service']['new'] = 'Nowa us�uga';
$l_validation['edit_service']['saved_success'] = 'Us�uga zosta�a zapisana.';
$l_validation['edit_service']['saved_failure'] = 'Us�uga nie mog�a zosta� zapisana.';
$l_validation['edit_service']['delete_success'] = 'Us�uga zosta�a usuni�ta.';
$l_validation['edit_service']['delete_failure'] = 'Us�uga nie mog�a zosta� usuni�ta.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Walidacja (X)HTML strony poprzez Upload pliku';
$l_validation['service_xhtml_url'] = 'Walidacja (X)HTML strony poprzez podanie linku URL';

//  services for css
$l_validation['service_css_upload'] = 'Walidacja CSS strony poprzez Upload pliku';
$l_validation['service_css_url'] = 'Walidacja CSS strony poprzez podanie linku URL';

$l_validation['connection_problems'] = '<strong>Wyst�pi� b��d podczas ��czenia si� z wybran� us�ug�.</strong><br /><br />Pami�taj: opcj� "podanie linku URL" mo�esz u�y� tylko wtedy, je�eli Twoja instalacja webEdition jest osi�galna z Internetu (czyli spoza Twojej sieci lokalnej). W przypadku instalacji lokalnej (Localhost) nie ma dost�pu do programu z zewn�trz.<br /><br />Przyczyn� problemu mog� te� by� serwery zap�r ogniowych (Firewall) i proxy. Sprawd� pod tym k�tem swoj� konfiguracj�.<br /><br />Odpowied� HTTP: %s';
?>