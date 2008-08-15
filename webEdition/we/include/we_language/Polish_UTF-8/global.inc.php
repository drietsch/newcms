<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Language file: global.inc.php
 * Provides language strings.
 * Language: English
 */
include_once(dirname(__FILE__)."/enc_".basename(__FILE__));

$GLOBALS["l_global"]["new_link"] = "New Link"; // TRANSLATE // It is important to use the GLOBALS ARRAY because in linklists, the file is included in a function.
$GLOBALS["l_global"]["load_menu_info"] = "Załaduj dane!<br>Przy wielu wpisach w menu może to długo potrwać ...";
$GLOBALS["l_global"]["text"] = "Tekst";
$GLOBALS["l_global"]["yes"] = "tak";
$GLOBALS["l_global"]["no"] = "nie";
$GLOBALS["l_global"]["checked"] = "Aktywny";
$GLOBALS["l_global"]["max_file_size"] = "Maks. wielkość pliku (w bajtach)";
$GLOBALS["l_global"]["default"] = "Domyślne";
$GLOBALS["l_global"]["values"] = "Wartość";
$GLOBALS["l_global"]["name"] = "Nazwa";
$GLOBALS["l_global"]["type"] = "Typ";
$GLOBALS["l_global"]["attributes"] = "Atrybut";
$GLOBALS["l_global"]["formmailerror"] = "Formularz nie został wysłany z następującego powodu:";
$GLOBALS["l_global"]["email_notallfields"] = "Nie wypełniłeś wszystkich wymaganych pól!";
$GLOBALS["l_global"]["email_ban"] = "Nie masz uprawnień do korzystania z tego skryptu!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Adres odbiorcy jest nieprawidłowy!";
$GLOBALS["l_global"]["email_no_recipient"] = "Adres odbiorcy nie istnieje!";
$GLOBALS["l_global"]["email_invalid"] = "Twój <b>adres e-mail </b> jest nieprawidłowy!";
$GLOBALS["l_global"]["question"] = "Pytanie";
$GLOBALS["l_global"]["warning"] = "Ostrzeżenie";
$GLOBALS["l_global"]["we_alert"] = "Ta funkcja nie jest dostępna w wersji demonstracyjnej webEdition!";
$GLOBALS["l_global"]["index_table"] = "Tabela indeksu";
$GLOBALS["l_global"]["cannotconnect"] = "Nie można było nawiązać połączenia z serwerem webEdition!";
$GLOBALS["l_global"]["recipients"] = "Odbiorca formularza pocztowego";
$GLOBALS["l_global"]["recipients_txt"] = "Wpisz tutaj wszystkie adresy e-mail, do których może być skierowany formularz za pomocą funkcji formularza pocztowego(&lt;we:form type=&quot;formmail&quot; ..&gt;). Jeżeli nie podanych adresów e-mail, nie można wysyłać formularzy za pomocą formularza poczty!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Stworzono nowy obiekt %s klasy %s!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Nowy obiekt";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Nowy dokument";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Stworzono nowy dokument %s!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Obiekt usunięto";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Obiekt %s został usunięty!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Dokument usunięto";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Dokument %s został usunięty!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Po zapisie nowej strony";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Brak wpisów!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Zapisz ponownie tymczasowe dokumenty robocze";
$GLOBALS["l_global"]["save_mainTable"] = "Zapisz teraz główną tabelę bazy danych";
$GLOBALS["l_global"]["add_workspace"] = "Dodaj obszar roboczy";
$GLOBALS["l_global"]["folder_not_editable"] = "Nie można wybrać tego katalogu!";
$GLOBALS["l_global"]["modules"] = "Moduł";
$GLOBALS["l_global"]["modules_and_tools"] = "Modules and Tools"; // TRANSLATE
$GLOBALS["l_global"]["center"] = "Centruj";
$GLOBALS["l_global"]["jswin"] = "Wyskakujące okno";
$GLOBALS["l_global"]["open"] = "Otwórz";
$GLOBALS["l_global"]["posx"] = "Pozycja x";
$GLOBALS["l_global"]["posy"] = "Pozycja y";
$GLOBALS["l_global"]["status"] = "Status"; // TRANSLATE
$GLOBALS["l_global"]["scrollbars"] = "Scrollbars";
$GLOBALS["l_global"]["menubar"] = "Menubar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Resizable"; // TRANSLATE
$GLOBALS["l_global"]["location"] = "Location"; // TRANSLATE
$GLOBALS["l_global"]["title"] = "Tytuł";
$GLOBALS["l_global"]["description"] = "Opis";
$GLOBALS["l_global"]["required_field"] = "Pole obowiązkowe";
$GLOBALS["l_global"]["from"] = "od";
$GLOBALS["l_global"]["to"] = "do";
$GLOBALS["l_global"]["search"]="Search"; // TRANSLATE
$GLOBALS["l_global"]["in"]="in"; // TRANSLATE
$GLOBALS["l_global"]["we_rebuild_at_save"] = "Automatyczny Rebuild";
$GLOBALS["l_global"]["we_publish_at_save"] = "Opublikuj przy zapisaniu";
$GLOBALS["l_global"]["we_new_folder_after_save"] = "New folder after saving";
$GLOBALS["l_global"]["we_new_entry_after_save"] = "New entry after saving";
$GLOBALS["l_global"]["we_new_doc_after_save"] = "New Document after saving"; // TRANSLATE
$GLOBALS["l_global"]["wrapcheck"] = "Zawijanie komórki";
$GLOBALS["l_global"]["static_docs"] = "Dokumenty statyczne";
$GLOBALS["l_global"]["save_templates_before"] = "Zapisz wcześniej szablony";
$GLOBALS["l_global"]["specify_docs"] = "Dokumenty o następujących kryteriach";
$GLOBALS["l_global"]["object_docs"] = "Wszystkie obiekty";
$GLOBALS["l_global"]["all_docs"] = "Wszystkie dokumenty";
$GLOBALS["l_global"]["ask_for_editor"] = "Zapytaj o oczekiwany edytor";
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Wprowadzenie";
$GLOBALS["l_global"]["doctypes"] = "Typy dokumentu";
$GLOBALS["l_global"]["content"] = "Zawartość";
$GLOBALS["l_global"]["site_not_exist"] = "Ta strona nie istnieje!";
$GLOBALS["l_global"]["site_not_published"] = "Ta strona nie jest jeszcze opublikowana!";
$GLOBALS["l_global"]["required"] = "Wpis obowiązkowy";
$GLOBALS["l_global"]["all_rights_reserved"] = "Wszelkie prawa zastrzeżone";
$GLOBALS["l_global"]["width"] = "Szerokość";
$GLOBALS["l_global"]["height"] = "Wysokość";
$GLOBALS["l_global"]["new_username"] = "Nowa nazwa użytkownika";
$GLOBALS["l_global"]["username"] = "Nazwa użytkownika";
$GLOBALS["l_global"]["password"] = "Hasło";
$GLOBALS["l_global"]["documents"] = "Dokumenty";
$GLOBALS["l_global"]["templates"] = "Szablony";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "Licencjobiorcja";
$GLOBALS["l_global"]["left"] = "lewa";
$GLOBALS["l_global"]["right"] = "prawa";
$GLOBALS["l_global"]["top"] = "góra";
$GLOBALS["l_global"]["bottom"] = "dół";
$GLOBALS["l_global"]["topleft"] = "góra lewa";
$GLOBALS["l_global"]["topright"] = "góra prawa";
$GLOBALS["l_global"]["bottomleft"] = "dół lewa";
$GLOBALS["l_global"]["bottomright"] = "dół prawa";
$GLOBALS["l_global"]["true"] = "tak";
$GLOBALS["l_global"]["false"] = "nie";
$GLOBALS["l_global"]["showall"] = "Pokaż wszystko";
$GLOBALS["l_global"]["noborder"] = "bez marginesu";
$GLOBALS["l_global"]["border"] = "Margines";
$GLOBALS["l_global"]["align"] = "Wyrównanie";
$GLOBALS["l_global"]["hspace"] = "Odstęp poziomy";
$GLOBALS["l_global"]["vspace"] = "Odstęp pionowy";
$GLOBALS["l_global"]["exactfit"] = "dopasuj";
$GLOBALS["l_global"]["select_color"] = "Wybór koloru";
$GLOBALS["l_global"]["changeUsername"] = "Zmień nazwę użytkownika";
$GLOBALS["l_global"]["changePass"] = "Zmień hasło";
$GLOBALS["l_global"]["oldPass"] = "Stare hasło";
$GLOBALS["l_global"]["newPass"] = "Nowe hasło";
$GLOBALS["l_global"]["newPass2"] = "Powtórzenie nowego hasła";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Powtórzenie nowego hasła nie zgadza się z nowym hasłem!";
$GLOBALS["l_global"]["pass_not_match"] = "Stare hasło nie zgadza się!";
$GLOBALS["l_global"]["passwd_not_match"] = "Hasło nie zgadza się!";
$GLOBALS["l_global"]["pass_to_short"] = "Hasło musi się składać z przynajmniej 4 znaków!";
$GLOBALS["l_global"]["pass_changed"] = "Hasło zostało zmienione!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Hasło może zawierać tylko litery (a-z oraz A-Z) i cyfry (0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "Wszystkie";
$GLOBALS["l_global"]["selected"] = "Wybrane";
$GLOBALS["l_global"]["username_to_short"] = "Nazwa użytkownika musi się składać przynajmniej z 4 znaków!";
$GLOBALS["l_global"]["username_changed"] = "Nazwa użytkownika została zmieniona!";
$GLOBALS["l_global"]["published"] = "Opublikowany";
$GLOBALS["l_global"]["help_welcome"] = "Witamy w systemie pomocy webEdition";
$GLOBALS["l_global"]["edit_file"] = "Edytuj dane";
$GLOBALS["l_global"]["docs_saved"] = "Dokumenty zostały zabezpieczone!";
$GLOBALS["l_global"]["preview"] = "Podgląd";
$GLOBALS["l_global"]["close"] = "Zamknij okno";
$GLOBALS["l_global"]["loginok"] =  "<strong>Logowanie powiodło się!</strong><br>webEdition powinien otworzyć się teraz w nowym oknie.<br>Jeżeli tak się nie stało, prawdopodobnie zablokowałeś okna wyskakujące w swojej przeglądarce!";
$GLOBALS["l_global"]["apple"] = "&#x2318;";
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "STRG";
$GLOBALS["l_global"]["required_fields"] = "Pola obowiązkowe";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Nie załadowano jeszcze żadnego dokumentu.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Otwórz-/Zamknij";
$GLOBALS["l_global"]["rebuild"] = "Rebuild"; // TRANSLATE
$GLOBALS["l_global"]["welcome_to_we"] = "Witamy w webEdition 3";
$GLOBALS["l_global"]["tofit"] = "Witamy w webEdition 3";
$GLOBALS["l_global"]["unlocking_document"] = "Zatwierdź dokument";
$GLOBALS["l_global"]["variant_field"] = "Pole wariantów";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
$GLOBALS["l_global"]["untitled"] = "Untitled"; // TRANSLATE
?>