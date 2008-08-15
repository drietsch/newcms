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
$l_voting['delete_alert'] = 'Usuń aktualną ankietę/grupę.\\n Jesteś pewien?';
$l_voting['nothing_to_delete'] = 'Brak obiektu do usunięcia!';
$l_voting['nothing_to_save'] = 'Brak obiektu do zapamiętania';
$l_voting['we_filename_notValid'] = 'Nieprawidłowa nazwa użytkownika!\\nDopuszczalne są znaki alfanumeryczne, wielkie i małe litery oraz znak podkreślenia, myślnik, kropka i spacja (a-z, A-Z, 0-9, _, -, ., )';

$l_voting['menu_new'] = 'Nowy';
$l_voting['menu_save'] = 'Zapisz';
$l_voting['menu_delete'] = 'Usuń';
$l_voting['menu_exit'] = 'Zakończ';
$l_voting['menu_info'] = 'Informacje';
$l_voting['menu_help'] = 'Pomoc';
$l_voting['headline'] = 'Imiona i nazwiska';


$l_voting['headline_name'] = 'Nazwisko';
$l_voting['headline_publish_date'] = 'Data ustawienia';
$l_voting['headline_data'] = 'Dane ankiety';

$l_voting['publish_date'] = 'Data';
$l_voting['publish_format'] = 'Format'; // TRANSLATE

$l_voting['published_on'] = 'Opublikowano dn.';
$l_voting['total_voting'] = 'Łączna liczba głosów';
$l_voting['reset_scores'] = 'Przywróć liczenie punktów';

$l_voting['inquiry_question'] = 'Pytanie';
$l_voting['inquiry_answers'] = 'Odpowiedzi';

$l_voting['question_empty'] = 'Pole pytania jest puste. Wypełnij je!';
$l_voting['answer_empty'] = 'Jedno lub więcej pól odpowiedzi jest pustych. Podaj odpowiedź/odpowiedzi!';

$l_voting['invalid_score'] = 'Wartość zliczania punktów musi być liczbą; podaj ponownie!';

$l_voting['headline_revote'] = 'Głosuj ponownie';
$l_voting['headline_help'] = 'Pomoc';

$l_voting['inquiry'] = 'Ankieta';

$l_voting['browser_vote'] = 'Z tej przeglądarki nie można ponownie głosować przed upływem';
$l_voting['one_hour'] = '1 godziny';
$l_voting['feethteen_minutes'] = '15 minut';
$l_voting['thirthty_minutes'] = '30 minut';
$l_voting['one_day'] = '1 dnia';
$l_voting['never'] = '--nigdy--';
$l_voting['always'] = '--zawsze--';
$l_voting['cookie_method'] = 'Metoda Cookie';
$l_voting['ip_method'] = 'Metoda IP';
$l_voting['time_after_voting_again'] = 'Czas do ponownego głosowania';
$l_voting['cookie_method_help'] = 'Wykorzystaj tą metodę, jeżeli nie chcesz/nie możesz korzystać z metody IP. Pamiętaj, że użytkownik może wyłączyć Cookies w przeglądarce. Opcja "Metoda Fallback IP" wymaga wykorzystania znaczników we:cookie w szablonie.';
$l_voting['ip_method_help'] = 'Jeżeli twoja strona jest dostępna tylko z intranetu a Twoi użytkownicy łączą się bez użycia Proxy, użyj tej metody. Pamiętaj, że niektóre serwery dynamicznie przydzielają adresy IP.';
$l_voting['time_after_voting_again_help'] = 'W celu uniknięcia częstego głosowania przez jednego i tego samego użytkownika, wprowadź okres czasu, który musi upłynąć, zanim z tego komputera będzie można ponownie zagłosować. W przypadku komputerów dostępnych dla wielu użytkowników jest to najrozsądniejsze rozwiązanie. W pozostałych przypadkach wybierz "nigdy".';

$l_voting['property'] = 'Właściwości';
$l_voting['variant'] = 'Wersja';
$l_voting['voting'] = 'Głosowanie';
$l_voting['result'] = 'Wynik';
$l_voting['group'] = 'Grupa';
$l_voting['name'] = 'Nazwa';
$l_voting['newFolder'] = 'Nowa grupa';
$l_voting['save_group_ok'] = 'Grupa została zapamiętana.';
$l_voting['save_ok'] = 'Głosowanie zostało zapamiętane.';

