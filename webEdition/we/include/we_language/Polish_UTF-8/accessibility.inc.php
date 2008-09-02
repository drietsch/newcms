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


$l_validation['headline'] = 'Sprawdzanie online poprawności tego dokumentu.';

//  variables for checking html files.
$l_validation['description'] = 'Tutaj można skorzystać z kilku usług, dzięki którym można sprawdzić swoją stronę pod względem poprawności czy też dostępności.';
$l_validation['available_services'] = 'Wprowadzone usługi';
$l_validation['category'] = 'Kategorie';
$l_validation['service_name'] = 'Nazwa usługi';
$l_validation['service'] = 'Usługa';
$l_validation['host'] = 'Host'; // TRANSLATE
$l_validation['path'] = 'Ścieżka';
$l_validation['ctype'] = 'Typ pliku';
$l_validation['desc']['ctype'] = 'Identyfikator dla serwera stwierdzający o jaki typ dokumentu chodzi. (tekst/html lub tekst/css)';
$l_validation['fileEndings'] = 'Zmiany pliku';
$l_validation['desc']['fileEndings'] = 'Tutaj mogą zostać wprowadzone zmiany pliku dla tej usługi. (.html,.css)';
$l_validation['method'] = 'Metoda';
$l_validation['checkvia']  = 'Wysłać przez';
$l_validation['checkvia_upload'] = 'Upload pliku';
$l_validation['checkvia_url'] = 'podanie linku URL';
$l_validation['varname'] = 'Nazwa zmiennej';
$l_validation['desc']['varname']  = '(Nazwa pliku HTML/ podać URL)';
$l_validation['additionalVars'] = 'Parametr dodatkowy';
$l_validation['desc']['additionalVars']  = 'opcjonalnie: var1=wartosc1&var2=wartosc2&...';
$l_validation['result']  = 'Wynik';
$l_validation['active'] = 'Aktywny';
$l_validation['desc']['active']  = 'Można wyświetlić usługi.';
$l_validation['no_services_available'] = 'Dla tego typ pliku nie podano jeszcze żadnych usług.';

//  the different predefined services
$l_validation['adjust_service'] = 'Edycja walidacji strony';

$l_validation['art_custom'] = 'Usługi zdefiniowane przez użytkownika';
$l_validation['art_default'] = 'Domyślnie ustawione usługi';

$l_validation['category_xhtml'] = '(X)HTML'; // TRANSLATE
$l_validation['category_links'] = 'Linki';
$l_validation['category_css'] = 'Cascading Style Sheets'; // TRANSLATE
$l_validation['category_accessibility'] = 'Dostępność';


$l_validation['edit_service']['new'] = 'Nowa usługa';
$l_validation['edit_service']['saved_success'] = 'Usługa została zapisana.';
$l_validation['edit_service']['saved_failure'] = 'Usługa nie mogła zostać zapisana.';
$l_validation['edit_service']['delete_success'] = 'Usługa została usunięta.';
$l_validation['edit_service']['delete_failure'] = 'Usługa nie mogła zostać usunięta.';
$l_validation['edit_service']['servicename_already_exists'] = 'A service with this name already exists.'; // TRANSLATE

//  services for html
$l_validation['service_xhtml_upload'] = 'Walidacja (X)HTML strony poprzez Upload pliku';
$l_validation['service_xhtml_url'] = 'Walidacja (X)HTML strony poprzez podanie linku URL';

//  services for css
$l_validation['service_css_upload'] = 'Walidacja CSS strony poprzez Upload pliku';
$l_validation['service_css_url'] = 'Walidacja CSS strony poprzez podanie linku URL';

$l_validation['connection_problems'] = '<strong>Wystšpił błšd podczas łšczenia się z wybranš usługš.</strong><br /><br />Pamiętaj: opcję "podanie linku URL" możesz użyć tylko wtedy, jeżeli Twoja instalacja webEdition jest osišgalna z Internetu (czyli spoza Twojej sieci lokalnej). W przypadku instalacji lokalnej (Localhost) nie ma dostępu do programu z zewnštrz.<br /><br />Przyczynš problemu mogš też być serwery zapór ogniowych (Firewall) i proxy. Sprawd pod tym kštem swojš konfigurację.<br /><br />Odpowied HTTP: %s';
?>