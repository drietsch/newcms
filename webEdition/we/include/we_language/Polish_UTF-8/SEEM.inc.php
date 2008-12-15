<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_language
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Language file: SEEM.inc.php
 * Provides language strings.
 * Language: English
 */
$l_we_SEEM["ext_doc_selected"] = "You have selected a link which points to a document that is not administered by webEdition. Continue?"; // TRANSLATE
$l_we_SEEM["ext_document_on_other_server_selected"] = "Kliknięto na odnośnik, który wskazuje na dokument na innym serwerze WWW. Dokument zostanie otwarty w nowym oknie przeglądarki.\\nKontynuować?";
$l_we_SEEM["ext_form_target_other_server"] = "Chcesz wysłać formularz, który wskazuje na inny serwer WWW.\\nZostanie on otwarty w nowym oknie przeglądarki. Kontynuować??";
$l_we_SEEM["ext_form_target_we_server"] = "Formularz zostanie wysłany do dokumentu,\\nktóry nie jest zarządzany przez webEdition. Kontynuować?";

$l_we_SEEM["ext_doc"] = "Aktualna strona: <b>%s</b><u>nie </u> jest stroną do zarządzania za pomocą webEdition";
$l_we_SEEM["ext_doc_not_found"] = "Nie można znaleźć oczekiwanej strony <b>%s</b>.";
$l_we_SEEM["ext_doc_tmp"] = "Strona nie została prawidłowo otwarta przez webEdition. Zastosuj normalną nawigację WWW w celu dotarcia do oczekiwanej strony.";

$l_we_SEEM["info_ext_doc"] = "Odnośnik spoza webEdition";
$l_we_SEEM["info_doc_with_parameter"] = "Odnośnik z parametrem";
$l_we_SEEM["link_does_not_work"] = "Ten odnośnik został zdeaktywowany w trybie podglądu.\\nużyj menu głównego, żeby nawigować przez stronę";
$l_we_SEEM["info_link_does_not_work"] = "Deaktywowany.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Jesteś przy zmianie okna edycji webEdition. Okno zostanie przez to zamknięte.";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Tryb";
$l_we_SEEM["start_mode_normal"] = "Normalny";
$l_we_SEEM["start_mode_seem"] = "seeMode"; // TRANSLATE

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Nie ustalono dla Ciebie prawidłowego dokumentu początkowego.\\nTa opcja może być ustawiona przez Twojego administratora.\\nOtwiera się teraz dokument startowy serwera WWW.";
$l_we_SEEM["only_seem_mode_allowed"] = "Nie masz wystarczających uprawnień, żeby uruchomić webEdition w trybie normalnym.\\nZamiast tego uruchomi się tryb seeMode.";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Dokument początkowy<br>dla seeMode ";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Spróbuj ponownie.";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Nie masz wystarczających uprawnień do edycji tej strony.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "W tej chwili nie ustalono żadnego prawidłowego dokumentu początkowego dla Ciebie.\\nCzy chcesz teraz określić swój dokument początkowy w ustawieniach?.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Nie masz wystarczających uprawnień do edytowania tego dokumentu.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Czy chcesz z powrotem przełączyć do trybu podglądu?";

$l_we_SEEM["alert"]["changed_include"] = "Zmieniły się załączone dane. Okno główne zostanie ponownie zawarte.";
$l_we_SEEM["alert"]["close_include"] = "This file is no webEdition document. The include window is closed."; // TRANSLATE
?>