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
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "You have selected a link which points to a document that is not administered by webEdition. Continue?"; // TRANSLATE
$l_we_SEEM["ext_document_on_other_server_selected"] = "Klikni�to na odno�nik, kt�ry wskazuje na dokument na innym serwerze WWW. Dokument zostanie otwarty w nowym oknie przegl�darki.\\nKontynuowa�?";
$l_we_SEEM["ext_form_target_other_server"] = "Chcesz wys�a� formularz, kt�ry wskazuje na inny serwer WWW.\\nZostanie on otwarty w nowym oknie przegl�darki. Kontynuowa�??";
$l_we_SEEM["ext_form_target_we_server"] = "Formularz zostanie wys�any do dokumentu,\\nkt�ry nie jest zarz�dzany przez webEdition. Kontynuowa�?";

$l_we_SEEM["ext_doc"] = "Aktualna strona: <b>%s</b><u>nie </u> jest stron� do zarz�dzania za pomoc� webEdition";
$l_we_SEEM["ext_doc_not_found"] = "Nie mo�na znale�� oczekiwanej strony <b>%s</b>.";
$l_we_SEEM["ext_doc_tmp"] = "Strona nie zosta�a prawid�owo otwarta przez webEdition. Zastosuj normaln� nawigacj� WWW w celu dotarcia do oczekiwanej strony.";

$l_we_SEEM["info_ext_doc"] = "Odno�nik spoza webEdition";
$l_we_SEEM["info_doc_with_parameter"] = "Odno�nik z parametrem";
$l_we_SEEM["link_does_not_work"] = "Ten odno�nik zosta� zdeaktywowany w trybie podgl�du.\\nu�yj menu g��wnego, �eby nawigowa� przez stron�";
$l_we_SEEM["info_link_does_not_work"] = "Deaktywowany.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Jeste� przy zmianie okna edycji webEdition. Okno zostanie przez to zamkni�te.";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Tryb";
$l_we_SEEM["start_mode_normal"] = "Normalny";
$l_we_SEEM["start_mode_seem"] = "seeMode"; // TRANSLATE

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Nie ustalono dla Ciebie prawid�owego dokumentu pocz�tkowego.\\nTa opcja mo�e by� ustawiona przez Twojego administratora.\\nOtwiera si� teraz dokument startowy serwera WWW.";
$l_we_SEEM["only_seem_mode_allowed"] = "Nie masz wystarczaj�cych uprawnie�, �eby uruchomi� webEdition w trybie normalnym.\\nZamiast tego uruchomi si� tryb seeMode.";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Dokument pocz�tkowy<br>dla seeMode ";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Spr�buj ponownie.";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Nie masz wystarczaj�cych uprawnie� do edycji tej strony.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "W tej chwili nie ustalono �adnego prawid�owego dokumentu pocz�tkowego dla Ciebie.\\nCzy chcesz teraz okre�li� sw�j dokument pocz�tkowy w ustawieniach?.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Nie masz wystarczaj�cych uprawnie� do edytowania tego dokumentu.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Czy chcesz z powrotem prze��czy� do trybu podgl�du?";

$l_we_SEEM["alert"]["changed_include"] = "Zmieni�y si� za��czone dane. Okno g��wne zostanie ponownie zawarte.";
$l_we_SEEM["alert"]["close_include"] = "This file is no webEdition document. The include window is closed."; // TRANSLATE
?>