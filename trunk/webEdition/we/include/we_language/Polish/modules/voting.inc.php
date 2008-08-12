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
$l_voting['delete_alert'] = 'Usu� aktualn� ankiet�/grup�.\\n Jeste� pewien?';
$l_voting['nothing_to_delete'] = 'Brak obiektu do usuni�cia!';
$l_voting['nothing_to_save'] = 'Brak obiektu do zapami�tania';
$l_voting['we_filename_notValid'] = 'Nieprawid�owa nazwa u�ytkownika!\\nDopuszczalne s� znaki alfanumeryczne, wielkie i ma�e litery oraz znak podkre�lenia, my�lnik, kropka i spacja (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nowy';
$l_voting['menu_save'] = 'Zapisz';
$l_voting['menu_delete'] = 'Usu�';
$l_voting['menu_exit'] = 'Zako�cz';
$l_voting['menu_info'] = 'Informacje';
$l_voting['menu_help'] = 'Pomoc';
$l_voting['headline'] = 'Imiona i nazwiska';


$l_voting['headline_name'] = 'Nazwisko';
$l_voting['headline_publish_date'] = 'Data ustawienia';
$l_voting['headline_data'] = 'Dane ankiety';

$l_voting['publish_date'] = 'Data';
$l_voting['publish_format'] = 'Format'; // TRANSLATE

$l_voting['published_on'] = 'Opublikowano dn.';
$l_voting['total_voting'] = '��czna liczba g�os�w';
$l_voting['reset_scores'] = 'Przywr�� liczenie punkt�w';

$l_voting['inquiry_question'] = 'Pytanie';
$l_voting['inquiry_answers'] = 'Odpowiedzi';

$l_voting['question_empty'] = 'Pole pytania jest puste. Wype�nij je!';
$l_voting['answer_empty'] = 'Jedno lub wi�cej p�l odpowiedzi jest pustych. Podaj odpowied�/odpowiedzi!';

$l_voting['invalid_score'] = 'Warto�� zliczania punkt�w musi by� liczb�; podaj ponownie!';

$l_voting['headline_revote'] = 'G�osuj ponownie';
$l_voting['headline_help'] = 'Pomoc';

$l_voting['inquiry'] = 'Ankieta';

$l_voting['browser_vote'] = 'Z tej przegl�darki nie mo�na ponownie g�osowa� przed up�ywem';
$l_voting['one_hour'] = '1 godziny';
$l_voting['feethteen_minutes'] = '15 minut';
$l_voting['thirthty_minutes'] = '30 minut';
$l_voting['one_day'] = '1 dnia';
$l_voting['never'] = '--nigdy--';
$l_voting['always'] = '--zawsze--';
$l_voting['cookie_method'] = 'Metoda Cookie';
$l_voting['ip_method'] = 'Metoda IP';
$l_voting['time_after_voting_again'] = 'Czas do ponownego g�osowania';
$l_voting['cookie_method_help'] = 'Wykorzystaj t� metod�, je�eli nie chcesz/nie mo�esz korzysta� z metody IP. Pami�taj, �e u�ytkownik mo�e wy��czy� Cookies w przegl�darce. Opcja "Metoda Fallback IP" wymaga wykorzystania znacznik�w we:cookie w szablonie.';
$l_voting['ip_method_help'] = 'Je�eli twoja strona jest dost�pna tylko z intranetu a Twoi u�ytkownicy ��cz� si� bez u�ycia Proxy, u�yj tej metody. Pami�taj, �e niekt�re serwery dynamicznie przydzielaj� adresy IP.';
$l_voting['time_after_voting_again_help'] = 'W celu unikni�cia cz�stego g�osowania przez jednego i tego samego u�ytkownika, wprowad� okres czasu, kt�ry musi up�yn��, zanim z tego komputera b�dzie mo�na ponownie zag�osowa�. W przypadku komputer�w dost�pnych dla wielu u�ytkownik�w jest to najrozs�dniejsze rozwi�zanie. W pozosta�ych przypadkach wybierz "nigdy".';

$l_voting['property'] = 'W�a�ciwo�ci';
$l_voting['variant'] = 'Wersja';
$l_voting['voting'] = 'G�osowanie';
$l_voting['result'] = 'Wynik';
$l_voting['group'] = 'Grupa';
$l_voting['name'] = 'Nazwa';
$l_voting['newFolder'] = 'Nowa grupa';
$l_voting['save_group_ok'] = 'Grupa zosta�a zapami�tana.';
$l_voting['save_ok'] = 'G�osowanie zosta�o zapami�tane.';