$l_voting['path_nok'] = 'Niewłaściwa ścieżka!';
$l_voting['name_empty'] = 'Nazwa nie może być pusta!';
$l_voting['name_exists'] = 'Nazwa nie istnieje!';
$l_voting['wrongtext'] = 'Nazwa nie jest prawidłowa!';
$l_voting['voting_deleted'] = 'Usunięto głosowanie.';
$l_voting['group_deleted'] = 'Usunięto grupę.';

$l_voting['access'] = 'Dostęp';
$l_voting['limit_access'] = 'Ogranicz dostęp';
$l_voting['limit_access_text'] = 'Dostęp wyłącznie dla następujacych użytkowników';

$l_voting['variant_limit'] = 'Musi istnieć przynajmniej jedna wersja!';
$l_voting['answer_limit'] = 'Ankieta musi zawierać przynajmiej dwie odpowiedzi!';

$l_voting['valid_txt'] = 'Należy aktywować pole wyboru "Aktywne", żeby głosowanie zostało zapamiętane na Twojej stronie, a po upływie ważności zostało wycofane. Ustaw za pomocą menu kontekstowych datę i czas, w których ma upływać głosowanie. Od tego momentu nie będą już przyjmowane żadne nowe głosy.';
$l_voting['active_till'] = 'Aktywne';
$l_voting['valid'] = 'Ważność';

$l_voting['export'] = 'Eksport';
$l_voting['export_txt'] = 'Eksport danych głosowania do pliku CSV (Comma Separated Values).';
$l_voting["csv_download"] = "Download CSV file"; // TRANSLATE
$l_voting["csv_export"] = "Plik '%s' został zapisany.";

$l_voting['fallback'] = 'Metoda Fallback IP';
$l_voting['save_user_agent'] = 'Zapisz/porównaj dane programu użytkownika';
$l_voting['voting_log'] = 'Protokołuj głosowanie w logu';
$l_voting['forbid_ip'] = 'Zablokuj kolejny adres IP';
$l_voting['until'] = 'do';
$l_voting['options'] = 'Opcje';
$l_voting['control'] = 'Kontrola';
$l_voting['data_deleted_info'] = 'Dane zostały usunięte!';
$l_voting['time'] = 'Czas';
$l_voting['ip'] = 'IP'; // TRANSLATE
$l_voting['user_agent'] = 'Program użytkownika';
$l_voting['cookie'] = 'Cookie'; // TRANSLATE
$l_voting['delete_ipdata_question'] = 'Chcesz wyczyścić wszystkie zapamietane dane IP. Na pewno?';
$l_voting['delete_log_question'] = 'Chcesz usunąć wszystkie wpisy do logu głosowania.Na pewno?';
$l_voting['delete_ipdata_text'] = 'Zapamiętane dane IP zajmują %s bajtów pamięci. Można je usunąć za pomocą przyciska  \'Usuń\'. Pamiętaj, że wszystkie zapisane dane IP głosowania zostaną usunięte a wyniki ?łosowania nie bedą już tak dokładne, ponieważ możliwe jest powtórzenie głosowania.';
$l_voting['status'] = 'Status'; // TRANSLATE
$l_voting['log_success'] = 'Sukces';
$l_voting['log_error'] = 'Błąd';
$l_voting['log_error_active'] = 'Błąd: nieaktywny';
$l_voting['log_error_revote'] = 'Błąd: nowe głosowanie';
$l_voting['log_error_blackip'] = 'Błąd: zablokowane IP';
$l_voting['log_is_empty'] = 'Log jest pusty!';
$l_voting['enabled'] = 'Włączony';
$l_voting['disabled'] = 'Wyłączony';
$l_voting['log_fallback'] = 'Fallback'; // TRANSLATE

$l_voting['new_ip_add'] = 'Proszę podać nowy adres IP!';
$l_voting['not_valid_ip'] = 'Nieprawidłowy adres IP';
?>