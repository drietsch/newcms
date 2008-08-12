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
$l_we_SEEM["ext_document_on_other_server_selected"] = "Vous avez cliquez sur un lien, qui m�ne � un document sur un autre web-serveur. Celui sera ouvert dans une nouvelle fen�tre.\\nPousuivre?";
$l_we_SEEM["ext_form_target_other_server"] = "Vous voulez envoyer un formulaire � un autre web-serveur.\\nCelui sera ouvert dans une nouvelle fen�tre. Poursuivre?";
$l_we_SEEM["ext_form_target_we_server"] = "Le formulaire est envoyer � un non webEdition document. Poursuivre?";

$l_we_SEEM["ext_doc"] = "La page: <b>%s</b> n'est <u>pas</u> pas editable avec webEdition";
$l_we_SEEM["ext_doc_not_found"] = "La page demand�e <b>%s</b> ne pouvait pas �tre trouv�e.";
$l_we_SEEM["ext_doc_tmp"] = "La page n'a pas �t� ouvert correctement par webEdition. S'il vous pla�t utiliser la navigation normale du site, pour aller au document voulu.";

$l_we_SEEM["info_ext_doc"] = "Non lien-webEdition";
$l_we_SEEM["info_doc_with_parameter"] = "Lien avec param�tres";
$l_we_SEEM["link_does_not_work"] = "Ce lien a �t� d�sactiv� dans le mode-de-Pr�vision.\\nS'il vous pla�t utilisez le menu principale, pour naviguer par le site.";
$l_we_SEEM["info_link_does_not_work"] = "Desactiv�.";

$l_we_SEEM["open_link_in_SEEM_edit_include"] = "Vous �tes en train de changer le contenu de la fen�tre-webEdtion. Cette fen�tre sera ferm�. Poursuivre?";

//  Used in we_info.inc.php
$l_we_SEEM["start_mode"] = "Mode"; // TRANSLATE
$l_we_SEEM["start_mode_normal"] = "Normal"; // TRANSLATE
$l_we_SEEM["start_mode_seem"] = "seeMode"; // TRANSLATE

//	When starting webedition in SEEMode
$l_we_SEEM["start_with_SEEM_no_startdocument"] = "Pour le moment aucune page d'accueil valide est d�fini.\\nCela peut �tre d�fini par votre administrateur eingestellt werden.\\nLa page d'accueil du web-serveur sera overt.";
$l_we_SEEM["only_seem_mode_allowed"] = "Vous ne disposez pas des droits n�cessaires, pour d�marrer webEdition le Mode normal.\\nEn remplacement le seeMode est d�marr�.";

//	Workspace - the SEEM startdocument
$l_we_SEEM["workspace_seem_startdocument"] = "Page d'accueil<br>pour le seeMode ";

//	Desired document is locked by another user
$l_we_SEEM["try_doc_again"] = "Essayer de nouveau.";

//	no permission to work with document
$l_we_SEEM["no_permission_to_work_with_document"] = "Vous ne disposez pas des droits n�cessaires pour �diter cette page.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["question_change_startdocument"] = "Pour le moment aucune page d'accueil valide est d�fini.\\nVous voulez d�finir une page d'accueil dans les pr�f�rences maintenant.";

//	started seem with no startdocument - can select startdocument.
$l_we_SEEM["no_permission_to_edit_document"] = "Vous ne disposez pas des droits n�cessairse, pour �diter ce document.";

$l_we_SEEM["confirm"]["change_to_preview"] = "Voulez-vous changer au Mode-de-Pr�vision?";

$l_we_SEEM["alert"]["changed_include"] = "Un fichier-inclu a �t� modifi�. La fen�tre principal sera actualis�e.";
$l_we_SEEM["alert"]["close_include"] = "This file is no webEdition document. The include window is closed."; // TRANSLATE
?>