$l_voting['path_nok'] = 'Niew�a�ciwa �cie�ka!';
$l_voting['name_empty'] = 'Nazwa nie mo�e by� pusta!';
$l_voting['name_exists'] = 'Nazwa nie istnieje!';
$l_voting['wrongtext'] = 'Nazwa nie jest prawid�owa!';
$l_voting['voting_deleted'] = 'Usuni�to g�osowanie.';
$l_voting['group_deleted'] = 'Usuni�to grup�.';

$l_voting['access'] = 'Dost�p';
$l_voting['limit_access'] = 'Ogranicz dost�p';
$l_voting['limit_access_text'] = 'Dost�p wy��cznie dla nast�pujacych u�ytkownik�w';

$l_voting['variant_limit'] = 'Musi istnie� przynajmniej jedna wersja!';
$l_voting['answer_limit'] = 'Ankieta musi zawiera� przynajmiej dwie odpowiedzi!';

$l_voting['valid_txt'] = 'Nale�y aktywowa� pole wyboru "Aktywne", �eby g�osowanie zosta�o zapami�tane na Twojej stronie, a po up�ywie wa�no�ci zosta�o wycofane. Ustaw za pomoc� menu kontekstowych dat� i czas, w kt�rych ma up�ywa� g�osowanie. Od tego momentu nie b�d� ju� przyjmowane �adne nowe g�osy.';
$l_voting['active_till'] = 'Aktywne';
$l_voting['valid'] = 'Wa�no��';

$l_voting['export'] = 'Eksport';
$l_voting['export_txt'] = 'Eksport danych g�osowania do pliku CSV (Comma Separated Values).';
$l_voting["csv_download"] = "Download CSV file"; // TRANSLATE
$l_voting["csv_export"] = "Plik '%s' zosta� zapisany.";

$l_voting['fallback'] = 'Metoda Fallback IP';
$l_voting['save_user_agent'] = 'Zapisz/por�wnaj dane programu u�ytkownika';
$l_voting['voting_log'] = 'Protoko�uj g�osowanie w logu';
$l_voting['forbid_ip'] = 'Zablokuj kolejny adres IP';
$l_voting['until'] = 'do';
$l_voting['options'] = 'Opcje';
$l_voting['control'] = 'Kontrola';
$l_voting['data_deleted_info'] = 'Dane zosta�y usuni�te!';
$l_voting['time'] = 'Czas';
$l_voting['ip'] = 'IP'; // TRANSLATE
$l_voting['user_agent'] = 'Program u�ytkownika';
$l_voting['cookie'] = 'Cookie'; // TRANSLATE
$l_voting['delete_ipdata_question'] = 'Chcesz wyczy�ci� wszystkie zapamietane dane IP. Na pewno?';
$l_voting['delete_log_question'] = 'Chcesz usun�� wszystkie wpisy do logu g�osowania.Na pewno?';
$l_voting['delete_ipdata_text'] = 'Zapami�tane dane IP zajmuj� %s bajt�w pami�ci. Mo�na je usun�� za pomoc� przyciska  \'Usu�\'. Pami�taj, �e wszystkie zapisane dane IP g�osowania zostan� usuni�te a wyniki ?�osowania nie bed� ju� tak dok�adne, poniewa� mo�liwe jest powt�rzenie g�osowania.';
$l_voting['status'] = 'Status'; // TRANSLATE
$l_voting['log_success'] = 'Sukces';
$l_voting['log_error'] = 'B��d';
$l_voting['log_error_active'] = 'B��d: nieaktywny';
$l_voting['log_error_revote'] = 'B��d: nowe g�osowanie';
$l_voting['log_error_blackip'] = 'B��d: zablokowane IP';
$l_voting['log_is_empty'] = 'Log jest pusty!';
$l_voting['enabled'] = 'W��czony';
$l_voting['disabled'] = 'Wy��czony';
$l_voting['log_fallback'] = 'Fallback'; // TRANSLATE

$l_voting['new_ip_add'] = 'Prosz� poda� nowy adres IP!';
$l_voting['not_valid_ip'] = 'Nieprawid�owy adres IP';
?>