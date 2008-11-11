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
 * Language: Deutsch
 */
$l_we_SEEM["ext_doc_selected"] = "Sie haben auf einen Link geklickt, der anscheinend auf kein von webEdition verwaltetes Dokument verweist.\\nFortfahren?";
$l_we_SEEM["ext_document_on_other_server_selected"] = "Sie haben auf einen Link geklickt, der auf ein Dokument auf einem anderen Web-Server verweist. Dieses wird in einem neuen Fenster ge�ffnet.\\nFortfahren?";
$l_we_SEEM["ext_form_target_other_server"] = "Sie wollen ein Formular abschicken, das auf einen anderen Web-Server verweist.\\nDieses wird in einem neuen Browser-Fenster ge�ffnet. Fortfahren??";
$l_we_SEEM["ext_form_target_we_server"] = "Das Formular wird an ein Dokument verschickt,\\ndas nicht von webEdition verwaltet wird. Fortfahren?";

$l_we_SEEM["ext_doc"] = "Die aktuelle Seite: <b>%s</b> ist <u>keine</u> von webEdition pflegbare Seite";
$l_we_SEEM["ext_doc_not_found"] = "Die gew�nschte Seite <b>%s</b> konnte nicht gefunden werden.";
$l_we_SEEM["ext_doc_tmp"] = "Diese Seite wurde nicht korrekt von webEdition ge�ffnet. Bitte verwenden Sie die normale Navigation der Website, um zu Ihrem gew�nschten Dokument zu gelangen.";

$l_we_SEEM["info_ext_doc"] = "Kein webEdition-Link";
$l_we_SEEM["info_doc_with_parameter"] = "Link mit Parameter";
$l_we_SEEM["link_does_not_work"] = "Dieser Link wurde innerhalb des Vorschau-Modus deaktiviert.\\nBitte benutzen sie das Hauptmen�, um sich durch die Seite zu navigieren.";
$l_we_SEEM["info_link_does_not_work"] = "Deaktiviert.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Sie sind dabei den Inhalt des webEdition-Fensters zu ver�ndern. Dabei wird dieses Fenster geschlossen.";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Modus";
$l_we_SEEM["start_mode_normal"] = "Normal";
$l_we_SEEM["start_mode_seem"] = "seeMode";

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Sie haben nicht die erforderlichen Rechte, das Cockpit zu �ffnen. Ihr Administrator kann Ihnen in den Einstellungen stattdessen ein Startdokument zuteilen.";
$l_we_SEEM["only_seem_mode_allowed"] = "Sie haben nicht die erforderlichen Rechte, um webEdition im normalen Modus zu starten.\\nStattdessen wird der seeMode gestartet.";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Startdokument<br>f�r seeMode ";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Nocheinmal versuchen.";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Sie haben nicht die erforderlichen Rechte diese Seite zu bearbeiten.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Sie haben nicht die erforderlichen Rechte, das Cockpit zu �ffnen. Wollen Sie jetzt in den Einstellungen ein Startdokument festlegen?";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Sie verf�gen nicht �ber die ben�tigten Rechte, um dieses Dokument zu berabeiten.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Wollen Sie wieder in den Vorschau-Modus wechseln?";

$l_we_SEEM["alert"]["changed_include"] = "Eine Include-Datei wurde ver�ndert. Das Hauptfenster wird neu geladen.";
$l_we_SEEM["alert"]["close_include"]   = "Die Datei ist keine webEdition-Datei. Das Include-Fenster wird geschlossen.";
?>