<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


$l_validation['headline'] = 'Sprawdzanie online poprawno¶ci tego dokumentu.';

//  variables for checking html files.
$l_validation['description'] = 'Tutaj mo¿na skorzystaæ z kilku us³ug, dziêki którym mo¿na sprawdziæ swoj± stronê pod wzglêdem poprawno¶ci czy te¿ dostêpno¶ci.';
$l_validation['available_services'] = 'Wprowadzone us³ugi';
$l_validation['category'] = 'Kategorie';
$l_validation['service_name'] = 'Nazwa us³ugi';
$l_validation['service'] = 'Us³uga';
$l_validation['host'] = 'Host'; // TRANSLATE
$l_validation['path'] = '¦cie¿ka';
$l_validation['ctype'] = 'Typ pliku';
$l_validation['desc']['ctype'] = 'Identyfikator dla serwera stwierdzaj±cy o jaki typ dokumentu chodzi. (tekst/html lub tekst/css)';
$l_validation['fileEndings'] = 'Zmiany pliku';
$l_validation['desc']['fileEndings'] = 'Tutaj mog± zostaæ wprowadzone zmiany pliku dla tej us³ugi. (.html,.css)';
$l_validation['method'] = 'Metoda';
$l_validation['checkvia']  = 'Wys³aæ przez';
$l_validation['checkvia_upload'] = 'Upload pliku';
$l_validation['checkvia_url'] = 'podanie linku URL';
$l_validation['varname'] = 'Nazwa zmiennej';
$l_validation['desc']['varname']  = '(Nazwa pliku HTML/ podaæ URL)';
$l_validation['additionalVars'] = 'Parametr dodatkowy';
$l_validation['desc']['additionalVars']  = 'opcjonalnie: var1=wartosc1&var2=wartosc2&...';
$l_validation['result']  = 'Wynik';
$l_validation['active'] = 'Aktywny';
$l_validation['desc']['active']  = 'Mo¿na wy¶wietliæ us³ugi.';
$l_validation['no_services_available'] = 'Dla tego typ pliku nie podano jeszcze ¿adnych us³ug.';

//  the different predefined services
$l_validation['adjust_service'] = 'Edycja walidacji strony';

$l_validation['art_custom'] = 'Us³ugi zdefiniowane przez u¿ytkownika';
$l_validation['art_default'] = 'Domy¶lnie ustawione us³ugi';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Linki';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Dostêpno¶æ';


$l_validation['edit_service']['new'] = 'Nowa us³uga';
$l_validation['edit_service']['saved_success'] = 'Us³uga zosta³a zapisana.';
$l_validation['edit_service']['saved_failure'] = 'Us³uga nie mog³a zostaæ zapisana.';
$l_validation['edit_service']['delete_success'] = 'Us³uga zosta³a usuniêta.';
$l_validation['edit_service']['delete_failure'] = 'Us³uga nie mog³a zostaæ usuniêta.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Walidacja (X)HTML strony poprzez Upload pliku';
$l_validation['service_xhtml_url'] = 'Walidacja (X)HTML strony poprzez podanie linku URL';

//  services for css
$l_validation['service_css_upload'] = 'Walidacja CSS strony poprzez Upload pliku';
$l_validation['service_css_url'] = 'Walidacja CSS strony poprzez podanie linku URL';

$l_validation['connection_problems'] = '<strong>Wyst¹pi³ b³¹d podczas ³¹czenia siê z wybran¹ us³ug¹.</strong><br /><br />Pamiêtaj: opcjê "podanie linku URL" mo¿esz u¿yæ tylko wtedy, je¿eli Twoja instalacja webEdition jest osi¹galna z Internetu (czyli spoza Twojej sieci lokalnej). W przypadku instalacji lokalnej (Localhost) nie ma dostêpu do programu z zewn¹trz.<br /><br />Przyczyn¹ problemu mog¹ te¿ byæ serwery zapór ogniowych (Firewall) i proxy. SprawdŸ pod tym k¹tem swoj¹ konfiguracjê.<br /><br />OdpowiedŸ HTTP: %s';
?>