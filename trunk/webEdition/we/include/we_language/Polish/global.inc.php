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
$GLOBALS["l_global"]["load_menu_info"] = "Za³aduj dane!<br>Przy wielu wpisach w menu mo¿e to d³ugo potrwaæ ...";
$GLOBALS["l_global"]["text"] = "Tekst";
$GLOBALS["l_global"]["yes"] = "tak";
$GLOBALS["l_global"]["no"] = "nie";
$GLOBALS["l_global"]["checked"] = "Aktywny";
$GLOBALS["l_global"]["max_file_size"] = "Maks. wielko¶æ pliku (w bajtach)";
$GLOBALS["l_global"]["default"] = "Domy¶lne";
$GLOBALS["l_global"]["values"] = "Warto¶æ";
$GLOBALS["l_global"]["name"] = "Nazwa";
$GLOBALS["l_global"]["type"] = "Typ";
$GLOBALS["l_global"]["attributes"] = "Atrybut";
$GLOBALS["l_global"]["formmailerror"] = "Formularz nie zosta³ wys³any z nastêpuj±cego powodu:";
$GLOBALS["l_global"]["email_notallfields"] = "Nie wype³ni³e¶ wszystkich wymaganych pól!";
$GLOBALS["l_global"]["email_ban"] = "Nie masz uprawnieñ do korzystania z tego skryptu!";
$GLOBALS["l_global"]["email_recipient_invalid"] = "Adres odbiorcy jest nieprawid³owy!";
$GLOBALS["l_global"]["email_no_recipient"] = "Adres odbiorcy nie istnieje!";
$GLOBALS["l_global"]["email_invalid"] = "Twój <b>adres e-mail </b> jest nieprawid³owy!";
$GLOBALS["l_global"]["question"] = "Pytanie";
$GLOBALS["l_global"]["warning"] = "Ostrze¿enie";
$GLOBALS["l_global"]["we_alert"] = "Ta funkcja nie jest dostêpna w wersji demonstracyjnej webEdition!";
$GLOBALS["l_global"]["index_table"] = "Tabela indeksu";
$GLOBALS["l_global"]["cannotconnect"] = "Nie mo¿na by³o nawi±zaæ po³±czenia z serwerem webEdition!";
$GLOBALS["l_global"]["recipients"] = "Odbiorca formularza pocztowego";
$GLOBALS["l_global"]["recipients_txt"] = "Wpisz tutaj wszystkie adresy e-mail, do których mo¿e byæ skierowany formularz za pomoc± funkcji formularza pocztowego(&lt;we:form type=&quot;formmail&quot; ..&gt;). Je¿eli nie podanych adresów e-mail, nie mo¿na wysy³aæ formularzy za pomoc± formularza poczty!";
$GLOBALS["l_global"]["std_mailtext_newObj"] = "Stworzono nowy obiekt %s klasy %s!";
$GLOBALS["l_global"]["std_subject_newObj"] = "Nowy obiekt";
$GLOBALS["l_global"]["std_subject_newDoc"] = "Nowy dokument";
$GLOBALS["l_global"]["std_mailtext_newDoc"] = "Stworzono nowy dokument %s!";
$GLOBALS["l_global"]["std_subject_delObj"] = "Obiekt usuniêto";
$GLOBALS["l_global"]["std_mailtext_delObj"] = "Obiekt %s zosta³ usuniêty!";
$GLOBALS["l_global"]["std_subject_delDoc"] = "Dokument usuniêto";
$GLOBALS["l_global"]["std_mailtext_delDoc"] = "Dokument %s zosta³ usuniêty!";
$GLOBALS["l_global"]["we_make_same"]["text/html"] = "Po zapisie nowej strony";
$GLOBALS["l_global"]["we_make_same"]["text/webedition"] = $GLOBALS["l_global"]["we_make_same"]["text/html"];
$GLOBALS["l_global"]["we_make_same"]["objectFile"] = "New object after saving";
$GLOBALS["l_global"]["no_entries"] = "Brak wpisów!";
$GLOBALS["l_global"]["save_temporaryTable"] = "Zapisz ponownie tymczasowe dokumenty robocze";
$GLOBALS["l_global"]["save_mainTable"] = "Zapisz teraz g³ówn± tabelê bazy danych";
$GLOBALS["l_global"]["add_workspace"] = "Dodaj obszar roboczy";
$GLOBALS["l_global"]["folder_not_editable"] = "Nie mo¿na wybraæ tego katalogu!";
$GLOBALS["l_global"]["modules"] = "Modu³";
$GLOBALS["l_global"]["modules_and_tools"] = "Modules and Tools"; // TRANSLATE
$GLOBALS["l_global"]["center"] = "Centruj";
$GLOBALS["l_global"]["jswin"] = "Wyskakuj±ce okno";
$GLOBALS["l_global"]["open"] = "Otwórz";
$GLOBALS["l_global"]["posx"] = "Pozycja x";
$GLOBALS["l_global"]["posy"] = "Pozycja y";
$GLOBALS["l_global"]["status"] = "Status"; // TRANSLATE
$GLOBALS["l_global"]["scrollbars"] = "Scrollbars";
$GLOBALS["l_global"]["menubar"] = "Menubar";
$GLOBALS["l_global"]["toolbar"] = "Toolbar"; // TRANSLATE
$GLOBALS["l_global"]["resizable"] = "Resizable"; // TRANSLATE
$GLOBALS["l_global"]["location"] = "Location"; // TRANSLATE
$GLOBALS["l_global"]["title"] = "Tytu³";
$GLOBALS["l_global"]["description"] = "Opis";
$GLOBALS["l_global"]["required_field"] = "Pole obowi±zkowe";
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
$GLOBALS["l_global"]["save_templates_before"] = "Zapisz wcze¶niej szablony";
$GLOBALS["l_global"]["specify_docs"] = "Dokumenty o nastêpuj±cych kryteriach";
$GLOBALS["l_global"]["object_docs"] = "Wszystkie obiekty";
$GLOBALS["l_global"]["all_docs"] = "Wszystkie dokumenty";
$GLOBALS["l_global"]["ask_for_editor"] = "Zapytaj o oczekiwany edytor";
$GLOBALS["l_global"]["cockpit"] = "Cockpit"; // TRANSLATE
$GLOBALS["l_global"]["introduction"] = "Wprowadzenie";
$GLOBALS["l_global"]["doctypes"] = "Typy dokumentu";
$GLOBALS["l_global"]["content"] = "Zawarto¶æ";
$GLOBALS["l_global"]["site_not_exist"] = "Ta strona nie istnieje!";
$GLOBALS["l_global"]["site_not_published"] = "Ta strona nie jest jeszcze opublikowana!";
$GLOBALS["l_global"]["required"] = "Wpis obowi±zkowy";
$GLOBALS["l_global"]["all_rights_reserved"] = "Wszelkie prawa zastrze¿one";
$GLOBALS["l_global"]["width"] = "Szeroko¶æ";
$GLOBALS["l_global"]["height"] = "Wysoko¶æ";
$GLOBALS["l_global"]["new_username"] = "Nowa nazwa u¿ytkownika";
$GLOBALS["l_global"]["username"] = "Nazwa u¿ytkownika";
$GLOBALS["l_global"]["password"] = "Has³o";
$GLOBALS["l_global"]["documents"] = "Dokumenty";
$GLOBALS["l_global"]["templates"] = "Szablony";
$GLOBALS["l_global"]["objects"] = "Objects"; // TRANSLATE
$GLOBALS["l_global"]["licensed_to"] = "Licencjobiorcja";
$GLOBALS["l_global"]["left"] = "lewa";
$GLOBALS["l_global"]["right"] = "prawa";
$GLOBALS["l_global"]["top"] = "góra";
$GLOBALS["l_global"]["bottom"] = "dó³";
$GLOBALS["l_global"]["topleft"] = "góra lewa";
$GLOBALS["l_global"]["topright"] = "góra prawa";
$GLOBALS["l_global"]["bottomleft"] = "dó³ lewa";
$GLOBALS["l_global"]["bottomright"] = "dó³ prawa";
$GLOBALS["l_global"]["true"] = "tak";
$GLOBALS["l_global"]["false"] = "nie";
$GLOBALS["l_global"]["showall"] = "Poka¿ wszystko";
$GLOBALS["l_global"]["noborder"] = "bez marginesu";
$GLOBALS["l_global"]["border"] = "Margines";
$GLOBALS["l_global"]["align"] = "Wyrównanie";
$GLOBALS["l_global"]["hspace"] = "Odstêp poziomy";
$GLOBALS["l_global"]["vspace"] = "Odstêp pionowy";
$GLOBALS["l_global"]["exactfit"] = "dopasuj";
$GLOBALS["l_global"]["select_color"] = "Wybór koloru";
$GLOBALS["l_global"]["changeUsername"] = "Zmieñ nazwê u¿ytkownika";
$GLOBALS["l_global"]["changePass"] = "Zmieñ has³o";
$GLOBALS["l_global"]["oldPass"] = "Stare has³o";
$GLOBALS["l_global"]["newPass"] = "Nowe has³o";
$GLOBALS["l_global"]["newPass2"] = "Powtórzenie nowego has³a";
$GLOBALS["l_global"]["pass_not_confirmed"] = "Powtórzenie nowego has³a nie zgadza siê z nowym has³em!";
$GLOBALS["l_global"]["pass_not_match"] = "Stare has³o nie zgadza siê!";
$GLOBALS["l_global"]["passwd_not_match"] = "Has³o nie zgadza siê!";
$GLOBALS["l_global"]["pass_to_short"] = "Has³o musi siê sk³adaæ z przynajmniej 4 znaków!";
$GLOBALS["l_global"]["pass_changed"] = "Has³o zosta³o zmienione!";
$GLOBALS["l_global"]["pass_wrong_chars"] = "Has³o mo¿e zawieraæ tylko litery (a-z oraz A-Z) i cyfry (0-9)!";
$GLOBALS["l_global"]["username_wrong_chars"] = "Username may only contain alpha-numeric characters (a-z, A-Z and 0-9) and '.', '_' or '-'!"; // TRANSLATE
$GLOBALS["l_global"]["all"] = "Wszystkie";
$GLOBALS["l_global"]["selected"] = "Wybrane";
$GLOBALS["l_global"]["username_to_short"] = "Nazwa u¿ytkownika musi siê sk³adaæ przynajmniej z 4 znaków!";
$GLOBALS["l_global"]["username_changed"] = "Nazwa u¿ytkownika zosta³a zmieniona!";
$GLOBALS["l_global"]["published"] = "Opublikowany";
$GLOBALS["l_global"]["help_welcome"] = "Witamy w systemie pomocy webEdition";
$GLOBALS["l_global"]["edit_file"] = "Edytuj dane";
$GLOBALS["l_global"]["docs_saved"] = "Dokumenty zosta³y zabezpieczone!";
$GLOBALS["l_global"]["preview"] = "Podgl±d";
$GLOBALS["l_global"]["close"] = "Zamknij okno";
$GLOBALS["l_global"]["loginok"] =  "<strong>Logowanie powiod³o siê!</strong><br>webEdition powinien otworzyæ siê teraz w nowym oknie.<br>Je¿eli tak siê nie sta³o, prawdopodobnie zablokowa³e¶ okna wyskakuj±ce w swojej przegl±darce!";
$GLOBALS["l_global"]["apple"] = "&#x2318;";
$GLOBALS["l_global"]["shift"] = "SHIFT"; // TRANSLATE
$GLOBALS["l_global"]["ctrl"] = "STRG";
$GLOBALS["l_global"]["required_fields"] = "Pola obowi±zkowe";
$GLOBALS["l_global"]["no_file_uploaded"] = "<p class=\"defaultfont\">Nie za³adowano jeszcze ¿adnego dokumentu.</p>";
$GLOBALS["l_global"]["openCloseBox"] = "Otwórz-/Zamknij";
$GLOBALS["l_global"]["rebuild"] = "Rebuild"; // TRANSLATE
$GLOBALS["l_global"]["welcome_to_we"] = "Witamy w webEdition 3";
$GLOBALS["l_global"]["tofit"] = "Witamy w webEdition 3";
$GLOBALS["l_global"]["unlocking_document"] = "Zatwierd¼ dokument";
$GLOBALS["l_global"]["variant_field"] = "Pole wariantów";
$GLOBALS["l_global"]["redirect_to_login_failed"] = "Please press the following link, if you are not redirected within the next 30 seconds "; // TRANSLATE
$GLOBALS["l_global"]["redirect_to_login_name"] = "webEdition login"; // TRANSLATE
$GLOBALS["l_global"]["untitled"] = "Untitled"; // TRANSLATE
?>